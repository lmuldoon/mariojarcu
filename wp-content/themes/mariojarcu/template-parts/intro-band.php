<?php

/**
 * Page intro band — eyebrow + H1 + lead, optional dimmed background photo.
 *
 * Content (kicker, title, text, image) comes from the "Intro Band" ACF
 * field group on the current page. bg_position has no ACF field (it's a
 * cosmetic per-template tweak, not editorial content) — pass it via
 * $args if a template needs something other than the default.
 *
 * Fields are looked up by their unique field KEY, not name — "title",
 * "text" and "image" are common field names reused elsewhere in this site
 * (e.g. the flexible-content block system), and get_field() by name can
 * resolve to the wrong field definition when names collide across groups.
 */

$kicker      = get_field( 'field_6a43ba76d4e4e' ) ?: ''; // kicker
$title       = get_field( 'field_6a43ba84d4e4f' ) ?: ''; // title
$lead        = get_field( 'field_6a43ba8cd4e50' ) ?: ''; // text
$image       = get_field( 'field_6a43ba9cd4e51' ) ?: ''; // image
$bg_position = $args['bg_position'] ?? 'center center';

$style = '';
if ( ! empty( $image['url'] ) ) {
	$style = ' style="background-image: linear-gradient(rgba(19,19,19,0.86), rgba(19,19,19,0.86)), url(' . esc_url( $image['url'] ) . '); background-position: ' . esc_attr( $bg_position ) . ';"';
}

?>

<section class="intro-band"<?php echo $style; ?>>
	<div class="container animated flow">
		<?php if ( $kicker ) : ?><p class="kicker"><?php echo esc_html( $kicker ); ?></p><?php endif; ?>
		<?php if ( $title ) : ?><h1 class="intro-band__title"><?php echo esc_html( $title ); ?></h1><?php endif; ?>
		<?php if ( $lead ) : ?><p class="intro-band__lead"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	</div>
</section>
