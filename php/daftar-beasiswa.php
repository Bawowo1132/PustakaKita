<?php
include('../php/koneksi.php');
// Periksa apakah form sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $ttl = $_POST['ttl'];
    $nik = $_POST['nik'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $asal_sekolah = $_POST['asal_sekolah'];
    $alamat = $_POST['alamat'];
    $kelas = $_POST['kelas'];
    $nilai_matematika = $_POST['nilai_matematika'];
    $nilai_ipa = $_POST['nilai_ipa'];
    $nilai_bindo = $_POST['nilai_bindo'];
    $nilai_binggris = $_POST['nilai_binggris'];
    $alasan = $_POST['alasan'];
    $agama = $_POST['agama'];

    // Query untuk memasukkan data
    $sql = "INSERT INTO daftar_beasiswa
            (nama, ttl, nik, jenis_kelamin, asal_sekolah, alamat, kelas, 
            nilai_matematika, nilai_ipa, nilai_bindo, nilai_binggris, alasan, agama) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssiiisss",
        $nama,
        $ttl,
        $nik,
        $jenis_kelamin,
        $asal_sekolah,
        $alamat,
        $kelas,
        $nilai_matematika,
        $nilai_ipa,
        $nilai_bindo,
        $nilai_binggris,
        $alasan,
        $agama
    );

    if ($stmt->execute()) {
        echo "<script>alert('Pendaftaran berhasil!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Beasiswa Cendekia</title>
</head>
<style>
    /* Gaya Umum */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
        color: #2c3e50;
        font-size: 24px;
    }

    form {
        background-color: #fff;
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    }

    fieldset {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    legend {
        font-weight: bold;
        color: #2c3e50;
        font-size: 16px;
    }

    button {
        background-color: #000000;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        display: block;
        margin: 0 auto;
    }

    button:hover {
        background-color: #218c53;
    }

    textarea {
        resize: none;
    }

    /* Responsif */
    @media (max-width: 768px) {
        form {
            width: 90%;
            padding: 15px;
        }

        input,
        select,
        textarea {
            font-size: 12px;
        }

        h1 {
            font-size: 20px;
        }
    }
</style>

<body>
    <h1>Form Pendaftaran Beasiswa Cendekia</h1>
    <form action="#" method="POST">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="ttl">Tempat, Tgl Lahir:</label>
        <input type="text" id="ttl" name="ttl" required><br><br>

        <label for="nik">NIK:</label>
        <input type="text" id="nik" name="nik" required><br><br>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="">Pilih</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br><br>

        <label for="asal_sekolah">Asal Sekolah:</label>
        <input type="text" id="asal_sekolah" name="asal_sekolah" required><br><br>

        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" rows="4" required></textarea><br><br>

        <label for="kelas">Kelas:</label>
        <input type="text" id="kelas" name="kelas" required><br><br>

        <fieldset>
            <legend>Nilai Raport</legend>
            <label for="matematika">Matematika:</label>
            <input type="number" id="matematika" name="nilai_matematika" min="0" max="100" required><br><br>

            <label for="ipa">IPA:</label>
            <input type="number" id="ipa" name="nilai_ipa" min="0" max="100" required><br><br>

            <label for="bindo">Bahasa Indonesia:</label>
            <input type="number" id="bindo" name="nilai_bindo" min="0" max="100" required><br><br>

            <label for="binggris">Bahasa Inggris:</label>
            <input type="number" id="binggris" name="nilai_binggris" min="0" max="100" required><br><br>
        </fieldset>

        <label for="alasan">Alasan Mengikuti Beasiswa Cendekia:</label>
        <textarea id="alasan" name="alasan" rows="4" required></textarea><br><br>

        <label for="agama">Agama:</label>
        <select id="agama" name="agama" required>
            <option value="">Pilih</option>
            <option value="Islam">Islam</option>
            <option value="Protestan">Protestan</option>
            <option value="Katolik">Katolik</option>
            <option value="Hindu">Hindu</option>
            <option value="Buddha">Buddha</option>
            <option value="Konghucu">Konghucu</option>
        </select><br><br>

        <button type="submit">Kirim</button>
    </form>

    <script src="../js/daftar.js"></script>
</body>

</html>