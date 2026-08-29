<?php
session_start();
 require_once  __DIR__.'/../common/config.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';
require __DIR__ . '/src/Exception.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? '';
$STATUS = $_GET['STATUS'] ?? '';

if (!$id || !$STATUS) {
    exit("Invalid request");
}

$stmt = $pdo->prepare("
    UPDATE food
    SET STATUS = ?
    WHERE id = ?
");

$result = $stmt->execute([$STATUS, $id]);

if($result){
 /* get restaurant details + food name */
    $foodStmt = $pdo->prepare("
        SELECT food.foodItem, users.name, users.email
        FROM food
        JOIN users ON food.restaurant_id = users.id
        WHERE food.id = ?
    ");

    $foodStmt->execute([$id]);

    $foodData = $foodStmt->fetch(PDO::FETCH_ASSOC);
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username   = 'bhartikapoor452@gmail.com';
        $mail->Password   = 'dnew yxye bwhg rusf';

          $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('bhartikapoor452@gmail.com', 'My website');

        $mail->addAddress(
            $foodData['email']
        );

        $mail->isHTML(true);

        /* approve mail */
        if ($STATUS === "approve") {

            $mail->Subject = "Food Approved";

            $mail->Body = "
                <h3>Hello {$foodData['name']},</h3>
                <p>Your food 
                <strong>{$foodData['foodItem']}</strong> 
                has been approved by admin.</p>

                <p>It is now visible to users.</p>
            ";

        } 
        /* reject mail */
        elseif ($STATUS === "reject") {

            $mail->Subject = "Food Rejected";

            $mail->Body = "
                <h3>Hello {$foodData['name']},</h3>
                <p>Your food 
                <strong>{$foodData['foodItem']}</strong> 
                has been rejected by admin.</p>
            ";
        }

        $mail->send();

    } catch (Exception $e) {
        echo "Mail Error: " . $mail->ErrorInfo;
        exit;
    }

    /* redirect back */
    header("Location: admindash.php");
    exit;

} else {

    print_r($stmt->errorInfo());
}

?>

