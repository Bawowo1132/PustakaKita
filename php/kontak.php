<?php
require_once "koneksi.php";

// Retrieve form data
$nama_lengkap = $_POST['nama_lengkap'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$pesan = $_POST['pesan'];

// Insert data into database
$sql = "INSERT INTO feedbacks (nama_lengkap, email, telepon, pesan) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql) ;
$stmt->bind_param("ssss", $nama_lengkap, $email, $telepon, $pesan);

if ($stmt->execute()) {
    echo "<script>alert('Pesan berhasil dikirim!'); window.location.href = 'index.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
