<?php

if ( ! function_exists( 'et_common_setup' ) ) :
/**
 * Setup Common const.
 *
 * @since ??
 *
 */
function et_common_setup() {
	if ( defined( 'ET_COMMON_URL' ) ) {
		return;
	}

	$common_path = _et_core_normalize_path( trailingslashit( dirname( __FILE__ ) ) );
	$theme_dir = _et_core_normalize_path( trailingslashit( realpath( get_template_directory() ) ) );

	if ( 0 === strpos( $common_path, $theme_dir ) ) {
		$url = get_template_directory_uri() . '/common/';
	} else {
		$url = plugin_dir_url( __FILE__ );
	}

	define( 'ET_COMMON_URL', $url );
}
endif;


if ( ! function_exists( 'et_fb_enqueue_react' ) ):
	/**
	 * Load React. Use react from cdn server in debug mode or local version in production.
	 *
	 * @since ??
	 *
	 */
	function et_fb_enqueue_react() {
		$DEBUG          = defined( 'ET_DEBUG' ) && ET_DEBUG;
		$common_scripts = ET_COMMON_URL . 'scripts';
		$react_version  = '16.14.0';
	
		wp_dequeue_script( 'react' );
		wp_dequeue_script( 'react-dom' );
		wp_deregister_script( 'react' );
		wp_deregister_script( 'react-dom' );
	
		if ( $DEBUG || DiviExtensions::is_debugging_extension() ) {
			wp_enqueue_script( 'react', "https://cdn.jsdelivr.net/npm/react@{$react_version}/umd/react.development.js", array(), $react_version, true );
			wp_enqueue_script( 'react-dom', "https://cdn.jsdelivr.net/npm/react-dom@{$react_version}/umd/react-dom.development.js", array( 'react' ), $react_version, true );
			add_filter( 'script_loader_tag', 'et_core_add_crossorigin_attribute', 10, 3 );
		} else {
			wp_enqueue_script( 'react', "{$common_scripts}/react.production.min.js", array(), $react_version, true );
			wp_enqueue_script( 'react-dom', "{$common_scripts}/react-dom.production.min.js", array( 'react' ), $react_version, true );
		}
	}
	endif;
