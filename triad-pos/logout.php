<?php
require __DIR__ . '/server/auth.php';
logout();
header('Location: login.php');
exit;
?>
