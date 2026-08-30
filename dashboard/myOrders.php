<?php
session_start();
require_once __DIR__.'/../common/config.php';

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT orders.*, food.foodItem, food.image, order_items.quantity
    FROM orders
    JOIN order_items ON orders.order_id = order_items.order_id
    JOIN food ON order_items.food_id = food.id
    WHERE orders.user_id = ?
    ORDER BY orders.created_at DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body class="bg-light">

<!-- TOPBAR -->
<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <h3>
            <i class="bi bi-box"></i> ORDERS
        </h3>

        <span>
            Welcome, <?php echo $_SESSION['user_name']; ?>
        </span>
    </div>
</div>

    <div class="container py-5">
        <h2 class="fw-bold mb-4">My Orders</h2>

        <?php if(empty($orders)): ?>
        <div class="alert alert-info">NO ORDERS YET!</div>
        <?php endif; ?>

        <?php foreach($orders as $order): ?>
                <?php
    $images = explode(",", $order['image']);
    ?>
            <div class="card shadow border-0 mb-4 p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fw-bold">Order #<?php echo $order['order_id']; ?></span>
            <span class="text-muted"><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></span>
        </div>

        <hr>
            <div class="d-flex align-items-center gap-3">
                <img src="../assets/images/<?php echo trim($images[0]); ?>" width="80" height="80"
                    style="object-fit:cover;border-radius:8px;">

                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <h5 class="fw-bold mb-1"><?php echo $order['foodItem']; ?></h5>
                    </div>
                    <p class="mb-1">Qty: <?php echo $order['quantity']; ?></p>
                    <p class="mb-1">Payment: <?php echo $order['payment_method']; ?></p>
                    <p class="mb-1">Phone: <?php echo $order['phone']; ?></p>
                    <p class="mb-1">Address: <?php echo $order['address']; ?></p>
                    <h6 class="fw-bold text-success">Total: ₹<?php echo $order['total']; ?></h6>
                </div>
            </div>

        </div> 

        <?php endforeach; ?>

    </div>

</body>
<script src="../assets/js/jQuery.js"></script> 
</html>