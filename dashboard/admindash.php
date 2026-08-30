<?php
session_start();


header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

 require_once  __DIR__.'/../common/config.php';


include 'dashboard_stats.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
   header("Location: ../index.php");
   exit;
} 
// else {
//     echo "invalid";
// }
$user_id = $_SESSION['user_id'];

try {
$data = $pdo->prepare("
    SELECT food.*, users.name AS restaurant_name 
    FROM food
    LEFT JOIN users ON food.restaurant_id = users.id
    WHERE food.STATUS ='pending'
");
$data->execute();
    $user = $data->fetchAll(PDO::FETCH_ASSOC);

//   $notification = $pdo->prepare("
//    SELECT *
//    FROM notifications
//    WHERE receiver_id=?
//    ORDER BY created DESC
//    ");

// $notification->execute([$user_id]);

// $notifications = $notification->fetchAll(PDO::FETCH_ASSOC);
// $count = count($notifications);
 
} catch (PDOException $e) {
    die("Database error");
}

?>

<!DOCTYPE html>

<html>
<head>
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/dashboard.css">

</head>

<body>

<div class="admin-layout">

<!-- ================= SIDEBAR ================= -->

<aside class="sidebar bg-dark text-white d-flex flex-column">

    <!-- BRAND -->

    <div class="sidebar-brand mb-4">

        <div class="d-flex align-items-center gap-2">

            <div class="brand-icon bg-primary rounded-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-shop"></i>
            </div>

            <div>
                <h5 class="mb-0 fw-bold">Admin Panel</h5>
                <small class="text-secondary">
                    Restaurant Management
                </small>
            </div>

        </div>

    </div>


    <!-- NAVIGATION -->

    <div class="sidebar-menu flex-grow-1">

        <small class="text-uppercase text-secondary fw-semibold px-2">
            Menu
        </small>

        <ul class="nav nav-pills flex-column gap-2 mt-3">

            <li class="nav-item">

                <a href="#" class="nav-link active text-white">

                    <i class="bi bi-speedometer2 me-2"></i>

                    Dashboard

                </a>

            </li>


            <!-- NOTIFICATIONS -->

            <li class="nav-item">

                <a href="#notificationBox"
                   data-bs-toggle="collapse"
                   class="nav-link text-white">

                    <i class="bi bi-bell me-2"></i>

                    Notifications

                    <span class="badge bg-danger rounded-pill ms-auto">

                        <?= $count ?>

                    </span>

                </a>

            </li>

        </ul>


        <!-- NOTIFICATION BOX -->

        <div class="collapse mt-2" id="notificationBox">

            <div class="notification-box bg-white text-dark rounded-3 p-3">

                <h6 class="fw-bold mb-3">

                    <i class="bi bi-bell me-2"></i>
                    Notifications

                </h6>


                <?php if($notifications){ ?>

                    <?php foreach($notifications as $item){ ?>

                        <div class="notification-item border-bottom pb-2 mb-2">

                            <strong class="d-block">

                                <?= htmlspecialchars($item['title']) ?>

                            </strong>

                            <p class="mb-1 small">

                                <?= htmlspecialchars($item['message']) ?>

                            </p>

                            <small class="text-muted">

                                <?= $item['created'] ?>

                            </small>

                        </div>

                    <?php } ?>

                <?php } else { ?>

                    <p class="text-muted small mb-0">

                        No notifications

                    </p>

                <?php } ?>

            </div>

        </div>

    </div>


    <!-- LOGOUT -->

    <div class="sidebar-footer">

        <hr class="border-secondary">

        <a href="../login/logout.php"
           class="btn btn-danger w-100">

            <i class="bi bi-box-arrow-right me-1"></i>

            Logout

        </a>

    </div>

</aside>


<!-- ================= MAIN CONTENT ================= -->

<main class="main-content">

    <!-- HEADER -->

    <div class="dashboard-header d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Dashboard
            </h3>

            <p class="text-muted mb-0">
                Manage your restaurant platform
            </p>

        </div>

        <div class="admin-welcome">

            <span class="text-muted">
                Welcome,
            </span>

            <strong>
                Admin
            </strong>

        </div>

    </div>


    <!-- ================= STATS ================= -->

    <div class="row g-4 mb-4">

        <!-- TOTAL USERS -->

        <div class="col-md-4">

            <div class="stat-card card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-2">
                                Total Users
                            </p>

                            <h3 class="fw-bold mb-0">

                                <?php echo $total_users; ?>

                            </h3>

                        </div>

                        <div class="stat-icon bg-primary-subtle text-primary">

                            <i class="bi bi-people-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- RESTAURANTS -->

        <div class="col-md-4">

            <div class="stat-card card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-2">
                                Restaurants
                            </p>

                            <h3 class="fw-bold mb-0">

                                <?php echo $total_restaurants; ?>

                            </h3>

                        </div>

                        <div class="stat-icon bg-success-subtle text-success">

                            <i class="bi bi-shop"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- PENDING APPROVALS -->

        <div class="col-md-4">

            <div class="stat-card card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-2">
                                Pending Approvals
                            </p>

                            <h3 class="fw-bold mb-0">

                                <?php echo $pending_approvals; ?>

                            </h3>

                        </div>

                        <div class="stat-icon bg-warning-subtle text-warning">

                            <i class="bi bi-hourglass-split"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ================= RESTAURANT SECTION ================= -->

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">
                        Restaurant Management
                    </h5>

                    <p class="text-muted mb-0">
                        Register and manage restaurants
                    </p>

                </div>

                <button
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#modal">

                    <i class="bi bi-plus-lg me-1"></i>

                    Add Restaurant

                </button>

            </div>

        </div>

    </div>


    <!-- ================= FOOD APPROVAL TABLE ================= -->

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <h5 class="fw-bold mb-1">
                        Food Approvals
                    </h5>

                    <p class="text-muted mb-0">
                        Review restaurant food submissions
                    </p>

                </div>

                <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2">

                    <?= $pending_approvals ?> Pending

                </span>

            </div>


            <!-- TABLE RESPONSIVE -->

            <div class="table-responsive">

                <table class="table table-hover align-middle text-center mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>

                            <th>Restaurant</th>

                            <th>Food Item</th>

                            <th>Price</th>

                            <th>Email</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if ($user){ ?>

                        <?php foreach($user as $row){ ?>

                            <tr>

                                <td class="fw-semibold">

                                    <?= $row['id'] ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars($row['restaurant_name']) ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars($row['foodItem']) ?>

                                </td>


                                <td>

                                    ₹<?= htmlspecialchars($row['price']) ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars($row['email']) ?>

                                </td>


                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        <a
                                            href="action.php?id=<?php echo $row['id']; ?>&STATUS=approve"
                                            class="btn btn-sm btn-success">

                                            <i class="bi bi-check-lg me-1"></i>
                                            Approve

                                        </a>


                                        <a
                                            href="action.php?id=<?php echo $row['id']; ?>&STATUS=reject"
                                            class="btn btn-sm btn-danger">

                                            <i class="bi bi-x-lg me-1"></i>
                                            Reject

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>

                            <td colspan="6" class="py-4 text-muted">

                                No pending food approvals

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>

</div>


<!-- ================= ADD RESTAURANT MODAL ================= -->

<div class="modal fade" id="modal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-primary text-white">

                <div>

                    <h5 class="modal-title fw-bold">
                        Add Restaurant
                    </h5>

                    <small>
                        Register a new restaurant
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <form action="resregister.php" method="post">

                <div class="modal-body p-4">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Restaurant Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Enter restaurant name"
                            required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter restaurant email"
                            required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter password"
                            required>

                    </div>

                </div>


                <div class="modal-footer border-0 px-4 pb-4">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary px-4">

                        <i class="bi bi-plus-lg me-1"></i>

                        Add Restaurant

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


</body>
</html>

