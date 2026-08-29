<?php 
session_start();
require_once  __DIR__.'/../common/config.php';
$id=$_GET['id'];
$data=$pdo->prepare("delete from cart where id=?");
$data->execute([$id]);
header("Location: ../dashboard/cartview.php");
exit;
?>