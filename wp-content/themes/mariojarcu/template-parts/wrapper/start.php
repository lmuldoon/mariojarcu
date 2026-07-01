<?php
	
/**
 * Template part for the start of the page wrapper.
 */

$main_class = array();
$main_class = apply_filters('main_class', $main_class);

?>

<main class="<?php echo implode(' ', $main_class); ?>" id="main" role="main">