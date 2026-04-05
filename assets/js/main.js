/**
 * Rezon8 Child Theme — main.js
 * Lightweight Material Design enhancements.
 * No dependencies — vanilla JS only.
 */

(function () {
  'use strict';

  // ── Sticky Header Shadow ────────────────────────────────────────────────────
  // Adds elevation shadow when user scrolls past the header.
  const header = document.querySelector('.wp-block-template-part, header, .site-header');
  if (header) {
    const onScroll = () => {
      if (window.scrollY > 10) {
        header.style.boxShadow = '0 3px 6px rgba(0,0,0,0.15), 0 2px 4px rgba(0,0,0,0.12)';
      } else {
        header.style.boxShadow = '0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)';
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // ── Material Ripple on Buttons ──────────────────────────────────────────────
  document.querySelectorAll('.wp-block-button__link, .wp-element-button').forEach((btn) => {
    btn.addEventListener('click', function (e) {
      const ripple = document.createElement('span');
      const rect = btn.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;

      Object.assign(ripple.style, {
        position: 'absolute',
        width: size + 'px',
        height: size + 'px',
        left: x + 'px',
        top: y + 'px',
        background: 'rgba(255,255,255,0.3)',
        borderRadius: '50%',
        transform: 'scale(0)',
        animation: 'r8-ripple 600ms linear',
        pointerEvents: 'none',
      });

      btn.appendChild(ripple);
      setTimeout(() => ripple.remove(), 650);
    });
  });

  // ── Inject ripple keyframes once ────────────────────────────────────────────
  if (!document.getElementById('r8-ripple-style')) {
    const style = document.createElement('style');
    style.id = 'r8-ripple-style';
    style.textContent = '@keyframes r8-ripple { to { transform: scale(4); opacity: 0; } }';
    document.head.appendChild(style);
  }

  // ── Smooth anchor scroll ─────────────────────────────────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

})();
