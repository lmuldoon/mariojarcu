<?php

/**
 * Reviews carousel — Swiper-powered testimonials.
 * Pulls from the "review" custom post type (quote/active/service ACF
 * fields), showing only reviews with Active = Yes, ordered by menu order.
 */

$review_posts = get_posts( [
    'post_type'      => 'review',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'meta_query'     => [
        [
            'key'     => 'active',
            'value'   => '1',
            'compare' => '=',
        ],
    ],
] );

$reviews = array_map( function ( $review_post ) {
    $name = $review_post->post_title;
    return [
        'text'    => get_field( 'quote', $review_post->ID ),
        'name'    => $name,
        'initial' => mb_strtoupper( mb_substr( $name, 0, 1 ) ),
        'service' => get_field( 'service', $review_post->ID ),
    ];
}, $review_posts );

?>

<?php if ( $reviews ) : ?>

<div class="reviews-carousel__nav">
    <button class="reviews-carousel__btn reviews-carousel__btn--prev" aria-label="Previous review">
        <svg width="18" height="10" viewBox="0 0 18 10" fill="none" aria-hidden="true">
            <path d="M17 5H1M1 5L5.5 1M1 5L5.5 9" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
    <button class="reviews-carousel__btn reviews-carousel__btn--next" aria-label="Next review">
        <svg width="18" height="10" viewBox="0 0 18 10" fill="none" aria-hidden="true">
            <path d="M1 5H17M17 5L12.5 1M17 5L12.5 9" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
</div>

<div class="reviews-carousel swiper js-reviews-carousel" role="region" aria-label="Client reviews">
    <div class="swiper-wrapper">
        <?php foreach ( $reviews as $review ) : ?>
        <div class="review-card swiper-slide">
            <div class="review-card__stars" aria-label="5 out of 5 stars">★★★★★</div>
            <blockquote class="review-card__text"><?php echo esc_html( $review['text'] ); ?></blockquote>
            <div class="review-card__footer">
                <div class="review-card__avatar" aria-hidden="true"><?php echo esc_html( $review['initial'] ); ?></div>
                <div class="review-card__meta">
                    <cite class="review-card__name"><?php echo esc_html( $review['name'] ); ?></cite>
                    <?php if ( $review['service'] ) : ?>
                        <span class="review-card__service"><?php echo esc_html( $review['service'] ); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php endif; ?>
