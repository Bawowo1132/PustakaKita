<?php
try {
    $servername = "localhost:3036";
    $username = "username";
    $password = "";
    $dbname = "Pustakakita"; // Replace with your actual database name

    // Create a PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception

    // Get action from request
    $action = $_GET['action'] ?? $_POST['action'] ?? null;
    
    if (!$action) {
        echo 'Invalid action';
        exit;
    }

    // Action for creating data
    if ($action == 'create') {
        // Mendapatkan data dari body request
        $data = json_decode(file_get_contents("php://input"), true);
        $namaPendaftar = $data['data']['nama_pendaftar'];
        $program = $data['data']['program'];
        $status = $data['data']['status'];
        $sekolah = $data['data']['sekolah'];

        // Validasi input
        if (empty($namaPendaftar) || empty($program) || empty($status) || empty($sekolah)) {
            echo 'Gagal, data tidak lengkap.';
            exit;
        }

        // Menyiapkan query untuk insert data
        $stmt = $pdo->prepare("INSERT INTO pendaftaran_beasiswa (nama_pendaftar, program, status, sekolah) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$namaPendaftar, $program, $status, $sekolah])) {
            echo 'success'; // Jika berhasil
        } else {
            echo 'Gagal menyimpan data.'; // Jika gagal
        }
    }

    // Action for reading data
    if ($action == 'read') {
        $stmt = $pdo->query("SELECT * FROM pendaftaran_beasiswa");
        $pendaftaran = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($pendaftaran);
    }

    // Action for editing data
    if ($action == 'edit') {
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM pendaftaran_beasiswa WHERE id = ?");
        $stmt->execute([$id]);
        $pendaftaran = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($pendaftaran);
    }

    // Action for updating data
    if ($action == 'update') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $namaPendaftar = $data['data']['nama_pendaftar'];
        $program = $data['data']['program'];
        $status = $data['data']['status'];
        $sekolah = $data['data']['sekolah'];

        $stmt = $pdo->prepare("UPDATE pendaftaran_beasiswa SET nama_pendaftar = ?, program = ?, status = ?, sekolah = ? WHERE id = ?");
        if ($stmt->execute([$namaPendaftar, $program, $status, $sekolah, $id])) {
            echo 'success';
        } else {
            echo 'Gagal memperbarui data.';
        }
    }

    // Action for deleting data
    if ($action == 'delete') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $stmt = $pdo->prepare("DELETE FROM pendaftaran_beasiswa WHERE id = ?");
        if ($stmt->execute([$id])) {
            echo 'success';
        } else {
            echo 'Gagal menghapus data.';
        }
    }

} catch (PDOException $e) {
    // Catch any errors and display them
    echo "Error: " . $e->getMessage();
}
?>