<?php

class DSM_Perspective_Image extends ET_Builder_Module {

	public $slug       = 'dsm_perspective_image';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name      = esc_html__( 'Supreme Image', 'dsm-supreme-modules-for-divi' );
		$this->plural    = esc_html__( 'Supreme Images', 'dsm-supreme-modules-for-divi' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
					'link'         => esc_html__( 'Link', 'dsm-supreme-modules-for-divi' ),
					'transform'    => esc_html__( 'Transform & Rotation', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced'   => array(
				'toggles' => array(
					'overlay'   => esc_html__( 'Overlay', 'dsm-supreme-modules-for-divi' ),
					'alignment' => esc_html__( 'Alignment', 'dsm-supreme-modules-for-divi' ),
					'width'     => array(
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
			'margin_padding' => array(
				'css' => array(
					'important' => array( 'custom_margin' ),
				),
			),
			'borders'        => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .et_pb_image_wrap',
							'border_styles' => '%%order_class%% .et_pb_image_wrap',
						),
					),
				),
			),
			'box_shadow'     => array(
				'default' => array(
					'css' => array(
						'main'         => '%%order_class%% .et_pb_image_wrap',
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
			'fonts'          => false,
			'text'           => false,
			'button'         => false,
			'link_options'   => false,
		);
	}

	public function get_fields() {
		return array(
			'src'                         => array(
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'dsm-supreme-modules-for-divi' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'dsm-supreme-modules-for-divi' ),
				'update_text'        => esc_attr__( 'Set As Image', 'dsm-supreme-modules-for-divi' ),
				'hide_metadata'      => true,
				'affects'            => array(
					'alt',
					'title_text',
				),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'        => 'main_content',
			),
			'alt'                         => array(
				'label'           => esc_html__( 'Image Alternative Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'on',
				'depends_on'      => array(
					'src',
				),
				'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'dsm-supreme-modules-for-divi' ),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'attributes',
			),
			'title_text'                  => array(
				'label'           => esc_html__( 'Image Title Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'on',
				'depends_on'      => array(
					'src',
				),
				'description'     => esc_html__( 'This defines the HTML Title text.', 'dsm-supreme-modules-for-divi' ),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'attributes',
			),
			'show_in_lightbox'            => array(
				'label'            => esc_html__( 'Open in Lightbox', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'off',
				'affects'          => array(
					'url',
					'url_new_window',
					'use_overlay',
					'show_lightbox_other_img',
				),
				'toggle_slug'      => 'link',
				'description'      => esc_html__( 'Here you can choose whether or not the image should open in Lightbox. Note: if you select to open the image in Lightbox, url options below will be ignored.', 'dsm-supreme-modules-for-divi' ),
			),
			'show_lightbox_other_img'     => array(
				'label'            => esc_html__( 'Use Other Lightbox Image', 'dsm-supreme-modules-pro-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'off',
				'affects'          => array(
					'show_lightbox_other_img_src',
				),
				'toggle_slug'      => 'link',
				'description'      => esc_html__( 'Here you can choose whether you want to have another image should open in Lightbox.', 'dsm-supreme-modules-pro-for-divi' ),
			),
			'show_lightbox_other_img_src' => array(
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an Lightbox image', 'dsm-supreme-modules-for-divi' ),
				'choose_text'        => esc_attr__( 'Choose an Lightbox Image', 'dsm-supreme-modules-for-divi' ),
				'update_text'        => esc_attr__( 'Set As Lightbox Image', 'dsm-supreme-modules-for-divi' ),
				'hide_metadata'      => true,
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'dsm-supreme-modules-pro-for-divi' ),
				'toggle_slug'        => 'link',
			),
			'url'                         => array(
				'label'           => esc_html__( 'Image Link URL', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'off',
				'affects'         => array(
					'use_overlay',
				),
				'description'     => esc_html__( 'If you would like your image to be a link, input your destination URL here. No link will be created if this field is left blank.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'link',
				//'dynamic_content' => 'url',
			),
			'url_new_window'              => array(
				'label'            => esc_html__( 'Image Link Target', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'In The New Tab', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'off',
				'depends_show_if'  => 'off',
				'toggle_slug'      => 'link',
				'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'dsm-supreme-modules-for-divi' ),
			),
			'perspective'                 => array(
				'label'            => esc_html__( 'Perspective', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'toggle_slug'      => 'transform',
				//'mobile_options'  => true,
				'validate_unit'    => true,
				'default'          => '1000px',
				'default_unit'     => 'px',
				'default_on_front' => '1000px',
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '1500',
					'step' => '1',
				),
				//'responsive'      => true,
			),
			'dsm_rotate_y'                => array(
				'label'            => esc_html__( 'Rotate Y', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'toggle_slug'      => 'transform',
				//'mobile_options'  => true,
				'validate_unit'    => true,
				'default'          => '0deg',
				'default_unit'     => 'deg',
				'default_on_front' => '0deg',
				'range_settings'   => array(
					'min'  => '-90',
					'max'  => '90',
					'step' => '1',
				),
				'hover'            => 'tabs',
				//'responsive'      => true,
			),
			'dsm_rotate_x'                => array(
				'label'            => esc_html__( 'Rotate X', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'toggle_slug'      => 'transform',
				//'mobile_options'  => true,
				'validate_unit'    => true,
				'default'          => '0deg',
				'default_unit'     => 'deg',
				'default_on_front' => '0deg',
				'range_settings'   => array(
					'min'  => '-90',
					'max'  => '90',
					'step' => '1',
				),
				'hover'            => 'tabs',
				//'responsive'      => true,
			),
			'dsm_rotate_z'                => array(
				'label'            => esc_html__( 'Rotate Z', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'toggle_slug'      => 'transform',
				//'mobile_options'  => true,
				'validate_unit'    => true,
				'default'          => '0deg',
				'default_unit'     => 'deg',
				'default_on_front' => '0deg',
				'range_settings'   => array(
					'min'  => '-90',
					'max'  => '90',
					'step' => '1',
				),
				'hover'            => 'tabs',
				//'responsive'      => true,
			),
			'use_overlay'                 => array(
				'label'            => esc_html__( 'Image Overlay', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'layout',
				'options'          => array(
					'off' => esc_html__( 'Off', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'On', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'off',
				'affects'          => array(
					'overlay_icon_color',
					'hover_overlay_color',
					'hover_icon',
				),
				'depends_show_if'  => 'on',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'overlay',
				'description'      => esc_html__( 'If enabled, an overlay color and icon will be displayed when a visitors hovers over the image', 'dsm-supreme-modules-for-divi' ),
			),
			'overlay_icon_color'          => array(
				'label'           => esc_html__( 'Overlay Icon Color', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'color-alpha',
				'custom_color'    => true,
				'depends_show_if' => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'overlay',
				'description'     => esc_html__( 'Here you can define a custom color for the overlay icon', 'dsm-supreme-modules-for-divi' ),
			),
			'hover_overlay_color'         => array(
				'label'           => esc_html__( 'Hover Overlay Color', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'color-alpha',
				'custom_color'    => true,
				'depends_show_if' => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'overlay',
				'description'     => esc_html__( 'Here you can define a custom color for the overlay', 'dsm-supreme-modules-for-divi' ),
			),
			'hover_icon'                  => array(
				'label'           => esc_html__( 'Hover Icon Picker', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'select_icon',
				'option_category' => 'configuration',
				'default'         => 'P',
				'class'           => array( 'et-pb-font-icon' ),
				'depends_show_if' => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'overlay',
				'description'     => esc_html__( 'Here you can define a custom icon for the overlay', 'dsm-supreme-modules-for-divi' ),
			),
			'align'                       => array(
				'label'            => esc_html__( 'Image Alignment', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'text_align',
				'option_category'  => 'layout',
				'options'          => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default_on_front' => 'left',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'alignment',
				'description'      => esc_html__( 'Here you can choose the image alignment.', 'dsm-supreme-modules-for-divi' ),
				'options_icon'     => 'module_align',
			),
			'force_fullwidth'             => array(
				'label'            => esc_html__( 'Force Fullwidth', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'layout',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'off',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'width',
				'affects'          => array(
					'max_width',
				),
			),
			'always_center_on_mobile'     => array(
				'label'            => esc_html__( 'Always Center Image On Mobile', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'layout',
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
				),
				'default_on_front' => 'on',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'alignment',
			),
		);
	}

	public function get_alignment() {
		$alignment = isset( $this->props['align'] ) ? $this->props['align'] : '';

		return et_pb_get_alignment( $alignment );
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$src                         = $this->props['src'];
		$alt                         = $this->props['alt'];
		$title_text                  = $this->props['title_text'];
		$url                         = $this->props['url'];
		$url_new_window              = $this->props['url_new_window'];
		$show_in_lightbox            = $this->props['show_in_lightbox'];
		$align                       = $this->get_alignment();
		$force_fullwidth             = $this->props['force_fullwidth'];
		$always_center_on_mobile     = $this->props['always_center_on_mobile'];
		$overlay_icon_color          = $this->props['overlay_icon_color'];
		$hover_overlay_color         = $this->props['hover_overlay_color'];
		$hover_icon                  = $this->props['hover_icon'];
		$use_overlay                 = $this->props['use_overlay'];
		$animation_style             = $this->props['animation_style'];
		$show_lightbox_other_img     = $this->props['show_lightbox_other_img'];
		$show_lightbox_other_img_src = $this->props['show_lightbox_other_img_src'];
		$perspective                 = $this->props['perspective'];
		$dsm_rotate_y                = $this->props['dsm_rotate_y'];
		$dsm_rotate_y_hover          = $this->get_hover_value( 'dsm_rotate_y' );
		$dsm_rotate_y__hover_enabled = et_pb_hover_options()->is_enabled( 'dsm_rotate_y', $this->props );
		$dsm_rotate_x                = $this->props['dsm_rotate_x'];
		$dsm_rotate_x_hover          = $this->get_hover_value( 'dsm_rotate_x' );
		$dsm_rotate_x__hover_enabled = et_pb_hover_options()->is_enabled( 'dsm_rotate_x', $this->props );
		$dsm_rotate_z                = $this->props['dsm_rotate_z'];
		$dsm_rotate_z_hover          = $this->get_hover_value( 'dsm_rotate_z' );
		$dsm_rotate_z__hover_enabled = et_pb_hover_options()->is_enabled( 'dsm_rotate_z', $this->props );

		$hover_transition_duration    = $this->props['hover_transition_duration'];
		$hover_transition_delay       = $this->props['hover_transition_delay'];
		$hover_transition_speed_curve = $this->props['hover_transition_speed_curve'];

		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$wrapper_selector  = '%%order_class%% .dsm-perspective-image-wrapper';
		$image_style_hover = '';

		// Handle svg image behaviour
		$src_pathinfo = pathinfo( $src );
		$is_src_svg   = isset( $src_pathinfo['extension'] ) ? 'svg' === $src_pathinfo['extension'] : false;

		// overlay can be applied only if image has link or if lightbox enabled
		$is_overlay_applied = 'on' === $use_overlay && ( 'on' === $show_in_lightbox || ( 'off' === $show_in_lightbox && '' !== $url ) ) ? 'on' : 'off';

		if ( 'on' === $force_fullwidth ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%%',
					'declaration' => 'max-width: 100% !important;',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .et_pb_image_wrap, %%order_class%% img',
					'declaration' => 'width: 100%;',
				)
			);
		}

		if ( ! $this->_is_field_default( 'align', $align ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%%',
					'declaration' => sprintf(
						'text-align: %1$s;',
						esc_html( $align )
					),
				)
			);
		}

		if ( 'center' !== $align ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%%',
					'declaration' => sprintf(
						'margin-%1$s: 0;',
						esc_html( $align )
					),
				)
			);
		}

		if ( 'on' === $is_overlay_applied ) {
			if ( '' !== $overlay_icon_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .et_overlay:before',
						'declaration' => sprintf(
							'color: %1$s !important;',
							esc_html( $overlay_icon_color )
						),
					)
				);
			}

			if ( '' !== $hover_overlay_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .et_overlay',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $hover_overlay_color )
						),
					)
				);
			}

			$data_icon = '' !== $hover_icon
				? sprintf(
					' data-icon="%1$s"',
					esc_attr( et_pb_process_font_icon( $hover_icon ) )
				)
				: '';

			$overlay_output = sprintf(
				'<span class="et_overlay%1$s"%2$s></span>',
				( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
				$data_icon
			);
		}

		// Set display block for svg image to avoid disappearing svg image
		if ( $is_src_svg ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .et_pb_image_wrap',
					'declaration' => 'display: block;',
				)
			);
		}

		$output = sprintf(
			'<span class="et_pb_image_wrap"><img src="%1$s" alt="%2$s"%3$s />%4$s</span>',
			esc_attr( $src ),
			esc_attr( $alt ),
			( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' ),
			'on' === $is_overlay_applied ? $overlay_output : ''
		);

		if ( 'on' === $show_in_lightbox ) {
			$output = sprintf(
				'<a href="%1$s" class="et_pb_lightbox_image" title="%3$s" data-mfp-src="%4$s">%2$s</a>',
				esc_attr( $src ),
				$output,
				esc_attr( $alt ),
				'on' === $show_lightbox_other_img && '' !== $show_lightbox_other_img_src ? esc_url( $show_lightbox_other_img_src ) : esc_url( $src )
			);
		} elseif ( '' !== $url ) {
			$output = sprintf(
				'<a href="%1$s"%3$s>%2$s</a>',
				esc_url( $url ),
				$output,
				( 'on' === $url_new_window ? ' target="_blank"' : '' )
			);
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dsm-perspective-image-wrapper',
				'declaration' => sprintf(
					'transform: perspective(%1$s) rotateX(%2$s) rotateY(%3$s) rotateZ(%4$s);',
					esc_attr( $perspective ),
					esc_attr( $dsm_rotate_x ),
					esc_attr( $dsm_rotate_y ),
					esc_attr( $dsm_rotate_z )
				),
			)
		);

		if ( et_builder_is_hover_enabled( 'dsm_rotate_y', $this->props ) || et_builder_is_hover_enabled( 'dsm_rotate_x', $this->props ) || et_builder_is_hover_enabled( 'dsm_rotate_z', $this->props ) ) {
			$image_style_hover = sprintf(
				'transform: perspective(%4$s)%1$s%2$s%3$s;',
				( et_builder_is_hover_enabled( 'dsm_rotate_x', $this->props ) ? esc_attr( " rotateX($dsm_rotate_x_hover)" ) : '' ),
				( et_builder_is_hover_enabled( 'dsm_rotate_y', $this->props ) ? esc_attr( " rotateY($dsm_rotate_y_hover)" ) : '' ),
				( et_builder_is_hover_enabled( 'dsm_rotate_z', $this->props ) ? esc_attr( " rotateZ($dsm_rotate_z_hover)" ) : '' ),
				esc_attr( $perspective )
			);
		}

		if ( '' !== $dsm_rotate_y_hover || '' !== $dsm_rotate_x_hover || '' !== $dsm_rotate_z_hover ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $this->add_hover_to_order_class( $wrapper_selector ),
					'declaration' => $image_style_hover,
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm-perspective-image-wrapper',
					'declaration' => sprintf(
						'transition: transform %1$s %3$s %2$s;',
						esc_attr( $hover_transition_duration ),
						esc_attr( $hover_transition_delay ),
						esc_attr( $hover_transition_speed_curve )
					),
				)
			);
		}

		// Module classnames

		$class = 'dsm-perspective-image-wrapper';
		// Module classnames
		if ( ! in_array( $animation_style, array( '', 'none' ) ) ) {
			$this->add_classname( 'et-waypoint' );
		}

		if ( 'on' === $is_overlay_applied ) {
			$class .= ' et_pb_has_overlay';
		}

		if ( 'on' === $always_center_on_mobile ) {
			$class .= ' et_always_center_on_mobile';
		}

		// Render module content
		$output = sprintf(
			'<div%3$s class="%2$s">
				%5$s
				%4$s
				%1$s
			</div>',
			$output,
			esc_attr( $class ),
			$this->module_id(),
			$video_background,
			$parallax_image_background
		);

		return $output;
	}
}

new DSM_Perspective_Image;
