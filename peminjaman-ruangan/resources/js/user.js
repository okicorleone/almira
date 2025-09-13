// resources/js/user.js
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btnSideToggle');
  const sidebar = document.querySelector('.side');

  if (btn && sidebar) {
    btn.addEventListener('click', () => {
      sidebar.classList.toggle('side--mini');

      // optional: update aria-expanded
      const expanded = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', (!expanded).toString());
    });
  }
});
