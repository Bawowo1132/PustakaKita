<?php
include '../php/koneksi.php';
// Query untuk menghitung Total Donasi

// Mengambil total donasi
$queryDonasi = "SELECT SUM(jumlah_donasi) AS total_donasi FROM donasi WHERE status_donasi = 'Completed'";
$resultDonasi = $conn->query($queryDonasi);

if ($resultDonasi->num_rows > 0) {
    $row = $resultDonasi->fetch_assoc();
    $donasiCount = $row['total_donasi'];
} else {
    $donasiCount = 0;
}

// Query untuk menghitung jumlah transaksi (donasi) yang ada
$queryTransaksi = "SELECT COUNT(id) AS total_transaksi FROM donasi";
$resultTransaksi = $conn->query($queryTransaksi);

if ($resultTransaksi->num_rows > 0) {
    $row = $resultTransaksi->fetch_assoc();
    $transaksiCount = $row['total_transaksi'];
} else {
    $transaksiCount = 0;
}

// Query untuk menghitung jumlah feedback
$queryFeedback = "SELECT COUNT(id) AS total_feedback FROM feedbacks";
$resultFeedback = $conn->query($queryFeedback);

if ($resultFeedback->num_rows > 0) {
    $row = $resultFeedback->fetch_assoc();
    $feedbackCount = $row['total_feedback'];
} else {
    $feedbackCount = 0;
}

// Menutup koneksi
$conn->close();
?>