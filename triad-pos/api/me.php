<?php
require_once __DIR__ . '/../server/auth.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user'])) {
  echo json_encode(['ok'=>false]);
  exit;
}

$u = $_SESSION['user'];
echo json_encode(['ok'=>true, 'user'=>[
  'id'=>$u['id'],
  'name'=>$u['name'],
  'email'=>$u['email'],
  'role'=>$u['role']
]]);
?>