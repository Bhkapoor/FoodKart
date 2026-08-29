<?php
session_start();
require_once  __DIR__.'/../common/config.php';
require '../vendor/autoload.php';

if(!isset($_SESSION['user_id'])){
    echo "Not logged in";
        exit;
}
$user_id=$_SESSION['user_id'];
$food_id= $_POST['food_id'] ?? '';
if(!$food_id){
    echo "Food not found";
    exit;
}
$address=$_POST["address"];
$phone=$_POST["phone"];
$quantity=$_POST["quantity"];
$paymentMethod=$_POST["payment_method"];
$razorpay_payment_id = $_POST['razorpay_payment_id'] ?? null;
$razorpay_order_id   = $_POST['razorpay_order_id'] ?? null;
if($quantity < 1){
    echo "Invalid quantity";
    exit;
}
$stmt=$pdo->prepare("SELECT * FROM food where id=?");
$stmt->execute([$food_id]);
$food=$stmt->fetch(PDO::FETCH_ASSOC);

$total=$food['price']*$quantity;

$data=$pdo->prepare("INSERT INTO orders(user_id,address,phone,payment_method,total,razorpay_payment_id,razorpay_order_id,payment_status) VALUES(?,?,?,?,?,?,?,?)");
$data->execute([$user_id,$address,$phone,$paymentMethod,$total,$razorpay_payment_id,$razorpay_order_id,  'paid']);
$order_id=$pdo->lastInsertId();
$data2=$pdo->prepare("INSERT INTO order_items(order_id,food_id,quantity,price)VALUES(?,?,?,?)");
$data2->execute([$order_id,$food_id,$quantity,$food['price']*$quantity]);
 echo "Your order placed";
?>