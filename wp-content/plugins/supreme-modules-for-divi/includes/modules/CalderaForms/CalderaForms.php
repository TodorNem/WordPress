<?php

class DSM_CalderaForms extends ET_Builder_Module {

	public $slug       = 'dsm_caldera_forms';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name             = esc_html__( 'Supreme Caldera Forms', 'dsm-supreme-modules-for-divi' );
		$this->icon_path        = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->main_css_element = '%%order_class%%';
		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Caldera Forms', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'header'                => array(
						'title'             => esc_html__( 'Header Text', 'dsm-supreme-modules-pro-for-divi' ),
						'priority'          => 5,
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'h1' => array(
								'name' => 'H1',
								'icon' => 'text-h1',
							),
							'h2' => array(
								'name' => 'H2',
								'icon' => 'text-h2',
							),
							'h3' => array(
								'name' => 'H3',
								'icon' => 'text-h3',
							),
							'h4' => array(
								'name' => 'H4',
								'icon' => 'text-h4',
							),
							'h5' => array(
								'name' => 'H5',
								'icon' => 'text-h5',
							),
							'h6' => array(
								'name' => 'H6',
								'icon' => 'text-h6',
							),
						),
					),
					'body'                  => array(
						'title'    => esc_html__( 'Body', 'dsm-supreme-modules-for-divi' ),
						'priority' => 5,
					),
					'cf_hr'                 => esc_html__( 'Horizontal Ruler (HR Tag)', 'dsm-supreme-modules-for-divi' ),
					'cf_labels'             => esc_html__( 'Labels', 'dsm-supreme-modules-for-divi' ),
					'cf_description'        => esc_html__( 'Field Description', 'dsm-supreme-modules-for-divi' ),
					'cf_field'              => array(
						'title' => esc_html__( 'Input, Textarea & Select', 'dsm-supreme-modules-for-divi' ),
					),
					'cf_field_focus'        => array(
						'title' => esc_html__( 'Input, Textarea & Select Focus', 'dsm-supreme-modules-for-divi' ),
					),
					'cf_placeholder'        => esc_html__( 'Placeholder', 'dsm-supreme-modules-for-divi' ),
					'cf_radio_checkbox'     => array(
						'title'             => esc_html__( 'Radio & Checkbox', 'dsm-supreme-modules-for-divi' ),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'radio'    => array(
								'name' => 'Radio',
							),
							'checkbox' => array(
								'name' => 'Checkbox',
							),
						),
					),
					'cf_basic_file'         => esc_html__( 'Basic File', 'dsm-supreme-modules-for-divi' ),
					'cf_error'              => esc_html__( 'Error Messages', 'dsm-supreme-modules-for-divi' ),
					'cf_validation_success' => esc_html__( 'Success Message', 'dsm-supreme-modules-for-divi' ),
				),
			),
		);
	}
	public function get_advanced_fields_config() {
		return array(
			'text'       => false,
			'fonts'      => array(
				'header'                      => array(
					'label'       => esc_html__( 'Heading', 'dsm-supreme-modules-pro-for-divi' ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dsm-cf-html h1",
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h1',
				),
				'header_2'                    => array(
					'label'       => esc_html__( 'Heading 2', 'dsm-supreme-modules-pro-for-divi' ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dsm-cf-html h2",
					),
					'font_size'   => array(
						'default' => '26px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h2',
				),
				'header_3'                    => array(
					'label'       => esc_html__( 'Heading 3', 'dsm-supreme-modules-pro-for-divi' ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dsm-cf-html h3",
					),
					'font_size'   => array(
						'default' => '22px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h3',
				),
				'header_4'                    => array(
					'label'       => esc_html__( 'Heading 4', 'dsm-supreme-modules-pro-for-divi' ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dsm-cf-html h4",
					),
					'font_size'   => array(
						'default' => '18px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h4',
				),
				'header_5'                    => array(
					'label'       => esc_html__( 'Heading 5', 'dsm-supreme-modules-pro-for-divi' ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dsm-cf-html h5",
					),
					'font_size'   => array(
						'default' => '16px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h5',
				),
				'header_6'                    => array(
					'label'       => esc_html__( 'Heading 6', 'dsm-supreme-modules-pro-for-divi' ),
					'css'         => array(
						'main' => "{$this->main_css_element} .dsm-cf-html h6",
					),
					'font_size'   => array(
						'default' => '14px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h6',
				),
				'body'                        => array(
					'label'       => esc_html__( 'Body', 'dsm-supreme-modules-for-divi' ),
					'font_size'   => array(
						'default' => '14px',
					),
					'line_height' => array(
						'default' => '1.7em	',
					),
					'css'         => array(
						'main'         => "{$this->main_css_element} .dsm-cf-html p",
						'line_height'  => "{$this->main_css_element} .dsm-cf-html p",
						'limited_main' => "{$this->main_css_element} .dsm-cf-html p",
						'text_shadow'  => "{$this->main_css_element} .dsm-cf-html p",
					),
				),
				'labels'                      => array(
					'label'          => esc_html__( 'Labels', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% .form-group label.control-label',
					),
					'font_size'      => array(
						'default' => '14px',
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'cf_labels',
				),
				'description'                 => array(
					'label'          => esc_html__( 'Description', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% .form-group>div span.help-block',
					),
					'font_size'      => array(
						'default' => '14px',
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'cf_description',
				),
				'input_textarea_select'       => array(
					'label'          => esc_html__( 'Input, Textarea & Select', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), %%order_class%% .form-group textarea, %%order_class%% .form-group select',
					),
					'font_size'      => array(
						'default' => '14px',
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'cf_field',
				),
				'input_textarea_select_focus' => array(
					'label'          => esc_html__( 'Input, Textarea & Select Focus', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, %%order_class%% .form-group textarea:focus',
					),
					'font_size'      => array(
						'default' => '14px',
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'cf_field_focus',
				),
				'placeholder'                 => array(
					'label'          => esc_html__( 'Placeholder', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% .form-group input::placeholder, %%order_class%% .form-group textarea::placeholder, %%order_class%% .form-group input::-webkit-input-placeholder, %%order_class%% .form-group textarea::-webkit-input-placeholder',
					),
					'font_size'      => array(
						'default' => '14px',
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'cf_placeholder',
				),
				'radio'                       => array(
					'label'              => esc_html__( 'Radio', 'dsm-supreme-modules-for-divi' ),
					'css'                => array(
						'main' => '%%order_class%% .radio [data-label]',
					),
					'font_size'          => array(
						'default' => '14px',
					),
					'line_height'        => array(
						'default' => '1em',
					),
					'letter_spacing'     => array(
						'default' => '0px',
					),
					'tab_slug'           => 'advanced',
					'toggle_slug'        => 'cf_radio_checkbox',
					'sub_toggle'         => 'radio',
					'use_text_alignment' => false,
				),
				'checkbox'                    => array(
					'label'              => esc_html__( 'Checkbox', 'dsm-supreme-modules-for-divi' ),
					'css'                => array(
						'main' => '%%order_class%% .checkbox [data-label]',
					),
					'font_size'          => array(
						'default' => '14px',
					),
					'line_height'        => array(
						'default' => '1em',
					),
					'letter_spacing'     => array(
						'default' => '0px',
					),
					'tab_slug'           => 'advanced',
					'toggle_slug'        => 'cf_radio_checkbox',
					'sub_toggle'         => 'checkbox',
					'use_text_alignment' => false,
				),
				'file'                        => array(
					'label'            => esc_html__( 'File', 'dsm-supreme-modules-for-divi' ),
					'css'              => array(
						'main' => '%%order_class%% .file-prevent-overflow',
					),
					'font_size'        => array(
						'default' => '11px',
					),
					'letter_spacing'   => array(
						'default' => '0px',
					),
					'hide_line_height' => true,
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'cf_basic_file',
				),
				'error_msg'                   => array(
					'label'          => esc_html__( 'Error Messages', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% .has-error .help-block.caldera_ajax_error_block',
					),
					'font_size'      => array(
						'default' => '14px',
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'cf_error',
				),
				'success_validation'          => array(
					'label'          => esc_html__( 'Success Message', 'dsm-supreme-modules-for-divi' ),
					'css'            => array(
						'main' => '%%order_class%% .alert.alert-success',
					),
					'font_size'      => array(
						'default' => '14px',
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'cf_validation_success',
				),
			),
			'background' => array(
				'css'     => array(
					'main' => '%%order_class%%',
				),
				'options' => array(
					'parallax_method' => array(
						'default' => 'off',
					),
				),
			),
			'max_width'  => array(
				'css' => array(
					'main' => '%%order_class%%',
				),
			),
			'borders'    => array(
				'default'            => array(),
				'image'              => array(
					'css'             => array(
						'main' => array(
							'border_radii'  => '%%order_class%% input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), %%order_class%% .form-group textarea, %%order_class%% .form-group select',
							'border_styles' => '%%order_class%% input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), %%order_class%% .form-group textarea, %%order_class%% .form-group select',
						),
					),
					'label_prefix'    => esc_html__( 'Field', 'dsm-supreme-modules-for-divi' ),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'cf_field',
					'depends_show_if' => 'off',
				),
				'error_msg'          => array(
					'css'             => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .has-error .help-block.caldera_ajax_error_block',
							'border_styles' => '%%order_class%% .has-error .help-block.caldera_ajax_error_block',
						),
					),
					'label_prefix'    => esc_html__( 'Error Messages', 'dsm-supreme-modules-for-divi' ),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'cf_error',
					'depends_show_if' => 'off',
				),
				'validation_success' => array(
					'css'             => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .alert.alert-success',
							'border_styles' => '%%order_class%% .alert.alert-success',
						),
					),
					'label_prefix'    => esc_html__( 'Validation Success', 'dsm-supreme-modules-for-divi' ),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'cf_validation_success',
					'depends_show_if' => 'off',
				),
			),
			'box_shadow' => array(
				'default'     => array(),
				'input_field' => array(
					'label'             => esc_html__( 'Box Shadow', 'dsm-supreme-modules-for-divi' ),
					'option_category'   => 'layout',
					'tab_slug'          => 'advanced',
					'toggle_slug'       => 'cf_field',
					'depends_show_if'   => 'off',
					'css'               => array(
						'main' => '%%order_class%% input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), %%order_class%% .form-group textarea, %%order_class%% .form-group select',
					),
					'default_on_fronts' => array(
						'color'    => '',
						'position' => '',
					),
				),
			),
			'filters'    => false,
			'button'     => array(
				'button_one'           => array(
					'label'      => esc_html__( 'Submit Button', 'dsm-supreme-modules-for-divi' ),
					'css'        => array(
						'main' => '%%order_class%% .et_pb_button_module_wrapper .et_pb_button',
					),
					'box_shadow' => array(
						'css' => array(
							'main' => '%%order_class%% .et_pb_button_module_wrapper .et_pb_button',
						),
					),
				),
				'button_advanced_file' => array(
					'label'      => esc_html__( 'Advanced File Button (1.0)', 'dsm-supreme-modules-for-divi' ),
					'css'        => array(
						'main' => '%%order_class%% .cf-uploader-trigger',
					),
					'box_shadow' => array(
						'css' => array(
							'main' => '%%order_class%% .cf-uploader-trigger',
						),
					),
				),
			),
		);
	}

	public function get_fields() {
		return array(
			'cf_notice'                           => array(
				'type'       => 'warning',
				'value'      => true,
				'display_if' => true,
				'message'    => esc_html__(
					sprintf(
						'Note: This module will automatically disable Alert Style, Form Styles and Grid Structure on the frontend even your <a href="%s" target="_blank">Caldera Forms General Settings</a> is enabled. This module will not function and render properly without disabling the above.',
						admin_url( 'admin.php?page=caldera-forms' )
					),
					'dsm-supreme-modules-for-divi'
				),
			),
			'cf_library'                          => array(
				'label'           => esc_html__( 'Caldera Form', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => dsm_get_caldera_forms(),
			),
			'show_validation'                     => array(
				'label'           => esc_html__( 'Show Error & Validation Messages', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default'         => 'off',
				'description'     => esc_html__( 'This will show the error and validation messages on the Visual Builder for styling purposes.', 'dsm-supreme-modules-for-divi' ),
			),
			'hr_color'                            => array(
				'label'        => esc_html__( 'Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#666666',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_hr',
			),
			'hr_gap'                              => array(
				'label'           => esc_html__( 'Gap', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'cf_hr',
				'default_unit'    => 'em',
				'default'         => '0.5em',
				'mobile_options'  => true,
				'validate_unit'   => true,
				'responsive'      => true,
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '3',
					'step' => '0.1',
				),
			),
			'label_bottom_spacing'                => array(
				'label'           => esc_html__( 'Bottom Spacing', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'cf_labels',
				'default_unit'    => 'px',
				'default'         => '5px',
			),
			'label_required_asterisk_color'       => array(
				'label'        => esc_html__( 'Required Asterisk Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_labels',
				'default'      => '#ee0000',
			),
			'description_background_color'        => array(
				'label'        => esc_html__( 'Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_description',
			),
			'input_textarea_select_margin_bottom' => array(
				'label'           => esc_html__( 'Margin Bottom', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'cf_field',
				'default_unit'    => 'px',
				'mobile_options'  => true,
				'validate_unit'   => true,
				'responsive'      => true,
				'default'         => '15px',
			),
			'button_alignment'                    => array(
				'label'           => esc_html__( 'Button Alignment', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'         => 'left',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'button_one',
				'description'     => esc_html__( 'Here you can define the alignment of Button', 'dsm-supreme-modules-for-divi' ),
			),
			'button_margin_top'                   => array(
				'label'           => esc_html__( 'Margin Top', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'button_one',
				'default_unit'    => 'px',
				'mobile_options'  => true,
				'validate_unit'   => true,
				'responsive'      => true,
				'default'         => '20px',
			),
			'input_background_color'              => array(
				'label'        => esc_html__( 'Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_field',
			),
			'file_padding'                        => array(
				'label'            => esc_html__( 'Padding', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'custom_padding',
				'option_category'  => 'layout',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'cf_basic_file',
				'validate_unit'    => true,
				'default'          => '',
				'default_unit'     => 'px',
				'default_on_front' => '',
				'mobile_options'   => true,
				'hover'            => 'tabs',
			),
			'file_background_color'               => array(
				'label'        => esc_html__( 'Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_basic_file',
			),
			'error_msg_background_color'          => array(
				'label'        => esc_html__( 'Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_error',
			),
			'validation_success_background_color' => array(
				'label'        => esc_html__( 'Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_validation_success',
			),
			'radio_style'                         => array(
				'label'            => esc_html__( 'Custom Radio Styles', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_'         => 'on',
				'default_on_front' => 'on',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'cf_radio_checkbox',
				'sub_toggle'       => 'radio',
				'description'      => esc_html__( 'Here you can choose to have custom Radio Style.', 'dsm-supreme-modules-for-divi' ),
			),
			'radio_checked_color'                 => array(
				'label'        => esc_html__( 'Checked Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#2ea3f2',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_radio_checkbox',
				'sub_toggle'   => 'radio',
				'show_if'      => array(
					'radio_style' => 'on',
				),
			),
			'radio_checked_background_color'      => array(
				'label'        => esc_html__( 'Checked Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#eeeeee',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_radio_checkbox',
				'sub_toggle'   => 'radio',
				'show_if'      => array(
					'radio_style' => 'on',
				),
			),
			'radio_background_color'              => array(
				'label'        => esc_html__( 'Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#eeeeee',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_radio_checkbox',
				'sub_toggle'   => 'radio',
				'show_if'      => array(
					'radio_style' => 'on',
				),
			),
			'checkbox_style'                      => array(
				'label'            => esc_html__( 'Custom Checbox Styles', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'default_'         => 'on',
				'default_on_front' => 'on',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'cf_radio_checkbox',
				'sub_toggle'       => 'checkbox',
				'description'      => esc_html__( 'Here you can choose to have custom Checkbox Style.', 'dsm-supreme-modules-for-divi' ),
			),
			'checkbox_checked_color'              => array(
				'label'        => esc_html__( 'Checked Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#2ea3f2',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_radio_checkbox',
				'sub_toggle'   => 'checkbox',
				'show_if'      => array(
					'checkbox_style' => 'on',
				),
			),
			'checkbox_checked_background_color'   => array(
				'label'        => esc_html__( 'Checked Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#eeeeee',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_radio_checkbox',
				'sub_toggle'   => 'checkbox',
				'show_if'      => array(
					'checkbox_style' => 'on',
				),
			),
			'checkbox_background_color'           => array(
				'label'        => esc_html__( 'Background Color', 'dsm-supreme-modules-for-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#eeeeee',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'cf_radio_checkbox',
				'sub_toggle'   => 'checkbox',
				'show_if'      => array(
					'checkbox_style' => 'on',
				),
			),
		);
	}

	public function get_button_alignment() {
		$text_orientation = isset( $this->props['button_alignment'] ) ? $this->props['button_alignment'] : '';

		return et_pb_get_alignment( $text_orientation );
	}

	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();

		$fields['file_padding'] = array(
			'padding' => '%%order_class%% .file-prevent-overflow',
		);

		return $fields;
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$cf_library                                 = $this->props['cf_library'];
		$show_validation                            = $this->props['show_validation'];
		$hr_color                                   = $this->props['hr_color'];
		$hr_gap                                     = $this->props['hr_gap'];
		$hr_gap_tablet                              = $this->props['hr_gap_tablet'];
		$hr_gap_phone                               = $this->props['hr_gap_phone'];
		$hr_gap_last_edited                         = $this->props['hr_gap_last_edited'];
		$label_bottom_spacing                       = $this->props['label_bottom_spacing'];
		$label_required_asterisk_color              = $this->props['label_required_asterisk_color'];
		$description_background_color               = $this->props['description_background_color'];
		$input_background_color                     = $this->props['input_background_color'];
		$file_background_color                      = $this->props['file_background_color'];
		$error_msg_background_color                 = $this->props['error_msg_background_color'];
		$validation_success_background_color        = $this->props['validation_success_background_color'];
		$file_padding_hover                         = $this->get_hover_value( 'file_padding' );
		$file_padding                               = $this->props['file_padding'];
		$file_padding_values                        = et_pb_responsive_options()->get_property_values( $this->props, 'file_padding' );
		$file_padding_tablet                        = isset( $file_padding_values['tablet'] ) ? $file_padding_values['tablet'] : '';
		$file_padding_phone                         = isset( $file_padding_values['phone'] ) ? $file_padding_values['phone'] : '';
		$input_textarea_select_margin_bottom        = $this->props['input_textarea_select_margin_bottom'];
		$input_textarea_select_margin_bottom_tablet = $this->props['input_textarea_select_margin_bottom_tablet'];
		$input_textarea_select_margin_bottom_phone  = $this->props['input_textarea_select_margin_bottom_phone'];
		$input_textarea_select_margin_bottom_last_edited = $this->props['input_textarea_select_margin_bottom_last_edited'];
		$custom_icon_1                                   = $this->props['button_one_icon'];
		$button_custom_1                                 = $this->props['custom_button_one'];
		$button_alignment                                = $this->get_button_alignment();
		$button_margin_top                               = $this->props['button_margin_top'];
		$button_margin_top_tablet                        = $this->props['button_margin_top_tablet'];
		$button_margin_top_phone                         = $this->props['button_margin_top_phone'];
		$button_margin_top_last_edited                   = $this->props['button_margin_top_last_edited'];
		$custom_icon_advanced                            = $this->props['button_advanced_file_icon'];
		$button_custom_advanced                          = $this->props['custom_button_advanced_file'];
		$radio_style                                     = $this->props['radio_style'];
		$radio_checked_color                             = $this->props['radio_checked_color'];
		$radio_checked_background_color                  = $this->props['radio_checked_background_color'];
		$radio_background_color                          = $this->props['radio_background_color'];
		$checkbox_style                                  = $this->props['checkbox_style'];
		$checkbox_checked_color                          = $this->props['checkbox_checked_color'];
		$checkbox_checked_background_color               = $this->props['checkbox_checked_background_color'];
		$checkbox_background_color                       = $this->props['checkbox_background_color'];
		$input_textarea_select_text_color                = $this->props['input_textarea_select_text_color'];

		if ( '' !== $input_textarea_select_text_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm-caldera-forms-select:after',
					'declaration' => sprintf(
						'border-color: %1$s transparent transparent;',
						esc_html( $input_textarea_select_text_color )
					),
				)
			);
		}

		if ( '#ee0000' !== $label_required_asterisk_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% label.control-label>span.field_required',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $label_required_asterisk_color )
					),
				)
			);
		}

		if ( '' !== $description_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .form-group>div span.help-block',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $description_background_color )
					),
				)
			);
		}

		if ( '#666666' !== $hr_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dsm-cf-html hr',
					'declaration' => sprintf(
						'border-color: %1$s;',
						esc_html( $hr_color )
					),
				)
			);
		}

		if ( '' !== $hr_gap_tablet || '' !== $hr_gap_phone || '0.5em' !== $hr_gap ) {
			$hr_gap_responsive_active = et_pb_get_responsive_status( $hr_gap_last_edited );

			$hr_gap_values = array(
				'desktop' => $hr_gap,
				'tablet'  => $hr_gap_responsive_active ? $hr_gap_tablet : '',
				'phone'   => $hr_gap_responsive_active ? $hr_gap_phone : '',
			);

			et_pb_generate_responsive_css( $hr_gap_values, '%%order_class%% .dsm-cf-html hr', 'margin-block-start', $render_slug );
			et_pb_generate_responsive_css( $hr_gap_values, '%%order_class%% .dsm-cf-html hr', 'margin-block-end', $render_slug );
		}

		if ( '' !== $input_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% input.text,
				%%order_class%% input.title,
				%%order_class%% input[type=email],
				%%order_class%% input[type=url],
				%%order_class%% input[type=password],
				%%order_class%% input[type=tel],
				%%order_class%% input[type=text],
				%%order_class%% input[type=number],
				%%order_class%% input[type=phone],
				%%order_class%% input[type=date],
				%%order_class%% select.form-control,
				%%order_class%% textarea',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $input_background_color )
					),
				)
			);
		}

		if ( '' !== $file_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .file-prevent-overflow',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $file_background_color )
					),
				)
			);
		}

		if ( '' !== $error_msg_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .has-error .help-block.caldera_ajax_error_block',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $error_msg_background_color )
					),
				)
			);
		}

		if ( '' !== $validation_success_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .alert.alert-success',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $validation_success_background_color )
					),
				)
			);
		}

		if ( '5px' !== $label_bottom_spacing ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% label.control-label',
					'declaration' => sprintf(
						'margin-bottom: %1$s;',
						esc_attr( $label_bottom_spacing )
					),
				)
			);
		}

		if ( 'left' !== $button_alignment ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .et_pb_button_module_wrapper',
					'declaration' => sprintf(
						'text-align: %1$s;',
						esc_attr( $button_alignment )
					),
				)
			);
		}

		if ( 'off' !== $radio_style ) {
			if ( '#2ea3f2' !== $radio_checked_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%%.dsm_cf_custom_radio .dsm-cf-radio:after',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $radio_checked_color )
						),
					)
				);
			}

			if ( '#eeeeee' !== $radio_checked_background_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%%.dsm_cf_custom_radio .dsm-radio input[type=radio]:checked ~ .dsm-cf-radio',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $radio_checked_background_color )
						),
					)
				);
			}

			if ( '#eeeeee' !== $radio_background_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%%.dsm_cf_custom_radio .dsm-radio .dsm-cf-radio',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $radio_background_color )
						),
					)
				);
			}
		}

		if ( 'off' !== $checkbox_style ) {
			if ( '#2ea3f2' !== $checkbox_checked_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%%.dsm_cf_custom_checkbox .dsm-checkbox input[type=checkbox]:checked ~ .dsm-cf-checkbox:after',
						'declaration' => sprintf(
							'color: %1$s;',
							esc_html( $checkbox_checked_color )
						),
					)
				);
			}

			if ( '#eeeeee' !== $checkbox_checked_background_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%%.dsm_cf_custom_checkbox .dsm-checkbox input[type=checkbox]:checked ~ .dsm-cf-checkbox',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $checkbox_checked_background_color )
						),
					)
				);
			}

			if ( '#eeeeee' !== $checkbox_background_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%%.dsm_cf_custom_checkbox .dsm-checkbox .dsm-cf-checkbox',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $checkbox_background_color )
						),
					)
				);
			}
		}

		if ( '' !== $button_margin_top_tablet || '' !== $button_margin_top_phone || '20px' !== $button_margin_top ) {
			$button_margin_top_responsive_active = et_pb_get_responsive_status( $button_margin_top_last_edited );

			$button_margin_top_values = array(
				'desktop' => $button_margin_top,
				'tablet'  => $button_margin_top_responsive_active ? $button_margin_top_tablet : '',
				'phone'   => $button_margin_top_responsive_active ? $button_margin_top_phone : '',
			);

			et_pb_generate_responsive_css( $button_margin_top_values, '%%order_class%% .et_pb_button_module_wrapper', 'margin-top', $render_slug );
		}

		if ( '' !== $input_textarea_select_margin_bottom_tablet || '' !== $input_textarea_select_margin_bottom_phone || '15px' !== $input_textarea_select_margin_bottom ) {
			$input_textarea_select_margin_bottom_responsive_active = et_pb_get_responsive_status( $input_textarea_select_margin_bottom_last_edited );

			$input_textarea_select_margin_bottom_values = array(
				'desktop' => $input_textarea_select_margin_bottom,
				'tablet'  => $input_textarea_select_margin_bottom_responsive_active ? $input_textarea_select_margin_bottom_tablet : '',
				'phone'   => $input_textarea_select_margin_bottom_responsive_active ? $input_textarea_select_margin_bottom_phone : '',
			);

			et_pb_generate_responsive_css( $input_textarea_select_margin_bottom_values, '%%order_class%% .form-group', 'margin-bottom', $render_slug );
		}

		$this->apply_custom_margin_padding(
			$render_slug,
			'file_padding',
			'padding',
			'%%order_class%% .file-prevent-overflow'
		);

		if ( class_exists( 'Caldera_Forms' ) ) {
			add_filter(
				'caldera_forms_render_field_file',
				function( $field_file, $field_type ) {
					if ( 'dropdown' == $field_type ) {
						return dirname( __FILE__ ) . '/includes/dropdown/field.php';
					}
					if ( 'button' == $field_type ) {
						return dirname( __FILE__ ) . '/includes/button/field.php';
					}
					if ( 'radio' == $field_type ) {
						return dirname( __FILE__ ) . '/includes/radio/field.php';
					}
					if ( 'checkbox' == $field_type ) {
						return dirname( __FILE__ ) . '/includes/checkbox/field.php';
					}
					if ( 'html' == $field_type ) {
						return dirname( __FILE__ ) . '/includes/html/field.php';
					}
					if ( 'advanced_file' == $field_type ) {
						return dirname( __FILE__ ) . '/includes/advanced_file/field.php';
					}

					return $field_file;
				},
				10,
				2
			);
			//disable CF styles
			add_filter( 'caldera_forms_get_style_includes', 'dsm_filter_caldera_forms_get_style_includes', 10, 1 );
		}

		// Module classnames
		$this->add_classname(
			array(
				'' !== $description_background_color ? 'dsm_cf_description_label' : '',
				'' !== $error_msg_background_color ? 'dsm_cf_error_label' : '',
				'' !== $validation_success_background_color ? 'dsm_cf_success_label' : '',
				'off' !== $radio_style ? 'dsm_cf_custom_radio' : '',
				'off' !== $checkbox_style ? 'dsm_cf_custom_checkbox' : '',
			)
		);

		$output = sprintf(
			'<div class="%2$s%4$s"%3$s%5$s>
				%1$s
			</div>',
			'' !== $cf_library ? do_shortcode( '[caldera_form id="' . esc_attr( $cf_library ) . '"]' ) : '',
			'' !== $custom_icon_1 ? ' dsm_caldera_forms_btn_icon' : '',
			'' !== $custom_icon_1 ? sprintf(
				' data-dsm-btn-icon="%1$s"',
				esc_attr( et_pb_process_font_icon( $custom_icon_1 ) )
			) : '',
			'' !== $custom_icon_advanced ? ' dsm_caldera_forms_advanced_btn_icon' : '',
			'' !== $custom_icon_advanced ? sprintf(
				' data-dsm-advanced-btn-icon="%1$s"',
				esc_attr( et_pb_process_font_icon( $custom_icon_advanced ) )
			) : ''
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

new DSM_CalderaForms;

function dsm_get_caldera_forms() {
	$options = array();
	if ( class_exists( 'Caldera_Forms' ) ) {
		$dsm_caldera_library_list = Caldera_Forms_Forms::get_forms( true, true );

		if ( ! empty( $dsm_caldera_library_list ) && ! is_wp_error( $dsm_caldera_library_list ) ) {
			$options[0] = esc_html__( 'Select Caldera Form', 'dsm-supreme-modules-for-divi' );
			foreach ( $dsm_caldera_library_list as $form ) {
				$options[ $form['ID'] ] = $form['name'];
			}
		}
	} else {
		$options[0] = esc_html__( 'Please create a Caldera Form', 'dsm-supreme-modules-for-divi' );
	}

	return $options;
}

if ( ! function_exists( 'dsm_filter_caldera_forms_get_style_includes' ) ) :
	function dsm_filter_caldera_forms_get_style_includes( $style_includes ) {
		$style_includes = wp_parse_args(
			array(
				'grid'  => false,
				'alert' => false,
				'form'  => false,
			)
		);

		return $style_includes;
	}
endif;
