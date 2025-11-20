<?php
// Include your database connection
include 'connect.php';

// Get POST data safely
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm  = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$fullname = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';

// Validate required fields
if (empty($username) || empty($password) || empty($fullname)) {
    die('กรุณากรอกข้อมูลให้ครบทุกช่อง');
}

// Check if password and confirmation match
if ($password !== $confirm) {
    die('รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน');
}

// Check if username already exists
$sql_check = "SELECT * FROM customers2 WHERE username = ?";
$stmt_check = $connect->prepare($sql_check);
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    die('ชื่อผู้ใช้นี้ถูกใช้ไปแล้ว');
}
$stmt_check->close();

// Hash the password securely
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert new user into the database
$sql_insert = "INSERT INTO customers2 (username, password, fullname) VALUES (?, ?, ?)";
$stmt_insert = $connect->prepare($sql_insert);
$stmt_insert->bind_param("sss", $username, $hashedPassword, $fullname);

if ($stmt_insert->execute()) {
    echo "✅ สมัครสมาชิกสำเร็จ!<br>";
    echo "<a href='login.php'>ไปหน้าล็อกอิน</a>";
} else {
    echo "❌ เกิดข้อผิดพลาดในการสมัครสมาชิก: " . $stmt_insert->error;
}

$stmt_insert->close();
$connect->close();
?>
