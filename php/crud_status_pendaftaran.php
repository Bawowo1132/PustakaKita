<?php
require_once "koneksi.php";

// Fungsi untuk membaca semua data pendaftaran
function readAllPendaftaran()
{
    global $conn;
    try {
        $result = $conn->query("SELECT * FROM status_pendaftaran");
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } catch (Exception $e) {
        error_log("Error in readAllPendaftaran: " . $e->getMessage());
        return [];
    }
}

// Fungsi untuk membaca data pendaftaran berdasarkan ID
function readPendaftaranById($id)
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM status_pendaftaran WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        error_log("Error in readPendaftaranById: " . $e->getMessage());
        return null;
    }
}

// Fungsi untuk membuat data pendaftaran baru
function createPendaftaran($namaPendaftar, $program, $status, $sekolah)
{
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO status_pendaftaran (nama_pendaftar, program, status, sekolah) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $namaPendaftar, $program, $status, $sekolah);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Error in createPendaftaran: " . $e->getMessage());
        var_dump($e);
        return false;
    }
}

// Fungsi untuk memperbarui data pendaftaran
function updatePendaftaran($id, $namaPendaftar, $program, $status, $sekolah)
{
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE status_pendaftaran SET nama_pendaftar = ?, program = ?, status = ?, sekolah = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $namaPendaftar, $program, $status, $sekolah, $id);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Error in updatePendaftaran: " . $e->getMessage());
        return false;
    }
}

// Fungsi untuk menghapus data pendaftaran
function deletePendaftaran($id)
{
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM status_pendaftaran WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Error in deletePendaftaran: " . $e->getMessage());
        return false;
    }
}
