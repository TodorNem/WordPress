<?php

class DSM_TwitterEmbeddedTimeline extends ET_Builder_Module {

	public $slug       = 'dsm_embed_twitter_timeline';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://divisupreme.com/',
		'author'     => 'Divi Supreme',
		'author_uri' => 'https://divisupreme.com/',
	);

	public function init() {
		$this->name      = esc_html__( 'Supreme Embed Twitter Timeline ', 'dsm-supreme-modules-for-divi' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		// Toggle settings
		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Twitter Timeline Settings', 'dsm-supreme-modules-for-divi' ),
				),
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
		);
	}

	public function get_fields() {
		return array(
			'twitter_username'  => array(
				'label'            => esc_html__( 'Twitter Username', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'default_on_front' => 'TwitterDev',
				'description'      => esc_html__( 'Enter the Twitter Username without the hashtag @', 'dsm-supreme-modules-for-divi' ),
			),
			'limit_tweet'       => array(
				'label'            => esc_html__( 'Limit Tweets', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Limiting the number of Tweets displayed.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
			),
			'tweet_number'      => array(
				'label'           => esc_html__( 'Number of Tweets', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'main_content',
				'validate_unit'   => false,
				'unitless'        => true,
				'default'         => '3',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '20',
					'step' => '1',
				),
				'show_if'         => array(
					'limit_tweet' => 'on',
				),
			),
			'theme'             => array(
				'label'            => esc_html__( 'Theme', 'et_builder' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'light' => esc_html__( 'Light', 'et_builder' ),
					'dark'  => esc_html__( 'Dark', 'et_builder' ),
				),
				'default_on_front' => 'Dark',
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Here you can choose whether the Twitter Widget will appear in light or dark theme.', 'et_builder' ),
			),
			/*
			'link_color' => array(
				'label'             => esc_html__( 'Link Color', 'et_builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'toggle_slug'     => 'main_content',
				'default_on_front' => '#1b95e0',
			),
			*/
			'header'            => array(
				'label'            => esc_html__( 'Show Header', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Hides the timeline header. Implementing sites must add their own Twitter attribution, link to the source timeline, and comply with other Twitter display requirements.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'on',
			),
			'footer'            => array(
				'label'            => esc_html__( 'Show Footer', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Hides the timeline footer and Tweet composer link, if included in the timeline widget type.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'on',
			),
			'borders'           => array(
				'label'            => esc_html__( 'Show Border', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Removes all borders within the widget including borders surrounding the widget area and separating Tweets.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'on',
			),
			'scrollbar'         => array(
				'label'            => esc_html__( 'Show Scrollbar', 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Crops and hides the main timeline scrollbar, if visible. Please consider that hiding standard user interface components can affect the accessibility of your website.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'on',
			),
			'remove_background' => array(
				'label'            => esc_html__( "Remove Widget's Background color", 'dsm-supreme-modules-for-divi' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'dsm-supreme-modules-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dsm-supreme-modules-for-divi' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Removes the widget’s background color.', 'dsm-supreme-modules-for-divi' ),
				'default_on_front' => 'off',
			),
			'height'            => array(
				'label'           => esc_html__( 'Height', 'dsm-supreme-modules-for-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'width',
				'default_unit'    => '',
				'default'         => '800px',
				'range_settings'  => array(
					'min'  => '200',
					'max'  => '1000',
					'step' => '1',
				),
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$twitter_username = $this->props['twitter_username'];
		$limit_tweet      = $this->props['limit_tweet'];
		$tweet_number     = floatval( $this->props['tweet_number'] );
		$theme            = $this->props['theme'];
		$header           = $this->props['header'];
		$footer           = $this->props['footer'];
		$borders          = $this->props['borders'];
		$scrollbar        = $this->props['scrollbar'];
		$height           = floatval( $this->props['height'] );
		//$link_color = $this->props['link_color'];
		$remove_background = $this->props['remove_background'];

		wp_enqueue_script( 'dsm-twitter-embed' );

		// Render module content
		$output = sprintf(
			'<div class="dsm-twitter-timeline">
				<a class="twitter-timeline" data-height="%9$s" data-theme="%8$s" href="https://twitter.com/%1$s" data-chrome="%2$s%3$s%4$s%5$s%6$s"%7$s>Tweets by @%1$s</a>
			</div>',
			esc_attr( $twitter_username ),
			'on' !== $header ? 'noheader' : '',
			'on' !== $footer ? ' nofooter' : '',
			'on' !== $borders ? ' noborders' : '',
			'on' !== $scrollbar ? ' noscrollbar' : '',
			'off' !== $remove_background ? ' transparent' : '',
			'off' !== $limit_tweet ? esc_attr( " data-tweet-limit={$tweet_number}" ) : '',
			esc_attr( $theme ),
			esc_attr( $height )
		);

		return $output;
	}

}

new DSM_TwitterEmbeddedTimeline;
