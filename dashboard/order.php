<?php 
session_start();
require_once  __DIR__.'/../common/config.php';
require '../vendor/autoload.php';
use Razorpay\Api\Api;

$keyId = "rzp_test_SqkeuTlieNzCKB";
$keySecret = "mohjRHVE837512cfW018z2JR";

$api = new Api($keyId, $keySecret);
$user_id = $_SESSION['user_id'];
// place all oreders
$totalAmount = 0;
$cartItems = [];

if(isset($_POST['cart_order'])){

    $stmt = $pdo->prepare("
        SELECT cart.*, food.*
        FROM cart
        JOIN food ON cart.food_id = food.id
        WHERE cart.user_id = ?
    ");

    $stmt->execute([$user_id]);
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($foods as $food){
        $totalAmount += $food['price'] * $food['quantity'];
    }

}
else{$food_id= $_GET['id'] ?? '';



if($food_id== ''){
    echo "Invalid id";
    exit;
}
$quantity=$_GET['quantity']?? 1;
$stmt = $pdo->prepare("SELECT * FROM food where id =?");
$stmt->execute([$food_id]);

$foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalAmount = $foods[0]['price'] * $quantity;

$order = $api->order->create([
    'receipt' => 'order_rcptid_11',
    'amount' => $totalAmount * 100,
    'currency' => 'INR'
]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order page</title>
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <div class="container mt-5">

        <h2 class="fw-bold mb-4">Order Details</h2>
        <?php if(isset($_POST['cart_order'])): ?>

        <div class="container mt-5">

            <div class="row">
                <div class="col-md-7">

                    <h2 class="fw-bold mb-4">
                        Cart Items
                    </h2>

                    <?php foreach($foods as $food): ?>

                    <div class="card shadow-sm border-0 rounded-4 mb-3 p-3">

                        <div class="d-flex align-items-center">

                            <img src="../assets/images/<?php echo $food['image']; ?>"
                                style="width:120px;height:100px;object-fit:cover;" class="rounded-3">

                            <div class="ms-3 w-100">

                                <h5 class="fw-bold mb-1">
                                    <?php echo $food['foodItem']; ?>
                                </h5>

                                <p class="mb-1 text-muted">
                                    Quantity:
                                    <?php echo $food['quantity']; ?>
                                </p>

                                <h6 class="text-warning fw-bold">
                                    ₹<?php echo $food['price'] * $food['quantity']; ?>
                                </h6>

                            </div>

                        </div>

                    </div>

                    <?php endforeach; ?>

                </div>

                <!-- RIGHT SIDE : FORM -->

                <div class="col-md-5">

                    <div class="card shadow border-0 rounded-4 p-4 sticky-top">

                        <h3 class="fw-bold mb-4">
                            Delivery Details
                        </h3>

                        <form class="order-form-class" action="orderphp.php" method="POST">

                            <input type="hidden" name="cart_order" value="1">

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Full Address
                                </label>

                                <textarea name="address" class="form-control" rows="3"></textarea>

                            </div>

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Phone Number
                                </label>

                                <input type="number" name="phone" class="form-control">

                            </div>

                            <div class="mb-4">

                                <label class="form-label fw-semibold d-block mb-2">
                                    Payment Method
                                </label>

                                <div class="form-check mb-2">

                                    <input class="form-check-input" type="radio" name="payment_method" value="razorpay"
                                        checked>

                                    <label class="form-check-label">
                                        Razorpay
                                    </label>

                                </div>

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="payment_method" value="cod">

                                    <label class="form-check-label">
                                        Cash on Delivery
                                    </label>

                                </div>

                            </div>

                            <div class="border-top pt-3 mb-3">

                                <h5 class="fw-bold">
                                    Total :
                                    ₹<?php echo $totalAmount; ?>
                                </h5>

                            </div>

                          <button type="submit" class="btn btn-warning w-100 py-2 fw-semibold">
                            Continue
                          </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        <?php else: ?>
        <?php foreach($foods as $food): ?>

        <div class="card shadow border-0 rounded-4 p-3 mb-5">
            <div class="row align-items-center">

                <!-- Image -->
                <div class="col-md-5">
                    <img src="../assets/images/<?php echo $food['image']; ?>" class="img-fluid rounded-4 w-100"
                        style="height:320px; object-fit:cover;">
                </div>

                <!-- Details -->
                <div class="col-md-7">

                    <div class="ps-md-4 mt-4 mt-md-0">

                        <h2 class="fw-bold mb-3">
                            <?php echo $food['foodItem']; ?>
                        </h2>

                        <h4 class="text-warning fw-bold mb-4">
                            ₹<?php echo $food['price']* $quantity; ?>
                        </h4>

                        <p class="text-muted mb-4">
                            Fresh and delicious food prepared with quality ingredients.
                        </p>

                        <!-- FORM -->
                        <div class="border rounded-4 p-4 bg-light">

                            <form class="order-form-class" id="orderForm" action="orderphp.php" method="post"
                                data-price="<?php echo htmlspecialchars($food['price']); ?>">

                                <input type="hidden" name="food_id" value="<?php echo $food['id']; ?>">



                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Full Address
                                    </label>

                                    <textarea name="address" class="form-control" rows="3"
                                        placeholder="Enter your address"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Phone Number
                                    </label>

                                    <input type="number" name="phone" class="form-control"
                                        placeholder="Enter phone number">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Quantity
                                    </label>

                                    <input type="number" name="quantity" class="form-control quantity-field-class"
                                        id="quantityInput" value="<?php echo $quantity;?>" min="1">
                                </div>

                                <div class="mb-4">

                                    <label class="form-label fw-semibold d-block mb-2">
                                        Choose Payment Method
                                    </label>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            value="razorpay" id="radio1" checked>

                                        <label class="form-check-label" for="radio1">
                                            Razorpay
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" value="cod"
                                            id="radio2">

                                        <label class="form-check-label" for="radio2">
                                            Cash on Delivery
                                        </label>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-warning w-100 py-2 fw-semibold">
                                    Continue
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>
        </div>

        <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    const razorpayOrderId = "<?php echo $order['id']; ?>";
    const razorpayAmount = "<?php echo $totalAmount * 100; ?>";
    </script>
    <script src="../assets/js/order.js"></script>
</body>

</html>