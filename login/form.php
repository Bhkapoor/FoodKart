<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if(isset($_SESSION['user_id'])){

    if($_SESSION['role'] === 'admin'){
        header("Location: ../dashboard/admindash.php");
        exit;
    }

    if($_SESSION['role'] === 'restaurant'){
        header("Location: ../dashboard/resdash.php");
        exit;
    }

    if($_SESSION['role'] === 'user'){
        header("Location: ../dashboard/userdash.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- REGISTER CARD -->
    <div class="row justify-content-center" id="container">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center mb-4">Register</h3>

                <form id="userform" action="register.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phoneNumber" class="form-control" maxlength="10" placeholder="10 digit number">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confpassword" class="form-control">
                    </div>

                    <button class="btn btn-primary w-100">Register</button>
                </form>

                <div id="message" class="mt-3 text-center"></div>

                <p class="text-center mt-3">Already have an account?</p>
            <a href="login.php" class="btn btn-outline-secondary w-100">
    Login
</a>
            </div>
        </div>
    </div>




<!-- Forgot password -->
     <div class="row justify-content-center d-none" id="container3">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center mb-4">Forgot password?</h3>
                <p><b>Enter your registered email </b></p>

                <form id="userform3" >
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input  type="email" name="foremail" class="form-control">
                    </div>
                    <button  type="submit" class="btn btn-success w-100">Send Link</button>
                </form>

                <div id="message2" class="mt-3 text-center"></div>
            </div>
        </div>
    </div>

</div>


<!-- Toggle Script -->
<script>
$("#btn1").click(function(){
    $("#container").addClass("d-none");
    $("#container2").removeClass("d-none");
});

$("#btn2").click(function(){
    $("#container2").addClass("d-none");
    $("#container").removeClass("d-none");
});

$(document).ready(function () {

    $("#btnF").click(function () {
        $("#container2").addClass("d-none");
        $("#container3").removeClass("d-none");
    });

});


</script>
<script src="../assets/js/jQuery.js"></script>
</body>
</html>