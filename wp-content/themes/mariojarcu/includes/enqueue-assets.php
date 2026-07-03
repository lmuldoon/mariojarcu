<?php

// These functions will be used by mj26_setup_theme() in functions.php

/**
 * Get your Google API Credentials from https://console.developers.google.com/apis/
 * Make sure to set up restrictions so that the key can only be used from certain HTTP Referrers.
 */

/**
 * Registers and enqueues the stylesheets that the theme requires.
 */
function mj26_enqueue_styles() {	
	if( !is_admin() ) {	
		// remove Gutenberg CSS
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');

		/**
		 * Load default theme stylesheet.
		 * false -> No dependancies.
		 */
		wp_register_style( 'theme_css', get_theme_file_uri( 'assets/public/css/screen.min.css' ), false );
		wp_enqueue_style( 'theme_css' );

		/**
		 * Load print stylesheet.
		 * false -> No dependancies.
		 */
		wp_register_style( 'print_css', get_theme_file_uri( 'assets/public/css/print.min.css' ), false, false, 'print' );
		wp_enqueue_style( 'print_css' );
	}
}

/**
 * Registers and enqueues the scripts that the theme requires.
 */
function mj26_enqueue_scripts() {
	if ( !is_admin() ) {

		// Load specific jQuery library from CDN, in noConflict mode ($ not defined)
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', apply_filters( 'basetheme_jquery_url', '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js' ), false, false, true );
		wp_enqueue_script( 'jquery' );

		/**
		 * Shared vendor chunk (GSAP, Swiper) extracted by webpack SplitChunksPlugin.
		 * Must load before header_js and footer_js which depend on it.
		 */
		wp_register_script( 'vendors_js', get_theme_file_uri( 'assets/public/js/vendors.min.js' ), [], false, false );
		wp_enqueue_script( 'vendors_js' );

		/**
		 * Load header scripts.
		 * No dependancies, in header -> default for wp_register_script().
		 * Note: no file_exists() guard here — in production webpack hashes the
		 * filename (header.abc123.min.js), so the unhashed path won't exist on
		 * disk. mj26_revision_assets() rewrites the URL via manifest.json, the
		 * same way footer_js and the stylesheets are handled.
		 */
		wp_register_script ( 'header_js', get_theme_file_uri( 'assets/public/js/header.min.js' ), [ 'vendors_js' ] );
		wp_enqueue_script ( 'header_js' );
		
		/**
		 * Load footer scripts
		 * Dependancies: jQuery
		 * false -> No version string (versions will be revisioned by Gulp.js)
		 * true  -> Load in footer
		 */
		wp_register_script ( 'footer_js', get_theme_file_uri( 'assets/public/js/footer.min.js' ), array( 'jquery', 'vendors_js' ), false, true );
		$footer_js_args = array(
			'template_directory_uri' => trailingslashit(get_template_directory_uri()),
			'stylesheet_directory_uri' => trailingslashit(get_stylesheet_directory_uri()),
		);
		wp_localize_script( 'footer_js', 'wp', $footer_js_args );
		wp_enqueue_script ( 'footer_js' );

	}
}

/**
 * Defer header_js — it only runs on DOMContentLoaded so deferring is safe
 * and removes it from the render-blocking critical path.
 */
add_filter( 'script_loader_tag', function( $tag, $handle ) {
	if ( 'header_js' === $handle ) {
		return str_replace( '<script ', '<script defer ', $tag );
	}
	return $tag;
}, 10, 2 );

/**
 * Register and enqueue Google Maps scripts for pages that require it.
 */
function mj26_enqueue_google_scripts() {
	global $post;

	if ( 
		!is_admin() && 
		'' !== GOOGLE_API_KEY && 
		apply_filters( 'page_has_google_map', false, $post ) 
	) {

		/**
		 * Load Google Maps JavaScript API.
		 * No dependancies
		 * false -> No version string
		 * true  -> Load in footer
		 */
		wp_register_script ("google-maps-api", "https://maps.googleapis.com/maps/api/js?libraries=places,marker&v=beta&key=" . GOOGLE_API_KEY, array(), false, true);
		wp_enqueue_script ("google-maps-api");

		/**
		 * Load script to initialise all maps on page.
		 * Dependancies: jQuery
		 * false -> No version string
		 * true  -> Load in footer
		 */
		wp_register_script ("initialise-google-maps", get_theme_file_uri( 'assets/public/js/google_maps.min.js' ), array( 'jquery' ), false, true);
		wp_enqueue_script ("initialise-google-maps");

	}
}

/**
 * Mapbox GL is now lazy-loaded via IntersectionObserver in
 * assets/src/js/scripts/lazy-map.js — it only downloads when the
 * #mapbox-map element approaches the viewport, removing ~229KB of JS
 * from the critical path and improving mobile performance significantly.
 * The function stub is kept so existing references don't fatal.
 */
function mj26_enqueue_mapbox() {
	// No-op — Mapbox is now lazy-loaded in footer.js via lazy-map.js
}

/**
 * Add the Google API key to the Advanced Custom Fields plugin.
 * @param  array $api  The API credentials in use.
 * @return array
 */
add_filter( 'acf/fields/google_map/api', 'mj26_add_acf_api_creds' );
function mj26_add_acf_api_creds( $api ) {
	if ( '' !== GOOGLE_API_KEY ) {
		$api['key'] = GOOGLE_API_KEY;
	}

	return $api;
}

/**
 * Include an asset file into the document, only if it exists.
 * Note: fails silently if path does not exist.
 * @param  string $path The path to the asset relative to the theme directory.
 */
function include_asset( $path ) {
	$path = get_theme_file_path( $path );

	if ( $path && file_exists($path) && is_readable($path) ) {
		include $path;
	}
}
