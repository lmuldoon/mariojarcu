import { gsap } from 'gsap';
import { disableBodyScroll, enableBodyScroll } from './body-scroll-lock-facade';

export default function initMobileNav() {
    const toggle = document.querySelector('.js-site-nav-toggle');
    const closeBtn = document.querySelector('.js-site-nav-close');
    const shade = document.querySelector('.js-menu-body-shade');
    const panel = document.getElementById('mobile-nav');

    if (!toggle || !panel) return;

    const animatedItems = panel.querySelectorAll('.mobile-nav__list li, .mobile-nav__footer');

    // Resting (closed) state for the nav items, set once up front so there's
    // no flash of visible content before the first open.
    gsap.set(animatedItems, { opacity: 0, x: 24 });

    const isOpen = () => panel.classList.contains('is-open');

    const open = () => {
        panel.classList.add('is-open');
        shade?.classList.add('is-open');
        toggle.classList.add('is-active');
        toggle.setAttribute('aria-expanded', 'true');
        disableBodyScroll(panel, { reserveScrollBarGap: true });

        gsap.to(animatedItems, {
            opacity: 1,
            x: 0,
            duration: 0.45,
            ease: 'power3.out',
            stagger: 0.06,
            delay: 0.15, // let the panel start sliding in first
            overwrite: true,
        });
    };

    const close = () => {
        panel.classList.remove('is-open');
        shade?.classList.remove('is-open');
        toggle.classList.remove('is-active');
        toggle.setAttribute('aria-expanded', 'false');
        enableBodyScroll(panel);

        gsap.to(animatedItems, {
            opacity: 0,
            x: 24,
            duration: 0.25,
            ease: 'power2.in',
            stagger: 0.03,
            overwrite: true,
        });
    };

    toggle.addEventListener('click', () => {
        isOpen() ? close() : open();
    });

    closeBtn?.addEventListener('click', close);
    shade?.addEventListener('click', close);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && isOpen()) close();
    });

    panel.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', close);
    });
}
