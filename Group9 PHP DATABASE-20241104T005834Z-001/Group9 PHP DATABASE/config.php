<?php
// config.php
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "group9"; // Database name updated to group9

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
