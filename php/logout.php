<?php
session_start();
session_destroy(); // Destroys the session data
header("Location: login.php"); // Correct syntax: 'Location:' is required
exit();
?>