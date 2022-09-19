<?php

class DSM_PriceList extends ET_Builder_Module {

	public $slug       = 'dsm_pricelist';
	public $vb_support = 'on';
	public $child_slug = 'dsm_pricelist_child';

	protected $module_credits = array(
		'module_uri' => 'https://divsupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name      = esc_html__( 'Supreme Price List', 'dsm-supreme-modules-for-divi' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'separator' => array(
						'title'    => esc_html__( 'Separator', 'dsm-supreme-modules-for-divi' ),
						'priority' => 70,
					),
					'image'     => array(
						'title'    => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
						'priority' => 69,
					),
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'      => array(
				'header'  => array(
					'label'             => esc_html__( 'Title', 'dsm-supreme-modules-for-divi' ),
					'css'               => array(
						'main' => '%%order_class%% .dsm-pricelist-title',
					),
					'font_size'         => array(
						'default' => '26px',
					),
					'line_height'       => array(
						'default' => '1em',
					),
					'letter_spacing'    => array(
						'default' => '0px',
					),
					'hide_header_level' => true,
					'hide_text_align'   => true,
				),
				'content' => array(
					'label'           => esc_html__( 'Description', 'dsm-supreme-modules-for-divi' ),
					'css'             => array(
						'main' => '%%order_class%% .dsm-pricelist-description',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'letter_spacing'  => array(
						'default' => '0px',
					),
					'hide_text_align' => true,
				),
				'price'   => array(
					'label'           => esc_html__( 'Price', 'dsm-supreme-modules-for-divi' ),
					'css'             => array(
						'main' => '%%order_class%% .dsm-pricelist-price',
					),
					'font_size'       => array(
						'default' => '18px',
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'letter_spacing'  => array(
						'default' => '0px',
					),
					'hide_text_align' => true,
				),
			),
			'text'       => array(
				'use_text_orientation'  => false,
				'use_background_layout' => false,
				'css'                   => array(
					'text_shadow' => '%%order_class%% .dsm_pricelist_child',
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
				'image'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dsm-pricelist-image img',
							'border_styles' => '%%order_class%% .dsm-pricelist-image img',
						),
					),
					'label_prefix' => esc_html__( 'Image', 'dsm-supreme-modules-for-divi' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'image',
				),
			),
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%%',
					),
				),
				'image'   => array(
					'label'             => esc_html__( 'Image Box Shadow', 'dsm-supreme-modules-for-divi' ),
					'option_category'   => 'layout',
					'tab_slug'          => 'advanced',
					'toggle_slug'       => 'image',
					'css'               => array(
						'main' => '%%order_class%% .dsm-pricelist-image img',
					),
					'default_on_fronts' => array(
						'color'    => '',
						'position' => '',
					),
				),
			),
		);
	}

	public function get_fields() {
		return array(
			'content_orientation' => array(
				'label'           => esc_html__( 'Vertical Alignment', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => array(
					'flex-start' => esc_html__( 'Top', 'dsm-supreme-modules-for-divi' ),
					'center'     => esc_html__( 'Center', 'dsm-supreme-modules-for-divi' ),
					'flex-end'   => esc_html__( 'Bottom', 'dsm-supreme-modules-for-divi' ),
				),
				'default'         => 'flex-start',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'description'     => esc_html__( 'This setting determines the vertical alignment of your content. Your content can either be align to the top, vertically centered, or aligned to the bottom.', 'dsm-supreme-modules-for-divi' ),
			),
			'item_bottom_gap'     => array(
				'label'            => esc_html__( 'Item Bottom Spacing', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default'          => '25px',
				'default_on_front' => '25px',
				'default_unit'     => 'px',
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '60',
					'step' => '1',
				),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'width',
				'mobile_options'   => true,
				'allow_empty'      => true,
				'responsive'       => true,
			),
			'separator_style'     => array(
				'label'           => esc_html__( 'Style', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'default'         => 'dotted',
				'options'         => et_divi_divider_style_choices(),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'separator',
			),
			'separator_weight'    => array(
				'label'            => esc_html__( 'Weight', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default'          => '2px',
				'default_on_front' => '2px',
				'default_unit'     => 'px',
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'separator',
			),
			'separator_color'     => array(
				'default'     => '#333',
				'label'       => esc_html__( 'Color', 'dsm-supreme-modules-for-divi' ),
				'type'        => 'color-alpha',
				'description' => esc_html__( 'Here you can define a custom color for your separator.', 'dsm-supreme-modules-for-divi' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'separator',
			),
			'separator_gap'       => array(
				'label'            => esc_html__( 'Gap Spacing', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default'          => '10px',
				'default_on_front' => '10px',
				'default_unit'     => 'px',
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '40',
					'step' => '1',
				),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'separator',
			),
			'image_max_width'     => array(
				'label'            => esc_html__( 'Image Width', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'image',
				'mobile_options'   => true,
				'validate_unit'    => true,
				'depends_show_if'  => 'off',
				'default'          => '50%',
				'default_unit'     => '%',
				'default_on_front' => '',
				'allow_empty'      => true,
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '50',
					'step' => '1',
				),
				'responsive'       => true,
			),
			'image_spacing'       => array(
				'label'            => esc_html__( 'Image Gap Spacing', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'image',
				'mobile_options'   => true,
				'validate_unit'    => true,
				'default'          => '25px',
				'default_unit'     => 'px',
				'default_on_front' => '',
				'allow_empty'      => true,
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '50',
					'step' => '1',
				),
				'responsive'       => true,
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$separator_style             = $this->props['separator_style'];
		$separator_weight            = $this->props['separator_weight'];
		$separator_color             = $this->props['separator_color'];
		$separator_gap               = $this->props['separator_gap'];
		$item_bottom_gap             = $this->props['item_bottom_gap'];
		$item_bottom_gap_tablet      = $this->props['item_bottom_gap_tablet'];
		$item_bottom_gap_phone       = $this->props['item_bottom_gap_phone'];
		$item_bottom_gap_last_edited = $this->props['item_bottom_gap_last_edited'];
		$content_orientation         = $this->props['content_orientation'];
		$image_max_width             = $this->props['image_max_width'];
		$image_max_width_tablet      = $this->props['image_max_width_tablet'];
		$image_max_width_phone       = $this->props['image_max_width_phone'];
		$image_max_width_last_edited = $this->props['image_max_width_last_edited'];
		$image_spacing               = $this->props['image_spacing'];
		$image_spacing_tablet        = $this->props['image_spacing_tablet'];
		$image_spacing_phone         = $this->props['image_spacing_phone'];
		$image_spacing_last_edited   = $this->props['image_spacing_last_edited'];

		if ( '25px' !== $item_bottom_gap_tablet || '' !== $item_bottom_gap_phone || '' !== $item_bottom_gap ) {
			$item_bottom_gap_responsive_active = et_pb_get_responsive_status( $item_bottom_gap_last_edited );

			$item_bottom_gap_values = array(
				'desktop' => $item_bottom_gap,
				'tablet'  => $item_bottom_gap_responsive_active ? $item_bottom_gap_tablet : '',
				'phone'   => $item_bottom_gap_responsive_active ? $item_bottom_gap_phone : '',
			);

			et_pb_generate_responsive_css( $item_bottom_gap_values, '%%order_class%% .dsm_pricelist_child:not(:last-child)', 'padding-bottom', $render_slug );
		}

		if ( '' !== $image_max_width_tablet || '' !== $image_max_width_phone || '' !== $image_max_width ) {
			$image_max_width_responsive_active = et_pb_get_responsive_status( $image_max_width_last_edited );

			$image_max_width_values = array(
				'desktop' => $image_max_width,
				'tablet'  => $image_max_width_responsive_active ? $image_max_width_tablet : '',
				'phone'   => $image_max_width_responsive_active ? $image_max_width_phone : '',
			);

			et_pb_generate_responsive_css( $image_max_width_values, '%%order_class%% .dsm-pricelist-image', 'max-width', $render_slug );
		}

		if ( '' !== $image_spacing_tablet || '' !== $image_spacing_phone || '' !== $image_spacing ) {
			$image_spacing_responsive_active = et_pb_get_responsive_status( $image_spacing_last_edited );

			$image_spacing_values = array(
				'desktop' => $image_spacing,
				'tablet'  => $image_spacing_responsive_active ? $image_spacing_tablet : '',
				'phone'   => $image_spacing_responsive_active ? $image_spacing_phone : '',
			);

			et_pb_generate_responsive_css( $image_spacing_values, '%%order_class%% .dsm-pricelist-image', 'margin-right', $render_slug );
		}

		if ( 'dotted' !== $separator_style ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm-pricelist-separator',
					'declaration' => sprintf(
						'border-bottom-style: %1$s;',
						esc_attr( $separator_style )
					),
				)
			);
		}

		if ( '2px' !== $separator_weight ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm-pricelist-separator',
					'declaration' => sprintf(
						'border-bottom-width: %1$s;',
						esc_attr( $separator_weight )
					),
				)
			);
		}

		if ( '' !== $separator_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm-pricelist-separator',
					'declaration' => sprintf(
						'border-bottom-color: %1$s;',
						esc_html( $separator_color )
					),
				)
			);
		}

		if ( '10px' !== $separator_gap ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm-pricelist-separator',
					'declaration' => sprintf(
						'margin-left: %1$s; margin-right: %1$s;',
						esc_attr( $separator_gap )
					),
				)
			);
		}

		if ( 'flex-start' !== $content_orientation ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_pricelist_child>div',
					'declaration' => sprintf(
						'align-items: %1$s;',
						esc_attr( $content_orientation )
					),
				)
			);
		}

		// Render module content
		$output = sprintf(
			'<div class="dsm_pricelist">%1$s</div>',
			et_core_sanitized_previously( $this->content )
		);

		return $output;
	}
}

new DSM_PriceList;
