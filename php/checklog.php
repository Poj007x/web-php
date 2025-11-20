<?php
session_start();

// Database connection
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "cns68-2";

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get POST data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Query customers2 table
$sql = "SELECT * FROM customers2 WHERE username = :username LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If username not found
if (!$user) {
    header("Location: login.php?error=invalid");
    exit();
}

// Compare raw password (your DB stores plain text)
if ($password === $user['password']) {

    // Set session values
    $_SESSION['custid']   = $user['custid'];
    $_SESSION['fullname'] = $user['fullname'];
    $_SESSION['username'] = $user['username'];

    header("Location: member.php");
    exit();

} else {
    // Password wrong
    header("Location: login.php?error=invalid");
    exit();
}
?>
