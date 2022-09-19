<?php

class DSM_Shapes extends ET_Builder_Module {

	public $slug       = 'dsm_shapes';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name             = esc_html__( 'Supreme Shapes', 'dsm-supreme-modules-for-divi' );
		$this->icon_path        = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->main_css_element = '%%order_class%%.dsm_shapes';

		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Shapes', 'dsm-supreme-modules-for-divi' ),
					'link'         => esc_html__( 'Link', 'dsm-supreme-modules-for-divi' ),
					'image'        => esc_html__( 'Image & Badge', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced'   => array(
				'toggles' => array(
					'shapes_settings' => esc_html__( 'Shapes', 'dsm-supreme-modules-for-divi' ),
					'text'            => array(
						'title'    => esc_html__( 'Text', 'dsm-supreme-modules-for-divi' ),
						'priority' => 49,
					),
					'width'           => array(
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
			'background'     => array(
				'has_background_color_toggle' => true,
				'use_background_color'        => true,
				'css'                         => array(
					"{$this->main_css_element}",
				),
			),
			'margin_padding' => array(
				'css' => array(
					'padding'   => "{$this->main_css_element}",
					'margin'    => "{$this->main_css_element}",
					'important' => 'all',
				),
			),
			'borders'        => array(
				'default' => array(),
				'shapes'  => array(
					'css'             => array(
						'main' => array(
							'border_radii'  => "{$this->main_css_element} .dsm_shapes_wrapper",
							'border_styles' => "{$this->main_css_element} .dsm_shapes_wrapper",
						),
					),
					'label_prefix'    => esc_html__( 'Shapes', 'dsm-supreme-modules-for-divi' ),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'shapes_settings',
					'depends_on'      => array( 'use_shape_border' ),
					'depends_show_if' => 'on',
				),
			),
			'box_shadow'     => array(
				'default' => array(
					'css' => array(
						'main' => "{$this->main_css_element}",
					),
				),
				'shapes'  => array(
					'label'             => esc_html__( 'Shapes Shadow', 'dsm-supreme-modules-for-divi' ),
					'option_category'   => 'layout',
					'tab_slug'          => 'advanced',
					'toggle_slug'       => 'shapes_settings',
					'css'               => array(
						'main' => "{$this->main_css_element} .dsm_shapes_wrapper",
					),
					'default_on_fronts' => array(
						'color'    => '',
						'position' => '',
					),
				),

			),
			'fonts'          => false,
			'text'           => false,
			'text_shadow'    => false,
			'button'         => false,
			'width'          => false,
			'height'         => false,
			'max_width'      => false,
			'filters'        => array(
				'css' => array(
					'main' => array(
						"{$this->main_css_element}",
					),
				),
				/*
				'child_filters_target' => array(
					'tab_slug' => 'advanced',
					'toggle_slug' => 'image_settings',
					'css'                 => array(
						'main'  => "{$this->main_css_element} .dsm_card_image_wrapper",
						'hover' => "{$this->main_css_element}:hover .dsm_card_image_wrapper",
					),
				),*/
			),
		);
	}

	public function get_fields() {
		$et_accent_color = et_builder_accent_color();

		return array(
			'shapes_type'        => array(
				'default'          => 'square',
				'default_on_front' => 'square',
				'label'            => esc_html__( 'Type', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'square'         => esc_html__( 'Square', 'dsm-supreme-modules-for-divi' ),
					'circle'         => esc_html__( 'Circle', 'dsm-supreme-modules-for-divi' ),
					'rectangle'      => esc_html__( 'Rectangle', 'dsm-supreme-modules-for-divi' ),
					'triangle'       => esc_html__( 'Triangle', 'dsm-supreme-modules-for-divi' ),
					'oval'           => esc_html__( 'Oval', 'dsm-supreme-modules-for-divi' ),
					'trapezoid'      => esc_html__( 'Trapezoid', 'dsm-supreme-modules-for-divi' ),
					'parallelogram'  => esc_html__( 'Parallelogram', 'dsm-supreme-modules-for-divi' ),
					'diamond_square' => esc_html__( 'Diamond Square', 'dsm-supreme-modules-for-divi' ),
					'hexagon'        => esc_html__( 'Hexagon', 'dsm-supreme-modules-for-divi' ),
					'blob_one'       => esc_html__( 'Blob #1', 'dsm-supreme-modules-for-divi' ),
					'blob_two'       => esc_html__( 'Blob #2', 'dsm-supreme-modules-for-divi' ),
					'blob_three'     => esc_html__( 'Blob #3', 'dsm-supreme-modules-for-divi' ),
					'blob_four'      => esc_html__( 'Blob #4', 'dsm-supreme-modules-for-divi' ),
					'blob_five'      => esc_html__( 'Blob #5', 'dsm-supreme-modules-for-divi' ),
					'blob_six'       => esc_html__( 'Blob #6', 'dsm-supreme-modules-for-divi' ),
					'blob_seven'     => esc_html__( 'Blob #7', 'dsm-supreme-modules-for-divi' ),
					'blob_eight'     => esc_html__( 'Blob #8', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( '', 'dsm-supreme-modules-for-divi' ),
			),
			'shapes_square_size' => array(
				'label'            => esc_html__( 'Size', 'dsm-supreme-modules-for-divi' ),
				'description'      => esc_html__( 'Adjust size of the Shape.', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'toggle_slug'      => 'main_content',
				'mobile_options'   => true,
				'validate_unit'    => true,
				'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'          => '80',
				'default_unit'     => '',
				'default_on_front' => '80',
				'unitless'         => true,
				'allow_empty'      => false,
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '800',
					'step' => '1',
				),
				'responsive'       => true,
			),
			'shape_color'        => array(
				'label'            => esc_html__( 'Shape Color', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'color-alpha',
				'custom_color'     => true,
				'default'          => $et_accent_color,
				'default_on_front' => $et_accent_color,
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'shapes_settings',
				'description'      => esc_html__( 'Here you can define a custom color for the shapes', 'dsm-supreme-modules-for-divi' ),
			),
			'use_shape_border'   => array(
				'label'            => esc_html__( 'Use Border', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'shapes_settings',
				'affects'          => array(
					'border_radii_shapes',
					'border_styles_shapes',
				),
				'show_if_not'      => array(
					'shapes_type' => 'triangle',
					'shapes_type' => 'hexagon',
					'shapes_type' => 'trapezoid',
				),
				'default'          => 'off',
				'default_on_front' => 'off',
			),
			/*
			'title' => array(
				'label'           => esc_html__( 'Title', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Text entered here will appear as title.', 'dsm-supreme-modules-for-divi' ),
				//'default' => 'Your Title Goes Here',
				'toggle_slug'     => 'main_content',
			),
			'subtitle' => array(
				'label'           => esc_html__( 'Sub Title', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Text entered here will appear as subtitle.', 'dsm-supreme-modules-for-divi' ),
				//'default' => 'Sub Title',
				'toggle_slug'     => 'main_content',
			),

			'content' => array(
				'label'           => esc_html__( 'Content', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'     => 'main_content',
			),
			*/
		);
	}

	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();
		return $fields;

	}

	public function render( $attrs, $content = null, $render_slug ) {
		$multi_view = et_pb_multi_view_options( $this );

		$shapes_type = $this->props['shapes_type'];

		$shapes_square_size        = $this->props['shapes_square_size'];
		$shapes_square_size_values = et_pb_responsive_options()->get_property_values( $this->props, 'shapes_square_size' );
		$shapes_square_size_tablet = isset( $shapes_square_size_values['tablet'] ) ? $shapes_square_size_values['tablet'] : '';
		$shapes_square_size_phone  = isset( $shapes_square_size_values['phone'] ) ? $shapes_square_size_values['phone'] : '';

		$shape_color        = $this->props['shape_color'];
		$shape_color_values = et_pb_responsive_options()->get_property_values( $this->props, 'shape_color' );
		$shape_color_tablet = isset( $shape_color_values['tablet'] ) ? $shape_color_values['tablet'] : '';
		$shape_color_phone  = isset( $shape_color_values['phone'] ) ? $shape_color_values['phone'] : '';

		$use_shape_border = $this->props['use_shape_border'];

		$shape_selector = "{$this->main_css_element} .dsm_shapes_wrapper";

		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		//size
		$shapes_square_size_parent_style        = sprintf( 'height: %1$spx; width: %1$spx;', esc_html( $shapes_square_size ) );
		$shapes_square_size_parent_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'height: %1$spx; width: %1$spx;', esc_html( $shapes_square_size_tablet ) ) : '';
		$shapes_square_size_parent_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'height: %1$spx; width: %1$spx;', esc_html( $shapes_square_size_phone ) ) : '';

		$shapes_square_size_style        = sprintf( 'height: %1$spx; width: %1$spx;', esc_html( $shapes_square_size ) );
		$shapes_square_size_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'height: %1$spx; width: %1$spx;', esc_html( $shapes_square_size_tablet ) ) : '';
		$shapes_square_size_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'height: %1$spx; width: %1$spx;', esc_html( $shapes_square_size_phone ) ) : '';

		if ( $shapes_type === 'square' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} elseif ( $shapes_type === 'circle' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} elseif ( $shapes_type === 'rectangle' ) {
			$shapes_square_size_style        = sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size ), ( esc_html( $shapes_square_size ) / 2 ) );
			$shapes_square_size_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_tablet ), ( esc_html( $shapes_square_size_tablet ) / 2 ) ) : '';
			$shapes_square_size_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_phone ), ( esc_html( $shapes_square_size_phone ) / 2 ) ) : '';

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} elseif ( $shapes_type === 'triangle' ) {
			$shapes_square_size_style        = sprintf( 'width: 0; height: 0; border-left: %2$spx solid transparent; border-right: %2$spx solid transparent; border-bottom-width: %1$spx;', esc_html( $shapes_square_size ), ( esc_html( $shapes_square_size ) / 2 ) );
			$shapes_square_size_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'width: 0; height: 0; border-left: %2$spx solid transparent; border-right: %2$spx solid transparent; border-bottom-width: %1$spx;', esc_html( $shapes_square_size_tablet ), ( esc_html( $shapes_square_size_tablet ) / 2 ) ) : '';
			$shapes_square_size_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'width: 0; height: 0; border-left: %2$spx solid transparent; border-right: %2$spx solid transparent; border-bottom-width: %1$spx;', esc_html( $shapes_square_size_phone ), ( esc_html( $shapes_square_size_phone ) / 2 ) ) : '';

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_parent_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_parent_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_parent_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} elseif ( $shapes_type === 'oval' ) {
			$shapes_square_size_style        = sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size ), ( esc_html( $shapes_square_size ) / 2 ) );
			$shapes_square_size_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_tablet ), ( esc_html( $shapes_square_size_tablet ) / 2 ) ) : '';
			$shapes_square_size_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_phone ), ( esc_html( $shapes_square_size_phone ) / 2 ) ) : '';

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} elseif ( $shapes_type === 'trapezoid' ) {
			$shapes_square_size_style        = sprintf( 'width: %1$spx; height: 0px; border-bottom-width: %3$spx; border-left: %2$spx solid transparent; border-right: %2$spx solid transparent;', esc_html( $shapes_square_size ), ( esc_html( $shapes_square_size ) / 5 ), ( esc_html( $shapes_square_size ) / 5 ) * 2 );
			$shapes_square_size_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'width: %1$spx; height: 0px; border-bottom-width: %3$spx; border-left: %2$spx solid transparent; border-right: %2$spx solid transparent;', esc_html( $shapes_square_size_tablet ), ( esc_html( $shapes_square_size_tablet ) / 5 ), ( esc_html( $shapes_square_size_tablet ) / 5 ) * 2 ) : '';
			$shapes_square_size_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'width: %1$spx; height: 0px; border-bottom-width: %3$spx; border-left: %2$spx solid transparent; border-right: %2$spx solid transparent;', esc_html( $shapes_square_size_phone ), ( esc_html( $shapes_square_size_phone ) / 5 ), ( esc_html( $shapes_square_size_phone ) / 5 ) * 2 ) : '';

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);

			$shapes_square_size_parent_style        = sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size ), ( esc_html( $shapes_square_size ) / 5 ) * 2 );
			$shapes_square_size_parent_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_tablet ), ( esc_html( $shapes_square_size_tablet ) / 5 ) * 2 ) : '';
			$shapes_square_size_parent_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_phone ), ( esc_html( $shapes_square_size_phone ) / 5 ) * 2 ) : '';

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_parent_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_parent_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_parent_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} elseif ( $shapes_type === 'parallelogram' ) {
			$shapes_square_size_style        = sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size ), ( esc_html( $shapes_square_size ) / 2 ) );
			$shapes_square_size_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_tablet ), ( esc_html( $shapes_square_size_tablet ) / 2 ) ) : '';
			$shapes_square_size_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_phone ), ( esc_html( $shapes_square_size_phone ) / 2 ) ) : '';

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} elseif ( $shapes_type === 'diamond_square' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} elseif ( $shapes_type === 'hexagon' ) {
			$shapes_square_size_style        = sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size ), ( esc_html( $shapes_square_size ) / 1.77 ) );
			$shapes_square_size_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_tablet ), ( esc_html( $shapes_square_size_tablet ) / 1.77 ) ) : '';
			$shapes_square_size_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'height: %2$spx; width: %1$spx;', esc_html( $shapes_square_size_phone ), ( esc_html( $shapes_square_size_phone ) / 1.77 ) ) : '';

			$shapes_square_size_before_style        = sprintf( 'border-left: %2$spx solid transparent; border-right: %2$spx solid transparent; border-bottom: %3$spx solid %1$s', esc_attr( $shape_color ), ( esc_html( $shapes_square_size ) / 2 ), ( esc_html( $shapes_square_size ) / 4 ) );
			$shapes_square_size_before_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'border-left: %2$spx solid transparent; border-right: %2$spx solid transparent; border-bottom: %3$spx solid %1$s', esc_attr( $shape_color ), ( esc_html( $shapes_square_size_tablet ) / 2 ), ( esc_html( $shapes_square_size_tablet ) / 4 ) ) : '';
			$shapes_square_size_before_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'border-left: %2$spx solid transparent; border-right: %2$spx solid transparent; border-bottom: %3$spx solid %1$s', esc_attr( $shape_color ), ( esc_html( $shapes_square_size_phone ) / 2 ), ( esc_html( $shapes_square_size_phone ) / 4 ) ) : '';

			$shapes_square_size_after_style        = sprintf( 'border-left: %2$spx solid transparent; border-right: %2$spx solid transparent; border-top: %3$spx solid %1$s', esc_attr( $shape_color ), ( esc_html( $shapes_square_size ) / 2 ), ( esc_html( $shapes_square_size ) / 4 ) );
			$shapes_square_size_after_tablet_style = '' !== $shapes_square_size_tablet ? sprintf( 'border-left: %2$spx solid transparent; border-right: %2$spx solid transparent; border-top: %3$spx solid %1$s', esc_attr( $shape_color ), ( esc_html( $shapes_square_size_tablet ) / 2 ), ( esc_html( $shapes_square_size_tablet ) / 4 ) ) : '';
			$shapes_square_size_after_phone_style  = '' !== $shapes_square_size_phone ? sprintf( 'border-left: %2$spx solid transparent; border-right: %2$spx solid transparent; border-top: %3$spx solid %1$s', esc_attr( $shape_color ), ( esc_html( $shapes_square_size_phone ) / 2 ), ( esc_html( $shapes_square_size_phone ) / 4 ) ) : '';

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => sprintf( 'margin: %1$spx 0;', ( esc_html( $shapes_square_size ) / 4 ) ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => sprintf( 'margin: %1$spx 0;', ( (int) esc_html( $shapes_square_size_tablet ) / 4 ) ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => sprintf( 'margin: %1$spx 0;', ( (int) esc_html( $shapes_square_size_phone ) / 4 ) ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
			//before
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_shapes_wrapper:before',
					'declaration' => $shapes_square_size_before_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_shapes_wrapper:before',
					'declaration' => $shapes_square_size_before_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_shapes_wrapper:before',
					'declaration' => $shapes_square_size_before_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);

			//after
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_shapes_wrapper:after',
					'declaration' => $shapes_square_size_after_style,
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_shapes_wrapper:after',
					'declaration' => $shapes_square_size_after_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm_shapes_wrapper:after',
					'declaration' => $shapes_square_size_after_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} else {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_style,
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $shape_selector,
					'declaration' => $shapes_square_size_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		//color
		$shape_color_style        = '';
		$shape_color_tablet_style = '';
		$shape_color_phone_style  = '';

		if ( $shapes_type === 'square' ) {
			$shape_color_style        = sprintf( 'background-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		} elseif ( $shapes_type === 'circle' ) {
			$shape_color_style        = sprintf( 'background-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		} elseif ( $shapes_type === 'rectangle' ) {
			$shape_color_style        = sprintf( 'background-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		} elseif ( $shapes_type === 'triangle' ) {
			$shape_color_style        = sprintf( 'border-bottom-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'border-bottom-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'border-bottom-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		} elseif ( $shapes_type === 'oval' ) {
			$shape_color_style        = sprintf( 'background-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		} elseif ( $shapes_type === 'trapezoid' ) {
			$shape_color_style        = sprintf( 'border-bottom-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'border-bottom-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'border-bottom-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		} elseif ( $shapes_type === 'parallelogram' ) {
			$shape_color_style        = sprintf( 'background-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		} elseif ( $shapes_type === 'diamond_square' ) {
			$shape_color_style        = sprintf( 'background-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		} elseif ( $shapes_type === 'hexagon' ) {
			$shape_color_style        = sprintf( 'background-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		} else {
			$shape_color_style        = sprintf( 'background-color: %1$s;', esc_attr( $shape_color ) );
			$shape_color_tablet_style = '' !== $shape_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_tablet ) ) : '';
			$shape_color_phone_style  = '' !== $shape_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $shape_color_phone ) ) : '';
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $shape_selector,
				'declaration' => $shape_color_style,
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $shape_selector,
				'declaration' => $shape_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $shape_selector,
				'declaration' => $shape_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			)
		);

		// Remove automatically added classnames
		$this->remove_classname(
			array(
				'et_pb_module',
			)
		);

		// Render module content
		$output = sprintf(
			'%1$s
			%2$s
			<div class="dsm_shapes_wrapper dsm_shapes_%3$s">
			</div>',
			$video_background,
			$parallax_image_background,
			esc_attr( $shapes_type )
		);

		return $output;
	}
	public function apply_custom_margin_padding( $function_name, $slug, $type, $class, $important = false ) {
		$slug_value                   = $this->props[ $slug ];
		$slug_value_tablet            = $this->props[ $slug . '_tablet' ];
		$slug_value_phone             = $this->props[ $slug . '_phone' ];
		$slug_value_last_edited       = $this->props[ $slug . '_last_edited' ];
		$slug_value_responsive_active = et_pb_get_responsive_status( $slug_value_last_edited );

		if ( isset( $slug_value ) && ! empty( $slug_value ) ) {
			ET_Builder_Element::set_style(
				$function_name,
				array(
					'selector'    => $class,
					'declaration' => et_builder_get_element_style_css( $slug_value, $type, $important ),
				)
			);
		}

		if ( isset( $slug_value_tablet ) && ! empty( $slug_value_tablet ) && $slug_value_responsive_active ) {
			ET_Builder_Element::set_style(
				$function_name,
				array(
					'selector'    => $class,
					'declaration' => et_builder_get_element_style_css( $slug_value_tablet, $type, $important ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}

		if ( isset( $slug_value_phone ) && ! empty( $slug_value_phone ) && $slug_value_responsive_active ) {
			ET_Builder_Element::set_style(
				$function_name,
				array(
					'selector'    => $class,
					'declaration' => et_builder_get_element_style_css( $slug_value_phone, $type, $important ),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}
		if ( et_builder_is_hover_enabled( $slug, $this->props ) ) {
			if ( isset( $this->props[ $slug . '__hover' ] ) ) {
				$hover = $this->props[ $slug . '__hover' ];
				ET_Builder_Element::set_style(
					$function_name,
					array(
						'selector'    => $this->add_hover_to_order_class( $class ),
						'declaration' => et_builder_get_element_style_css( $hover, $type, $important ),
					)
				);
			}
		}
	}
}

new DSM_Shapes;
