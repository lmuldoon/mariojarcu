<?php

/**
 * The template for displaying the header.
 */

$DOMAIN = 'mariojarcu.com';
$re = "/^(?:www\.)?" . str_replace('.', "\.", $DOMAIN) . "$/"; // escape dots
$IS_LIVE = preg_match($re, $_SERVER['SERVER_NAME'] ?? '');

?>
<!DOCTYPE html>
<html <?php html_class(); ?> <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title><?php trim(wp_title('') ?? ''); ?></title>

	<!-- Start Favicons -->

	<!-- End Favicons -->

	<?php
	// Preload critical Montserrat weights — font-display:swap causes all text
	// to reflow when Montserrat loads (FOUT), which registers as CLS. Preloading
	// ensures the fonts are available before the first paint, eliminating the swap.
	// crossorigin="anonymous" is required even for same-origin fonts to avoid a
	// double-fetch (the browser opens a separate CORS-enabled connection for fonts).
	$font_base      = get_theme_file_uri( 'assets/fonts/' );
	$critical_fonts = [
		'montserrat-v31-latin-regular.woff2',
		'montserrat-v31-latin-700.woff2',
		'montserrat-v31-latin-800.woff2',
	];
	foreach ( $critical_fonts as $font ) : ?>
		<link rel="preload" as="font" type="font/woff2" href="<?php echo esc_url( $font_base . $font ); ?>" crossorigin="anonymous" />
	<?php endforeach; ?>

	<?php
	// Preload the hero background image on the front page so the browser
	// fetches it in parallel with the HTML rather than after CSS is parsed.
	if ( is_front_page() ) :
		$hero           = get_field( 'hero', get_option( 'page_on_front' ) ) ?: [];
		$hero_image_id  = $hero['image'] ?? '';
		$hero_image_url = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'full' ) : '';
		if ( $hero_image_url ) : ?>
			<link rel="preload" as="image" href="<?php echo esc_url( $hero_image_url ); ?>" fetchpriority="high" />
		<?php endif;
	endif;
	?>

	<?php wp_head(); ?>

	<script>
		document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/g, 'js');
	</script>

	<?php if ($IS_LIVE) : ?>

		<!-- Cookie Consent -->

		<link rel="preconnect" href="https://www.googletagmanager.com">
		<!-- Google Analytics -->
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-7YPDG6FQ87"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());

			gtag('config', 'G-7YPDG6FQ87');
		</script>

	<?php endif; ?>
</head>

<body <?php body_class(); ?>>

	<a class="button skip-link" href="#main">
		Skip to main content
	</a>

	<header class="site-header">
		<div class="container container--wide">
			<a class="site-logo" href="<?php echo home_url(); ?>" aria-label="Mario Jarcu Salon Concept">
				<?php include_asset('images/logos/logo-lockup-dark.svg'); ?>
			</a>
			<div class="flex gap-10">
				<?php get_template_part('template-parts/site-nav'); ?>
				<div class="site-header__actions">
					<a class="site-header__book-btn" href="<?php echo esc_url(get_permalink(175)); ?>">Book Now</a>
				</div>
			</div>
		</div>
	</header> <!-- /.site-header -->

	<?php get_template_part('template-parts/mobile-nav'); ?>

	<?php get_template_part('template-parts/wrapper/start'); ?>