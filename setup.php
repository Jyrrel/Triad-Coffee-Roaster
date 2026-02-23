<?php
// Run once after importing schema.sql (then delete this file for security)
require_once __DIR__ . '/server/db.php';
require_once __DIR__ . '/server/config.php';

try {
  $pdo = db();

  $accounts = [
    ['Triad Owner', 'owner@triad.local', 'Owner123!', 'owner'],
    ['Triad Staff', 'staff@triad.local', 'Staff123!', 'staff'],
  ];

  foreach ($accounts as [$name,$email,$pass,$role]) {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name,email,password_hash,role,is_active) VALUES (?,?,?,?,1)
      ON DUPLICATE KEY UPDATE name=VALUES(name), password_hash=VALUES(password_hash), role=VALUES(role), is_active=1');
    $stmt->execute([$name, $email, $hash, $role]);
  }

  echo "✅ Sample accounts created/updated.\n";
  echo "Owner: owner@triad.local / Owner123!\n";
  echo "Staff: staff@triad.local / Staff123!\n";
  echo "\nIMPORTANT: Delete setup.php after running.\n";
} catch (Throwable $e) {
  http_response_code(500);
  echo "❌ Error: " . $e->getMessage();
}
?>