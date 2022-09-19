<?php

class DSM_EmbedGoogleMap extends ET_Builder_Module {

	public $slug       = 'dsm_embed_google_map';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name                   = esc_html__( 'Supreme Embed Google Map', 'dsm-supreme-modules-for-divi' );
		$this->icon_path              = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Embed Google Map', 'dsm-supreme-modules-for-divi' ),
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'      => false,
			'button'     => false,
			'text'       => false,
			'background' => false,
			'height'     => array(
				'css'     => array(
					'main' => '%%order_class%% iframe',
				),
				'options' => array(
					'height' => array(
						'default'        => '320px',
						'default_tablet' => '320px',
						'default_phone'  => '320px',
					),
				),
			),
		);
	}

	public function get_fields() {
		return array(
			'google_maps_script_notice' => array(
				'type'        => 'warning',
				'value'       => true,
				'display_if'  => true,
				'message'     => esc_html__( 'Google Embed Map API is not required. However, if you encounter any issues with the Embed Google Map, please consider using Google Embed Map API for stability in the future.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug' => 'main_content',
			),
			'google_api_key'            => array(
				'label'                  => esc_html__( 'Google API Key', 'dsm-supreme-modules-for-divi' ),
				'type'                   => 'text',
				'option_category'        => 'basic_option',
				'attributes'             => 'readonly',
				'additional_button'      => sprintf(
					' <a href="%2$s" target="_blank" class="et_pb_update_google_key button" data-empty_text="%3$s">%1$s</a>',
					esc_html__( 'Change API Key', 'dsm-supreme-modules-for-divi' ),
					esc_url( et_pb_get_options_page_link() ),
					esc_attr__( 'Add Your API Key', 'dsm-supreme-modules-for-divi' )
				),
				'additional_button_type' => 'change_google_api_key',
				'class'                  => array( 'et_pb_google_api_key', 'et-pb-helper-field' ),
				'description'            => sprintf(
					'The module uses the Google Maps API and requires a valid Google API Key to function. Before using the map module, please make sure you have added your API key inside the Divi Theme Options panel. Learn more about how to create your Google API Key <a href="%1$s" target="_blank">here</a>.',
					esc_url( 'http://www.elegantthemes.com/gallery/divi/documentation/map/#gmaps-api-key' )
				),
				'toggle_slug'            => 'main_content',
			),
			'address'                   => array(
				'label'            => esc_html__( 'Address', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Enter the address for the embed Google Map.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => '1233 Howard St Apt 3A San Francisco, CA 94103-2775',
				'toggle_slug'      => 'main_content',
				'dynamic_content'  => 'text',
			),
			'zoom'                      => array(
				'label'           => esc_html__( 'Zoom', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'main_content',
				'default_unit'    => '',
				'default'         => '10',
				'unitless'        => true,
				'allow_empty'     => false,
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '22',
					'step' => '1',
				),
			),
		);
	}

	function render( $attrs, $content = null, $render_slug ) {
		$address = $this->props['address'];
		$zoom    = $this->props['zoom'];

		if ( et_pb_get_google_api_key() ) {
			$output = sprintf(
				'<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed/v1/place?key=%5$s&amp;q=%1$s&amp;zoom=%2$s&amp;language=%4$s" aria-label="%3$s"></iframe>',
				rawurlencode( $address ),
				absint( $zoom ),
				esc_attr( $address ),
				esc_attr( get_locale() ),
				esc_attr( et_pb_get_google_api_key() )
			);
		} else {
			$output = sprintf(
				'<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$s&amp;output=embed&amp;iwloc=near&hl=%4$s" aria-label="%3$s"></iframe>',
				rawurlencode( $address ),
				absint( $zoom ),
				esc_attr( $address ),
				esc_attr( get_locale() )
			);
		}

		return $output;
	}
}

new DSM_EmbedGoogleMap();
