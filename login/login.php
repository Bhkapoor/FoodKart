<?php 
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

 require_once  __DIR__.'/../common/config.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $logemail=trim($_POST['logemail']);
    $logpassword=trim($_POST['logpassword']);
    
    
    if(!filter_var ($logemail,FILTER_VALIDATE_EMAIL)){
        echo "enter valid email";
        exit;
    }
    try{
    $stmt=$pdo->prepare("select * from users where email=?");
     $stmt->execute([$logemail]);

     $user=$stmt->fetch(PDO:: FETCH_ASSOC);

     if(!$user){
        echo "Email not registered";
        exit;
     }
    //  if(!password_verify ($logpassword ,$user['password'])){
    //     echo "wrong password";
    //     exit;
    
    //  }
       $_SESSION['user_id']=$user['id'];
     $_SESSION['user_email']=$user['email'];
     $_SESSION['role'] = $user['role'];
     $_SESSION['user_name'] = $user['name'];

      if($user['role'] === 'admin'){
        echo "admin";
        exit;
    }
          if($user['role'] === 'restaurant'){
        echo "restaurant";
        exit;
    }
     if($user['role'] === 'user'){
        echo "user";
        exit;
    }
     
     echo "Login Successfully";
  
    }
    catch(PDOException $e){
echo "something wrong";
    }
}
?>