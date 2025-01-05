document.addEventListener('DOMContentLoaded', function() {
  const donationForm1 = document.getElementById('donation-form-1');
  const donationForm2 = document.getElementById('donation-form-2');
  const donationForm3 = document.getElementById('donation-form-3');
  const backBtn1 = document.getElementById('back-btn-1');
  const backBtn2 = document.getElementById('back-btn-2');
  const backBtn3 = document.getElementById('back-btn-3');
  const proceedBtn1 = document.getElementById('proceed-btn');
  const proceedBtn2 = document.getElementById('proceed-btn-2');
  const proceedBtn3 = document.getElementById('proceed-btn-3');
  const otherAmountInput = document.getElementById('other-amount');
  const donorAmountInput = document.getElementById('donor-amount');
  const donorForm = document.getElementById('donor-form');
  const paymentMethodForm = document.getElementById('payment-method-form');

  let donationAmount = 0;

  // Handle donation amount selection
  const amountBtns = document.querySelectorAll('.amount-btn');
  amountBtns.forEach(button => {
    button.addEventListener('click', function() {
      donationAmount = parseInt(this.getAttribute('data-amount'));
      donorAmountInput.value = `Rp ${donationAmount.toLocaleString()}`;

      // Automatically proceed to the next form (Data Diri)
      donationForm1.classList.add('hidden');
      donationForm2.classList.remove('hidden');
    });
  });

  // Handle other donation amount input
  otherAmountInput.addEventListener('input', function() {
    const otherAmount = parseInt(otherAmountInput.value);
    if (!isNaN(otherAmount)) {
      donationAmount = otherAmount;
      donorAmountInput.value = `Rp ${donationAmount.toLocaleString()}`;
    }
  });

  // Go to the next form (Data Diri)
  proceedBtn1.addEventListener('click', function() {
    if (donationAmount > 0) {
      donationForm1.classList.add('hidden');
      donationForm2.classList.remove('hidden');
    } else {
      alert('Harap pilih jumlah donasi terlebih dahulu');
    }
  });

  // Go back to the previous form (Donasi)
  backBtn2.addEventListener('click', function() {
    donationForm2.classList.add('hidden');
    donationForm1.classList.remove('hidden');
  });

  // Handle donor form submission
  proceedBtn2.addEventListener('click', function(event) {
    event.preventDefault();

    const donorName = document.getElementById('donor-name').value;
    const donorPhone = document.getElementById('donor-phone').value;
    const donorEmail = document.getElementById('donor-email').value;

    if (donorName && donorPhone && donorEmail) {
      donationForm2.classList.add('hidden');
      donationForm3.classList.remove('hidden');
    } else {
      alert('Harap lengkapi data diri Anda');
    }
  });

  // Go back to the previous form (Data Diri)
  backBtn3.addEventListener('click', function() {
    donationForm3.classList.add('hidden');
    donationForm2.classList.remove('hidden');
  });

  // Handle payment method form submission
  proceedBtn3.addEventListener('click', function(event) {
    event.preventDefault();

    const paymentMethod = document.getElementById('payment-method').value;

    // Submit the form data to PHP
    const donorName = document.getElementById('donor-name').value;
    const donorPhone = document.getElementById('donor-phone').value;
    const donorEmail = document.getElementById('donor-email').value;

    const data = new FormData();
    data.append('nama_lengkap', donorName);
    data.append('nomor_hp', donorPhone);
    data.append('email', donorEmail);
    data.append('jumlah_donasi', donationAmount);
    data.append('metode_pembayaran', paymentMethod);

    fetch('simpan_donasi.php', {
      method: 'POST',
      body: data
    })
      .then(response => response.text())
      .then(result => {
        // Show success notification
        alert('Donasi berhasil!');
        window.location.reload();  // Reload the page or redirect to a thank you page
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
      });
  });
});
