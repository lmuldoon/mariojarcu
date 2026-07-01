<?php

/**
 * Single source of truth for the service menu — used by the homepage
 * services grid and the full Services page price list.
 *
 * Reads from the "service" custom post type (registered by the
 * register-services-posttype plugin), ordered by menu order (Page
 * Attributes), grouped by the "service_group" taxonomy.
 */
function mj26_get_services() {
	static $services = null;

	if ( null !== $services ) {
		return $services;
	}

	$services = [];

	$posts = get_posts( [
		'post_type'      => 'service',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	] );

	foreach ( $posts as $service_post ) {
		$image    = get_field( 'image', $service_post->ID );
		$duration = get_field( 'duration', $service_post->ID );
		$price    = get_field( 'price', $service_post->ID );
		$groups   = get_the_terms( $service_post->ID, 'service_group' );

		$services[] = [
			'title'    => $service_post->post_title,
			'desc'     => get_field( 'description', $service_post->ID ),
			'duration' => $duration ? $duration . ' Min' : '',
			'price'    => $price !== '' && $price !== null ? '£' . number_format( (float) $price, 0 ) : '',
			'image'    => $image['sizes']['medium_large'] ?? ( $image['url'] ?? '' ),
			'group'    => ( $groups && ! is_wp_error( $groups ) ) ? wp_specialchars_decode( $groups[0]->name ) : '',
		];
	}

	return $services;
}

/**
 * Services with a photo attached — used for the homepage preview grid.
 * @param  int $limit Max number of services to return.
 * @return array
 */
function mj26_get_featured_services( $limit = 6 ) {
	$with_images = array_values( array_filter( mj26_get_services(), function ( $service ) {
		return ! empty( $service['image'] );
	} ) );

	return array_slice( $with_images, 0, $limit );
}
