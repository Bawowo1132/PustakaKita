<?php
error_reporting(E_ALL); // Report all PHP errors
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "webapp-mysql";
$user = "webstriix";
$pass = "webstriix";
$dbname = "Pustakakita";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
