import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';

export default function initReviewsCarousel() {
    const el = document.querySelector('.js-reviews-carousel');
    if (!el) return;

    new Swiper(el, {
        modules: [Navigation, Autoplay],
        loop: true,
        grabCursor: true,
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 24,
        autoplay: {
            delay: 6000,
            pauseOnMouseEnter: true,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.reviews-carousel__btn--next',
            prevEl: '.reviews-carousel__btn--prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                slidesPerGroup: 2,
                spaceBetween: 32,
            },
            1024: {
                slidesPerView: 3,
                slidesPerGroup: 3,
                spaceBetween: 40,
            },
        },
    });
}
