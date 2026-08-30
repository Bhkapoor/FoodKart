<?php 
session_start();
require_once __DIR__.'/../common/config.php';

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

$foods = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Your existing CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <!-- User Dashboard CSS -->
    <link rel="stylesheet" href="../assets/css/userdash.css">

</head>


<body>


<div class="user-layout">


    <!-- =========================
         SIDEBAR
    ========================== -->

    <aside class="user-sidebar">

        <!-- Logo -->

        <div class="sidebar-brand">

            <div class="brand-icon">
                <i class="bi bi-shop"></i>
            </div>

            <div>
                <h5>FoodKart</h5>
                <small>Food Ordering</small>
            </div>

        </div>


        <!-- Navigation -->

        <div class="sidebar-menu">

            <p class="menu-title">
                MENU
            </p>


            <a href="userdash.php" class="sidebar-link active">

                <i class="bi bi-grid-1x2-fill"></i>

                Dashboard

            </a>


            <a href="#foodMenu" class="sidebar-link">

                <i class="bi bi-egg-fried"></i>

                Food Menu

            </a>


            <!-- EXISTING LINK - NOT CHANGED -->

            <a href="myOrders.php?id=" class="sidebar-link">

                <i class="bi bi-bag-check"></i>

                My Orders

            </a>


            <!-- EXISTING LINK - NOT CHANGED -->

            <a href="wishlist.php?id=" class="sidebar-link">

                <i class="bi bi-heart"></i>

                Wishlist

            </a>


            <!-- EXISTING LINK - NOT CHANGED -->

            <a href="cartview.php?id=" class="sidebar-link">

                <i class="bi bi-cart3"></i>

                My Cart

            </a>

        </div>


        <!-- Bottom -->

        <div class="sidebar-bottom">


            <div class="logged-user">

                <div class="user-avatar">

                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>

                </div>

                <div>

                    <strong>
                        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </strong>

                    <small>
                        Customer
                    </small>

                </div>

            </div>


            <a href="../login/logout.php" class="logout-btn">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </a>

        </div>


    </aside>



    <!-- =========================
         MAIN CONTENT
    ========================== -->

    <main class="user-main">


        <!-- HEADER -->

        <header class="dashboard-header">


            <div>

                <p class="welcome-small">
                    Welcome back 👋
                </p>

                <h2>
                    Dashboard
                </h2>

            </div>


            <div class="header-actions">


                <!-- EXISTING LINK -->

                <a href="myOrders.php?id=" class="orders-btn">

                    <i class="bi bi-bag-check"></i>

                    My Orders

                </a>


                <!-- EXISTING LINK -->

                <a
                    href="wishlist.php?id="
                    class="header-icon-btn"
                    title="Wishlist">

                    <i class="bi bi-heart"></i>

                </a>


                <!-- EXISTING LINK -->

                <a
                    href="cartview.php?id="
                    class="header-icon-btn"
                    title="View Cart">

                    <i class="bi bi-cart3"></i>

                </a>


                <div class="header-user">

                    <div class="header-avatar">

                        <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>

                    </div>

                    <div>

                        <small>Welcome</small>

                        <strong>
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </strong>

                    </div>

                </div>


            </div>


        </header>



        <!-- =========================
             HERO SECTION
        ========================== -->

        <section class="food-hero">


            <div class="hero-content">


                <span class="hero-label">

                    <i class="bi bi-stars"></i>

                    Fresh & Delicious

                </span>


                <h1>

                    Delicious food,
                    <br>

                    <span>delivered to you.</span>

                </h1>


                <p>

                    Discover delicious meals from our restaurants
                    and order your favourite food with ease.

                </p>


                <a href="#foodMenu" class="hero-button">

                    Explore Menu

                    <i class="bi bi-arrow-right"></i>

                </a>


            </div>


            <div class="hero-food-icon">

                <i class="bi bi-egg-fried"></i>

            </div>


        </section>



        <!-- =========================
             QUICK STATS
        ========================== -->

        <div class="row g-4 stats-row">


            <div class="col-md-4">

                <div class="stat-card">

                    <div class="stat-icon food-icon">

                        <i class="bi bi-egg-fried"></i>

                    </div>

                    <div>

                        <span>
                            Available Food
                        </span>

                        <h3>
                            <?php echo count($foods); ?>
                        </h3>

                    </div>

                </div>

            </div>



            <div class="col-md-4">

                <a href="myOrders.php?id=" class="stat-card stat-link">

                    <div class="stat-icon order-icon">

                        <i class="bi bi-bag-check"></i>

                    </div>

                    <div>

                        <span>
                            My Orders
                        </span>

                        <h3>
                            <i class="bi bi-arrow-right"></i>
                        </h3>

                    </div>

                </a>

            </div>



            <div class="col-md-4">

                <a href="cartview.php?id=" class="stat-card stat-link">

                    <div class="stat-icon cart-icon">

                        <i class="bi bi-cart3"></i>

                    </div>

                    <div>

                        <span>
                            My Cart
                        </span>

                        <h3>
                            <i class="bi bi-arrow-right"></i>
                        </h3>

                    </div>

                </a>

            </div>


        </div>



        <!-- =========================
             FOOD MENU
        ========================== -->

        <section id="foodMenu" class="food-section">


            <div class="section-heading">

                <div>

                    <h3>
                        Food Menu
                    </h3>

                    <p>
                        Explore food from our approved restaurants.
                    </p>

                </div>


                <span class="food-count">

                    <?php echo count($foods); ?>

                    Items

                </span>

            </div>



            <!-- FOOD CARDS -->

            <div class="row g-4">


                <?php foreach($foods as $food): ?>

                    <?php
                    $images = explode(",", $food['image']);
                    ?>


                    <div class="col-md-6 col-xl-4">


                        <div class="food-card">


                            <!-- IMAGE -->

                            <div class="food-image-wrapper">


                                <img
                                    src="../assets/images/<?php echo trim($images[0]); ?>"
                                    class="food-image"
                                    alt="<?php echo htmlspecialchars($food['foodItem']); ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#foodModal<?php echo $food['id']; ?>"
                                >


                                <!-- APPROVED -->

                                <span class="approved-badge">

                                    <i class="bi bi-check-circle-fill"></i>

                                    Approved

                                </span>


                                <!-- WISHLIST -->

                                <a
                                    href="wish.php?id=<?php echo $food['id']; ?>"
                                    class="wishlist-btn"
                                    title="Add to Wishlist">

                                    <i class="bi bi-heart"></i>

                                </a>


                            </div>



                            <!-- CARD BODY -->

                            <div class="food-card-body">


                                <div class="food-title-row">

                                    <h4>
                                        <?php echo htmlspecialchars($food['foodItem']); ?>
                                    </h4>

                                    <span class="food-price">

                                        ₹<?php echo htmlspecialchars($food['price']); ?>

                                    </span>

                                </div>



                                <!-- RESTAURANT -->

                                <div class="restaurant-name">

                                    <i class="bi bi-shop"></i>

                                    <?php echo htmlspecialchars($food['restaurant_name']); ?>

                                </div>



                                <!-- ACTIONS -->

                                <div class="food-actions">


                                    <!-- EXISTING LINK -->

                                    <a
                                        href="cart.php?id=<?php echo $food['id']; ?>"
                                        class="add-cart-btn">

                                        <i class="bi bi-cart-plus"></i>

                                        Add to Cart

                                    </a>


                                    <!-- EXISTING LINK -->

                                    <a
                                        href="order.php?id=<?php echo $food['id']; ?>"
                                        class="buy-now-btn">

                                        Buy Now

                                    </a>


                                </div>


                            </div>


                        </div>


                    </div>



                    <!-- =========================
                         FOOD IMAGE MODAL
                    ========================== -->

                    <div
                        class="modal fade"
                        id="foodModal<?php echo $food['id']; ?>"
                        tabindex="-1"
                    >

                        <div class="modal-dialog modal-dialog-centered modal-lg">

                            <div class="modal-content food-modal">


                                <div class="modal-header">


                                    <div>

                                        <h5 class="modal-title fw-bold">

                                            <?php echo htmlspecialchars($food['foodItem']); ?>

                                        </h5>

                                        <small class="text-muted">

                                            <i class="bi bi-shop"></i>

                                            <?php echo htmlspecialchars($food['restaurant_name']); ?>

                                        </small>

                                    </div>


                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                    </button>


                                </div>



                                <div class="modal-body">


                                    <div
                                        id="carousel<?php echo $food['id']; ?>"
                                        class="carousel slide"
                                    >


                                        <div class="carousel-inner">


                                            <?php foreach($images as $index => $img): ?>


                                                <div
                                                    class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>"
                                                >

                                                    <img
                                                        src="../assets/images/<?php echo trim($img); ?>"
                                                        class="d-block w-100 modal-food-image"
                                                        alt="<?php echo htmlspecialchars($food['foodItem']); ?>"
                                                    >

                                                </div>


                                            <?php endforeach; ?>


                                        </div>



                                        <?php if(count($images) > 1): ?>


                                            <button
                                                class="carousel-control-prev"
                                                type="button"
                                                data-bs-target="#carousel<?php echo $food['id']; ?>"
                                                data-bs-slide="prev"
                                            >

                                                <span class="carousel-control-prev-icon"></span>

                                            </button>


                                            <button
                                                class="carousel-control-next"
                                                type="button"
                                                data-bs-target="#carousel<?php echo $food['id']; ?>"
                                                data-bs-slide="next"
                                            >

                                                <span class="carousel-control-next-icon"></span>

                                            </button>


                                        <?php endif; ?>


                                    </div>


                                </div>


                            </div>

                        </div>

                    </div>


                <?php endforeach; ?>



                <?php if(count($foods) == 0): ?>


                    <div class="col-12">

                        <div class="empty-food">

                            <div class="empty-icon">

                                <i class="bi bi-egg-fried"></i>

                            </div>

                            <h4>
                                No food available
                            </h4>

                            <p>
                                No approved food items are available right now.
                            </p>

                        </div>

                    </div>


                <?php endif; ?>


            </div>


        </section>



        <!-- FOOTER -->

        <footer class="dashboard-footer">

            <span>

                <i class="bi bi-shield-check"></i>

                All food items are admin approved

            </span>


            <span>

                © <?php echo date('Y'); ?> FoodHub

            </span>

        </footer>


    </main>

</div>



<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/jQuery.js"></script>


</body>

</html>