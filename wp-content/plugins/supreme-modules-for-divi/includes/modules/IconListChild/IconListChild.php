<?php

class DSM_Icon_List_Child extends ET_Builder_Module {

	public $slug       = 'dsm_icon_list_child';
	public $vb_support = 'on';
	public $type       = 'child';
	public $child_title_var          = 'title';
	// If the attribute defined on $this->child_title_var is empty, this attribute will be used instead
	public $child_title_fallback_var = 'subtitle';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name = esc_html__( 'Icon List Item', 'dsm-supreme-modules-for-divi' );
		$this->advanced_setting_title_text = esc_html__( 'Icon List Item', 'dsm-supreme-modules-for-divi' );
		$this->settings_text = esc_html__( 'Icon List Settings', 'dsm-supreme-modules-for-divi' );

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'dsm-supreme-modules-for-divi' ),
					'link'         => esc_html__( 'Link', 'dsm-supreme-modules-for-divi' ),
					'icon'        => esc_html__( 'Icon', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'icon_settings' => esc_html__( 'Icon', 'dsm-supreme-modules-for-divi' ),
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
			'fonts'      => array(
				'text' => array(
					'label'    => esc_html__( '', 'dsm-supreme-modules-for-divi' ),
					'css'      => array(
						'main' => '.dsm_icon_list %%order_class%%.dsm_icon_list_child .dsm_icon_list_text, .dsm_icon_list %%order_class%%.dsm_icon_list_child a .dsm_icon_list_text',
						'important' => 'all',
					),
					'font_size' => array(
						'default'      => '14px',
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'hide_header_level' => true,
					'hide_text_align' => true,
					'hide_text_shadow' => false,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'text',
				),
			),
			'text'                  => array(
				'use_text_orientation' => false,
				'use_background_layout' => false,
				'css'              => array(
					'text_shadow' => '.dsm_icon_list %%order_class%% .dsm_icon_list_child',
				),
			),
			'borders'               => array(
				'default' => array(),
				'icon'   => array(
					'css'             => array(
						'main' => array(
							'border_radii' => "%%order_class%% .dsm_icon_list_icon",
							'border_styles' => "%%order_class%% .dsm_icon_list_icon",
						)
					),
					'label_prefix'    => esc_html__( 'Icon', 'dsm-supreme-modules-for-divi' ),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'icon_settings',
				),
			),
			'box_shadow'            => array(
				'default' => array(),
				'icon'   => array(
					'label'               => esc_html__( 'icon Box Shadow', 'dsm-supreme-modules-for-divi' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'icon_settings',
					'css'                 => array(
						'main' => '%%order_class%% .dsm_icon_list_icon',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main' => '.dsm_icon_list %%order_class%%',
					'important' => 'all',
				),
			),
			'button' => false,
			'link_options'          => false,
		);
	}

	public function get_fields() {
		$et_accent_color = et_builder_accent_color();
		return array(
			'text' => array(
				'label'           => esc_html__( 'Text', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
				'default' => 'Icon List Item',
				'default_on_front' => 'Icon List Item',
			),
			'font_icon' => array(
				'label'               => esc_html__( 'Icon', 'et_builder' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'main_content',
				'description'         => esc_html__( 'Choose an icon to display with your text.', 'et_builder' ),
				'depends_show_if'     => 'on',
				'hover'               => 'tabs',
				'default'	=> 'P',
				'default_on_front' => 'P',
			),
			'icon_color' => array(
				'default'           => $et_accent_color,
				'label'             => esc_html__( 'Icon Color', 'dsm-supreme-modules-for-divi' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'dsm-supreme-modules-for-divi' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon_settings',
				'hover'             => 'tabs',
				'mobile_options'    => true,
			),
			'icon_background_color' => array(
				'label'             => esc_html__( 'Icon Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom background color for your icon.', 'dsm-supreme-modules-for-divi' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon_settings',
				'hover'             => 'tabs',
				'mobile_options'    => true,
			),
			'icon_padding' => array(
				'label'           => esc_html__( 'Icon Padding', 'dsm-supreme-modules-for-divi' ),
				'description'     => esc_html__( 'Here you can define a custom padding size for the icon.', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
				'default_unit'    => 'px',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings' => array(
					'min'  => '1',
					'max'  => '30',
					'step' => '1',
				),
				'mobile_options'  => true,
				'responsive'      => true,
				'hover'           => 'tabs',
			),
			'icon_font_size' => array(
				'label'           => esc_html__( 'Icon Font Size', 'et_builder' ),
				'description'     => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
				'default'         => '14px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'  => true,
				'depends_show_if' => 'on',
				'responsive'      => true,
				'hover'           => 'tabs',
			),
			'url' => array(
				'label'           => esc_html__( 'Link URL', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'If you would like to make your Icon List a link, input your destination URL here.', 'et_builder' ),
				'toggle_slug'     => 'link_options',
			),
			'url_new_window' => array(
				'label'           => esc_html__( 'Title Link Target', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'     => 'link_options',
				'description'     => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'default_on_front'=> 'off',
			),
			'text_indent' => array(
				'label'           => esc_html__( 'Text Indent', 'dsm-supreme-modules-for-divi' ),
				'description'     => esc_html__( 'Here you can add padding between the icons and the text.', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'default'         => '5px',
				'default_unit'    => 'px',
				'default_on_front'=> '5px',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options'  => true,
				'responsive'      => true,
				'hover'           => 'tabs',
			),
		);
	}

	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();
		$fields['icon_color'] = array(
			'color' => '%%order_class%%.dsm_icon_list_child .dsm_icon_list_icon',
		);

		$fields['icon_background_color'] = array(
			'background-color' => '%%order_class%%.dsm_icon_list_child .dsm_icon_list_icon',
		);

		$fields['icon_font_size'] = array(
			'font-size' => '%%order_class%%.dsm_icon_list_child .dsm_icon_list_icon',
		);

		$fields['icon_padding'] = array(
			'padding' => '%%order_class%% .dsm_icon_list_child .dsm_icon_list_icon',
		);

		$fields['text_indent'] = array(
			'padding-left' => '%%order_class%%.dsm_icon_list_child .dsm_icon_list_text',
		);

		return $fields;
		
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$text              = $this->props['text'];
		$url                             = $this->props['url'];
		$url_new_window                  = $this->props['url_new_window'];

		$multi_view                      = et_pb_multi_view_options( $this );
		$font_icon                       = $this->props['font_icon'];
		$icon_font_size                  = $this->props['icon_font_size'];
		$icon_font_size_hover            = $this->get_hover_value( 'icon_font_size' );
		$icon_font_size_tablet           = $this->props['icon_font_size_tablet'];
		$icon_font_size_phone            = $this->props['icon_font_size_phone'];
		$icon_font_size_last_edited      = $this->props['icon_font_size_last_edited'];

		$icon_color_hover            = $this->get_hover_value( 'icon_color' );
		$icon_color = $this->props['icon_color'];
		$icon_color_tablet      = $this->props['icon_color_tablet'];
		$icon_color_phone       = $this->props['icon_color_phone'];
		$icon_color_last_edited = $this->props['icon_color_last_edited'];

		$icon_background_color_hover            = $this->get_hover_value( 'icon_background_color' );
		$icon_background_color = $this->props['icon_background_color'];
		$icon_background_color_tablet      = $this->props['icon_background_color_tablet'];
		$icon_background_color_phone       = $this->props['icon_background_color_phone'];
		$icon_background_color_last_edited = $this->props['icon_background_color_last_edited'];

		$icon_padding             = $this->props['icon_padding'];
		$icon_padding_hover       = $this->get_hover_value( 'icon_padding' );
		$icon_padding_values      = et_pb_responsive_options()->get_property_values( $this->props, 'icon_padding' );
		$icon_padding_tablet      = isset( $icon_padding_values['tablet'] ) ? $icon_padding_values['tablet'] : '';
		$icon_padding_phone       = isset( $icon_padding_values['phone'] ) ? $icon_padding_values['phone'] : '';
		$icon_padding_last_edited  = $this->props['icon_padding_last_edited'];

		$text_indent                    = $this->props['text_indent'];
		$text_indent_hover              = $this->get_hover_value( 'text_indent' );
		$text_indent_tablet      = $this->props['text_indent_tablet'];
		$text_indent_phone       = $this->props['text_indent_phone'];
		$text_indent_last_edited = $this->props['text_indent_last_edited'];

		$icon_selector = '.dsm_icon_list .dsm_icon_list_items %%order_class%%.dsm_icon_list_child .dsm_icon_list_icon';
		$text_selector = '.dsm_icon_list .dsm_icon_list_items %%order_class%%.dsm_icon_list_child .dsm_icon_list_icon+.dsm_icon_list_text';

		$font_size_responsive_active = et_pb_get_responsive_status( $icon_font_size_last_edited );

		$font_size_values = array(
			'desktop' => $icon_font_size,
			'tablet'  => $font_size_responsive_active ? $icon_font_size_tablet : '',
			'phone'   => $font_size_responsive_active ? $icon_font_size_phone : '',
		);

		et_pb_generate_responsive_css( $font_size_values, $icon_selector, 'font-size', $render_slug );

		if ( et_builder_is_hover_enabled( 'icon_font_size', $this->props ) ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $this->add_hover_to_order_class( $icon_selector ),
				'declaration' => sprintf(
					'font-size: %1$s;',
					esc_html( $icon_font_size_hover )
				),
			) );
		}

		if ( '' !== $icon_padding ) {
			$icon_padding_responsive_active = et_pb_get_responsive_status( $icon_padding_last_edited );
	 
			$icon_padding_values = array(
				   'desktop' => $icon_padding,
				   'tablet'  => $icon_padding_responsive_active ? $icon_padding_tablet : '',
				   'phone'   => $icon_padding_responsive_active ? $icon_padding_phone : '',
			);
	 
			et_pb_generate_responsive_css( $icon_padding_values, $icon_selector, 'padding', $render_slug );
	 
			if ( et_builder_is_hover_enabled( 'icon_padding', $this->props ) ) {
				   ET_Builder_Element::set_style( $render_slug, array(
						  'selector'    => $this->add_hover_to_order_class( $icon_selector ),
						  'declaration' => sprintf(
								 'padding: %1$s;',
								 esc_html( $icon_padding_hover )
						  ),
				   ) );
			}
		}

		$icon_style        = sprintf( 'color: %1$s;', esc_attr( $icon_color ) );
		$icon_tablet_style = '' !== $icon_color_tablet ? sprintf( 'color: %1$s;', esc_attr( $icon_color_tablet ) ) : '';
		$icon_phone_style  = '' !== $icon_color_phone ? sprintf( 'color: %1$s;', esc_attr( $icon_color_phone ) ) : '';
		$icon_style_hover  = '';

		if ( et_builder_is_hover_enabled( 'icon_color', $this->props ) ) {
			$icon_style_hover = sprintf( 'color: %1$s;', esc_attr( $icon_color_hover ) );
		}

		if ( $icon_color !== et_builder_accent_color() ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $icon_selector,
				'declaration' => $icon_style,
			) );
		}

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => $icon_selector,
			'declaration' => $icon_tablet_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
		) );

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => $icon_selector,
			'declaration' => $icon_phone_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
		) );

		if ( '' !== $icon_style_hover ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $this->add_hover_to_order_class( $icon_selector ),
				'declaration' => $icon_style_hover,
			) );
		}

		$icon_background_style        = sprintf( 'background-color: %1$s;', esc_attr( $icon_background_color ) );
		$icon_background_tablet_style = '' !== $icon_background_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $icon_background_color_tablet ) ) : '';
		$icon_background_phone_style  = '' !== $icon_background_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $icon_background_color_phone ) ) : '';
		$icon_background_style_hover  = '';

		if ( et_builder_is_hover_enabled( 'icon_background_color', $this->props ) ) {
			$icon_background_style_hover = sprintf( 'background-color: %1$s;', esc_attr( $icon_background_color_hover ) );
		}

		if ( '' !== $icon_background_color ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $icon_selector,
				'declaration' => $icon_background_style,
			) );
		}

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => $icon_selector,
			'declaration' => $icon_background_tablet_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
		) );

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => $icon_selector,
			'declaration' => $icon_background_phone_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
		) );

		if ( '' !== $icon_background_style_hover ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $this->add_hover_to_order_class( $icon_selector ),
				'declaration' => $icon_background_style_hover,
			) );
		}

		if ( '5px' !== $text_indent ) {
			$text_indent_responsive_active = et_pb_get_responsive_status( $text_indent_last_edited );
	 
			$text_indent_values = array(
				   'desktop' => $text_indent,
				   'tablet'  => $text_indent_responsive_active ? $text_indent_tablet : '',
				   'phone'   => $text_indent_responsive_active ? $text_indent_phone : '',
			);
	 
			et_pb_generate_responsive_css( $text_indent_values, $text_selector, 'padding-left', $render_slug );
	 
			if ( et_builder_is_hover_enabled( 'text_indent', $this->props ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => $this->add_hover_to_order_class( $text_selector ),
						'declaration' => sprintf(
								'padding-left: %1$s;',
								esc_html( $text_indent_hover )
						),
				) );
			}
		}

		$icon = $multi_view->render_element( array(
			'tag'     => 'span',
			'content' => '{{font_icon}}',
			'attrs'   => array(
				'class' => 'dsm_icon_list_icon',
			),
		) );

		$text = $multi_view->render_element( array(
			'tag'     => 'span',
			'content' => '{{text}}',
			'attrs'   => array(
				'class' => 'dsm_icon_list_text',
			),
		) );

		$content = '';

		if ('' !== $url) {
			$content = sprintf(
				'<a href="%3$s"%4$s>%2$s%1$s</a>',
				et_core_esc_previously( $text ),
				$icon,
				esc_url( $url ),
				'on' === $url_new_window ? ' target="_blank"' : ''
			);
		} else {
			$content = sprintf(
				'%2$s%1$s',
				et_core_esc_previously( $text ),
				$icon
			);
		}

		// Remove automatically added classnames
		$this->remove_classname( array(
			'et_pb_module',
			'et_pb_section_video',
			'et_pb_preload',
			'et_pb_section_parallax',
		) );

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		// Render module content
		$output = sprintf(
			'%1$s',
			$content
		);

		return $output;
	}
	
	/**
	 * Wrap module's rendered output with proper module wrapper. Ensuring module has consistent
	 * wrapper output which compatible with module attribute and background insertion.
	 *
	 * @since 3.1
	 *
	 * @param string $output      Module's rendered output
	 * @param string $render_slug Slug of module that is used for rendering output
	 *
	 * @return string
	*/
	protected function _render_module_wrapper( $output = '', $render_slug = '' ) {
		$wrapper_settings    = $this->get_wrapper_settings( $render_slug );
		$slug                = $render_slug;
		$outer_wrapper_attrs = $wrapper_settings['attrs'];
		$inner_wrapper_attrs = $wrapper_settings['inner_attrs'];

		/**
		 * Filters the HTML attributes for the module's outer wrapper. The dynamic portion of the
		 * filter name, '$slug', corresponds to the module's slug.
		 *
		 * @since 3.23 Add support for responsive video background.
		 * @since 3.1
		 *
		 * @param string[]           $outer_wrapper_attrs
		 * @param ET_Builder_Element $module_instance
		 */
		$outer_wrapper_attrs = apply_filters( "et_builder_module_{$slug}_outer_wrapper_attrs", $outer_wrapper_attrs, $this );

		/**
		 * Filters the HTML attributes for the module's inner wrapper. The dynamic portion of the
		 * filter name, '$slug', corresponds to the module's slug.
		 *
		 * @since 3.1
		 *
		 * @param string[]           $inner_wrapper_attrs
		 * @param ET_Builder_Element $module_instance
		 */
		$inner_wrapper_attrs = apply_filters( "et_builder_module_{$slug}_inner_wrapper_attrs", $inner_wrapper_attrs, $this );

		return sprintf(
			'<li%1$s>
				%2$s
				%3$s
				%6$s
				%7$s
				%5$s
			</li>',
			et_html_attrs( $outer_wrapper_attrs ),
			$wrapper_settings['parallax_background'],
			$wrapper_settings['video_background'],
			et_html_attrs( $inner_wrapper_attrs ),
			$output,
			et_()->array_get( $wrapper_settings, 'video_background_tablet', '' ),
			et_()->array_get( $wrapper_settings, 'video_background_phone', '' )
		);
	}
	/**
	 * Filter multi view value.
	 *
	 * @since 3.27.1
	 * 
	 * @see ET_Builder_Module_Helper_MultiViewOptions::filter_value
	 *
	 * @param mixed $raw_value Props raw value.
	 * @param array $args {
	 *     Context data.
	 *
	 *     @type string $context      Context param: content, attrs, visibility, classes.
	 *     @type string $name         Module options props name.
	 *     @type string $mode         Current data mode: desktop, hover, tablet, phone.
	 *     @type string $attr_key     Attribute key for attrs context data. Example: src, class, etc.
	 *     @type string $attr_sub_key Attribute sub key that availabe when passing attrs value as array such as styes. Example: padding-top, margin-botton, etc.
	 * }
	 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
	 *
	 * @return mixed
	 */
	public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';
		$mode = isset( $args['mode'] ) ? $args['mode'] : '';

		if ( $raw_value && 'font_icon' === $name ) {
			$processed_value = html_entity_decode( et_pb_process_font_icon( $raw_value ) );
			if ( '%%1%%' === $raw_value ) {
				$processed_value = "\"";
			}

			return $processed_value;
		}

		$fields_need_escape = array(
			'button_text',
		);

		if ( $raw_value && in_array( $name, $fields_need_escape, true ) ) {
			return $this->_esc_attr( $multi_view->get_name_by_mode( $name, $mode ) );
		}

		return $raw_value;
	}
}

new DSM_Icon_List_Child;