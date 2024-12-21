// JavaScript for Handling Section Visibility and Form Modal
const menuItems = document.querySelectorAll('.menu-item');
const sections = document.querySelectorAll('.content-section');
const modal = document.getElementById('modal');
const dashboard_first = document.querySelector("#dashboard-first")
const cancelButton = document.getElementById('cancel-button');

menuItems.forEach(item => {
    item.addEventListener('click', (e) => {
        sections.forEach(section => {
            section.style.display = 'none';
        });
        const targetSection = document.querySelector(e.target.getAttribute('href'));
        if (targetSection) {
            targetSection.style.display = 'block';
        }
    });
});

document.getElementById('add-donasi').addEventListener('click', () => {
    modal.style.display = 'block';
});

cancelButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

document.getElementById('add-donatur').addEventListener('click', () => {
    modal.style.display = 'block';
});

document.getElementById('add-sekolah').addEventListener('click', () => {
    modal.style.display = 'block';
});
document.querySelector('.logout-button').addEventListener('click', () => {
window.location.href = 'login1.php';
});