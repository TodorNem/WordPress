<?php

class DSM_TypingEffect extends ET_Builder_Module {

	public $slug       = 'dsm_typing_effect';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);


	public function init() {
		$this->name      = esc_html__( 'Supreme Typing', 'dsm-supreme-modules-for-divi' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content'  => esc_html__( 'Text', 'dsm-supreme-modules-for-divi' ),
					'typing_option' => esc_html__( 'Typing Options', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'typing_styles' => array(
						'title'    => esc_html__( 'Typing Styles', 'dsm-supreme-modules-pro-for-divi' ),
						'priority' => 56,
					),
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'          => array(
				'header' => array(
					'label'          => esc_html__( 'Main', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main'       => '%%order_class%% h1.et_pb_module_header, %%order_class%% h2.et_pb_module_header, %%order_class%% h3.et_pb_module_header, %%order_class%% h4.et_pb_module_header, %%order_class%% h5.et_pb_module_header, %%order_class%% h6.et_pb_module_header',
						'text_align' => '%%order_class%%',
					),
					'font_size'      => array(
						'default' => '30px',
					),
					'line_height'    => array(
						'default' => '1em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'header_level'   => array(
						'default' => 'h1',
					),
				),
			),
			'text'           => array(
				'use_text_orientation'  => false,
				'use_background_layout' => true,
				'css'                   => array(
					'text_shadow' => '%%order_class%%',
				),
				'options'               => array(
					'background_layout' => array(
						'default' => 'light',
					),
				),
				'toggle_slug'           => 'header',
			),
			'text_shadow'    => array(
				// Don't add text-shadow fields since they already are via font-options.
				'default' => false,
			),
			'margin_padding' => array(
				'css' => array(
					'main'      => "{$this->main_css_element}",
					'important' => 'all',
				),
			),
			'borders'        => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%%',
							'border_styles' => '%%order_class%%',
						),
					),
				),
			),
			'box_shadow'     => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%%',
					),
				),
			),
		);
	}

	public function get_fields() {
		return array(
			'typing_effect'       => array(
				'label'            => esc_html__( 'Typing Effect Text', 'dsm-supreme-modules-pro-for-divi' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'The title of your Typing Effect Text. Use "|" as a separator. eg Word One|Text Two|Divi 3', 'dsm-supreme-modules-pro-for-divi' ),
				'default_on_front' => 'Design Divi sites with|Divi|Supreme',
				'toggle_slug'      => 'main_content',
			),
			'typing_loop'         => array(
				'label'            => esc_html__( 'Use Loop', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'default'          => 'on',
				'default_on_front' => 'on',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'description'      => esc_html__( 'If enabled, typing effect will loop infinite.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'      => 'typing_option',
			),
			'typing_speed'        => array(
				'label'            => esc_html__( 'Typing Speed (in ms)', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default'          => '100ms',
				'default_on_front' => '100ms',
				'default_unit'     => 'ms',
				'range_settings'   => array(
					'min'  => '10',
					'max'  => '3000',
					'step' => '1',
				),
				'toggle_slug'      => 'typing_option',
			),
			'typing_backspeed'    => array(
				'label'            => esc_html__( 'Typing Backspeed (in ms)', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default'          => '50ms',
				'default_on_front' => '50ms',
				'default_unit'     => 'ms',
				'range_settings'   => array(
					'min'  => '1',
					'max'  => '300',
					'step' => '1',
				),
				'toggle_slug'      => 'typing_option',
			),
			'typing_backdelay'    => array(
				'label'            => esc_html__( 'Back delay (in ms)', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'default'          => '700ms',
				'default_on_front' => '700ms',
				'range_settings'   => array(
					'min'  => '200',
					'max'  => '2000',
					'step' => '100',
				),
				'description'      => esc_html__( 'Time before backspacing', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'      => 'typing_option',
			),
			'typing_cursor_color' => array(
				'label'        => esc_html__( 'Cursor Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'typing_styles',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$typing_effect       = $this->props['typing_effect'];
		$typing_loop         = $this->props['typing_loop'];
		$typing_speed        = $this->props['typing_speed'];
		$typing_backspeed    = $this->props['typing_backspeed'];
		$typing_backdelay    = $this->props['typing_backdelay'];
		$typing_cursor_color = $this->props['typing_cursor_color'];
		$background_layout   = $this->props['background_layout'];
		$header_level        = $this->props['header_level'];

		if ( '' !== $typing_effect ) {
			$typing_effect = sprintf(
				'<%1$s class="dsm-typing-effect et_pb_module_header"><span class="dsm-typing" data-dsm-typing-strings="%2$s"%3$s%4$s></span></%1$s>',
				et_pb_process_header_level( $header_level, 'h1' ),
				htmlspecialchars( $typing_effect, ENT_QUOTES ),
				esc_attr( " data-dsm-typing-speed={$typing_speed} data-dsm-typing-backspeed={$typing_backspeed} data-dsm-typing-backdelay={$typing_backdelay}" ),
				( 'off' !== $typing_loop ? esc_attr( ' data-dsm-typing-loop=true' ) : esc_attr( ' data-dsm-typing-loop=false' ) )
			);
		}

		if ( '' !== $typing_cursor_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm-typing-effect .typed-cursor',
					'declaration' => sprintf(
						'color: %1$s;',
						esc_html( $typing_cursor_color )
					),
				)
			);
		}

		$this->add_classname(
			array(
				"et_pb_bg_layout_{$background_layout}",
				$this->get_text_orientation_classname(),
			)
		);

		wp_enqueue_script( 'dsm-typed' );

		// Render module content
		$output = sprintf(
			'%1$s',
			$typing_effect
		);

		return $output;
	}
}

new DSM_TypingEffect;
