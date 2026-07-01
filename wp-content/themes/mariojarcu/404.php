<?php

/**
 * The template for displaying 404 pages (Not Found).
 */

get_header();

?>

<section class="error-404" aria-label="Page not found">
	<div class="container container--text text-center animated">
		<p class="error-404__code">404</p>
		<h1 class="error-404__title">Sorry, that doesn&rsquo;t exist.</h1>
		<p class="error-404__lead">We couldn&rsquo;t find the page you were looking for. If you typed the URL, please check it for spelling mistakes &mdash; or use one of the links below.</p>
		<div class="error-404__actions">
			<a class="button" href="<?php echo esc_url( home_url() ); ?>">Back to Home</a>
			<a class="button button--outline" href="<?php echo esc_url( get_permalink( 175 ) ); ?>">Book your chair</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
