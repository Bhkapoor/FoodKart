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

<div class="d-flex">

<!-- SIDEBAR -->

<div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-dark vh-100">
<h4 class="text-center mb-4">Admin Panel</h4>

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
            <i class="bi bi-shop me-2"></i> Restaurants
        </a>
    </li>

    <li>
        <a href="#" class="nav-link text-white">
            <i class="bi bi-check2-square me-2"></i> Food Approvals
        </a>
    </li> -->
 <li class="position-relative">

<a href="#notificationBox" data-bs-toggle="collapse" class="nav-link text-white">

<i class="bi bi-bell"></i>

Notifications

<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

<?= $count ?>

</span>

</a>

</li>

    <!-- <li>
        <a href="#" class="nav-link text-white">
            <i class="bi bi-gear me-2"></i> Settings
        </a>
    </li> -->

</ul>
<div class="collapse mt-2" id="notificationBox">

<div class="bg-white text-dark p-2 rounded">

<h6>Notifications</h6>

<?php if($notifications){ ?>

<?php foreach($notifications as $item){ ?>

<div class="border-bottom mb-2 pb-2">

<strong>
<?= htmlspecialchars($item['title']) ?>
</strong>

<p class="mb-1">
<?= htmlspecialchars($item['message']) ?>
</p>

<small>
<?= $item['created'] ?>
</small>

</div>

<?php } ?>

<?php } else { ?>

<p>No notifications</p>

<?php } ?>

</div>
</div>
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
    <span class="text-muted">Welcome, Admin</span>
</div>

<!-- STATS -->
<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6>Total Users</h6>

            <h3><?php echo $total_users;?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6>Restaurants</h6>
            <h3><?php echo $total_restaurants;?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6>Pending Approvals</h6>
            <h3><?php echo $pending_approvals;?></h3>
        </div>
    </div>

</div>

<!-- RESTAURANT SECTION -->
<div class="card shadow-sm p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Restaurants</h5>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            + Add Restaurant
        </button>
    </div>

    <p class="text-muted">Register all  restaurants from here.</p>

</div>

<!-- USER INFO -->
<div class="mt-4">

    <!-- TABLE -->
    <div class="card shadow p-4">
        <h5 class="mb-3">Your Profile</h5>

        <table class="table table-bordered table-hover text-center table-striped-columns">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Restaurant</th>
                    <th>foodItem</th>
                     <th>price</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($user){
                    foreach($user as $row)
                 { ?>
                   <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['restaurant_name']) ?></td>
            <td><?= htmlspecialchars($row['foodItem']) ?></td>
            <td><?= htmlspecialchars($row['price']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <a href="action.php?id=<?php echo $row['id']; ?>&STATUS=approve" class="btn btn-primary" data-id="<?= $row['id'] ?>">Approve</a>
                <a href="action.php?id=<?php echo $row['id']; ?>&STATUS=reject"  class="btn btn-danger" data-id="<?= $row['id'] ?>">Reject</a>
            </td>
        </tr>
                <?php } }else { ?>
                    <tr>
                        <td colspan="5">User not found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</div>
</div>

<!-- MODAL -->

<div class="modal fade" id="modal">
<div class="modal-dialog">
<div class="modal-content rounded-3 shadow">

<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Add Restaurant</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="resregister.php" method="post">

    <div class="modal-body">

        <div class="mb-3">
            <label class="form-label">Restaurant Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
           <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary w-100">Add Restaurant</button>
    </div>

</form>

</div>
</div>
</div>

</body>
</html>

