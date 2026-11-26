//
document.documentElement.classList.add('js');

document.addEventListener('DOMContentLoaded', () => {
    // Anak dari [data-stagger] muncul berurutan
    document.querySelectorAll('[data-stagger]').forEach(parent => {
        [...parent.children].forEach((child, i) => {
            child.setAttribute('data-reveal', child.getAttribute('data-reveal') || '');
            child.style.setProperty('--d', (i * 90) + 'ms');
        });
    });

    // Muncul saat masuk layar
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('[data-reveal]').forEach(el => io.observe(el));

    // Angka berhitung naik (untuk statistik)
    const counter = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            const el = e.target;
            const m = el.textContent.trim().match(/^(\d+)(.*)$/);
            counter.unobserve(el);
            if (!m) return;
            const target = parseInt(m[1], 10), suffix = m[2], start = performance.now(), dur = 1400;
            const tick = now => {
                const p = Math.min((now - start) / dur, 1);
                el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3))) + suffix;
                if (p < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        });
    }, { threshold: 0.6 });
    document.querySelectorAll('[data-count]').forEach(el => counter.observe(el));

    // Bayangan header saat scroll
    const header = document.getElementById('site-header');
    if (header) {
        const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 10);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }
    if (document.querySelector('[data-map-picker]')) {
        import('./map-picker.js');
    }
});