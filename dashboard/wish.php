<?php 
session_start();
require_once  __DIR__.'/../common/config.php';

$id=$_SESSION['user_id'];
$food_id=$_GET['id']??'';
if($food_id==''){
    echo "invalid";
    exit;
}
$check=$pdo->prepare("select * from wish where user_id=? AND food_id=?");
$check->execute([$id,$food_id]);

$result=$check->fetch(PDO::FETCH_ASSOC);


$stmt=$pdo->prepare("INSERT INTO wish(user_id,food_id) 
VALUES(?,?)");
$stmt->execute([$id,$food_id]);

header("Location: ../dashboard/userdash.php");
exit;

?>