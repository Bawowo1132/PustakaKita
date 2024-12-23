<?php
include('koneksi.php');
include('laporan.php'); // Memasukkan file laporan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $nomor_hp = trim($_POST['nomor_hp']);
    $email = trim($_POST['email']);
    $jumlah_donasi = (int) $_POST['jumlah_donasi'];
    $metode_pembayaran = trim($_POST['metode_pembayaran']);

    if (empty($nama_lengkap) || empty($nomor_hp) || empty($email) || empty($jumlah_donasi) || empty($metode_pembayaran)) {
        echo "<script>alert('Semua kolom wajib diisi.'); window.history.back();</script>";
        exit;
    }

    $sql = "INSERT INTO donasi (nama_lengkap, nomor_hp, email, jumlah_donasi, metode_pembayaran) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $nama_lengkap, $nomor_hp, $email, $jumlah_donasi, $metode_pembayaran);

    if ($stmt->execute()) {
        // Panggil fungsi simpanLaporan setelah donasi berhasil disimpan
        if (simpanLaporan($conn, $jumlah_donasi)) {
            echo "<script>alert('Donasi berhasil dan laporan diperbarui!'); window.location.href = '../php/index.php';</script>";
        } else {
            echo "<script>alert('Donasi berhasil, tetapi laporan gagal diperbarui.');</script>";
        }
    } else {
        echo "<script>alert('Gagal menyimpan donasi: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>