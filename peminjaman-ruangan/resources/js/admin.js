// Sidebar toggle + simpan state + fix 100vh mobile
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = 'admin:side-mini';
  const side = document.querySelector('.side');
  const btn  = document.getElementById('btnSideToggle');

  function applyMini(mini) {
    side?.classList.toggle('side--mini', mini);
    btn?.setAttribute('aria-expanded', (!mini).toString());
    try { localStorage.setItem(STORAGE_KEY, mini ? '1' : '0'); } catch {}
  }

  const savedMini = (() => {
    try { return localStorage.getItem(STORAGE_KEY) === '1'; }
    catch { return false; }
  })();
  applyMini(savedMini);

  btn?.addEventListener('click', () => {
    const mini = !side.classList.contains('side--mini');
    applyMini(mini);
  });

  const setVH = () => {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
  };
  setVH();
  window.addEventListener('resize', setVH, { passive: true });
});
