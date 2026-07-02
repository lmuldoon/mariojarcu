<?php

/**
 * Template Name: Services
 *
 * Full price list page, grouped by the "service_group" taxonomy.
 */

get_header();

$services = mj26_get_services();
$groups   = [];
foreach ( $services as $service ) {
	$group_name = $service['group'] ?: 'Other';
	$groups[ $group_name ][] = $service;
}

?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'template-parts/intro-band', null, [
		'bg_position' => 'center 35%',
	] ); ?>

	<section class="section bg-white price-list" aria-label="Price list">
		<div class="container container--narrow">
			<div class="price-list__columns animated">
				<?php $i = 0; foreach ( $groups as $group_name => $group_services ) : $i++; ?>
					<div class="price-group animated">
						<div class="price-group__header">
							<span class="kicker"><?php echo esc_html( sprintf( '%02d', $i ) ); ?> &mdash; <?php echo esc_html( $group_name ); ?></span>
							<span class="price-group__rule"></span>
						</div>
						<div class="price-group__list animated">
							<?php foreach ( $group_services as $service ) : ?>
								<div class="price-row">
									<div class="price-row__info">
										<div class="price-row__name"><?php echo esc_html( $service['title'] ); ?></div>
										<?php if ( $service['duration'] ) : ?>
											<div class="price-row__meta"><?php echo esc_html( $service['duration'] ); ?></div>
										<?php endif; ?>
									</div>
									<span class="price-row__price"><?php echo esc_html( $service['price'] ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
	$cta = [
		'title'    => get_field( 'cta_title' ) ?: '',
		'text'     => get_field( 'cta_text' ) ?: '',
		'link'     => get_field( 'cta_link' ) ?: [],
		'btn_label' => '',
		'btn_url'  => '',
	];
	if ( ! empty( $cta['link']['url'] ) )   $cta['btn_url']   = esc_url( $cta['link']['url'] );
	if ( ! empty( $cta['link']['title'] ) ) $cta['btn_label'] = $cta['link']['title'];
	get_template_part( 'template-parts/cta-band', null, $cta );
	?>

<?php endwhile; ?>

<?php get_footer(); ?>
