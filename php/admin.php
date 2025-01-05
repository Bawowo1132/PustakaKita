<?php
include('../php/koneksi.php');


$donasi_query = "SELECT * FROM donasi";
$donasi_result = $conn->query($donasi_query);

// Query to get Laporan data
$laporan_query = "SELECT * FROM laporan";
$laporan_result = $conn->query($laporan_query);

$BeasiswaCendekia_query = "SELECT * FROM daftar_beasiswa";
$BeasiswaCendekia_result = $conn->query($BeasiswaCendekia_query);

$BantuanSekolahCendekia_query = "SELECT * FROM daftar_sekolah";
$BantuanSekolahCendekia_result = $conn->query($BantuanSekolahCendekia_query);

$pendaftaran_query = "SELECT * FROM status_pendaftaran";
$pendaftaran_result = $conn->query($pendaftaran_query);

$feedback_query = "SELECT * FROM feedbacks";
$feedback_result = $conn->query($feedback_query);

// Query untuk menghitung jumlah transaksi (donasi) yang ada
$queryDonasi = "SELECT SUM(jumlah_donasi) AS total_donasi FROM donasi";
$resultDonasi = $conn->query($queryDonasi);



if ($resultDonasi->num_rows > 0) {
    $row = $resultDonasi->fetch_assoc();
    $donasiCount = $row['total_donasi'];
} else {
    $donasiCount = 0;
}

// Query untuk menghitung total transaksi (donasi) yang ada
$queryTransaksi = "SELECT COUNT(id) AS total_transaksi FROM donasi";
$resultTransaksi = $conn->query($queryTransaksi);

if ($resultTransaksi->num_rows > 0) {
    $row = $resultTransaksi->fetch_assoc();
    $transaksiCount = $row['total_transaksi'];
} else {
    $transaksiCount = 0;
}

// Query untuk menghitung jumlah feedback
$queryFeedback = "SELECT COUNT(id) AS total_feedback FROM feedbacks";
$resultFeedback = $conn->query($queryFeedback);

if ($resultFeedback->num_rows > 0) {
    $row = $resultFeedback->fetch_assoc();
    $feedbackCount = $row['total_feedback'];
} else {
    $feedbackCount = 0;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pustaka Kita</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/admin.css" />
</head>

<body>

    <div class="container">
        <nav class="navbar">
            <a href="" class="navbar-logo">Pustaka<span>Kita</span>.</a>
        </nav>

        <nav class="sidebar">
            <div class="sidebar-header">
                <input type="file" id="upload-profile" style="display: none;">
                <img src="https://tse4.mm.bing.net/th?id=OIP.SAcV4rjQCseubnk32USHigHaHx&pid=Api&P=0&h=180"
                    alt="Profile Picture" class="profile-picture" id="profile-picture">
                <h4>Administrator</h4>

            </div>
            <ul>
                <li>
                    <a href="#beranda" class="menu-item">Beranda</a>
                </li>
                <li>
                    <a href="" class="menu-item">Donasi Pendidikan</a>
                    <ul class="submenu">
                        <li><a href="#data-donasi" class="menu-item">Data Donasi</a></li>
                    </ul>
                </li>

                <li>
                    <a href="" class="menu-item">Pendaftar</a>
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
            <section id="dashboard-first">
                <header>
                    <h2>Dashboard</h2>
                    <button class="logout-button">Logout</button>
                </header>
                <div class="alert">Selamat Bekerja Admin Ganteng, Bersemangatlah Demi Pendidikan Indonesia Maju! </div>
            </section>
            <section id="beranda" class="content-section">
                <h3>Selamat Datang di Beranda</h3>
                <div class="cards">
                    <div class="card">
                        <h5>Total Donasi</h5>
                        <p class="number"><?php echo $donasiCount; ?></p>
                    </div>
                    <div class="card">
                        <h5>Total Transaksi</h5>
                        <p class="number"><?php echo $transaksiCount; ?></p>
                    </div>
                    <div class="card">
                        <h5>Feedback Masuk</h5>
                        <p class="number"><?php echo $feedbackCount; ?></p>
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
                            <th>TTL</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Sekolah</th>
                            <th>Alamat</th>
                            <th>Kelas</th>
                            <th>Nilai Matematika</th>
                            <th>Nilai IPA</th>
                            <th>Nilai B. Indo</th>
                            <th>Nilai B. Inggris</th>
                            <th>Alasan</th>
                            <th>Agama</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($BeasiswaCendekia_result->num_rows > 0) {
                            while ($row = $BeasiswaCendekia_result->fetch_assoc()) {
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
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Perkiraan Dana Yang Dibutuhkan</th>
                            <th>Tujuan Bantuan</th>
                            <th>Foto Bukti Kondisi Sekolah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($BantuanSekolahCendekia_result->num_rows > 0) {
                            // Menampilkan data tiap baris
                            while ($row = $BantuanSekolahCendekia_result->fetch_assoc()) {
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
                        ?>
                    </tbody>
                </table>
            </section>

            <section id="status-pendaftaran" class="content-section">
                <h3>Status Pendaftaran</h3>
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
                    <?php
                    require_once "crud_status_pendaftaran.php";

                    // Ambil semua data pendaftaran
                    $dataPendaftaran = readAllPendaftaran();
                    ?>
                    <tbody id="pendaftaran-table">
                        <?php if (!empty($dataPendaftaran)): ?>
                            <?php foreach ($dataPendaftaran as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['nama_pendaftar']); ?></td>
                                    <td><?php echo htmlspecialchars($row['program']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td><?php echo htmlspecialchars($row['sekolah']); ?></td>
                                    <td>
                                        <button class="edit-button" data-id="<?php echo htmlspecialchars($row['id']); ?>">Edit</button>
                                        <form action="statuspendaftaran.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">Tidak ada data yang tersedia</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

            <?php $editData = null; ?>
            <!-- Modal untuk Tambah/Edit Penerima (Hidden by default) -->
            <div id="modal-penerima" style="display:none;">
                <h3>Tambah/Perbarui Penerima</h3>
                <form id="form-penerima" method="POST" class="mb-4" action="statuspendaftaran.php">
                    <input type="hidden" name="action" class="action" value="create">
                    <input type="hidden" name="id" class="id" value="">

                    <label for="nama-pendaftar">Nama Pendaftar:</label>
                    <input type="text" id="nama-pendaftar" name="nama_pendaftar"
                        value="" required class="nama-pendaftar"><br><br>

                    <label for="program-pendaftar">Program:</label>
                    <select id="program-pendaftar" name="program" class="program-pendaftar" required>
                        <option value="Beasiswa Cendekia">Beasiswa Cendekia</option>
                        <option value="Bantuan Sekolah Cendekia">Bantuan Sekolah Cendekia</option>
                    </select><br><br>

                    <label for="status-pendaftar">Status:</label>
                    <select id="status-pendaftar" name="status" required>
                        <option value="Menunggu">Pending</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak</option>
                    </select><br><br>

                    <label for="sekolah-pendaftar">Sekolah:</label>
                    <input type="text" id="sekolah-pendaftar" name="sekolah"
                        value="" required><br><br>

                    <!-- Tombol Submit/Update -->
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>

                    <!-- Tombol Batal -->

                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('modal-penerima').style.display='none';">Batal</button>
                </form>
            </div>

            <section id="feedback" class="content-section" style="display: none;">
                <h3>Feedback</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Pengirim</th>
                            <th>No.Telepon</th>
                            <th>Email</th>
                            <th>Pesan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody id="feedback-table">
                        <?php
                        if ($feedback_result->num_rows > 0) {
                            while ($row = $feedback_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['telepon']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['pesan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No feedback available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <section id="laporan" class="content-section" style="display: none">
                <h3>Laporan</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul Laporan</th>
                            <th>Tanggal Laporan</th>
                            <th>Jenis Laporan</th>
                            <th>Jumlah Biaya</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody id="laporan-table">
                    <?php 
                    // Query untuk laporan yang ada
                    $queryLaporan = "SELECT * FROM laporan";
                    $resultLaporan = $conn->query($queryLaporan);
                    
                    while ($row = $resultLaporan->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['judul_laporan']; ?></td>
                        <td><?php echo $row['tanggal_laporan']; ?></td>
                        <td><?php echo $row['jenis_laporan']; ?></td>
                        <td>Rp<?php echo number_format($row['jumlah_biaya'], 0, ',', '.'); ?></td>
                        <td><a href="<?php echo $row['link']; ?>">Download PDF</a></td>
                    </tr>
                <?php endwhile; ?>
                    </tbody>
                </table>
            </section>




            <script>
                document.querySelector('#pendaftaran-table').addEventListener('click', function(event) {
                    if (event.target.classList.contains('edit-button')) {
                        const id = event.target.getAttribute('data-id'); // Mendapatkan ID dari tombol yang diklik
                        fetchEditData(id); // Panggil fungsi untuk mengambil data
                    }
                });

                function fetchEditData(id) {
                    // Mengambil data pendaftaran berdasarkan ID
                    fetch('statuspendaftaran.php?action=edit&id=' + id)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.status !== 'error') {
                                // Mengisi data ke dalam form di modal
                                document.getElementById('nama-pendaftar').value = data.nama_pendaftar;
                                document.getElementById('program-pendaftar').value = data.program;
                                document.getElementById('status-pendaftar').value = data.status;
                                document.getElementById('sekolah-pendaftar').value = data.sekolah;

                                // Set action ke 'update' dan ID untuk form submission
                                document.querySelector('.action').value = 'update';
                                document.querySelector('.id').value = data.id;

                                // Menampilkan modal untuk edit
                                document.getElementById('modal-penerima').style.display = 'block';
                            } else {
                                alert('Data tidak ditemukan');
                            }
                        })
                        .catch(error => {
                            alert('Terjadi kesalahan: ' + error);
                        });
                }



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
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    action: id ? 'update' : 'create',
                                    id,
                                    data: {
                                        nama_pendaftar: namaPendaftar,
                                        program,
                                        status,
                                        sekolah
                                    }
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
                            })
                            .catch(error => {
                                alert('Gagal mengambil data: ' + error);
                            });
                    };
                    console.log("testr");





                    // Fungsi untuk menghapus data
                    window.deleteData = function(id) {
                        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                            fetch('statuspendaftaran.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        action: 'delete',
                                        id
                                    })
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
        </main>
    </div>
    <script src="../js/admin.js"></script>



</body>

</html>