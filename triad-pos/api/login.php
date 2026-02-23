<?php
require_once __DIR__ . '/../server/auth.php';

header('Content-Type: application/json; charset=utf-8');

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

$email = strtolower(trim($data['email'] ?? ''));
$password = (string)($data['password'] ?? '');
$role = strtolower(trim($data['role'] ?? ''));

if (!$email || !$password || !in_array($role, ['staff','owner'], true)) {
  echo json_encode(['ok'=>false,'message'=>'Missing email/password/role.']);
  exit;
}

$user = find_user_by_email($email);
if (!$user) {
  echo json_encode(['ok'=>false,'message'=>'Account not found.']);
  exit;
}

if ($user['role'] !== $role) {
  echo json_encode(['ok'=>false,'message'=>'Role mismatch. Please select the correct role.']);
  exit;
}

if (!(int)($user['is_active'] ?? 1)) {
  echo json_encode(['ok'=>false,'message'=>'Account is disabled. Please contact the owner.']);
  exit;
}

if (!password_verify($password, $user['password_hash'])) {
  echo json_encode(['ok'=>false,'message'=>'Incorrect password.']);
  exit;
}

$_SESSION['user'] = [
  'id' => (int)$user['id'],
  'name' => $user['name'],
  'email' => $user['email'],
  'role' => $user['role'],
];

$redirect = ($user['role'] === 'owner') ? '/triad-pos/owner.php' : '/triad-pos/staff.php';
echo json_encode(['ok'=>true,'redirect'=>$redirect]);
?>