<?php
// Prevent direct access to files
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'DSM_JSON_Handler' ) ) {
	class DSM_JSON_Handler {
		const MIME_TYPE = 'application/json';

		/**
		* add JSON to allowed file uploads.
		*
		* @since 2.0.5
		*/
		public function dsm_mime_types( $mimes ) {
			$mimes['json'] = 'application/json';
			return $mimes;
		}
		/**
		* add JSON to wp_check_filetype_and_ext.
		*
		* @since 2.0.5
		*/
		public function dsm_check_filetype_and_ext( $types, $file, $filename, $mimes ) {
			if ( false !== strpos( $filename, '.json' ) ) {
				$types['ext']  = 'json';
				$types['type'] = self::MIME_TYPE;
			}

			return $types;
		}

		/**
		 * DSM_JSON_Handler constructor.
		 *
		 * @param string $name
		 * @param array  $args
		 */
		public function __construct() {
			add_filter( 'upload_mimes', array( $this, 'dsm_mime_types' ) );
			add_filter( 'wp_check_filetype_and_ext', array( $this, 'dsm_check_filetype_and_ext' ), 10, 4 );
		}
	}
}
