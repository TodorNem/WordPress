<?php
/**
 * Plugin Name: Supreme Modules Lite - Divi Theme, Extra Theme and Divi Builder
 * Plugin URI:  https://suprememodules.com
 * Description: Divi Supreme enhances the experience and features found on Divi and extend with custom creative modules to help you build amazing websites.
 * Version:     2.4.1
 * Author:      Supreme Modules
 * Author URI:  https://suprememodules.com/about-us/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: dsm-supreme-modules-for-divi
 * Domain Path: /languages
 *
 * Divi Supreme Pro is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.

 * Divi Supreme Pro is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Divi Supreme Pro. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 *
 * @link              https://divisupreme.com
 * @since             1.0.0
 * @package           dsm-supreme-modules-for-divi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'DSM_VERSION' ) ) {
	define( 'DSM_VERSION', '2.4.1' );
}
if ( ! defined( 'DSM_SHORTCODE' ) ) {
	define( 'DSM_SHORTCODE', 'divi_shortcode' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dsm-supreme-modules-for-divi-activator.php
 */
function activate_dsm_supreme_modules_for_divi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dsm-supreme-modules-for-divi-activator.php';
	Dsm_Supreme_Modules_For_Divi_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dsm-supreme-modules-for-divi-deactivator.php
 */
function deactivate_dsm_supreme_modules_for_divi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dsm-supreme-modules-for-divi-deactivator.php';
	Dsm_Supreme_Modules_For_Divi_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dsm_supreme_modules_for_divi' );
register_deactivation_hook( __FILE__, 'deactivate_dsm_supreme_modules_for_divi' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dsm-supreme-modules-for-divi.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dsm_supreme_modules_for_divi() {
	$plugin = new Dsm_Supreme_Modules_For_Divi();
	$plugin->run();
}
if ( is_plugin_active( 'supreme-modules-pro-for-divi/supreme-modules-pro-for-divi.php' ) ) {
	return;
}
if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
	if ( ! function_exists( 'dsm_admin_notice__php_version_error' ) ) :
		/**
		 * Display PHP version error
		 *
		 * @since 1.0.0
		 */
		function dsm_admin_notice__php_version_error() {
			echo sprintf(
				'<div class="notice notice-error"><p>Goodness! Either you do not have Divi installed or your PHP version is either too old or not recommended to use Divi Supreme! We are not going to load anything on your WordPress unless you update your PHP. Do you know by using Divi Supreme, you can create even more stunning and amazing site with it? Learn more about the WordPress requirements <a href="%1$s" target="_blank">here</a>. Current PHP version is: %2$s Recommended PHP version: 7 and above.</p></div>',
				esc_url( 'https://wordpress.org/about/requirements/' ),
				PHP_VERSION
			);
		}
		add_action( 'admin_notices', 'dsm_admin_notice__php_version_error' );
		return;
	endif;
} else {
	run_dsm_supreme_modules_for_divi();
}
