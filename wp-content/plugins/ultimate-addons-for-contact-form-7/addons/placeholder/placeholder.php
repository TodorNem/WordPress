<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_Placeholder {
    
    /*
    * Construct function
    */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_placeholder_style' ) );
		add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );
        add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_contact_form' ) );
        add_filter( 'wpcf7_contact_form_properties', array( $this, 'uacf7_properties' ), 10, 2 );
    }
	
	public function admin_enqueue_placeholder_styles() {
        wp_enqueue_style( 'uacf7-placeholder-style', UACF7_URL . 'addons/', array(), null, true );
    }
    
    public function enqueue_placeholder_style() {
        wp_enqueue_style( 'uacf7-placeholder', UACF7_ADDONS . '/placeholder/css/placeholder-style.css' );
        wp_enqueue_script( 'uacf7-placeholder-script', UACF7_ADDONS . '/placeholder/js/color-pickr.js', array('jquery', 'wp-color-picker' ), '', true );
    }
    
    /*
    * Function create tab panel
    */
    public function uacf7_add_panel( $panels ) {
		$panels['uacf7-placeholder-panel'] = array(
            'title'    => __( 'UACF7 Placeholder', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_placeholder_panel_fields' ),
		);
		return $panels;
	}
    
    /*
    * Function Placeholder fields
    */
    public function uacf7_create_placeholder_panel_fields( $post ) {
        // get existing value
        $fontfamily = get_post_meta( $post->id(), 'uacf7_placeholder_fontfamily', true );
        $fontsize = get_post_meta( $post->id(), 'uacf7_placeholder_fontsize', true );
        $fontstyle = get_post_meta( $post->id(), 'uacf7_placeholder_fontstyle', true );
        $fontweight = get_post_meta( $post->id(), 'uacf7_placeholder_fontweight', true );
        $color = get_post_meta( $post->id(), 'uacf7_placeholder_color', true );
        $background_color = get_post_meta( $post->id(), 'uacf7_placeholder_background_color', true );
        ?>
        <h2><?php echo esc_html__( 'Placeholder Styles', 'ultimate-addons-cf7' ); ?></h2>
        <p><?php echo esc_html__('This feature will help you to edit the Styles of Placeholder of your form. Note that, all below fields are optional. If any field is not needed, leave them blank.','ultimate-addons-cf7'); ?></p>
        <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/placeholder-styler-for-contact-form-7/" target="_blank">documentation</a>.</div>
        <fieldset>
           <div class="ultimate-placeholder-admin">
               <div class="ultimate-placeholder-wrapper">
                 
                  <?php $placeholder_styles = get_post_meta( $post->id(), 'uacf7_enable_placeholder_styles', true ); ?>
                  <h3>Placeholder Styles</h3>
                  <label for="uacf7_enable_placeholder_styles">  
                       <input id="uacf7_enable_placeholder_styles" type="checkbox" name="uacf7_enable_placeholder_styles" <?php checked( 'on', $placeholder_styles ); ?> > Enable
                   </label><br><br>
                  <hr>
                   <h3>Color and Font Options</h3>
                    <div class="placeholder-fourcolumns">
                        <h4>Color</h4>
                        <input type="text" id="uacf7-placeholder-color" name="uacf7_placeholder_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($color); ?>" placeholder="<?php echo esc_html__( 'Enter Placeholder Color', 'ultimate-addons-cf7' ); ?>"><br><br>
                    </div>
                    <div class="placeholder-fourcolumns">
                        <h4>Background Color</h4>
                        <input type="text" id="uacf7-placeholder-background-color" name="uacf7_placeholder_background_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($background_color); ?>" placeholder="<?php echo esc_html__( 'Enter Placeholder Background Color', 'ultimate-addons-cf7' ); ?>"><br><br>
                    </div>
                    <div class="placeholder-fourcolumns">
                        <h4>Font Style</h4>
                        <select name="uacf7_placeholder_fontstyle" id="uacf7-placeholder-fontstyle">
                            <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($fontstyle), true ); ?>><?php echo esc_html('Normal'); ?></option>
                            <option value="<?php esc_attr_e('italic'); ?>" <?php selected( 'italic', esc_attr($fontstyle), true ); ?> ><?php echo esc_html('Italic'); ?></option>
                        </select>
                    </div>
                    <div class="placeholder-fourcolumns">
                        <h4>Font Weight</h4>
                        <select name="uacf7_placeholder_fontweight" id="uacf7-placeholder-fontweight">
                            <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($fontweight), true ); ?>><?php echo esc_html('Normal / 400'); ?></option>
                            <option value="<?php esc_attr_e('300'); ?>" <?php selected( '300', esc_attr($fontweight), true ); ?>><?php echo esc_html('300'); ?></option>
                            <option value="<?php esc_attr_e('500'); ?>" <?php selected( '500', esc_attr($fontweight), true ); ?>><?php echo esc_html('500'); ?></option>
                            <option value="<?php esc_attr_e('700'); ?>" <?php selected( '700', esc_attr($fontweight), true ); ?>><?php echo esc_html('700'); ?></option>
                            <option value="<?php esc_attr_e('900'); ?>" <?php selected( '900', esc_attr($fontweight), true ); ?>><?php echo esc_html('900'); ?></option>
                        </select>
                        <br><br>
                    </div>
                    <div class="clear"></div>
                    <hr>
                    <div class="placeholder-columns">
                        <h4>Font Size (in px)</h4>
                        <input type="number" id="uacf7-placeholder-fontsize" name="uacf7_placeholder_fontsize" class="large-text" value="<?php echo esc_attr_e($fontsize); ?>" placeholder="<?php echo esc_html__( 'Enter Placeholder Font Size (in px)', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
                    </div>
                    <div class="placeholder-columns">
                        <h4>Font Name</h4>
                        <input type="text" id="uacf7-placeholder-fontfamily" name="uacf7_placeholder_fontfamily" class="large-text" value="<?php echo esc_attr_e($fontfamily); ?>" placeholder="<?php echo esc_html__( 'Enter Placeholder Font Name', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>Roboto, sans-serif</span> (Do not add special characters like '' or ; )</small><br><br>
                    </div>
                    <div class="clear"></div>
               </div>
                <p>Need more placeholder or other options? Let us know <a href="https://themefic.com/contact/" target="_blank">here</a>.</p>
           </div>
        </fieldset>
        <?php
         wp_nonce_field( 'uacf7_placeholder_nonce_action', 'uacf7_placeholder_nonce' );
    }
    
    public function uacf7_save_contact_form( $form ) {
        
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        if ( ! wp_verify_nonce( $_POST['uacf7_placeholder_nonce'], 'uacf7_placeholder_nonce_action' ) ) {
            return;
        }

        update_post_meta( $form->id(), 'uacf7_enable_placeholder_styles', $_POST['uacf7_enable_placeholder_styles'] );
        
        update_post_meta( $form->id(), 'uacf7_placeholder_fontfamily', $_POST['uacf7_placeholder_fontfamily'] );
        update_post_meta( $form->id(), 'uacf7_placeholder_fontsize', $_POST['uacf7_placeholder_fontsize'] );
        update_post_meta( $form->id(), 'uacf7_placeholder_fontstyle', $_POST['uacf7_placeholder_fontstyle'] );
        update_post_meta( $form->id(), 'uacf7_placeholder_fontweight', $_POST['uacf7_placeholder_fontweight'] );
        update_post_meta( $form->id(), 'uacf7_placeholder_color', $_POST['uacf7_placeholder_color'] );
        update_post_meta( $form->id(), 'uacf7_placeholder_background_color', $_POST['uacf7_placeholder_background_color'] );
    }
    
    public function uacf7_properties($properties, $cfform) {
	
        if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) { 

            $form = $properties['form'];

            $placeholder_styles = get_post_meta( $cfform->id(), 'uacf7_enable_placeholder_styles', true );
            
            if( $placeholder_styles == 'on' ) :
            
            ob_start();
            
            $fontfamily = get_post_meta( $cfform->id(), 'uacf7_placeholder_fontfamily', true );
            $fontsize = get_post_meta( $cfform->id(), 'uacf7_placeholder_fontsize', true );
            $fontstyle = get_post_meta( $cfform->id(), 'uacf7_placeholder_fontstyle', true );
            $fontweight = get_post_meta( $cfform->id(), 'uacf7_placeholder_fontweight', true );
            $color = get_post_meta( $cfform->id(), 'uacf7_placeholder_color', true );
            $background_color = get_post_meta( $cfform->id(), 'uacf7_placeholder_background_color', true );
            ?>
            <style>
                .uacf7-form-<?php esc_attr_e( $cfform->id() ); ?> ::placeholder {
                    color: <?php echo esc_attr_e($color); ?>;
                    background-color: <?php echo esc_attr_e($background_color); ?>;
                    font-size: <?php echo esc_attr_e($fontsize).'px'; ?>;
                    font-family: <?php echo esc_attr_e($fontfamily); ?>;
                    font-style: <?php echo esc_attr_e($fontstyle); ?>;
                    font-weight: <?php echo esc_attr_e($fontweight); ?>;
                }
                .uacf7-form-<?php esc_attr_e( $cfform->id() ); ?> ::-webkit-input-placeholder { /* Edge */
                    color: <?php echo esc_attr_e($color); ?>;
                    background-color: <?php echo esc_attr_e($background_color); ?>;
                    font-size: <?php echo esc_attr_e($fontsize).'px'; ?>;
                    font-family: <?php echo esc_attr_e($fontfamily); ?>;
                    font-style: <?php echo esc_attr_e($fontstyle); ?>;
                    font-weight: <?php echo esc_attr_e($fontweight); ?>;
                }
                .uacf7-form-<?php esc_attr_e( $cfform->id() ); ?> :-ms-input-placeholder { /* Internet Explorer 10-11 */
                    color: <?php echo esc_attr_e($color); ?>;
                    background-color: <?php echo esc_attr_e($background_color); ?>;
                    font-size: <?php echo esc_attr_e($fontsize).'px'; ?>;
                    font-family: <?php echo esc_attr_e($fontfamily); ?>;
                    font-style: <?php echo esc_attr_e($fontstyle); ?>;
                    font-weight: <?php echo esc_attr_e($fontweight); ?>;
                }
            </style>
            <?php
            echo $form;
            $properties['form'] = ob_get_clean();
            
            endif;
        }

        return $properties;
    }
   
}
new UACF7_Placeholder();