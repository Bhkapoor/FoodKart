<?php 
session_start();
require_once  __DIR__.'/../common/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
  header("Location: ../login.php");
    exit;
}
$stmt = $pdo->prepare("
    SELECT food.*, users.name AS restaurant_name
    FROM food
    JOIN users ON food.restaurant_id = users.id
    WHERE food.STATUS = 'approve'
");

$stmt->execute();

$foods= $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
            <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
      <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/css/dashboard.css">

</head>
<body>
    <div class="d-flex">

<!-- SIDEBAR -->

<div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-info vh-100">
<h4 class="text-center mb-4">User</h4>

<ul class="nav nav-pills flex-column gap-2">

    <li>
        <a href="#" class="nav-link active text-white">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
    </li>

    <!-- <li>
        <a href="#" class="nav-link text-white">
            <i class="bi bi-people me-2"></i> Users
        </a>
    </li>

    <li>
        <a href="#" class="nav-link text-white">
            <i class="bi bi-fork-knife"></i>Approved foods
        </a>
    </li>

    <li>
        <a href="#" class="nav-link text-white">
            <i class="bi bi-gear me-2"></i> Settings
        </a>
    </li> -->

</ul>

<hr>

<a href="../login/logout.php" class="btn btn-danger mt-auto">
    <i class="bi bi-box-arrow-right me-1"></i> Logout
</a>

</div>

<!-- MAIN CONTENT -->

<div class="p-4 w-100">
<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Dashboard</h3>
    <h4 class="text-muted"> <a href="myOrders.php?id=" class="btn btn-success">My orders</a>  <a href="wishlist.php?id=" class="tooltip-wrapper" data-tooltip="Wishlist"><i class="bi bi-heart"></i></a> <a href="cartview.php?id=" class="tooltip-wrapper" data-tooltip="View Cart"><i class="bi bi-cart"></i></a> Welcome, <?php echo $_SESSION['user_name'];?></h4>
</div>

<!-- STATS -->
<div class="container mt-5">

    <h2 class="fw-bold mb-4">Food Menu</h2>

    <div class="row">

        <?php foreach($foods as $food): ?>
            <?php 
         $images = explode(",", $food['image']);
           ?>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">

                <div class="card-body">
                    
                        <h4 class="fw-bold">
                      <img src="../assets/images/<?php echo $images[0]; ?>" class="card-img-top"style="height:270px; object-fit:cover; cursor:pointer;"data-bs-toggle="modal"
data-bs-target="#foodModal<?php echo $food['id']; ?>"
>
                    </h4>
                    <div class="modal fade" id="foodModal<?php echo $food['id']; ?>" tabindex="-1">
    
    <div class="modal-dialog modal-dialog-centered modal-lg">
        
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <?php echo $food['foodItem']; ?>
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div id="carousel<?php echo $food['id']; ?>" class="carousel slide">

                    <div class="carousel-inner">

                        <?php foreach($images as $index => $img): ?>

                            <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">

                                <img 
                                src="../assets/images/<?php echo $img; ?>" 
                                class="d-block w-100"
                                style="height:500px; object-fit:cover;"
                                >

                            </div>

                        <?php endforeach; ?>

                    </div>

                    <!-- Prev Button -->
                    <button class="carousel-control-prev" 
                    type="button" 
                    data-bs-target="#carousel<?php echo $food['id']; ?>" 
                    data-bs-slide="prev">

                        <span class="carousel-control-prev-icon"></span>

                    </button>

                    <!-- Next Button -->
                    <button class="carousel-control-next" 
                    type="button" 
                    data-bs-target="#carousel<?php echo $food['id']; ?>" 
                    data-bs-slide="next">

                        <span class="carousel-control-next-icon"></span>

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>
                    
                    <h4 class="fw-bold">
                        <?php echo $food['foodItem']; ?>
                    </h4>

                    <p>
                        <strong>Restaurant:</strong>
                        <?php echo $food['restaurant_name']; ?>
                    </p>

                    <p>
                        <strong>Price:</strong>
                        ₹<?php echo $food['price']; ?>
                    </p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                       <p>
                        <a href="cart.php?id=<?php echo $food['id']; ?>" 
   class="btn btn-outline-warning add-to-cart-btn">
   Add to cart
 </a>
                    </p>
                        <p>
                        <a href="order.php?id=<?php echo $food['id']; ?>" class="btn btn-warning">Buy Now</a>
                    </p>
                         <p>
                        <a href="wish.php?id=<?php echo $food['id']; ?>" 
   class="btn btn-outline-warning add-to-wishlist-btn">&#9825;</a>
                    </p>
                    </div>
                </div>

            </div>
        </div>

        <?php endforeach; ?>

    </div>

</div>

</div>
<script src="../assets/js/jQuery.js"></script>
</body>
</html>