<?php
session_start();

// Security Check
if (!isset($_SESSION['custid']) || $_SESSION['status'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-danger">
  <div class="container">
    <span class="navbar-brand mb-0 h1">👑 Admin Dashboard</span>
    <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
  </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h2>
            <p class="text-muted">You have administrative access.</p>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">👤 Manage Users</h5>
                    <p class="card-text">View and manage registered members.</p>
                    <a href="users.php" class="btn btn-primary">Go to Users</a>
                </div>
            </div>
        </div>

        </div>
</div>

</body>
</html>