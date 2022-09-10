<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_Admin_Menu {
    
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'uacf7_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'uacf7_page_init' ) );
	}

    /*
    * Admin menu
    */
	public function uacf7_add_plugin_page() {
		add_submenu_page(
            'wpcf7', //parent slug
			__('Ultimate Addons','ultimate-addons-cf7'), // page_title
			__('Ultimate Addons','ultimate-addons-cf7'), // menu_title
			'manage_options', // capability
			'ultimate-addons', // menu_slug
			array( $this, 'uacf7_create_admin_page' ) // function
		);
	}

    /*
    * Admin settings page
    */
	public function uacf7_create_admin_page() {
        ?>
		<div class="wrap uacf7-admin-cont">
			<h1><?php echo esc_html__( 'Ultimate Addons for Contact Form 7 (UACF7) Settings', 'ultimate-addons-cf7' ); ?></h1>
			<p class="sub-head"><?php echo esc_html__( 'Tick the addons you need from the below settings Panel and click Save. Those addons will be activated. Then go to the Contact Form 7 settings Panel and start editing.', 'ultimate-addons-cf7' ); ?></p>
			<?php settings_errors(); ?>

            <!--Settings tab start-->
            
            <!--Tab buttons start-->
			<div class="uacf7-tab">
              <a class="tablinks active" onclick="uacf7_settings_tab(event, 'uacf7_addons')">Addons Settings</a>
              
			  <?php do_action('uacf7_admin_tab_button'); ?>
			 
			  <a class="tablinks" onclick="uacf7_settings_tab(event, 'uacf7_doc')">Documentation</a>
              
            </div>
            <!--Tab buttons end-->

            <!--Tab Addons start-->
            <div id="uacf7_addons" class="uacf7-tabcontent" style="display:block">
                <form method="post" action="options.php">
                    <?php
                        settings_fields( 'uacf7_option_group' );
                        do_settings_sections( 'ultimate-addons-admin' );
                        submit_button();
                    ?>
                </form>
            </div>
            <!--Tab Addons end-->
            
			<?php do_action('uacf7_admin_tab_content'); ?>

            <div id="uacf7_doc" class="uacf7-tabcontent uacf7-docs">
			<?php
				include_once( plugin_dir_path( __FILE__ ) . 'admin-docs.html');
				?>
            </div>
            
            <!--Settings tab end-->
			
		</div>
	    <?php 
    }

    /*
    * Admin settings fields
    */
	public function uacf7_page_init() {
		//Addons Settings
		register_setting(
			'uacf7_option_group', // option_group
			'uacf7_option_name', // option_name
			array( $this, 'uacf7_sanitize' ) // sanitize_callback
		);
		
		//Mailchimp Settings
		register_setting(
			'uacf7_mailchimp_option', // option_group
			'uacf7_mailchimp_option_name', // option_name
			array( $this, 'uacf7_mailchimp_sanitize' ) // sanitize_callback
		);

		//Addons settings section
		add_settings_section(
			'uacf7_setting_section', // id
			__( 'General Addons:', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_section_info' ), // callback
			'ultimate-addons-admin' // page
		);

		//Mailchimp settings section
		add_settings_section(
			'uacf7_mailchimp_setting_section', // id
			__( 'Mailchimp settings:', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_mailchimp_section_info' ), // callback
			'ultimate-mailchimp-admin' // page
		);

		add_settings_field(
			'uacf7_enable_redirection', // id
			__( 'Redirection', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_redirection_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);
        
        add_settings_field(
			'uacf7_enable_conditional_field', // id
			__( 'Conditional Field', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_conditional_field_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);
        
        add_settings_field(
			'uacf7_enable_field_column', // id
			__( 'Column or Grid', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_field_column_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);
        
        add_settings_field(
			'uacf7_enable_placeholder', // id
			__( 'Placeholder Styling', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_placeholder_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);
        
        add_settings_field(
			'uacf7_enable_uacf7style', // id
			__( 'Complete Form Styler', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_uacf7style_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);
        
        add_settings_field(
			'uacf7_enable_multistep', // id
			__( 'Multistep Form', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_multistep_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);
		
		add_settings_field(
			'uacf7_enable_booking_form', // id
			__( 'Booking/Appointment Form', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_booking_form_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);
        
        add_settings_field(
			'uacf7_enable_post_submission', // id
			__( 'Frontend Post Submission', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_post_submission_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);
        
        add_settings_field(
			'uacf7_enable_mailchimp', // id
			__( 'Mailchimp', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_mailchimp_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);
        add_settings_field(
			'uacf7_enable_dynamic_text', // id
			__( 'Dynamic Text', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_dynamic_text_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);

        add_settings_field(
			'uacf7_enable_pre_populate_field', // id
			__( 'Pre-populate Field', 'ultimate-addons-cf7' ), // title
			array( $this, 'uacf7_enable_pre_populate_field_callback' ), // callback
			'ultimate-addons-admin', // page
			'uacf7_setting_section' // section
		);

        add_settings_section(
			'uacf7_setting_section_fields', // id
			'', // title
			array( $this, 'uacf7_setting_section_fields_callback' ), // callback
			'ultimate-addons-admin' // page
		);
        
        add_settings_field(
            'uacf7_enable_star_rating', // id
            __( 'Star Rating', 'ultimate-addons-cf7' ), // title
            array( $this, 'uacf7_enable_star_rating_callback' ), // callback
            'ultimate-addons-admin', // page
            'uacf7_setting_section_fields' // section
        );

        add_settings_section(
			'uacf7_setting_section_woo', // id
			'', // title
			array( $this, 'uacf7_setting_section_woo_callback' ), // callback
			'ultimate-addons-admin' // page
		);
        
        add_settings_field(
            'uacf7_enable_product_dropdown', // id
            __( 'Product Dropdown Menu', 'ultimate-addons-cf7' ), // title
            array( $this, 'uacf7_enable_product_dropdown_callback' ), // callback
            'ultimate-addons-admin', // page
            'uacf7_setting_section_woo' // section
        );
        
        add_settings_field(
            'uacf7_enable_product_auto_cart', // id
            __( 'Auto Add to Cart & Checkout after Form Submission', 'ultimate-addons-cf7' ), // title
            array( $this, 'uacf7_enable_product_auto_cart_callback' ), // callback
            'ultimate-addons-admin', // page
            'uacf7_setting_section_woo' // section
        );

		add_settings_field(
			'uacf7_enable_range_slider', //id
			__( 'Range Slider', 'ultimate-addons-cf7'), //title 
			array( $this, 'uacf7_range_slider_callback'),
			'ultimate-addons-admin', // page
			'uacf7_setting_section_fields'
		);
		
		add_settings_field(
			'uacf7_enable_repeater_field', //id
			__( 'Repeater Field', 'ultimate-addons-cf7'), //title 
			array( $this, 'uacf7_repeater_field_callback'),
			'ultimate-addons-admin', // page
			'uacf7_setting_section_fields'
		);
		
		add_settings_field(
			'uacf7_enable_country_dropdown_field', //id
			__( 'Country Dropdown Field', 'ultimate-addons-cf7'), //title 
			array( $this, 'uacf7_country_dropdown_callback'),
			'ultimate-addons-admin', // page
			'uacf7_setting_section_fields'
		);
		
		add_settings_field(
			'uacf7_enable_ip_geo_fields', //id
			__( 'IP Geo Fields (Autocomplete Country, City, State, Zip Fields)', 'ultimate-addons-cf7'), //title 
			array( $this, 'uacf7_ip_geo_callback'),
			'ultimate-addons-admin', // page
			'uacf7_setting_section_fields'
		);
		
		add_settings_field(
			'uacf7_mailchimp_api_key', //id
			__( 'Mailchimp API', 'ultimate-addons-cf7'), //title 
			array( $this, 'uacf7_mailchimp_api_key_callback'),
			'ultimate-mailchimp-admin', // page
			'uacf7_mailchimp_setting_section'
		);
        
        do_action( 'uacf7_settings_field' );
	}

    /*
    * Sanitize fields
    */
	public function uacf7_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['uacf7_enable_redirection'] ) ) {
			$sanitary_values['uacf7_enable_redirection'] = $input['uacf7_enable_redirection'];
		}
        
        if ( isset( $input['uacf7_enable_conditional_field'] ) ) {
			$sanitary_values['uacf7_enable_conditional_field'] = $input['uacf7_enable_conditional_field'];
		}
        
        if ( isset( $input['uacf7_enable_field_column'] ) ) {
			$sanitary_values['uacf7_enable_field_column'] = $input['uacf7_enable_field_column'];
		}
        
        if ( isset( $input['uacf7_enable_placeholder'] ) ) {
			$sanitary_values['uacf7_enable_placeholder'] = $input['uacf7_enable_placeholder'];
		}
        
        if ( isset( $input['uacf7_enable_uacf7style'] ) ) {
			$sanitary_values['uacf7_enable_uacf7style'] = $input['uacf7_enable_uacf7style'];
		}
        
        if ( isset( $input['uacf7_enable_star_rating'] ) ) {
			$sanitary_values['uacf7_enable_star_rating'] = $input['uacf7_enable_star_rating'];
		}
        
        if ( isset( $input['uacf7_enable_multistep'] ) ) {
			$sanitary_values['uacf7_enable_multistep'] = $input['uacf7_enable_multistep'];
		}
        
        if ( isset( $input['uacf7_enable_product_dropdown'] ) ) {
			$sanitary_values['uacf7_enable_product_dropdown'] = $input['uacf7_enable_product_dropdown'];
		}
		
        if ( isset( $input['uacf7_enable_range_slider'] ) ) {
			$sanitary_values['uacf7_enable_range_slider'] = $input['uacf7_enable_range_slider'];
		}
        
        if ( isset( $input['uacf7_enable_country_dropdown_field'] ) ) {
			$sanitary_values['uacf7_enable_country_dropdown_field'] = $input['uacf7_enable_country_dropdown_field'];
		}

        if ( isset( $input['uacf7_enable_mailchimp'] ) ) {
			$sanitary_values['uacf7_enable_mailchimp'] = $input['uacf7_enable_mailchimp'];
		}
        if ( isset( $input['uacf7_enable_dynamic_text'] ) ) {
			$sanitary_values['uacf7_enable_dynamic_text'] = $input['uacf7_enable_dynamic_text'];
		}
        if ( isset( $input['uacf7_enable_pre_populate_field'] ) ) {
			$sanitary_values['uacf7_enable_pre_populate_field'] = $input['uacf7_enable_pre_populate_field'];
		}
		if ( isset( $input['uacf7_enable_booking_form'] ) ) {
			$sanitary_values['uacf7_enable_booking_form'] = $input['uacf7_enable_booking_form'];
		}

		if ( isset( $input['uacf7_mailchimp_api_key'] ) ) {
			$sanitary_values['uacf7_mailchimp_api_key'] = sanitize_text_field($input['uacf7_mailchimp_api_key']);
		}

        return apply_filters( 'uacf7_save_admin_menu', $sanitary_values, $input );
	}
    
	//Mailchimp sanitize
    public function uacf7_mailchimp_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['uacf7_mailchimp_api_key'] ) ) {
			$sanitary_values['uacf7_mailchimp_api_key'] = $input['uacf7_mailchimp_api_key'];
		}
		return apply_filters( 'uacf7_save_mailchimp_menu', $sanitary_values, $input );
	}

    public function uacf7_section_info() {
		//Nothing to say
	}

    public function uacf7_mailchimp_section_info() {
		//Nothing to say
	}
    
    /*
    * Section- Extra fields
    */
    public function uacf7_setting_section_fields_callback() {
		echo '<h2>Extra Fields Addons:</h2>';
	}
    
    /*
    * Section- WooCommerce Integration
    */
    public function uacf7_setting_section_woo_callback() {
		echo '<h2>WooCommerce Integration Addons:</h2>';
	}
    
    /*
    * Field - Enable redirection
    */
	public function uacf7_enable_redirection_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_redirection">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_redirection]" id="uacf7_enable_redirection" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
        	</label>', uacf7_checked('uacf7_enable_redirection')
		);
	}
    
    /*
    * Field - Enable conditional field
    */
    public function uacf7_enable_conditional_field_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_conditional_field">
				<input type="checkbox" class="uacf7-admin-toggle__input"  name="uacf7_option_name[uacf7_enable_conditional_field]" id="uacf7_enable_conditional_field" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_conditional_field')
		);
	}
    
    /*
    * Field - Enable field column
    */
    public function uacf7_enable_field_column_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_field_column">
				<input type="checkbox" class="uacf7-admin-toggle__input"  name="uacf7_option_name[uacf7_enable_field_column]" id="uacf7_enable_field_column" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_field_column')
		);
	}
    
    /*
    * Field - Enable Placeholder
    */
    public function uacf7_enable_placeholder_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_placeholder">
				<input type="checkbox" class="uacf7-admin-toggle__input"  name="uacf7_option_name[uacf7_enable_placeholder]" id="uacf7_enable_placeholder" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_placeholder')
		);
	}
    
    /*
    * Field - Enable Form Styler
    */
    public function uacf7_enable_uacf7style_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_uacf7style">
				<input type="checkbox" class="uacf7-admin-toggle__input"  name="uacf7_option_name[uacf7_enable_uacf7style]" id="uacf7_enable_uacf7style" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_uacf7style')
		);
	}
    
    /*
    * Field - Enable Multistep
    */
    public function uacf7_enable_multistep_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_multistep">
				<input type="checkbox" class="uacf7-admin-toggle__input"  name="uacf7_option_name[uacf7_enable_multistep]" id="uacf7_enable_multistep" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_multistep')
		);
	}
	
	/*
    * Field - Enable Booking/Appointment Form
    */
    public function uacf7_enable_booking_form_callback() {
		if(is_plugin_active('ultimate-booking-form/uacf7-booking-form.php')){
			$pro = '';
		}else{
			$pro = '<span class="uacf7-bf-pro-link"><a style="color:red" target="_blank" href="https://cf7addons.com/preview/booking-form">(Pro Addon)</a></span>';
		}
		
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_booking_form">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_booking_form]" id="uacf7_enable_booking_form" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>'.$pro.'', apply_filters('uacf7_enable_booking_form','')
		);
	}
    
    /*
    * Field - Enable post submission
    */
    public function uacf7_enable_post_submission_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_post_submission">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_post_submission]" id="uacf7_enable_post_submission" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label> 
			<span class="uacf7-post-sub-pro-link"><a style="color:red" target="_blank" href="https://cf7addons.com/preview/post-submission/">(Pro Addon)</a></span>', uacf7_checked('uacf7_enable_post_submission')
		);
	}
    
    /*
    * Field - Enable mailchimp
    */
    public function uacf7_enable_mailchimp_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_mailchimp">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_mailchimp]" id="uacf7_enable_mailchimp" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_mailchimp')
		);
	}
    
    /*
    * Field - Enable dynamic text
    */
    public function uacf7_enable_dynamic_text_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_dynamic_text">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_dynamic_text]" id="uacf7_enable_dynamic_text" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_dynamic_text')
		);
	}
    
    /*
    * Field - Enable dynamic text
    */
    public function uacf7_enable_pre_populate_field_callback() {
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_pre_populate_field">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_pre_populate_field]" id="uacf7_enable_pre_populate_field" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_pre_populate_field')
		);
	}
    
    /*
    * Field - Enable star rating
    */
    public function uacf7_enable_star_rating_callback(){
        printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_star_rating">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_star_rating]" id="uacf7_enable_star_rating" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_star_rating')
		);
    }
    
    /*
    * Field - Enable product dropdown
    */
    public function uacf7_enable_product_dropdown_callback(){
        printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_product_dropdown">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_product_dropdown]" id="uacf7_enable_product_dropdown" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_product_dropdown')
			);
    }
    
    /*
    * Field - Enable product dropdown
    */
    public function uacf7_enable_product_auto_cart_callback(){
		
        printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_product_auto_cart">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_product_auto_cart]" id="uacf7_enable_product_auto_cart" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label><span class="uacf7-product-auto-cart-pro"><a style="color:red" target="_blank" href="https://cf7addons.com/preview/woocommerce-checkout/">(Pro Addon)</a></span>', apply_filters('uacf7_enable_product_auto_cart','')
		);
    }

	/**
	 * Field - Enable Range slider
	 */
	public function uacf7_range_slider_callback(){
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_range_slider">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_range_slider]" id="uacf7_enable_range_slider" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_range_slider')
		);
	}
	
	/**
	 * Field - Enable repeater
	 */
	public function uacf7_repeater_field_callback(){
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_repeater_field">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_repeater_field]" id="uacf7_enable_repeater_field" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>
			<span class="uacf7-repeater-field-pro"><a style="color:red" target="_blank" href="https://cf7addons.com/preview/repeater-field/">(Pro Addon)</a></span>', apply_filters('uacf7_enable_repeater_field','')
		);
	}
	
	/**
	 * Field - Country dropdown
	 */
	public function uacf7_country_dropdown_callback(){
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_country_dropdown_field">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_country_dropdown_field]" id="uacf7_enable_country_dropdown_field" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>', uacf7_checked('uacf7_enable_country_dropdown_field')
		);
	}
	
	/**
	 * Field - IP Geo
	 */
	public function uacf7_ip_geo_callback(){
		printf(
			'<label class="uacf7-admin-toggle" for="uacf7_enable_ip_geo_fields">
				<input type="checkbox" class="uacf7-admin-toggle__input" name="uacf7_option_name[uacf7_enable_ip_geo_fields]" id="uacf7_enable_ip_geo_fields" %s>
				<span class="uacf7-admin-toggle-track"><span class="uacf7-admin-toggle-indicator"><span class="checkMark"><svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg></span></span></span>
			</label>
			<span class="uacf7-ip-get-field"><a style="color:red" target="_blank" href="https://cf7addons.com/preview/ip-geo/">(Pro Addon)</a></span>', apply_filters('uacf7_enable_ip_geo_fields','')
		);
	}
	
	/**
	 * Field - Mailchimp
	 */
	public function uacf7_mailchimp_api_key_callback(){
		$val = get_option('uacf7_mailchimp_option_name');
		
		if( is_array($val) && !empty(array_filter($val)) ){
			$val = $val['uacf7_mailchimp_api_key'];
		}else {
			$val = '';
		}

		$mailchimp = new UACF7_MAILCHIMP();

		echo '<label class="" for="uacf7_mailchimp_api_key">
				<input type="text" class="" name="uacf7_mailchimp_option_name[uacf7_mailchimp_api_key]" id="uacf7_mailchimp_api_key" value="'. $val.'">
				'.$mailchimp->connection_status().'
			</label>';
	}

}

/*
* Object - UACF7_Admin_Menu
*/
$uacf7_admin_menu = new UACF7_Admin_Menu();

// Link to settings page from plugins screen
add_filter( 'plugin_action_links_ultimate-addons-for-contact-form-7/ultimate-addons-for-contact-form-7.php', 'bafg_action_links' );
function bafg_action_links ( $links ) {
    $settings = esc_html__('Settings','ultimate-addons');
    $settings_link = array(
        '<a href="' . admin_url( 'admin.php?page=ultimate-addons' ) . '">'.$settings.'</a>',
    );
    return array_merge( $links, $settings_link );
}