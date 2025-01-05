<?php
require '../../vendor/autoload.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

function tambahLaporanDenganHTML($conn, $judul_laporan, $tanggal_laporan, $jenis_laporan, $jumlah_biaya) {

    

    // Nama folder tempat menyimpan PDF
    $folder = "uploads/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // Nama file PDF
    $file_name = $folder . uniqid() . ".pdf";

    // Buat HTML untuk laporan
    $html = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            h1 { text-align: center; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
        </style>
    </head>
    <body>
        <h1>Laporan</h1>
        <p><strong>Judul Laporan:</strong> $judul_laporan</p>
        <p><strong>Tanggal Laporan:</strong> $tanggal_laporan</p>
        <p><strong>Jenis Laporan:</strong> $jenis_laporan</p>
        <p><strong>Jumlah Biaya:</strong> Rp" . number_format($jumlah_biaya, 0, ',', '.') . "</p>
    </body>
    </html>";

    // Konversi HTML menjadi PDF menggunakan Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Simpan PDF ke server
    file_put_contents($file_name, $dompdf->output());

    // Simpan data ke database
    $sql = "INSERT INTO laporan (judul_laporan, tanggal_laporan, jenis_laporan, link, jumlah_biaya) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Kesalahan dalam menyiapkan statement: " . $conn->error);
    }

    // Mengikat parameter
    $stmt->bind_param("ssssi", $judul_laporan, $tanggal_laporan, $jenis_laporan, $file_name, $jumlah_biaya);

    // Menjalankan statement
    if ($stmt->execute()) {
        echo "<script>alert('Laporan berhasil ditambahkan dengan PDF!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $stmt->error . "');</script>";
    }

    // Menutup statement
    $stmt->close();
}
