<?php
session_start(); 
if(isset($_SESSION['user_id'])){
    if($_SESSION['role']=='admin'){
     header("Location: /phpfolder/Restaurant/dashboard/admindash.php");
   exit;
    }
    elseif($_SESSION['role']=='restaurant'){
          header("Location: /phpfolder/Restaurant/dashboard/resdash.php");
   exit;
    }
    else{
        header("Location:/phpfolder/Restaurant/dashboard/userdash.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <!DOCTYPE html>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Restaurant</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

        <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .carousel-item img {
            height: 80vh;
            object-fit: cover;
        }
        </style>

    </head>

    <body>

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
            <div class="container">

                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQV9QHWDr02TbzDkCbbr641ABpQCUbZiuu0PA&s"
                        width="40" class="rounded-circle me-2">
                    <strong>FoodKart</strong>
                </a>

                <!-- Toggle -->
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav ms-auto align-items-center">

                        <li class="nav-item">
                            <a class="nav-link active" href="#">Home</a>
                        </li>

                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li> -->

                        <li class="nav-item ms-3">
                            <a href="login/login.php" class="btn btn-outline-primary">Login</a>
                        </li>

                        <li class="nav-item ms-2">
                            <a href="login/form.php" class="btn btn-primary">Register</a>
                        </li>

                    </ul>
                </div>

            </div>
        </nav>

        <!-- CAROUSEL -->

        <div id="demo" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <div class="carousel-inner">


                <div class="carousel-item active">
                    <img src="https://lecoucou.com/wp-content/uploads/2026/04/Le_Coucou_Hero_Image_Desktop-1.jpg"
                        class="d-block w-100">
                    <div class="carousel-caption text-start">
                        <h1>Welcome to Our Platform</h1>
                        <p>It is a cherished part of Happy Meal, offering a unique choice of books by Cressida Cowell with every Happy Meal. </p>
                        <a href="#" class="btn btn-primary">Get Started</a>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="https://t3.ftcdn.net/jpg/07/22/10/16/360_F_722101646_Hihl0HarADbpyjzG25yobsey7AgMH2DP.jpg"
                        class="d-block w-100">
                    <div class="carousel-caption">
                        <h2>Welcome</h2>
                        <p> All orders are delivered quickly and efficiently, allowing you the peace of mind to know that smiles-inducing food is never too far.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="https://media.istockphoto.com/id/1829241109/photo/enjoying-a-brunch-together.jpg?s=612x612&w=0&k=20&c=9awLLRMBLeiYsrXrkgzkoscVU_3RoVwl_HA-OT-srjQ="
                        class="d-block w-100">
                    <div class="carousel-caption text-end">
                        <h2>Fast & Reliable</h2>
                        <p>Happy Meal Readers is part of our commitment in bringing to life Truly Together moments by encouraging reading as a fun family activity.</p>
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" data-bs-target="#demo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" data-bs-target="#demo" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

        </div>

        <!-- FEATURES SECTION -->

        <section class="py-5">
            <div class="container text-center">
                <h2 class="mb-4">Our Features</h2>

                <div class="row">

                    <div class="col-md-4">
                        <div class="p-4 shadow-sm rounded">
                            <h4>Easy to Use</h4>
                            <p>User-friendly interface for everyone.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 shadow-sm rounded">
                            <h4>Happy Meal Readers</h4>
                            <p>Happy Meal, offering a unique choice of books by Cressida Cowell with every Happy Meal. .</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 shadow-sm rounded">
                            <h4>Delivery</h4>
                            <p> All orders are delivered quickly and efficiently, allowing you the peace of mind to know that smiles-inducing food is never too far.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- FOOTER -->

        <footer class="bg-dark text-white text-center py-3">
            <p class="mb-0">© 2026 MyRestaurant. All rights reserved.</p>
        </footer>

    </body>
    </html>
</body>
</html>