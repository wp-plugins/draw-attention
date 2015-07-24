<?php
class DrawAttention_CPT {
	public $post_type = 'da_image';
	public $singular_name = 'Image';

	function __construct( $parent ) {

		add_action( 'init' , array( $this, 'register_cpt' ) );
		// add_filter( 'manage_edit-' . $this->post_type . '_columns', array( $this, 'register_custom_column_headings' ), 10, 1 );
		// add_action( 'manage_' . $this->post_type .'_posts_custom_column', array( $this, 'register_custom_columns' ), 10, 2 );

		add_action( 'init', array( $this, 'load_drag_drop_featured_image' ) );
	}

	function load_drag_drop_featured_image() {
		global $drag_drop_featured_image_map;
		if ( empty( $drag_drop_featured_image_map ) || !class_exists( 'WP_Drag_Drop_Featured_Image_Map' ) ) {
			include_once( 'lib/drag-drop-featured-image/index.php' );
			if ( !class_exists( 'WP_Drag_Drop_Featured_Image_Map' ) ) return;
			$drag_drop_featured_image_map = new WP_Drag_Drop_Featured_Image_Map;
		}
	}




	function register_cpt() {
		$result = register_post_type( $this->post_type, /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		 	// let's now add all the options for this post type
			array('labels' => array(
				'name' => __('Draw Attention', $this->post_type.' general name', 'drawattention'), /* This is the Title of the Group */
				'singular_name' => __('Image', $this->post_type.' singular name', 'drawattention'), /* This is the individual type */
				'all_items' => __('All Images', 'drawattention'), /* the all items menu item */
				'add_new' => __('Add New', 'custom '.$this->post_type.' item', 'drawattention'), /* The add new menu item */
				'add_new_item' => __('Add New Image', 'drawattention'), /* Add New Display Title */
				'edit' => __( 'Edit' ), /* Edit Dialog */
				'edit_item' => __('Edit Image', 'drawattention'), /* Edit Display Title */
				'new_item' => __('New Image', 'drawattention'), /* New Display Title */
				'view_item' => __('View Image', 'drawattention'), /* View Display Title */
				'search_items' => __('Search Images', 'drawattention'), /* Search CPT_SINGULAR_NAME Title */
				'not_found' =>  __('Nothing found in the Database.', 'drawattention'), /* This displays if there are no entries yet */
				'not_found_in_trash' => __('Nothing found in Trash', 'drawattention'), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
				), /* end of arrays */
				'description' => __( 'Stores '.$this->post_type.'s in the database', 'drawattention' ), /* CPT_SINGULAR_NAME Description */
				'public' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
				'menu_icon' => 'dashicons-images-alt2', /* the icon for the custom post type menu */
				'rewrite'	=> false,
				'has_archive' => $this->post_type.'s', /* you can rename the slug here */
				// 'capabilities' => array(
				// 	'edit_post' => 'subscriber',
				// 	'edit_posts' => 'subscriber',
				// 	'edit_others_posts' => 'subscriber',
				// 	'publish_posts' => 'subscriber',
				// 	'read_post' => 'subscriber',
				// 	'read_private_posts' => 'subscriber',
				// 	'delete_post' => 'subscriber'
				// ),

				'hierarchical' => false,
				/* the next one is important, it tells what's enabled in the post editor */
				'supports' => array( 'title', 'thumbnail' ),
		 	) /* end of options */
		); /* end of register post type */
	}

	function get_image ( $id, $size = 'projects-thumbnail' ) {
		$response = '';

		if ( has_post_thumbnail( $id ) ) {
			// If not a string or an array, and not an integer, default to 150x9999.
			if ( is_int( $size ) || ( 0 < intval( $size ) ) ) {
				$size = array( intval( $size ), intval( $size ) );
			} elseif ( ! is_string( $size ) && ! is_array( $size ) ) {
				$size = array( 150, 9999 );
			}
			$response = get_the_post_thumbnail( intval( $id ), $size );
		}

		return $response;
	} // End projects_get_image()

	/**
	 * Add custom columns for the "manage" screen of this post type.
	 *
	 * @access public
	 * @param string $column_name
	 * @param int $id
	 * @since  1.0.0
	 * @return void
	 */
	public function register_custom_columns ( $column_name, $id ) {
		global $wpdb, $post;

		$meta = get_post_custom( $id );

		switch ( $column_name ) {

			case 'image':
			$value = '';

			$value = $this->get_image( $id, 120 );

			echo $value;
			break;

			default:
			break;

		}
	} // End register_custom_columns()

	/**
	 * Add custom column headings for the "manage" screen of this post type.
	 *
	 * @access public
	 * @param array $defaults
	 * @since  1.0.0
	 * @return void
	 */
	public function register_custom_column_headings ( $defaults ) {

		$new_columns          = array();
		$new_columns['cb']    = $defaults['cb'];
		$new_columns['image'] = __( 'Image', 'drawattention' );

		$last_item = '';

		if ( isset( $defaults['date'] ) ) { unset( $defaults['date'] ); }

		if ( count( $defaults ) > 2 ) {
			$last_item = array_slice( $defaults, -1 );

			array_pop( $defaults );
		}
		$defaults = array_merge( $new_columns, $defaults );

		if ( $last_item != '' ) {
			foreach ( $last_item as $k => $v ) {
				$defaults[$k] = $v;
				break;
			}
		}

		return $defaults;
	} // End register_custom_column_headings()
}
