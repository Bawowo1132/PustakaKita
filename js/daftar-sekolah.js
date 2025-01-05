document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const fileInput = document.getElementById("foto_bukti");
  const danaInput = document.getElementById("dana");

  form.addEventListener("submit", function (event) {
    let valid = true;

    // Cek apakah semua input diisi
    const fields = form.querySelectorAll("input, select, textarea");
    fields.forEach(function (field) {
      if (!field.value.trim()) {
        valid = false;
        field.style.borderColor = "red"; // Tandai input yang kosong
      } else {
        field.style.borderColor = ""; // Reset border jika valid
      }
    });

    // Validasi ukuran file foto
    const file = fileInput.files[0];
    if (file) {
      const maxFileSize = 2 * 1024 * 1024; // 2MB
      if (file.size > maxFileSize) {
        alert("Ukuran foto tidak boleh lebih dari 2MB.");
        valid = false;
      }
    }

    // Cegah form dikirim jika validasi gagal
    if (!valid) {
      event.preventDefault();
      alert("Semua kolom harus diisi dan ukuran file foto harus kurang dari 2MB.");
    }
  });
});
