<?php
$host = "localhost";
$user = "root";  // Change this if you use a different username
$pass = "";      // Change this if your database has a password
$dbname = "user_auth";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
