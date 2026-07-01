<?php

/**
 * Featured services grid — homepage snapshot.
 */

$services_section = get_field( 'services' ) ?: [];
$section_link      = $services_section['link'] ?? [];
$book_url          = ! empty( $section_link['url'] ) ? esc_url( $section_link['url'] ) : esc_url( get_permalink( 177 ) );
$book_label        = ! empty( $section_link['title'] ) ? $section_link['title'] : 'See the Full Menu & Book';
$book_target        = ! empty( $section_link['target'] ) ? esc_attr( $section_link['target'] ) : '';

$services = mj26_get_featured_services();

?>

<div class="card-grid card-grid--3col animated">
    <?php foreach ( $services as $service ) : ?>
    <article class="card-grid__item">
        <div class="card-grid__media">
            <img src="<?php echo esc_url( $service['image'] ); ?>" alt="<?php echo esc_attr( $service['title'] ); ?>" loading="lazy" />
        </div>
        <div class="card-grid__body">
            <div class="card-grid__row">
                <h3 class="card-grid__title"><?php echo esc_html( $service['title'] ); ?></h3>
                <span class="card-grid__price"><?php echo esc_html( $service['price'] ); ?></span>
            </div>
            <?php if ( $service['desc'] ) : ?><p class="card-grid__desc"><?php echo esc_html( $service['desc'] ); ?></p><?php endif; ?>
            <?php if ( $service['duration'] ) : ?><p class="card-grid__meta"><?php echo esc_html( $service['duration'] ); ?></p><?php endif; ?>
        </div>
    </article>
    <?php endforeach; ?>
</div>

<div class="card-grid__footer">
    <a class="button button--outline" href="<?php echo $book_url; ?>" <?php echo $book_target ? 'target="' . $book_target . '"' : ''; ?>><?php echo esc_html( $book_label ); ?> &rarr;</a>
</div>
