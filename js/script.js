document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const emailInput = form.querySelector('input[type="email"]');
  const passwordInput = form.querySelector('input[type="password"]');
  
  form.addEventListener("submit", (event) => {
    event.preventDefault(); // Mencegah pengiriman form

    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    if (!email || !validateEmail(email)) {
      alert("Please enter a valid email address.");
      return;
    }

    if (!password) {
      alert("Please enter your password.");
      return;
    }

    // Simulate form submission
    alert("Login successful! Welcome back.");
    form.reset(); // Mengosongkan form setelah submit
  });

  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
});
