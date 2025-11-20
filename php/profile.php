<?php
session_start();

// Check for 'custid' (matches login_check.php)
if (!isset($_SESSION['custid'])) {
    header("Location: login.php");
    exit();
}

include 'connect.php';

// Get variables from session
$full_name = $_SESSION['fullname']; // matches login_check.php
$username = $_SESSION['username'];

function is_active($file) {
    $current = basename($_SERVER['PHP_SELF']);
    return $current === $file ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>โปรไฟล์ของฉัน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🌟 MyProfile</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="profile.php">โปรไฟล์</a></li>
      </ul>

      <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item me-3">
            <span class="text-white">👤 <?php echo htmlspecialchars($full_name); ?></span>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="btn btn-danger btn-sm">ออกจากระบบ</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center mb-4">ข้อมูลโปรไฟล์</h3>
        <p><strong>ชื่อผู้ใช้:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>ชื่อเต็ม:</strong> <?php echo htmlspecialchars($full_name); ?></p>
        <div class="alert alert-success mt-4">
            ยินดีต้อนรับเข้าสู่ระบบ! 🎉
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>