<?php
 include('../php/koneksi.php');

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
$querydonatur = "SELECT COUNT(id) AS total_donatur FROM donasi";
$resultdonatur = $conn->query($querydonatur);

if ($resultdonatur->num_rows > 0) {
    $row = $resultdonatur->fetch_assoc();
    $donaturCount = $row['total_donatur'];
} else {
    $donaturCount = 0;
}



// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pustaka Kita</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css" />
  </head>
  <body>
    <!-- Navbar Start -->
    <nav class="navbar">
      <a href="#" class="navbar-logo">Pustaka<span>Kita</span>.</a>

      <div class="navbar-nav">
        <a href="#home">Home</a>
        <a href="#about">Tentang Kami</a>
        <a href="#program">Program</a>
        <a href="#donation">Donasi</a>
        <a href="#contact">Kontak</a>
      </div>

      <div class="navbar-extra">
        <a href="login.php" id="user"><i data-feather="user"></i></a>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
    </nav>
    <!-- Navbar End -->

    <!-- Hero Section Start -->
    <section class="hero" id="home">
      <main class="content">
        <h1>Donasi Pendidikan Bangsa <span>Cendekia</span></h1>
        <p>
          Lebih dari 100.000 siswa telah terbantu oleh gerakan ini dan 1.000 sekolah dalam kondisi
          memprihatinkan kembali terbangun.
        </p>
        <p>Mari berdonasi demi memajukan pendidikan di Indonesia.</p>
        <a href="../php/donasi.php" class="cta">Donasi Sekarang</a>
      </main>
    </section>
    <!-- Hero Section End -->

    <!-- About Section Start -->
    <section id="about" class="about">
      <h2><span>Tentang</span> Kami</h2>

      <div class="row">
        <div class="about-img">
          <img src="../img/tentang-kami.jpg" alt="Tentang Kami" />
        </div>
        <div class="content">
          <h3>Siapa <span>Pustaka</span><span class="kita">Kita</span>. ?</h3>
          <p>
            Pustaka Kita adalah organisasi di bidang pendidikan yang berfokus membantu putra dan
            putri Indonesia dalam menggapai cita serta sekolah yang membutuhkan, sebagai komitmen
            kami untuk memajukan pendidikan di Indonesia.
          </p>
          <p>
            Kami menjadi jembatan antara donatur dan penerima benefit, memberikan akses pendidikan
            yang lebih merata hingga ke pelosok negeri.
          </p>
          <p>
            Bersama Anda, kami wujudkan masa depan yang lebih cerah bagi generasi muda Indonesia.
          </p>
        </div>
      </div>
    </section>
    <!-- About Section End -->

    <!-- Program Section Start -->
    <section id="program" class="program">
      <h2><span>Program</span> Kami</h2>
      <p>
        Kami menjalankan beberapa program untuk mendukung visi memajukan pendidikan di Indonesia.
      </p>

      <div class="row">
        <div class="program-card">
          <img src="../img/program/beasiswa.jpg" alt="Donasi buku" class="program-card-img" />
          <h3 class="program-card-title">Beasiswa Bangsa Cendekia</h3>
          <p class="program-card-p">
            Kami mengumpulkan donasi dari para donatur untuk mendanai bantuan dana pendidikan berupa
            beasiswa kepada siswa terpilih yang membutuhkan.
          </p>
          <a href="../php/daftar-beasiswa.php" class="cta">Daftar Beasiswa</a>
        </div>
        <div class="program-card">
          <img
            src="../img/program/sekolah.jpg"
            alt="Siswa belajar di kelas"
            class="program-card-img"
          />
          <h3 class="program-card-title">Bantuan Sekolah Cendekia</h3>
          <p class="program-card-p">
            Kami mendistribusikan dana donasi dari para donatur untuk membantu sekolah - sekolah
            terpilih yang membutuhkan bantuan.
          </p>
          <a href="../php/daftar-sekolah.php" class="cta">Daftar Bantuan Sekolah</a>
        </div>
      </div>
    </section>
    <!-- Program Section End -->

    <!-- Donation Section Start -->
    <section id="donation" class="donation">
      <h2>Pusat <span>Donasi</span></h2>

      <div class="donation-stats">
        <div class="stat">
          <h3 class="number"><?php echo $donaturCount; ?> </h3>
          <p>Jumlah Donatur</p>
        </div>
        <div class="stat">
        <h3  class="number">Rp. <?php echo $donasiCount; ?> </h3>
          <p>Jumlah Dana Terkumpul</p>
        </div>
      </div>

      

      <div class="donation-content">
        <div class="donation-carousel">
          <button class="carousel-btn prev-btn">&lt;</button>
          <div class="carousel-images">
            <img
              src="../img/program/belajar.jpg"
              alt="Sekelompok siswa sedang bermain laptop "
              class="active"
            />
            <img src="../img/program/belajar2.jpg" alt="Siswa sedang angkat tangan" />
            <img src="../img/program/belajar3.jpg" alt="Siswa sekolah dasar dalam keadaan ceria" />
          </div>
          <button class="carousel-btn next-btn">&gt;</button>
        </div>

        <div class="donation-info">
          <h2>Donasi Pendidikan Bangsa Cendekia</h2>
          <p>
            Donasi ini adalah sebuah gerakan dari Pustaka Kita untuk memajukan pendidikan di
            Indonesia. Dengan donasi Anda, kami dapat memperbaiki fasilitas pendidikan, menyediakan
            beasiswa, dan memberikan akses pendidikan yang merata untuk anak-anak di seluruh
            Indonesia. <br />
            Bersama, mari wujudkan masa depan pendidikan yang lebih cerah demi putra - putri Bangsa
            Indonesia !
          </p>

          <a href="../php/donasi.php" class="cta">Donasi Sekarang</a>
        </div>
      </div>
    </section>
    <!-- Donation Section End -->

    <!-- Contact Section Start -->
    <section id="contact" class="contact">
      <h2><span>Kontak</span> Kami</h2>
      <p>
        Kami selalu siap untuk mendengarkan saran, pertanyaan, atau kolaborasi dari Anda. <br />
        Jangan ragu untuk menghubungi kami!
      </p>

      <form action="../php/kontak.php" method="post">
        <input type="text" placeholder="Nama Lengkap" name="nama_lengkap" required />
        <input type="email" placeholder="Email" name="email" required />
        <input type="text" placeholder="Telepon" name="telepon" required />
        <textarea placeholder="Pesan" name="pesan" required></textarea>
        <button type="submit">Kirim Pesan</button>
      </form>
    </section>
    <!-- Contact Section End -->

    <!-- Footer Start -->
    <footer>
      <div class="footer-left">
        <div class="footer-contact">
          <a href="#" class="footer-logo">Pustaka<span>Kita</span>.</a>
          <p>Email: info@pustakakita.org</p>
          <p>Telepon: +62 21 1234 5678</p>
          <p>Alamat: Jl. Pustaka Kita Indonesia, No. 123, Denpasar, Indonesia</p>
        </div>

        <div class="socials">
          <a href="#"><i data-feather="instagram"></i></a>
          <a href="#"><i data-feather="twitter"></i></a>
          <a href="#"><i data-feather="facebook"></i></a>
          <a href="#"><i data-feather="youtube"></i></a>
        </div>
      </div>

      <div class="footer-right">
        <h3>Pusat Donasi</h3>
        <p>
          Setiap donasi berarti. Dukungan dan kontribusi Anda mendukung upaya kami dalam memajukan
          pendidikan di Indonesia.
        </p>
        <a href="../php/donasi.php" class="cta">Donasi Sekarang</a>
      </div>

      <div class="credit">
        <p>
          Created by <a href="">Pemuda Bingung</a>. | &copy 2024 Pustaka Kita. All Rights
          Reserved.
        </p>
      </div>
    </footer>
    <!-- Footer End -->

    <!-- Feather Icons -->
    <script>
      feather.replace();
    </script>

    <!-- Javascript -->
    <script src="../js/script.js"></script>

  </body>
</html>
