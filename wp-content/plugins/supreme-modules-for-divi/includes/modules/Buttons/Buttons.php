<?php

class DSM_Button extends ET_Builder_Module {

	public $slug       = 'dsm_button';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name      = esc_html__( 'Supreme Button', 'dsm-supreme-modules-for-divi' );
		$this->plural    = esc_html__( 'Supreme Buttons', 'dsm-supreme-modules-for-divi' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		$this->custom_css_fields = array(
			'main_element' => array(
				'label'                    => esc_html__( 'Main Element', 'dsm-supreme-modules-for-divi' ),
				'no_space_before_selector' => true,
			),
		);

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'dsm-supreme-modules-for-divi' ),
					'links'        => esc_html__( 'Links', 'dsm-supreme-modules-for-divi' ),
					'separator'    => esc_html__( 'Separator', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'alignment' => esc_html__( 'Alignment', 'dsm-supreme-modules-for-divi' ),
					'text'      => array(
						'title'    => esc_html__( 'Text', 'dsm-supreme-modules-for-divi' ),
						'priority' => 49,
					),
				),
			),
		);

	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'          => array(
				'separator_text' => array(
					'label'          => esc_html__( 'Separator', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% .dsm-button-separator-text',
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
			'borders'        => array(
				'default' => false,
			),
			'button'         => array(
				'button_one' => array(
					'label'          => esc_html__( 'Button One', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => "{$this->main_css_element} .et_pb_button_one.et_pb_button",
					),
					'box_shadow'     => array(
						'css' => array(
							'main' => '%%order_class%% .et_pb_button_one',
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
				),
				'button_two' => array(
					'label'          => esc_html__( 'Button Two', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => "{$this->main_css_element} .et_pb_button_two.et_pb_button",
					),
					'box_shadow'     => array(
						'css' => array(
							'main' => '%%order_class%% .et_pb_button_two',
						),
					),
					'margin_padding' => array(
						'css'           => array(
							'important' => 'all',
						),
						'custom_margin' => array(
							'default' => '|||20px|false|false',
						),
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'padding'   => '%%order_class%%, %%order_class%%:hover',
					'margin'    => '%%order_class%%.dsm_button',
					'important' => 'all',
				),
			),
			'text'           => array(
				'use_text_orientation'  => false,
				'use_background_layout' => true,
				'options'               => array(
					'background_layout' => array(
						'default_on_front' => 'light',
						'hover'            => 'tabs',
					),
				),
			),
			'text_shadow'    => array(
				'default' => false,
			),
			'background'     => false,
			'max_width'      => false,
			'link_options'   => false,
		);
	}

	public function get_fields() {
		return array(
			'button_one_text'                    => array(
				'label'           => esc_html__( 'Button #1 Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Enter the text for the Button.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'main_content',
			),
			'button_one_url'                     => array(
				'label'           => esc_html__( 'Button #1 URL', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Enter the URL for the Button.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'links',
			),
			'button_one_url_new_window'          => array(
				'label'            => esc_html__( 'Url Opens', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'In The New Tab', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'links',
				'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
				'show_if_not'      => array(
					'button_one_image_popup' => 'on',
					'button_one_video_popup' => 'on',
				),
			),
			'button_one_image_popup'             => array(
				'label'            => esc_html__( 'Open as Image Lightbox', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'links',
				'description'      => esc_html__( 'Here you can choose whether or not the button should open in Lightbox. Note: if you select to open the button in Lightbox, url options below will be ignored.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
				'show_if_not'      => array(
					'button_one_video_popup' => 'on',
				),
			),
			'button_one_image_src'               => array(
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'dsm-supreme-modules-for-divi' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'dsm-supreme-modules-for-divi' ),
				'update_text'        => esc_attr__( 'Set As Image', 'dsm-supreme-modules-for-divi' ),
				'hide_metadata'      => true,
				'description'        => esc_html__( 'Upload your desired image for Button One Image Lightbox, or type in the URL to the image you would like to display.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'        => 'links',
				'show_if'            => array(
					'button_one_image_popup' => 'on',
				),
			),
			'button_one_video_popup'             => array(
				'label'            => esc_html__( 'Open as Video Lightbox', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'links',
				'description'      => esc_html__( 'Put the Video link on the Button #1 URL. Copy the video URL link and paste it here. Support: YouTube, Vimeo and Dailymotion.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
				'show_if_not'      => array(
					'button_one_image_popup' => 'on',
				),
			),
			'button_two_text'                    => array(
				'label'           => esc_html__( 'Button #1 Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Enter the text for the Button.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'main_content',
			),
			'button_two_url'                     => array(
				'label'           => esc_html__( 'Button #1 URL', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Enter the URL for the Button.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'links',
			),
			'button_two_url_new_window'          => array(
				'label'            => esc_html__( 'Url Opens', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'In The New Tab', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'links',
				'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
				'show_if_not'      => array(
					'button_two_image_popup' => 'on',
					'button_two_video_popup' => 'on',
				),
			),
			'button_two_image_popup'             => array(
				'label'            => esc_html__( 'Open as Image Lightbox', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'links',
				'description'      => esc_html__( 'Here you can choose whether or not the button should open in Lightbox. Note: if you select to open the button in Lightbox, url options below will be ignored.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
				'show_if_not'      => array(
					'button_two_video_popup' => 'on',
				),
			),
			'button_two_image_src'               => array(
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'dsm-supreme-modules-for-divi' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'dsm-supreme-modules-for-divi' ),
				'update_text'        => esc_attr__( 'Set As Image', 'dsm-supreme-modules-for-divi' ),
				'hide_metadata'      => true,
				'description'        => esc_html__( 'Upload your desired image for Button One Image Lightbox, or type in the URL to the image you would like to display.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'        => 'links',
				'show_if'            => array(
					'button_two_image_popup' => 'on',
				),
			),
			'button_two_video_popup'             => array(
				'label'            => esc_html__( 'Open as Video Lightbox', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'links',
				'description'      => esc_html__( 'Put the Video link on the Button #2 URL. Copy the video URL link and paste it here. Support: YouTube, Vimeo and Dailymotion.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
				'show_if_not'      => array(
					'button_two_image_popup' => 'on',
				),
			),
			'button_alignment'                   => array(
				'label'           => esc_html__( 'Button Alignment', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'alignment',
				'description'     => esc_html__( 'Here you can define the alignment of Button', 'dsm-supreme-modules-for-divi' ),
				'mobile_options'  => true,
			),
			'separator_text'                     => array(
				'label'           => esc_html__( 'Separator Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired seprator text, or leave blank for no separator text in between the both buttons.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'separator',
			),
			'fullwidth_separator_text_on_mobile' => array(
				'label'            => esc_html__( 'Make Separator Text Fullwidth On Mobile', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'separator',
				'description'      => esc_html__( 'This will make the Separator Text as fullwidth instead of inline-block.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
				'show_if'          => array(
					'remove_separator_text_on_mobile' => 'off',
				),
			),
			'remove_separator_text_on_mobile'    => array(
				'label'            => esc_html__( 'Remove Separator Text On Mobile', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'separator',
				'description'      => esc_html__( 'This will remove Separator Text on mobile devices.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
			),
			'separator_gap'                      => array(
				'label'           => esc_html__( 'Separator Gap', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'mobile_options'  => true,
				'toggle_slug'     => 'width',
				'default_unit'    => 'px',
				'default'         => '10px',
				'responsive'      => true,
			),
			'button_one_hover_animation'         => array(
				'label'            => esc_html__( 'Button Hover #1 Animation', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'dsm-none'         => esc_html__( 'None', 'dsm-supreme-modules-for-divi' ),
					'dsm-grow'         => esc_html__( 'Grow', 'dsm-supreme-modules-for-divi' ),
					'dsm-shrink'       => esc_html__( 'Shrink', 'dsm-supreme-modules-for-divi' ),
					'dsm-pulse'        => esc_html__( 'Pulse', 'dsm-supreme-modules-for-divi' ),
					'dsm-pulse-grow'   => esc_html__( 'Pulse Grow', 'dsm-supreme-modules-for-divi' ),
					'dsm-pulse-shrink' => esc_html__( 'Pulse Grow', 'dsm-supreme-modules-for-divi' ),
					'dsm-push'         => esc_html__( 'Push', 'dsm-supreme-modules-for-divi' ),
					'dsm-pop'          => esc_html__( 'Pop', 'dsm-supreme-modules-for-divi' ),
					'dsm-bounce-in'    => esc_html__( 'Bounce In', 'dsm-supreme-modules-for-divi' ),
					'dsm-bounce-out'   => esc_html__( 'Bounce Out', 'dsm-supreme-modules-for-divi' ),
					'dsm-rotate'       => esc_html__( 'Rotate', 'dsm-supreme-modules-for-divi' ),
				),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'animation',
				'default_on_front' => 'dsm-none',
			),
			'button_two_hover_animation'         => array(
				'label'            => esc_html__( 'Button Hover #2 Animation', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'dsm-none'         => esc_html__( 'None', 'dsm-supreme-modules-for-divi' ),
					'dsm-grow'         => esc_html__( 'Grow', 'dsm-supreme-modules-for-divi' ),
					'dsm-shrink'       => esc_html__( 'Shrink', 'dsm-supreme-modules-for-divi' ),
					'dsm-pulse'        => esc_html__( 'Pulse', 'dsm-supreme-modules-for-divi' ),
					'dsm-pulse-grow'   => esc_html__( 'Pulse Grow', 'dsm-supreme-modules-for-divi' ),
					'dsm-pulse-shrink' => esc_html__( 'Pulse Grow', 'dsm-supreme-modules-for-divi' ),
					'dsm-push'         => esc_html__( 'Push', 'dsm-supreme-modules-for-divi' ),
					'dsm-pop'          => esc_html__( 'Pop', 'dsm-supreme-modules-for-divi' ),
					'dsm-bounce-in'    => esc_html__( 'Bounce In', 'dsm-supreme-modules-for-divi' ),
					'dsm-bounce-out'   => esc_html__( 'Bounce Out', 'dsm-supreme-modules-for-divi' ),
					'dsm-rotate'       => esc_html__( 'Rotate', 'dsm-supreme-modules-for-divi' ),
				),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'animation',
				'default_on_front' => 'dsm-none',
			),
		);
	}

	/**
	 * Get button alignment.
	 *
	 * @since 3.23 Add responsive support by adding device parameter.
	 *
	 * @param  string $device Current device name.
	 * @return string         Alignment value, rtl or not.
	 */
	public function get_button_alignment( $device = 'desktop' ) {
		$suffix           = 'desktop' !== $device ? "_{$device}" : '';
		$text_orientation = isset( $this->props[ "button_alignment{$suffix}" ] ) ? $this->props[ "button_alignment{$suffix}" ] : '';

		return et_pb_get_alignment( $text_orientation );
	}

	function render( $attrs, $content = null, $render_slug ) {
		$button_one_text                    = $this->props['button_one_text'];
		$button_one_url                     = $this->props['button_one_url'];
		$button_one_video_popup             = $this->props['button_one_video_popup'];
		$button_one_image_popup             = $this->props['button_one_image_popup'];
		$button_one_image_src               = $this->props['button_one_image_src'];
		$button_one_rel                     = $this->props['button_one_rel'];
		$button_two_text                    = $this->props['button_two_text'];
		$button_two_url                     = $this->props['button_two_url'];
		$button_two_video_popup             = $this->props['button_two_video_popup'];
		$button_two_image_popup             = $this->props['button_two_image_popup'];
		$button_two_image_src               = $this->props['button_two_image_src'];
		$button_two_rel                     = $this->props['button_two_rel'];
		$background_layout                  = $this->props['background_layout'];
		$background_layout_hover            = et_pb_hover_options()->get_value( 'background_layout', $this->props, 'light' );
		$background_layout_hover_enabled    = et_pb_hover_options()->is_enabled( 'background_layout', $this->props );
		$background_layout_values           = et_pb_responsive_options()->get_property_values( $this->props, 'background_layout' );
		$background_layout_tablet           = isset( $background_layout_values['tablet'] ) ? $background_layout_values['tablet'] : '';
		$background_layout_phone            = isset( $background_layout_values['phone'] ) ? $background_layout_values['phone'] : '';
		$button_one_url_new_window          = $this->props['button_one_url_new_window'];
		$button_two_url_new_window          = $this->props['button_two_url_new_window'];
		$custom_icon_1                      = $this->props['button_one_icon'];
		$button_custom_1                    = $this->props['custom_button_one'];
		$custom_icon_2                      = $this->props['button_two_icon'];
		$button_custom_2                    = $this->props['custom_button_two'];
		$button_alignment                   = $this->get_button_alignment();
		$is_button_aligment_responsive      = et_pb_responsive_options()->is_responsive_enabled( $this->props, 'button_alignment' );
		$button_alignment_tablet            = $is_button_aligment_responsive ? $this->get_button_alignment( 'tablet' ) : '';
		$button_alignment_phone             = $is_button_aligment_responsive ? $this->get_button_alignment( 'phone' ) : '';
		$separator_text                     = $this->props['separator_text'];
		$separator_gap                      = $this->props['separator_gap'];
		$separator_gap_tablet               = $this->props['separator_gap_tablet'];
		$separator_gap_phone                = $this->props['separator_gap_phone'];
		$separator_gap_last_edited          = $this->props['separator_gap_last_edited'];
		$button_one_hover_animation         = $this->props['button_one_hover_animation'];
		$button_two_hover_animation         = $this->props['button_two_hover_animation'];
		$fullwidth_separator_text_on_mobile = $this->props['fullwidth_separator_text_on_mobile'];
		$remove_separator_text_on_mobile    = $this->props['remove_separator_text_on_mobile'];

		// Button Alignment.
		$button_alignments = array();
		if ( ! empty( $button_alignment ) ) {
			array_push( $button_alignments, sprintf( 'et_pb_button_alignment_%1$s', esc_attr( $button_alignment ) ) );
		}

		if ( ! empty( $button_alignment_tablet ) ) {
			array_push( $button_alignments, sprintf( 'et_pb_button_alignment_tablet_%1$s', esc_attr( $button_alignment_tablet ) ) );
		}

		if ( ! empty( $button_alignment_phone ) ) {
			array_push( $button_alignments, sprintf( 'et_pb_button_alignment_phone_%1$s', esc_attr( $button_alignment_phone ) ) );
		}

		$button_alignment_classes = join( ' ', $button_alignments );

		$separator_gap_responsive_active = et_pb_get_responsive_status( $separator_gap_last_edited );

		$separator_gap_values = array(
			'desktop' => $separator_gap,
			'tablet'  => $separator_gap_responsive_active ? $separator_gap_tablet : '',
			'phone'   => $separator_gap_responsive_active ? $separator_gap_phone : '',
		);

		et_pb_generate_responsive_css( $separator_gap_values, '%%order_class%% .dsm-button-separator-text', 'margin-left', $render_slug );
		et_pb_generate_responsive_css( $separator_gap_values, '%%order_class%% .dsm-button-separator-text', 'margin-right', $render_slug );

		$add_class  = '';
		$add_class .= " et_pb_bg_layout_{$background_layout}";
		if ( ! empty( $background_layout_tablet ) ) {
			$add_class .= " et_pb_bg_layout_{$background_layout_tablet}_tablet";
		}
		if ( ! empty( $background_layout_phone ) ) {
			$add_class .= " et_pb_bg_layout_{$background_layout_phone}_phone";
		}

		$button_output = '';

		if ( '' !== $button_one_text ) {
			$button_output .= sprintf(
				'<a class="et_pb_button et_pb_button_one%5$s%8$s%9$s%10$s %7$s" %6$s href="%1$s"%3$s%4$s>%2$s</a>',
				'off' !== $button_one_image_popup ? esc_url( $button_one_image_src ) : esc_url( $button_one_url ),
				esc_html( $button_one_text ),
				( 'on' === $button_one_url_new_window ? ' target="_blank"' : '' ),
				'' !== $custom_icon_1 && 'on' === $button_custom_1 ? sprintf(
					' data-icon="%1$s"',
					esc_attr( et_pb_process_font_icon( $custom_icon_1 ) )
				) : '',
				'' !== $custom_icon_1 && 'on' === $button_custom_1 ? ' et_pb_custom_button_icon' : '',
				$this->get_rel_attributes( $button_one_rel ),
				esc_attr( $button_one_hover_animation ),
				'off' !== $button_one_video_popup ? ' dsm-video-lightbox' : '',
				'off' !== $button_one_image_popup ? ' dsm-image-lightbox' : '',
				$add_class
			);
		}

		if ( '' !== $separator_text ) {
			$button_output .= '<span class="dsm-button-separator-text">' . $separator_text . '</span>';
		}

		if ( '' !== $button_two_text ) {
			$button_output .= sprintf(
				'<a class="et_pb_button et_pb_button_two%5$s%8$s%9$s%10$s %7$s" %6$s href="%1$s"%3$s%4$s>%2$s</a>',
				'off' !== $button_two_image_popup ? esc_url( $button_two_image_src ) : esc_url( $button_two_url ),
				esc_html( $button_two_text ),
				( 'on' === $button_two_url_new_window ? ' target="_blank"' : '' ),
				'' !== $custom_icon_2 && 'on' === $button_custom_2 ? sprintf(
					' data-icon="%1$s"',
					esc_attr( et_pb_process_font_icon( $custom_icon_2 ) )
				) : '',
				'' !== $custom_icon_2 && 'on' === $button_custom_2 ? ' et_pb_custom_button_icon' : '',
				$this->get_rel_attributes( $button_two_rel ),
				esc_attr( $button_two_hover_animation ),
				'off' !== $button_two_video_popup ? ' dsm-video-lightbox' : '',
				'off' !== $button_two_image_popup ? ' dsm-image-lightbox' : '',
				$add_class
			);
		}

		$data_background_layout       = '';
		$data_background_layout_hover = '';
		if ( $background_layout_hover_enabled ) {
			$data_background_layout       = sprintf(
				' data-background-layout="%1$s"',
				esc_attr( $background_layout )
			);
			$data_background_layout_hover = sprintf(
				' data-background-layout-hover="%1$s"',
				esc_attr( $background_layout_hover )
			);
		}

		$this->add_classname( "et_pb_bg_layout_{$background_layout}" );
		if ( ! empty( $background_layout_tablet ) ) {
			$this->add_classname( "et_pb_bg_layout_{$background_layout_tablet}_tablet" );
		}
		if ( ! empty( $background_layout_phone ) ) {
			$this->add_classname( "et_pb_bg_layout_{$background_layout_phone}_phone" );
		}

		if ( 'on' === $button_one_image_popup || 'on' === $button_two_image_popup ) {
			if ( ! wp_script_is( 'magnific-popup', 'enqueued' ) ) {
				wp_enqueue_script( 'magnific-popup' );
			}
		}

		if ( 'on' === $button_one_video_popup || 'on' === $button_two_video_popup ) {
			if ( ! wp_script_is( 'magnific-popup', 'enqueued' ) ) {
				wp_enqueue_script( 'magnific-popup' );
			}
		}

		$output = sprintf(
			'<div class="et_pb_button_module_wrapper dsm_button_%3$s_wrapper %2$s%4$s%5$s%8$s"%6$s%7$s>
				%1$s
			</div>',
			$button_output,
			esc_attr( $button_alignment_classes ),
			$this->render_count(),
			( 'off' !== $remove_separator_text_on_mobile ? ' dsm-button-separator-remove' : '' ),
			( 'off' !== $fullwidth_separator_text_on_mobile ? ' dsm-button-separator-fullwidth' : '' ),
			et_core_esc_previously( $data_background_layout ),
			et_core_esc_previously( $data_background_layout_hover ),
			( '' !== $separator_text ? ' dsm-button-seperator' : '' )
		);

		return $output;
	}
}

new DSM_Button();
