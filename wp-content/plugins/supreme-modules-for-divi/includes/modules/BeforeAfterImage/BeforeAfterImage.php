<?php

class DSM_Before_After_Image extends ET_Builder_Module {
	protected static $rendering = false;
	public $slug                = 'dsm_before_after_image';
	public $vb_support          = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name             = esc_html__( 'Supreme Before/After Image Slider', 'dsm-supreme-modules-for-divi' );
		$this->icon_path        = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->main_css_element = '%%order_class%%.dsm_before_after_image';

		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'main_content'    => esc_html__( 'Images', 'dsm-supreme-modules-for-divi' ),
					'labels'          => esc_html__( 'Labels', 'dsm-supreme-modules-for-divi' ),
					'slider_settings' => esc_html__( 'Settings', 'dsm-supreme-modules-for-divi' ),
					'link'            => esc_html__( 'Link', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced'   => array(
				'toggles' => array(
					'before_image'  => esc_html__( 'Before Image', 'dsm-supreme-modules-for-divi' ),
					'before_label'  => esc_html__( 'Before Label', 'dsm-supreme-modules-for-divi' ),
					'after_label'   => esc_html__( 'After Label', 'dsm-supreme-modules-for-divi' ),
					'overlay'       => esc_html__( 'Overlay', 'dsm-supreme-modules-for-divi' ),
					'handle_slider' => esc_html__( 'Handle Slider', 'dsm-supreme-modules-for-divi' ),
					'width'         => array(
						'title'    => esc_html__( 'Sizing', 'dsm-supreme-modules-for-divi' ),
						'priority' => 65,
					),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'animation'  => array(
						'title'    => esc_html__( 'Animation', 'dsm-supreme-modules-for-divi' ),
						'priority' => 90,
					),
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
			'fonts'          => array(
				'before_label' => array(
					'label'           => esc_html__( 'Before Label', 'dsm-supreme-modules-pro-for-divi' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .dsm-before-after-image-slider-before-label:before",
					),
					'font_size'       => array(
						'default' => '13px',
					),
					'line_height'     => array(
						'default' => '38px',
					),
					'letter_spacing'  => array(
						'default' => '0px',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'before_label',
				),
				'after_label'  => array(
					'label'           => esc_html__( 'After Label', 'dsm-supreme-modules-pro-for-divi' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .dsm-before-after-image-slider-after-label:before",
					),
					'font_size'       => array(
						'default' => '13px',
					),
					'line_height'     => array(
						'default' => '38px',
					),
					'letter_spacing'  => array(
						'default' => '0px',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'after_label',
				),
			),
			'margin_padding' => array(
				'css' => array(
					'important' => array( 'custom_margin' ),
				),
			),
			'borders'        => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => "{$this->main_css_element}",
							'border_styles' => "{$this->main_css_element}",
						),
					),
				),
			),
			'box_shadow'     => array(
				'default' => array(
					'css' => array(
						'main'         => "{$this->main_css_element}",
						'custom_style' => true,
					),
				),
			),
			'max_width'      => array(
				'options' => array(
					'max_width' => array(
						'depends_show_if' => 'off',
					),
				),
			),
			'text'           => false,
			'button'         => false,
		);
	}

	public function get_fields() {
		return array(
			'before_src'                    => array(
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an before image', 'dsm-supreme-modules-for-divi' ),
				'choose_text'        => esc_attr__( 'Choose an before Image', 'dsm-supreme-modules-for-divi' ),
				'update_text'        => esc_attr__( 'Set As Before Image', 'dsm-supreme-modules-for-divi' ),
				'hide_metadata'      => true,
				'affects'            => array(
					'before_alt',
					'before_title_text',
				),
				'description'        => esc_html__( 'Upload your desired before image, or type in the URL to the image you would like to display.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'        => 'main_content',
			),
			'before_alt'                    => array(
				'label'           => esc_html__( 'Before Image Alternative Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'on',
				'depends_on'      => array(
					'before_src',
				),
				'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'main_content',
			),
			'before_title_text'             => array(
				'label'           => esc_html__( 'Before Image Title Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'on',
				'depends_on'      => array(
					'before_src',
				),
				'description'     => esc_html__( 'This defines the HTML Title text.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'main_content',
			),
			'after_src'                     => array(
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an after image', 'dsm-supreme-modules-for-divi' ),
				'choose_text'        => esc_attr__( 'Choose an after Image', 'dsm-supreme-modules-for-divi' ),
				'update_text'        => esc_attr__( 'Set As After Image', 'dsm-supreme-modules-for-divi' ),
				'hide_metadata'      => true,
				'affects'            => array(
					'after_alt',
					'after_title_text',
				),
				'description'        => esc_html__( 'Upload your desired after image, or type in the URL to the image you would like to display.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'        => 'main_content',
			),
			'after_alt'                     => array(
				'label'           => esc_html__( 'After Image Alternative Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'on',
				'depends_on'      => array(
					'after_src',
				),
				'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'main_content',
			),
			'after_title_text'              => array(
				'label'           => esc_html__( 'After Image Title Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'on',
				'depends_on'      => array(
					'after_src',
				),
				'description'     => esc_html__( 'This defines the HTML Title text.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'main_content',
			),
			'before_label_text'             => array(
				'label'           => esc_html__( 'Before Label Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'This defines the before label text.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'labels',
				'default'         => 'Before',
			),
			'after_label_text'              => array(
				'label'           => esc_html__( 'After Label Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'This defines the after label text.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'labels',
				'default'         => 'After',
			),
			'default_offset_pct'            => array(
				'label'            => esc_html__( 'Default Offset Percentage', 'dsm-supreme-modules-pro-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default_on_front' => '0.5',
				'validate_unit'    => false,
				'unitless'         => true,
				'description'      => esc_html__( 'How much of the before image is visible when the page loads.', 'dsm-supreme-modules-for-divi' ),
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '1',
					'step' => '0.1',
				),
				'toggle_slug'      => 'slider_settings',
			),
			'orientation'                   => array(
				'label'            => esc_html__( 'Orientation', 'dsm-supreme-modules-pro-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'layout',
				'options'          => array(
					'horizontal' => esc_html__( 'Horizontal', 'dsm-supreme-modules-pro-for-divi' ),
					'vertical'   => esc_html__( 'Vertical', 'dsm-supreme-modules-pro-for-divi' ),
				),
				'default_on_front' => 'horizontal',
				'toggle_slug'      => 'slider_settings',
			),
			'no_overlay'                    => array(
				'label'            => esc_html__( 'No Overlay', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'off',
				'affects'          => array(
					'overlay_color',
				),
				'toggle_slug'      => 'slider_settings',
				'description'      => esc_html__( 'Here you can choose whether or not your to show overlay with before and after.', 'dsm-supreme-modules-for-divi' ),
			),
			'move_slider_on_hover'          => array(
				'label'            => esc_html__( 'Move Slider on Hover?', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'slider_settings',
				'description'      => esc_html__( 'Move slider on mouse hover.', 'dsm-supreme-modules-for-divi' ),
			),
			'move_with_handle_only'         => array(
				'label'            => esc_html__( 'Move Slider with Handle', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'slider_settings',
				'description'      => esc_html__( 'Allow a user to swipe anywhere on the image to control slider movement.', 'dsm-supreme-modules-for-divi' ),
			),
			'click_to_move'                 => array(
				'label'            => esc_html__( 'Click to Move Slider', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'slider_settings',
				'description'      => esc_html__( 'Allow a user to click (or tap) anywhere on the image to move the slider to that location.', 'dsm-supreme-modules-for-divi' ),
			),
			'before_label_background_color' => array(
				'label'            => esc_html__( 'Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'color-alpha',
				'custom_color'     => true,
				'default_on_front' => 'rgba(255, 255, 255, 0.2)',
				'depends_show_if'  => 'off',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'before_label',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define a custom background color for the before label.', 'dsm-supreme-modules-for-divi' ),
			),
			'after_label_background_color'  => array(
				'label'            => esc_html__( 'Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'color-alpha',
				'custom_color'     => true,
				'default_on_front' => 'rgba(255, 255, 255, 0.2)',
				'depends_show_if'  => 'off',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'after_label',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define a custom background color for the after label.', 'dsm-supreme-modules-for-divi' ),
			),
			'overlay_color'                 => array(
				'label'            => esc_html__( 'Overlay Color', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'color-alpha',
				'custom_color'     => true,
				'default_on_front' => 'rgba(0, 0, 0, 0.5)',
				'depends_show_if'  => 'off',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'overlay',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define a custom color for the overlay', 'dsm-supreme-modules-for-divi' ),
			),
			'handle_border_color'           => array(
				'label'            => esc_html__( 'Handle Border Color', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'color-alpha',
				'custom_color'     => true,
				'default_on_front' => '#ffffff',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'handle_slider',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define a custom border color for the handle slider.', 'dsm-supreme-modules-for-divi' ),
			),
			'handle_border_radius'          => array(
				'label'            => esc_html__( 'Handle Border Radius', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'handle_slider',
				'mobile_options'   => true,
				'validate_unit'    => true,
				'allowed_units'    => array( 'px' ),
				'default'          => '100px',
				'default_unit'     => 'px',
				'default_on_front' => '',
				'allow_empty'      => true,
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '100px',
					'step' => '1',
				),
				'responsive'       => true,
			),
			'handle_background_color'       => array(
				'label'          => esc_html__( 'Handle Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'handle_slider',
				'mobile_options' => true,
				'description'    => esc_html__( 'Here you can define a custom background color for the handle slider.', 'dsm-supreme-modules-for-divi' ),
			),
			'handle_arrow_color'            => array(
				'label'            => esc_html__( 'Arrow Color', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'color-alpha',
				'custom_color'     => true,
				'default_on_front' => '#ffffff',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'handle_slider',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define a custom arrow color for the handle slider.', 'dsm-supreme-modules-for-divi' ),
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$multi_view        = et_pb_multi_view_options( $this );
		$before_src        = $this->props['before_src'];
		$before_alt        = $this->props['before_alt'];
		$before_title_text = $this->props['before_title_text'];
		$before_label_text = $this->props['before_label_text'];
		$after_src         = $this->props['after_src'];
		$after_alt         = $this->props['after_alt'];
		$after_title_text  = $this->props['after_title_text'];
		$after_label_text  = $this->props['after_label_text'];

		$default_offset_pct                   = $this->props['default_offset_pct'];
		$orientation                          = $this->props['orientation'];
		$no_overlay                           = $this->props['no_overlay'];
		$move_slider_on_hover                 = $this->props['move_slider_on_hover'];
		$move_with_handle_only                = $this->props['move_with_handle_only'];
		$click_to_move                        = $this->props['click_to_move'];
		$before_label_background_color        = $this->props['before_label_background_color'];
		$before_label_background_color_values = et_pb_responsive_options()->get_property_values( $this->props, 'before_label_background_color' );
		$before_label_background_color_tablet = isset( $before_label_background_color_values['tablet'] ) ? $before_label_background_color_values['tablet'] : '';
		$before_label_background_color_phone  = isset( $before_label_background_color_values['phone'] ) ? $before_label_background_color_values['phone'] : '';
		$after_label_background_color         = $this->props['after_label_background_color'];
		$after_label_background_color_values  = et_pb_responsive_options()->get_property_values( $this->props, 'after_label_background_color' );
		$after_label_background_color_tablet  = isset( $after_label_background_color_values['tablet'] ) ? $after_label_background_color_values['tablet'] : '';
		$after_label_background_color_phone   = isset( $after_label_background_color_values['phone'] ) ? $after_label_background_color_values['phone'] : '';
		$handle_border_color                  = $this->props['handle_border_color'];
		$handle_border_color_values           = et_pb_responsive_options()->get_property_values( $this->props, 'handle_border_color' );
		$handle_border_color_tablet           = isset( $handle_border_color_values['tablet'] ) ? $handle_border_color_values['tablet'] : '';
		$handle_border_color_phone            = isset( $handle_border_color_values['phone'] ) ? $handle_border_color_values['phone'] : '';
		$handle_border_radius                 = $this->props['handle_border_radius'];
		$handle_border_radius_values          = et_pb_responsive_options()->get_property_values( $this->props, 'handle_border_radius' );
		$handle_border_radius_tablet          = isset( $handle_border_radius_values['tablet'] ) ? $handle_border_radius_values['tablet'] : '';
		$handle_border_radius_phone           = isset( $handle_border_radius_values['phone'] ) ? $handle_border_radius_values['phone'] : '';
		$handle_background_color              = $this->props['handle_background_color'];
		$handle_background_color_values       = et_pb_responsive_options()->get_property_values( $this->props, 'handle_background_color' );
		$handle_background_color_tablet       = isset( $handle_background_color_values['tablet'] ) ? $handle_background_color_values['tablet'] : '';
		$handle_background_color_phone        = isset( $handle_background_color_values['phone'] ) ? $handle_background_color_values['phone'] : '';
		$handle_arrow_color                   = $this->props['handle_arrow_color'];
		$handle_arrow_color_values            = et_pb_responsive_options()->get_property_values( $this->props, 'handle_arrow_color' );
		$handle_arrow_color_tablet            = isset( $handle_arrow_color_values['tablet'] ) ? $handle_arrow_color_values['tablet'] : '';
		$handle_arrow_color_phone             = isset( $handle_arrow_color_values['phone'] ) ? $handle_arrow_color_values['phone'] : '';

		$overlay_color        = $this->props['overlay_color'];
		$overlay_color_values = et_pb_responsive_options()->get_property_values( $this->props, 'overlay_color' );
		$overlay_color_tablet = isset( $overlay_color_values['tablet'] ) ? $overlay_color_values['tablet'] : '';
		$overlay_color_phone  = isset( $overlay_color_values['phone'] ) ? $overlay_color_values['phone'] : '';

		$animation_style           = $this->props['animation_style'];
		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$wrapper_selector            = '%%order_class%% .dsm_before_after_image_wrapper';
		$overlay_selector            = '%%order_class%% .dsm-before-after-image-slider-overlay';
		$overlay_selector_hover      = '%%order_class%% .dsm-before-after-image-slider-overlay:hover';
		$before_label_selector       = '%%order_class%% .dsm-before-after-image-slider-before-label:before';
		$after_label_selector        = '%%order_class%% .dsm-before-after-image-slider-after-label:before';
		$handle_border_selector      = '%%order_class%% .dsm-before-after-image-slider-horizontal .dsm-before-after-image-slider-handle:before, %%order_class%% .dsm-before-after-image-slider-horizontal .dsm-before-after-image-slider-handle:after, %%order_class%% .dsm-before-after-image-slider-vertical .dsm-before-after-image-slider-handle:before, %%order_class%% .dsm-before-after-image-slider-vertical .dsm-before-after-image-slider-handle:after';
		$handle_selector             = '%%order_class%% .dsm-before-after-image-slider-handle';
		$handle_arrow_up_selector    = '%%order_class%% .dsm-before-after-image-slider-up-arrow';
		$handle_arrow_down_selector  = '%%order_class%% .dsm-before-after-image-slider-down-arrow';
		$handle_arrow_left_selector  = '%%order_class%% .dsm-before-after-image-slider-left-arrow';
		$handle_arrow_right_selector = '%%order_class%% .dsm-before-after-image-slider-right-arrow';

		if ( 'off' === $no_overlay ) {
			// Overlay.
			$overlay_color_style        = sprintf( ' background-color: %1$s;', esc_attr( $overlay_color ) );
			$overlay_color_tablet_style = '' !== $overlay_color_tablet ? sprintf( ' background-color: %1$s;', esc_attr( $overlay_color_tablet ) ) : '';
			$overlay_color_phone_style  = '' !== $overlay_color_phone ? sprintf( ' background-color: %1$s;', esc_attr( $overlay_color_phone ) ) : '';

			if ( 'rgba(0,0,0,0.5)' !== $overlay_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $overlay_selector_hover,
						'declaration' => $overlay_color_style,
					)
				);
			}

			if ( '' !== $overlay_color_tablet ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $overlay_selector_hover,
						'declaration' => $overlay_color_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
			}

			if ( '' !== $overlay_color_phone ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $overlay_selector_hover,
						'declaration' => $overlay_color_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
			}

			// Labels.
			$before_label_background_color_style        = sprintf( ' background-color: %1$s;', esc_attr( $before_label_background_color ) );
			$before_label_background_color_tablet_style = '' !== $before_label_background_color_tablet ? sprintf( ' background-color: %1$s;', esc_attr( $before_label_background_color_tablet ) ) : '';
			$before_label_background_color_phone_style  = '' !== $before_label_background_color_phone ? sprintf( ' background-color: %1$s;', esc_attr( $before_label_background_color_phone ) ) : '';

			if ( 'rgba(255, 255, 255, 0.2)' !== $before_label_background_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $before_label_selector,
						'declaration' => $before_label_background_color_style,
					)
				);
			}

			if ( '' !== $before_label_background_color_tablet ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $before_label_selector,
						'declaration' => $before_label_background_color_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
			}

			if ( '' !== $before_label_background_color_phone ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $before_label_selector,
						'declaration' => $before_label_background_color_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
			}

			$after_label_background_color_style        = sprintf( ' background-color: %1$s;', esc_attr( $after_label_background_color ) );
			$after_label_background_color_tablet_style = '' !== $after_label_background_color_tablet ? sprintf( ' background-color: %1$s;', esc_attr( $after_label_background_color_tablet ) ) : '';
			$after_label_background_color_phone_style  = '' !== $after_label_background_color_phone ? sprintf( ' background-color: %1$s;', esc_attr( $after_label_background_color_phone ) ) : '';

			if ( 'rgba(255, 255, 255, 0.2)' !== $after_label_background_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $after_label_selector,
						'declaration' => $after_label_background_color_style,
					)
				);
			}

			if ( '' !== $after_label_background_color_tablet ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $after_label_selector,
						'declaration' => $after_label_background_color_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
			}

			if ( '' !== $after_label_background_color_phone ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $after_label_selector,
						'declaration' => $after_label_background_color_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
			}
		}

		// Handle Slider.
		$handle_border_style              = sprintf( ' border-color: %1$s;', esc_attr( $handle_border_color ) );
		$handle_border_tablet_style       = '' !== $handle_border_color_tablet ? sprintf( ' border-color: %1$s;', esc_attr( $handle_border_color_tablet ) ) : '';
		$handle_border_phone_style        = '' !== $handle_border_color_phone ? sprintf( ' border-color: %1$s;', esc_attr( $handle_border_color_phone ) ) : '';
		$handle_border_color_style        = sprintf( ' background-color: %1$s;', esc_attr( $handle_border_color ) );
		$handle_border_color_tablet_style = '' !== $handle_border_color_tablet ? sprintf( ' background-color: %1$s;', esc_attr( $handle_border_color_tablet ) ) : '';
		$handle_border_color_phone_style  = '' !== $handle_border_color_phone ? sprintf( ' background-color: %1$s;', esc_attr( $handle_border_color_phone ) ) : '';

		if ( '#ffffff' !== $handle_border_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_selector,
					'declaration' => $handle_border_style,
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_border_selector,
					'declaration' => $handle_border_color_style,
				)
			);
		}

		if ( '' !== $handle_border_color_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_selector,
					'declaration' => $handle_border_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_border_selector,
					'declaration' => $handle_border_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}

		if ( '' !== $handle_border_color_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_border_selector,
					'declaration' => $handle_border_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_selector,
					'declaration' => $handle_border_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);

		}

		$handle_border_radius_style        = sprintf( ' border-radius: %1$s;', esc_attr( $handle_border_radius ) );
		$handle_border_radius_tablet_style = '' !== $handle_border_radius_tablet ? sprintf( ' border-radius: %1$s;', esc_attr( $handle_border_radius_tablet ) ) : '';
		$handle_border_radius_phone_style  = '' !== $handle_border_radius_phone ? sprintf( ' border-radius: %1$s;', esc_attr( $handle_border_radius_phone ) ) : '';

		if ( '100px' !== $handle_border_radius ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_selector,
					'declaration' => $handle_border_radius_style,
				)
			);
		}

		if ( '' !== $handle_border_radius_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_selector,
					'declaration' => $handle_border_radius_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}

		if ( '' !== $handle_border_radius_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_selector,
					'declaration' => $handle_border_radius_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		// Arrows.
		if ( 'vertical' === $orientation ) {
			$handle_arrow_up_style          = sprintf( ' border-bottom-color: %1$s;', esc_attr( $handle_arrow_color ) );
			$handle_arrow_up_tablet_style   = '' !== $handle_arrow_color_tablet ? sprintf( ' border-bottom-color: %1$s;', esc_attr( $handle_arrow_color_tablet ) ) : '';
			$handle_arrow_up_phone_style    = '' !== $handle_arrow_color_phone ? sprintf( ' border-bottom-color: %1$s;', esc_attr( $handle_arrow_color_phone ) ) : '';
			$handle_arrow_down_style        = sprintf( ' border-top-color: %1$s;', esc_attr( $handle_arrow_color ) );
			$handle_arrow_down_tablet_style = '' !== $handle_arrow_color_tablet ? sprintf( ' border-top-color: %1$s;', esc_attr( $handle_arrow_color_tablet ) ) : '';
			$handle_arrow_down_phone_style  = '' !== $handle_arrow_color_phone ? sprintf( ' border-top-color: %1$s;', esc_attr( $handle_arrow_color_phone ) ) : '';

			if ( '#ffffff' !== $handle_arrow_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_up_selector,
						'declaration' => $handle_arrow_up_style,
					)
				);
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_down_selector,
						'declaration' => $handle_arrow_down_style,
					)
				);
			}

			if ( '' !== $handle_arrow_color_tablet ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_up_selector,
						'declaration' => $handle_arrow_up_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_down_selector,
						'declaration' => $handle_arrow_down_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
			}

			if ( '' !== $handle_arrow_color_phone ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_up_selector,
						'declaration' => $handle_arrow_up_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_down_selector,
						'declaration' => $handle_arrow_down_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
			}
		} else {
			$handle_arrow_left_style         = sprintf( ' border-right-color: %1$s;', esc_attr( $handle_arrow_color ) );
			$handle_arrow_left_tablet_style  = '' !== $handle_arrow_color_tablet ? sprintf( ' border-right-color: %1$s;', esc_attr( $handle_arrow_color_tablet ) ) : '';
			$handle_arrow_left_phone_style   = '' !== $handle_arrow_color_phone ? sprintf( ' border-right-color: %1$s;', esc_attr( $handle_arrow_color_phone ) ) : '';
			$handle_arrow_right_style        = sprintf( ' border-left-color: %1$s;', esc_attr( $handle_arrow_color ) );
			$handle_arrow_right_tablet_style = '' !== $handle_arrow_color_tablet ? sprintf( ' border-left-color: %1$s;', esc_attr( $handle_arrow_color_tablet ) ) : '';
			$handle_arrow_right_phone_style  = '' !== $handle_arrow_color_phone ? sprintf( ' border-left-color: %1$s;', esc_attr( $handle_arrow_color_phone ) ) : '';

			if ( '#ffffff' !== $handle_arrow_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_left_selector,
						'declaration' => $handle_arrow_left_style,
					)
				);
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_right_selector,
						'declaration' => $handle_arrow_right_style,
					)
				);
			}

			if ( '' !== $handle_arrow_color_tablet ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_left_selector,
						'declaration' => $handle_arrow_left_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_right_selector,
						'declaration' => $handle_arrow_right_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
			}

			if ( '' !== $handle_arrow_color_phone ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_left_selector,
						'declaration' => $handle_arrow_left_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $handle_arrow_right_selector,
						'declaration' => $handle_arrow_right_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
			}

			// Handle.
			$handle_horizontal_border_style        = sprintf( ' box-shadow: 0 -3px 0 %1$s, 0px 0px 12px rgba(51, 51, 51, 0.5);', esc_attr( $handle_border_color ) );
			$handle_horizontal_border_tablet_style = '' !== $handle_border_color_tablet ? sprintf( ' box-shadow: 0 -3px 0 %1$s, 0px 0px 12px rgba(51, 51, 51, 0.5);', esc_attr( $handle_border_color_tablet ) ) : '';
			$handle_horizontal_border_phone_style  = '' !== $handle_border_color_phone ? sprintf( ' box-shadow: 0 -3px 0 %1$s, 0px 0px 12px rgba(51, 51, 51, 0.5);', esc_attr( $handle_border_color_phone ) ) : '';

			if ( '#ffffff' !== $handle_border_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .dsm-before-after-image-slider-horizontal .dsm-before-after-image-slider-handle:before, %%order_class%% .dsm-before-after-image-slider-horizontal .dsm-before-after-image-slider-handle:after',
						'declaration' => $handle_horizontal_border_style,
					)
				);
			}

			if ( '' !== $handle_border_color_tablet ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .dsm-before-after-image-slider-horizontal .dsm-before-after-image-slider-handle:before, %%order_class%% .dsm-before-after-image-slider-horizontal .dsm-before-after-image-slider-handle:after',
						'declaration' => $handle_horizontal_border_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
			}

			if ( '' !== $handle_border_color_phone ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .dsm-before-after-image-slider-horizontal .dsm-before-after-image-slider-handle:before, %%order_class%% .dsm-before-after-image-slider-horizontal .dsm-before-after-image-slider-handle:after',
						'declaration' => $handle_horizontal_border_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
			}
		}

		$handle_background_style        = sprintf( ' background-color: %1$s;', esc_attr( $handle_background_color ) );
		$handle_background_tablet_style = '' !== $handle_background_color_tablet ? sprintf( ' background-color: %1$s;', esc_attr( $handle_background_color_tablet ) ) : '';
		$handle_background_phone_style  = '' !== $handle_background_color_phone ? sprintf( ' background-color: %1$s;', esc_attr( $handle_background_color_phone ) ) : '';

		if ( '' !== $handle_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_selector,
					'declaration' => $handle_background_style,
				)
			);
		}

		if ( '' !== $handle_background_color_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_selector,
					'declaration' => $handle_background_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}

		if ( '' !== $handle_background_color_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $handle_selector,
					'declaration' => $handle_background_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		if ( 'Before' !== $before_label_text ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $before_label_selector,
					'declaration' => sprintf( ' content: "%1$s";', esc_attr( $before_label_text ) ),
				)
			);
		}

		if ( 'After' !== $after_label_text ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $after_label_selector,
					'declaration' => sprintf( ' content: "%1$s";', esc_attr( $after_label_text ) ),
				)
			);
		}

		$before_image_html = $multi_view->render_element(
			array(
				'tag'      => 'img',
				'attrs'    => array(
					'class' => 'skip-lazy',
					'src'   => '{{before_src}}',
					'alt'   => '{{before_alt}}',
					'title' => '{{before_title_text}}',
				),
				'required' => 'before_src',
			)
		);

		$after_image_html = $multi_view->render_element(
			array(
				'tag'      => 'img',
				'attrs'    => array(
					'class' => 'skip-lazy',
					'src'   => '{{after_src}}',
					'alt'   => '{{after_alt}}',
					'title' => '{{after_title_text}}',
				),
				'required' => 'after_src',
			)
		);

		$output = sprintf(
			'%1$s%2$s',
			$before_image_html,
			$after_image_html
		);

		$data_attrs[] = array(
			'offset'      => $default_offset_pct,
			'orientation' => $orientation,
			'overlay'     => 'off' !== $no_overlay ? true : false,
			'hover'       => 'off' !== $move_slider_on_hover ? true : false,
			'handle'      => 'off' !== $move_with_handle_only ? true : false,
			'click'       => 'off' !== $click_to_move ? true : false,
		);

		wp_enqueue_script( 'dsm-before-after-image' );

		// Module classnames.
		$class = 'dsm_before_after_image_wrapper';
		if ( ! in_array( $animation_style, array( '', 'none' ) ) ) {
			$this->add_classname( 'et-waypoint' );
		}

		// Render module content.
		$output = sprintf(
			'<div%3$s class="%2$s" data-params=%6$s>
				%5$s
				%4$s
				%1$s
			</div>',
			$output,
			esc_attr( $class ),
			$this->module_id(),
			$video_background,
			$parallax_image_background,
			wp_json_encode( $data_attrs )
		);

		return $output;
	}
}

new DSM_Before_After_Image();
