<?php

class DSM_Business_Hours_Child extends ET_Builder_Module {

	public $slug            = 'dsm_business_hours_child';
	public $vb_support      = 'on';
	public $type            = 'child';
	public $child_title_var = 'title';
	// If the attribute defined on $this->child_title_var is empty, this attribute will be used instead
	public $child_title_fallback_var = 'subtitle';

	protected $module_credits = array(
		'module_uri' => 'https://suprememodules.com/',
		'author'     => 'Supreme Modules',
		'author_uri' => 'https://suprememodules.com/',
	);

	public function init() {
		$this->name                        = esc_html__( 'Business Hours Item', 'dsm-supreme-modules-for-divi' );
		$this->advanced_setting_title_text = esc_html__( 'Business Hours Item', 'dsm-supreme-modules-for-divi' );
		$this->settings_text               = esc_html__( 'Business Hours Item Settings', 'dsm-supreme-modules-for-divi' );

		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'dsm-supreme-modules-for-divi' ),
					'link'         => esc_html__( 'Link', 'dsm-supreme-modules-for-divi' ),
					'image'        => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced'   => array(
				'toggles' => array(
					'icon_settings' => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
					'text'          => array(
						'title'    => esc_html__( 'Text', 'dsm-supreme-modules-for-divi' ),
						'priority' => 49,
					),
					'width'         => array(
						'title'    => esc_html__( 'Sizing', 'dsm-supreme-modules-for-divi' ),
						'priority' => 65,
					),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'attributes' => array(
						'title'    => esc_html__( 'Attributes', 'dsm-supreme-modules-for-divi' ),
						'priority' => 95,
					),
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'           => array(
				'text'   => array(
					'label'             => esc_html__( '', 'dsm-supreme-modules-for-divi' ),
					'css'               => array(
						'main' => '%%order_class%% .dsm-business-hours-header',
					),
					'font_size'         => array(
						'default' => '14px',
					),
					'line_height'       => array(
						'default' => '1.7em',
					),
					'letter_spacing'    => array(
						'default' => '0px',
					),
					'hide_header_level' => true,
					'hide_text_align'   => true,
					'hide_text_shadow'  => true,
					'tab_slug'          => 'advanced',
					'toggle_slug'       => 'text',
				),
				'header' => array(
					'label'             => esc_html__( 'Day', 'dsm-supreme-modules-for-divi' ),
					'css'               => array(
						'main' => '%%order_class%% .dsm-business-hours-day',
					),
					'font_size'         => array(
						'default' => '14px',
					),
					'line_height'       => array(
						'default' => '1.7em',
					),
					'letter_spacing'    => array(
						'default' => '0px',
					),
					'hide_header_level' => true,
					'hide_text_align'   => true,
				),
				'time'   => array(
					'label'           => esc_html__( 'Time', 'dsm-supreme-modules-for-divi' ),
					'css'             => array(
						'main' => '%%order_class%% .dsm-business-hours-time',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.7em',
					),
					'letter_spacing'  => array(
						'default' => '0px',
					),
					'hide_text_align' => true,
				),
			),
			'text'            => array(
				'use_text_orientation'  => false,
				'use_background_layout' => false,
				'css'                   => array(
					'text_shadow' => '%%order_class%% .dsm_business_hours_item_wrapper',
				),
			),
			'borders'         => array(
				'default' => array(),
				/*
				'image'   => array(
					'css'             => array(
						'main' => array(
							'border_radii' => "%%order_class%% .dsm-business-hours-image img",
							'border_styles' => "%%order_class%% .dsm-business-hours-image img",
						)
					),
					'label_prefix'    => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
					'tab_slug'          => 'advanced',
					'toggle_slug'       => 'icon_settings',
				),*/
			),
			'box_shadow'      => array(
				'default' => array(),
				/*
				'image'   => array(
					'label'               => esc_html__( 'Image Box Shadow', 'dsm-supreme-modules-for-divi' ),
					'option_category'     => 'layout',
					'tab_slug'          => 'advanced',
					'toggle_slug'       => 'icon_settings',
					'css'                 => array(
						'main' => '%%order_class%% .dsm-business-hours-image img',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),*/
			),
			'button'          => false,
			/*
			'filters'               => array(
				'child_filters_target' => array(
					'tab_slug' => 'advanced',
					'toggle_slug' => 'icon_settings',
				),
			),
			'icon_settings'         => array(
				'css' => array(
					'main' => '%%order_class%% .dsm-business-hours-image img',
				),
			),*/
			'position_fields' => false,
		);
	}

	public function get_fields() {
		$et_accent_color = et_builder_accent_color();

		return array(
			'time'  => array(
				'label'            => esc_html__( 'Time', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'The time of the day', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'      => 'main_content',
				'default'          => '9:00 AM - 6:00 PM',
				'default_on_front' => '9:00 AM - 6:00 PM',
			),
			'title' => array(
				'label'            => esc_html__( 'Day', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'The day', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'      => 'main_content',
				'default'          => 'Monday',
				'default_on_front' => 'Monday',
			),
			/*
			'image' => array(
				'label'              => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'dsm-supreme-modules-for-divi' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'dsm-supreme-modules-for-divi' ),
				'update_text'        => esc_attr__( 'Set As Image', 'dsm-supreme-modules-for-divi' ),
				'depends_show_if'    => 'off',
				'description'        => esc_html__( 'Upload an image to display at the top of your blurb.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'        => 'image',
			),
			'alt' => array(
				'label'           => esc_html__( 'Image Alt Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the HTML ALT text for your image here.', 'dsm-supreme-modules-for-divi' ),
				'depends_show_if' => 'off',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'attributes',
			),
			'image_max_width' => array(
				'label'           => esc_html__( 'Image Width', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
				'mobile_options'  => true,
				'validate_unit'   => true,
				'depends_show_if' => 'off',
				'default'         => '50%',
				'default_unit'    => '%',
				'default_on_front'=> '',
				'allow_empty'     => true,
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '50',
					'step' => '1',
				),
				'responsive'      => true,
			),
			'image_spacing' => array(
				'label'           => esc_html__( 'Image Gap Spacing', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
				'mobile_options'  => true,
				'validate_unit'   => true,
				'default'         => '25px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'allow_empty'     => true,
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '50',
					'step' => '1',
				),
				'responsive'      => true,
			),
			*/
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$title = $this->props['title'];
		$time  = $this->props['time'];
		/*
		$image                 = $this->props['image'];
		$alt                   = $this->props['alt'];
		$image_spacing = $this->props['image_spacing'];
		$image_spacing_tablet      = $this->props['image_spacing_tablet'];
		$image_spacing_phone       = $this->props['image_spacing_phone'];
		$image_spacing_last_edited = $this->props['image_spacing_last_edited'];
		$image_max_width             = $this->props['image_max_width'];
		$image_max_width_tablet      = $this->props['image_max_width_tablet'];
		$image_max_width_phone       = $this->props['image_max_width_phone'];
		$image_max_width_last_edited = $this->props['image_max_width_last_edited'];*/

		/*
		if ( '' !== $image_max_width_tablet || '' !== $image_max_width_phone || '' !== $image_max_width ) {
			$image_max_width_responsive_active = et_pb_get_responsive_status( $image_max_width_last_edited );

			$image_max_width_values = array(
				'desktop' => $image_max_width,
				'tablet'  => $image_max_width_responsive_active ? $image_max_width_tablet : '',
				'phone'   => $image_max_width_responsive_active ? $image_max_width_phone : '',
			);

			et_pb_generate_responsive_css( $image_max_width_values, '%%order_class%% .dsm-business-hours-image', 'max-width', $render_slug );
		}*/

		if ( '' !== $title ) {
			$title = sprintf( '<div class="dsm-business-hours-day">%1$s</div>', $title );
		}

		if ( '' !== $time ) {
			$time = sprintf( '<div class="dsm-business-hours-time">%1$s</div>', $time );
		}

		/*
		$image = ( '' !== trim( $image ) ) ? sprintf(
			'<img src="%1$s" alt="%2$s" />',
			esc_url( $image ),
			esc_attr( $alt )
			//esc_attr( " et_pb_animation_{$animation}" )
		) : '';

		// Images: Add CSS Filters and Mix Blend Mode rules (if set)
		$generate_css_image_filters = '';
		if ( $image && array_key_exists( 'icon_settings', $this->advanced_fields ) && array_key_exists( 'css', $this->advanced_fields['icon_settings'] ) ) {
			$generate_css_image_filters = $this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get( $this->advanced_fields['icon_settings']['css'], 'main', '%%order_class%%' )
			);
		}

		$image = $image ? sprintf(
			'<div class="dsm-business-hours-image%2$s">%1$s</div>',
			$image,
			esc_attr( $generate_css_image_filters )
		) : '';*/

		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		// Render module content
		return sprintf(
			'%5$s
			%4$s
			<div class="dsm_business_hours_item_wrapper%3$s">
				<div class="dsm-business-hours-header">
					%1$s
					<div class="dsm-business-hours-separator"></div>
					%2$s
				</div>
			</div>',
			$title,
			$time,
			$this->get_text_orientation_classname(),
			$video_background,
			$parallax_image_background
		);
	}
}

new DSM_Business_Hours_Child;
