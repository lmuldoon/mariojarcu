<?php

/**
 * Opening hours table. Data comes from mj26_get_opening_hours()
 * (see includes/opening-hours.php).
 */

$today = strtolower( date('l') );
$hours = mj26_get_opening_hours();
?>

<div class="opening-times">
    <p class="opening-times__heading">Hours</p>
    <?php foreach ( $hours as $key => $day ) :
        $is_today  = $key === $today;
        $is_closed = empty( $day['time'] );
        $classes   = 'opening-times__row';
        if ( $is_today )  $classes .= ' is-today';
        if ( $is_closed ) $classes .= ' is-closed';
    ?>
    <div class="<?php echo $classes; ?>">
        <span class="opening-times__day"><?php echo esc_html( $day['label'] ); ?> <span class="opening-times__date"><?php echo esc_html( $day['date'] ); ?></span></span>
        <span class="opening-times__dots"></span>
        <span class="opening-times__time"><?php echo $is_closed ? 'Closed' : esc_html( $day['time'] ); ?></span>
    </div>
    <?php endforeach; ?>
</div>
