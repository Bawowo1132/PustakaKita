document.addEventListener("DOMContentLoaded", () => {
  const donationButtons = document.querySelectorAll(".cta");

  donationButtons.forEach(button => {
    button.addEventListener("click", event => {
      const buttonText = button.textContent.trim().toLowerCase();

      if (buttonText === "donasi sekarang") {
        event.preventDefault(); 
        window.location.href = "donasi.html"; 
      }
    });
  });
});
