<?php
/**
 * Plugin Name: Advanced Google reCAPTCHA
 * Plugin URI: https://wpconcern.com/plugins/advanced-google-recaptcha/
 * Description: Advanced Google reCAPTCHA will safeguard your WordPress site from spam comments and brute force attacks. With this plugin, you can easily add Google reCAPTCHA to WordPress comment form, login form and other forms.
 * Version: 1.0.9
 * Author: WP Concern
 * Author URI: https://wpconcern.com/
 * Text Domain: advanced-google-recaptcha
 * License: GPL3
 * Domain Path: /languages
 *
 * @package Advanced_Google_Recaptcha
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ADVANCED_GOOGLE_RECAPTCHA_VERSION', '1.0.9' );
define( 'ADVANCED_GOOGLE_RECAPTCHA_SLUG', 'advanced-google-recaptcha' );
define( 'ADVANCED_GOOGLE_RECAPTCHA_BASENAME', plugin_basename( __FILE__ ) );
define( 'ADVANCED_GOOGLE_RECAPTCHA_PLUGIN_FILE', __FILE__ );
define( 'ADVANCED_GOOGLE_RECAPTCHA_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'ADVANCED_GOOGLE_RECAPTCHA_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
define( 'ADVANCED_GOOGLE_RECAPTCHA_OPTION', 'agr_options' );

if ( file_exists( ADVANCED_GOOGLE_RECAPTCHA_DIR . '/vendor/autoload.php' ) ) {
	require_once ADVANCED_GOOGLE_RECAPTCHA_DIR . '/vendor/autoload.php';
}

// Load helpers.
require_once ADVANCED_GOOGLE_RECAPTCHA_DIR . '/inc/helpers.php';

// Load admin.
require_once ADVANCED_GOOGLE_RECAPTCHA_DIR . '/inc/admin.php';

// Load core.
require_once ADVANCED_GOOGLE_RECAPTCHA_DIR . '/inc/core.php';
