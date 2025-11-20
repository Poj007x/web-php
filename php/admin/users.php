<?php
session_start();

// 1. Security Check: Is the user an admin?
// If no session or status is not 'admin', kick them to the main login
if (!isset($_SESSION['custid']) || $_SESSION['status'] !== 'admin') {
    header("Location: ../login.php"); // Go up one level to login
    exit();
}

// 2. Connect to Database (Go up one level to find connect.php)
include '../connect.php';

// Query
$sql = "SELECT username, fullname, phone FROM customers2";
$result = mysqli_query($connect, $sql);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Customer List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { padding-top: 1.5rem; background-color:#f8f9fa; }
  .card { max-width: 1100px; margin: 0 auto; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">👑 Admin Panel</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <h1 class="card-title mb-0">All Customers</h1>
        
        <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
      </div>

      <?php if (mysqli_num_rows($result) === 0): ?>
        <div class="alert alert-warning mb-0">No customers found.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-striped table-hover table-bordered mb-0">
            <thead class="table-light">
              <tr>
                <th scope="col">Username</th>
                <th scope="col">Full Name</th>
                <th scope="col">Phone</th>
              </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

    </div>
    <div class="card-footer text-muted small">
      Data retrieved: <?php echo date('Y-m-d H:i'); ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

