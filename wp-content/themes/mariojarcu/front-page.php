<?php

/**
 * The front page template file
 */

get_header();

$about    = get_field('about')    ?: [];
$services = get_field('services') ?: [];
$reviews  = get_field('reviews')  ?: [];
$location = get_field('location') ?: [];
?>

<?php while (have_posts()) : ?>
	<?php the_post(); ?>

	<?php get_template_part('template-parts/hero-home'); ?>

	<div class="_anchor" id="main-content"></div>

	<article id="post-<?php the_ID(); ?>" <?php post_class('page-home-content'); ?>>

		<!-- ===== ABOUT ===== -->
		<section class="section bg-white" aria-label="Experience and approach" id="about">
			<div class="container">
				<div class="image-content-list">

					<div class="image-content-item image-content-item--image-left js-reveal animated">
						<?php if (!empty($about['image'])) : ?>
							<figure class="image-content-item__media card__media stat-badge-wrap">
								<div class="image-content-item__media-inner">
									<?php echo wp_get_attachment_image($about['image'], 'large', false, [
										'loading' => 'lazy',
										'class'   => '',
									]); ?>
								</div>
								<div class="stat-badge">
									<span class="stat-badge__number">15<span class="stat-badge__plus">+</span></span>
									<span class="stat-badge__label">Years at<br>the Chair</span>
								</div>
							</figure>
						<?php endif; ?>
						<div class="image-content-item__content flow js-reveal animated">
							<?php
							$title = $about['title'];
							$title = preg_replace(
								'/\*\*(.*?)\*\*/',
								'<span class="title__span">$1</span>',
								esc_html($title)
							);
							?>
							<?php if (!empty($about['kicker'])) : ?><p class="kicker"><?php echo esc_html($about['kicker']); ?></p><?php endif; ?>
							<?php if (!empty($title)) : ?><h2><?php echo wp_kses_post($title); ?></h2><?php endif; ?>
							<?php if (!empty($about['text'])) : ?><?php echo wp_kses_post($about['text']); ?><?php endif; ?>
						</div>
					</div>

				</div>
			</div>
		</section>

		<!-- ===== MENU ===== -->
		<section class="section bg-black" aria-label="The Menu" id="services">
			<div class="container">
				<div class="section-header animated">
					<div class="section-header__text">
						<?php if (!empty($services['kicker'])) : ?><p class="kicker"><?php echo esc_html($services['kicker']); ?></p><?php endif; ?>
						<?php if (!empty($services['title'])) : ?><h2><?php echo esc_html($services['title']); ?></h2><?php endif; ?>
					</div>
				</div>
				<?php get_template_part('template-parts/services-grid'); ?>
			</div>
		</section>

		<!-- ===== Reviews ===== -->
		<section class="section bg-white" aria-label="Reviews" id="reviews">
			<div class="container container--text text-center flow animated">
				<?php if (!empty($reviews['kicker'])) : ?><p class="kicker"><?php echo esc_html($reviews['kicker']); ?></p><?php endif; ?>
				<?php if (!empty($reviews['title'])) : ?><h2><?php echo esc_html($reviews['title']); ?></h2><?php endif; ?>
				<?php if (!empty($reviews['text'])) : ?><p class="reviews-rating"><span class="reviews-rating__stars">★★★★★</span> <?php echo esc_html($reviews['text']); ?></p><?php endif; ?>
			</div>
			<div class="container animated mt-10">
				<?php get_template_part('template-parts/reviews-carousel'); ?>
			</div>
		</section>

		<!-- ===== Location ===== -->
		<section class="section bg-black" aria-label="Location" id="location">
			<div class="container">
				<div class="two-col two-col--wide-left js-reveal">
					<div class="flow js-reveal animated">
						<?php if (!empty($location['kicker'])) : ?><p class="kicker"><?php echo esc_html($location['kicker']); ?></p><?php endif; ?>
						<?php if (!empty($location['title'])) : ?><h2><?php echo esc_html($location['title']); ?></h2><?php endif; ?>
						<?php if (!empty($location['text'])) : ?><p><?php echo esc_html($location['text']); ?></p><?php endif; ?>

						<?php get_template_part('template-parts/opening-times'); ?>

						<?php
						$location_link        = $location['link'] ?? [];
						$location_link_url    = ! empty($location_link['url']) ? esc_url($location_link['url']) : esc_url(get_permalink(175));
						$location_link_label  = ! empty($location_link['title']) ? $location_link['title'] : 'Book an appointment';
						$location_link_target = ! empty($location_link['target']) ? esc_attr($location_link['target']) : '';
						?>
						<div class="mt-8 mb-8">
						<a class="button" href="<?php echo $location_link_url; ?>" <?php echo $location_link_target ? 'target="' . $location_link_target . '"' : ''; ?>><?php echo esc_html($location_link_label); ?></a>
						</div>
					</div>
					<div class="flow js-reveal animated">
						<div id="mapbox-map" class="location-map"></div>
					</div>
				</div>
			</div>
		</section>



	</article><!-- #post -->

<?php endwhile; ?>

<?php get_footer(); ?>