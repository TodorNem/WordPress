<?php

class DSM_ImageAccordion extends ET_Builder_Module {

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->slug             = 'dsm_image_accordion';
		$this->child_slug       = 'dsm_image_accordion_child';
		$this->vb_support       = 'on';
		$this->name             = esc_html__( 'Supreme Image Accordion', 'dsm-supreme-modules-for-divi' );
		$this->icon_path        = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->main_css_element = '%%order_class%%';
	}

	public function get_settings_modal_toggles() {
		return array(
			'general'  => array(
				'toggles' => array(
					'settings' => esc_html__( 'Accordion Settings', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'overlay'  => esc_html__( 'Overlay', 'dsm-supreme-modules-for-divi' ),
					'ia_icon'  => esc_html__( 'Icon', 'dsm-supreme-modules-for-divi' ),
					'ia_image' => esc_html__( 'Icon Image', 'dsm-supreme-modules-for-divi' ),
					'ia_title' => esc_html__( 'Title', 'dsm-supreme-modules-for-divi' ),
					'ia_desc'  => esc_html__( 'Description', 'dsm-supreme-modules-for-divi' ),
				),
			),
		);
	}

	public function get_fields() {

		$fields = array();

		$fields['image_accordion_type'] = array(
			'label'       => esc_html__( 'Accordion Type', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'select',
			'default'     => 'on_hover',
			'options'     => array(
				'on_hover' => esc_html__( 'By Hover', 'dsm-supreme-modules-for-divi' ),
				'on_click' => esc_html__( 'By Click', 'dsm-supreme-modules-for-divi' ),
			),
			'toggle_slug' => 'settings',
		);

		$fields['image_accordion_animation'] = array(
			'label'       => esc_html__( 'Accordion Content Animation', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'select',
			'default'     => 'fade_in',
			'options'     => array(
				'fade_in'    => esc_html__( 'Fade In', 'dsm-supreme-modules-for-divi' ),
				'zoom_in'    => esc_html__( 'Zoom In', 'dsm-supreme-modules-for-divi' ),
				'push_up'    => esc_html__( 'Push Up', 'dsm-supreme-modules-for-divi' ),
				'push_down'  => esc_html__( 'Push Down', 'dsm-supreme-modules-for-divi' ),
				'push_left'  => esc_html__( 'Push Left', 'dsm-supreme-modules-for-divi' ),
				'push_right' => esc_html__( 'Push Right', 'dsm-supreme-modules-for-divi' ),
			),
			'toggle_slug' => 'settings',
		);

		$fields['image_accordion_animation_sequence'] = array(
			'label'       => esc_html__( 'Use Sequenced Animation', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'yes_no_button',
			'default'     => 'off',
			'options'     => array(
				'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
				'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
			),
			'toggle_slug' => 'settings',
		);

		$fields['ia_direction'] = array(
			'label'          => esc_html__( 'Accordion Direction', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'select',
			'default'        => 'horizontal',
			'mobile_options' => true,
			'options'        => array(
				'horizontal' => esc_html__( 'Horizontal', 'dsm-supreme-modules-for-divi' ),
				'vertical'   => esc_html__( 'Vertical', 'dsm-supreme-modules-for-divi' ),
			),
			'toggle_slug'    => 'settings',
		);

		$fields['ia_height'] = array(
			'label'          => esc_html__( 'Accordion Height', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'range',
			'default'        => '380px',
			'default_unit'   => 'px',
			'range_settings' => array(
				'min'  => '1',
				'max'  => '1200',
				'step' => '10',
			),
			'validate_unit'  => true,
			'mobile_options' => true,
			'toggle_slug'    => 'settings',
		);
		/*
		$fields['anim_speed'] = array(
			'label'          => esc_html__( 'Toggle Animation Speed', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'range',
			'default'        => '300ms',
			'default_unit'   => 'ms',
			'range_settings' => array(
				'min'  => '1',
				'max'  => '2000',
				'step' => '1',
			),
			'toggle_slug'    => 'settings',
		);

		$fields['anim_delay'] = array(
			'label'          => esc_html__( 'Toggle Animation Delay', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'range',
			'default'        => '80ms',
			'default_unit'   => 'ms',
			'range_settings' => array(
				'min'  => '1',
				'max'  => '2000',
				'step' => '1',
			),
			'toggle_slug'    => 'settings',
		);*/

		$fields['ia_icon_color'] = array(
			'label'          => esc_html__( 'Icon Color', 'dsm-supreme-modules-for-divi' ),
			'type'           => 'color-alpha',
			'tab_slug'       => 'advanced',
			'default'        => '#fff',
			'mobile_options' => true,
			'toggle_slug'    => 'ia_icon',
		);

		$fields['use_ia_icon_font_size'] = array(
			'label'       => esc_html__( 'Use Icon Font Size', 'dsm-supreme-modules-for-divi' ),
			'type'        => 'yes_no_button',
			'options'     => array(
				'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
				'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
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

		$advanced_fields['borders']['default'] = array(
			'css' => array(
				'main' => array(
					'border_radii'  => '%%order_class%%',
					'border_styles' => '%%order_class%%',
				),
			),
		);

		$advanced_fields['box_shadow']['default'] = array(
			'css' => array(
				'main' => '%%order_class%%',
			),
		);

		$advanced_fields['borders']['image'] = array(
			'label_prefix' => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
			'css'          => array(
				'main' => array(
					'border_radii'  => '%%order_class%% .dsm-accordion-image',
					'border_styles' => '%%order_class%% .dsm-accordion-image',
				),
			),
			'tab_slug'     => 'advanced',
			'toggle_slug'  => 'ia_image',
		);

		$advanced_fields['box_shadow']['image'] = array(
			'label'       => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
			'css'         => array(
				'main'    => '%%order_class%% .dsm-accordion-image',
				'overlay' => 'inset',
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
		$this->add_classname(
			array(
				"dsm_image_accordion_animation_{$this->props['image_accordion_animation']}",
				"dsm_image_accordion_animation_sequence_{$this->props['image_accordion_animation_sequence']}",
			)
		);
		wp_enqueue_script( 'dsm-image-accordion' );

		return sprintf(
			'<div class="dsm_image_accordion_wrapper dsm_image_accordion_trigger_%2$s">
                %1$s
            </div>',
			et_core_sanitized_previously( $this->content ),
			$this->props['image_accordion_type']
		);
	}

	public function apply_css( $render_slug ) {
		$this->height_css( $render_slug );
		$ia_direction             = $this->props['ia_direction'];
		$ia_direction_tablet      = $this->props['ia_direction_tablet'];
		$ia_direction_phone       = $this->props['ia_direction_phone'];
		$ia_direction_last_edited = $this->props['ia_direction_last_edited'];

		$ia_direction_responsive_status = et_pb_get_responsive_status( $ia_direction_last_edited );

		if ( 'vertical' === $ia_direction ) :

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_wrapper',
					'declaration' => 'flex-direction: column;',
				)
			);

		elseif ( 'horizontal' === $ia_direction ) :

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_wrapper',
					'declaration' => 'flex-direction: row;',
				)
			);

		endif;

		if ( $ia_direction_responsive_status ) {

			if ( 'vertical' === $ia_direction_tablet ) :

				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .dsm_image_accordion_wrapper',
						'declaration' => 'flex-direction: column;',
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);

			elseif ( 'horizontal' === $ia_direction_tablet ) :

				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .dsm_image_accordion_wrapper',
						'declaration' => 'flex-direction: row;',
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);

			endif;

			if ( 'vertical' === $ia_direction_phone ) :

				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .dsm_image_accordion_wrapper',
						'declaration' => 'flex-direction: column;',
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);

			elseif ( 'horizontal' === $ia_direction_phone ) :

				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .dsm_image_accordion_wrapper',
						'declaration' => 'flex-direction: row;',
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);

			endif;

		}

		/*
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dsm_image_accordion_child .dsm_image_accordion_child_content, %%order_class%% .dsm_image_accordion_child.dsm_image_accordion_active_item .dsm_image_accordion_child_content',
				'declaration' => sprintf( 'transition-duration:  %1$s;', $this->props['image_accordion_animation_speed'] ),
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dsm_image_accordion_child',
				'declaration' => sprintf( 'transition-duration: %1$s;', $this->props['anim_speed'] ),
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dsm_image_accordion_child, %%order_class%% .dsm_image_accordion_child.dsm_image_accordion_active_item .dsm_image_accordion_child_content',
				'declaration' => sprintf( 'transition-delay:  %1$s;', $this->props['anim_delay'] ),
			)
		);*/

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

		// Overlay.
		if ( '' !== $this->props['overlay_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_child>div:before',
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
					'selector'    => '%%order_class%% .dsm_image_accordion_child>div:before',
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
					'selector'    => '%%order_class%% .dsm_image_accordion_child>div:before',
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
						'selector'    => '%%order_class%%:hover .dsm_image_accordion_child>div:before',
						'declaration' => sprintf(
							'background: %1$s;',
							$this->props['overlay_color__hover']
						),
					)
				);
			}
		}
	}

	private function height_css( $render_slug ) {
		$ia_height        = $this->props['ia_height'];
		$ia_height_tablet = $this->props['ia_height_tablet'];
		$ia_height_phone  = $this->props['ia_height_phone'];

		$ia_height_last_edited       = $this->props['ia_height_last_edited'];
		$ia_height_responsive_status = et_pb_get_responsive_status( $ia_height_last_edited );

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dsm_image_accordion_wrapper',
				'declaration' => sprintf( 'height: %1$s;', $ia_height ),
			)
		);

		if ( $ia_height_responsive_status ) {

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_wrapper',
					'declaration' => sprintf( 'height: %1$s;', $ia_height_tablet ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_image_accordion_wrapper',
					'declaration' => sprintf( 'height: %1$s;', $ia_height_phone ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}
	}
}

new DSM_ImageAccordion();
