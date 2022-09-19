<?php

class DSM_FlipBox_Perk extends ET_Builder_Module {

	public $slug       = 'dsm_flipbox';
	public $vb_support = 'on';
	public $child_slug = 'dsm_flipbox_child';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name                   = esc_html__( 'Supreme Flipbox', 'dsm-supreme-modules-for-divi' );
		$this->icon_path              = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'dsm-supreme-modules-for-divi' ),
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'       => array(
				'header'  => array(
					'label'          => esc_html__( 'Title', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% h1.et_pb_module_header, %%order_class%% h2.et_pb_module_header, %%order_class%% h3.et_pb_module_header, %%order_class%% h4.et_pb_module_header, %%order_class%% h5.et_pb_module_header, %%order_class%% h6.et_pb_module_header',
					),
					'font_size'      => array(
						'default' => '18px',
					),
					'line_height'    => array(
						'default' => '1em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'header_level'   => array(
						'default' => 'h4',
					),
				),
				'content' => array(
					'label'          => esc_html__( 'Body', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% .dsm-content',
					),
					'font_size'      => array(
						'default' => '14px',
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
				),
				'subhead' => array(
					'label'          => esc_html__( 'Subhead', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% .dsm-subtitle',
					),
					'font_size'      => array(
						'default' => '14px',
					),
					'line_height'    => array(
						'default' => '1em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
				),
			),
			'text'        => array(
				'use_text_orientation'  => false,
				'use_background_layout' => false,
				'css'                   => array(
					'text_shadow' => '%%order_class%%',
				),
				'options'               => array(
					'background_layout' => array(
						'default' => 'light',
					),
				),
			),
			'borders'     => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dsm_flipbox_child',
							'border_styles' => '%%order_class%% .dsm_flipbox_child',
						),
					),
				),
			),
			'box_shadow'  => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%% .dsm_flipbox_child',
					),
				),
			),
			'text_shadow' => array(
				// Don't add text-shadow fields since they already are via font-options.
				'default' => false,
			),
		);
	}

	public function get_fields() {
		return array(
			'flipbox_effect' => array(
				'label'           => esc_html__( 'Flipbox Effect', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'default'         => 'right',
				'options'         => array(
					'left'  => esc_html__( 'Flip Left', 'dsm-supreme-modules-for-divi' ),
					'right' => esc_html__( 'Flip Right', 'dsm-supreme-modules-for-divi' ),
					'up'    => esc_html__( 'Flip Up', 'dsm-supreme-modules-for-divi' ),
					'down'  => esc_html__( 'Flip Down', 'dsm-supreme-modules-for-divi' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'animation',
			),
			'flipbox_speed'  => array(
				'label'            => esc_html__( 'Animation Speed (in s)', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default'          => '0.6s',
				'default_on_front' => '0.6s',
				'default_unit'     => 's',
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '0.1',
				),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'animation',
			),
			'flipbox_height' => array(
				'label'            => esc_html__( 'Height', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'width',
				'mobile_options'   => true,
				'validate_unit'    => true,
				'default'          => '200px',
				'default_unit'     => 'px',
				'default_on_front' => '',
				'range_settings'   => array(
					'min'  => '1',
					'max'  => '1200',
					'step' => '1',
				),
				'responsive'       => true,
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$flipbox_effect             = $this->props['flipbox_effect'];
		$flipbox_speed              = $this->props['flipbox_speed'];
		$flipbox_height             = $this->props['flipbox_height'];
		$flipbox_height_tablet      = $this->props['flipbox_height_tablet'];
		$flipbox_height_phone       = $this->props['flipbox_height_phone'];
		$flipbox_height_last_edited = $this->props['flipbox_height_last_edited'];

		if ( '' !== $flipbox_height_tablet || '' !== $flipbox_height_phone || '' !== $flipbox_height ) {
			$flipbox_height_responsive_active = et_pb_get_responsive_status( $flipbox_height_last_edited );

			$flipbox_height_values = array(
				'desktop' => $flipbox_height,
				'tablet'  => $flipbox_height_responsive_active ? $flipbox_height_tablet : '',
				'phone'   => $flipbox_height_responsive_active ? $flipbox_height_phone : '',
			);

			et_pb_generate_responsive_css( $flipbox_height_values, '%%order_class%% .dsm-flipbox', 'height', $render_slug );
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dsm_flipbox_child',
				'declaration' => sprintf(
					'transition: transform %1$s ease-in-out;',
					esc_attr( $flipbox_speed )
				),
			)
		);

		$output = sprintf(
			'<div class="dsm-flipbox%2$s">%1$s</div>',
			et_core_sanitized_previously( $this->content ),
			esc_attr( " dsm-flipbox-effect-${flipbox_effect}" )
		);

		return $output;
	}
}

new DSM_FlipBox_Perk;
