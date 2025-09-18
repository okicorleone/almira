// Sidebar toggle + simpan state + fix 100vh mobile
document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = 'user:side-mini';   // beda key dengan admin
  const side = document.querySelector('.side');
  const btn  = document.getElementById('btnSideToggle');

  function applyMini(mini) {
    side?.classList.toggle('side--mini', mini);
    btn?.setAttribute('aria-expanded', (!mini).toString());
    try { localStorage.setItem(STORAGE_KEY, mini ? '1' : '0'); } catch {}
  }

  // ambil state tersimpan
  const savedMini = (() => {
    try { return localStorage.getItem(STORAGE_KEY) === '1'; }
    catch { return false; }
  })();
  applyMini(savedMini);

  // toggle manual
  btn?.addEventListener('click', () => {
    const mini = !side.classList.contains('side--mini');
    applyMini(mini);
  });

  // fix 100vh untuk mobile (safe viewport height)
  const setVH = () => {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
  };
  setVH();
  window.addEventListener('resize', setVH, { passive: true });
});
