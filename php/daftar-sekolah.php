<?php
include '../php/koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nama_sekolah = $_POST['nama_sekolah'];
    $alamat = $_POST['alamat'];
    $kontak_telepon = $_POST['kontak_telepon'];
    $email = $_POST['email'];
    $dana = (int)$_POST['dana']; // Pastikan tipe data sesuai
    $tujuan = $_POST['tujuan'];

    // Mengupload foto bukti
    $foto_bukti = $_FILES['foto_bukti']['name'];
    $foto_bukti_tmp = $_FILES['foto_bukti']['tmp_name'];
    $upload_dir = __DIR__ . "/uploads/";

    // Pastikan direktori upload ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $foto_bukti_path = $upload_dir . basename($foto_bukti);

    // Validasi apakah file gambar valid
    if (move_uploaded_file($foto_bukti_tmp, $foto_bukti_path)) {
        // Query untuk menyimpan data ke dalam database
        $sql = "INSERT INTO daftar_sekolah (nama_sekolah, alamat, kontak_telepon, email, dana, tujuan, foto_bukti)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssiss",
            $nama_sekolah,
            $alamat,
            $kontak_telepon,
            $email,
            $dana,
            $tujuan,
            $foto_bukti
        );

        if ($stmt->execute()) {
            echo "<script>alert('Pendaftaran berhasil!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Upload foto gagal. Pastikan file valid dan ukuran tidak terlalu besar.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Bantuan Sekolah</title>
    <style>
        /* Reset untuk body */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            /* Warna background putih */
            color: #000;
            /* Warna teks hitam */
            margin: 0;
            padding: 0;
        }

        /* Gaya untuk heading */
        h1 {
            text-align: center;
            font-size: 28px;
            margin: 20px 0;
            color: #333;
        }

        /* Styling form container */
        form {
            max-width: 600px;
            margin: 0 auto;
            /* Pusatkan form */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            /* Warna latar belakang form */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Bayangan */
        }

        /* Label */
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #444;
            /* Warna teks label */
        }

        /* Input dan Textarea */
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            /* Textarea dapat diubah ukuran secara vertikal */
        }

        /* Fokus pada input */
        input:focus,
        textarea:focus {
            border-color: #000;
            /* Hitam */
            outline: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        /* Tombol */
        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #000;
            /* Hitam */
            color: #fff;
            /* Putih */
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #444;
            /* Hitam lebih terang */
        }

        /* Responsif */
        @media (max-width: 768px) {
            form {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            button[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <h1>Form Bantuan Sekolah Cendekia</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nama_sekolah">Nama Sekolah:</label>
        <input type="text" id="nama_sekolah" name="nama_sekolah" required><br>

        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" rows="4" required></textarea><br>

        <label for="kontak_telepon">Kontak Telepon:</label>
        <input type="tel" id="kontak_telepon" name="kontak_telepon" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="dana">Perkiraan Dana Yang Dibutuhkan:</label>
        <input type="number" id="dana" name="dana" min="0" required><br>

        <label for="tujuan">Tujuan Bantuan:</label>
        <textarea id="tujuan" name="tujuan" rows="4" required></textarea><br>

        <label for="foto_bukti">Foto Bukti Kondisi Sekolah:</label>
        <input type="file" id="foto_bukti" name="foto_bukti" accept="image/*" required><br>

        <button type="submit">Kirim</button>
    </form>

</body>

</html>