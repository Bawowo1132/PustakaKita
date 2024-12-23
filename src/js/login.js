document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const emailInput = form.querySelector('input[name="email"]');
  const passwordInput = form.querySelector('input[name="password"]');

  form.addEventListener("submit", (event) => {
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    // Validasi sederhana
    if (!validateEmail(email)) {
      alert("Masukkan email yang valid.");
      event.preventDefault(); // Batalkan pengiriman form
      return;
    }

    if (password.length === 0) {
      alert("Masukkan password.");
      event.preventDefault();
    }
  });

  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
});