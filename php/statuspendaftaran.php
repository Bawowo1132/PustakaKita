<?php
require_once "crud_status_pendaftaran.php";

// Inisialisasi variabel untuk pesan
$error = '';
$success = '';


// Tangani permintaan GET untuk mengambil data berdasarkan ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $editData = readPendaftaranById($id);
    if ($editData) {
        echo json_encode($editData);  // Mengembalikan data dalam format JSON
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        exit;
    }
}



// Tangani permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    // var_dump($action);
    // Validasi action
    if (!$action || !in_array($action, ['create', 'update', 'delete'])) {
        $error = "Aksi tidak valid.";
    } else {
        try {
            switch ($action) {
                case 'create':
                    // Validasi input
                    if (!empty($_POST['nama_pendaftar']) && !empty($_POST['program']) && !empty($_POST['status']) && !empty($_POST['sekolah'])) {
                        // Panggil fungsi create
                        $result = createPendaftaran(
                            $_POST['nama_pendaftar'],
                            $_POST['program'],
                            $_POST['status'],
                            $_POST['sekolah']
                        );
                        $success = $result ? "Data berhasil ditambahkan." : "Gagal menambahkan data.";
                    } else {
                        $error = "Semua field harus diisi.";
                    }
                    break;

                case 'update':
                    // Validasi input
                    if (!empty($_POST['id']) && !empty($_POST['nama_pendaftar']) && !empty($_POST['program']) && !empty($_POST['status']) && !empty($_POST['sekolah'])) {
                        // Panggil fungsi update
                        $result = updatePendaftaran(
                            $_POST['id'],
                            $_POST['nama_pendaftar'],
                            $_POST['program'],
                            $_POST['status'],
                            $_POST['sekolah']
                        );
                        $success = $result ? "Data berhasil diperbarui." : "Gagal memperbarui data.";
                    } else {
                        $error = "Semua field harus diisi.";
                    }
                    break;

                case 'delete':
                    // Validasi input
                    if (!empty($_POST['id'])) {
                        // Panggil fungsi delete
                        $result = deletePendaftaran($_POST['id']);
                        $success = $result ? "Data berhasil dihapus." : "Gagal menghapus data.";
                    } else {
                        $error = "ID tidak valid.";
                    }
                    break;
            }
        } catch (Exception $e) {
            $error = "Terjadi kesalahan: " . $e->getMessage();
        }
    }
}




if ($error) {
    echo "<script>alert('$error'); window.location.href = 'admin.php';</script>";
    exit; // Hentikan eksekusi lebih lanjut setelah redirect
}

if ($success) {
    echo "<script>alert('$success'); window.location.href = 'admin.php';</script>";
    exit; // Hentikan eksekusi lebih lanjut setelah redirect
}
