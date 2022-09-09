<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_MULTISTEP {
    
    private $hidden_fields = array();
    
    /*
    * Construct function
    */
    public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
        add_action( 'admin_init', array( $this, 'tag_generator' ) );        
        add_action( 'wp_ajax_check_fields_validation', array( $this, 'check_fields_validation' ) );
        add_action( 'wp_ajax_nopriv_check_fields_validation', array( $this, 'check_fields_validation' ) );
        wpcf7_add_form_tag( 'uacf7_step_start', array( $this, 'step_start_tag_handler' ), true );
        wpcf7_add_form_tag( 'uacf7_step_end', array( $this, 'step_end_tag_handler' ), true );
        wpcf7_add_form_tag( 'uacf7_multistep_progressbar', array( $this, 'uacf7_multistep_progressbar' ), true );
        add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );
        add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_contact_form' ) );
        add_filter( 'wpcf7_contact_form_properties', array( $this, 'uacf7_properties' ), 10, 2 );
        
    }
    
    public function enqueue_script() {
        wp_enqueue_script( 'uacf7-multistep', UACF7_ADDONS . '/multistep/assets/js/multistep.js', array('jquery'), null, true );
        wp_enqueue_script( 'uacf7-progressbar', UACF7_ADDONS . '/multistep/assets/js/progressbar.js', array('jquery'), null, true );
        wp_enqueue_style( 'uacf7-multistep-style', UACF7_ADDONS . '/multistep/assets/css/multistep.css' );

        
        wp_localize_script('uacf7-multistep', 'uacf7_multistep_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'), 
        'nonce' => wp_create_nonce('uacf7-multistep') ));
    }
    
    function step_start_tag_handler($tag){
        ob_start();
        ?>
        <div class="uacf7-step step-content" next-btn-text="<?php echo esc_html( get_option('next_btn_'.$tag->name) ); ?>" prev-btn-text="<?php echo esc_html( get_option('prev_btn_'.$tag->name) ); ?>">
        <?php
        return ob_get_clean();
    }
    
    function step_end_tag_handler($tag){
        ob_start();
        $form_current = \WPCF7_ContactForm::get_current();
        ?>
        <p>
        	<button class="uacf7-prev"><?php echo esc_html__('Previous', 'ultimate-addons-cf7'); ?></button>
			<button class="uacf7-next"><?php echo esc_html__('Next', 'ultimate-addons-cf7'); ?></button>
			<span class="wpcf7-spinner uacf7-ajax-loader"></span>
        </p>
        </div>
        <?php
        return ob_get_clean();
    }
	
    function uacf7_multistep_progressbar($tag){
        ob_start();
		$form_current = \WPCF7_ContactForm::get_current();
		
		$all_steps = get_post_meta( $form_current->id(), 'uacf7_multistep_steps_title', true );
        ?>
        <div class="uacf7-steps steps-form">
			<div class="steps-row setup-panel">
			<?php
				$step_id = 1;
				$step_count = 0;

				$step_name = get_post_meta( $form_current->id(), 'uacf7_multistep_steps_names', true );
				
				$uacf7_multistep_use_step_labels = !empty(get_post_meta( $form_current->id(), 'uacf7_multistep_use_step_labels', true )) ? get_post_meta( $form_current->id(), 'uacf7_multistep_use_step_labels', true ) : ''; 
		        
				foreach ($all_steps as $step) {
					$content = $step;
					?>
					<div class="steps-step"><a href="#step-<?php echo esc_attr($step_id); ?>" type="button" class="btn <?php if( $step_id == 1 ) { echo esc_attr('uacf7-btn-active'); }else{ echo esc_attr('uacf7-btn-default'); } ?> btn-circle"><?php 
					if(is_array($step_name)) {
						do_action( 'uacf7_progressbar_image', $step_name[$step_count] );
					}
					echo apply_filters( 'uacf7_progressbar_step', esc_attr($step_id), $uacf7_multistep_use_step_labels, $content ); ?></a><p><?php if( $uacf7_multistep_use_step_labels != 'on' ) { echo $content; } ?></p></div>
					<?php
					$step_id++;
					$step_count++;
				}

				?>
			</div>
		</div>
        <?php
        return ob_get_clean();
    }

    /*
    * Generate tag
    */
    public function tag_generator() {
        if (! function_exists('wpcf7_add_tag_generator'))
            return;

        wpcf7_add_tag_generator('uacf7_step_start',
            __('Multistep Start', 'ultimate-addons-cf7'),
            'uacf7-tg-pane-step',
            array($this, 'tg_pane_step_start')
        );

        wpcf7_add_tag_generator('uacf7_step_end',
            __('Multistep end', 'ultimate-addons-cf7'),
            'wpcf7-tg-pane-step-end',
            array($this, 'tg_pane_step_end')
        );

    }
    
    static function tg_pane_step_start( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $uacf7_field_type = 'uacf7_step_start';
        ?>
        <div class="control-box">
            <fieldset>
                <legend><?php echo esc_html__( "Generate tag: Step", "ultimate-addons-cf7" ); ?></legend>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label><?php echo esc_html( __( 'Label', 'ultimate-addons-cf7' ) ); ?></label></th>
                            <td>
                               <input type="text" name="values" class="oneline"> 
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label><?php echo esc_html( __( 'Name', 'ultimate-addons-cf7' ) ); ?></label></th>
                            <td>
                               <input type="text" name="name" class="tg-name oneline" id="tag-generator-panel-text-name"> 
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="uacf7-doc-notice uacf7-guide">You need to enable the form from the "UACF7 Multistep Form" tab. The tab also includes additional necessary settings. Make sure you set those, otherwise the form submission may not work correctly.</div>
                <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/multi-step-form/" target="_blank">documentation</a>.</div>
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
    
    
    static function tg_pane_step_end( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $uacf7_field_type = 'uacf7_step_end';
        ?>
        <div class="control-box">
            <fieldset>
                <legend><?php echo esc_html__( "Multistep end", "ultimate-addons-cf7" ); ?></legend>
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
    
    /*
    * Function create tab panel
    */
    public function uacf7_add_panel( $panels ) {
		$panels['uacf7-multistep-panel'] = array(
            'title'    => __( 'UACF7 Multistep Form', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_multistep_panel_fields' ),
		);
		return $panels;
	}
    
    public function uacf7_create_multistep_panel_fields( $post ) {
        $form_current = \WPCF7_ContactForm::get_current();
        
        $all_steps = $form_current->scan_form_tags( array('type'=>'uacf7_step_start') );
        ?>
        <fieldset>
           <div class="ultimate-multistep-admin">
               <div class="ultimate-multistep-wrapper">
                  <?php
                    $uacf7_is_multistep = get_post_meta( $post->id(), 'uacf7_multistep_is_multistep', true );
        
                    $uacf7_enable_multistep_progressbar = get_post_meta( $post->id(), 'uacf7_enable_multistep_progressbar', true );
                    $uacf7_enable_multistep_scroll = get_post_meta( $post->id(), 'uacf7_enable_multistep_scroll', true );
                   ?>
                   <div class="multistep_fields_row">
                       <h3>Is It Multistep Form?</h3>
                       <label for="uacf7_multistep_is_multistep">
                           <input id="uacf7_multistep_is_multistep" type="checkbox" name="uacf7_multistep_is_multistep" <?php checked( 'on', $uacf7_is_multistep ); ?>> Yes
                       </label>
                       <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/multi-step-form/" target="_blank">documentation</a>.</div>
                   </div>
                   <?php if( !empty(array_filter($all_steps)) ) { ?>
                   
                   <div class="multistep_fields_row">
                       <h3>Multistep Progressbar</h3>
                       <label for="uacf7_enable_multistep_progressbar">
                           <input id="uacf7_enable_multistep_progressbar" type="checkbox" name="uacf7_enable_multistep_progressbar" <?php checked( 'on', $uacf7_enable_multistep_progressbar ); ?>> Enable
                       </label>
                   </div>
                   <!-- Pro Scroll To Top Feature -->
                   <?php ob_start(); ?>
                   <div class="multistep_fields_row">
                       <h3>Form Auto Scrolling <a style="color:red" target="_blank" href="https://cf7addons.com/preview/pro">(Pro)</a></h3>
                       <label for="uacf7_enable_multistep_scroll">
                           <input id="uacf7_enable_multistep_scroll" type="checkbox"> Enable 
                       </label>
                       <p>Auto scroll to top after clicking on the next button</p>
                   
                   </div>
                   <?php 
                    $scroll_to_top = ob_get_clean();
                    echo apply_filters( 'uacf7_multistep_scroll_to_top_field', $scroll_to_top, $uacf7_enable_multistep_scroll);
                   ?>
                   <!-- Pro Scroll To Top Feature -->
                   <!--Pro style-->
                   <?php $uacf7_progressbar_style = get_post_meta( $post->id(), 'uacf7_progressbar_style', true ); ?>
                   <div class="multistep_fields_row">
                       <h3>Progressbar Layout (Multistep Skins)</h3>
                       <select name="uacf7_progressbar_style" id="uacf7_progressbar_style">
                       		<option value="default" <?php selected( $uacf7_progressbar_style, 'default', true ); ?>>Default</option>
                       		<option value="style-1" <?php selected( $uacf7_progressbar_style, 'style-1', true ); ?>>Style 1</option>
                       		<?php 
                       		$option  = '<option value="style-2">Style 2(Pro)</option>'; 
                       		$option .= '<option value="style-3">Style 3(Pro)</option>';
                       		$option .= '<option value="style-4">Style 4(Pro)</option>';
                       		$option .= '<option value="style-5">Style 5(Pro)</option>';
                       		$option .= '<option value="style-6">Style 6(Pro)</option>';
                       		?>
                       		<?php echo apply_filters( 'uacf7_multistep_progressbar_style', $option, $uacf7_progressbar_style ); ?>
                       </select>
                       <p><strong>See live demo examples here:</strong> <a target="_blank" href="https://cf7addons.com/preview/multi-step-form/pro/">Live demo.</a> Check our step by step <a target="_blank" href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/premium-skins/">documentation.</a></p>
                   </div>
                   
                   <?php
				   $uacf7_multistep_use_step_labels = !empty(get_post_meta( $post->id(), 'uacf7_multistep_use_step_labels', true )) ? get_post_meta( $post->id(), 'uacf7_multistep_use_step_labels', true ) : '';
				   ?>
                   
                   <div class="multistep_fields_row">
						<h3>Hide Progressbar labels</h3>
						<label for="uacf7_multistep_use_step_labels">  
						   <input id="uacf7_multistep_use_step_labels" type="checkbox" name="uacf7_multistep_use_step_labels" <?php checked( 'on', $uacf7_multistep_use_step_labels ); ?> > Yes
				   		</label>
				   </div>
                   
                   <?php
					$uacf7_multistep_circle_width = get_post_meta( $post->id(), 'uacf7_multistep_circle_width', true ); 
					$uacf7_multistep_circle_height = get_post_meta( $post->id(), 'uacf7_multistep_circle_height', true ); 
					$uacf7_multistep_circle_bg_color = get_post_meta( $post->id(), 'uacf7_multistep_circle_bg_color', true ); 
					$uacf7_multistep_circle_font_color = get_post_meta( $post->id(), 'uacf7_multistep_circle_font_color', true ); 
					$uacf7_multistep_circle_border_radious = get_post_meta( $post->id(), 'uacf7_multistep_circle_border_radious', true ); 
					$uacf7_multistep_font_size = get_post_meta( $post->id(), 'uacf7_multistep_font_size', true ); 
					$uacf7_multistep_progress_bg_color = get_post_meta( $post->id(), 'uacf7_multistep_progress_bg_color', true );
					$uacf7_multistep_progress_line_color = get_post_meta( $post->id(), 'uacf7_multistep_progress_line_color', true );
					$uacf7_multistep_step_description_color = get_post_meta( $post->id(), 'uacf7_multistep_step_description_color', true );
					$uacf7_multistep_step_title_color = get_post_meta( $post->id(), 'uacf7_multistep_step_title_color', true );
					$uacf7_multistep_circle_active_color = get_post_meta( $post->id(), 'uacf7_multistep_circle_active_color', true );
					$uacf7_multistep_progressbar_title_color = get_post_meta( $post->id(), 'uacf7_multistep_progressbar_title_color', true );
					$uacf7_multistep_step_height = get_post_meta( $post->id(), 'uacf7_multistep_step_height', true );
					?>
					<div class="multistep_fields_row col-25">
						<h3>Progressbar Style</h3>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_circle_width">
								<p>Circle Width (px)</p>
								<input id="uacf7_multistep_circle_width" type="number" name="uacf7_multistep_circle_width" min="0" max="300" value="<?php echo esc_attr($uacf7_multistep_circle_width); ?>">
							</label>
						</div>

						<div class="multistep_field_column">
							<label for="uacf7_multistep_circle_height">
								<p>Circle Height (px)</p>
								<input id="uacf7_multistep_circle_height" type="number" name="uacf7_multistep_circle_height" min="0" max="300" value="<?php echo esc_attr($uacf7_multistep_circle_height); ?>">
							</label>
						</div>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_circle_bg_color"><p>Circle Background Color</p></label>
							<input id="uacf7_multistep_circle_bg_color" class="uacf7-color-picker" type="text" name="uacf7_multistep_circle_bg_color" value="<?php echo esc_attr($uacf7_multistep_circle_bg_color); ?>">
						</div>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_circle_active_color"><p>Circle Active Color</p></label>
							<input id="uacf7_multistep_circle_active_color" class="uacf7-color-picker" type="text" name="uacf7_multistep_circle_active_color" value="<?php echo esc_attr($uacf7_multistep_circle_active_color); ?>">
						</div>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_circle_font_color"><p>Circle Font Color</p></label>
							<input id="uacf7_multistep_circle_font_color" class="uacf7-color-picker" type="text" name="uacf7_multistep_circle_font_color" value="<?php echo esc_attr($uacf7_multistep_circle_font_color); ?>">
						</div>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_circle_border_radious">
								<p>Circle Border Radious (px)</p>
								<input id="uacf7_multistep_circle_border_radious" type="number" name="uacf7_multistep_circle_border_radious" min="0" max="50" value="<?php echo esc_attr($uacf7_multistep_circle_border_radious); ?>">
							</label>
						</div>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_font_size">
								<p>Font Size (px)</p>
								<input id="uacf7_multistep_font_size" type="number" name="uacf7_multistep_font_size" min="0" value="<?php echo esc_attr($uacf7_multistep_font_size); ?>">
							</label>
						</div>
						<div class="multistep_field_column show-if-left-progressbar">
							<label for="uacf7_multistep_progress_bg_color"><p>Progressbar Background Color</p></label>
							<input id="uacf7_multistep_progress_bg_color" class="uacf7-color-picker" type="text" name="uacf7_multistep_progress_bg_color" value="<?php echo esc_attr($uacf7_multistep_progress_bg_color); ?>">
						</div>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_progress_line_color"><p>Progressbar Line Color</p></label>
							<input id="uacf7_multistep_progress_line_color" class="uacf7-color-picker" type="text" name="uacf7_multistep_progress_line_color" value="<?php echo esc_attr($uacf7_multistep_progress_line_color); ?>">
						</div>
						<div class="multistep_field_column show-if-pro">
							<label for="uacf7_multistep_step_title_color"><p>Step Title Color</p></label>
							<input id="uacf7_multistep_step_title_color" class="uacf7-color-picker" type="text" name="uacf7_multistep_step_title_color" value="<?php echo esc_attr($uacf7_multistep_step_title_color); ?>">
						</div>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_progressbar_title_color"><p>Progressbar Title Color</p></label>
							<input id="uacf7_multistep_progressbar_title_color" class="uacf7-color-picker" type="text" name="uacf7_multistep_progressbar_title_color" value="<?php echo esc_attr($uacf7_multistep_progressbar_title_color); ?>">
						</div>
						<div class="multistep_field_column show-if-style-6">
							<label for="uacf7_multistep_step_description_color"><p>Progressbar Description Color</p></label>
							<input id="uacf7_multistep_step_description_color" class="uacf7-color-picker" type="text" name="uacf7_multistep_step_description_color" value="<?php echo esc_attr($uacf7_multistep_step_description_color); ?>">
						</div>
						<div class="multistep_field_column show-if-left-progressbar">
							<label for="uacf7_multistep_step_height"><p>Progressbar Height</p></label>
							<select id="uacf7_multistep_step_height" name="uacf7_multistep_step_height">
							    <option value="default" <?php selected( $uacf7_multistep_step_height, 'default', true ); ?>>Default</option>
							    <option value="equal-height" <?php selected( $uacf7_multistep_step_height, 'equal-height', true ); ?>>Equal height</option>
							</select>
						</div>
					</div>

                    <?php 
                        $uacf7_multistep_button_padding_tb = get_post_meta( $post->id(), 'uacf7_multistep_button_padding_tb', true ); 
                        $uacf7_multistep_button_padding_lr = get_post_meta( $post->id(), 'uacf7_multistep_button_padding_lr', true ); 
                    ?>
                    <div class="multistep_fields_row col-25">
						<h3>Button Style</h3>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_button_padding_tb">
								<p>Padding Top - Bottom (px)</p>
								<input id="uacf7_multistep_button_padding_tb" type="number" name="uacf7_multistep_button_padding_tb" min="0" max="300" value="<?php echo esc_attr($uacf7_multistep_button_padding_tb); ?>">
							</label>
						</div>
						<div class="multistep_field_column">
							<label for="uacf7_multistep_circle_height">
								<p>Padding Left - Right (px)</p>
								<input id="uacf7_multistep_button_padding_lr" type="number" name="uacf7_multistep_button_padding_lr" min="0" max="300" value="<?php echo esc_attr($uacf7_multistep_button_padding_lr); ?>">
							</label>
						</div>
 
						
					</div>
                   
                   <?php                    
                    echo do_action( 'uacf7_multistep_pro_features', $all_steps, $post->id() );
                    
                    }
                   ?>
               </div>
            </div>
        </fieldset>
        <?php
         wp_nonce_field( 'uacf7_multistep_nonce_action', 'uacf7_multistep_nonce' );
    }
    
    public function uacf7_save_contact_form( $form ) {
        
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        
        if ( ! wp_verify_nonce( $_POST['uacf7_multistep_nonce'], 'uacf7_multistep_nonce_action' ) ) {
            return;
        }
        
        // Current Contact Form tags
        $form_current = \WPCF7_ContactForm::get_current();
        
        $all_steps = $form_current->scan_form_tags( array('type'=>'uacf7_step_start') );
        
        apply_filters( 'uacf7_multistep_save_pro_feature', '', $form, $all_steps );
        
        update_post_meta( $form->id(), 'uacf7_enable_multistep_progressbar', sanitize_text_field($_POST['uacf7_enable_multistep_progressbar']) );
 
		if( $_POST['uacf7_progressbar_style'] == 'default' || $_POST['uacf7_progressbar_style'] == 'style-1' ) {
			update_post_meta( $form->id(), 'uacf7_progressbar_style', sanitize_text_field($_POST['uacf7_progressbar_style']) );
		}
        
        update_post_meta( $form->id(), 'uacf7_multistep_is_multistep', sanitize_text_field($_POST['uacf7_multistep_is_multistep']) );
        
        $step_titles = array();
        foreach ($all_steps as $step) {
            $step_titles[] = (is_array($step->values) && !empty($step->values)) ? $step->values[0] : '';
        }
        
        update_post_meta( $form->id(), 'uacf7_multistep_steps_title', $step_titles );
		
        update_post_meta( $form->id(), 'uacf7_multistep_use_step_labels', sanitize_text_field($_POST['uacf7_multistep_use_step_labels']) );
		
		update_post_meta( $form->id(), 'uacf7_multistep_circle_width', sanitize_text_field($_POST['uacf7_multistep_circle_width']) );
    
		update_post_meta( $form->id(), 'uacf7_multistep_circle_height', sanitize_text_field($_POST['uacf7_multistep_circle_height']) );

		update_post_meta( $form->id(), 'uacf7_multistep_circle_bg_color', sanitize_text_field($_POST['uacf7_multistep_circle_bg_color']) );

		update_post_meta( $form->id(), 'uacf7_multistep_circle_font_color', sanitize_text_field($_POST['uacf7_multistep_circle_font_color']) );

		update_post_meta( $form->id(), 'uacf7_multistep_circle_border_radious', sanitize_text_field($_POST['uacf7_multistep_circle_border_radious']) );

		update_post_meta( $form->id(), 'uacf7_multistep_font_size', sanitize_text_field($_POST['uacf7_multistep_font_size']) );
		
		update_post_meta( $form->id(), 'uacf7_multistep_progress_bg_color', sanitize_text_field($_POST['uacf7_multistep_progress_bg_color']) );
		
		update_post_meta( $form->id(), 'uacf7_multistep_progress_line_color', sanitize_text_field($_POST['uacf7_multistep_progress_line_color']) );
		
		update_post_meta( $form->id(), 'uacf7_multistep_step_title_color', sanitize_text_field($_POST['uacf7_multistep_step_title_color']) );
		
		update_post_meta( $form->id(), 'uacf7_multistep_step_description_color', sanitize_text_field($_POST['uacf7_multistep_step_description_color']) );
		
		update_post_meta( $form->id(), 'uacf7_multistep_circle_active_color', sanitize_text_field($_POST['uacf7_multistep_circle_active_color']) );
		
		update_post_meta( $form->id(), 'uacf7_multistep_progressbar_title_color', sanitize_text_field($_POST['uacf7_multistep_progressbar_title_color']) );
		
		update_post_meta( $form->id(), 'uacf7_multistep_step_height', sanitize_text_field($_POST['uacf7_multistep_step_height']) ); 

        // Next Previous Button
		update_post_meta( $form->id(), 'uacf7_multistep_button_padding_tb', sanitize_text_field($_POST['uacf7_multistep_button_padding_tb']) ); 

		update_post_meta( $form->id(), 'uacf7_multistep_button_padding_lr', sanitize_text_field($_POST['uacf7_multistep_button_padding_lr']) ); 
		
    }
    
    /*
    * Change form properties for multistep
    */
    public function uacf7_properties($properties, $cfform) {
	    
        if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) { 

            $form = $properties['form'];

            $uacf7_multistep_is_multistep = get_post_meta( $cfform->id(), 'uacf7_multistep_is_multistep', true ); 
            
			$uacf7_enable_multistep_progressbar = get_post_meta( $cfform->id(), 'uacf7_enable_multistep_progressbar', true );


            if( $uacf7_multistep_is_multistep == 'on' ) {
			
			ob_start();
            
            $all_steps = get_post_meta( $cfform->id(), 'uacf7_multistep_steps_title', true );
			
			$uacf7_multistep_use_step_labels = !empty(get_post_meta( $cfform->id(), 'uacf7_multistep_use_step_labels', true )) ? get_post_meta( $cfform->id(), 'uacf7_multistep_use_step_labels', true ) : ''; 
			
            $uacf7_multistep_button_padding_tb = get_post_meta( $cfform->id(), 'uacf7_multistep_button_padding_tb', true ); 
            $uacf7_multistep_button_padding_lr = get_post_meta( $cfform->id(), 'uacf7_multistep_button_padding_lr', true ); 
            if($uacf7_multistep_button_padding_tb !='' || $uacf7_multistep_button_padding_tb != 0){
                $padding_top = 'padding-top:'.$uacf7_multistep_button_padding_tb.'px !important;'; 
                $padding_bottom = 'padding-bottom:'.$uacf7_multistep_button_padding_tb.'px !important;'; 
            }else{
                $padding_top = ''; 
                $padding_bottom = '';
            }
            if($uacf7_multistep_button_padding_lr !='' || $uacf7_multistep_button_padding_lr != 0){ 
                $padding_left = 'padding-left:'.$uacf7_multistep_button_padding_lr.'px !important;'; 
                $padding_right = ' padding-right:'.$uacf7_multistep_button_padding_lr.'px !important;'; 
            }else{
                $padding_left = ''; 
                $padding_right = ''; 
            }
            
             $next_prev_style = '<style>.uacf7-next, .uacf7-next, .wpcf7-submit{'.$padding_top.' '.$padding_bottom.' '.$padding_left.' '.$padding_right.'}  </style>';
             echo $next_prev_style;
			?> 
			<div class="uacf7-steps steps-form" style="display:none">
                <div class="steps-row setup-panel">
                    <?php
                        $step_id = 1;
                        $step_count = 0;
                
                        $step_name = get_post_meta( $cfform->id(), 'uacf7_multistep_steps_names', true );
                		
                        foreach ($all_steps as $step) {
                            $content = $step;
                            ?>
                            <div class="steps-step"><a title-id=".step-<?php echo esc_attr($step_id); ?>" href="#step-<?php echo esc_attr($step_id); ?>" type="button"></a></div>
                            <?php
                            $step_id++;
                            $step_count++;
                        }
                    ?>
                </div>
            </div>
            <?php
			
            if( $uacf7_enable_multistep_progressbar == 'on' ) {
				
			$uacf7_progressbar_style = get_post_meta( $cfform->id(), 'uacf7_progressbar_style', true );
				
            do_action( 'uacf7_multistep_before_form', $cfform->id() );
            ?>
            <?php 
            $uacf7_multistep_progressbar_title_color = get_post_meta( $cfform->id(), 'uacf7_multistep_progressbar_title_color', true );
            
            if($uacf7_progressbar_style == 'default' && !empty($uacf7_multistep_progressbar_title_color)):

            ?>
            <style>
                .steps-form .steps-row .steps-step p {
                    color: <?php echo esc_attr($uacf7_multistep_progressbar_title_color); ?>;
                }
                .uacf7-steps  .uacf7-next, .uacf7-steps .uacf7-next{
                    padding: <?php echo esc_attr($uacf7_multistep_button_padding_tb); ?> <?php echo esc_attr($uacf7_multistep_button_padding_lr); ?> ;
                } 
 
            </style>
            <?php endif; ?>
 
            <div class="uacf7-steps steps-form <?php if($uacf7_progressbar_style == 'style-1'){echo 'progressbar-style-1';} ?>">
                <div class="steps-row setup-panel">
                <?php
                    $step_id = 1;
                    $step_count = 0;
            
                    $step_name = get_post_meta( $cfform->id(), 'uacf7_multistep_steps_names', true );
            		
                    foreach ($all_steps as $step) {
                        $content = $step;
                        ?>
                        <div class="steps-step"><a title-id=".step-<?php echo esc_attr($step_id); ?>" href="#step-<?php echo esc_attr($step_id); ?>" type="button" class="btn <?php if( $step_id == 1 ) { echo esc_attr('uacf7-btn-active'); }else{ echo esc_attr('uacf7-btn-default'); } ?> btn-circle"><?php 
						if(is_array($step_name)) {
							do_action( 'uacf7_progressbar_image', $step_name[$step_count] );
						}
						
						if( $uacf7_progressbar_style == 'style-1' ){
							if( $uacf7_multistep_use_step_labels != 'on' ) {
								echo $content;
							}else {
								return esc_attr($step_id);
							}
						}else {
							echo esc_attr($step_id);
						} ?></a><?php if( $uacf7_multistep_use_step_labels != 'on' && $uacf7_progressbar_style != 'style-1' && $uacf7_progressbar_style != 'style-4' ) { echo '<p>'.$content.'</p>'; } ?></div>
                        <?php
                        $step_id++;
                        $step_count++;
                    }

                    ?>
                </div>
            </div>
            <?php
			}
            
            $progressbar = ob_get_clean();
			ob_start();
			
			echo apply_filters( 'uacf7_progressbar_html', $progressbar, $form, $cfform->id() );
            
			ob_start();
			?>
			<div class="uacf7-multisetp-form">
				<?php echo $form; ?>
			</div>
			<?php
			$form_html = ob_get_clean();
			
			echo apply_filters( 'uacf7_form_html', $form_html );
				
			$multistep_form = ob_get_clean();

            $properties['form'] = $multistep_form;
				
            }else {
                
                $properties['form'] = $form;
            }
        }

        return $properties;
    }
    
    public function check_fields_validation() {
        if ( !wp_verify_nonce($_REQUEST['ajax_nonce'], 'uacf7-multistep')) {
            exit(esc_html__("Security error", 'ultimate-addons-cf7'));
        }

        $current_step_fields = explode(',', $_REQUEST['current_fields_to_check']);
        
        $form = wpcf7_contact_form( $_REQUEST['form_id'] );
        $all_form_tags = $form->scan_form_tags();
        $invalid_fields = false;
        
        require_once WPCF7_PLUGIN_DIR . '/includes/validation.php';
        $result = new \WPCF7_Validation();
        
        $tags = array_filter(
            $all_form_tags, function($v, $k) use ($current_step_fields) {
                return in_array($v->name, $current_step_fields);
            }, ARRAY_FILTER_USE_BOTH
        );
        $form->validate_schema(
            array(
                'text'  => true,
                'file'  => false,
                'field' =>  $current_step_fields,
            ),
            $result
        );
        
        foreach ( $tags as $tag ) {
            $type = $tag->type;
            
            if ( 'file' != $type && 'file*' != $type ) {
				
                $result = apply_filters("wpcf7_validate_{$type}", $result, $tag);
                
			}elseif( 'file*' === $type ){
			    
			    $fdir = $_REQUEST[$tag->name];

				if ( $fdir ) {
					$_FILES[ $tag->name ] = array(
						'name' => wp_basename( $fdir ),
						'tmp_name' => $fdir,
					);
				}
			    
			    $file = $_FILES[$tag->name];
			    //$file = $_REQUEST[$tag->name];

    			$args = array(
    				'tag' => $tag,
    				'name' => $tag->name,
    				'required' => $tag->is_required(),
    				'filetypes' => $tag->get_option( 'filetypes' ),
    				'limit' => $tag->get_limit_option(),
    			);
    
    			$new_files = wpcf7_unship_uploaded_file( $file, $args );
			    
			    update_option('file_errors', $new_files);
			    
			    $result = apply_filters("wpcf7_validate_{$type}", $result, $tag, array( 'uploaded_files' => $new_files, ) );
			    
			}
            
        }
        
        $result = apply_filters('wpcf7_validate', $result, $tags);
        
        $is_valid = $result->is_valid();

        if (!$is_valid) {
            $invalid_fields = $this->prepare_invalid_form_fields($result);
        }

        echo(json_encode( array(
                    'is_valid' => $is_valid,
                    'invalid_fields' => $invalid_fields,
                )
            )
        );
        wp_die();
    }
    
    private function prepare_invalid_form_fields ($result){
        $invalid_fields = array();

        foreach ((array)$result->get_invalid_fields() as $name => $field) {
            $invalid_fields[] = array(
                'into' => 'span.wpcf7-form-control-wrap[data-name = '.$name.']',
                'message' => $field['reason'],
                'idref' => $field['idref'],
            );
        }

        return $invalid_fields;
    }
    
}
new UACF7_MULTISTEP();
