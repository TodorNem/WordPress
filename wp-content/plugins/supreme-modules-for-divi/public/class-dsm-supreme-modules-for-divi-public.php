<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://suprememodules.com/about-us/
 * @since      1.0.0
 *
 * @package    Dsm_Supreme_Modules_For_Divi
 * @subpackage Dsm_Supreme_Modules_For_Divi/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dsm_Supreme_Modules_For_Divi
 * @subpackage Dsm_Supreme_Modules_For_Divi/public
 * @author     Supreme Modules <hello@divisupreme.com>
 */
class Dsm_Supreme_Modules_For_Divi_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dsm_Supreme_Modules_For_Divi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dsm_Supreme_Modules_For_Divi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( function_exists( 'et_core_is_fb_enabled' ) ) {
			if ( et_core_is_fb_enabled() ) {
				wp_enqueue_style( 'dsm-et-admin', plugin_dir_url( __FILE__ ) . 'css/dsm-et-admin.css', array(), DSM_VERSION, 'all' );
			}
		}
		$easy_theme_builder = isset( get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_fixed'] ) && 'off' !== get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_fixed'] ? true : false;
		if ( true === $easy_theme_builder ) {
			wp_enqueue_style( 'dsm-easy-theme-builder-style', plugin_dir_url( __FILE__ ) . 'css/dsm-easy-tb.css', array(), DSM_VERSION, 'all' );
			$easy_theme_builder_image   = isset( get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_shrink_image'] ) && '' !== get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_shrink_image'] ? esc_attr( get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_shrink_image'] ) : '';
			$easy_theme_builder_section = isset( get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_section_padding'] ) && '' !== get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_section_padding'] ? esc_attr( get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_section_padding'] ) : '';
			$easy_theme_builder_row     = isset( get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_row_padding'] ) && '' !== get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_row_padding'] ? esc_attr( get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_row_padding'] ) : '';
			$dsm_tb_header_css          = '';

			if ( '' !== $easy_theme_builder_image ) {
				$dsm_tb_header_css = '.et-db.dsm_fixed_header_shrink.dsm_fixed_header_shrink_active header.et-l--header img { max-width: ' . floatval( $easy_theme_builder_image ) . '%; }';
			}
			if ( '' !== $easy_theme_builder_section ) {
				$dsm_tb_header_css .= '.et-db.dsm_fixed_header_shrink.dsm_fixed_header_shrink_active header.et-l--header .et_pb_section { padding-top: ' . floatval( $easy_theme_builder_section ) . 'px; padding-bottom: ' . floatval( $easy_theme_builder_section ) . 'px; } ';
			}
			if ( '' !== $easy_theme_builder_row ) {
				$dsm_tb_header_css .= '.et-db.dsm_fixed_header_shrink.dsm_fixed_header_shrink_active header.et-l--header .et_pb_section .et_pb_row { padding-top: ' . floatval( $easy_theme_builder_row ) . 'px !important; padding-bottom: ' . floatval( $easy_theme_builder_row ) . 'px !important; } ';
			}

			wp_add_inline_style( 'dsm-easy-theme-builder-style', $dsm_tb_header_css );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dsm_Supreme_Modules_For_Divi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dsm_Supreme_Modules_For_Divi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$facebook_app_id = isset( get_option( 'dsm_settings_social_media' )['dsm_facebook_app_id'] ) && '' !== get_option( 'dsm_settings_social_media' )['dsm_facebook_app_id'] ? '&appId=' . esc_attr( get_option( 'dsm_settings_social_media' )['dsm_facebook_app_id'] ) : '';
		if ( isset( get_option( 'dsm_settings_social_media' )['dsm_facebook_site_lang'] ) && 'off' !== get_option( 'dsm_settings_social_media' )['dsm_facebook_site_lang'] ) {
			$facebook_lang = get_locale();
		} elseif ( isset( get_option( 'dsm_settings_social_media' )['dsm_facebook_site_lang'] ) && null === get_option( 'dsm_settings_social_media' )['dsm_facebook_site_lang'] ) {
			$facebook_lang = 'en_US';
		} else {
			$facebook_lang = 'en_US';
		}

		$easy_theme_builder = isset( get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_fixed'] ) && 'off' !== get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_fixed'] ? true : false;
		if ( true === $easy_theme_builder ) {
			$dsm_tb_header_start_threshold = isset( get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_start_threshold'] ) && '' !== get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_start_threshold'] ? get_option( 'dsm_theme_builder' )['dsm_theme_builder_header_start_threshold'] : '150';

			$dsm_tb_header = array(
				'threshold' => $dsm_tb_header_start_threshold,
			);

			if ( function_exists( 'et_core_is_fb_enabled' ) && function_exists( 'et_builder_bfb_enabled' ) ) {
				if ( et_core_is_fb_enabled() && ! et_builder_bfb_enabled() ) {
					wp_enqueue_script( 'dsm-easy-theme-builder-vb', plugin_dir_url( __FILE__ ) . 'js/dsm-easy-tb-vb.js', array( 'jquery' ), DSM_VERSION, true );
					wp_localize_script( 'dsm-easy-theme-builder-vb', 'dsm_easy_tb_js', $dsm_tb_header );
				}
				if ( ! et_core_is_fb_enabled() && ! et_builder_bfb_enabled() ) {
					wp_enqueue_script( 'dsm-easy-theme-builder', plugin_dir_url( __FILE__ ) . 'js/dsm-easy-tb.js', array( 'jquery' ), DSM_VERSION, true );
					wp_localize_script( 'dsm-easy-theme-builder', 'dsm_easy_tb_js', $dsm_tb_header );
				}
			}
		}

		wp_register_script( 'dsm-typed', plugin_dir_url( __FILE__ ) . 'js/typed.min.js', array(), DSM_VERSION, true );
		wp_register_script( 'dsm-before-after-image', plugin_dir_url( __FILE__ ) . 'js/dsm-before-after-image-slider.js', array( 'jquery' ), DSM_VERSION, true );
		wp_register_script( 'dsm-lottie', plugin_dir_url( __FILE__ ) . 'js/lottie.min.js', array(), DSM_VERSION, true );
		wp_register_script( 'dsm-facebook', 'https://connect.facebook.net/' . $facebook_lang . '/sdk.js#xfbml=1&version=v8.0' . $facebook_app_id, array(), null, true );
		wp_register_script( 'dsm-twitter-embed', 'https://platform.twitter.com/widgets.js', array(), DSM_VERSION, true );
		wp_register_script( 'dsm-image-accordion', plugin_dir_url( __DIR__ ) . 'includes/modules/ImageAccordion/frontend.min.js', array( 'jquery' ), DSM_VERSION, true );
		// Divi Assets.
		$ET_BUILDER_URI = defined( 'ET_BUILDER_PLUGIN_URI' ) ? ET_BUILDER_PLUGIN_URI : get_template_directory_uri();
		wp_register_script( 'magnific-popup', $ET_BUILDER_URI . '/includes/builder/feature/dynamic-assets/assets/js/magnific-popup.js', array( 'jquery' ), DSM_VERSION, true );
	}

}
