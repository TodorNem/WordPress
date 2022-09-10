<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Pre Populate Classs
*/
class UACF7_PRE_POPULATE {
    
    /*
    * Construct function
    */
    public function __construct() {
        
        add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_script' ) );  
        add_action( 'admin_enqueue_scripts', array($this, 'wp_enqueue_admin_script' ) );  
        add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );
        add_action( 'wpcf7_after_save', array( $this, 'uacf7_bf_save_contact_form' ) ); 
        add_action( 'wp_ajax_uacf7_ajax_pre_populate_redirect', array( $this, 'uacf7_ajax_pre_populate_redirect' ) ); 
        add_action( 'wp_ajax_nopriv_uacf7_ajax_pre_populate_redirect', array( $this, 'uacf7_ajax_pre_populate_redirect' ) ); 

    
        
    } 

    /*
    * Enqueue script Forntend
    */
    
    public function wp_enqueue_script() {
		wp_enqueue_script( 'pre-populate-script', UACF7_ADDONS . '/pre-populate-field/assets/js/pre-populate.js', array('jquery'), null, true ); 
        wp_localize_script( 'pre-populate-script', 'pre_populate_url',
            array( 
                    'ajaxurl' => admin_url( 'admin-ajax.php' ),
                )
        );
    }

    /*
    * Enqueue script Backend
    */
    
    public function wp_enqueue_admin_script() {
        wp_enqueue_style( 'uacf7-multistep-style', UACF7_ADDONS . '/pre-populate-field/assets/css/admin-pre-populate.css' );
		wp_enqueue_script( 'admin-pre-populate', UACF7_ADDONS . '/pre-populate-field/assets/js/admin-pre-populate.js', array('jquery'), null, true ); 
    }
    
    /*
    * Pre-populate Tab Panel
    */
    
    public function uacf7_add_panel($panels){
        $panels['uacf7-pre-populate-panel'] = array(
            'title'    => __( 'UACF7 pre-populate Fields', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_pre_populate_panel_fields' ),
		);
		return $panels;
    }


    /*
    * Pre-populate Tab Panel Fields
    */

    public function uacf7_create_pre_populate_panel_fields( $post ) { 
        $form_current = \WPCF7_ContactForm::get_current();
         
        $all_fields = $post->scan_form_tags();
         
        $pre_populate_enable = !empty(get_post_meta( $post->id(), 'pre_populate_enable', true )) ? get_post_meta( $post->id(), 'pre_populate_enable', true ) : '';
        $data_redirect_url = !empty(get_post_meta( $post->id(), 'data_redirect_url', true )) ? get_post_meta( $post->id(), 'data_redirect_url', true ) : ''; 
        $pre_populate_passing_field = !empty(get_post_meta( $post->id(), 'pre_populate_passing_field', true )) ? get_post_meta( $post->id(), 'pre_populate_passing_field', true ) : []; 
        $pre_populate_form = !empty(get_post_meta( $post->id(), 'pre_populate_form', true )) ? get_post_meta( $post->id(), 'pre_populate_form', true ) : []; 
        $count_shifting = count($pre_populate_passing_field);
   
        $list_forms = get_posts(array(
            'post_type'     => 'wpcf7_contact_form',
            'posts_per_page'   => -1
        )); 
        ?>  
        <fieldset>
           <div class="ultimate-pre-populate-admin"> 
               <div class="main-block">
                    <div class="sub-block">
                        <label for="pre_populate_enable">
                        <h3><?php _e( 'Enable/Disable Pre-populate fields', 'ultimate-addons-cf7' ); ?></h3>
                        </label> 
                       
                        <label for="pre_populate_enable">
                            <input class="pre-populate" id="pre_populate_enable" name="pre_populate_enable" type="checkbox" value="1" <?php checked( '1', $pre_populate_enable, true ); ?>> <?php _e( 'Enable Pre-populate fields', 'ultimate-addons-cf7' ); ?>
                        </label> 
                        <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/pre-populate-fields/" target="_blank">documentation</a>.</div>
                        <?php if($pre_populate_enable != '' || $pre_populate_enable != 0): ?>
                       
                         
                        <div class="sub-block "> 
                            <h3><?php _e( 'Redirect URL', 'ultimate-addons-cf7' ); ?></h3> 
                            <label for="bf-enable">
                                <input class="data-redirect-url" id="data_redirect_url" name="data_redirect_url" type="input" value="<?php echo $data_redirect_url; ?>"> 
                            </label> 
                        </div> 
                        <div class="sub-block "> 
                            <label><h3><?php _e( 'Select Pre-populate form', 'ultimate-addons-cf7' ); ?></h3></label>  
                            <div class="pre_populate_field">
                                <div class="single_pre_populate_field_wrap">
                                    <div class="single_pre_populate_field_inner">
                                        <select name="pre_populate_form" id="pre_populate_form">
                                            <?php 
                                            foreach ($list_forms as $form) { 
                                                if($pre_populate_form == $form->ID){$selected = "selected"; }else{$selected = "";}
                                                echo '<option value="' . esc_attr($form->ID) . '" '.esc_attr($selected).'>' . esc_attr($form->post_title) . '</option>'; 
                                            }
                                            ?>
                                        </select>  
                                    </div>
                                </div> 
                                
                            </div>   
                        </div> 

                        <div class="sub-block "> 
                            <label><h3><?php _e( 'Select Pre-populate Field', 'ultimate-addons-cf7' ); ?></h3></label>   
                            <div class="pre_populate_field">
                                <div class="single_pre_populate_field_wrap" style="display: none !important;">
                                    <div class="single_pre_populate_field_inner">
                                        <select name="pre_populate_passing[]" id="pre_populate_passing_field">
                                            <?php 
                                            foreach ($all_fields as $tag) {
                                                if ($tag['type'] != 'submit') {
                                                    echo '<option value="' . esc_attr($tag['name']) . '" >' . esc_attr($tag['name']) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> 
                                        <span class="close" style="display: none !important;"><a class="uacf7-remove-data-shift button-primary" href="#" title="Remove">Remove Field</a></span>
                                    </div>
                                </div>
                                <?php  
                                    $count_sifting = count($pre_populate_passing_field);
                                    ?>
                                <div class="single_pre_populate_field_wrap_2"> 
                                <?php for( $i = 0; $i < $count_shifting; $i++ ) : ?>
                                    <div class="single_pre_populate_field_inner">
                                        
                                        <select name="pre_populate_passing_field[]" id="pre_populate_passing_field">
                                            <?php 
                                            $all_fields = $post->scan_form_tags();
                                            foreach ($all_fields as $tag) {
                                                if ($tag['type'] != 'submit') {
                                                    if($pre_populate_passing_field[$i] == $tag['name']){$selected = "selected"; }else{$selected = "";}
                                                    echo '<option value="' . esc_attr($tag['name']) . '" ' . esc_attr($selected) . '>' . esc_attr($tag['name']) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> 
                                        <span class="close" style=""><a class="uacf7-remove-data-shift button-primary" href="#" title="Remove">Remove Field</a></span>
                                    </div>
                                <?php endfor; ?>
                                </div>
                                
                            </div>  
                            <br>
                            <a class="uacf7-add-data-shift button-primary" href="#" title="Add">Add Field</a>
                        </div> 
                        <?php endif; ?>
                    </div>
                </div>
            </div> 
        </fieldset> 
        <?php 
         wp_nonce_field( 'uacf7_pre_populate_nonce_action', 'uacf7_pre_populate_nonce' );
    }
    
    
    /*
    * Form Save Meta Data
    */

    public function uacf7_bf_save_contact_form($post){
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
            return;
        }
        
        if ( !wp_verify_nonce( $_POST['uacf7_pre_populate_nonce'], 'uacf7_pre_populate_nonce_action' ) ) {
            return;
        }

        // Event Calendar
        update_post_meta( $post->id(), 'pre_populate_enable', $_POST['pre_populate_enable'] );
        update_post_meta( $post->id(), 'data_redirect_url', $_POST['data_redirect_url'] ); 
        update_post_meta( $post->id(), 'pre_populate_form', $_POST['pre_populate_form'] ); 

        $filed_values = array();
        foreach( $_POST['pre_populate_passing_field'] as $filed_value ) {
            $filed_values[] = sanitize_text_field( $filed_value );
        }
        update_post_meta( $post->id(), 'pre_populate_passing_field', $filed_values );

    }
 
 
    /*
    * Product Pre-populate redirect with value after submiting form by ajax
    */
    
    public function uacf7_ajax_pre_populate_redirect() { 

        $form_id = $_POST['form_id']; 
        $pre_populate_enable = get_post_meta( $form_id, 'pre_populate_enable', true ); 
        if($pre_populate_enable != '' || $pre_populate_enable != 0){
            $data_redirect_url = get_post_meta( $form_id, 'data_redirect_url', true );
            $pre_populate_passing_field = get_post_meta( $form_id, 'pre_populate_passing_field', true );
            $pre_populate_form = get_post_meta( $form_id, 'pre_populate_form', true );

            $data = [
                'form_id' => $form_id,
                'pre_populate_enable' => $pre_populate_enable,
                'data_redirect_url' => $data_redirect_url,
                'pre_populate_passing_field' => $pre_populate_passing_field,
                'pre_populate_form' => $pre_populate_form,
            ];
            
            echo json_encode($data);
        }else{
            echo false;
        }  
        wp_die();
    }
   
}
new UACF7_PRE_POPULATE();