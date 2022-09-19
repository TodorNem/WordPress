<?php

class DSM_FacebookSimpleComments extends ET_Builder_Module {

	public $slug       = 'dsm_facebook_comments';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name      = esc_html__( 'Supreme Facebook Comments', 'dsm-supreme-modules-for-divi' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Facebook Comments Settings', 'dsm-supreme-modules-for-divi' ),
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
			'page_url'         => array(
				'label'            => esc_html__( 'Page URL', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Enter the Page URL.', 'dsm-supreme-modules-for-divi' ),
				'toggle_slug'      => 'main_content',
				'default_on_front' => 'https://www.facebook.com/divisupreme/',
			),
			'num_posts'        => array(
				'label'            => esc_html__( 'Number of Posts', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'The number of comments to show by default. The minimum value is 1.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => '10',
			),
			'color_scheme'     => array(
				'label'            => esc_html__( 'Color Scheme', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'light' => esc_html__( 'Light', 'dsm-supreme-modules-for-divi' ),
					'dark'  => esc_html__( 'Dark', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'The color scheme used by the comments plugin. Can be "light" or "dark".', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'light',
			),
			'order_by'         => array(
				'label'            => esc_html__( 'Order By', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'social'       => esc_html__( 'Social', 'dsm-supreme-modules-for-divi' ),
					'reverse_time' => esc_html__( 'Reverse Time', 'dsm-supreme-modules-for-divi' ),
					'time'         => esc_html__( 'Time', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => sprintf( esc_html__( 'The order to use when displaying comments. Can be "social", "reverse_time", or "time". The different order types are explained <a href="%1$s">in the FAQ</a>' ), 'https://developers.facebook.com/docs/plugins/comments/#faqorder', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'social',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$fb_app_id    = $this->props['fb_app_id'];
		$page_url     = $this->props['page_url'];
		$num_posts    = $this->props['num_posts'];
		$color_scheme = $this->props['color_scheme'];
		$order_by     = $this->props['order_by'];

		wp_enqueue_script( 'dsm-facebook' );

		// Render module content
		$output = sprintf(
			'<div class="dsm-facebook-comments">
				<div id="fb-root"></div>
				<div class="fb-comments" data-href="%1$s" data-colorscheme="%3$s" data-numposts="%2$s" data-order-by="%4$s" width="100%%" data-lazy="true"></div>
			</div>',
			esc_url( $page_url ),
			esc_attr( $num_posts ),
			esc_attr( $color_scheme ),
			esc_attr( $order_by )
		);

		return $output;
	}
}

new DSM_FacebookSimpleComments();
