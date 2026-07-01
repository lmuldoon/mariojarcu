<?php

/**
 * Shared opening-hours helpers.
 * Source of truth is the "Opening Hours" group nested inside the Location
 * group on the Home page (id 2) — same fields edited in wp-admin that
 * drive the homepage Location section's hours table.
 */

/**
 * Get any "closure" posts (holiday/out-of-office date ranges) as a
 * normalised list. Reversed ranges (end before start) are swapped round
 * rather than silently ignored, since that's an easy mistake to make when
 * entering dates.
 * @return array list of [ 'title' => string, 'start' => 'Ymd', 'end' => 'Ymd' ]
 */
function mj26_get_closures() {
	$closure_posts = get_posts( [
		'post_type'      => 'closure',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	] );

	$closures = [];
	foreach ( $closure_posts as $closure_post ) {
		$start = get_field( 'start_date', $closure_post->ID );
		$end   = get_field( 'end_date', $closure_post->ID ) ?: $start;

		if ( ! $start ) {
			continue;
		}

		if ( $end < $start ) {
			[ $start, $end ] = [ $end, $start ];
		}

		$closures[] = [
			'title' => $closure_post->post_title,
			'start' => $start,
			'end'   => $end,
		];
	}

	return $closures;
}

/**
 * Find the closure (if any) covering a given date.
 * @param  string $date_ymd Date in 'Ymd' format.
 * @param  array  $closures Optional, pass an already-fetched list to avoid re-querying in a loop.
 * @return array|null
 */
function mj26_get_closure_for_date( $date_ymd, $closures = null ) {
	$closures = $closures ?? mj26_get_closures();

	foreach ( $closures as $closure ) {
		if ( $date_ymd >= $closure['start'] && $date_ymd <= $closure['end'] ) {
			return $closure;
		}
	}

	return null;
}

/**
 * Get the per-day opening hours as a simple associative array, for the
 * current calendar week — taking into account any "closure" post that
 * covers that specific date (e.g. a holiday closure overrides the normal
 * recurring hours for that day).
 * @return array day key => [ 'label' => string, 'date' => string, 'time' => string|null, 'closure_label' => string|null ]
 *               ('label' is e.g. "Monday", 'date' is e.g. "1 Jul", 'time' is null when closed,
 *               whether normally or via a closure)
 */
function mj26_get_opening_hours() {
	$day_labels = [
		'monday'    => 'Monday',
		'tuesday'   => 'Tuesday',
		'wednesday' => 'Wednesday',
		'thursday'  => 'Thursday',
		'friday'    => 'Friday',
		'saturday'  => 'Saturday',
		'sunday'    => 'Sunday',
	];

	$location_fields = get_field( 'location', 2 ) ?: [];
	$opening_hours   = $location_fields['opening_hours'] ?? [];
	$closures        = mj26_get_closures();

	// Find this week's Monday so each day name can be checked against
	// closure date ranges.
	$today    = new DateTime( 'today' );
	$iso_dow  = (int) $today->format( 'N' ); // 1 (Mon) .. 7 (Sun)
	$monday   = ( clone $today )->modify( '-' . ( $iso_dow - 1 ) . ' days' );

	$hours = [];
	$i     = 0;
	foreach ( $day_labels as $key => $label ) {
		$date     = ( clone $monday )->modify( "+{$i} days" );
		$date_ymd = $date->format( 'Ymd' );
		$i++;

		$is_closed = ! empty( $opening_hours[ $key . '_closed' ] );
		$time      = $opening_hours[ $key . '_hours' ] ?? '';

		$closure = mj26_get_closure_for_date( $date_ymd, $closures );
		if ( $closure ) {
			$is_closed = true;
		}

		$hours[ $key ] = [
			'label'         => $label,
			'date'          => $date->format( 'j M' ),
			'time'          => $is_closed ? null : $time,
			'closure_label' => $closure['title'] ?? null,
		];
	}

	return $hours;
}

/**
 * Get a compact, human-readable summary of the week's hours, grouping
 * consecutive days that share the same hours (or are both closed), e.g.
 * "Tue–Fri 9am – 6pm · Sat 8am – 4:30pm · Mon, Sun Closed".
 * @return string
 */
function mj26_get_opening_hours_summary() {
	$short_labels = [
		'monday'    => 'Mon',
		'tuesday'   => 'Tue',
		'wednesday' => 'Wed',
		'thursday'  => 'Thu',
		'friday'    => 'Fri',
		'saturday'  => 'Sat',
		'sunday'    => 'Sun',
	];

	$hours = mj26_get_opening_hours();

	$groups = [];
	foreach ( $hours as $key => $day ) {
		$value = $day['time'] ?: 'Closed';
		$short = $short_labels[ $key ];

		$last_index = count( $groups ) - 1;
		if ( $last_index >= 0 && $groups[ $last_index ]['value'] === $value ) {
			$groups[ $last_index ]['days'][] = $short;
		} else {
			$groups[] = [
				'value' => $value,
				'days'  => [ $short ],
			];
		}
	}

	$parts = [];
	foreach ( $groups as $group ) {
		$days_label = count( $group['days'] ) > 1
			? $group['days'][0] . '–' . end( $group['days'] )
			: $group['days'][0];

		$parts[] = $days_label . ' ' . $group['value'];
	}

	return implode( ' · ', $parts );
}
