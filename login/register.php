<?php
 require_once  __DIR__.'/../common/config.php';
    if($_SERVER['REQUEST_METHOD']=='POST'){
     $name=trim($_POST['name']);
     $email=trim($_POST['email']);
     $phoneNumber=trim($_POST['phoneNumber']);
     $password=trim($_POST['password']);
     $confpassword=trim($_POST['confpassword']);
     $hashPassword=PASSWORD_HASH($password, PASSWORD_DEFAULT);
     if($name===''||$email===''||$phoneNumber===''||$password===''){
        echo "All fields are required";
        exit;
     }
     if($password!=$confpassword){
        echo "Password not matched";
        exit;
     }
      
    try{
     $stmt=$pdo->prepare("insert into users (name,email,phoneNumber,password)
     values(?,?,?,?)");
     $stmt->execute([
      $name,
      $email,
      $phoneNumber,
      $hashPassword
     ]);
     echo "Register Successfully";
    }
 catch(PDOException $e){
 echo "something wrong";
    }
    }
?>
