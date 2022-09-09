<?php
/**
 * Helpers functions
 *
 * @package Advanced_Google_Recaptcha
 */

/**
 * Get plugin option.
 *
 * @since 1.0.0
 *
 * @param string $key Option key.
 * @return mixed Option value.
 */
function advanced_google_recaptcha_option( $key ) {
	if ( empty( $key ) ) {
		return;
	}

	$plugin_options = wp_parse_args( (array) get_option( 'agr_options' ), advanced_google_recaptcha_get_detault_options() );

	$value = null;

	if ( isset( $plugin_options[ $key ] ) ) {
		$value = $plugin_options[ $key ];
	}

	return $value;
}

/**
 * Get default plugin options.
 *
 * @since 1.0.0
 *
 * @return array Default plugin options.
 */
function advanced_google_recaptcha_get_detault_options() {
	$default = array();

	// Key.
	$default['captcha_type'] = 'v2';
	$default['site_key']     = '';
	$default['secret_key']   = '';

	// Status.
	$default['enable_login']         = 1;
	$default['enable_register']      = 1;
	$default['enable_lost_password'] = 1;
	$default['enable_comment_form']  = 1;
	$default['enable_woo_register']  = 0;
	$default['enable_woo_login']     = 0;
	$default['enable_edd_register']  = 0;
	$default['enable_edd_login']     = 0;
	$default['enable_bp_register']   = 0;

	return $default;
}

/**
 * Check if key setup complete.
 *
 * @since 1.0.0
 *
 * @return array Default plugin options.
 */
function advanced_google_recaptcha_is_key_setup_complete() {
	$output = false;

	$site_key   = advanced_google_recaptcha_option( 'site_key' );
	$secret_key = advanced_google_recaptcha_option( 'secret_key' );

	if ( ! empty( $site_key ) && ! empty( $secret_key ) ) {
		$output = true;
	}

	return $output;
}

/**
 * Return captcha API URL.
 *
 * @since 1.0.0
 *
 * @param string $type Type.
 * @return string API URL.
 */
function advanced_google_recaptcha_get_captcha_api_url( $type ) {
	$output = '';

	$site_key = advanced_google_recaptcha_option( 'site_key' );

	if ( 'v2' === $type ) {
		$output = 'https://www.google.com/recaptcha/api.js?hl=' . esc_attr( get_locale() ) . '&onload=agr_load&render=explicit';
	} elseif ( 'v3' === $type ) {
		$output = 'https://www.google.com/recaptcha/api.js?onload=agr_v3&render=' . esc_attr( $site_key );
	}

	return $output;
}
