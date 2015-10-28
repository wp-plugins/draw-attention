<?php
/**
 * Plugin Name.
 *
 * @package   DrawAttention_Admin
 * @author    Nathan Tyler <support@tylerdigital.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Tyler Digital
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-drawattention.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package DrawAttention_Admin
 * @author  Nathan Tyler <support@tylerdigital.com>
 */
if ( !class_exists( 'DrawAttention_Admin' ) ) {
	class DrawAttention_Admin {

		public $upsell;
		public $script_handle_whitelist;

		/**
		 * Instance of this class.
		 *
		 * @since    1.0.0
		 *
		 * @var      object
		 */
		static $instance = null;
		public $da;

		/**
		 * Slug of the plugin screen.
		 *
		 * @since    1.0.0
		 *
		 * @var      string
		 */
		protected $plugin_screen_hook_suffix = null;

		/**
		 * Initialize the plugin by loading admin scripts & styles and adding a
		 * settings page and menu.
		 *
		 * @since     1.0.0
		 */
		private function __construct() {

			/*
			 * @TODO :
			 *
			 * - Uncomment following lines if the admin class should only be available for super admins
			 */
			/* if( ! is_super_admin() ) {
				return;
			} */

			/*
			 * Call $plugin_slug from public plugin class.
			 *
			 * @TODO:
			 *
			 * - Rename "DrawAttention" to the name of your initial plugin class
			 *
			 */
			$this->da = DrawAttention::get_instance();
			$this->plugin_slug = $this->da->get_plugin_slug();

			// Load admin style sheet and JavaScript.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );

			add_action( 'admin_notices', array( $this, 'display_third_party_js_conflict_notice' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'store_enqueued_scripts' ), 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'disable_third_party_js' ), 9999999 );

			// Add the options page and menu item.
			// add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

			// Add an action link pointing to the options page.
			// $plugin_basename = 'draw-attention/' . DrawAttention::slug . '.php';
			// add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

			include 'upsell-admin.php';
			$this->upsell = new DrawAttention_Upsell( $this );
		}

		/**
		 * Return an instance of this class.
		 *
		 * @since     1.0.0
		 *
		 * @return    object    A single instance of this class.
		 */
		public static function get_instance() {

			/*
			 * @TODO :
			 *
			 * - Uncomment following lines if the admin class should only be available for super admins
			 */
			/* if( ! is_super_admin() ) {
				return;
			} */

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Register and enqueue admin-specific style sheet.
		 *
		 * @TODO:
		 *
		 * - Rename "DrawAttention" to the name your plugin
		 *
		 * @since     1.0.0
		 *
		 * @return    null    Return early if no settings page is registered.
		 */
		public function enqueue_admin_styles() {
			$screen = get_current_screen();
			if ( $this->da->cpt->post_type==$screen->post_type || $this->plugin_screen_hook_suffix == $screen->id ) {
				wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), DrawAttention::VERSION );
			}

		}

		/**
		 * Register and enqueue admin-specific JavaScript.
		 *
		 * @TODO:
		 *
		 * - Rename "DrawAttention" to the name your plugin
		 *
		 * @since     1.0.0
		 *
		 * @return    null    Return early if no settings page is registered.
		 */
		public function enqueue_admin_scripts() {

			$screen = get_current_screen();
			if ( $this->da->cpt->post_type==$screen->post_type || $this->plugin_screen_hook_suffix == $screen->id ) {
				wp_register_script( $this->plugin_slug . '-canvasareadraw', plugins_url( 'assets/js/jquery.canvasAreaDraw.js', __FILE__ ), array( 'jquery' ), DrawAttention::VERSION );
				wp_register_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery', $this->plugin_slug . '-canvasareadraw' ), DrawAttention::VERSION );
				do_action( 'da_register_admin_script' );
				wp_localize_script( $this->plugin_slug . '-admin-script', 'hotspotAdminVars', array(
					'ajaxURL' => admin_url( 'admin-ajax.php' ),
				) );
				wp_enqueue_script( $this->plugin_slug . '-admin-script' );
			}

		}

		/**
		 * Register the administration menu for this plugin into the WordPress Dashboard menu.
		 *
		 * @since    1.0.0
		 */
		public function add_plugin_admin_menu() {

			/*
			 * Add a settings page for this plugin to the Settings menu.
			 *
			 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
			 *
			 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
			 *
			 * @TODO:
			 *
			 * - Change 'Page Title' to the title of your plugin admin page
			 * - Change 'Menu Text' to the text for menu item for the plugin settings page
			 * - Change 'manage_options' to the capability you see fit
			 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
			 */
			$this->plugin_screen_hook_suffix = add_options_page(
				__( 'DrawAttention', $this->plugin_slug ),
				__( 'DrawAttention', $this->plugin_slug ),
				'manage_options',
				$this->plugin_slug,
				array( $this, 'display_plugin_admin_page' )
			);
		}

		/**
		 * Render the settings page for this plugin.
		 *
		 * @since    1.0.0
		 */
		public function display_plugin_admin_page() {
			if ( class_exists( 'CMB2_hookup' ) ) {
				CMB2_hookup::enqueue_cmb_css();
				CMB2_hookup::enqueue_cmb_js();
			}
			include_once( 'views/admin.php' );
		}

		/**
		 * Add settings action link to the plugins page.
		 *
		 * @since    1.0.0
		 */
		public function add_action_links( $links ) {

			return array_merge(
				array(
					'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
				),
				$links
			);

		}

		public function admin_menu() {
			global $submenu;

			remove_submenu_page( 'edit.php?post_type=da_image', 'post-new.php?post_type=da_image'  );
			remove_submenu_page( 'edit.php?post_type=da_image', 'edit.php?post_type=da_image'  );
			add_submenu_page( 'edit.php?post_type=da_image', __('Edit Image', 'drawattention'), __('Edit Image', 'drawattention'), 'edit_posts', 'edit.php?post_type=da_image' );
		}

		public function admin_init() {
			if ( empty( $_GET['post_type'] ) ) {
				return;
			}
			
			global $pagenow;
			if (
				$pagenow == 'edit.php' && $_GET['post_type'] == $this->da->cpt->post_type
				|| $pagenow == 'post-new.php' && $_GET['post_type'] == $this->da->cpt->post_type
			) {
				$image_args = array(
					'post_status' => 'any',
					'post_type' => $this->da->cpt->post_type,
					'posts_per_page' => 1,
					);
				$image = new WP_Query($image_args);
				if ($image->have_posts() ) {
					$image->the_post();
					$imageID = get_the_ID();
				}
				wp_reset_query();

				if ( empty( $imageID ) ) {
					$imageID = wp_insert_post( array(
						'post_type' => 'da_image',
						'post_status' => 'publish',
						'post_title' => '',
					) );
					DrawAttention_Themes::apply_theme( $imageID, 'drawattention' );
				}
				if ( empty( $imageID ) ) die( 'An error occurred setting up DrawAttention, please contact support@tylerdigital.com');

				wp_redirect( get_edit_post_link( $imageID, 'raw' ) );
				exit();
			}
		}

		public function display_third_party_js_conflict_notice() {
			global $pagenow;
			$screen = get_current_screen();
			if ( $screen->base != 'post' || $screen->post_type != $this->da->cpt->post_type ) {
				return;
			}
			if ( get_option( 'da_disable_third_party_js' ) ) {
				return;
			}

			if ( !empty( $_GET['da_disable_third_party_js'] ) ) {
				update_option( 'da_disable_third_party_js', true );
				$disable_url = add_query_arg( array( 'da_disable_third_party_js' => 1 ) );
				$class = "da-disabled-third-party-js updated";
				$message = "
				<h3>3rd party scripts disabled</h3>
				<p>
					Draw Attention is currently disabling 3rd party scripts on this page. If you still have trouble using Draw Attention, please contact us at <a href='mailto:support@tylerdigital.com'>support@tylerdigital.com</a>
				</p>
				";
				echo"<div class=\"$class\">$message</div>";

			} else {
				$disable_url = add_query_arg( array( 'da_disable_third_party_js' => 1 ) );
				$class = "error da-disable-third-party-js";
				$message = "
				<h3>Theme or plugin conflict</h3>
				<p>
					A 3rd party script (from your theme or one of your plugins) is conflicting with Draw Attention. You will probably be unable to draw areas until you switch themes or disable the conflicting plugin.
				</p>
				<p>
					<a href='".$disable_url."'>Click here</a> and Draw Attention will try to fix it by reloading this page & disabling 3rd party scripts
				</p>
				";
				echo"<div class=\"$class\">$message</div>";
			}
		}

		public function store_enqueued_scripts() {
			global $pagenow;
			$screen = get_current_screen();
			if ( $screen->base != 'post' || $screen->post_type != $this->da->cpt->post_type ) {
				return;
			}

			global $wp_scripts;
			$this->script_handle_whitelist = $wp_scripts->queue;
		}

		public function disable_third_party_js() {
			global $pagenow;
			$screen = get_current_screen();
			if ( $screen->base != 'post' || $screen->post_type != $this->da->cpt->post_type ) {
				return;
			}
			if ( get_option( 'da_disable_third_party_js', false ) === false  && empty( $_GET['da_disable_third_party_js'] ) ) {
				return;
			}

			$draw_attention_whitelist = array(
				'drawattention-admin-script',
				'plupload-all',
				'dgd_uploaderScript'
			);

			global $wp_scripts;
			foreach ($wp_scripts->queue as $key => $handle) {
				if ( in_array( $handle, $this->script_handle_whitelist ) || in_array( $handle, $draw_attention_whitelist ) ) {
					continue;
				}

				wp_dequeue_script( $handle );
			}
		}


	}
}