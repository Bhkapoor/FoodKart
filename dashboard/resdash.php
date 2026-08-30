<?php
session_start();

require_once __DIR__ . '/../common/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$restaurant_id = $_SESSION['user_id'];

try {

    $stmt = $pdo->prepare("
        SELECT *
        FROM food
        WHERE restaurant_id = ?
        ORDER BY id DESC
    ");

    $stmt->execute([$restaurant_id]);

    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restaurant Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">

</head>

<body>

<div class="dashboard-wrapper">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <!-- Logo -->
        <div class="sidebar-brand">

            <div class="brand-icon">
                🍴
            </div>

            <div>
                <h5 class="mb-0 fw-bold">Restaurant</h5>
                <small>Food Management</small>
            </div>

        </div>


        <!-- Navigation -->
        <nav class="sidebar-nav">

            <a href="#" class="sidebar-link active">

                <span class="sidebar-icon">▦</span>

                <span>Dashboard</span>

            </a>

            <a href="#" class="sidebar-link">

                <span class="sidebar-icon">🍽</span>

                <span>My Food Items</span>

            </a>

        </nav>


        <!-- Logout -->
        <div class="sidebar-bottom">

            <a href="../login/logout.php" class="logout-btn">

                <span>↪</span>

                Logout

            </a>

        </div>

    </aside>


    <!-- ================= MAIN CONTENT ================= -->

    <main class="main-content">


        <!-- HEADER -->

        <div class="dashboard-header">

            <div>

                <p class="welcome-text mb-1">
                    Welcome back 👋
                </p>

                <h2 class="dashboard-title">
                    Dashboard
                </h2>

            </div>


            <div class="restaurant-profile">

                <div class="profile-icon">
                    <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
                </div>

                <div>

                    <small class="text-muted d-block">
                        Restaurant
                    </small>

                    <strong>
                        <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </strong>

                </div>

            </div>

        </div>


        <!-- ================= SUMMARY CARD ================= -->

        <div class="row g-4 mb-4">

            <div class="col-md-6 col-xl-4">

                <div class="summary-card">

                    <div class="summary-icon">
                        🍴
                    </div>

                    <div>

                        <p class="summary-label">
                            Total Food Items
                        </p>

                        <h3 class="summary-number">
                            <?= count($foods) ?>
                        </h3>

                    </div>

                </div>

            </div>


            <div class="col-md-6 col-xl-4">

                <div class="summary-card">

                    <div class="summary-icon pending-icon">
                        ⏳
                    </div>

                    <div>

                        <p class="summary-label">
                            Pending
                        </p>

                        <h3 class="summary-number">

                            <?php

                            $pending = 0;

                            foreach ($foods as $food) {

                                if (strtolower($food['STATUS']) === 'pending') {
                                    $pending++;
                                }

                            }

                            echo $pending;

                            ?>

                        </h3>

                    </div>

                </div>

            </div>


            <div class="col-md-6 col-xl-4">

                <div class="summary-card">

                    <div class="summary-icon approved-icon">
                        ✓
                    </div>

                    <div>

                        <p class="summary-label">
                            Approved
                        </p>

                        <h3 class="summary-number">

                            <?php

                            $approved = 0;

                            foreach ($foods as $food) {

                                if (strtolower($food['STATUS']) === 'approved') {
                                    $approved++;
                                }

                            }

                            echo $approved;

                            ?>

                        </h3>

                    </div>

                </div>

            </div>

        </div>


        <!-- ================= FOOD SECTION HEADER ================= -->

        <div class="section-header">

            <div>

                <h4 class="section-title">
                    My Food Items
                </h4>

                <p class="section-subtitle">
                    Manage your food items and check their approval status.
                </p>

            </div>


            <button
                class="btn add-food-btn"
                data-bs-toggle="modal"
                data-bs-target="#modal">

                + Add Food

            </button>

        </div>


        <!-- ================= FOOD CARDS ================= -->

        <div class="row g-4">

            <?php if (count($foods) > 0): ?>

                <?php foreach ($foods as $food): ?>

                    <?php

                    $images = explode(",", $food['image']);

                    $status = strtolower($food['STATUS']);

                    ?>

                    <div class="col-md-6 col-xl-4">

                        <div class="food-card">


                            <!-- IMAGE -->

                            <div class="food-image-wrapper">

                                <?php if (!empty($food['image'])): ?>

                                    <img
                                        src="../assets/images/<?= htmlspecialchars($images[0]) ?>"
                                        class="food-image"
                                        alt="<?= htmlspecialchars($food['foodItem']) ?>"
                                    >

                                <?php else: ?>

                                    <div class="no-image">
                                        No Image
                                    </div>

                                <?php endif; ?>


                                <!-- STATUS -->

                                <div class="status-position">

                                    <?php if ($status === 'approved'): ?>

                                        <span class="status-badge status-approved">
                                            ✓ Approved
                                        </span>

                                    <?php elseif ($status === 'rejected'): ?>

                                        <span class="status-badge status-rejected">
                                            ✕ Rejected
                                        </span>

                                    <?php else: ?>

                                        <span class="status-badge status-pending">
                                            ⏳ Pending
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>


                            <!-- CARD BODY -->

                            <div class="food-card-body">

                                <div class="d-flex justify-content-between align-items-start">

                                    <h5 class="food-name">
                                        <?= htmlspecialchars($food['foodItem']) ?>
                                    </h5>

                                    <span class="food-price">
                                        ₹<?= htmlspecialchars($food['price']) ?>
                                    </span>

                                </div>


                                <div class="food-details">

                                    <div class="food-detail">

                                        <span class="detail-label">
                                            Email
                                        </span>

                                        <span class="detail-value">
                                            <?= htmlspecialchars($food['email']) ?>
                                        </span>

                                    </div>

                                </div>


                                <!-- STATUS TEXT -->

                                <div class="approval-info">

                                    <?php if ($status === 'approved'): ?>

                                        <span>
                                            Your food item has been approved.
                                        </span>

                                    <?php elseif ($status === 'rejected'): ?>

                                        <span>
                                            Your food item has been rejected.
                                        </span>

                                    <?php else: ?>

                                        <span>
                                            Waiting for admin approval.
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>


            <?php else: ?>

                <!-- EMPTY STATE -->

                <div class="col-12">

                    <div class="empty-state">

                        <div class="empty-icon">
                            🍽
                        </div>

                        <h5>
                            No food items yet
                        </h5>

                        <p>
                            You haven't added any food items.
                            Start by adding your first food item.
                        </p>

                        <button
                            class="btn add-food-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#modal">

                            + Add Food

                        </button>

                    </div>

                </div>

            <?php endif; ?>

        </div>


        <!-- ================= USER INFO ================= -->

        <div class="account-card mt-5">

            <div>

                <small>
                    Logged in as
                </small>

                <h6 class="mb-0">
                    <?= htmlspecialchars($_SESSION['user_name']) ?>
                </h6>

            </div>

            <div>

                <small>
                    Email
                </small>

                <h6 class="mb-0">
                    <?= htmlspecialchars($_SESSION['user_email']) ?>
                </h6>

            </div>

            <div>

                <small>
                    Restaurant ID
                </small>

                <h6 class="mb-0">
                    #<?= htmlspecialchars($_SESSION['user_id']) ?>
                </h6>

            </div>

        </div>


    </main>

</div>



<!-- ================= ADD FOOD MODAL ================= -->

<div class="modal fade" id="modal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content custom-modal">


            <div class="modal-header">

                <div>

                    <h5 class="modal-title fw-bold">
                        Add Food Item
                    </h5>

                    <small class="text-muted">
                        Add a new food item for admin approval.
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <form
                action="food.php"
                method="post"
                enctype="multipart/form-data">


                <div class="modal-body">


                    <!-- Food -->
                    <div class="mb-3">

                        <label class="form-label">
                            Food Item
                        </label>

                        <input
                            type="text"
                            name="foodItem"
                            class="form-control"
                            placeholder="Enter food name"
                            required>

                    </div>


                    <!-- Price -->
                    <div class="mb-3">

                        <label class="form-label">
                            Price
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₹
                            </span>

                            <input
                                type="number"
                                name="price"
                                class="form-control"
                                placeholder="Enter price"
                                required>

                        </div>

                    </div>


                    <!-- Image -->
                    <div class="mb-3">

                        <label class="form-label">
                            Food Image
                        </label>

                        <input
                            type="file"
                            name="img[]"
                            multiple
                            class="form-control"
                            accept="image/*"
                            required>

                        <small class="text-muted">
                            You can select multiple images.
                        </small>

                    </div>


                    <!-- Email -->
                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter email"
                            required>

                    </div>


                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn submit-food-btn">

                        Add Food

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>