<?php

/**
 * Template Name: Gallery
 *
 * Masonry photo gallery with lightbox.
 * Images come from the "Gallery" custom post type (image + caption ACF fields),
 * ordered using the page-attributes menu order set in wp-admin.
 */

get_header();

$gallery_items = get_posts( [
	'post_type'      => 'gallery',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
] );

?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'template-parts/intro-band' ); ?>

	<section class="section bg-black gallery-masonry" aria-label="Photo gallery">
		<div class="container">
			<?php if ( $gallery_items ) : ?>
				<div class="gallery-masonry__grid animated">
					<?php foreach ( $gallery_items as $gallery_post ) :
						$image   = get_field( 'image', $gallery_post->ID );
						$caption = get_field( 'caption', $gallery_post->ID );

						if ( empty( $image['url'] ) ) {
							continue;
						}

						$thumb_url = $image['sizes']['large'] ?? $image['url'];
					?>
						<a class="gallery-tile" href="<?php echo esc_url( $image['url'] ); ?>" data-full="<?php echo esc_url( $image['url'] ); ?>">
							<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $caption ?: $image['alt'] ); ?>" loading="lazy" />
							<?php if ( $caption ) : ?><span class="gallery-tile__tag"><?php echo esc_html( $caption ); ?></span><?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="gallery-masonry__empty">More photos coming soon.</p>
			<?php endif; ?>
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

<div id="gallery-lightbox" class="gallery-lightbox">
	<button type="button" class="gallery-lightbox__close" aria-label="Close">Close &times;</button>
	<img class="gallery-lightbox__img" src="" alt="" />
</div>

<?php get_footer(); ?>
