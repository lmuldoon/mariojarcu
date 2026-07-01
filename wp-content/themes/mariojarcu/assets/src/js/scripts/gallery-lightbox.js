export default function initGalleryLightbox() {
    const lightbox = document.getElementById('gallery-lightbox');
    if (!lightbox) return;

    const lightboxImg = lightbox.querySelector('.gallery-lightbox__img');
    const closeBtn = lightbox.querySelector('.gallery-lightbox__close');

    const open = (src, alt) => {
        lightboxImg.setAttribute('src', src);
        lightboxImg.setAttribute('alt', alt || '');
        lightbox.classList.add('is-open');
    };

    const close = () => {
        lightbox.classList.remove('is-open');
    };

    document.addEventListener('click', (event) => {
        const tile = event.target.closest('.gallery-tile');
        if (tile) {
            event.preventDefault();
            open(tile.getAttribute('data-full'), tile.querySelector('img')?.getAttribute('alt'));
            return;
        }

        if (event.target === lightbox || event.target === closeBtn || closeBtn.contains(event.target)) {
            close();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') close();
    });
}
