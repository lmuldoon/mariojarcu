<?php

/**
 * Home page hero section.
 */

$hero               = get_field('hero') ?: [];
$hero_kicker        = $hero['kicker'] ?? '';
$hero_title         = $hero['title'] ?? '';
$hero_lead          = $hero['text'] ?? '';
$hero_image_id      = $hero['image'] ?? '';
$hero_bg_position   = $hero['background_position'] ?? 'center center';

$hero_image_url = $hero_image_id ? wp_get_attachment_image_url($hero_image_id, 'full') : '';

$inline_style = $hero_image_url
    ? ' style="background-image: url(' . esc_url($hero_image_url) . '); background-position: ' . esc_attr($hero_bg_position) . ';"'
    : '';


$hero_title = preg_replace(
    '/\*\*(.*?)\*\*/',
    '<span class="title__span">$1</span>',
    esc_html($hero_title)
);

?>

<section class="hero section" id="hero" aria-labelledby="hero-heading" <?php echo $inline_style; ?>>

    <div class="container">
        <div class="hero__content js-reveal flow animated">

            <?php if (!empty($hero_kicker)) : ?><p class="kicker"><?php echo esc_html($hero_kicker); ?></p><?php endif; ?>
            <?php if (!empty($hero_title)) : ?><h1 id="hero-heading" class="hero__heading"><?php echo wp_kses_post($hero_title); ?></h1><?php endif; ?>
            <?php if (!empty($hero_lead)) : ?><div class="hero__lead"><?php echo wp_kses_post($hero_lead); ?></div><?php endif; ?>

            <div class="hero__actions">
                <a class="button" href="<?php echo esc_url( get_permalink( 175 ) ); ?>">Book your chair</a>
                <a class="button button--outline" href="#services">View services</a>
            </div>
        </div>
    </div>

</section>

<?php get_template_part('template-parts/marquee-strip'); ?>