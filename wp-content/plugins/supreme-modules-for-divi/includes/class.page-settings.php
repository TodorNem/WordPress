<?php
/**
 * WordPress settings API
 */
if ( ! class_exists( 'DSM_Settings' ) ) :
	class DSM_Settings {

		private $settings_api;

		function __construct() {
			$this->settings_api = new DSM_Settings_API();

			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		function admin_init() {

			// set the settings
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

			// initialize settings
			$this->settings_api->admin_init();
		}

		function admin_menu() {
			$dsm_plugin_menu_icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMy4xNiAyNSI+PGRlZnM+PHN0eWxlPi5jbHMtMXtpc29sYXRpb246aXNvbGF0ZTt9LmNscy0ye2ZpbGw6I2ZmZjt9LmNscy0ze2ZpbGw6IzIzMWYyMDtvcGFjaXR5OjAuMjU7bWl4LWJsZW5kLW1vZGU6bXVsdGlwbHk7fTwvc3R5bGU+PC9kZWZzPjx0aXRsZT5pY29uLTEyOHgxMjg8L3RpdGxlPjxnIGNsYXNzPSJjbHMtMSI+PGcgaWQ9IkxheWVyXzEiIGRhdGEtbmFtZT0iTGF5ZXIgMSI+PHBhdGggY2xhc3M9ImNscy0yIiBkPSJNMjkuMjYsMTIuNzVBMTIuNDgsMTIuNDgsMCwwLDAsMTcuMzMsNEgxMC40MkEzLjc1LDMuNzUsMCwwLDAsNi42Nyw3Ljc1djcuOTFhMy43NSwzLjc1LDAsMCwwLDMuNzUsMy43NWgwYTMuNzUsMy43NSwwLDAsMCwzLjc1LTMuNzVoMFYxMS40OWgzLjE0YzMsMCw1LDEuNCw1LDQuODJhNi40NCw2LjQ0LDAsMCwxLS4yMywxLjc1LDQuNTUsNC41NSwwLDAsMS00LjE2LDMuNDNIMTAuNDJhMy43NSwzLjc1LDAsMCwwLTMuNzUsMy43NWgwQTMuNzUsMy43NSwwLDAsMCwxMC40MiwyOWg3LjkxYTMuNzcsMy43NywwLDAsMCwxLjE3LS4xOUExMi41LDEyLjUsMCwwLDAsMjkuODMsMTYuNWgwQTEyLjUyLDEyLjUyLDAsMCwwLDI5LjI2LDEyLjc1WiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTYuNjcgLTQpIi8+PHBhdGggY2xhc3M9ImNscy0yIiBkPSJNMjcuNDgsOS4yYTEyLjU1LDEyLjU1LDAsMCwwLTQuMDctMy42Myw3LjQyLDcuNDIsMCwwLDAtMi4zMi0uMzcsNi43Miw2LjcyLDAsMCwwLTYuOTIsNi4yOWgzLjE0YzMsMCw1LDEuNCw1LDQuODJhNi40NCw2LjQ0LDAsMCwxLS4yMywxLjc1LDQuNTUsNC41NSwwLDAsMS00LjE2LDMuNDMsMTIuNDksMTIuNDksMCwwLDAsOS41OC01LjI0LDYuMDUsNi4wNSwwLDAsMCwwLTdaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtNi42NyAtNCkiLz48cGF0aCBjbGFzcz0iY2xzLTMiIGQ9Ik0yOC40LDExLjFhNS41Niw1LjU2LDAsMCwxLC4xMywxLjIyYzAsMy41My0zLjExLDYuNTMtNy40NSw3LjY2YTQuNjEsNC42MSwwLDAsMS0zLjE0LDEuNTEsMTIuNDksMTIuNDksMCwwLDAsOS41OC01LjI0QTYsNiwwLDAsMCwyOC40LDExLjFaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtNi42NyAtNCkiLz48cGF0aCBjbGFzcz0iY2xzLTMiIGQ9Ik0yMi42Nyw1LjM3YTcuNSw3LjUsMCwwLDAtMS41OC0uMTcsNi43Miw2LjcyLDAsMCwwLTYuOTIsNi4yOWgxQTcuNjgsNy42OCwwLDAsMSwyMi42Nyw1LjM3WiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTYuNjcgLTQpIi8+PC9nPjwvZz48L3N2Zz4=';
			add_menu_page( __( 'Divi Supreme', 'dsm-supreme-modules-for-divi' ), __( 'Divi Supreme', 'dsm-supreme-modules-for-divi' ), 'manage_options', 'divi_supreme_settings', array( $this, 'plugin_page' ), $dsm_plugin_menu_icon, 99 );
			if ( $this->settings_api->get_option( 'dsm_use_header_footer', 'dsm_general' ) === 'on' ) {
				add_submenu_page( 'divi_supreme_settings', __( 'Divi Templates', 'dsm-supreme-modules-for-divi' ), __( 'Divi Templates', 'dsm-supreme-modules-for-divi' ), 'manage_options', 'edit.php?post_type=dsm_header_footer' );
			}
		}

		function get_settings_sections() {
			$sections = array(
				array(
					'id'    => 'dsm_general',
					'title' => __( 'General Settings', 'dsm-supreme-modules-for-divi' ),
				),
				array(
					'id'    => 'dsm_theme_builder',
					'title' => __( 'Easy Theme Builder', 'dsm-supreme-modules-for-divi' ),
				),
				array(
					'id'    => 'dsm_settings_social_media',
					'title' => __( 'Social Media Settings', 'dsm-supreme-modules-for-divi' ),
				),
				array(
					'id'    => 'dsm_settings_misc',
					'title' => __( 'Misc', 'dsm-supreme-modules-for-divi' ),
				),
			);
			return $sections;
		}

		/**
		 * Returns all the settings fields
		 *
		 * @return array settings fields
		 */
		function get_settings_fields() {
			$settings_fields = array(
				'dsm_general'               => array(
					array(
						'name'  => 'dsm_section_subtitle',
						'class' => 'dsm-section-subtitle',
						'label' => __( 'Divi Supreme Extensions', 'dsm-supreme-modules-for-divi' ),
						'desc'  => __( 'This is where you can enable Divi Extensions.' ),
						'type'  => 'subheading',
					),
					array(
						'name'    => 'dsm_use_scheduled_content',
						'class'   => 'dsm-settings-checkbox',
						'label'   => __( 'Enable Scheduled Content on Section & Row', 'dsm-supreme-modules-for-divi' ),
						//'desc'    => __( '<span class="slider round"></span>', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'    => 'dsm_use_header_footer',
						'class'   => 'dsm-settings-checkbox',
						'label'   => __( 'Enable Divi Templates', 'dsm-supreme-modules-for-divi' ),
						//'desc'    => __( '<span class="slider round"></span>', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'    => 'dsm_use_shortcode',
						'class'   => 'dsm-settings-checkbox',
						'label'   => __( 'Enable Divi Library Shortcodes', 'dsm-supreme-modules-for-divi' ),
						//'desc'    => __( '<span class="slider round"></span>', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					/*
					array(
						'name'    => 'dsm_use_sticky_element',
						'class'   => 'dsm-settings-checkbox',
						'label'   => __( 'Enable Divi Sticky Element', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),*/
				),
				'dsm_theme_builder'         => array(
					array(
						'name'  => 'dsm_theme_builder_header',
						'label' => __( 'Theme Builder Header', 'dsm-supreme-modules-for-divi' ),
						'desc'  => __( 'Configure Theme Builder Header settings here.' ),
						'type'  => 'subheading',
					),
					array(
						'name'    => 'dsm_theme_builder_header_fixed',
						'class'   => 'dsm-settings-checkbox',
						'label'   => __( 'Enable Fixed Header', 'dsm-supreme-modules-for-divi' ),
						'desc'    => __( 'This will make the Divi Theme Builder Header stay fixed to the top.', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					/*
					array(
						'name'    => 'dsm_theme_builder_header_fixed_devices',
						'label'   => __( 'Disable On', 'dsm-supreme-modules-for-divi' ),
						'desc'    => __( 'This will disable the fixed header on selected devices.', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'multicheck',
						'options' => array(
							'desktop' => 'Desktop',
							'tablet'  => 'Tablet',
							'phone'   => 'Phone',
						),
					),*/
					array(
						'name'    => 'dsm_theme_builder_header_auto_calc',
						'class'   => 'dsm-settings-checkbox',
						'label'   => __( 'Push Body Down', 'dsm-supreme-modules-for-divi' ),
						'desc'    => __( 'This will calculate the Divi Theme Builder Header height automatically and apply the height to the body to prevent the first section from overlapping. This will push tbe first section down based on the header height. This is not needed if you have a transparent background for the header.', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name' => 'dsm_theme_builder_header_shrink_break',
						'desc' => __( '<hr />', 'dsm-supreme-modules-for-divi' ),
						'type' => 'html',
					),
					array(
						'name'    => 'dsm_theme_builder_header_shrink',
						'class'   => 'dsm-settings-checkbox',
						'label'   => __( 'Enable Shrink on Scroll', 'dsm-supreme-modules-for-divi' ),
						'desc'    => __( 'This will shrink your Divi Theme Builder Header and stays fixed when you scroll. For developers, the active shrink CSS Class Selector is ".dsm_fixed_header_shrink_active"', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'              => 'dsm_theme_builder_header_section_padding',
						'label'             => __( 'Shrink Section Padding (px)', 'dsm-supreme-modules-for-divi' ),
						'desc'              => __( 'If Shrink on Scroll is enabled, you can define a custom top and bottom padding in pixel(px) value for the section when shrinked.', 'dsm-supreme-modules-for-divi' ),
						'type'              => 'text',
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'name'              => 'dsm_theme_builder_header_row_padding',
						'label'             => __( 'Shrink Row Padding (px)', 'dsm-supreme-modules-for-divi' ),
						'desc'              => __( 'If Shrink on Scroll is enabled, you can define a custom top and bottom padding in pixel(px) value for the row when shrinked.', 'dsm-supreme-modules-for-divi' ),
						'type'              => 'text',
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'name'              => 'dsm_theme_builder_header_shrink_image',
						'label'             => __( 'Shrink Image (%)', 'dsm-supreme-modules-for-divi' ),
						'desc'              => __( 'If Shrink on Scroll is enabled, you can define a max-width in percentage(%) value when shrinked. (Default: 70)', 'dsm-supreme-modules-for-divi' ),
						'type'              => 'text',
						'default'           => '70',
						'sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'name'              => 'dsm_theme_builder_header_start_threshold',
						'label'             => __( 'Shrink Threshold', 'dsm-supreme-modules-for-divi' ),
						'desc'              => __( 'If Shrink on Scroll is enabled, you can define when the header should shrink after viewport. (Default: 200)', 'dsm-supreme-modules-for-divi' ),
						'type'              => 'text',
						'default'           => '200',
						'sanitize_callback' => 'sanitize_text_field',
					),
				),
				'dsm_settings_social_media' => array(
					array(
						'name'  => 'dsm_section_subtitle',
						'class' => 'dsm-section-subtitle',
						'label' => __( 'Social Media Settings', 'dsm-supreme-modules-for-divi' ),
						'desc'  => __( 'Configure Social Media settings here.' ),
						'type'  => 'subheading',
					),
					'dsm_facebook_app_id'    => array(
						'name'              => 'dsm_facebook_app_id',
						'label'             => __( 'Facebook APP ID', 'dsm-supreme-modules-for-divi' ),
						'desc'              => sprintf(
							__( 'Enter the Facebook App ID. You can go to <a href="%1$s">Facebook Developer</a> and click on Create New App to get one.', 'dsm-supreme-modules-for-divi' ),
							esc_url( 'https://developers.facebook.com/apps/' )
						),
						'default'           => ' ',
						'type'              => 'text',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'dsm_facebook_site_lang' => array(
						'name'    => 'dsm_facebook_site_lang',
						'class'   => 'dsm-settings-checkbox',
						'label'   => __( 'Facebook Language', 'dsm-supreme-modules-for-divi' ),
						'desc'    => __( 'Check this box if you would like your Divi Facebook Modules to use your WordPress Site Language instead of the default English(US).', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
				),
				'dsm_settings_misc'         => array(
					'dsm_uninstall_on_delete'    => array(
						'name'  => 'dsm_uninstall_on_delete',
						'class' => 'dsm-settings-checkbox',
						'label' => __( 'Remove Data on Uninstall?', 'dsm-supreme-modules-for-divi' ),
						'desc'  => __( 'Check this box if you would like Divi Supreme to completely remove all of its data when the plugin is deleted.', 'dsm-supreme-modules-for-divi' ),
						'type'  => 'checkbox',
					),
					'dsm_allow_mime_json_upload' => array(
						'name'    => 'dsm_allow_mime_json_upload',
						'class'   => 'dsm-settings-checkbox',
						'label'   => __( 'Allow JSON file upload', 'dsm-supreme-modules-for-divi' ),
						'desc'    => __( 'Check this box if you would like allow JSON file through WordPress Media Uploader.', 'dsm-supreme-modules-for-divi' ),
						'type'    => 'checkbox',
						'default' => 'on',
					),
				),
			);

			return $settings_fields;
		}

		function plugin_page() {
			echo '<div class="wrap">';

			$this->settings_api->show_navigation();
			$this->settings_api->show_forms();

			echo '</div>';
		}

		/**
		 * Get all the pages
		 *
		 * @return array page names with key value pairs
		 */
		function get_pages() {
			$pages         = get_pages();
			$pages_options = array();
			if ( $pages ) {
				foreach ( $pages as $page ) {
					$pages_options[ $page->ID ] = $page->post_title;
				}
			}

			return $pages_options;
		}

	}
endif;
new DSM_Settings();
