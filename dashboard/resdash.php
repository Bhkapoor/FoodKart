<?php
session_start();

if(!isset($_session['user_id'])){
     
 
} else {
    echo "invalid";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<body class="bg-light">

<div class="d-flex">

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column p-3 bg-warning text-dark vh-100 shadow">
    
    <h4 class="text-center mb-4 fw-bold">Restaurant</h4>

    <ul class="nav nav-pills flex-column gap-2">
      <li class="nav-item">
        <a href="#" class="nav-link active bg-dark text-white">Dashboard</a>
      </li>
      <!-- <li>
        <a href="#" class="nav-link text-dark">Users</a>
      </li>
      <li>
        <a href="#" class="nav-link text-dark">Food Items</a>
      </li>
      <li>
        <a href="#" class="nav-link text-dark">Settings</a>
      </li> -->
    </ul>

    <a href="../login/logout.php" class="btn btn-dark mt-auto">Logout</a>
  </div>

  <!-- Content -->
  <div class="flex-grow-1 p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold">Dashboard</h3>
      <span class="text-muted">Hi, Restaurant</span>
    </div>

    <!-- Card Section -->
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-body bg-warning-subtle">
        <h4 class="card-title">Food Items</h4>
        <p class="card-text">
          You can add food by clicking the button below:
        </p>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
          + Add Food
        </button>
      </div>
    </div>

    <!-- User Info -->
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <p class="mb-1"><strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?></p>
        <p class="mb-0"><strong>Email:</strong> <?php echo $_SESSION['user_email']; ?></p>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-warning">
        <h5 class="modal-title">Add Food</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="food.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Food Item</label>
            <input type="text" name="foodItem" class="form-control" placeholder="Enter food name">
          </div>

          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" placeholder="Enter price">
          </div>
                   <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="img[]" multiple class="form-control" placeholder="Enter image file">
          </div>

          <div class="mb-3">
            <label class="form-label">Send Mail To</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email">
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-warning w-100">Send</button>
        </div>
      </form>

    </div>
  </div>
</div>

</body>
</body>
</html>