<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "user_system";
$port = 3308; 

$conn = new mysqli($host, $user, $pass, $db, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
?>