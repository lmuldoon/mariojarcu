<?php

/**
 * Gold full-width call-to-action band.
 * Args: title, text, btn_label, btn_url
 */

$title     = $args['title'] ?? 'Ready when you are.';
$text      = $args['text'] ?? '';
$btn_label = $args['btn_label'] ?? 'Book your chair';
$btn_url   = $args['btn_url'] ?? esc_url( get_permalink( 175 ) );

?>

<section class="cta-band">
	<div class="container container--narrow animated">
		<div class="cta-band__text">
			<h2><?php echo esc_html( $title ); ?></h2>
			<?php if ( $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
		</div>
		<a class="button button--white" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_label ); ?></a>
	</div>
</section>
