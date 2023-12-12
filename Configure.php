<?php
$hostname = "localhost"; 
$username = "root"; 
$password = "witlibrary2023password"; 
$database = "database_users"; 

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>