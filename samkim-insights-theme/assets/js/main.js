/* Sam Kim Insights — main.js */

/* ── Mobile menu ── */
function toggleMenu() {
    document.getElementById('mobile-menu').classList.toggle('open');
}

/* ── User dropdown ── */
function toggleDropdown() {
    document.getElementById('user-dropdown').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    const dd = document.getElementById('user-dropdown');
    if (dd && !e.target.closest('#auth-user')) dd.classList.remove('open');
});

/* ── Login modal ── */
function openModal(type) {
    const el = document.getElementById('modal-' + type);
    if (el) el.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(type) {
    const el = document.getElementById('modal-' + type);
    if (el) el.classList.remove('open');
    document.body.style.overflow = '';
}
// Close on backdrop click
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('open');
        document.body.style.overflow = '';
    }
});
// Close on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.open').forEach(function(m) {
            m.classList.remove('open');
        });
        document.body.style.overflow = '';
    }
});

/* ── Toast ── */
function showToast(msg, duration) {
    duration = duration || 3000;
    const t = document.getElementById('toast');
    if (!t) return;
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(function() { t.classList.remove('show'); }, duration);
}

/* ── Category bar active state ── */
(function() {
    const items = document.querySelectorAll('.cat-item');
    items.forEach(function(item) {
        item.addEventListener('click', function() {
            items.forEach(function(i) { i.classList.remove('active'); });
            item.classList.add('active');
        });
    });
})();
