// JavaScript for Handling Section Visibility and Form Modal
const menuItems = document.querySelectorAll(".menu-item");
const sections = document.querySelectorAll(".content-section");
const modal = document.getElementById("modal");
const cancelButton = document.getElementById("cancel-button");

menuItems.forEach((item) => {
  item.addEventListener("click", (e) => {
    sections.forEach((section) => {
      section.style.display = "none";
    });
    const targetSection = document.querySelector(e.target.getAttribute("href"));
    if (targetSection) {
      targetSection.style.display = "block";
    }
  });
});

document.querySelector(".logout-button").addEventListener("click", () => {
  window.location.href = "../php/login.php";
});

const profilePicture = document.getElementById("profile-picture");
const uploadProfile = document.getElementById("upload-profile");

profilePicture.addEventListener("click", () => {
  uploadProfile.click();
});

uploadProfile.addEventListener("change", (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      profilePicture.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});

const addPenerimaButton = document.getElementById("add-penerima");
const modalPenerima = document.getElementById("modal-penerima");
const cancelPenerimaButton = document.getElementById("cancel-penerima");
const formPenerima = document.getElementById("form-penerima");
const pendaftaranTable = document.getElementById("pendaftaran-table");

// Tampilkan modal
addPenerimaButton.addEventListener("click", () => {
  modalPenerima.style.display = "block";
});

// Sembunyikan modal
cancelPenerimaButton.addEventListener("click", () => {
  modalPenerima.style.display = "none";
});

let editingRowIndex = null; // Gunakan untuk melacak indeks baris yang sedang diedit

// Fungsi untuk mendapatkan data dari formulir
function getFormData() {
  return {
    nama: document.getElementById("nama-pendaftar").value,
    program: document.getElementById("program-pendaftar").value,
    status: document.getElementById("status-pendaftar").value,
    sekolah: document.getElementById("sekolah-pendaftar").value,
  };
}

// Fungsi untuk mengisi formulir dari data tabel
function setFormData(data) {
  document.getElementById("nama-pendaftar").value = data.nama;
  document.getElementById("program-pendaftar").value = data.program;
  document.getElementById("status-pendaftar").value = data.status;
  document.getElementById("sekolah-pendaftar").value = data.sekolah;
}

// Tambah atau perbarui data saat formulir disubmit
formPenerima.addEventListener("submit", (e) => {
  e.preventDefault();

  const data = getFormData();

  if (editingRowIndex !== null) {
    // Edit data pada baris yang sedang diedit
    const rows = Array.from(pendaftaranTable.rows);
    const row = rows[editingRowIndex];
    row.cells[0].textContent = data.nama;
    row.cells[1].textContent = data.program;
    row.cells[2].textContent = data.status;
    row.cells[3].textContent = data.sekolah;

    console.log(`Baris ke-${editingRowIndex} diperbarui`);
    editingRowIndex = null; // Reset editingRowIndex
  } else {
    // Tambah baris baru
    const newRow = document.createElement("tr");
    newRow.innerHTML = `
            <td>${data.nama}</td>
            <td>${data.program}</td>
            <td>${data.status}</td>
            <td>${data.sekolah}</td>
            <td>
                <button class="edit-button">Edit</button>
                <button class="delete-button">Delete</button>
            </td>
        `;
    pendaftaranTable.appendChild(newRow);

    console.log("Baris baru ditambahkan");
  }

  modalPenerima.style.display = "none"; // Tutup modal
  formPenerima.reset(); // Reset formulir
});

// Delegasi klik untuk tombol Edit dan Delete
pendaftaranTable.addEventListener("click", (e) => {
  if (e.target.classList.contains("delete-button")) {
    e.target.closest("tr").remove();
    console.log("Baris dihapus");
  } else if (e.target.classList.contains("edit-button")) {
    const row = e.target.closest("tr");
    const rows = Array.from(pendaftaranTable.rows);

    editingRowIndex = rows.indexOf(row); // Simpan indeks baris yang sedang diedit
    const data = {
      nama: row.cells[0].textContent,
      program: row.cells[1].textContent,
      status: row.cells[2].textContent,
      sekolah: row.cells[3].textContent,
    };

    setFormData(data); // Isi formulir dengan data baris yang dipilih
    modalPenerima.style.display = "block"; // Tampilkan modal

    console.log(`Edit baris ke-${editingRowIndex}`);
  }
});

// Tampilkan modal untuk tambah penerima
addPenerimaButton.addEventListener("click", () => {
  editingRowIndex = null; // Pastikan tidak sedang mengedit
  formPenerima.reset(); // Reset formulir
  modalPenerima.style.display = "block"; // Tampilkan modal
});

// Delegasi klik untuk tombol Edit dan Delete
pendaftaranTable.addEventListener("click", (e) => {
  if (e.target.classList.contains("delete-button")) {
    e.target.closest("tr").remove();
    console.log("Baris dihapus");
  } else if (e.target.classList.contains("edit-button")) {
    const row = e.target.closest("tr");
    const rows = Array.from(pendaftaranTable.rows);

    editingRowIndex = rows.indexOf(row); // Simpan indeks baris yang sedang diedit
    const data = {
      nama: row.cells[0].textContent,
      program: row.cells[1].textContent,
      status: row.cells[2].textContent,
      sekolah: row.cells[3].textContent,
    };

    setFormData(data); // Isi formulir dengan data baris yang dipilih
    modalPenerima.style.display = "block"; // Tampilkan modal

    console.log(`Edit baris ke-${editingRowIndex}`);
  }
});

// Tampilkan modal untuk tambah penerima
addPenerimaButton.addEventListener("click", () => {
  editingRowIndex = null; // Pastikan tidak sedang mengedit
  formPenerima.reset(); // Reset formulir
  modalPenerima.style.display = "block"; // Tampilkan modal
});

// Tangani semua tombol "Kirim" pada kolom Balasan
document.addEventListener("click", function (event) {
  if (event.target.classList.contains("send-reply-button")) {
    // Temukan elemen baris (tr) dari tombol yang ditekan
    const row = event.target.closest("tr");

    // Ambil teks balasan dari textarea di dalam baris
    const replyTextarea = row.querySelector("textarea");
    const replyMessage = replyTextarea.value.trim();

    if (!replyMessage) {
      alert("Pesan balasan tidak boleh kosong.");
      return;
    }

    // Tambahkan balasan ke kolom Balasan dan tampilkan
    const replyContainer = document.createElement("div");
    replyContainer.textContent = `Balasan: ${replyMessage}`;
    replyContainer.style.marginTop = "10px";
    replyContainer.style.fontWeight = "bold";

    // Hapus textarea dan tombol setelah balasan dikirim
    const replyCell = row.cells[row.cells.length - 1];
    replyCell.innerHTML = "";
    replyCell.appendChild(replyContainer);

    // Simpan balasan ke server (opsional, tambahkan jika diperlukan)
    console.log(`Balasan terkirim untuk: ${row.cells[0].textContent}`);
    console.log(`Pesan balasan: ${replyMessage}`);

    // Tampilkan pesan sukses
    alert("Balasan berhasil dikirim!");
  }
});

// Membuat grafik menggunakan Chart.js
const ctx = document.getElementById("donasiChart").getContext("2d");
const donasiChart = new Chart(ctx, {
  type: "bar", // Tipe grafik: bar chart
  data: {
    labels: ["Total Donasi", "Donasi Keluar"], // Label sumbu X
    datasets: [
      {
        label: "Jumlah Donasi (Rp)",
        data: [5500000, 2250000], // Data untuk Total Donasi dan Donasi Keluar
        backgroundColor: ["rgba(75, 192, 192, 0.2)", "rgba(255, 99, 132, 0.2)"], // Warna latar belakang grafik
        borderColor: ["rgba(75, 192, 192, 1)", "rgba(255, 99, 132, 1)"], // Warna border grafik
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true, // Mulai dari 0 di sumbu Y
      },
    },
  },
});
