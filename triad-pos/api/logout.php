<?php
require_once __DIR__ . '/../server/auth.php';
logout();
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['ok'=>true]);
?>