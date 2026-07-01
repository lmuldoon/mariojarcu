<?php

/**
 * ----------------------------
 * QUICK START
 * ----------------------------
 *
 * Use Find & Replace in this file to replace each instance of the placeholders below
 *
 * 		closure 			=> The name of the post type, e.g. post, page. Should be all lowercase.
 *		Closures 				=> The plural label for the post type. Shown in wp-admin.
 *		Closure 			=> The singular label for the post type. Shown in wp-admin.
 *		calendar-alt 					=> The name of a dashicon to show next to the post type name.
 *														@see https://developer.wordpress.org/resource/dashicons/
 *
 * Change the core settings of the post type in the __construct() function.
 *
 * Add custom columns by modifying the array in the add_columns() function.

 * Register taxonomies by using the commented placeholder function in the init() function.
 *
 * If the post type requires a custom hook such as save_post,
 * you can add it here as a new method such as
 *  		public function save_post( $post_id, $_post, $update ) {
 *  			if ( !is_admin() || $this->post_type !== $_post->post_type ) {
 *					return;
 *				}
 *
 *				# code...
 *  		}
 *
 * Then register the hook in the __construct() function like this:
 * 		// save_post is an action hook so use _addAction()
 * 		// For filters use _addFilter()
 * 		$this->_addAction( 'save_post', 20, 3 );
 *
 */

/**
 * Plugin Name: Register Closures Post Type
 * Description: This plugin registers a new post type called Closure, [closure] — used for holiday / out-of-office date ranges.
 * Version: 2.0.0
 * Author: Adam Taylor
 * License: GPL2
 */

/*  Copyright 2017  Adam Taylor

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !class_exists( 'RPT_closure' ) ) {

	class RPT_closure {

		public $post_type;
    public $singular_label;
    public $plural_label;
    public $icon;
    public $supports;

		function __construct() {
			$this->post_type = 'closure';
			$this->singular_label = 'Closure';
			$this->plural_label = 'Closures';
			$this->icon = 'dashicons-calendar-alt';

			/**
			 * Modify this array to change what the post type supports when editing.
			 * @see https://codex.wordpress.org/Function_Reference/register_post_type#supports
			 */
			$this->supports = array(
				'title',
				'revisions',
			);

			// Set up hooks
			$this->_addAction( 'init' );
			$this->_registerCustomColumns();
		}

		/**
		 * Add a WordPress action linked to a method on this class.
		 * @param string  $hook_name The name of the action & function that handles it.
		 * @param integer $priority
		 * @param integer $args
		 */
		private function _addAction( $hook_name, $priority = 20, $args = 1 ) {
			add_action( $hook_name, array( $this, $hook_name ), $priority, $args );
		}

		/**
		 * Add a WordPress filter linked to a method on this class.
		 * @param string  $hook_name The name of the action & function that handles it.
		 * @param integer $priority
		 * @param integer $args
		 */
		private function _addFilter( $hook_name, $priority = 20, $args = 1 ) {
			add_filter( $hook_name, array( $this, $hook_name ), $priority, $args );
		}

		/**
		 * Fires on WordPress's init hook
		 */
		public function init() {
			$this->_registerPostType();

			// No taxonomy needed for closures — each one is independent.
		}

		/**
		 * Register the post type.
		 */
		private function _registerPostType() {
			$args = array(
				'labels'             => $this->_getLabels(),
				'public'             => false,
				'publicly_queryable' => false,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'capability_type'    => 'post',
				'has_archive'        => false,
				'hierarchical'       => false,
				'menu_position'      => null,
				'rewrite'						 => false,
				'menu_icon'			 		 =>	$this->icon,
				'supports'       		 => $this->supports,
			);

			register_post_type( $this->post_type, $args );
		}

		/**
		 * Get the labels for the post type.
		 * @return array
		 */
		private function _getLabels() {
			$labels = array(
				'name'               => _x( $this->plural_label, 'post type general name' ),
				'singular_name'      => _x( $this->singular_label, 'post type singular name' ),
				'menu_name'          => _x( $this->plural_label, 'admin menu' ),
				'name_admin_bar'     => _x( $this->singular_label, 'add new on admin bar' ),
				'add_new'            => _x( 'Add New', $this->singular_label ),
				'add_new_item'       => __( 'Add New ' . $this->singular_label ),
				'new_item'           => __( 'New ' . $this->singular_label ),
				'edit_item'          => __( 'Edit ' . $this->singular_label ),
				'view_item'          => __( 'View ' . $this->singular_label ),
				'all_items'          => __( 'All ' . $this->plural_label ),
				'search_items'       => __( 'Search ' . $this->plural_label ),
				'parent_item_colon'  => __( 'Parent ' . $this->plural_label . ':' ),
				'not_found'          => __( 'No '. strtolower( $this->plural_label ) .' found.' ),
				'not_found_in_trash' => __( 'No '. strtolower( $this->plural_label ) .' found in Trash.' )
			);

			return $labels;
		}

		/**
		 * Register any custom columns we need for the post type.
		 */
		private function _registerCustomColumns() {
			add_filter(
				sprintf( 'manage_edit-%s_columns', $this->post_type ),
				array( $this, 'define_columns' )
			);

			add_filter(
				sprintf( 'manage_edit-%s_sortable_columns', $this->post_type ),
				array( $this, 'define_sortable_columns' )
			);

			add_action(
				sprintf( 'manage_%s_posts_custom_column', $this->post_type ),
				array( $this, 'display_column_data' ),
				20,
				2
			);
		}

		/**
		 * Define the custom column structure.
		 * @param array $columns The current columns.
		 * @return array The new columns.
		 */
		public function define_columns( $columns ) {
			$_columns = array();

			/**
			 * Add new column names to the array below.
			 * 		key => The meta key for the custom field this column represents.
			 * 		value => The title of the column
			 * @var array
			 */
			$new_columns = array(
				'start_date' => 'Start Date',
				'end_date'   => 'End Date',
			);

			$remove_column_keys = array( 'date' );

			foreach ($columns as $key => $column_name) {

				if ( !in_array( $key, $remove_column_keys ) ) {
					$_columns[ $key ] = $column_name;
				}

				if ( 'title' === $key ) {

					foreach ($new_columns as $new_key => $new_column_name) {
						$_columns[ $new_key ] = $new_column_name;
					}

				}
			}

			return $_columns;
		}

		/**
		 * Define the custom sortable columns structure.
		 * @param array $columns The current sortable columns.
		 * @return array The new sortable columns.
		 */
		public function define_sortable_columns( $columns ) {
			$columns['start_date'] = 'start_date';
			return $columns;
		}

		/**
		 * Display the data for each custom column.
		 * @param string  $column_name The key of the column.
		 * @param integer $post_id     The ID of the post being displayed.
		 */
		public function display_column_data( $column_name, $post_id ) {
			switch ( $column_name ) {

				// By default, try to get the meta and display it
				default:
					$column_data = get_post_meta( $post_id, $column_name, true );
					echo $column_data ? esc_html( $column_data ) : '—';
					break;
			}
		}

	}

}

$rpt_closure = new RPT_closure();
