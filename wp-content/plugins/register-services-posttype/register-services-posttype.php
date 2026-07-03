<?php

/**
 * ----------------------------
 * QUICK START
 * ----------------------------
 *
 * Use Find & Replace in this file to replace each instance of the placeholders below
 *
 * 		service 			=> The name of the post type, e.g. post, page. Should be all lowercase.
 *		Services 				=> The plural label for the post type. Shown in wp-admin.
 *		Service 			=> The singular label for the post type. Shown in wp-admin.
 *		tag 					=> The name of a dashicon to show next to the post type name.
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
 * Plugin Name: Register Services Post Type
 * Description: This plugin registers a new post type called Service, [service]
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

if ( !class_exists( 'RPT_service' ) ) {

	class RPT_service {

		public $post_type;
    public $singular_label;
    public $plural_label;
    public $icon;
    public $supports;

		function __construct() {
			$this->post_type = 'service';
			$this->singular_label = 'Service';
			$this->plural_label = 'Services';
			$this->icon = 'dashicons-tag';

			/**
			 * Modify this array to change what the post type supports when editing.
			 * @see https://codex.wordpress.org/Function_Reference/register_post_type#supports
			 */
			$this->supports = array(
				'title',
				'revisions',
				// menu_order
				'page-attributes',
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

			// Register a custom taxonomy (if needed)
			$this->_registerTaxonomy( 'service_group', 'Service Group', 'Service Groups' );
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
		 * Register a custom taxonomy for this post type.
		 * @param  string $taxonomy_slug  The taxonomy name.
		 * @param  string $singular_label The singular label for the taxonomy.
		 * @param  stirng $plural_label   The plural label for the taxonomy.
		 */
		private function _registerTaxonomy( $taxonomy_slug, $singular_label, $plural_label ) {
			$args = array(
				// Makes the quick edit show checkboxes instead of text input
		    'hierarchical'      => true,
		    'labels'            => $this->_getTaxonomyLabels( $singular_label, $plural_label ),
		    'show_admin_column' => true,
		    'query_var'         => false,
		    // No public URLs — this taxonomy is admin-only for grouping
		    // private post types. Setting public:false + rewrite:false stops
		    // Yoast from generating sitemap entries and makes any direct URL
		    // return a 404.
		    'public'            => false,
		    'publicly_queryable' => false,
		    'rewrite'           => false,
			);

		  register_taxonomy( $taxonomy_slug, $this->post_type, $args );
		}

		/**
		 * Get the labels for the taxonomy.
		 * @return array
		 */
		private function _getTaxonomyLabels( $singular_label, $plural_label ) {
			$labels = array(
				'name'              => _x( $plural_label, 'taxonomy general name' ),
				'singular_name'     => _x( $singular_label, 'taxonomy singular name' ),
				'search_items'      => __( 'Search ' . $plural_label ),
				'all_items'         => __( 'All ' . $plural_label ),
				'parent_item'       => __( 'Parent ' . $singular_label ),
				'parent_item_colon' => __( 'Parent ' . $singular_label . ':' ),
				'edit_item'         => __( 'Edit ' . $singular_label ),
				'update_item'       => __( 'Update ' . $singular_label ),
				'add_new_item'      => __( 'Add New ' . $singular_label ),
				'new_item_name'     => __( 'New ' . $singular_label ),
				'menu_name'         => __( $plural_label ),
				'not_found'					=> __('No ' . strtolower( $plural_label ) . ' found'),
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
				'price'    => 'Price',
				'duration' => 'Duration',
				'tag'      => 'Tag',
			);

			$remove_column_keys = array();

			foreach ($columns as $key => $column_name) {
				if ( 'date' === $key ) {
					$_columns['menu_order'] = 'Order';
				}

				if ( 'title' === $key ) {
					$_columns['thumbnail'] = 'Thumbnail';
				}

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
			return $columns;
		}

		/**
		 * Display the data for each custom column.
		 * @param string  $column_name The key of the column.
		 * @param integer $post_id     The ID of the post being displayed.
		 */
		public function display_column_data( $column_name, $post_id ) {
			$_post = get_post( $post_id );

			switch ( $column_name ) {
				// Handle specific cases
				// case 'meta_key':
				// 	# code...
				// 	break;

				case 'thumbnail':
					$thumbnail_id = get_post_meta( $post_id, 'image', true );
					if ( $thumbnail_id ) {

	          ?>

	          <a href="<?php echo get_edit_post_link( $post_id ); ?>">
	            <img <?php echo $this->get_image_attributes( $thumbnail_id, 'thumbnail' ); ?> style="display:block; max-width:100%; width:300px; height:auto;" >
	          </a>

	          <?php

	        } else {
	          ?>

	          <span aria-hidden="true">—</span>
	          <span class="screen-reader-text">No thumbnail</span>

	          <?php
	        }
					break;

				case 'menu_order':
					echo $_post->menu_order;
					break;

				// By default, try to get the meta and display it
				default:
					$column_data = get_post_meta( $post_id, $column_name, true );
					echo $column_data ? $column_data : '—';
					break;
			}
		}

		/**
		 * Get the attributes for an image attachment from the media library.
		 *
		 * @param integer $image_id The image attachment to get.
		 * @param string $size Optional, The size of the image attachment to get, e.g. 'full', 'thumbnail'. 'full' is used by default.
		 *
		 * @return string The attributes needed to output the image.
		 */
		private function get_image_attributes( $image_id, $size = 'full' ) {
		  $image = $this->get_image( $image_id, $size );

		  if ( !$image ) {
		    return false;
		  }

		  return sprintf(
		    'src="%s" alt="%s" width="%s" height="%s"',
		    $image['src'],
		    $image['alt'],
		    $image['width'],
		    $image['height']
		  );
		}

		/**
		 * Get an image attachment from the media library.
		 *
		 * @param integer $image_id The image attachment to get.
		 * @param string $size Optional, The size of the image attachment to get, e.g. 'full', 'thumbnail'. 'full' is used by default.
		 *
		 * @return array An array containing the image src, width & height and the alt text.
		 */
		private function get_image( $image_id, $size = 'full' ) {
		  if ( $image = wp_get_attachment_image_src( $image_id, $size ) ) {
		    return array(
		      'src' => $image[0],
		      'width' => $image[1],
		      'height' => $image[2],
		      'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
		    );
		  }
		}

	}

}

$rpt_service = new RPT_service();
