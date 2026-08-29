<?php
require_once __DIR__.'/../common/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './src/PHPMailer.php';
require './src/SMTP.php';
require './src/Exception.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $foremail=trim($_POST['foremail']);
    $token=bin2hex(random_bytes(50));
    $expiry=date("Y-m-d H:i:s",strtotime("+10 minutes"));

    try {
        $data = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $data->execute([$foremail]);
        $user = $data->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Email not registered";
            exit; 
        }

        $stmt = $pdo->prepare("INSERT INTO ressetpassword (email, token, expiry) VALUES (?, ?, ?)");
        $stmt->execute([$foremail, $token, $expiry]);

    } catch (PDOException $e) {
        echo "Database error: Something went wrong.";
        exit; 
    }

    // Send Mail Block
    $mail = new PHPMailer(true);
    $verifyemail = "http://localhost/phpfolder/Restaurant/login/varifypass.php?code=" . urlencode($token);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bhartikapoor452@gmail.com';
        $mail->Password = 'dnew yxye bwhg rusf'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;

        $mail->setFrom('bhartikapoor452@gmail.com', 'My Website');
        $mail->addAddress($foremail);

        $mail->isHTML(true);
        $mail->Subject = "Reset Your Password";
        $mail->Body = "Hello, your reset password request has been accepted. <br><br>
                       Please click the link below to enter a new password:<br>
                       <a href='$verifyemail'>Click here to verify</a>";

        $mail->send();
        echo "Reset link has been sent to your email successfully.";

    } catch (Exception $e) {
        echo "Token generated, but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid Request Method";
}
?>