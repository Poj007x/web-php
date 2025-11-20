<?php
session_start();
if(empty($_SESSION['fullname'])) {
    header("Location: php/login.php");
    exit();
}
welcome_message = isset($_SESSION['fullname']) ? "Welcome, " . htmlspecialchars($_SESSION['fullname']) . "!" : "Welcome!";
?>