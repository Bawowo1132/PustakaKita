document.addEventListener("DOMContentLoaded", function () {
    const amountBtns = document.querySelectorAll(".amount-btn");
    const otherAmountInput = document.getElementById("other-amount");
    const donorAmountInput = document.getElementById("donor-amount");
    const proceedBtn2 = document.getElementById("proceed-btn-2");
    const proceedBtn3 = document.getElementById("proceed-btn-3");
  
    let selectedAmount = 0;
  
    // Pilih jumlah donasi dari tombol dan langsung pindah ke form data diri
    amountBtns.forEach((button) => {
      button.addEventListener("click", function () {
        selectedAmount = parseInt(button.getAttribute("data-amount")) || 0;
        donorAmountInput.value = selectedAmount;
        otherAmountInput.value = ""; // Kosongkan input jumlah lain
  
        // Pindah langsung ke form data diri
        document.getElementById("donation-form-1").classList.add("hidden");
        document.getElementById("donation-form-2").classList.remove("hidden");
      });
    });
  
    // Input jumlah donasi lainnya
    otherAmountInput.addEventListener("input", function () {
      const inputAmount = parseInt(otherAmountInput.value) || 0;
      donorAmountInput.value = inputAmount;
    });
  
    // Form 2: Lanjut ke form pembayaran
    proceedBtn2.addEventListener("click", function (event) {
      event.preventDefault();
  
      const donorName = document.getElementById("donor-name").value.trim();
      const donorPhone = document.getElementById("donor-phone").value.trim();
      const donorEmail = document.getElementById("donor-email").value.trim();
  
      if (donorName && donorPhone && donorEmail && selectedAmount > 0) {
        document.getElementById("donation-form-2").classList.add("hidden");
        document.getElementById("donation-form-3").classList.remove("hidden");
      } else {
        alert("Semua data harus diisi dengan benar.");
      }
    });
  
    // Form 3: Kirimkan data ke PHP
    proceedBtn3.addEventListener("click", function (event) {
      event.preventDefault();
  
      const paymentMethod = document.getElementById("payment-method").value;
      const donorName = document.getElementById("donor-name").value.trim();
      const donorPhone = document.getElementById("donor-phone").value.trim();
      const donorEmail = document.getElementById("donor-email").value.trim();
  
      if (paymentMethod && donorName && donorPhone && donorEmail && selectedAmount > 0) {
        const formData = new FormData();
        formData.append("nama_lengkap", donorName);
        formData.append("nomor_hp", donorPhone);
        formData.append("email", donorEmail);
        formData.append("jumlah_donasi", selectedAmount);
        formData.append("metode_pembayaran", paymentMethod);
  
        // Kirimkan data ke PHP menggunakan Fetch API
        fetch("donasi.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.text())
          .then((data) => {
            document.getElementById("donation-form-3").classList.add("hidden");
            document.getElementById("success-notification").classList.remove("hidden");
          })
          .catch((error) => {
            alert("Terjadi kesalahan: " + error);
          });
      } else {
        alert("Semua data harus diisi.");
      }
    });
  
    // Kembali ke form sebelumnya
    document.getElementById("back-btn-2").addEventListener("click", function () {
      document.getElementById("donation-form-2").classList.add("hidden");
      document.getElementById("donation-form-1").classList.remove("hidden");
    });
  
    document.getElementById("back-btn-3").addEventListener("click", function () {
      document.getElementById("donation-form-3").classList.add("hidden");
      document.getElementById("donation-form-2").classList.remove("hidden");
    });
  });
  