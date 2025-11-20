<?php
session_start();

// Make sure nothing is output before header()
if (!isset($_SESSION['mem_id'])) {
    header("Location: login.php");
    exit();
}

// Use variables to store session data safely
$fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'ผู้ใช้';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'ไม่ระบุ';

// Sanitize output
$fullname_safe = htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8');
$username_safe = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าหลักสมาชิก</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        .container { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        p { font-size: 16px; color: #555; }
        a { color: #007BFF; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .logout { margin-top: 20px; display: inline-block; padding: 10px 15px; background: #dc3545; color: #fff; border-radius: 5px; }
        .logout:hover { background: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>สวัสดีคุณ, <?= $fullname_safe ?></h1>
        <p>Username ของคุณ: <?= $username_safe ?></p>
        <hr>
        <a class="logout" href="logout.php" class="logout">ออกจากระบบ</a>
    </div>
</body>
</html>
