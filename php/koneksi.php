<?php
$host = "localhost:3036";
$user = "root";
$pass = "";
$dbname = "Pustakakita";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
