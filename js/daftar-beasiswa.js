document.addEventListener("DOMContentLoaded", () => {
  // Form Validation
  const form = document.querySelector("form");

  form.addEventListener("submit", function (event) {
    let valid = true;

    // Cek apakah semua field telah diisi
    const fields = form.querySelectorAll("input, select, textarea");
    fields.forEach((field) => {
      if (!field.value.trim()) {
        valid = false;
        field.style.borderColor = "red"; // Tandai input yang kosong
      } else {
        field.style.borderColor = ""; // Reset border jika valid
      }
    });

    // Jika ada input yang kosong, cegah submit
    if (!valid) {
      event.preventDefault();
      alert("Semua kolom harus diisi!");
    }
  });

  // Menambahkan interaktivitas jika dibutuhkan
  // Contoh: Validasi nilai rapor (tidak lebih dari 100)
  const nilaiMatematika = document.getElementById("matematika");
  const nilaiIpa = document.getElementById("ipa");
  const nilaiBindo = document.getElementById("bindo");
  const nilaiBinggris = document.getElementById("binggris");

  const nilaiFields = [nilaiMatematika, nilaiIpa, nilaiBindo, nilaiBinggris];

  nilaiFields.forEach((field) => {
    field.addEventListener("input", (e) => {
      if (e.target.value > 100) {
        alert("Nilai tidak boleh lebih dari 100.");
        e.target.value = 100;
      }
    });
  });
});
