<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_COUNTRY_DROPDOWN {

    /*
    * Construct function
    */
    public function __construct() {
        add_action( 'wpcf7_init', array($this, 'add_shortcodes') );
        
		add_action( 'admin_init', array( $this, 'tag_generator' ) );
        
		add_filter( 'wpcf7_validate_uacf7_country_dropdown', array($this, 'wpcf7_country_dropdown_validation_filter'), 10, 2 );
        
		add_filter( 'wpcf7_validate_uacf7_country_dropdown*', array($this,'wpcf7_country_dropdown_validation_filter'), 10, 2 );
        
		add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_script' ) );        
    }
    
    public function wp_enqueue_script() {
		wp_enqueue_style( 'uacf7-country-select-main', UACF7_ADDONS . '/country-dropdown/assets/css/countrySelect.min.css' );
		wp_enqueue_style( 'uacf7-country-select-style', UACF7_ADDONS . '/country-dropdown/assets/css/style.css' );
		
		wp_enqueue_script( 'uacf7-country-select-library', UACF7_ADDONS . '/country-dropdown/assets/js/countrySelect.js', array('jquery'), null, true );
		wp_enqueue_script( 'uacf7-country-select-script', UACF7_ADDONS . '/country-dropdown/assets/js/script.js', array('jquery','uacf7-country-select-library'), null, true );
    }
    
    /*
    * Form tag
    */
    public function add_shortcodes() {
        
        wpcf7_add_form_tag( array( 'uacf7_country_dropdown', 'uacf7_country_dropdown*'),
        array( $this, 'tag_handler_callback' ), array( 'name-attr' => true ) );
    }
    
    public function tag_handler_callback( $tag ) {
        
        if ( empty( $tag->name ) ) {
            return '';
        }

        $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type );

        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }

        $atts = array();

        $atts['class'] = $tag->get_class_option( $class );
        $atts['id'] = $tag->get_id_option();
        $atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
        }

        $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

        $atts['name'] = $tag->name;
		
		$size = $tag->get_option( 'size', 'int', true );

		if ( $size ) {
			$atts['size'] = $size;
		} else {
			//$atts['size'] = 40;
		}
		
        $atts = wpcf7_format_atts( $atts );
		
		ob_start();
		?>
		<span id="uacf7_country_select" class="wpcf7-form-control-wrap <?php echo sanitize_html_class( $tag->name ); ?>">
		
			<input id="uacf7_countries_<?php echo esc_attr($tag->name); ?>" type="text" <?php echo $atts; ?> <?php echo do_action('uacf7_country_dropdown_atts', $tag); ?> >
			<span><?php echo $validation_error; ?></span>
		
			<div style="display:none;">
				<input type="hidden" id="uacf7_countries_<?php echo esc_attr($tag->name); ?>_code" data-countrycodeinput="1" readonly="readonly" placeholder="Selected country code will appear here" />
			</div>
		</span>
		<?php
		
		$countries = ob_get_clean();
		
        return $countries;
    }
    
    public function wpcf7_country_dropdown_validation_filter( $result, $tag ) {
        $name = $tag->name;

        if ( isset( $_POST[$name] )
        and is_array( $_POST[$name] ) ) {
            foreach ( $_POST[$name] as $key => $value ) {
                if ( '' === $value ) {
                    unset( $_POST[$name][$key] );
                }
            }
        }

        $empty = ! isset( $_POST[$name] ) || empty( $_POST[$name] ) && '0' !== $_POST[$name];

        if ( $tag->is_required() and $empty ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
        }

        return $result;
    }

    /*
    * Generate tag - conditional
    */
    public function tag_generator() {
        if (! function_exists( 'wpcf7_add_tag_generator'))
            return;

        wpcf7_add_tag_generator('uacf7_country_dropdown',
            __('Country Dropdown', 'ultimate-addons-cf7'),
            'uacf7-tg-pane-country-dropdown',
            array($this, 'tg_pane_country_dropdown')
        );

    }
    
    static function tg_pane_country_dropdown( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $uacf7_field_type = 'uacf7_country_dropdown';
        ?>
        <div class="control-box">
            <fieldset>                
                <table class="form-table">
                   <tbody>
                        <tr>
                            <th scope="row">Field type</th>
                            <td>
                                <fieldset>
                                <legend class="screen-reader-text">Field type</legend>
                                <label><input type="checkbox" name="required" value="on"> Required field</label>
                                </fieldset>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'ultimate-addons-cf7' ) ); ?></label></th>
                            <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
                        </tr>
                        
                        <?php ob_start(); ?>
                        <tr>
                            <th scope="row"><label><?php echo esc_html( __( 'Auto complete', 'ultimate-addons-cf7' ) ); ?> <a style="color:red" target="_blank" href="https://cf7addons.com/">(Pro)</a></label></th>
                            <td><input disabled type="checkbox" class="option"> Auto complete country using user's network IP.</td>
                        </tr>
                        <?php 
                        $autocomplete_html = ob_get_clean(); 
                        /*
                        * Tag generator field: auto complete
                        */
                        echo apply_filters('uacf7_tag_generator_country_autocomplete_field',$autocomplete_html);
                        ?>
                        
                        <tr>
                            <th scope="row"><label for="tag-generator-panel-text-class">Class attribute</label></th>
                            <td><input type="text" name="class" class="classvalue oneline option" id="tag-generator-panel-text-class"></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
            <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/country-dropdown-field-in-contact-form-7/" target="_blank">documentation</a>.</div>
            <p class="uacf7-doc-notice uacf7-guide">Use Our Pro plugin <strong><a target="_blank" href="https://cf7addons.com/preview/ip-geo/">IP Geolocation</a></strong> to enable autocomplete country, city, state and zip code field based on user IP address.</p>
        </div>

        <div class="insert-box">
            <input type="text" name="<?php echo esc_attr($uacf7_field_type); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

            <div class="submitbox">
                <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'ultimate-addons-cf7' ) ); ?>" />
            </div>
        </div>
        <?php
    }
    
}
new UACF7_COUNTRY_DROPDOWN();
