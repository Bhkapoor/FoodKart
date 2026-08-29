<?php 
session_start();
require_once  __DIR__.'/../common/config.php';

$id=$_SESSION['user_id'];
$stmt=$pdo->prepare("select wish.*,food.*,users.name AS restaurant_name 
from wish 
join food ON wish.food_id=food.id 
join users ON food.restaurant_id=users.id 
where wish.user_id=?
");
$stmt->execute([$id]);
$foods=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <h3>
            <i class="bi bi-heart-fill"></i> Wishlist
        </h3>

        <span>
            Welcome, <?php echo $_SESSION['user_name']; ?>
        </span>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="wishlist-title">Wishlist Items</h2>
    </div>

    <div class="row g-4">

        <?php foreach($foods as $food): ?>

        <div class="col-lg-4 col-md-6">
            <div class="card wishlist-card h-100 shadow-sm">

                <!-- IMAGE -->
                <img src="../assets/images/<?php echo $food['image']; ?>"  
                     class="card-img-top wishlist-img" 
                     alt="Food Image">

                <!-- CARD BODY -->
                <div class="card-body d-flex flex-column">

                    <h4 class="food-title">
                        <?php echo $food['foodItem']; ?>
                    </h4>

                    <p class="restaurant-text mb-2">
                        <i class="bi bi-shop"></i>
                        <?php echo $food['restaurant_name']; ?>
                    </p>

                    <p class="price mb-4">
                        ₹<?php echo $food['price']; ?>
                    </p>

                    <div class="mt-auto">
                        <a href="cart.php?id=<?php echo $food['id']; ?>" 
                           class="btn btn-warning w-100 add-to-cart-btn">
                           <i class="bi bi-cart-plus"></i>
                           Add to cart
                        </a>
                    </div>

                </div>

            </div>
        </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>