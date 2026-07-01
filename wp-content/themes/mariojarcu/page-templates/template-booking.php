<?php

/**
 * Template Name: Booking
 *
 * Booksy booking embed.
 *
 * TODO: replace $booksy_url below with Mario's real embeddable Booksy
 * widget URL (Booksy → Boost → Website widget) — the public profile
 * link will not embed.
 */

get_header();

$booksy_url = 'https://mariojarcusalonconcept.booksy.com/a/';

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
				<a class="button button--outline booking-embed__open-link" href="<?php echo esc_url( $booksy_url ); ?>" target="_blank" rel="noopener noreferrer">Open in Booksy &#8599;</a>
			</div>

			<div class="booking-embed__frame">
				<div class="booking-embed__fallback">
					<img src="<?php echo esc_url( get_theme_file_uri( 'images/logos/logo-v3-light.svg' ) ); ?>" alt="" height="62" />
					<p>Loading the booking calendar&hellip;</p>
					<a class="button" href="<?php echo esc_url( $booksy_url ); ?>" target="_blank" rel="noopener noreferrer">Book on Booksy</a>
				</div>
				<iframe
					src="<?php echo esc_url( $booksy_url ); ?>"
					title="Book with Mario Jarcu on Booksy"
					loading="lazy"
					class="booking-embed__iframe"
				></iframe>
			</div>

			<p class="booking-embed__note">Secure booking powered by Booksy. You'll get a confirmation by email or text once your appointment is set.</p>

		</div>
	</section>

<?php endwhile; ?>

<?php get_footer(); ?>
