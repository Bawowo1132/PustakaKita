<?php
include('../php/koneksi.php');
require "laporan.php";
// Mengecek apakah data dari form telah dikirim

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Mengambil data dari form
  $nama_lengkap = $_POST['nama_lengkap'];
  $nomor_hp = $_POST['nomor_hp'];
  $email = $_POST['email'];
  $jumlah_donasi = $_POST['jumlah_donasi'];
  $metode_pembayaran = $_POST['metode_pembayaran'];

  $judul_laporan = "Laporan " . $nama_lengkap;
  $tanggal_laporan = date('Y-m-d');

  
  // Memanggil fungsi untuk menambahkan laporan
  tambahLaporanDenganHTML($conn, $judul_laporan, $tanggal_laporan, "donasi",  $jumlah_donasi);


  // Query untuk menyimpan data ke dalam database
  $sql = "INSERT INTO donasi (nama_lengkap, nomor_hp, email, jumlah_donasi, metode_pembayaran) 
            VALUES (?, ?, ?, ?, ?)";

  

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssis", $nama_lengkap, $nomor_hp, $email, $jumlah_donasi, $metode_pembayaran);

  if ($stmt->execute()) {

    // Jika berhasil, tampilkan notifikasi sukses
    echo "
            <script>
                alert('Donasi berhasil!');
            </script>
        ";
      

  } else {
    echo "<script>alert('Terjadi kesalahan: " . $stmt->error . "');</script>";
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pustaka Kita</title>
  <link rel="stylesheet" href="../css/donasi.css">
</head>

<body>
  <div id="donation-forms">
    <!-- Form pertama untuk memilih jumlah donasi -->
    <div id="donation-form-1" class="donation-form-overlay">
      <div class="donation-form-container">
        <button class="back-btn" id="back-btn-1">&larr;</button>
        <h2>Donasi Sekarang</h2>
        <div class="amount-options">
          <button class="amount-btn" data-amount="15000">Rp 15.000</button>
          <button class="amount-btn" data-amount="25000">Rp 25.000</button>
          <button class="amount-btn" data-amount="50000">Rp 50.000</button>
          <button class="amount-btn" data-amount="75000">Rp 75.000</button>
          <button class="amount-btn" data-amount="100000">Rp 100.000</button>
        </div>
        <div class="other-donation">
          <input type="number" id="other-amount" placeholder="Jumlah Donasi Lainnya" />
        </div>
        <button id="proceed-btn" class="cta">Lanjut ke Data Diri</button>
      </div>
    </div>

    <!-- Form kedua untuk data diri donatur -->
    <div id="donation-form-2" class="donation-form-overlay hidden">
      <div class="donation-form-container">
        <button class="back-btn" id="back-btn-2">&larr;</button>
        <h2>Data Diri Donatur</h2>
        <form id="donor-form">
          <div class="form-group">
            <label for="donor-name">Nama Lengkap</label>
            <input type="text" id="donor-name" placeholder="Nama Anda" required />
          </div>
          <div class="form-group">
            <label for="donor-phone">Nomor HP</label>
            <input type="text" id="donor-phone" placeholder="Nomor HP" required />
          </div>
          <div class="form-group">
            <label for="donor-email">Email</label>
            <input type="email" id="donor-email" placeholder="Email Anda" required />
          </div>
          <div class="form-group">
            <label for="donor-amount">Jumlah Donasi</label>
            <input type="text" id="donor-amount" readonly />
          </div>
          <button id="proceed-btn-2" class="cta" type="submit">
            Lanjut ke Metode Pembayaran
          </button>
        </form>
      </div>
    </div>

    <!-- Form ketiga untuk memilih metode pembayaran -->
    <div id="donation-form-3" class="donation-form-overlay hidden">
      <div class="donation-form-container">
        <button class="back-btn" id="back-btn-3">&larr;</button>
        <h2>Pilih Metode Pembayaran</h2>
        <form id="payment-method-form">
          <div class="form-group">
            <label for="payment-method">Metode Pembayaran</label>
            <select id="payment-method" required>
              <option value="bank transfer">Bank Transfer</option>
              <option value="qris">QRIS (E-wallet)</option>
            </select>
          </div>
          <button id="proceed-btn-3" class="cta" type="submit">Lanjutkan</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Notifikasi sukses -->
  <div id="success-notification" class="notification hidden">
    <p>Donasi Berhasil!</p>
  </div>

  <script src="../js/donasi.js"></script>
   
</body>

</html>