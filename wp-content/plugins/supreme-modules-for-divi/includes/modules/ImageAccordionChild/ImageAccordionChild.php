<?php

class DSM_ImageAccordionChild extends ET_Builder_Module {

	public function init() {
		$this->name            = esc_html__( 'Image Accordion Child', 'dsm-supreme-modules-for-divi' );
		$this->slug            = 'dsm_image_accordion_child';
		$this->vb_support      = 'on';
		$this->type            = 'child';
		$this->child_title_var = 'image_accordion_title';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content' => esc_html__( 'Content', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'overlay'  => esc_html__( 'Overlay', 'dsm-supreme-modules-for-divi' ),
					'ia_icon'  => esc_html__( 'Icon', 'dsm-supreme-modules-for-divi' ),
					'ia_image' => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
					'ia_title' => esc_html__( 'Title', 'dsm-supreme-modules-for-divi' ),
					'ia_desc'  => esc_html__( 'Description', 'dsm-supreme-modules-for-divi' ),
				),
			),
		);
	}

	public function get_fields() {

		$fields = array();

		$fields['expanded_item'] = array(
			'label'       => esc_html__( 'Make Item Expanded', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'yes_no_button',
			'default'     => 'off',
			'options'     => array(
				'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
				'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
			),
			'toggle_slug' => 'content',
		);

		$fields['image_accordion_src'] = array(
			'type'               => 'upload',
			'hide_metadata'      => true,
			'choose_text'        => esc_attr__( 'Choose an Image', 'dsm-supreme-modules-for-divi' ),
			'update_text'        => esc_attr__( 'Set As Image', 'dsm-supreme-modules-for-divi' ),
			'upload_button_text' => esc_attr__( 'Upload an image', 'dsm-supreme-modules-for-divi' ),
			'toggle_slug'        => 'content',
		);

		$fields['use_accordion_icon'] = array(
			'label'       => esc_html__( 'Use Icon', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'yes_no_button',
			'options'     => array(
				'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
				'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
			),
			'toggle_slug' => 'content',
		);

		$fields['image_accordion_icon'] = array(
			'label'       => esc_html__( 'Icon', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'select_icon',
			'class'       => array( 'et-pb-font-icon' ),
			'default'     => '1',
			'show_if'     => array(
				'use_accordion_icon' => 'on',
			),
			'toggle_slug' => 'content',
		);

		$fields['image_accordion_icon_image'] = array(
			'type'               => 'upload',
			'hide_metadata'      => true,
			'choose_text'        => esc_attr__( 'Choose an Image', 'dsm-supreme-modules-for-divi' ),
			'update_text'        => esc_attr__( 'Set As Image', 'dsm-supreme-modules-for-divi' ),
			'upload_button_text' => esc_attr__( 'Upload an image', 'dsm-supreme-modules-for-divi' ),
			'show_if'            => array(
				'use_accordion_icon' => 'off',
			),
			'toggle_slug'        => 'content',
		);

		$fields['image_width'] = array(
			'label'            => esc_html__( 'Image Width', 'dsm-supreme-modules-for-divi' ),
			'type'             => 'range',
			'default'          => '100px',
			'default_unit'     => 'px',
			'default_on_front' => '100px',
			'allowed_units'    => array( 'px' ),
			'range_settings'   => array(
				'min'  => '1',
				'max'  => '1000',
				'step' => '10',
			),
			'show_if'          => array(
				'use_accordion_icon' => 'off',
			),
			'validate_unit'    => true,
			'mobile_options'   => true,
			'tab_slug'         => 'advanced',
			'toggle_slug'      => 'ia_icon',
		);

		$fields['image_accordion_title'] = array(
			'label'           => esc_html__( 'Title', 'dsm-supreme-modules-for-divi' ),
			'type'            => 'text',
			'toggle_slug'     => 'content',
			'dynamic_content' => 'text',
		);

		$fields['image_accordion_desc'] = array(
			'label'           => esc_html__( 'Description', 'dsm-supreme-modules-for-divi' ),
			'type'            => 'textarea',
			'dynamic_content' => 'text',
			'toggle_slug'     => 'content',
		);

		$fields['show_ia_button'] = array(
			'default'     => 'off',
			'label'       => esc_html__( 'Show Button', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'yes_no_button',
			'options'     => array(
				'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
			),
			'toggle_slug' => 'content',
		);

		$fields['ia_button_text'] = array(
			'label'           => esc_html__( 'Button Text', 'dsm-supreme-modules-for-divi' ),
			'type'            => 'text',
			'show_if'         => array(
				'show_ia_button' => 'on',
			),
			'toggle_slug'     => 'content',
			'dynamic_content' => 'text',
		);

		$fields['ia_button_link'] = array(
			'label'           => esc_html__( 'Button Link', 'dsm-supreme-modules-for-divi' ),
			'type'            => 'text',
			'show_if'         => array(
				'show_ia_button' => 'on',
			),
			'toggle_slug'     => 'content',
			'dynamic_content' => 'url',
		);

		$fields['ia_button_link_target'] = array(
			'label'       => esc_html__( 'Link Target', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'select',
			'default'     => 'same',
			'options'     => array(
				'same' => esc_html__( 'Same Window', 'dsm-supreme-modules-for-divi' ),
				'new'  => esc_html__( 'New Window', 'dsm-supreme-modules-for-divi' ),
			),
			'show_if'     => array(
				'show_ia_button' => 'on',
			),
			'toggle_slug' => 'content',
		);

		$fields['ia_align_horizontal'] = array(
			'label'          => esc_html__( 'Horizontal Align', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'select',
			'default'        => 'center',
			'mobile_options' => true,
			'options'        => array(
				'left'   => esc_html__( 'Left', 'dsm-supreme-modules-for-divi' ),
				'center' => esc_html__( 'Center', 'dsm-supreme-modules-for-divi' ),
				'right'  => esc_html__( 'Right', 'dsm-supreme-modules-for-divi' ),
			),
			'toggle_slug'    => 'content',
		);

		$fields['ia_align_vertical'] = array(
			'label'          => esc_html__( 'Vertical Align', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'select',
			'default'        => 'center',
			'mobile_options' => true,
			'options'        => array(
				'top'    => esc_html__( 'Top', 'dsm-supreme-modules-for-divi' ),
				'center' => esc_html__( 'Center', 'dsm-supreme-modules-for-divi' ),
				'bottom' => esc_html__( 'Bottom', 'dsm-supreme-modules-for-divi' ),
			),
			'toggle_slug'    => 'content',
		);

		$fields['ia_icon_color'] = array(
			'label'          => esc_html__( 'Icon Color', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'color-alpha',
			'tab_slug'       => 'advanced',
			'default'        => '#fff',
			'mobile_options' => true,
			'show_if'        => array(
				'use_accordion_icon' => 'on',
			),
			'toggle_slug'    => 'ia_icon',
		);

		$fields['use_ia_icon_font_size'] = array(
			'label'       => esc_html__( 'Use Icon Font Size', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'yes_no_button',
			'options'     => array(
				'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
				'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
			),
			'show_if'     => array(
				'use_accordion_icon' => 'on',
			),
			'tab_slug'    => 'advanced',
			'toggle_slug' => 'ia_icon',
		);

		$fields['ia_icon_font_size'] = array(
			'label'            => esc_html__( 'Icon Font Size', 'dsm-supreme-modules-for-divi' ),
			'type'             => 'range',
			'default'          => '40px',
			'default_unit'     => 'px',
			'default_on_front' => '40px',
			'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
			'show_if'          => array(
				'use_accordion_icon'    => 'on',
				'use_ia_icon_font_size' => 'on',
			),
			'range_settings'   => array(
				'min'  => '1',
				'max'  => '150',
				'step' => '1',
			),
			'validate_unit'    => true,
			'mobile_options'   => true,
			'tab_slug'         => 'advanced',
			'toggle_slug'      => 'ia_icon',
		);

		$fields['content_width'] = array(
			'label'          => esc_html__( 'Content Width', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'range',
			'default'        => '100%',
			'default_unit'   => '%',
			'range_settings' => array(
				'min'  => '1',
				'max'  => '100',
				'step' => '1',
			),
			'validate_unit'  => true,
			'mobile_options' => true,
			'tab_slug'       => 'advanced',
			'toggle_slug'    => 'width',
		);

		$fields['overlay_color'] = array(
			'label'          => esc_html__( 'Overlay Color', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'color-alpha',
			'mobile_options' => true,
			'tab_slug'       => 'advanced',
			'toggle_slug'    => 'overlay',
			'hover'          => 'tabs',
		);

		return $fields;
	}

	public function get_advanced_fields_config() {

		$advanced_fields                = array();
		$advanced_fields['text']        = false;
		$advanced_fields['text_shadow'] = false;
		$advanced_fields['fonts']       = false;

		$advanced_fields['margin_padding'] = array(
			'css' => array(
				'margin'    => '%%order_class%%',
				'padding'   => '%%order_class%%>div',
				'important' => 'all',
			),
		);

		$advanced_fields['borders']['default'] = array(
			'css' => array(
				'main' => array(
					'border_radii'  => '%%order_class%%.dsm_image_accordion_child',
					'border_styles' => '%%order_class%%.dsm_image_accordion_child',
				),
			),
		);

		$advanced_fields['box_shadow']['default'] = array(
			'css' => array(
				'main' => '%%order_class%%',
			),
		);

		$advanced_fields['fonts']['title'] = array(
			'label'           => esc_html__( 'Title', 'dsm-supreme-modules-for-divi' ),
			'css'             => array(
				'main' => '%%order_class%% .dsm_image_accordion_title',
			),
			'hide_text_align' => true,
			'toggle_slug'     => 'ia_title',
			'line_height'     => array(
				'default'        => '1em',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '3',
					'step' => '0.1',
				),
			),
			'header_level'    => array(
				'default' => 'h3',
			),
			'important'       => 'all',
		);

		$advanced_fields['fonts']['desc'] = array(
			'label'           => esc_html__( 'Description', 'dsm-supreme-modules-for-divi' ),
			'css'             => array(
				'main' => '%%order_class%% .dsm_image_accordion_description',
			),
			'hide_text_align' => true,
			'line_height'     => array(
				'default'        => '1em',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '3',
					'step' => '0.1',
				),
			),
			'toggle_slug'     => 'ia_desc',
		);

		$advanced_fields['borders']['image'] = array(
			'label_prefix'    => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
			'css'             => array(
				'main' => array(
					'border_radii'  => '%%order_class%% .dsm_image_accordion_img',
					'border_styles' => '%%order_class%% .dsm_image_accordion_img',
				),
			),
			'depends_on'      => array( 'use_accordion_icon' ),
			'depends_show_if' => 'off',
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'ia_image',
		);

		$advanced_fields['box_shadow']['image'] = array(
			'label'       => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
			'css'         => array(
				'main' => '%%order_class%% .dsm_image_accordion_img',
				''     => 'inset',
			),
			'show_if'     => array(
				'use_accordion_icon' => 'off',
			),
			'tab_slug'    => 'advanced',
			'toggle_slug' => 'ia_image',
		);

		$advanced_fields['button']['button'] = array(
			'label'          => esc_html__( 'Button', 'dsm-supreme-modules-for-divi' ),
			'use_alignment'  => true,
			'css'            => array(
				'main'      => '%%order_class%% .dsm_ia_button.et_pb_button',
				'alignment' => '%%order_class%% .dsm_image_accordion_child_content .et_pb_button_wrapper.dsm_image_accordion_button_wrapper',
				'important' => true,
			),
			'box_shadow'     => array(
				'css' => array(
					'main'      => '%%order_class%% .dsm_ia_button.et_pb_button',
					'important' => true,
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main'      => '%%order_class%% .dsm_ia_button.et_pb_button',
					'important' => 'all',
				),
			),
		);

		return $advanced_fields;
	}

	public function render( $attrs, $content = null, $render_slug ) {

		$this->apply_css( $render_slug );

		$use_accordion_icon         = $this->props['use_accordion_icon'];
		$image_accordion_icon       = et_pb_process_font_icon( $this->props['image_accordion_icon'] );
		$image_accordion_icon_image = $this->props['image_accordion_icon_image'];

		$image_accordion_icon = '' !== $image_accordion_icon ? sprintf(
			'<div class="dsm_image_accordion_image_icon_wrapper">
                <span class="et-pb-icon et-pb-font-icon dsm_image_accordion_icon">
                    %1$s
                </span>
            </div>',
			esc_attr( $image_accordion_icon )
		) : '';

		$image_accordion_icon_image = '' !== $image_accordion_icon_image ? sprintf(
			'<div class="dsm_image_accordion_image_icon_wrapper"><img src="%1$s" class="dsm_image_accordion_img"></div>',
			$image_accordion_icon_image
		) : '';

		$ia_icon = 'on' === $use_accordion_icon ? $image_accordion_icon : $image_accordion_icon_image;

		$ia_title       = $this->_esc_attr( 'image_accordion_title', 'full' );
		$ia_title_level = $this->props['title_level'] ? $this->props['title_level'] : 'h3';

		$ia_title = '' !== $ia_title ? sprintf(
			'<%2$s class="dsm_image_accordion_title">%1$s</%2$s>',
			$ia_title,
			esc_attr( $ia_title_level )
		) : '';

		$ia_description = $this->_esc_attr( 'image_accordion_desc', 'full' );
		$ia_description = '' !== $ia_description ? sprintf(
			'<div class="dsm_image_accordion_description">%1$s</div>',
			$ia_description
		) : '';

		$align_horizontal_tablet = '';
		$align_horizontal_phone  = '';

		$ia_align_horizontal_last_edited       = $this->props['ia_align_horizontal_last_edited'];
		$ia_align_horizontal_responsive_status = et_pb_get_responsive_status( $ia_align_horizontal_last_edited );

		if ( $ia_align_horizontal_responsive_status ) {
			$align_horizontal_tablet = 'dsm_image_accordion_horizontal_tablet_' . $this->props['ia_align_horizontal_phone'];
			$align_horizontal_phone  = 'dsm_image_accordion_horizontal_phone_' . $this->props['ia_align_horizontal_phone'];
		}

		$align_vertical_tablet = '';
		$align_vertical_phone  = '';

		$ia_align_vertical_last_edited       = $this->props['ia_align_vertical_last_edited'];
		$ia_align_vertical_responsive_status = et_pb_get_responsive_status( $ia_align_vertical_last_edited );

		if ( $ia_align_vertical_responsive_status ) {
			$align_vertical_tablet = 'dsm_image_accordion_vertical_tablet_' . $this->props['ia_align_vertical_phone'];
			$align_vertical_phone  = 'dsm_image_accordion_vertical_phone_' . $this->props['ia_align_vertical_phone'];
		}

		$show_ia_button        = $this->props['show_ia_button'];
		$ia_button_text        = $this->props['ia_button_text'];
		$ia_button_link        = $this->props['ia_button_link'];
		$ia_button_link_target = $this->props['ia_button_link_target'];

		$ia_button_rel    = $this->props['button_rel'];
		$ia_button_icon   = $this->props['button_icon'];
		$ia_button_custom = $this->props['custom_button'];

		$ia_button = $this->render_button(
			array(
				'button_classname' => array( 'dsm_ia_button' ),
				'button_custom'    => $ia_button_custom,
				'button_rel'       => $ia_button_rel,
				'button_text'      => $ia_button_text,
				'button_url'       => $ia_button_link,
				'custom_icon'      => $ia_button_icon,
				'url_new_window'   => $ia_button_link_target,
				'has_wrapper'      => false,
			)
		);

		$ia_button = 'on' === $show_ia_button ? sprintf(
			'<div class="et_pb_button_wrapper dsm_image_accordion_button_wrapper">%1$s</div>',
			$ia_button
		) : '';

		$this->add_classname(
			array(
				"dsm_image_accordion_horizontal_{$this->props['ia_align_horizontal']}",
				"dsm_image_accordion_vertical_{$this->props['ia_align_vertical']}",
				'on' === $this->props['expanded_item'] ? 'dsm_image_accordion_active_item' : '',
				$align_horizontal_tablet,
				$align_horizontal_phone,
				$align_vertical_tablet,
				$align_vertical_phone,
			)
		);

		return sprintf(
			'<div class="dsm_image_accordion_child_content">
				%1$s
				%2$s
				%3$s
				%4$s
			</div>',
			$ia_icon,
			$ia_title,
			$ia_description,
			$ia_button
		);
	}

	public function apply_css( $render_slug ) {
		$this->image_width_css( $render_slug );
		$this->content_width_css( $render_slug );

		$use_ia_icon_font_size = $this->props['use_ia_icon_font_size'];

		$ia_icon_color = $this->props['ia_icon_color'];

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dsm_image_accordion_icon',
				'declaration' => "color: {$ia_icon_color};",
			)
		);

		$ia_icon_color_last_edited       = $this->props['ia_icon_color_last_edited'];
		$ia_icon_color_responsive_status = et_pb_get_responsive_status( $ia_icon_color_last_edited );

		if ( $ia_icon_color_responsive_status ) {

			$ia_icon_color_tablet = $this->props['ia_icon_color_tablet'];
			$ia_icon_color_phone  = $this->props['ia_icon_color_phone'];

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_icon',
					'declaration' => "color: {$ia_icon_color_tablet};",
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_icon',
					'declaration' => "color: {$ia_icon_color_phone};",
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		if ( 'on' === $use_ia_icon_font_size ) {
			$ia_icon_font_size        = $this->props['ia_icon_font_size'];
			$ia_icon_font_size_tablet = $this->props['ia_icon_font_size_tablet'];
			$ia_icon_font_size_phone  = $this->props['ia_icon_font_size_phone'];

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_icon',
					'declaration' => "font-size: {$ia_icon_font_size};",
				)
			);

			$ia_icon_font_size_last_edited       = $this->props['ia_icon_font_size_last_edited'];
			$ia_icon_font_size_responsive_status = et_pb_get_responsive_status( $ia_icon_font_size_last_edited );

			if ( $ia_icon_font_size_responsive_status ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .dsm_image_accordion_icon',
						'declaration' => "font-size: {$ia_icon_font_size_tablet};",
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);

				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .dsm_image_accordion_icon',
						'declaration' => "font-size: {$ia_icon_font_size_phone};",
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
			}
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%%',
				'declaration' => "background-image: url({$this->props['image_accordion_src']});",
			)
		);

		if ( '' !== $this->props['overlay_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '.dsm_image_accordion %%order_class%%>div:before',
					'declaration' => sprintf(
						'background: %1$s;',
						$this->props['overlay_color']
					),
				)
			);
		}

		$overlay_color_last_edited       = $this->props['overlay_color_last_edited'];
		$overlay_color_responsive_status = et_pb_get_responsive_status( $overlay_color_last_edited );
		if ( $overlay_color_responsive_status ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '.dsm_image_accordion %%order_class%%>div:before',
					'declaration' => sprintf(
						'background: %1$s;',
						$this->props['overlay_color_tablet']
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '.dsm_image_accordion %%order_class%%>div:before',
					'declaration' => sprintf(
						'background: %1$s;',
						$this->props['overlay_color_phone']
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);

		}

		if ( isset( $this->props['overlay_color__hover'] ) ) {

			$overlay_color_hover = explode( '|', $this->props['overlay_color__hover'] );

			if ( isset( $overlay_color_hover ) ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '.dsm_image_accordion %%order_class%%:hover>div:before',
						'declaration' => sprintf(
							'background: %1$s;',
							$this->props['overlay_color__hover']
						),
					)
				);
			}
		}
	}

	private function image_width_css( $render_slug ) {
		$image_width        = $this->props['image_width'];
		$image_width_tablet = $this->props['image_width_tablet'];
		$image_width_phone  = $this->props['image_width_phone'];

		$image_width_last_edited       = $this->props['image_width_last_edited'];
		$image_width_responsive_status = et_pb_get_responsive_status( $image_width_last_edited );

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dsm_image_accordion_img',
				'declaration' => sprintf( 'width: %1$s;', $image_width ),
			)
		);

		if ( $image_width_responsive_status ) {

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_img',
					'declaration' => sprintf( 'width: %1$s;', $image_width_tablet ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_img',
					'declaration' => sprintf( 'width: %1$s;', $image_width_phone ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);

		}
	}

	private function content_width_css( $render_slug ) {
		$content_width        = $this->props['content_width'];
		$content_width_tablet = $this->props['content_width_tablet'];
		$content_width_phone  = $this->props['content_width_phone'];

		$content_width_last_edited       = $this->props['content_width_last_edited'];
		$content_width_responsive_status = et_pb_get_responsive_status( $content_width_last_edited );

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dsm_image_accordion_child_content',
				'declaration' => sprintf( 'max-width: %1$s;', $content_width ),
			)
		);

		if ( $content_width_responsive_status ) {

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_child_content',
					'declaration' => sprintf( 'max-width: %1$s;', $content_width_tablet ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_child_content',
					'declaration' => sprintf( 'max-width: %1$s;', $content_width_phone ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);

		}
	}

}

new DSM_ImageAccordionChild();
