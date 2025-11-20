<?php
session_start();
$message = '';

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'cns68-2'; // Your database name

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `customers2` (username, full_name, phone, password)
                VALUES (:username, :full_name, :phone, :password)";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute([
                ':username' => $username,
                ':full_name' => $fullname,
                ':phone' => $phone,
                ':password' => $hashed_password
            ]);

            $message = "✅ Registration successful!";
        } catch(PDOException $e) {
            if (str_contains($e->getMessage(), 'Duplicate')) {
                $message = "⚠️ Error: Username already exists!";
            } else {
                $message = "❌ Database Error: " . $e->getMessage();
            }
        }
    } else {
        $message = "⚠️ Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #a1c4fd, #c2e9fb);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input {
            display: block;
            margin-bottom: 10px;
            padding: 8px;
            width: 250px;
        }
        .message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Register</h2>
        <div class="message"><?= htmlspecialchars($message) ?></div>
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
