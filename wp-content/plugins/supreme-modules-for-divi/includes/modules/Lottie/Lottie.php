<?php

class DSM_Lottie extends ET_Builder_Module {

	public $slug       = 'dsm_lottie';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name      = esc_html__( 'Supreme Lottie', 'dsm-supreme-modules-for-divi' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Lottie', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'text'       => false,
			'fonts'      => false,
			'background' => array(
				'css'     => array(
					'main' => '%%order_class%%',
				),
				'options' => array(
					'parallax_method' => array(
						'default' => 'off',
					),
				),
			),
			'max_width'  => array(
				'css' => array(
					'main' => '%%order_class%%',
				),
			),
			'borders'    => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%%',
							'border_styles' => '%%order_class%%',
						),
					),
				),
			),
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%%',
					),
				),
			),
			'filters'    => false,
		);
	}

	public function get_fields() {
		return array(
			'lottie_url'                => array(
				'label'              => esc_html__( 'Lottie JSON File', 'dsm-supreme-modules-for-divi' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'data_type'          => 'json',
				'upload_button_text' => esc_attr__( 'Upload a json file', 'dsm-supreme-modules-for-divi' ),
				'choose_text'        => esc_attr__( 'Choose a JSON file', 'dsm-supreme-modules-for-divi' ),
				'update_text'        => esc_attr__( 'Set As JSON for the module', 'dsm-supreme-modules-for-divi' ),
				'computed_affects'   => array(
					'__lottie',
				),
			),
			'lottie_loop'               => array(
				'label'            => esc_html__( 'Loop', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'on',
				'description'      => esc_html__( 'Here you can choose whether or not your Lottie will animate in loop.', 'dsm-supreme-modules-for-divi' ),
				'computed_affects' => array(
					'__lottie',
				),
			),
			'lottie_delay'              => array(
				'label'            => esc_html__( 'Delay', 'dsm-supreme-modules-pro-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default_on_front' => '0ms',
				'validate_unit'    => true,
				'allowed_units'    => array( 'ms' ),
				'description'      => esc_html__( 'Delay the lottie animation (in ms).', 'dsm-supreme-modules-for-divi' ),
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '8000',
					'step' => '1',
				),
				'computed_affects' => array(
					'__lottie',
				),
			),
			'lottie_direction'          => array(
				'label'            => esc_html__( 'Direction', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'layout',
				'options'          => array(
					'1'  => esc_html__( 'Normal', 'dsm-supreme-modules-pro-for-divi' ),
					'-1' => esc_html__( 'Reverse', 'dsm-supreme-modules-pro-for-divi' ),
				),
				'default_on_front' => '1',
				'computed_affects' => array(
					'__lottie',
				),
			),
			'lottie_speed'              => array(
				'label'            => esc_html__( 'Speed (More is faster)', 'dsm-supreme-modules-pro-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default_on_front' => '1',
				'validate_unit'    => false,
				'unitless'         => true,
				'description'      => esc_html__( 'The speed of the animation.', 'dsm-supreme-modules-for-divi' ),
				'range_settings'   => array(
					'min'  => '0.1',
					'max'  => '2.5',
					'step' => '0.1',
				),
				'computed_affects' => array(
					'__lottie',
				),
			),
			'lottie_animation_viewport' => array(
				'label'            => esc_html__( 'Animate in Viewport', 'dsm-supreme-modules-for-divi' ),
				'description'      => esc_html__( 'Animation when the element is in viewport.', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'default'          => '80%',
				'default_on_front' => '80%',
				'unitless'         => false,
				'allow_empty'      => false,
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'responsive'       => false,
				'mobile_options'   => false,
				'computed_affects' => array(
					'__lottie',
				),
			),
			'__lottie'                  => array(
				'type'                => 'computed',
				'computed_callback'   => array( 'DSM_Lottie', 'getLottie' ),
				'computed_depends_on' => array(
					'lottie_url',
					'lottie_loop',
					'lottie_delay',
					'lottie_direction',
					'lottie_speed',
					'lottie_animation_viewport',
				),
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$lottie_url                = $this->props['lottie_url'];
		$lottie_loop               = $this->props['lottie_loop'];
		$lottie_delay              = $this->props['lottie_delay'];
		$lottie_direction          = $this->props['lottie_direction'];
		$lottie_speed              = $this->props['lottie_speed'];
		$lottie_animation_viewport = $this->props['lottie_animation_viewport'];

		wp_enqueue_script( 'dsm-lottie' );

		$data_attrs[] = array(
			'path'      => $lottie_url,
			'loop'      => $lottie_loop !== 'off' ? true : false,
			'delay'     => $lottie_delay,
			'direction' => $lottie_direction,
			'speed'     => $lottie_speed,
			'viewport'  => $lottie_animation_viewport,
		);

		// Render module content.
		$output = sprintf(
			'<div class="dsm_lottie_wrapper" data-params=%1$s>
			</div>',
			wp_json_encode( $data_attrs )
		);

		return $output;
	}
}

new DSM_Lottie();
