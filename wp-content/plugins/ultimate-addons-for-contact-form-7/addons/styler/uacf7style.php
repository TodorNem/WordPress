<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_uacf7style {
    
    /*
    * Construct function
    */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_uacf7style_style' ) );
		add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );
        add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_contact_form' ) );
        add_filter( 'wpcf7_contact_form_properties', array( $this, 'uacf7_properties' ), 10, 2 );
    }
	
	public function admin_enqueue_uacf7style_styles() {
        wp_enqueue_style( 'uacf7-uacf7style-style', UACF7_URL . 'addons/', array(), null, true );
    }
    
    public function enqueue_uacf7style_style() {
        wp_enqueue_style( 'uacf7-uacf7style', UACF7_ADDONS . '/styler/css/uacf7styler.css' );
         
        
		global $pagenow;
		if( isset($_GET['page']) ){
			if ( ($pagenow == 'admin.php') && ($_GET['page'] == 'wpcf7') || ($_GET['page'] == 'wpcf7-new') ) {
				$cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
        		wp_localize_script('jquery', 'cm_settings', $cm_settings);
        		wp_enqueue_script('wp-theme-plugin-editor');
        		wp_enqueue_style('wp-codemirror');
				wp_enqueue_script( 'uacf7-uacf7style-script', UACF7_ADDONS . '/styler/js/custom.js', array('jquery', 'wp-color-picker' ), '', true );
			}
		}
		
    }
    
    /*
    * Function create tab panel
    */
    public function uacf7_add_panel( $panels ) {
		$panels['uacf7-uacf7style-panel'] = array(
            'title'    => __( 'UACF7 Form Styler', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_uacf7style_panel_fields' ),
		);
		return $panels;
	}
    
    /*
    * Function uacf7style fields
    */
    public function uacf7_create_uacf7style_panel_fields( $post ) {
        // get existing value
        $label_color = get_post_meta( $post->id(), 'uacf7_uacf7style_label_color', true );
        $label_background_color = get_post_meta( $post->id(), 'uacf7_uacf7style_label_background_color', true );
        $label_font_size = get_post_meta( $post->id(), 'uacf7_uacf7style_label_font_size', true );
        $label_font_family = get_post_meta( $post->id(), 'uacf7_uacf7style_label_font_family', true );
        $label_font_style = get_post_meta( $post->id(), 'uacf7_uacf7style_label_font_style', true );
        $label_font_weight = get_post_meta( $post->id(), 'uacf7_uacf7style_label_font_weight', true );
        $label_padding_top = get_post_meta( $post->id(), 'uacf7_uacf7style_label_padding_top', true );
        $label_padding_right = get_post_meta( $post->id(), 'uacf7_uacf7style_label_padding_right', true );
        $label_padding_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_label_padding_bottom', true );
        $label_padding_left = get_post_meta( $post->id(), 'uacf7_uacf7style_label_padding_left', true );
        $label_margin_top = get_post_meta( $post->id(), 'uacf7_uacf7style_label_margin_top', true );
        $label_margin_right = get_post_meta( $post->id(), 'uacf7_uacf7style_label_margin_right', true );
        $label_margin_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_label_margin_bottom', true );
        $label_margin_left = get_post_meta( $post->id(), 'uacf7_uacf7style_label_margin_left', true );
        
        $input_color = get_post_meta( $post->id(), 'uacf7_uacf7style_input_color', true );
        $input_background_color = get_post_meta( $post->id(), 'uacf7_uacf7style_input_background_color', true );
        $input_font_size = get_post_meta( $post->id(), 'uacf7_uacf7style_input_font_size', true );
        $input_font_family = get_post_meta( $post->id(), 'uacf7_uacf7style_input_font_family', true );
        $input_font_style = get_post_meta( $post->id(), 'uacf7_uacf7style_input_font_style', true );
        $input_font_weight = get_post_meta( $post->id(), 'uacf7_uacf7style_input_font_weight', true );
        $input_height = get_post_meta( $post->id(), 'uacf7_uacf7style_input_height', true );
        $input_border_width = get_post_meta( $post->id(), 'uacf7_uacf7style_input_border_width', true );
        $input_border_color = get_post_meta( $post->id(), 'uacf7_uacf7style_input_border_color', true );
        $input_border_style = get_post_meta( $post->id(), 'uacf7_uacf7style_input_border_style', true );
        $input_border_radius = get_post_meta( $post->id(), 'uacf7_uacf7style_input_border_radius', true );
        $textarea_input_height = get_post_meta( $post->id(), 'uacf7_uacf7style_textarea_input_height', true );
        $input_padding_top = get_post_meta( $post->id(), 'uacf7_uacf7style_input_padding_top', true );
        $input_padding_right = get_post_meta( $post->id(), 'uacf7_uacf7style_input_padding_right', true );
        $input_padding_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_input_padding_bottom', true );
        $input_padding_left = get_post_meta( $post->id(), 'uacf7_uacf7style_input_padding_left', true );
        $input_margin_top = get_post_meta( $post->id(), 'uacf7_uacf7style_input_margin_top', true );
        $input_margin_right = get_post_meta( $post->id(), 'uacf7_uacf7style_input_margin_right', true );
        $input_margin_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_input_margin_bottom', true );
        $input_margin_left = get_post_meta( $post->id(), 'uacf7_uacf7style_input_margin_left', true );
        
        $btn_color = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_color', true );
        $btn_background_color = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_background_color', true );
        $btn_font_size = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_font_size', true );
        $btn_font_style = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_font_style', true );
        $btn_font_weight = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_font_weight', true );
        $btn_border_width = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_width', true );
        $btn_border_color = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_color', true );
        $btn_border_style = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_style', true );
        $btn_border_radius = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_radius', true );
        $btn_width = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_width', true );
        $btn_color_hover = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_color_hover', true );
        $btn_background_color_hover = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_background_color_hover', true );
        $btn_border_color_hover = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_border_color_hover', true );
        $btn_padding_top = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_padding_top', true );
        $btn_padding_right = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_padding_right', true );
        $btn_padding_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_padding_bottom', true );
        $btn_padding_left = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_padding_left', true );
        $btn_margin_top = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_margin_top', true );
        $btn_margin_right = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_margin_right', true );
        $btn_margin_bottom = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_margin_bottom', true );
        $btn_margin_left = get_post_meta( $post->id(), 'uacf7_uacf7style_btn_margin_left', true );
        
        $ua_custom_css = get_post_meta( $post->id(), 'uacf7_uacf7style_ua_custom_css', true );
        ?>
        <h2><?php echo esc_html__( 'Form Styles', 'ultimate-addons-cf7' ); ?></h2>
        <p><?php echo esc_html__('This feature will help you to edit the Styles of your form. Note that, all below fields are optional. If any field is not needed, leave them blank.','ultimate-addons-cf7'); ?></p>
        <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/cf7-styler/" target="_blank">documentation</a>.</div>
        <fieldset>
           <div class="ultimate-uacf7style-admin">
               <div class="ultimate-uacf7style-wrapper">
                   <h3>Label Options</h3>
                   <div class="uacf7style-fourcolumns">
                       <h4>Color</h4>
                       <input type="text" id="uacf7-uacf7style-label-color" name="uacf7_uacf7style_label_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($label_color); ?>" placeholder="<?php echo esc_html__( 'Enter Label Color', 'ultimate-addons-cf7' ); ?>"><br><br>
                   </div>
                    <div class="uacf7style-fourcolumns">
                       <h4>Background Color</h4>
                       <input type="text" id="uacf7-uacf7style-label-background-color" name="uacf7_uacf7style_label_background_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($label_background_color); ?>" placeholder="<?php echo esc_html__( 'Enter Label Background Color', 'ultimate-addons-cf7' ); ?>"><br><br>
                   </div>
                   <div class="uacf7style-fourcolumns">
                       <h4>Font Style</h4>
                       <select name="uacf7_uacf7style_label_font_style" id="uacf7-uacf7style-label-font-style">
                            <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($label_font_style), true ); ?>><?php echo esc_html('Normal'); ?></option>
                            <option value="<?php esc_attr_e('italic'); ?>" <?php selected( 'italic', esc_attr($label_font_style), true ); ?> ><?php echo esc_html('Italic'); ?></option>
                        </select>
                   </div>
                    <div class="uacf7style-fourcolumns">
                       <h4>Font Weight</h4>
                       <select name="uacf7_uacf7style_label_font_weight" id="uacf7-uacf7style-label-font_weight">
                            <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('Normal / 400'); ?></option>
                            <option value="<?php esc_attr_e('300'); ?>" <?php selected( '300', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('300'); ?></option>
                            <option value="<?php esc_attr_e('500'); ?>" <?php selected( '500', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('500'); ?></option>
                            <option value="<?php esc_attr_e('700'); ?>" <?php selected( '700', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('700'); ?></option>
                            <option value="<?php esc_attr_e('900'); ?>" <?php selected( '900', esc_attr($label_font_weight), true ); ?>><?php echo esc_html('900'); ?></option>
                        </select>
                        <br><br>
                   </div>
                   <div class="clear"></div>
                   <div class="uacf7style-columns">
                       <h4>Font Size (in px)</h4>
                       <input type="number" id="uacf7-uacf7style-label-font-size" name="uacf7_uacf7style_label_font_size" class="large-text" value="<?php echo esc_attr_e($label_font_size); ?>" placeholder="<?php echo esc_html__( 'Enter Label Font Size', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
                   </div>
                    <div class="uacf7style-columns">
                       <h4>Font Family</h4>
                       <input type="text" id="uacf7-uacf7style-label-font-family" name="uacf7_uacf7style_label_font_family" class="large-text" value="<?php echo esc_attr_e($label_font_family); ?>" placeholder="<?php echo esc_html__( 'Enter Label Font Family', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>Roboto, sans-serif</span> (Do not add special characters like '' or ; )</small><br><br>
                   </div>
                   <div class="uacf7style-columns">
                       <h4>Padding (in px)</h4>
                       <div class="four-input">
                           <input type="number" id="uacf7-uacf7style-label-padding-top" name="uacf7_uacf7style_label_padding_top" class="large-text" value="<?php echo esc_attr_e($label_padding_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-padding-right" name="uacf7_uacf7style_label_padding_right" class="large-text" value="<?php echo esc_attr_e($label_padding_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-padding-bottom" name="uacf7_uacf7style_label_padding_bottom" class="large-text" value="<?php echo esc_attr_e($label_padding_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-padding-left" name="uacf7_uacf7style_label_padding_left" class="large-text" value="<?php echo esc_attr_e($label_padding_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                        </div>
                        <small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
                   </div>
                    <div class="uacf7style-columns">
                       <h4>Margin (in px)</h4>
                       <div class="four-input">
                           <input type="number" id="uacf7-uacf7style-label-margin-top" name="uacf7_uacf7style_label_margin_top" class="large-text" value="<?php echo esc_attr_e($label_margin_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-margin-right" name="uacf7_uacf7style_label_margin_right" class="large-text" value="<?php echo esc_attr_e($label_margin_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-margin-bottom" name="uacf7_uacf7style_label_margin_bottom" class="large-text" value="<?php echo esc_attr_e($label_margin_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                           <input type="number" id="uacf7-uacf7style-label-margin-left" name="uacf7_uacf7style_label_margin_left" class="large-text" value="<?php echo esc_attr_e($label_margin_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                       </div>
                       <small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
                   </div>
                   <div class="clear"></div>
               </div>
               
                <div class="clear"></div>
                
            <div class="ultimate-uacf7style-wrapper">
                <h3>Input Field Options</h3>
                <div class="uacf7style-fourcolumns">
                   <h4>Color</h4>
                   <input type="text" id="uacf7-uacf7style-input-color" name="uacf7_uacf7style_input_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($input_color); ?>" placeholder="<?php echo esc_html__( 'Enter Input Color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4>Background Color</h4>
                   <input type="text" id="uacf7-uacf7style-input-background-color" name="uacf7_uacf7style_input_background_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($input_background_color); ?>" placeholder="<?php echo esc_html__( 'Enter input Background Color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Font Style</h4>
                   <select name="uacf7_uacf7style_input_font_style" id="uacf7-uacf7style-input-font-style">
                        <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($input_font_style), true ); ?>><?php echo esc_html('Normal'); ?></option>
                    	<option value="<?php esc_attr_e('italic'); ?>" <?php selected( 'italic', esc_attr($input_font_style), true ); ?> ><?php echo esc_html('Italic'); ?></option>
                    </select>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4>Font Weight</h4>
                   <select name="uacf7_uacf7style_input_font_weight" id="uacf7-uacf7style-input-font_weight">
                    	<option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('Normal / 400'); ?></option>
                    	<option value="<?php esc_attr_e('300'); ?>" <?php selected( '300', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('300'); ?></option>
                    	<option value="<?php esc_attr_e('500'); ?>" <?php selected( '500', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('500'); ?></option>
                    	<option value="<?php esc_attr_e('700'); ?>" <?php selected( '700', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('700'); ?></option>
                    	<option value="<?php esc_attr_e('900'); ?>" <?php selected( '900', esc_attr($input_font_weight), true ); ?>><?php echo esc_html('900'); ?></option>
                    </select>
                    <br><br>
               </div>
               <div class="clear"></div>
               <div class="uacf7style-fourcolumns">
                   <h4>Font Size (in px)</h4>
                   <input type="number" id="uacf7-uacf7style-input-font-size" name="uacf7_uacf7style_input_font_size" class="large-text" value="<?php echo esc_attr_e($input_font_size); ?>" placeholder="<?php echo esc_html__( 'Enter input Font Size', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4>Font Family</h4>
                   <input type="text" id="uacf7-uacf7style-input-font-family" name="uacf7_uacf7style_input_font_family" class="large-text" value="<?php echo esc_attr_e($input_font_family); ?>" placeholder="<?php echo esc_html__( 'Enter input Font Family', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>Roboto, sans-serif</span> (Do not add special characters like '' or ; )</small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Input Height (in px)</h4>
                   <input type="number" id="uacf7-uacf7style-input-height" name="uacf7_uacf7style_input_height" class="large-text" value="<?php echo esc_attr_e($input_height); ?>" placeholder="<?php echo esc_html__( 'Enter input Height', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4>Input (Textarea) Height (in px)</h4>
                   <input type="number" id="uacf7-uacf7style-textarea-input-height" name="uacf7_uacf7style_textarea_input_height" class="large-text" value="<?php echo esc_attr_e($textarea_input_height); ?>" placeholder="<?php echo esc_html__( 'Enter textarea input Height', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
               <div class="clear"></div>
               <div class="uacf7style-columns">
                   <h4>Padding (in px)</h4>
                   <div class="four-input">
                       <input type="number" id="uacf7-uacf7style-input-padding-top" name="uacf7_uacf7style_input_padding_top" class="large-text" value="<?php echo esc_attr_e($input_padding_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-padding-right" name="uacf7_uacf7style_input_padding_right" class="large-text" value="<?php echo esc_attr_e($input_padding_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-padding-bottom" name="uacf7_uacf7style_input_padding_bottom" class="large-text" value="<?php echo esc_attr_e($input_padding_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-padding-left" name="uacf7_uacf7style_input_padding_left" class="large-text" value="<?php echo esc_attr_e($input_padding_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                    </div>
                    <small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
                <div class="uacf7style-columns">
                   <h4>Margin (in px)</h4>
                   <div class="four-input">
                       <input type="number" id="uacf7-uacf7style-input-margin-top" name="uacf7_uacf7style_input_margin_top" class="large-text" value="<?php echo esc_attr_e($input_margin_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-margin-right" name="uacf7_uacf7style_input_margin_right" class="large-text" value="<?php echo esc_attr_e($input_margin_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-margin-bottom" name="uacf7_uacf7style_input_margin_bottom" class="large-text" value="<?php echo esc_attr_e($input_margin_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-input-margin-left" name="uacf7_uacf7style_input_margin_left" class="large-text" value="<?php echo esc_attr_e($input_margin_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                   </div>
                   <small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Border Width (in px)</h4>
                   <input type="number" id="uacf7-uacf7style-input-border-width" name="uacf7_uacf7style_input_border_width" class="large-text" value="<?php echo esc_attr_e($input_border_width); ?>" placeholder="<?php echo esc_html__( 'Enter input border width', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Border Style</h4>
                   <select name="uacf7_uacf7style_input_border_style" id="uacf7-uacf7style-input-border-style">
                    	<option value="<?php esc_attr_e('none'); ?>" <?php selected( 'none', esc_attr($input_border_style), true ); ?>><?php echo esc_html('None'); ?></option>
                    	<option value="<?php esc_attr_e('dotted'); ?>" <?php selected( 'dotted', esc_attr($input_border_style), true ); ?>><?php echo esc_html('Dotted'); ?></option>
                    	<option value="<?php esc_attr_e('dashed'); ?>" <?php selected( 'dashed', esc_attr($input_border_style), true ); ?>><?php echo esc_html('Dashed'); ?></option>
                    	<option value="<?php esc_attr_e('solid'); ?>" <?php selected( 'solid', esc_attr($input_border_style), true ); ?>><?php echo esc_html('Solid'); ?></option>
                    	<option value="<?php esc_attr_e('double'); ?>" <?php selected( 'double', esc_attr($input_border_style), true ); ?>><?php echo esc_html('Double'); ?></option>
                    </select>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4>Border Radius (in px)</h4>
                   <input type="number" id="uacf7-uacf7style-input-border-radius" name="uacf7_uacf7style_input_border_radius" class="large-text" value="<?php echo esc_attr_e($input_border_radius); ?>" placeholder="<?php echo esc_html__( 'Enter input border radius', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Border Color</h4>
                   <input type="text" id="uacf7-uacf7style-input-border-color" name="uacf7_uacf7style_input_border_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($input_border_color); ?>" placeholder="<?php echo esc_html__( 'Enter input border color', 'ultimate-addons-cf7' ); ?>">
               </div>
               <div class="clear"></div>
            </div>
                
                <div class="clear"></div>
                
            <div class="ultimate-uacf7style-wrapper">
                <h3>Submit Button Options</h3>
                <div class="uacf7style-fourcolumns">
                   <h4>Color</h4>
                   <input type="text" id="uacf7-uacf7style-btn-color" name="uacf7_uacf7style_btn_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_color); ?>" placeholder="<?php echo esc_html__( 'Enter Button Color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Color (hover)</h4>
                  <input type="text" id="uacf7-uacf7style-btn-color-hover" name="uacf7_uacf7style_btn_color_hover" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_color_hover); ?>" placeholder="<?php echo esc_html__( 'Enter Button Color hover', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4>Background Color</h4>
                   <input type="text" id="uacf7-uacf7style-btn-background-color" name="uacf7_uacf7style_btn_background_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_background_color); ?>" placeholder="<?php echo esc_html__( 'Enter Button Background Color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Background Color (Hover)</h4>
                   <input type="text" id="uacf7-uacf7style-btn-background-color-hover" name="uacf7_uacf7style_btn_background_color_hover" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_background_color_hover); ?>" placeholder="<?php echo esc_html__( 'Enter Button Background Color hover', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Font Size (in px)</h4>
                   <input type="number" id="uacf7-uacf7style-btn-font-size" name="uacf7_uacf7style_btn_font_size" class="large-text" value="<?php echo esc_attr_e($btn_font_size); ?>" placeholder="<?php echo esc_html__( 'Enter Button Font Size', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Font Style</h4>
                   <select name="uacf7_uacf7style_btn_font_style" id="uacf7-uacf7style-btn-font-style">
                        <option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($btn_font_style), true ); ?>><?php echo esc_html('Normal'); ?></option>
                    	<option value="<?php esc_attr_e('italic'); ?>" <?php selected( 'italic', esc_attr($btn_font_style), true ); ?> ><?php echo esc_html('Italic'); ?></option>
                    </select>
               </div>
                <div class="uacf7style-fourcolumns">
                   <h4>Font Weight</h4>
                   <select name="uacf7_uacf7style_btn_font_weight" id="uacf7-uacf7style-btn-font_weight">
                    	<option value="<?php esc_attr_e('normal'); ?>" <?php selected( 'normal', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('Normal / 400'); ?></option>
                    	<option value="<?php esc_attr_e('300'); ?>" <?php selected( '300', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('300'); ?></option>
                    	<option value="<?php esc_attr_e('500'); ?>" <?php selected( '500', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('500'); ?></option>
                    	<option value="<?php esc_attr_e('700'); ?>" <?php selected( '700', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('700'); ?></option>
                    	<option value="<?php esc_attr_e('900'); ?>" <?php selected( '900', esc_attr($btn_font_weight), true ); ?>><?php echo esc_html('900'); ?></option>
                    </select>
               </div>
               <div class="uacf7style-fourcolumns">
                   <h4>Width (in px or %)</h4>
                   <input type="text" id="uacf7-uacf7style-btn-width" name="uacf7_uacf7style_btn_width" class="large-text" value="<?php echo esc_attr_e($btn_width); ?>" placeholder="<?php echo esc_html__( 'Enter Button width', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>100px or 100%</span>.</small><br><br>
               </div>
               <div class="clear"></div>
               <div class="uacf7style-fivecolumns">
                   <h4>Border Width (in px)</h4>
                   <input type="number" id="uacf7-uacf7style-btn-border-width" name="uacf7_uacf7style_btn_border_width" class="large-text" value="<?php echo esc_attr_e($btn_border_width); ?>" placeholder="<?php echo esc_html__( 'Enter Button border width', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
               <div class="uacf7style-fivecolumns">
                   <h4>Border Style</h4>
                   <select name="uacf7_uacf7style_btn_border_style" id="uacf7-uacf7style-btn-border-style">
                    	<option value="<?php esc_attr_e('none'); ?>" <?php selected( 'none', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('None'); ?></option>
                    	<option value="<?php esc_attr_e('dotted'); ?>" <?php selected( 'dotted', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('Dotted'); ?></option>
                    	<option value="<?php esc_attr_e('dashed'); ?>" <?php selected( 'dashed', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('Dashed'); ?></option>
                    	<option value="<?php esc_attr_e('solid'); ?>" <?php selected( 'solid', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('Solid'); ?></option>
                    	<option value="<?php esc_attr_e('double'); ?>" <?php selected( 'double', esc_attr($btn_border_style), true ); ?>><?php echo esc_html('Double'); ?></option>
                    </select>
               </div>
                <div class="uacf7style-fivecolumns">
                   <h4>Border Radius (in px)</h4>
                   <input type="number" id="uacf7-uacf7style-btn-border-radius" name="uacf7_uacf7style_btn_border_radius" class="large-text" value="<?php echo esc_attr_e($btn_border_radius); ?>" placeholder="<?php echo esc_html__( 'Enter Button border radius', 'ultimate-addons-cf7' ); ?>"><small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
               <div class="uacf7style-fivecolumns">
                   <h4>Border Color</h4>
                   <input type="text" id="uacf7-uacf7style-btn-border-color" name="uacf7_uacf7style_btn_border_color" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_border_color); ?>" placeholder="<?php echo esc_html__( 'Enter Button border color', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="uacf7style-fivecolumns">
                   <h4>Border Color (Hover)</h4>
                   <input type="text" id="uacf7-uacf7style-btn-border-color-hover" name="uacf7_uacf7style_btn_border_color_hover" class="uacf7-color-picker" value="<?php echo esc_attr_e($btn_border_color_hover); ?>" placeholder="<?php echo esc_html__( 'Enter Button border color hover', 'ultimate-addons-cf7' ); ?>"><br><br>
               </div>
               <div class="clear"></div>
               <div class="uacf7style-columns">
                   <h4>Padding (in px)</h4>
                   <div class="four-input">
                       <input type="number" id="uacf7-uacf7style-btn-padding-top" name="uacf7_uacf7style_btn_padding_top" class="large-text" value="<?php echo esc_attr_e($btn_padding_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-padding-right" name="uacf7_uacf7style_btn_padding_right" class="large-text" value="<?php echo esc_attr_e($btn_padding_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-padding-bottom" name="uacf7_uacf7style_btn_padding_bottom" class="large-text" value="<?php echo esc_attr_e($btn_padding_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-padding-left" name="uacf7_uacf7style_btn_padding_left" class="large-text" value="<?php echo esc_attr_e($btn_padding_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                    </div>
                    <small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
                <div class="uacf7style-columns">
                   <h4>Margin (in px)</h4>
                   <div class="four-input">
                       <input type="number" id="uacf7-uacf7style-btn-margin-top" name="uacf7_uacf7style_btn_margin_top" class="large-text" value="<?php echo esc_attr_e($btn_margin_top); ?>" placeholder="<?php echo esc_html__( 'Top', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-margin-right" name="uacf7_uacf7style_btn_margin_right" class="large-text" value="<?php echo esc_attr_e($btn_margin_right); ?>" placeholder="<?php echo esc_html__( 'Right', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-margin-bottom" name="uacf7_uacf7style_btn_margin_bottom" class="large-text" value="<?php echo esc_attr_e($btn_margin_bottom); ?>" placeholder="<?php echo esc_html__( 'Bottom', 'ultimate-addons-cf7' ); ?>">
                       <input type="number" id="uacf7-uacf7style-btn-margin-left" name="uacf7_uacf7style_btn_margin_left" class="large-text" value="<?php echo esc_attr_e($btn_margin_left); ?>" placeholder="<?php echo esc_html__( 'Left', 'ultimate-addons-cf7' ); ?>">
                   </div>
                   <small>E.g. <span>16</span> (Do not add px or em ).</small><br><br>
               </div>
               <div class="clear"></div>
            </div>
                  
                   <div class="clear"></div>
            <div class="ultimate-uacf7style-wrapper">
                <h3>Custom CSS Option</h3>
               <input type="text" id="uacf7-customcss" name="uacf7_uacf7style_ua_custom_css" class="large-text" value="<?php echo esc_attr_e($ua_custom_css); ?>" placeholder="<?php echo esc_html__( 'Enter Your Custom CSS', 'ultimate-addons-cf7' ); ?>">
               <div class="clear"></div>
            </div>
                
               <div class="clear"></div>
                <p>Need more options? Let us know <a href="https://themefic.com/contact/" target="_blank">here</a>.</p>
           </div>
        <?php
         wp_nonce_field( 'uacf7_uacf7style_nonce_action', 'uacf7_uacf7style_nonce' );
    }
    
    public function uacf7_save_contact_form( $form ) {
        
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        if ( ! wp_verify_nonce( $_POST['uacf7_uacf7style_nonce'], 'uacf7_uacf7style_nonce_action' ) ) {
            return;
        }

        update_post_meta( $form->id(), 'uacf7_uacf7style_label_color', $_POST['uacf7_uacf7style_label_color'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_background_color', $_POST['uacf7_uacf7style_label_background_color'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_font_size', $_POST['uacf7_uacf7style_label_font_size'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_font_family', $_POST['uacf7_uacf7style_label_font_family'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_font_style', $_POST['uacf7_uacf7style_label_font_style'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_font_weight', $_POST['uacf7_uacf7style_label_font_weight'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_padding_top', $_POST['uacf7_uacf7style_label_padding_top'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_padding_right', $_POST['uacf7_uacf7style_label_padding_right'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_padding_bottom', $_POST['uacf7_uacf7style_label_padding_bottom'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_padding_left', $_POST['uacf7_uacf7style_label_padding_left'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_margin_top', $_POST['uacf7_uacf7style_label_margin_top'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_margin_right', $_POST['uacf7_uacf7style_label_margin_right'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_margin_bottom', $_POST['uacf7_uacf7style_label_margin_bottom'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_label_margin_left', $_POST['uacf7_uacf7style_label_margin_left'] );
        
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_color', $_POST['uacf7_uacf7style_input_color'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_background_color', $_POST['uacf7_uacf7style_input_background_color'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_font_size', $_POST['uacf7_uacf7style_input_font_size'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_font_family', $_POST['uacf7_uacf7style_input_font_family'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_font_style', $_POST['uacf7_uacf7style_input_font_style'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_font_weight', $_POST['uacf7_uacf7style_input_font_weight'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_height', $_POST['uacf7_uacf7style_input_height'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_border_width', $_POST['uacf7_uacf7style_input_border_width'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_border_color', $_POST['uacf7_uacf7style_input_border_color'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_border_style', $_POST['uacf7_uacf7style_input_border_style'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_border_radius', $_POST['uacf7_uacf7style_input_border_radius'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_textarea_input_height', $_POST['uacf7_uacf7style_textarea_input_height'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_padding_top', $_POST['uacf7_uacf7style_input_padding_top'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_padding_right', $_POST['uacf7_uacf7style_input_padding_right'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_padding_bottom', $_POST['uacf7_uacf7style_input_padding_bottom'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_padding_left', $_POST['uacf7_uacf7style_input_padding_left'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_margin_top', $_POST['uacf7_uacf7style_input_margin_top'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_margin_right', $_POST['uacf7_uacf7style_input_margin_right'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_margin_bottom', $_POST['uacf7_uacf7style_input_margin_bottom'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_input_margin_left', $_POST['uacf7_uacf7style_input_margin_left'] );
        
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_color', $_POST['uacf7_uacf7style_btn_color'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_background_color', $_POST['uacf7_uacf7style_btn_background_color'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_font_size', $_POST['uacf7_uacf7style_btn_font_size'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_font_style', $_POST['uacf7_uacf7style_btn_font_style'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_font_weight', $_POST['uacf7_uacf7style_btn_font_weight'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_width', $_POST['uacf7_uacf7style_btn_border_width'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_color', $_POST['uacf7_uacf7style_btn_border_color'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_style', $_POST['uacf7_uacf7style_btn_border_style'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_radius', $_POST['uacf7_uacf7style_btn_border_radius'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_width', $_POST['uacf7_uacf7style_btn_width'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_color_hover', $_POST['uacf7_uacf7style_btn_color_hover'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_background_color_hover', $_POST['uacf7_uacf7style_btn_background_color_hover'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_border_color_hover', $_POST['uacf7_uacf7style_btn_border_color_hover'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_padding_top', $_POST['uacf7_uacf7style_btn_padding_top'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_padding_right', $_POST['uacf7_uacf7style_btn_padding_right'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_padding_bottom', $_POST['uacf7_uacf7style_btn_padding_bottom'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_padding_left', $_POST['uacf7_uacf7style_btn_padding_left'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_margin_top', $_POST['uacf7_uacf7style_btn_margin_top'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_margin_right', $_POST['uacf7_uacf7style_btn_margin_right'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_margin_bottom', $_POST['uacf7_uacf7style_btn_margin_bottom'] );
        update_post_meta( $form->id(), 'uacf7_uacf7style_btn_margin_left', $_POST['uacf7_uacf7style_btn_margin_left'] );
        
        update_post_meta( $form->id(), 'uacf7_uacf7style_ua_custom_css', $_POST['uacf7_uacf7style_ua_custom_css'] );
    }
    
    public function uacf7_properties($properties, $cfform) {
	
        if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) { 

            $form = $properties['form'];

            ob_start();

            $label_color = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_color', true );
            $label_background_color = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_background_color', true );
            $label_font_size = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_font_size', true );
            $label_font_family = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_font_family', true );
            $label_font_style = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_font_style', true );
            $label_font_weight = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_font_weight', true );
            $label_padding_top = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_padding_top', true );
            $label_padding_right = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_padding_right', true );
            $label_padding_bottom = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_padding_bottom', true );
            $label_padding_left = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_padding_left', true );
            $label_margin_top = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_margin_top', true );
            $label_margin_right = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_margin_right', true );
            $label_margin_bottom = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_margin_bottom', true );
            $label_margin_left = get_post_meta( $cfform->id(), 'uacf7_uacf7style_label_margin_left', true );
            
            $input_color = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_color', true );
            $input_background_color = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_background_color', true );
            $input_font_size = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_font_size', true );
            $input_font_family = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_font_family', true );
            $input_font_style = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_font_style', true );
            $input_font_weight = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_font_weight', true );
            $input_height = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_height', true );
            $input_border_width = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_border_width', true );
            $input_border_color = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_border_color', true );
            $input_border_style = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_border_style', true );
            $input_border_radius = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_border_radius', true );
            $textarea_input_height = get_post_meta( $cfform->id(), 'uacf7_uacf7style_textarea_input_height', true );
            $input_padding_top = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_padding_top', true );
            $input_padding_right = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_padding_right', true );
            $input_padding_bottom = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_padding_bottom', true );
            $input_padding_left = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_padding_left', true );
            $input_margin_top = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_margin_top', true );
            $input_margin_right = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_margin_right', true );
            $input_margin_bottom = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_margin_bottom', true );
            $input_margin_left = get_post_meta( $cfform->id(), 'uacf7_uacf7style_input_margin_left', true );
            
            $btn_color = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_color', true );
            $btn_background_color = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_background_color', true );
            $btn_font_size = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_font_size', true );
            $btn_font_style = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_font_style', true );
            $btn_font_weight = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_font_weight', true );
            $btn_width = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_width', true );
            $btn_border_color = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_border_color', true );
            $btn_border_style = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_border_style', true );
            $btn_border_radius = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_border_radius', true );
            $btn_border_width = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_border_width', true );
            $btn_color_hover = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_color_hover', true );
            $btn_background_color_hover = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_background_color_hover', true );
            $btn_border_color_hover = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_border_color_hover', true );
            $btn_padding_top = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_padding_top', true );
            $btn_padding_right = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_padding_right', true );
            $btn_padding_bottom = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_padding_bottom', true );
            $btn_padding_left = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_padding_left', true );
            $btn_margin_top = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_margin_top', true );
            $btn_margin_right = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_margin_right', true );
            $btn_margin_bottom = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_margin_bottom', true );
            $btn_margin_left = get_post_meta( $cfform->id(), 'uacf7_uacf7style_btn_margin_left', true );
            
            $ua_custom_css = get_post_meta( $cfform->id(), 'uacf7_uacf7style_ua_custom_css', true );
            ?>
            <style>
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> label {
                    color: <?php echo esc_attr_e($label_color); ?>;
                    background-color: <?php echo esc_attr_e($label_background_color); ?>;
                    font-size: <?php echo esc_attr_e($label_font_size).'px'; ?>;
                    font-family: <?php echo esc_attr_e($label_font_family); ?>;
                    font-style: <?php echo esc_attr_e($label_font_style); ?>;
                    font-weight: <?php echo esc_attr_e($label_font_weight); ?>;
                    padding-top: <?php echo esc_attr_e($label_padding_top).'px'; ?>;
                    padding-right: <?php echo esc_attr_e($label_padding_right).'px'; ?>;
                    padding-bottom: <?php echo esc_attr_e($label_padding_bottom).'px'; ?>;
                    padding-left: <?php echo esc_attr_e($label_padding_left).'px'; ?>;
                    margin-top: <?php echo esc_attr_e($label_margin_top).'px'; ?>;
                    margin-right: <?php echo esc_attr_e($label_margin_right).'px'; ?>;
                    margin-bottom: <?php echo esc_attr_e($label_margin_bottom).'px'; ?>;
                    margin-left: <?php echo esc_attr_e($label_margin_left).'px'; ?>;
                }
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="email"],
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="number"],
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="password"],
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="search"],
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="tel"],
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="text"],
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="url"],
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="date"],
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> select,
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> textarea {
                    color: <?php echo esc_attr_e($input_color); ?>;
                    background-color: <?php echo esc_attr_e($input_background_color); ?>;
                    font-size: <?php echo esc_attr_e($input_font_size).'px'; ?>;
                    font-family: <?php echo esc_attr_e($input_font_family); ?>;
                    font-style: <?php echo esc_attr_e($input_font_style); ?>;
                    font-weight: <?php echo esc_attr_e($input_font_weight); ?>;
                    height: <?php echo esc_attr_e($input_height).'px'; ?>;
                    border-width: <?php echo esc_attr_e($input_border_width).'px'; ?>;
                    border-color: <?php echo esc_attr_e($input_border_color); ?>;
                    border-style: <?php echo esc_attr_e($input_border_style); ?>;
                    border-radius: <?php echo esc_attr_e($input_border_radius).'px'; ?>;
                    padding-top: <?php echo esc_attr_e($input_padding_top).'px'; ?>;
                    padding-right: <?php echo esc_attr_e($input_padding_right).'px'; ?>;
                    padding-bottom: <?php echo esc_attr_e($input_padding_bottom).'px'; ?>;
                    padding-left: <?php echo esc_attr_e($input_padding_left).'px'; ?>;
                    margin-top: <?php echo esc_attr_e($input_margin_top).'px'; ?>;
                    margin-right: <?php echo esc_attr_e($input_margin_right).'px'; ?>;
                    margin-bottom: <?php echo esc_attr_e($input_margin_bottom).'px'; ?>;
                    margin-left: <?php echo esc_attr_e($input_margin_left).'px'; ?>;
                }
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> .wpcf7-radio span,
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> .wpcf7-checkbox span {
                    color: <?php echo esc_attr_e($input_color); ?>;
                    font-size: <?php echo esc_attr_e($input_font_size).'px'; ?>;
                    font-family: <?php echo esc_attr_e($input_font_family); ?>;
                    font-style: <?php echo esc_attr_e($input_font_style); ?>;
                    font-weight: <?php echo esc_attr_e($input_font_weight); ?>;
                }
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> textarea {
                    height: <?php echo esc_attr_e($textarea_input_height).'px'; ?>;
                }
                .wpcf7-form-control-wrap select {
                    width: 100%;
                }
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="submit"] {
                    color: <?php echo esc_attr_e($btn_color); ?>;
                    background-color: <?php echo esc_attr_e($btn_background_color); ?>;
                    font-size: <?php echo esc_attr_e($btn_font_size).'px'; ?>;
                    font-family: <?php echo esc_attr_e($input_font_family); ?>;
                    font-style: <?php echo esc_attr_e($btn_font_style); ?>;
                    font-weight: <?php echo esc_attr_e($btn_font_weight); ?>;
                    border-width: <?php echo esc_attr_e($btn_border_width).'px'; ?>;
                    border-color: <?php echo esc_attr_e($btn_border_color); ?>;
                    border-style: <?php echo esc_attr_e($btn_border_style); ?>;
                    border-radius: <?php echo esc_attr_e($btn_border_radius).'px'; ?>;
                    width: <?php echo esc_attr_e($btn_width); ?>;
                    padding-top: <?php echo esc_attr_e($btn_padding_top).'px'; ?>;
                    padding-right: <?php echo esc_attr_e($btn_padding_right).'px'; ?>;
                    padding-bottom: <?php echo esc_attr_e($btn_padding_bottom).'px'; ?>;
                    padding-left: <?php echo esc_attr_e($btn_padding_left).'px'; ?>;
                    margin-top: <?php echo esc_attr_e($btn_margin_top).'px'; ?>;
                    margin-right: <?php echo esc_attr_e($btn_margin_right).'px'; ?>;
                    margin-bottom: <?php echo esc_attr_e($btn_margin_bottom).'px'; ?>;
                    margin-left: <?php echo esc_attr_e($btn_margin_left).'px'; ?>;
                }
                .uacf7-uacf7style-<?php esc_attr_e( $cfform->id() ); ?> input[type="submit"]:hover {
                    color: <?php echo esc_attr_e($btn_color_hover); ?>;
                    background-color: <?php echo esc_attr_e($btn_background_color_hover); ?>;
                    border-color: <?php echo esc_attr_e($btn_border_color_hover); ?>;
                }
                <?php echo esc_attr_e($ua_custom_css); ?>
            </style>
            <?php
            echo '<div class="uacf7-uacf7style-'.$cfform->id().'">'.$form.'</div>';
            $properties['form'] = ob_get_clean();
        }

        return $properties;
    }
   
}
new UACF7_uacf7style();