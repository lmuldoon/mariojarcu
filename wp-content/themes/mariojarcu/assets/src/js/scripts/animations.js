import $ from "jquery";
import {
	throttle,
	debounce
} from "./__event-utilities";
import {
	gsap,
	random
} from "gsap";
import {
	ScrollTrigger
} from "gsap/ScrollTrigger";
import {
	Flip
} from "gsap/Flip";
// import {
// 	CountUp
// } from 'countup.js';

let mobileTl;
let flipCtx;

export function initAnimations() {

	init();
	if (document.querySelector(".gallery--bento")) {
		initBentoGallery();
	}
	setUpHeader();
	animateParallax();
	smoothScrolling();
	animateElements();
	animateHeaderIn();
	$('html').removeClass('no-gsap').addClass('gsap');

}

function init() {

	gsap.registerPlugin(ScrollTrigger);
	gsap.registerPlugin(Flip);

	gsap.config({
		nullTargetWarn: false,
		force3D: false
	});
	gsap.defaults({
		ease: "ease",
		duration: 0.75
	});

	ScrollTrigger.config({
		limitCallbacks: true,
	});

	ScrollTrigger.defaults({
		once: true,
	});

	// refresh trigger points for Safari to calculate correct height of footer
	setTimeout(function () {
		ScrollTrigger.refresh();
	}, 1000);

}

function setUpHeader() {
	const $siteHeader = $('.site-header');

	function storeHeaderHeight() {
		if (!$siteHeader.length) {
			return;
		}
		$('html').css('--header-height', `${Math.ceil($siteHeader.outerHeight(true))}px`);
	}

	storeHeaderHeight();

	$(window).on('resize', debounce(storeHeaderHeight, 150));
}

/**
 * The sticky header's current rendered height (in px), so anchor-link
 * scrolling lands the target flush against the header's bottom edge.
 * Read live rather than cached, since it's cheap and avoids any staleness
 * from the resize-debounced --header-height var.
 *
 * Deliberately no extra "breathing room" padding added on top of this —
 * sections butt directly against each other with no gap in the DOM, so
 * under-scrolling past the exact header height just reveals the tail end
 * of the previous section in that gap rather than empty space.
 */
export function getAnchorScrollOffset() {
	const $siteHeader = $('.site-header');
	return $siteHeader.length ? Math.ceil($siteHeader.outerHeight(true)) : 0;
}

function animateParallax() {

	gsap.utils.toArray(".parallax-up").forEach(item => {
		const parallaxUp = gsap.timeline();
		const content = $(item).find('.parallax-up--element');

		parallaxUp.to(content, {
			y: '-30vh'
		});

		ScrollTrigger.create({
			trigger: item,
			animation: parallaxUp,
			scrub: 0.2,
			once: false,
			start: 'top top',
			end: 'bottom+=1000 top '
		})
	});

	gsap.utils.toArray(".parallax").forEach(image => {
		const parallax = gsap.timeline(),
			img = $(image).find('img');

		parallax.set(img, {
			scale: 1.2,
		}).to(img, {
			scale: 1,
		});

		ScrollTrigger.create({
			trigger: image,
			animation: parallax,
			scrub: true,
			once: false,
			end: 'bottom center',
			//onLeave: () => ScrollTrigger.refresh(),
		})
	});
}

function initBentoGallery() {


	const createTween = () => {

		ScrollTrigger.disable();

		let galleryElement = document.querySelector(".gallery--bento");
		let galleryItems = galleryElement.querySelectorAll(".gallery__item");
		let galleryItemCaption = galleryElement.querySelectorAll(".gallery__item__caption");
		flipCtx && flipCtx.revert();
		galleryElement.classList.remove("gallery--final");

		flipCtx = gsap.context(() => {
			// Temporarily add the final class to capture the final state
			galleryElement.classList.add("gallery--final");
			const flipState = Flip.getState(galleryItems);
			galleryElement.classList.remove("gallery--final");

			const flip = Flip.to(flipState, {
				simple: true
			});

			ScrollTrigger.enable();

			ScrollTrigger.create({
				trigger: galleryElement,
				start: "center center",
				end: "+=300%",
				scrub: true,
				once: false,
				pin: galleryElement.parentNode,
				animation: flip,
				invalidateOnRefresh: false,
				onUpdate: self => {
					if (self.progress > 0.9) {
						gsap.to(galleryItemCaption, {
							duration: 0.3,
							autoAlpha: 1,
						});
					} else {
						gsap.to(galleryItemCaption, {
							duration: 0.3,
							autoAlpha: 0,
						});
					}
				},
			});

			animateElements();


			return () => gsap.set(galleryItems, {
				clearProps: "all"
			});
		});


	};

	let mm = gsap.matchMedia();

	mm.add("(min-width: 768px)", () => {

		createTween();

		window.addEventListener("resize", createTween);

	});

}

function animateElements() {
	gsap.utils.toArray(".animated").forEach((elem, index) => {
		gsap.set(elem.children, {
			opacity: 0
		});

		ScrollTrigger.create({
			trigger: elem,
			start: "top 90%",
			once: true,
			onEnter: () => {
				gsap.fromTo(elem.children, {
					y: 50,
					autoAlpha: 0
				}, {
					y: 0,
					autoAlpha: 1,
					stagger: 0.05,
					// Only clear the transform, not opacity/visibility — the
					// final inline opacity:1 needs to stick around so it
					// overrides the CSS .js .animated > * { opacity: 0 }
					// pre-hide rule (see global.scss). If opacity were
					// cleared too, the element would fall back to that CSS
					// rule and snap invisible again right after revealing.
					clearProps: "transform"
				});
			},
			onEnterBack: () => {
				gsap.to(elem.children, {
					duration: 0.3,
					autoAlpha: 1,
					stagger: 0.05
				});
			}
		})
	});

	gsap.utils.toArray(".featured-angle-left").forEach((elem, index) => {
		ScrollTrigger.create({
			trigger: elem,
			toggleClass: 'cropped',
			once: true,
		})
	});

	gsap.utils.toArray(".image-text__image__wrapper").forEach((elem, index) => {

		let mm = gsap.matchMedia();

		mm.add("(min-width: 1280px)", () => {
			gsap.set(elem, {
				autoAlpha: 0
			});

			ScrollTrigger.create({
				trigger: elem,
				toggleClass: 'cropped',
				once: true,
				onEnter: () => {
					gsap.to(elem, {
						autoAlpha: 1
					});
				},
				onEnterBack: () => {
					gsap.to(elem, {
						autoAlpha: 1
					});
				}
			})
		});

		mm.add("(max-width: 1279px)", () => {
			gsap.set(elem, {
				autoAlpha: 0
			});

			ScrollTrigger.create({
				trigger: elem,
				toggleClass: 'cropped',
				start: "top 90%",
				once: true,
				onEnter: () => {
					gsap.fromTo(elem, {
						y: 50,
						autoAlpha: 0
					}, {
						y: 0,
						autoAlpha: 1,
						stagger: 0.05,
						clearProps: "transform, opacity"
					});
				},
				onEnterBack: () => {
					gsap.to(elem, {
						duration: 0.3,
						autoAlpha: 1,
						stagger: 0.05
					});
				}
			})
		});

	});

}

/**
 * One-off page-load entrance for the header: logo, nav links and the
 * Book Now button slide down and fade in together. Not scroll-triggered —
 * the header is always above the fold, so this just plays immediately.
 */
function animateHeaderIn() {
	const logo = document.querySelector(".site-logo");
	const navItems = gsap.utils.toArray(".site-nav__item");
	const bookBtn = document.querySelector(".site-header__book-btn");

	const targets = [logo, ...navItems, bookBtn].filter(Boolean);

	if (!targets.length) {
		return;
	}

	gsap.set(targets, {
		y: -16,
		autoAlpha: 0
	});

	gsap.to(targets, {
		y: 0,
		autoAlpha: 1,
		duration: 0.6,
		ease: "power3.out",
		stagger: 0.05,
		delay: 0.1,
		// Only clear the transform — the final inline opacity/visibility
		// need to stick around so they override the CSS
		// .js .site-logo / .site-nav__item / .site-header__book-btn
		// pre-hide rule (see _site-header.scss). Same reasoning as the
		// .animated reveal in animateElements() above.
		clearProps: "transform"
	});
}

export function refreshAnimations() {
	ScrollTrigger.refresh();
}

export function toggleScroll(toggle) {
	if (!smoother) {
		return;
	}

	smoother.paused(toggle);
}

export function progressTimeline() {
	if (!mobileTl) {
		return;
	}
	mobileTl.progress(1);
}


function smoothScrolling() {

	// Select all links with hashes
	$('a[href*="#"]')
		// Remove links that don't actually link to anything
		.not('[href="#"]')
		.not('[href="#0"]')
		.not('[role="tab"]')
		.click(function (event) {
			// On-page links
			if (
				location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
				location.hostname == this.hostname
			) {
				// Figure out element to scroll to
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				// Does a scroll target exist?
				if (target.length) {
					// Only prevent default if animation is actually gonna happen

					var extra = getAnchorScrollOffset();

					event.preventDefault();
					$('html, body').animate({
						scrollTop: target.offset().top - extra
					}, 350, function () {
						// Callback after animation
						// Must change focus!

						target[0].focus({
							preventScroll: true
						});

						// check if target was actually focused
						if (target[0] != document.activeElement) {
							// if not, set tabindex and focus again
							target[0].setAttribute('tabindex', '-1');
							target[0].focus({
								preventScroll: true
							});
						}

					});
				}
			}
		});
}