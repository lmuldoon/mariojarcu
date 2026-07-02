<?php

/**
 * Template Name: Booking
 *
 * Booksy booking embed — uses Booksy's official widget script in
 * `mode=inline` so the full booking calendar appears directly on the
 * page. Booksy blocks raw iframe embedding (X-Frame-Options: DENY) but
 * their own widget script creates an internal iframe that IS allowed.
 */

get_header();

$booksy_profile_url = 'https://booksy.com/en-gb/dl/show-business/138519';

?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'template-parts/intro-band', null, [
		'bg_position' => 'center 30%',
	] ); ?>

	<section class="info-strip" aria-label="Booking information">
		<div class="container animated">
			<div class="info-strip__item">
				<span class="info-strip__label">Where</span>
				<span class="info-strip__value">1 Craven Road, Rugby, CV21 3JX</span>
			</div>
			<div class="info-strip__item">
				<span class="info-strip__label">Hours</span>
				<span class="info-strip__value"><?php echo esc_html( mj26_get_opening_hours_summary() ); ?></span>
			</div>
			<div class="info-strip__item">
				<span class="info-strip__label">Good to know</span>
				<span class="info-strip__value">Appointment only &middot; please arrive on time</span>
			</div>
		</div>
	</section>

	<section class="section bg-black booking-embed" id="book" aria-label="Booksy booking widget">
		<div class="container container--narrow animated">

			<div class="booking-embed__status">
				<span class="booking-embed__status-dot"></span>
				<span class="booking-embed__status-text">Live availability via Booksy</span>
				<a class="button button--outline booking-embed__open-link" href="<?php echo esc_url( $booksy_profile_url ); ?>" target="_blank" rel="noopener noreferrer">Open in Booksy &#8599;</a>
			</div>

			<div class="booking-embed__widget">
				<!-- Booksy inline widget — renders the full booking calendar directly.
				     mode=inline embeds it on-page; Booksy's own script creates an
				     internal iframe that is not blocked by their X-Frame-Options policy. -->
				<script
					type="text/javascript"
					src="https://booksy.com/widget/code.js?id=138519&country=gb&lang=en-GB&mode=inline"
				></script>
			</div>

			<p class="booking-embed__note">Secure booking powered by Booksy. You'll get a confirmation by email or text once your appointment is set.</p>

		</div>
	</section>

<?php endwhile; ?>

<?php get_footer(); ?>
