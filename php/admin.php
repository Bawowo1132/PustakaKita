<?php
 include('../php/koneksi.php');

 $donasi_query = "SELECT * FROM donasi";
 $donasi_result = $conn->query($donasi_query);
 
 // Query to get Feedback data
 $feedback_query = "SELECT * FROM feedback";
 $feedback_result = $conn->query($feedback_query);
 
 // Query to get Laporan data
 $laporan_query = "SELECT * FROM laporan";
 $laporan_result = $conn->query($laporan_query);

 $BeasiswaCendekia_query = "SELECT * FROM DaftarBeasiswa";
 $BeasiswaCendekia_result = $conn->query($BeasiswaCendekia_query);

 $BantuanSekolahCendekia_query = "SELECT * FROM bantuan_sekolah";
 $BantuanSekolahCendekia_result = $conn->query($BantuanSekolahCendekia_query);
 
 $pendaftaran_query = "SELECT * FROM pendaftaran_beasiswa";
 $pendaftaran_result = $conn->query($pendaftaran_query);
 
 
?>
 
 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrator</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/Admin.css" />
</head>

<body>

    <div class="container">
        <nav class="sidebar">
            <nav class="navbar">
                <a href="#" class="navbar-logo">Pustaka<span>Kita</span>.</a>
            </nav>
            <div class="sidebar-header">
                <input type="file" id="upload-profile" style="display: none;">
                <img src="https://tse4.mm.bing.net/th?id=OIP.SAcV4rjQCseubnk32USHigHaHx&pid=Api&P=0&h=180"
                    alt="Profile Picture" class="profile-picture" id="profile-picture">
                <h5>Dashboard</h5>
                <p>Administrator</p>
            </div>
            <ul>
                <li><a href="#beranda" class="menu-item">Beranda</a></li>
                <li>
                    <a href="#" class="menu-item">Donasi Pendidikan</a>
                    <ul class="submenu">
                        <li><a href="#data-donasi" class="menu-item"> Donasi</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="#" class="menu-item">Pendaftar</a>
                    <ul class="submenu">
                        <li><a href="#beasiswa-cendekia" class="menu-item">Beasiswa Cendekia</a></li>
                        <li><a href="#bantuan-sekolah" class="menu-item">Bantuan Sekolah Cendekia</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#status-pendaftaran" class="menu-item">Status Pendaftaran</a>
                </li>
                
                <li><a href="#feedback" class="menu-item">Feedback</a></li>
                <li><a href="#laporan" class="menu-item">Laporan</a></li>
            
                
            </ul>
        </nav>
        
        <main class="content">
            <section id="dashboard-firs">
            <header>
                <h2>Dashboard</h2>
                <button class="logout-button">Logout</button>
            </header>
            <div class="alert">Welcome admin ganteng.</div>
            </section>
            <section id="beranda" class="content-section">
                <h3>Selamat datang di Dashboard</h3>
                <div class="cards">
                    <div class="card">
                        <h5>Total Donasi</h5>
                        <p class="number">8</p>
                    </div>
                    <div class="card">
                        <h5>Total Transaksi</h5>
                        <p class="number">24</p>
                    </div>
                    <div class="card">
                        <h5>Feedback Masuk</h5>
                        <p class="number">2</p>
                    </div>
                </div>
            </section>

            <section id="data-donasi" class="content-section" style="display: none;">
                <h3>Data Donasi</h3>
                <!-- Diagram Statistik Donasi -->
    <div class="chart-container">
        <canvas id="donasiChart"></canvas>
    </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Donatur</th>
                            <th>No.Telepon</th>
                            <th>Total Donasi</th>
                            <th>Status Donasi</th>
                            <th>Tanggal</th>
                            <th>Metode Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($donasi_result->num_rows > 0) {
                            while ($row = $donasi_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['nama_lengkap'] . "</td>";
                                echo "<td>" . $row['nomor_hp'] . "</td>";
                                echo "<td>Rp " . number_format($row['jumlah_donasi'], 0, ',', '.') . "</td>";
                                echo "<td>" . ($row['status_donasi'] ? 'Sukses' : 'Pending') . "</td>";
                                echo "<td>" . $row['tanggal_donasi'] . "</td>";
                                echo "<td>" . $row['metode_pembayaran'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data donasi.</td></tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </section>

            <section id="beasiswa-cendekia" class="content-section" style="display: none;">
                <h3>Beasiswa Cendekia</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>ttl</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Sekolah</th>
                            <th>Alamat</th>
                            <th>Kelas</th>
                            <th>Nilai matematika</th>
                            <th>Nilai ipa</th>
                            <th>Nilai bindo</th>
                            <th>Nilai binggris</th>
                            <th>Alasan</th>
                            <th>Agama</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($BeasiswaCendekia_result->num_rows > 0) {
                        while($row = $BeasiswaCendekia_result->fetch_assoc()) {
                            // Menghitung nilai rapot (rata-rata)
                            $nilai_rapot = ($row['nilai_matematika'] + $row['nilai_ipa'] + $row['nilai_bindo'] + $row['nilai_binggris']) / 4;

                            echo "<tr>
                                    <td>" . $row['nama'] . "</td>
                                    <td>" . $row['ttl'] . "</td>
                                    <td>" . $row['nik'] . "</td>
                                    <td>" . $row['jenis_kelamin'] . "</td>
                                    <td>" . $row['asal_sekolah'] . "</td>
                                    <td>" . $row['alamat'] . "</td>
                                    <td>" . $row['kelas'] . "</td>
                                    <td>" . number_format($row['nilai_matematika'], 0, ',', '.') . "</td>
                                    <td>" . number_format($row['nilai_ipa'], 0, ',', '.') . "</td>
                                    <td>" . number_format($row['nilai_bindo'], 0, ',', '.') . "</td>
                                    <td>" . number_format($row['nilai_binggris'], 0, ',', '.') . "</td>
                                    <td>" . $row['alasan'] . "</td>
                                    <td>" . $row['agama'] . "</td>
                                    <td>" . $row['status'] . "</td>
                                </tr>";
                                    }
                                } else {
                                echo "<tr><td colspan='13'>No data found</td></tr>";
                                }
                        ?>
                    </tbody>
                </table>
            </section>
            
            <section id="bantuan-sekolah" class="content-section" style="display: none;">
                <h3>Bantuan Sekolah Cendekia</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nama Sekolah</th>
                            <th>Alamat</th>
                            <th>Kontak Telepon</th>
                            <th>Email</th>
                            <th>Perkiraan dana yang dibutuhkan</th>
                            <th>Tujuan Bantuan</th>
                            <th>Foto bukti kondisi Sekolah</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($BantuanSekolahCendekia_result->num_rows > 0) {
                        // Menampilkan data tiap baris
                        while($row = $BantuanSekolahCendekia_result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['nama_sekolah'] . "</td>
                                    <td>" . $row['nama_sekolah'] . "</td>
                                    <td>" . $row['alamat'] . "</td>
                                    <td>" . $row['kontak_telepon'] . "</td>
                                    <td>" . $row['email'] . "</td>
                                    <td>" . number_format($row['dana'], 0, ',', '.') . "</td>
                                    <td>" . $row['tujuan'] . "</td>
                                    <td><img src='" . $row['foto_bukti'] . "' width='100' height='100' alt='Foto Bukti'></td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada data yang ditemukan</td></tr>";
                    }
                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </section>

    <section id="status-pendaftaran" class="content-section">
    <h3>Status Pendaftaran Beasiswa</h3>
    <button id="add-penerima" class="logout-button">Tambah Penerima</button>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Pendaftar</th>
                <th>Program</th>
                <th>Status</th>
                <th>Sekolah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="pendaftaran-table">
           <?php
           include '../php/statuspendaftaran.php';
           ?>
        </tbody>
    </table>
</section>

<!-- Modal untuk Tambah/Edit Penerima (Hidden by default) -->
<div id="modal-penerima" style="display:none;">
    <h3>Tambah/Perbarui Penerima</h3>
    <form id="form-penerima">
        <input type="hidden" id="pendaftaran-id">
        <label for="nama-pendaftar">Nama Pendaftar:</label>
        <input type="text" id="nama-pendaftar" required><br><br>
        <label for="program-pendaftar">Program:</label>
        <select id="program-pendaftar" required>
            <option value="Beasiswa Cendekia">Beasiswa Cendekia</option>
            <option value="Bantuan Sekolah Cendekia">Bantuan Sekolah Cendekia</option>
        </select><br><br>
        <label for="status-pendaftar">Status:</label>
        <select id="status-pendaftar" required>
            <option value="Diterima">Diterima</option>
            <option value="Ditolak">Ditolak</option>
            <option value="Menunggu">Menunggu</option>
        </select><br><br>
        <label for="sekolah-pendaftar">Sekolah:</label>
        <input type="text" id="sekolah-pendaftar" required><br><br>
        <button type="submit">Simpan</button>
        <button type="button" id="cancel-penerima">Batal</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadData();

        // Event listener untuk tombol "Tambah Penerima"
        document.getElementById('add-penerima').addEventListener('click', function() {
            document.getElementById('modal-penerima').style.display = 'block';
        });

        // Event listener untuk tombol "Batal"
        document.getElementById('cancel-penerima').addEventListener('click', function() {
            document.getElementById('modal-penerima').style.display = 'none';
        });

        // Fungsi untuk mengambil data dari database dan menampilkannya di tabel
        function loadData() {
            fetch('statuspendaftaran.php?action=read')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('pendaftaran-table');
                    tableBody.innerHTML = ''; // Clear table before filling

                    data.forEach(pendaftar => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${pendaftar.nama_pendaftar}</td>
                            <td>${pendaftar.program}</td>
                            <td>${pendaftar.status}</td>
                            <td>${pendaftar.sekolah}</td>
                            <td>
                                <button class="edit-button" onclick="editData(${pendaftar.id})">Edit</button>
                                <button class="delete-button" onclick="deleteData(${pendaftar.id})">Delete</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                });
        }

        // Fungsi untuk menyimpan data (tambah atau perbarui)
        document.getElementById('form-penerima').addEventListener('submit', function(event) {
            event.preventDefault();

            const id = document.getElementById('pendaftaran-id').value;
            const namaPendaftar = document.getElementById('nama-pendaftar').value;
            const program = document.getElementById('program-pendaftar').value;
            const status = document.getElementById('status-pendaftar').value;
            const sekolah = document.getElementById('sekolah-pendaftar').value;

            fetch('statuspendaftaran.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: id ? 'update' : 'create',
                    id,
                    data: { nama_pendaftar: namaPendaftar, program, status, sekolah }
                })
            })
            .then(response => response.text())
            .then(result => {
                if (result === 'success') {
                    loadData(); // Refresh the data
                    document.getElementById('modal-penerima').style.display = 'none';
                } else {
                    alert('Gagal menyimpan data.');
                }
            });
        });

        // Fungsi untuk mengedit data
        window.editData = function(id) {
            fetch('statuspendaftaran.php?action=edit&id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('pendaftaran-id').value = data.id;
                    document.getElementById('nama-pendaftar').value = data.nama_pendaftar;
                    document.getElementById('program-pendaftar').value = data.program;
                    document.getElementById('status-pendaftar').value = data.status;
                    document.getElementById('sekolah-pendaftar').value = data.sekolah;
                    document.getElementById('modal-penerima').style.display = 'block';
                });
        };

        // Fungsi untuk menghapus data
        window.deleteData = function(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                fetch('statuspendaftaran.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'delete', id })
                })
                .then(response => response.text())
                .then(result => {
                    if (result === 'success') {
                        loadData();
                    } else {
                        alert('Gagal menghapus data.');
                    }
                });
            }
        };
    });
</script>    


<script src="../js/admin.js"></script>
<script src="../js/statuspendaftaran.js"></script>

</body>

</html>