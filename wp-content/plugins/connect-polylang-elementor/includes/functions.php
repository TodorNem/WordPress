<?php

defined( 'ABSPATH' ) || exit;


/**
 * Is Elementor (free) plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function cpel_is_elementor_active() {

	return defined( 'ELEMENTOR_VERSION' );

}

/**
 * Is Elementor Pro plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function cpel_is_elementor_pro_active() {

	return defined( 'ELEMENTOR_PRO_VERSION' );

}

/**
 * Is Polylang (free) OR Polylang Pro (Premium) plugin active or not?
 *   Note: This is for checking the base Polylang functionality which is
 *         identical in free and Pro version.
 *
 * @since  1.0.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function cpel_is_polylang_active() {

	return defined( 'POLYLANG_BASENAME' );

}

/**
 * Is Polylang Pro (Premium) plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function cpel_is_polylang_pro_active() {

	return defined( 'POLYLANG_PRO' );

}

/**
 * Is Polylang API active
 *
 * @since  2.0.8
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function cpel_is_polylang_api_active() {

	return cpel_is_polylang_active() && function_exists( 'pll_get_post' );

}

/**
 * Is Polylang Multidomain
 *
 * @since  2.1.1
 *
 * @return bool TRUE if is polylang multi-domain configuration, FALSE otherwise.
 */
function cpel_is_polylang_multidomain() {

	return cpel_is_polylang_api_active() && 3 === PLL()->options['force_lang'] && ! empty( PLL()->options['domains'] );

}

/**
 * Is Elementor Editor
 *
 * @since  2.3.0
 *
 * @return bool TRUE if is Elementor Editor, FALSE otherwise.
 */
function cpel_is_elementor_editor() {

	return is_admin() && isset( $_GET['action'], $_GET['post'] ) && 'elementor' === $_GET['action'];

}

/**
 * Is post a translation in secondary language
 *
 * @since  2.0.0
 *
 * @return bool TRUE if is a translation, FALSE otherwise.
 */
function cpel_is_translation( $post_id = null ) {

	$post_id = $post_id ? $post_id : get_the_ID();
	$default = pll_default_language();

	return pll_get_post_language( $post_id ) !== $default && pll_get_post( $post_id, $default );

}

/**
 * Flag code
 *
 * @since 2.0.0
 * @since 2.0.5 don't return code for custom flags
 *
 * @param  string $flag_url full flag url.
 * @return string|bool  flag code or false
 */
function cpel_flag_code( $flag_url ) {

	return preg_match( '/polylang\/flags\/(\w+).(?:jpg|png|svg)$/i', $flag_url, $matchs ) ? $matchs[1] : false;

}

/**
 * SVG flag info
 *
 * @since 2.0.0
 *
 * @param  string $flag_code flag two letters code.
 * @return array|bool  SVG flag info or false
 */
function cpel_flag_svg( $flag_code ) {

	$flag_path = "/assets/flags/$flag_code.svg";

	if ( file_exists( CPEL_DIR . $flag_path ) ) {
		return array(
			'path' => $flag_path,
			'url'  => plugins_url( $flag_path, CPEL_FILE ),
		);
	}

	return false;

}
