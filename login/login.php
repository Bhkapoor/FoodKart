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
    <!-- LOGIN CARD -->
    <div class="row justify-content-center " id="container2">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center mb-4">Login</h3>

                <form id="userform2" >
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input  type="email" name="logemail" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="logpassword" class="form-control">
                    </div>

                    <button class="btn btn-success w-100">Login</button>
                </form>

                <div id="message1" class="mt-3 text-center"></div>

               <a href="#" id="btnF">Forgot Password?</a>
           <p class="text-center mt-3">
    Don't have an account?
</p>

<a href="register.php" class="btn btn-outline-secondary w-100">
    Register
</a>
            </div>
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