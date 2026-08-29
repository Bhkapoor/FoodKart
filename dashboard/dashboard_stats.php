<?php
 require_once  __DIR__.'/../common/config.php';

$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
$stmt->execute(['restaurant']);
$total_restaurants = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
$stmt->execute(['user']);
$total_users = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM food WHERE STATUS = ?");
$stmt->execute(['pending']);
$pending_approvals = $stmt->fetchColumn();

?>