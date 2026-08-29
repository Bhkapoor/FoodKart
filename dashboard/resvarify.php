<?php 
require_once  __DIR__.'/../common/config.php';
if (isset($_GET['code'])) {
    $token = $_GET['code'];
    


    // Select user with the matching token
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    // if ($user) {
    //     $stmt = $pdo->prepare("UPDATE users SET is_verify = 1 WHERE id = ?");
    //     $stmt->execute([$user['id']]);

    //     header("Location: Restaurant/index.php");
    //     exit; // Always exit after a header redirect
    // }
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
      <!--  Restaurant REGISTER CARD -->
    <div class="row justify-content-center" id="container">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center mb-4"> Restaurant Register </h3>

                <form id="userform <?php echo $id ?>" action="resvarify.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name">
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
                <button id="btn1" class="btn btn-outline-secondary w-100">Login</button>
            </div>
        </div>
    </div>
</body>
</html>