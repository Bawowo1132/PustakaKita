CREATE DATABASE PustakaKita;

USE PustakaKita;


-- Table for Feedback
CREATE TABLE feedbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telepon VARCHAR(15) NOT NULL,
    pesan TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Table for Daftar Beasiswa
CREATE TABLE daftar_beasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    ttl VARCHAR(100) NOT NULL,
    nik VARCHAR(16) NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    asal_sekolah VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    kelas VARCHAR(10) NOT NULL,
    nilai_matematika TINYINT UNSIGNED NOT NULL,
    nilai_ipa TINYINT UNSIGNED NOT NULL,
    nilai_bindo TINYINT UNSIGNED NOT NULL,
    nilai_binggris TINYINT UNSIGNED NOT NULL,
    alasan TEXT NOT NULL,
    agama ENUM('Islam', 'Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu') NOT NULL,
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    

-- Table for Donasi
CREATE TABLE donasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    nomor_hp VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    jumlah_donasi INT NOT NULL,
    metode_pembayaran ENUM('QRIS', 'Bank Transfer') NOT NULL,
    tanggal_donasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_donasi ENUM('Completed') NOT NULL
);

-- Table for Daftar Sekolah
CREATE TABLE daftar_sekolah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_sekolah VARCHAR(255) NOT NULL,
    alamat TEXT NOT NULL,
    kontak_telepon VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    dana INT UNSIGNED NOT NULL,
    tujuan TEXT NOT NULL,
    foto_bukti VARCHAR(255) NOT NULL,
    tanggal_pengajuan TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Status Pendaftaran
CREATE TABLE status_pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pendaftar VARCHAR(100) NOT NULL,
    program VARCHAR(100) NOT NULL,
    status ENUM('Diterima', 'Ditolak', 'Menunggu') NOT NULL,
    sekolah VARCHAR(100) NOT NULL
);

-- Table for Laporan
CREATE TABLE laporan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul_laporan VARCHAR(255) NOT NULL,
    tanggal_laporan DATE NOT NULL,
    jenis_laporan VARCHAR(255) NOT NULL,
    link VARCHAR(255) NOT NULL
);


-- INSERT INTO pendaftaran_beasiswa (nama_pendaftar, program, status, sekolah)
-- VALUES
-- ('John Doe', 'Beasiswa Cendekia', 'Diterima', 'SMK Cendekia'),
-- ('Jane Smith', 'Bantuan Sekolah Cendekia', 'Menunggu', 'SMA Cendekia'),
-- ('Michael Johnson', 'Beasiswa Cendekia', 'Ditolak', 'SMA Terpadu');

-- Insert a User
INSERT INTO users (email, password) VALUES
('pemuda@gmail.com', '12345');