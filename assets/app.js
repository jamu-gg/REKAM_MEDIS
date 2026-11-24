// Toggle sidebar (mobile)
const sidebar = document.getElementById('sidebar');
const btnMenu = document.getElementById('btnMenu');
if (btnMenu) btnMenu.addEventListener('click', () => sidebar.classList.toggle('open'));
document.addEventListener('click', (ev) => {
  if (sidebar && sidebar.classList.contains('open') && !sidebar.contains(ev.target) && ev.target !== btnMenu) {
    sidebar.classList.remove('open');
  }
});

// Konfirmasi sebelum hapus: <form data-confirm="pesan">
document.addEventListener('submit', (ev) => {
  const msg = ev.target.dataset.confirm;
  if (msg && !window.confirm(msg)) ev.preventDefault();
});

// Pesan flash hilang otomatis
document.querySelectorAll('[data-autodismiss]').forEach((el) => {
  setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 400); }, 5000);
});
