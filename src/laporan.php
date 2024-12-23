<?php
function simpanLaporan($conn, $total_donasi) {
    // Mengambil total donasi
    $query_donasi = "SELECT SUM(jumlah_donasi) AS total_donasi, NOW() AS tanggal FROM donasi";
    $result_donasi = $conn->query($query_donasi);

    if ($result_donasi) {
        $data_donasi = $result_donasi->fetch_assoc();
        $tanggal = $data_donasi['tanggal'];

        if (!is_null($total_donasi) && !empty($tanggal)) {
            // Memasukkan data ke tabel laporan
            $query_laporan = "INSERT INTO laporan (total, tanggal_laporan, jenis_laporan) VALUES (?, ?, ?)";
            $stmt_laporan = $conn->prepare($query_laporan);
            $jenis_laporan = "donasi";
            $stmt_laporan->bind_param("iss", $total_donasi, $tanggal, $jenis_laporan);

            if ($stmt_laporan->execute()) {
                return true;
            } else {
                error_log("Gagal menyimpan laporan: " . $stmt_laporan->error);
                return false;
            }

            $stmt_laporan->close();
        } else {
            error_log("Data total donasi atau tanggal tidak valid.");
            return false;
        }
    } else {
        error_log("Gagal menghitung total donasi: " . $conn->error);
        return false;
    }
}
?>
