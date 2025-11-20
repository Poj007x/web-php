<?php
$servername = "localhost";
$username = "root";  
$password = "";       
$dbname = "cns68-2";  

$connect = mysqli_connect($servername, $username, $password, $dbname);

if (!$connect) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}
?>
