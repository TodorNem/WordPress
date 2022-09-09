<?php
/**
 * Plugin Name: WooLentor - WooCommerce Elementor Addons + Builder
 * Description: The WooCommerce elements library for Elementor page builder plugin for WordPress.
 * Plugin URI:  https://woolentor.com/
 * Version:     2.4.4
 * Author:      HasThemes
 * Author URI:  https://hasthemes.com/plugins/woolentor-pro/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: woolentor
 * Domain Path: /languages
 * WC tested up to: 6.8.2
 * Elementor tested up to: 3.7.2
 * Elementor Pro tested up to: 3.7.3
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WOOLENTOR_VERSION', '2.4.4' );
define( 'WOOLENTOR_ADDONS_PL_ROOT', __FILE__ );
define( 'WOOLENTOR_ADDONS_PL_URL', plugins_url( '/', WOOLENTOR_ADDONS_PL_ROOT ) );
define( 'WOOLENTOR_ADDONS_PL_PATH', plugin_dir_path( WOOLENTOR_ADDONS_PL_ROOT ) );
define( 'WOOLENTOR_ADDONS_DIR_URL', plugin_dir_url( WOOLENTOR_ADDONS_PL_ROOT ) );
define( 'WOOLENTOR_PLUGIN_BASE', plugin_basename( WOOLENTOR_ADDONS_PL_ROOT ) );
define( 'WOOLENTOR_TEMPLATE', trailingslashit( WOOLENTOR_ADDONS_PL_PATH . 'includes/templates' ) );
define( 'WOOLENTOR_ITEM_NAME', 'WooLentor - WooCommerce Elementor Addons + Builder' );

// Required File
require_once ( WOOLENTOR_ADDONS_PL_PATH.'includes/base.php' );
\WooLentor\woolentor();

/**
 * Gutenbarge Blocks
 */
require_once ( WOOLENTOR_ADDONS_PL_PATH.'woolentor-blocks/woolentor-blocks.php' );