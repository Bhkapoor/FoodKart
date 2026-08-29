<?php 
session_start();
require_once  __DIR__.'/../common/config.php';

$id=$_SESSION['user_id'];
$stmt=$pdo->prepare("select cart.*,cart.id AS cart_id,food.*,users.name AS restaurant_name 
from cart 
join food ON cart.food_id=food.id 
join users ON food.restaurant_id=users.id 
where cart.user_id=?
");
$stmt->execute([$id]);
$foods=$stmt->fetchAll(PDO::FETCH_ASSOC);
$total=0;
foreach($foods as $food){
    $total+=$food['price']*$food['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart page</title>
            <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<!-- TOPBAR -->
<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <h3>
            <i class="bi bi-cart"></i> Cart Items
        </h3>

        <span>
            Welcome, <?php echo $_SESSION['user_name']; ?>
        </span>
    </div>
</div>

<!-- MAIN CONTENT -->

<div class="container mt-5">

    <h2 class="fw-bold mb-4">Item</h2>

    <div class="row">

        <?php foreach($foods as $food): ?>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">

                <div class="card-body">
                    
                        <h4 class="fw-bold">
                        <img src="../assets/images/<?php echo $food['image']; ?>"  class="card-img-top" alt="" style="height:270px">
                    </h4>
                    
                    <h4 class="fw-bold">
                        <?php echo $food['foodItem']; ?>
                    </h4>

                    <p>
                        <strong>Restaurant:</strong>
                        <?php echo $food['restaurant_name']; ?>
                    </p>

                    <p>
                        <strong>Price:</strong>
                        ₹<?php echo $food['price']*$food['quantity']; ?>
                    </p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                       <p>
                        <a href="order.php?id=<?php echo $food['id']; ?>&quantity=<?php echo $food['quantity']; ?>" class="btn btn-warning">Buy Now</a>
                    </p>
                         <p>
                        <a href="removecart.php?id=<?php echo $food['cart_id'] ?>" class="btn btn-outline-danger">Remove from cart</a>
                    </p>
                         <p>
                    <a href="cart.php?id=<?php echo $food['id']; ?>&action=remove"><button class="btn btn-light">-</button></a>
                    <button><?php echo $food['quantity']?> </button>
                    <a href="cart.php?id=<?php echo $food['id']; ?>&action=add"><button class="btn btn-light">+</button></a>
                    </p>
                    </div>
                </div>

            </div>
        </div>

        <?php endforeach; ?>

    </div>

</div>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Order Summary</h5>
        <hr>
        <p class="justify-content-between">
            <span>Total Items Price:</span>
            <strong>₹<?php echo $total; ?></strong>
        </p>
<form action="order.php" method="POST">
    <input type="hidden" name="cart_order" value="1">

    <button class="btn btn-primary w-100">
        Place all orders
    </button>
</form>
    </div>
</div>
</body>
</html>