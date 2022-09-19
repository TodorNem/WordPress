<?php

class DSM_FacebookSimpleFeed extends ET_Builder_Module {

	public $slug       = 'dsm_facebook_feed';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name      = esc_html__( 'Supreme Facebook Feed', 'dsm-supreme-modules-for-divi' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Facebook Feed Settings', 'dsm-supreme-modules-for-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'text'       => false,
			'fonts'      => false,
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
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%%',
							'border_styles' => '%%order_class%%',
						),
					),
				),
			),
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%%',
					),
				),
			),
			'filters'    => false,
		);
	}

	public function get_fields() {
		return array(
			'fb_app_id_notice' => array(
				'type'        => 'warning',
				'value'       => isset( get_option( 'dsm_settings_social_media' )['dsm_facebook_app_id'] ) && '' !== get_option( 'dsm_settings_social_media' )['dsm_facebook_app_id'] ? true : false,
				'display_if'  => false,
				'message'     => et_get_safe_localization( sprintf( __( 'The Facebook APP ID is currently empty in the <a href="%s" target="_blank">Divi Supreme Plugin Page</a>. This module might not function properly without the Facebook APP ID.', 'dsm-supreme-modules-for-divi' ), admin_url( 'admin.php?page=divi_supreme_settings#dsm_settings_social_media' ) ) ),
				'toggle_slug' => 'main_content',
			),
			'fb_app_id'        => array(
				'label'            => esc_html__( 'Facebook APP ID', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'attributes'       => 'readonly',
				'default_on_front' => isset( get_option( 'dsm_settings_social_media' )['dsm_facebook_app_id'] ) && '' !== get_option( 'dsm_settings_social_media' )['dsm_facebook_app_id'] ? get_option( 'dsm_settings_social_media' )['dsm_facebook_app_id'] : '',
				'description'      => et_get_safe_localization( sprintf( __( 'The Facebook module uses the Facebook APP ID and requires a Facebook APP ID to function. Before using all Facebook module, please make sure you have added your Facebook APP ID inside the Divi Supreme Plugin Page. You can go to <a href="%1$s">Facebook Developer</a> and click on Create New App to get one.', 'dsm-supreme-modules-for-divi' ), esc_url( 'https://developers.facebook.com/apps/' ) ) ),
				'toggle_slug'      => 'main_content',
			),
			'fb_page_url'      => array(
				'label'            => esc_html__( 'Facebook Page URL', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Enter the Facebook Page URL.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'      => 'main_content',
				'default_on_front' => 'https://www.facebook.com/divisupreme/',
			),
			'fb_tabs'          => array(
				'label'           => esc_html__( 'Tabs', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'multiple_checkboxes',
				'option_category' => 'configuration',
				'options'         => array(
					'timeline' => esc_html__( 'Timeline', 'dsm-supreme-modules-for-divi' ),
					'events'   => esc_html__( 'Events', 'dsm-supreme-modules-for-divi' ),
					'messages' => esc_html__( 'Messages', 'dsm-supreme-modules-for-divi' ),
				),
				'default'         => 'on|off|off',
				'toggle_slug'     => 'main_content',
				'description'     => esc_html__( 'Here you can choose to show tabs on your facebook page.', 'dsm-supreme-modules-for-divi' ),

			),
			'fb_hide_cover'    => array(
				'label'            => esc_html__( 'Hide Cover Photo', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'false' => esc_html__( 'Show', 'dsm-supreme-modules-for-divi' ),
					'true'  => esc_html__( 'Hide', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Hide cover photo in the header.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'false',
			),
			'fb_small_header'  => array(
				'label'            => esc_html__( 'Use Small Header?', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'false' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'true'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Use the small header instead.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'false',
			),
			'fb_show_facepile' => array(
				'label'            => esc_html__( 'Show Face Pile', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'false' => esc_html__( 'Hide', 'dsm-supreme-modules-for-divi' ),
					'true'  => esc_html__( 'Show', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Show profile photos when friends like this.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'true',
			),
			'fb_width'         => array(
				'label'            => esc_html__( 'Width', 'et_builder' ),
				'type'             => 'range',
				'option_category'  => 'layout',
				'toggle_slug'      => 'main_content',
				'validate_unit'    => true,
				'default'          => '340px',
				'default_unit'     => 'px',
				'default_on_front' => '340px',
				'allow_empty'      => true,
				'range_settings'   => array(
					'min'  => '180',
					'max'  => '500',
					'step' => '1',
				),
				'description'      => esc_html__( 'The pixel width of the Facebook Feed. Min. is 180 & Max. is 500.', 'dsm-supreme-modules-for-divi' ),
			),
			'fb_height'        => array(
				'label'           => esc_html__( 'Height', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'width',
				'default_unit'    => 'px',
				'default'         => '500px',
				'range_settings'  => array(
					'min'  => '300',
					'max'  => '600',
					'step' => '1',
				),
			),
			'fb_alignment'     => array(
				'label'           => esc_html__( 'Alignment', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'alignment',
				'description'     => esc_html__( 'Here you can define the alignment of Facebook Feed', 'dsm-supreme-modules-for-divi' ),
				'default'         => 'center',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$fb_app_id        = $this->props['fb_app_id'];
		$fb_page_url      = $this->props['fb_page_url'];
		$fb_hide_cover    = $this->props['fb_hide_cover'];
		$fb_tabs          = $this->props['fb_tabs'];
		$fb_small_header  = $this->props['fb_small_header'];
		$fb_show_facepile = $this->props['fb_show_facepile'];
		$fb_width         = floatval( $this->props['fb_width'] );
		$fb_height        = floatval( $this->props['fb_height'] );
		$fb_alignment     = $this->props['fb_alignment'];

		$this->add_classname(
			array(
				"et_pb_text_align_{$fb_alignment}",
			)
		);

		if ( ! empty( $fb_tabs ) ) {
			$value_map = array( 'timeline', 'events', 'messages' );
			$fb_tabs   = $this->process_multiple_checkboxes_field_value( $value_map, $fb_tabs );
			$fb_tabs   = str_replace( '|', ',', $fb_tabs );
		} else {
			$fb_tabs = '';
		}

		wp_enqueue_script( 'dsm-facebook' );

		// Render module content
		$output = sprintf(
			'<div class="dsm-facebook-feed">
				<div id="fb-root"></div>
				<div class="fb-page" data-href="%1$s" data-tabs="%7$s" data-width="%6$s" data-height="%5$s" data-small-header="%4$s" data-adapt-container-width="true" data-hide-cover="%2$s" data-show-facepile="%3$s" data-lazy="true">
				</div>
			</div>',
			esc_url( $fb_page_url ),
			esc_attr( $fb_hide_cover ),
			esc_attr( $fb_show_facepile ),
			esc_attr( $fb_small_header ),
			esc_attr( $fb_height ),
			esc_attr( $fb_width ),
			esc_attr( $fb_tabs )
		);

		return $output;
	}
}

new DSM_FacebookSimpleFeed();
