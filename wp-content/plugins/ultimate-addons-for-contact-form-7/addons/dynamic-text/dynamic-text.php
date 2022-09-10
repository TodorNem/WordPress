<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_DYNAMIC_TEXT {
    
    /*
    * Construct function
    */
    public function __construct() {
        add_action( 'wpcf7_init', array($this, 'add_shortcodes') );

        add_action( 'admin_init', array( $this, 'tag_generator' ) );

        add_filter( 'wpcf7_validate_uacf7_dynamic_text', array($this, 'uacf7_dynamic_text_validation_filter'), 10, 2 );
        
		add_filter( 'wpcf7_validate_uacf7_dynamic_text*', array($this,'uacf7_dynamic_text_validation_filter'), 10, 2 );


        //Require Shortcode
        require_once( 'inc/shortcode.php' );
        
    } 

    /*
    * Form tag
    */
    public function add_shortcodes() {
        
        wpcf7_add_form_tag( array( 'uacf7_dynamic_text', 'uacf7_dynamic_text*'),
        array( $this, 'uacf7_dynamic_text_tag_handler_callback' ), array( 'name-attr' => true ) );
    }

    /*
    * Form tag shortcode
    */
    public function uacf7_dynamic_text_tag_handler_callback($tag){
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
		
        // input size
		$size = $tag->get_option( 'size', 'int', true );
        if ( $size ) {
			$atts['size'] = $size;
		} else {
			$atts['size'] = 40;
		}

        // Visibility
		$visibility = $tag->get_option( 'visibility', '', true );
        if($visibility == 'show'){
            $atts['type'] = 'text';
        }elseif($visibility == 'disabled'){
            $atts['type'] = 'text';
            $atts['disabled'] = 'disabled';
        }elseif($visibility == 'hidden'){
            $atts['type'] = 'hidden';
        }

		
        $values = $tag->values;
        $key = $tag->get_option( 'key', '', true );

        // Short Code
        $shortcode = '';
        if(!empty($values)){ 
             $shortcode =  do_shortcode('['.$values[0].' attr="'.$key.'"]'); 
        } 
		$atts['value'] = esc_attr($shortcode);

        $atts = wpcf7_format_atts( $atts );
		ob_start();
        
		?>
		<span  class="wpcf7-form-control-wrap <?php echo sanitize_html_class( $tag->name ); ?>" data-name="<?php echo sanitize_html_class( $tag->name ); ?>">
		
			<input id="uacf7_<?php echo esc_attr($tag->name); ?>" <?php echo $atts; ?>  >
			<span><?php echo $validation_error; ?></span> 
		</span>
		<?php
		
		$countries = ob_get_clean();
		
        return $countries;
    }


    /*
    * Form tag Validation 
    */
    public function uacf7_dynamic_text_validation_filter($result, $tag ){
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

        wpcf7_add_tag_generator('uacf7_dynamic_text',
            __('Dynamic Text', 'ultimate-addons-cf7'),
            'uacf7-tg-pane-dynamic-text',
            array($this, 'tg_pane_uacf7_dynamic_text')
        );

    }


    static function tg_pane_uacf7_dynamic_text( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $uacf7_field_type = 'uacf7_dynamic_text';
        ?>
        <div class="control-box">
        <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/country-dropdown-field-in-contact-form-7/" target="_blank">documentation</a>.</div>
         
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
                        <tr>
                            <th scope="row"><label for="visibility"> Field Visibility </label></th>
                            <td>
                                <label for="show"><input id="show" name="visibility" class="option" type="radio" value="show" checked> Show</label>
                                
                                <label for="disabled"><input id="disabled" name="visibility" class="option" type="radio" value="disabled"> Disabled</label>
                                
                                <label for="hidden"><input id="hidden" name="visibility" class="option" type="radio" value="hidden"> Hidden</label>
                            </td>
                        </tr>  
                        <tr class="">   
                            <th><label for="tag-generator-panel-star-style">Dynamic value</label></th>                     
                            <td>
                                <select  name="values" class="values" id="tag-generator-panel-dynamic-value">
                                    <option value="">Select</option> 
                                    <option value="UACF7_URL">Current URL</option> 
                                    <option value="UACF7_BLOGINFO">Blog Info</option> 
                                    <option value="UACF7_POSTINFO">Current post info</option> 
                                    <option value="UACF7_USERINFO">Current User info</option> 
                                    <option value="UACF7_CUSTOM_FIELDS">Custom fields</option> 
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="tag-generator-panel-text-class">Dynamic key</label></th>
                            <td><input type="text" placeholder="Dynamic key" name="key" class="key oneline option" id="tag-generator-panel-text-key"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="tag-generator-panel-text-class">Class attribute</label></th>
                            <td><input type="text" name="class" class="classvalue oneline option" id="tag-generator-panel-text-class"></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
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
new UACF7_DYNAMIC_TEXT();