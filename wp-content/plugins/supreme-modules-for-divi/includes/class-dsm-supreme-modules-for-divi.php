<?php
if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . '/wp-admin/includes/plugin.php';
}
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://suprememodules.com/about-us/
 * @since      1.0.0
 *
 * @package    Dsm_Supreme_Modules_For_Divi
 * @subpackage Dsm_Supreme_Modules_For_Divi/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Dsm_Supreme_Modules_For_Divi
 * @subpackage Dsm_Supreme_Modules_For_Divi/includes
 * @author     Supreme Modules <hello@divisupreme.com>
 */
class Dsm_Supreme_Modules_For_Divi {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Dsm_Supreme_Modules_For_Divi_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	private $settings_api;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'DSM_VERSION' ) ) {
			$this->version = DSM_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'dsm-supreme-modules-for-divi';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Dsm_Supreme_Modules_For_Divi_Loader. Orchestrates the hooks of the plugin.
	 * - Dsm_Supreme_Modules_For_Divi_i18n. Defines internationalization functionality.
	 * - Dsm_Supreme_Modules_For_Divi_Admin. Defines all hooks for the admin area.
	 * - Dsm_Supreme_Modules_For_Divi_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dsm-supreme-modules-for-divi-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dsm-supreme-modules-for-divi-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dsm-supreme-modules-for-divi-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dsm-supreme-modules-for-divi-public.php';

		/**
		 * The class responsible for defining all actions that occur in Divi Supreme
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class.settings-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class.page-settings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dsm-supreme-modules-for-divi-review.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/SupremeModulesLoader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dsm-json-handler.php';

		$this->loader = new Dsm_Supreme_Modules_For_Divi_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Dsm_Supreme_Modules_For_Divi_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Dsm_Supreme_Modules_For_Divi_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Dsm_Supreme_Modules_For_Divi_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Load page settings.
		$this->settings_api = new DSM_Settings_API();

		add_action( 'divi_extensions_init', array( $this, 'dsm_initialize_extension' ) );
		// Plugin Admin.
		add_filter( 'admin_footer_text', array( $this, 'dsm_admin_footer_text' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'dsm_admin_load_enqueue' ) );
		new Dsm_Supreme_Modules_For_Divi_Review(
			array(
				'slug'       => $this->get_plugin_name(),
				'name'       => __( 'Divi Supreme', 'dsm-supreme-modules-for-divi' ),
				'time_limit' => intval( '864000' ),
			)
		);

		// JSON Handler.
		if ( $this->settings_api->get_option( 'dsm_allow_mime_json_upload', 'dsm_settings_misc' ) === 'on' || $this->settings_api->get_option( 'dsm_allow_mime_json_upload', 'dsm_settings_misc' ) === '' ) {
			new DSM_JSON_Handler();
		}
		// Plugin links
		add_filter( 'plugin_action_links_supreme-modules-for-divi/supreme-modules-for-divi.php', array( $this, 'dsm_plugin_action_links' ), 10, 5 );
		add_filter( 'plugin_action_links', array( $this, 'dsm_add_action_plugin' ), 10, 5 );
		add_filter( 'plugin_row_meta', array( $this, 'dsm_plugin_row_meta' ), 10, 2 );

		// Divi Template
		add_action( 'init', array( $this, 'dsm_flush_rewrite_rules' ), 20 );
		if ( $this->settings_api->get_option( 'dsm_use_header_footer', 'dsm_general' ) === 'on' ) {
			add_action( 'init', array( $this, 'dsm_header_footer_posttypes' ), 0 );
			add_filter( 'single_template', array( $this, 'dsm_load_headerfooter_template' ) );
			add_filter( 'post_class', array( $this, 'dsm_load_headerfooter_post_class' ), 11 );
			add_action( 'add_meta_boxes', array( $this, 'dsm_add_header_footer_meta_box' ), 11 );
			add_action( 'save_post', array( $this, 'dsm_save_header_footer_meta_box' ), 10, 3 );
			add_action( 'et_after_main_content', array( $this, 'dsm_custom_footer' ) );
			add_filter( 'template_include', array( $this, 'dsm_redirect_template' ) );
			add_action( 'wp_print_scripts', array( $this, 'dsm_custom_footer_settings' ), 30 );
			add_action( 'admin_notices', array( $this, 'dsm_header_footer_admin_notice' ) );
		}

		// Scheduled content.
		if ( $this->settings_api->get_option( 'dsm_use_scheduled_content', 'dsm_general' ) === 'on' ) {
			add_filter( 'et_pb_all_fields_unprocessed_et_pb_section', array( $this, 'dsm_add_section_setting' ) );
			add_filter( 'et_module_shortcode_output', array( $this, 'output_section' ), 10, 3 );
			add_filter( 'et_pb_all_fields_unprocessed_et_pb_row', array( $this, 'dsm_add_row_setting' ) );
			add_filter( 'et_module_shortcode_output', array( $this, 'output_row' ), 10, 3 );
		}

		// Divi shortcode.
		if ( $this->settings_api->get_option( 'dsm_use_shortcode', 'dsm_general' ) === 'on' ) {
			add_shortcode( DSM_SHORTCODE, array( $this, 'dsm_divi_shortcode' ) );
			add_filter( 'manage_edit-et_pb_layout_columns', array( $this, 'dsm_divi_shortcode_post_columns_header' ) );
			add_action( 'manage_et_pb_layout_posts_custom_column', array( $this, 'dsm_divi_shortcode_post_columns_content' ) );
		}

		// Divi Theme Builder.
		if ( $this->settings_api->get_option( 'dsm_theme_builder_header_fixed', 'dsm_theme_builder' ) === 'on' ) {
			add_filter( 'body_class', array( $this, 'dsm_theme_builder_header_css_classes' ) );
		}

		// ContactForm7.
		add_filter( 'et_builder_load_actions', array( $this, 'dsm_et_builder_load_cf7' ) );
		add_action( 'wp_ajax_nopriv_dsm_load_cf7_library', array( $this, 'dsm_load_cf7_library' ) );
		add_action( 'wp_ajax_dsm_load_cf7_library', array( $this, 'dsm_load_cf7_library' ) );
		if ( class_exists( 'WPCF7' ) ) {
			remove_action( 'wpcf7_init', 'wpcf7_add_shortcode_submit', 20 );
			add_action( 'wpcf7_init', array( $this, 'dsm_wpcf7_add_form_tag_submit' ) );
			remove_action( 'wpcf7_init', 'wpcf7_add_form_tag_select', 20 );
			add_action( 'wpcf7_init', array( $this, 'dsm_wpcf7_add_form_tag_select' ) );
		}

		// Caldera.
		add_filter( 'et_builder_load_actions', array( $this, 'dsm_et_builder_load_caldera_forms' ) );
		add_action( 'wp_ajax_nopriv_dsm_load_caldera_forms', array( $this, 'dsm_load_caldera_forms' ) );
		add_action( 'wp_ajax_dsm_load_caldera_forms', array( $this, 'dsm_load_caldera_forms' ) );

		// // Sync or Defer script.
		add_filter( 'et_required_module_assets', array( $this, 'dsm_load_required_divi_assets' ), 10 );
	}

	/**
	 * Force load required module styles.
	 *
	 * @return array
	 */
	public function dsm_load_required_divi_assets( $modules ) {
		array_push( $modules, 'et_pb_image', 'et_pb_blurb' );
		return $modules;
	}
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Dsm_Supreme_Modules_For_Divi_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Dsm_Supreme_Modules_For_Divi_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Creates the extension's main class instance.
	 *
	 * @since 1.0.0
	 */
	public function dsm_initialize_extension() {
		// require_once plugin_dir_path( __FILE__ ) . 'includes/SupremeModulesForDivi.php';
		require_once plugin_dir_path( __FILE__ ) . 'SupremeModulesForDivi.php';
	}

	/**
	 * Flush Rules for Divi Template.
	 *
	 * @since 1.0.0
	 */
	public function dsm_flush_rewrite_rules() {
		if ( get_option( 'dsm_flush_rewrite_rules_flag' ) ) {
			flush_rewrite_rules();
			delete_option( 'dsm_flush_rewrite_rules_flag' );
		}
	}

	/**
	 * Creates the plugin action links.
	 *
	 * @since 1.0.0
	 */
	public function dsm_plugin_action_links( $links ) {
		$dsm_go_pro = sprintf(
			__( '<a href="%2$s" target="_blank" class="dsm-plugin-gopro">%1$s</a>', 'dsm-supreme-modules-for-divi' ),
			sprintf( '%s', esc_html__( 'Go Pro', 'dsm-supreme-modules-for-divi' ) ),
			esc_url( 'https://divisupreme.com/features/' )
		);

		$links[] = $dsm_go_pro;
		return $links;
	}

	/**
	 * Creates the plugin action links.
	 *
	 * @since 1.0.0
	 */
	public function dsm_add_action_plugin( $actions, $plugin_file ) {
		static $plugin;
		if ( ! isset( $plugin ) ) {
			$plugin = 'supreme-modules-for-divi/supreme-modules-for-divi.php';
		}

		if ( $plugin == $plugin_file ) {
			$settings = array( 'settings' => '<a href="' . esc_url( get_admin_url( null, 'options-general.php?page=divi_supreme_settings' ) ) . '">' . __( 'Settings', 'dsm-supreme-modules-for-divi' ) . '</a>' );

			$actions = array_merge( $settings, $actions );

		}
		return $actions;
	}

	/**
	 * Creates the plugin action links.
	 *
	 * @since 1.0.0
	 */
	public function dsm_plugin_row_meta( $links, $file ) {
		if ( 'supreme-modules-for-divi/supreme-modules-for-divi.php' == $file ) {
			$row_meta = array(
				'docs'    => '<a href="' . esc_url( 'https://docs.divisupreme.com/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Divi Supreme Documentation', 'dsm-supreme-modules-for-divi' ) . '">' . esc_html__( 'Documentation', 'dsm-supreme-modules-for-divi' ) . '</a>',
				'support' => '<a href="' . esc_url( 'https://divisupreme.com/contact/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Get Support', 'dsm-supreme-modules-for-divi' ) . '">' . esc_html__( 'Get Support', 'dsm-supreme-modules-for-divi' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}

	// Template load admin script
	public function dsm_admin_footer_text( $footer_text ) {
		$current_screen                = get_current_screen();
		$is_divi_supreme_screen_footer = ( $current_screen->id == 'edit-dsm_header_footer' );
		$is_divi_supreme_screen        = ( $current_screen && false !== strpos( $current_screen->id, 'toplevel_page_divi_supreme_settings' ) );

		if ( $is_divi_supreme_screen || $is_divi_supreme_screen_footer ) {
			$footer_text = sprintf(
				/* translators: 1: DiviSupreme 2:: five stars */
				__( 'If you like %1$s please leave us a %2$s rating. A huge thanks in advance!', 'dsm-supreme-modules-for-divi' ),
				sprintf( '<strong>%s</strong>', esc_html__( 'Divi Supreme', 'dsm-supreme-modules-for-divi' ) ),
				'<a href="https://wordpress.org/support/plugin/supreme-modules-for-divi/reviews/?rate=5#new-post" target="_blank" class="dsm-rating-link" data-rated="' . esc_attr__( 'Thanks :)', 'dsm-supreme-modules-for-divi' ) . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
			);
		}

		return $footer_text;
	}
	public function dsm_admin_load_enqueue( $hook_suffix ) {
		if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {
			$screen = get_current_screen();

			if ( is_object( $screen ) && 'dsm_header_footer' == $screen->post_type ) {
				wp_enqueue_script( 'dsm-admin-js', plugins_url( 'admin/js/dsm-admin.js', dirname( __FILE__ ) ) );
			}
		}
	}
	/**
	 * Shortcode Empty Paragraph fix
	 *
	 * @since 1.0.0
	 */
	public function dsm_fix_shortcodes( $content ) {
		$array   = array(
			'<p>['    => '[',
			']</p>'   => ']',
			']<br />' => ']',
		);
		$content = strtr( $content, $array );
		return $content;
	}
	/**
	 * Creates the Divi Template
	 *
	 * @since 1.0.0
	 */
	public function dsm_header_footer_posttypes() {
		$labels = array(
			'name'               => esc_html__( 'Divi Templates', 'dsm-supreme-modules-for-divi' ),
			'singular_name'      => esc_html__( 'Divi Template', 'dsm-supreme-modules-for-divi' ),
			'add_new'            => esc_html__( 'Add New', 'dsm-supreme-modules-for-divi' ),
			'add_new_item'       => esc_html__( 'Add New Template', 'dsm-supreme-modules-for-divi' ),
			'edit_item'          => esc_html__( 'Edit Template', 'dsm-supreme-modules-for-divi' ),
			'new_item'           => esc_html__( 'New Template', 'dsm-supreme-modules-for-divi' ),
			'all_items'          => esc_html__( 'All Templates', 'dsm-supreme-modules-for-divi' ),
			'view_item'          => esc_html__( 'View Template', 'dsm-supreme-modules-for-divi' ),
			'search_items'       => esc_html__( 'Search Templates', 'dsm-supreme-modules-for-divi' ),
			'not_found'          => esc_html__( 'Nothing found', 'dsm-supreme-modules-for-divi' ),
			'not_found_in_trash' => esc_html__( 'Nothing found in Trash', 'dsm-supreme-modules-for-divi' ),
			'parent_item_colon'  => '',
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => true,
			'show_in_menu'       => false,
			'show_ui'            => true,
			'can_export'         => true,
			'show_in_nav_menus'  => true,
			'has_archive'        => true,
			'rewrite'            => array(
				'slug'       => 'header-footer',
				'with_front' => false,
			),
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'author', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);

		register_post_type( 'dsm_header_footer', $args );
	}
	public function dsm_load_headerfooter_template( $template ) {
		global $post;

		if ( $post->post_type == 'dsm_header_footer' && $template !== locate_template( array( 'page-template-blank.php' ) ) ) {
			return plugin_dir_path( __FILE__ ) . 'templates/page-template-blank.php';
		}

		return $template;
	}
	public function dsm_load_headerfooter_post_class( $classes ) {
		global $post;
		if ( $post->post_type == 'dsm_header_footer' ) {
			$classes = array_diff( $classes, array( 'et_pb_post' ) );
		}
		return $classes;
	}
	public function dsm_header_footer_meta_box_options( $post ) {
		wp_nonce_field( 'dsm-header-footer-meta-box-nonce', 'dsm-header-footer-meta-box-nonce' );
		?>
		<div class="dsm-header-footer-meta-box dsm_<?php echo get_post_meta( $post->ID, 'dsm-header-footer-meta-box-options', true ); ?>">
			<p class="dsm-header-footer-meta-box-options">
				<label for="dsm-header-footer-meta-box-options" style="display: block; font-weight: bold; margin-bottom: 5px;">Assign template to:</label>
				<select name="dsm-header-footer-meta-box-options">
					<?php
						$option_values = array(
							'footer'           => __( 'Footer', 'dsm-supreme-modules-for-divi' ),
							'404'              => __( '404', 'dsm-supreme-modules-for-divi' ),
							'search_no_result' => __( 'Search No Result', 'dsm-supreme-modules-for-divi' ),
						);

						foreach ( $option_values as $key => $value ) {
							if ( $key == get_post_meta( $post->ID, 'dsm-header-footer-meta-box-options', true ) ) {
								?>
									<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
								<?php
							} else {
								?>
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
								<?php
							}
						}
						?>
				</select>
			</p>
			<p class="dsm-css-classes-meta-box-options">
				<label for="dsm-css-classes-meta-box-options" style="display: block; font-weight: bold; margin-bottom: 5px;">CSS Classes:</label>
				<input name="dsm-css-classes-meta-box-options" style="width:100%;" type="text" value="<?php echo get_post_meta( $post->ID, 'dsm-css-classes-meta-box-options', true ); ?>">
			</p>
			<p class="dsm-remove-default-footer-meta-box-options" style="margin-bottom: 0;">
				<input type="checkbox" name="dsm-remove-default-footer-meta-box-options" id="dsm-remove-default-footer-meta-box-options" value="yes" 
				<?php
				if ( isset( get_post_meta( $post->ID )['dsm-remove-default-footer-meta-box-options'] ) ) {
					checked( get_post_meta( $post->ID )['dsm-remove-default-footer-meta-box-options'][0], 'yes' );}
				?>
				/>
				<label for="dsm-remove-default-footer-meta-box-options">Remove default Divi footer</label>
			</p>
			<p class="dsm-footer-show-on-blank-template-meta-box-options" style="margin-bottom: 0; margin-top: 0;">
				<input type="checkbox" name="dsm-footer-show-on-blank-template" id="dsm-footer-show-on-blank-template" value="yes" 
				<?php
				if ( isset( get_post_meta( $post->ID )['dsm-footer-show-on-blank-template'] ) ) {
					checked( get_post_meta( $post->ID )['dsm-footer-show-on-blank-template'][0], 'yes' );}
				?>
				/>
				<label for="dsm-footer-show-on-blank-template">Show on Blank Page Template</label>
			</p>
			<p class="dsm-footer-show-on-404-template-meta-box-options" style="margin-top: 0;">
				<input type="checkbox" name="dsm-footer-show-on-404-template" id="dsm-footer-show-on-404-template" value="yes" 
				<?php
				if ( isset( get_post_meta( $post->ID )['dsm-footer-show-on-404-template'] ) ) {
					checked( get_post_meta( $post->ID )['dsm-footer-show-on-404-template'][0], 'yes' );}
				?>
				/>
				<label for="dsm-footer-show-on-404-template">Show on 404 Page</label>
			</p>
			<p><?php _e( 'Note: Footer Template will only show up on the frontend.', 'dsm-supreme-modules-for-divi' ); ?></p>
		</div>
		<?php
	}
	public function dsm_add_header_footer_meta_box() {
		add_meta_box( 'dsm_header_footer_meta_box', 'Divi Templates', array( $this, 'dsm_header_footer_meta_box_options' ), 'dsm_header_footer', 'side', 'high', null );
		remove_meta_box( 'et_settings_meta_box', 'dsm_header_footer', 'side', 'high' );
	}
	public function dsm_save_header_footer_meta_box( $post_id, $post, $update ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['dsm-header-footer-meta-box-nonce'] ) || ! wp_verify_nonce( $_POST['dsm-header-footer-meta-box-nonce'], 'dsm-header-footer-meta-box-nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$slug = 'dsm_header_footer';
		if ( $slug != $post->post_type ) {
			return $post_id;
		}

		if ( isset( $_POST['dsm-header-footer-meta-box-options'] ) ) {
			update_post_meta( $post_id, 'dsm-header-footer-meta-box-options', sanitize_text_field( $_POST['dsm-header-footer-meta-box-options'] ) );
		}

		if ( isset( $_POST['dsm-css-classes-meta-box-options'] ) ) {
			update_post_meta( $post_id, 'dsm-css-classes-meta-box-options', sanitize_text_field( $_POST['dsm-css-classes-meta-box-options'] ) );
		}

		if ( isset( $_POST['dsm-remove-default-footer-meta-box-options'] ) ) {
			$dsm_remove_default_footer = sanitize_text_field( $_POST['dsm-remove-default-footer-meta-box-options'] );
		}
		update_post_meta( $post_id, 'dsm-remove-default-footer-meta-box-options', $dsm_remove_default_footer );

		if ( isset( $_POST['dsm-footer-show-on-blank-template'] ) ) {
			$dsm_footer_hide_on_blank_template = sanitize_text_field( $_POST['dsm-footer-show-on-blank-template'] );
		}
		update_post_meta( $post_id, 'dsm-footer-show-on-blank-template', $dsm_footer_hide_on_blank_template );

		if ( isset( $_POST['dsm-footer-show-on-404-template'] ) ) {
			$dsm_footer_show_404_template = sanitize_text_field( $_POST['dsm-footer-show-on-404-template'] );
		}
		update_post_meta( $post_id, 'dsm-footer-show-on-404-template', $dsm_footer_show_404_template );
	}

	public function dsm_custom_footer() {
		$footer_args = array(
			'post_type'  => 'dsm_header_footer',
			'meta_key'   => 'dsm-header-footer-meta-box-options',
			'meta_value' => 'footer',
			'meta_type'  => 'post',
			'meta_query' => array(
				array(
					'key'     => 'dsm-header-footer-meta-box-options',
					'value'   => 'footer',
					'compare' => '==',
					'type'    => 'post',
				),
			),
		);

		$footer_template = new WP_Query(
			$footer_args
		);

		$footer_css_args = array(
			'post_type'  => 'dsm_header_footer',
			'meta_key'   => 'dsm-css-classes-meta-box-options',
			'value'      => '',
			'meta_type'  => 'post',
			'meta_query' => array(
				array(
					'key'     => 'dsm-css-classes-meta-box-options',
					'value'   => '',
					'compare' => '!=',
					'type'    => 'post',
				),
			),
		);

		$footer_css_template = new WP_Query(
			$footer_css_args
		);

		if ( $footer_template->have_posts() ) {
			add_filter( 'the_content', array( $this, 'dsm_fix_shortcodes' ) );
			$footer_template_ID        = $footer_template->post->ID;
			$footer_template_shortcode = do_shortcode( get_post_field( 'post_content', $footer_template_ID ) );
			$footer_template_css       = get_post_custom( $footer_template_ID );

			if ( $footer_template_css['dsm-css-classes-meta-box-options'][0] != '' ) {
				$footer_template_css_output = get_post_meta( $footer_css_template->post->ID, 'dsm-css-classes-meta-box-options', true );
			} else {
				$footer_template_css_output = '';
			}

			/*Get Blank Template*/
			global $post;
			if ( ! $post ) {
				return false;
			}

			if ( get_post_meta( $post->ID, '_wp_page_template', true ) === 'page-template-blank.php' && ( $footer_template_css['dsm-footer-show-on-blank-template'][0] == '' || $footer_template_css['dsm-footer-show-on-blank-template'][0] == 'no' ) ) {
				return;
			}

			if ( ! et_core_is_fb_enabled() ) {
				$footer_output = sprintf(
					'<footer id="dsm-footer" class="%2$s" itemscope="itemscope" itemtype="https://schema.org/WPFooter">%1$s</footer>
                    ',
					$footer_template_shortcode,
					( '' !== $footer_template_css_output ? 'dsm-footer ' . $footer_template_css_output : 'dsm-footer' )
				);
				echo $footer_output;
			}
		}
	}
	public function dsm_redirect_template( $template ) {
		global $wp_query;
		if ( is_404() ) {
			return plugin_dir_path( __FILE__ ) . 'templates/page-template-404.php';
		}
		if ( is_search() ) {
			if ( 0 === $wp_query->found_posts ) {
				return plugin_dir_path( __FILE__ ) . 'templates/page-template-search.php';
			}
		}
		/*
		if ( basename($template) === 'page.php') {
			return plugin_dir_path( __FILE__ ) . 'templates/page-template.php';
		}*/
		return $template;
	}

	public function dsm_custom_footer_settings() {
		$footer_args = array(
			'post_type'  => 'dsm_header_footer',
			'meta_key'   => 'dsm-header-footer-meta-box-options',
			'meta_value' => 'footer',
			'meta_type'  => 'post',
			'meta_query' => array(
				array(
					'key'     => 'dsm-header-footer-meta-box-options',
					'value'   => 'footer',
					'compare' => '==',
					'type'    => 'post',
				),
			),
		);

		$footer_template = new WP_Query(
			$footer_args
		);

		if ( $footer_template->have_posts() ) {
			$footer_template_ID  = $footer_template->post->ID;
			$footer_template_css = get_post_custom( $footer_template_ID );

			if ( $footer_template_css['dsm-remove-default-footer-meta-box-options'][0] == 'yes' ) {
				echo '<style id="dsm-footer-css" type="text/css">footer#main-footer { display: none; }</style>';
			}
		}
	}
	public function dsm_header_footer_admin_notice() {
		$current_screen = get_current_screen();

		if ( $current_screen->post_type === 'dsm_header_footer' ) {
			?>
			<div class="notice notice-info">
				<p><?php _e( 'Notice: For first time user, please re-save your <a href="' . get_admin_url() . 'options-permalink.php"  target="_blank">Permalinks</a> again to flush the rewrite rules in order view them in Visual Builder. This will only work for the Divi Theme. Once ElegantThemes updated their Template Hook on Extra Theme, this feature will also be available. Currently only the footer and 404 template is available you. Please create one template and assign to the footer or 404. If you do not see Divi Builder here, remember to <a href="' . get_admin_url() . 'admin.php?page=et_divi_options#wrap-builder" target="_blank">Enable Divi Builder On Post Types</a> in the Divi Options.', 'dsm-supreme-modules-for-divi' ); ?></p>
			</div>
			<?php
		}
	}

	/**
	 * Creates the Divi Supreme Scheduled Content
	 *
	 * @since 1.0.0
	 */
	public function dsm_add_section_setting( $fields_unprocessed ) {
		$fields                                        = array();
		$fields['dsm_section_schedule_visibility']     = array(
			'label'            => esc_html__( 'Use Scheduled Element', 'dsm-supreme-modules-for-divi' ),
			'type'             => 'yes_no_button',
			'option_category'  => 'configuration',
			'options'          => array(
				'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
				'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
			),
			'default_on_front' => 'off',
			'tab_slug'         => 'custom_css',
			'toggle_slug'      => 'visibility',
			'description'      => esc_html__( 'Here you can choose whether your Section will show or hide depending on the given date/time.', 'dsm-supreme-modules-for-divi' ),
		);
		$fields['dsm_section_schedule_show_hide']      = array(
			'label'            => esc_html__( 'Show or Hide Section', 'dsm-supreme-modules-for-divi' ),
			'type'             => 'select',
			'option_category'  => 'configuration',
			'options'          => array(
				'start' => esc_html__( 'Show', 'dsm-supreme-modules-for-divi' ),
				'end'   => esc_html__( 'Hide', 'dsm-supreme-modules-for-divi' ),
			),
			'default_on_front' => 'start',
			'tab_slug'         => 'custom_css',
			'toggle_slug'      => 'visibility',
			'show_if'          => array(
				'dsm_section_schedule_visibility' => 'on',
			),
		);
		$fields['dsm_section_schedule_after_datetime'] = array(
			'default'     => '',
			'label'       => esc_html__( 'Schedule a Date/Time', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'date_picker',
			'tab_slug'    => 'custom_css',
			'toggle_slug' => 'visibility',
			'show_if'     => array(
				'dsm_section_schedule_visibility' => 'on',
			),
		);
		return array_merge( $fields_unprocessed, $fields );
	}

	public function output_section( $output, $render_slug, $module ) {
		if ( 'et_pb_section' !== $render_slug ) {
			return $output;
		} else {
			if ( isset( $module->props['dsm_section_schedule_visibility'] ) && $module->props['dsm_section_schedule_visibility'] === 'on' ) {
				if ( is_array( $output ) ) {
					return $output;
				}

				$dsm_section_schedule_visibility     = $module->props['dsm_section_schedule_visibility'];
				$dsm_section_schedule_show_hide      = $module->props['dsm_section_schedule_show_hide'];
				$dsm_section_schedule_after_datetime = $module->props['dsm_section_schedule_after_datetime'];
				$dsm_section_current_wp_date         = wp_date( 'Y-m-d H:i:s', null );

				if ( $dsm_section_schedule_show_hide === 'start' ) {
					if ( $dsm_section_schedule_after_datetime >= $dsm_section_current_wp_date ) {
						return;
					} else {
						$output;
					}
				} else {
					if ( $dsm_section_schedule_after_datetime <= $dsm_section_current_wp_date ) {
						return;
					} else {
						$output;
					}
				}
			}
		}
		return $output;
	}

	public function dsm_add_row_setting( $fields_unprocessed ) {
		$fields                                    = array();
		$fields['dsm_row_schedule_visibility']     = array(
			'label'            => esc_html__( 'Use Scheduled Element', 'dsm-supreme-modules-for-divi' ),
			'type'             => 'yes_no_button',
			'option_category'  => 'configuration',
			'options'          => array(
				'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
				'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
			),
			'default_on_front' => 'off',
			'tab_slug'         => 'custom_css',
			'toggle_slug'      => 'visibility',
			'description'      => esc_html__( 'Here you can choose whether your Row will show/hide depending on the given date/time.', 'dsm-supreme-modules-for-divi' ),
		);
		$fields['dsm_row_schedule_show_hide']      = array(
			'label'            => esc_html__( 'Show or Hide Row', 'dsm-supreme-modules-for-divi' ),
			'type'             => 'select',
			'option_category'  => 'configuration',
			'options'          => array(
				'start' => esc_html__( 'Show', 'dsm-supreme-modules-for-divi' ),
				'end'   => esc_html__( 'Hide', 'dsm-supreme-modules-for-divi' ),
			),
			'default_on_front' => 'start',
			'tab_slug'         => 'custom_css',
			'toggle_slug'      => 'visibility',
			'show_if'          => array(
				'dsm_row_schedule_visibility' => 'on',
			),
		);
		$fields['dsm_row_schedule_after_datetime'] = array(
			'default'     => '',
			'label'       => esc_html__( 'Schedule a Date/Time', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'date_picker',
			'tab_slug'    => 'custom_css',
			'toggle_slug' => 'visibility',
			'show_if'     => array(
				'dsm_row_schedule_visibility' => 'on',
			),
		);
		return array_merge( $fields_unprocessed, $fields );
	}

	public function output_row( $output, $render_slug, $module ) {
		if ( 'et_pb_row' !== $render_slug ) {
			return $output;
		} else {
			if ( isset( $module->props['dsm_row_schedule_visibility'] ) && $module->props['dsm_row_schedule_visibility'] === 'on' ) {
				if ( is_array( $output ) ) {
					return $output;
				}

				$dsm_row_schedule_visibility     = $module->props['dsm_row_schedule_visibility'];
				$dsm_row_schedule_show_hide      = $module->props['dsm_row_schedule_show_hide'];
				$dsm_row_schedule_after_datetime = $module->props['dsm_row_schedule_after_datetime'];
				$dsm_row_current_wp_date         = wp_date( 'Y-m-d H:i:s', null );

				if ( $dsm_row_schedule_show_hide === 'start' ) {
					if ( $dsm_row_schedule_after_datetime >= $dsm_row_current_wp_date ) {
						return;
					} else {
						$output;
					}
				} else {
					if ( $dsm_row_schedule_after_datetime <= $dsm_row_current_wp_date ) {
						return;
					} else {
						$output;
					}
				}
			}
		}
		return $output;
	}

	/**
	 * Creates the Divi Supreme Shortcodes.
	 *
	 * @since 1.0.0
	 */
	public function dsm_divi_shortcode( $divi_shortcode = array() ) {
		if ( empty( $divi_shortcode['id'] ) ) {
			return '';
		}
		return do_shortcode( '[et_pb_section global_module="' . $divi_shortcode['id'] . '"][/et_pb_section]' );
	}
	public function dsm_divi_shortcode_post_columns_header( $columns ) {
		$columns['shortcode'] = __( 'Shortcode', 'dsm-supreme-modules-for-divi' );
		return $columns;
	}
	public function dsm_divi_shortcode_post_columns_content( $column_name ) {
		global $post;
		switch ( $column_name ) {
			case 'shortcode':
				$shortcode = esc_attr( sprintf( '[%s id="%d"]', DSM_SHORTCODE, $post->ID ) );
				printf( '<input class="dsm-shortcode-input" type="text" readonly onfocus="this.select()" value="%s" style="width:100%%" />', $shortcode );
				break;
		}
	}

	/**
	 * Creates the Divi Supreme Theme Builder Header.
	 *
	 * @since 2.1.2
	 */

	public function dsm_theme_builder_header_css_classes( $classes ) {
		if ( $this->settings_api->get_option( 'dsm_theme_builder_header_fixed', 'dsm_theme_builder' ) === 'on' ) {
			$classes[] = 'dsm_fixed_header';
		}
		if ( $this->settings_api->get_option( 'dsm_theme_builder_header_auto_calc', 'dsm_theme_builder' ) === 'on' || $this->settings_api->get_option( 'dsm_theme_builder_header_auto_calc', 'dsm_theme_builder' ) === '' ) {
			$classes[] = 'dsm_fixed_header_auto';
		}
		if ( $this->settings_api->get_option( 'dsm_theme_builder_header_shrink', 'dsm_theme_builder' ) === 'on' ) {
			$classes[] = 'dsm_fixed_header_shrink';
		}
		if ( function_exists( 'et_core_is_fb_enabled' ) ) {
			if ( et_core_is_fb_enabled() || et_builder_bfb_enabled() ) {
				$classes[] = 'dsm_fixed_header_vb';
			}
		}
		return $classes;
	}

	/**
	 * Load Custom CF7
	 *
	 * @since 1.0.0
	 */
	public function dsm_et_builder_load_cf7( $actions ) {
		$actions[] = 'dsm_load_cf7_library';

		return $actions;
	}
	public function dsm_load_cf7_library() {
		if ( isset( $_POST['et_admin_load_nonce'], $_POST['et_admin_load_nonce'], $_POST['cf7_library'] ) && wp_verify_nonce( sanitize_key( $_POST['et_admin_load_nonce'] ), 'et_admin_load_nonce' ) ) {
			echo do_shortcode( '[contact-form-7 id="' . sanitize_text_field( wp_unslash( $_POST['cf7_library'] ) ) . '"]' );
			wp_die();
		} else {
			esc_html_e( 'No Contact Form 7 selected.', 'dsm-supreme-modules-pro-for-divi' );
			wp_die();
		}
	}
	public function dsm_wpcf7_add_form_tag_submit() {
		wpcf7_add_form_tag( 'submit', array( $this, 'dsm_wpcf7_submit_form_tag_handler' ) );
	}
	public function dsm_wpcf7_submit_form_tag_handler( $tag ) {
		$class = wpcf7_form_controls_class( $tag->type . ' et_pb_button et_pb_bg_layout_light' );

		$atts = array();

		$atts['class']    = $tag->get_class_option( $class );
		$atts['id']       = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

		$value = isset( $tag->values[0] ) ? $tag->values[0] : '';

		if ( empty( $value ) ) {
			$value = __( 'Send', 'contact-form-7' );
		}

		$atts['type']  = 'submit';
		$atts['value'] = $value;

		$atts = wpcf7_format_atts( $atts );

		$html = '<button ' . $atts . '>' . esc_attr( $value ) . '</button>';

		return $html;
	}
	public function dsm_wpcf7_add_form_tag_select() {
		wpcf7_add_form_tag(
			array( 'select', 'select*' ),
			array( $this, 'dsm_wpcf7_select_form_tag_handler' ),
			array(
				'name-attr'         => true,
				'selectable-values' => true,
			)
		);
	}
	public function dsm_wpcf7_select_form_tag_handler( $tag ) {
		if ( empty( $tag->name ) ) {
			return '';
		}

		$validation_error = wpcf7_get_validation_error( $tag->name );

		$class = wpcf7_form_controls_class( $tag->type );

		if ( $validation_error ) {
			$class .= ' wpcf7-not-valid';
		}

		$atts = array();

		$atts['class']    = $tag->get_class_option( $class . ' et_pb_contact_select input' );
		$atts['id']       = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

		if ( $tag->is_required() ) {
			$atts['aria-required'] = 'true';
		}

		$atts['aria-invalid'] = $validation_error ? 'true' : 'false';

		$multiple       = $tag->has_option( 'multiple' );
		$include_blank  = $tag->has_option( 'include_blank' );
		$first_as_label = $tag->has_option( 'first_as_label' );

		if ( $tag->has_option( 'size' ) ) {
			$size = $tag->get_option( 'size', 'int', true );

			if ( $size ) {
				$atts['size'] = $size;
			} elseif ( $multiple ) {
				$atts['size'] = 4;
			} else {
				$atts['size'] = 1;
			}
		}

		$values = $tag->values;
		$labels = $tag->labels;

		if ( $data = (array) $tag->get_data_option() ) {
			$values = array_merge( $values, array_values( $data ) );
			$labels = array_merge( $labels, array_values( $data ) );
		}

		$default_choice = $tag->get_default_option(
			null,
			array(
				'multiple' => $multiple,
				'shifted'  => $include_blank,
			)
		);

		if ( $include_blank || empty( $values ) ) {
			array_unshift( $labels, '---' );
			array_unshift( $values, '' );
		} elseif ( $first_as_label ) {
			$values[0] = '';
		}

		$html     = '';
		$hangover = wpcf7_get_hangover( $tag->name );

		foreach ( $values as $key => $value ) {
			if ( $hangover ) {
				$selected = in_array( $value, (array) $hangover, true );
			} else {
				$selected = in_array( $value, (array) $default_choice, true );
			}

			$item_atts = array(
				'value'    => $value,
				'selected' => $selected ? 'selected' : '',
			);

			$item_atts = wpcf7_format_atts( $item_atts );

			$label = isset( $labels[ $key ] ) ? $labels[ $key ] : $value;

			$html .= sprintf(
				'<option %1$s>%2$s</option>',
				$item_atts,
				esc_html( $label )
			);
		}

		if ( $multiple ) {
			$atts['multiple'] = 'multiple';
		}

		$atts['name'] = $tag->name . ( $multiple ? '[]' : '' );

		$atts = wpcf7_format_atts( $atts );

		$html = sprintf(
			'<span class="wpcf7-form-control-wrap dsm-contact-form-7-select %1$s"><select %2$s>%3$s</select>%4$s</span>',
			sanitize_html_class( $tag->name ),
			$atts,
			$html,
			$validation_error
		);

		return $html;
	}

	/**
	 * Load Custom CF
	 *
	 * @since 1.0.0
	 */
	public function dsm_et_builder_load_caldera_forms( $actions ) {
		$actions[] = 'dsm_load_caldera_forms';

		return $actions;
	}
	public function dsm_load_caldera_forms() {
		if ( class_exists( 'Caldera_Forms' ) ) {
			add_filter(
				'caldera_forms_render_field_file',
				function( $field_file, $field_type ) {
					if ( 'dropdown' == $field_type ) {
						return dirname( __FILE__ ) . '/modules/CalderaForms/includes/dropdown/field.php';
					}
					if ( 'button' == $field_type ) {
						return dirname( __FILE__ ) . '/modules/CalderaForms/includes/button/field.php';
					}
					if ( 'radio' == $field_type ) {
						return dirname( __FILE__ ) . '/modules/CalderaForms/includes/radio/field.php';
					}
					if ( 'checkbox' == $field_type ) {
						return dirname( __FILE__ ) . '/modules/CalderaForms/includes/checkbox/field.php';
					}
					if ( 'html' == $field_type ) {
						return dirname( __FILE__ ) . '/modules/CalderaForms/includes/html/field.php';
					}
					if ( 'advanced_file' == $field_type ) {
						return dirname( __FILE__ ) . '/modules/CalderaForms/includes/advanced_file/field.php';
					}
					return $field_file;
				},
				10,
				2
			);
			// disable CF styles

			add_filter( 'caldera_forms_get_style_includes', 'dsm_filter_caldera_forms_get_style_includes', 10, 1 );

			if (
				isset( $_POST['et_admin_load_nonce'], $_POST['et_admin_load_nonce'], $_POST['cf_library'] )
				&& wp_verify_nonce( sanitize_key( $_POST['et_admin_load_nonce'] ), 'et_admin_load_nonce' )
			) {
				echo do_shortcode( '[caldera_form id="' . sanitize_text_field( wp_unslash( $_POST['cf_library'] ) ) . '"]' );
				wp_die();
			} else {
				esc_html_e( 'No Caldera forms selected.', 'dsm-supreme-modules-pro-for-divi' );
				wp_die();
			}
		}
	}
}
