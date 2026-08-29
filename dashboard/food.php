<?php
 require_once  __DIR__.'/../common/config.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';
require __DIR__ . '/src/Exception.php';


    if($_SERVER['REQUEST_METHOD']=='POST'){
     $foodItem=trim($_POST['foodItem']);
     $price=trim($_POST['price']);
     $email=trim($_POST['email']);
     $images=$_FILES['img'];
     $uploadedImages=[];
     for($i=0; $i<count($images['name']);$i++){

     $imageName= $images['name'][$i];
     $tempName= $images['tmp_name'][$i];

      $folder="../assets/images/".$imageName;
    
        if(move_uploaded_file($tempName, $folder)){
        $uploadedImages[] = $imageName;
    }

     }
 

     $STATUS = 'pending';
    
     if($foodItem===''||$price===''||$email===''){
        echo "All fields are required";
        exit;
     }


$restaurant_id = $_SESSION['user_id'];
  $imageString = implode(",",$uploadedImages);

     $data=$pdo->prepare("insert into food (foodItem,price,image,email,STATUS,restaurant_id)
     values(?,?,?,?,?,?)");
     if($data->execute([
      $foodItem,
      $price,
     $imageString,
     $email,
      $STATUS,
      $restaurant_id
     ])){

    $restaurant_name=$_SESSION['user_name'];
     $admindata=$pdo->prepare("select id from users where role='admin'");
     $admindata->execute();
     $admin=$admindata->fetch(PDO::FETCH_ASSOC);
     $admin_id=$admin['id'];
     // notification insert
      $title = "New Food Added";

      $message = "$restaurant_name added a new food item";

      $type = "food_added";



      $notification = $pdo->prepare("
      INSERT INTO notifications
      (receiver_id, sender_id, title, message, type)
      VALUES
      (?, ?, ?, ?, ?)
      ");

      $notification->execute([

            $admin_id,
            $restaurant_id,
            $title,
            $message,
            $type

      ]);


          // Sent mail
        $mail = new PHPMailer(true);
        

        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bhartikapoor452@gmail.com';
            $mail->Password = 'dnew yxye bwhg rusf';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
           
            $mail->setFrom('yourgmail@gmail.com','My Website');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Welcome";
            $mail->Body = "Hello one food request is arrived name  $foodItem, check and approve if you like it ";
         
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
