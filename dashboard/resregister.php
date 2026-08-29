<?php
 require_once  __DIR__.'/../common/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';
require __DIR__ . '/src/Exception.php';

    if($_SERVER['REQUEST_METHOD']=='POST'){
     $name=trim($_POST['name']);
     $email=trim($_POST['email']);
    //  $token=bin2hex(random_bytes(50));
     $password=trim($_POST['password']);
      $hashedPassword=PASSWORD_HASH('$password', PASSWORD_DEFAULT);
     $role='user';
     if($name===''||$email===''){
        echo "All fields are required";
        exit;
     }
    
     $data=$pdo->prepare("insert into users (name,email,password,role)
     values(?,?,?,?)");
     if($data->execute([
      $name,
      $email,
      $hashedPassword,
      'restaurant'
     ])){
          // Sent mail
        $mail = new PHPMailer(true);
        // $varifyemail= "http://localhost/php-folder/Restaurant/dashboard/resvarify.php?code=$token";

        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bhartikapoor452@gmail.com';
            $mail->Password = 'dnew yxye bwhg rusf';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
           
            $mail->setFrom('yourgmail@gmail.com','My Website');
            $mail->addAddress($email,$name);

            $mail->isHTML(true);
            $mail->Subject = "Welcome";
            $mail->Body="Hello your email $email and password $password you can login now";
            // $mail->Body = "Hello $name,$email,$password you account is created successfully .Please click the link below to verify your email address:\n\n <a href='$varifyemail'>Click here to varify</a>";
         
            $mail->send();

            echo "Register Successfully";

        }catch(Exception $e){
            echo "Registered but email failed";
        }
     }
    else{
      echo "insert failed";
    }
    }
?>
