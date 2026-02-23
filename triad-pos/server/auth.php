<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_name(SESSION_NAME);
  session_start();
}

function require_login(): void {
  if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
  }
}

function require_role(string $role): void {
  if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== $role) {
    // send them back to their own page if logged in, else login
    if (isset($_SESSION['user'])) {
      $r = $_SESSION['user']['role'] ?? 'staff';
      header('Location: ' . ($r === 'owner' ? 'owner.php' : 'staff.php'));
      exit;
    }
    header('Location: login.php');
    exit;
  }
}

function logout(): void {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
  }
  session_destroy();
}

function find_user_by_email(string $email): ?array {
  $stmt = db()->prepare('SELECT id, name, email, password_hash, role, is_active FROM users WHERE email = ? LIMIT 1');
  $stmt->execute([$email]);
  $u = $stmt->fetch();
  return $u ?: null;
}
?>