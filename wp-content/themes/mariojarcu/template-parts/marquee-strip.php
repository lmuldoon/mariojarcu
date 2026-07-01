<?php

/**
 * Infinite scrolling ticker strip — service keywords below the hero.
 * The word list is output twice so the loop seam is invisible — when the
 * first copy scrolls fully off-screen, the identical second copy is
 * already in place behind it. The CSS animation shifts by exactly -50%
 * (one copy's width) so the transition is seamless.
 */

$marquee_words = [
    'CLASSIC HAIRCUTS',
    'SKIN FADES',
    'TAPER FADES',
    'BEARD TRIMS',
    'SHAPE-UPS',
    'HOT TOWEL SHAVES',
    'HEAD SHAVES',
    'BUZZ CUTS',
    'COMBO DEALS',
    'KIDS CUTS',
];

?>

<div class="marquee" aria-hidden="true">
    <div class="marquee__track">
        <?php
        // Output twice for the seamless infinite loop
        for ( $pass = 0; $pass < 2; $pass++ ) :
            foreach ( $marquee_words as $word ) :
        ?>
            <span class="marquee__word"><?php echo esc_html( $word ); ?></span>
            <span class="marquee__star">&#9733;</span>
        <?php
            endforeach;
        endfor;
        ?>
    </div>
</div>
