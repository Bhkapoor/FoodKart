<?php
require_once __DIR__.'/../common/config.php';

if(isset($_GET['code'])){
   $token=$_GET['code'];
}
else{
    die("No token found");
}

$data = $pdo->prepare("SELECT * FROM ressetpassword WHERE token=?");
$data->execute([$token]);
$user = $data->fetch(PDO::FETCH_ASSOC);

if(!$user){
    die("Invalid token");
}

if(strtotime($user['expiry']) < time()){
    die("Reset link expired");
}

$email = $user['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $newpassword = trim($_POST['newpassword']);
    $confpassword = trim($_POST['confpassword']);

    if(empty($newpassword) || empty($confpassword)){
        echo "Fields cannot be empty";
        exit;
    }

    if($newpassword !== $confpassword){
        echo "Passwords do not match";
        exit;
    }

    if(strlen($newpassword) < 6){
        echo "Password must be at least 6 characters";
        exit;
    }

    $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);

    $update = $pdo->prepare("UPDATE users SET password=? WHERE email=?");
    $update->execute([$hashedPassword, $email]);

    $delete = $pdo->prepare("DELETE FROM ressetpassword WHERE token=?");
    $delete->execute([$token]);
         echo '
        <div class="alert alert-success">
            Password updated successfully.
        </div>

        <a href="/phpfolder/Restaurant/login/form.php" 
        class="btn btn-primary w-100">
            Go to Login
        </a>
        ';
       exit;


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
        <div class="row justify-content-center " id="container4">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center mb-4">Create new password</h3>

                <form id="userform4" method="post" >
                    <div class="mb-3">
                        <label class="form-label"><b>New Password</b></label>
                        <input  type="password" name="newpassword" class="form-control" placeholder="Enter new password here...">
                    </div>
                     <div class="mb-3">
                        <label class="form-label"><b>Confirm Password</b></label>
                        <input  type="password" name="confpassword" class="form-control" placeholder="Confirm your password">
                    </div>
                    <button  type="submit" class="btn btn-success w-100">Submit</button>
                </form>

                <div id="message3" class="mt-3 text-center"></div>
            </div>
        </div>
    </div>

</div>
<script src="../assets/js/jQuery.js"></script>
</body>
</html>