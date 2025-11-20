<?php
session_start();
include_once 'connect.php';

// 1. Receive inputs safely
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// 2. Check if empty
if (empty($username) || empty($password)) {
    header("Location: login.php?error=empty");
    exit();
}

// 3. Prepare SQL
$sql = "SELECT * FROM customers2 WHERE username = ?";
$stmt = mysqli_prepare($connect, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 4. Check if user exists
    if ($row = mysqli_fetch_assoc($result)) {
        
        // 5. Verify the encrypted password
        if (password_verify($password, $row['password'])) {
            
            // ✅ SUCCESS: Set session variables
            $_SESSION['custid']   = $row['custid'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['username'] = $row['username'];
            // Optional: Store status in session too so you can check it on other pages
            $_SESSION['status']   = $row['status']; 

            // 🔀 REDIRECT BASED ON STATUS
            if ($row['status'] == 'admin') {
                header('Location: admin/index.php');
            } else {
                header('Location: profile.php');
            }
            exit();
            
        } else {
            // ❌ WRONG PASSWORD
            header("Location: login.php?error=invalid");
            exit();
        }
    } else {
        // ❌ USERNAME NOT FOUND
        header("Location: login.php?error=invalid");
        exit();
    }
    
    mysqli_stmt_close($stmt);
} else {
    die("Database connection error.");
}

mysqli_close($connect);
?>