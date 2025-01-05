// Toggle class active
const navbarNav = document.querySelector(".navbar-nav");
// ketika hamburger menu diklik
document.querySelector("#hamburger-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

// Klik di luar sidebar untuk menghilangkan nav

const hamburger = document.querySelector("#hamburger-menu");

document.addEventListener("click", function (e) {
  if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});

// Carousel Functionality
document.addEventListener("DOMContentLoaded", () => {
  const images = document.querySelectorAll(".carousel-images img");
  const prevBtn = document.querySelector(".prev-btn");
  const nextBtn = document.querySelector(".next-btn");

  let currentIndex = 0;

  function updateCarousel() {
    images.forEach((img, index) => {
      img.classList.toggle("active", index === currentIndex);
    });
  }

  prevBtn.addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateCarousel();
  });

  nextBtn.addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % images.length;
    updateCarousel();
  });

  updateCarousel(); // Initialize carousel
});
