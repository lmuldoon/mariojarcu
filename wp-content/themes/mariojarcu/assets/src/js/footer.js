import './scripts/__tools';
import initReviewsCarousel from './scripts/init.swiper';
import initGalleryLightbox from './scripts/gallery-lightbox';
import {
    initAnimations,
    getAnchorScrollOffset,
} from './scripts/animations';

// Wait for the self-hosted webfonts to finish loading before starting the
// GSAP scroll-reveal animations. Without this, an above-the-fold reveal
// (e.g. the hero) can fire and start tweening while the fallback system
// font is still showing, then swap to the real font mid-animation — a
// visible font/layout change while the text is sliding in. A short timeout
// guards against document.fonts.ready never resolving.
function whenFontsReady(callback, timeoutMs = 1500) {
    if (!(document.fonts && document.fonts.ready)) {
        callback();
        return;
    }

    Promise.race([
        document.fonts.ready,
        new Promise((resolve) => setTimeout(resolve, timeoutMs)),
    ]).then(callback);
}

whenFontsReady(initAnimations);

document.addEventListener('DOMContentLoaded', () => {
    initReviewsCarousel();
    initGalleryLightbox();
});

(function ($) {
    // Same-page anchor clicks are handled by smoothScrolling() in
    // animations.js (already header-offset aware) — only the cross-page
    // case (arriving at a URL with a #hash already in it, e.g. a footer
    // link to /#services from another page) needs handling here, since the
    // browser's own native jump-to-hash happens before our JS can offset it.
    if (window.location.hash) {
        var $hashTarget = $(window.location.hash);
        if ($hashTarget.length) {
            $(window).on('load', function () {
                var headerHeight = getAnchorScrollOffset();
                $('html, body').scrollTop($hashTarget.offset().top - headerHeight);
            });
        }
    }
})(jQuery);