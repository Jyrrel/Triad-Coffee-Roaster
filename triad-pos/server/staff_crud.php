<?php
require_once __DIR__ . '/db.php';

/**
 * Staff CRUD helpers (owner only)
 */

function list_staff(string $q = '', string $status = 'all'): array {
  $q = trim($q);
  $status = in_array($status, ['all','active','disabled'], true) ? $status : 'all';

  $sql = "SELECT id, name, email, role, is_active, created_at, updated_at
          FROM users
          WHERE role='staff'";
  $params = [];

  if ($status === 'active') { $sql .= " AND is_active=1"; }
  if ($status === 'disabled') { $sql .= " AND is_active=0"; }

  if ($q !== '') {
    $sql .= " AND (name LIKE ? OR email LIKE ?)";
    $like = '%' . $q . '%';
    $params[] = $like;
    $params[] = $like;
  }

  $sql .= " ORDER BY is_active DESC, created_at DESC";
  $stmt = db()->prepare($sql);
  $stmt->execute($params);
  return $stmt->fetchAll();
}

function create_staff(string $name, string $email, string $password): array {
  $name = trim($name);
  $email = strtolower(trim($email));
  if ($name === '' || $email === '' || $password === '') {
    return ['ok'=>false,'message'=>'Name, email, and password are required.'];
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return ['ok'=>false,'message'=>'Invalid email format.'];
  }
  if (strlen($password) < 6) {
    return ['ok'=>false,'message'=>'Password must be at least 6 characters.'];
  }

  $hash = password_hash($password, PASSWORD_DEFAULT);
  $stmt = db()->prepare("INSERT INTO users (name,email,password_hash,role,is_active) VALUES (?,?,?,'staff',1)");
  try {
    $stmt->execute([$name,$email,$hash]);
    return ['ok'=>true,'message'=>'Staff account created.'];
  } catch (Throwable $e) {
    if (str_contains($e->getMessage(), 'Duplicate')) {
      return ['ok'=>false,'message'=>'Email already exists.'];
    }
    return ['ok'=>false,'message'=>'Error: '.$e->getMessage()];
  }
}

function update_staff(int $id, string $name, string $email, ?string $password = null): array {
  $name = trim($name);
  $email = strtolower(trim($email));
  if ($id <= 0 || $name === '' || $email === '') {
    return ['ok'=>false,'message'=>'ID, name, and email are required.'];
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return ['ok'=>false,'message'=>'Invalid email format.'];
  }

  $pdo = db();
  $pdo->beginTransaction();
  try {
    // prevent editing non-staff
    $chk = $pdo->prepare("SELECT id FROM users WHERE id=? AND role='staff' LIMIT 1");
    $chk->execute([$id]);
    if (!$chk->fetch()) {
      $pdo->rollBack();
      return ['ok'=>false,'message'=>'Staff account not found.'];
    }

    if ($password !== null && trim($password) !== '') {
      if (strlen($password) < 6) {
        $pdo->rollBack();
        return ['ok'=>false,'message'=>'Password must be at least 6 characters.'];
      }
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, password_hash=? WHERE id=?");
      $stmt->execute([$name,$email,$hash,$id]);
    } else {
      $stmt = $pdo->prepare("UPDATE users SET name=?, email=? WHERE id=?");
      $stmt->execute([$name,$email,$id]);
    }

    $pdo->commit();
    return ['ok'=>true,'message'=>'Staff account updated.'];
  } catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    if (str_contains($e->getMessage(), 'Duplicate')) {
      return ['ok'=>false,'message'=>'Email already exists.'];
    }
    return ['ok'=>false,'message'=>'Error: '.$e->getMessage()];
  }
}

function set_staff_active(int $id, int $active): array {
  $active = $active ? 1 : 0;
  if ($id <= 0) return ['ok'=>false,'message'=>'Invalid staff id.'];

  $stmt = db()->prepare("UPDATE users SET is_active=? WHERE id=? AND role='staff'");
  $stmt->execute([$active,$id]);
  if ($stmt->rowCount() === 0) {
    return ['ok'=>false,'message'=>'Staff account not found.'];
  }
  return ['ok'=>true,'message'=> $active ? 'Staff enabled.' : 'Staff disabled.'];
}
?>