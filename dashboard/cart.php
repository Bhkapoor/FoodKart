<?php 
session_start();
require_once  __DIR__.'/../common/config.php';

$id=$_SESSION['user_id'];
$food_id=$_GET['id']??'';
$action=$_GET['action']??'add';
if($food_id==''){
    echo "invalid";
    exit;
}
$check=$pdo->prepare("select * from cart where user_id=? AND food_id=?");
$check->execute([$id,$food_id]);

$result=$check->fetch(PDO::FETCH_ASSOC);
if($result){
    if($action=='add'){
$stmt=$pdo->prepare("UPDATE cart SET quantity=quantity+1 WHERE user_id=? AND food_id=?");
$stmt->execute([$id,$food_id]);
header("Location: ../dashboard/cartview.php");
exit;
}
elseif($action=='remove'){
$stmt=$pdo->prepare("UPDATE cart SET quantity=case
when quantity>1 THEN quantity-1 
ELSE 1
END 
 WHERE user_id=? AND food_id=?");
$stmt->execute([$id,$food_id]);
header("Location: ../dashboard/cartview.php");
exit;
}
}
else{
    $stmt=$pdo->prepare("INSERT INTO cart(user_id,food_id,quantity) 
VALUES(?,?,1)");
$stmt->execute([$id,$food_id]);
}
header("Location: ../dashboard/userdash.php");
exit;

?>
