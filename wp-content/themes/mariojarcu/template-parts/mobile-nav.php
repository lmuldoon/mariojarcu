<?php

/**
 * Slide-out mobile navigation panel.
 *
 * Rendered as a sibling of <header>, NOT nested inside it — .site-header
 * has a backdrop-filter, which establishes a new containing block for any
 * position:fixed descendant. If this panel lived inside the header, its
 * height:100% would resolve against the header's own height (~78px)
 * instead of the viewport, squashing the panel and clipping the nav links.
 */

try {
	$menu = new WP_Menu_Query( array(
		'location' => 'header-menu',
	) );
} catch (Exception $e) {
	return;
}

if ( !$menu->have_items() ) {
	return;
}

?>

<div class="menu-body-shade js-menu-body-shade"></div>

<div class="mobile-nav" id="mobile-nav">

	<div class="mobile-nav__header">
		<button class="mobile-nav__close js-site-nav-close" type="button" aria-label="Close menu" aria-controls="mobile-nav">
			Close
			<svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
				<path d="M1 1L13 13M13 1L1 13" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
			</svg>
		</button>
	</div>

	<ul class="mobile-nav__list">

		<?php while ( $menu->have_items() ): ?>

			<?php
				$item = $menu->the_item();
				$classes = $item->classes;

				if ( $item->is_current() || $item->has_current_child() ) {
					$classes[] = 'is-current';
				}

				if ( $item->has_children() ) {
					$classes[] = 'has-children';
				}
			?>
			<li class="<?= esc_attr( implode( ' ', $classes ) ); ?>">

				<a
					class="mobile-nav__item"
					href="<?= esc_url( $item->url ); ?>"
					<?= ( $item->target ? 'target="' . $item->target . '"' : '' ); ?>
					<?php if ( $item->is_current() ): ?>
						aria-current="page"
					<?php endif ?>
				>
					<?= $item->title; ?>
				</a>

			</li>

		<?php endwhile; ?>

	</ul>

	<div class="mobile-nav__footer">
		<a class="button mobile-nav__book-btn" href="<?php echo esc_url( get_permalink( 175 ) ); ?>">Book Now</a>
	</div>

</div>
