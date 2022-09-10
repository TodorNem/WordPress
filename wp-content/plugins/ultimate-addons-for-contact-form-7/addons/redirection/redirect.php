<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_Redirection {
    
    /*
    * Construct function
    */
    public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_redirect_script' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_redirect_script' ) );
		add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_panel' ) );
		add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_meta' ) );
		add_action( 'wpcf7_submit', array( $this, 'uacf7_non_ajax_redirection' ) );
    }
    
    public function enqueue_redirect_script() {
        wp_enqueue_script( 'uacf7-redirect-script', UACF7_URL . 'addons/redirection/js/redirect.js', array(), null, true );
		wp_localize_script( 'uacf7-redirect-script', 'uacf7_redirect_object', $this->get_forms() );
        wp_localize_script( 'uacf7-redirect-script', 'uacf7_redirect_enable', $this->uacf7_redirect_enable() );
        
		if ( isset( $this->enqueue_new_tab_script ) && $this->enqueue_new_tab_script ) {
			wp_add_inline_script( 'wpcf7-redirect-script', 'window.open("' . $this->redirect_url . '");' );
		}
    }
	
	public function admin_enqueue_redirect_script() {
        wp_enqueue_script( 'uacf7-redirect-script', UACF7_URL . 'addons/redirection/js/admin-redirect.js', array(), null, true );
        wp_enqueue_style( 'uacf7-redirect-style', UACF7_URL . 'addons/redirection/css/admin-redirect.css', array(), null, true );
    }
    
    public function get_forms() {
		$args  = array(
			'post_type'        => 'wpcf7_contact_form',
			'posts_per_page'   => -1,
		);
		$query = new WP_Query( $args );

		$forms = array();

		if ( $query->have_posts() ) :

			$fields = $this->fields();

			while ( $query->have_posts() ) :
				$query->the_post();

				$post_id = get_the_ID();

				foreach ( $fields as $field ) {
					$forms[ $post_id ][ $field['name'] ] = get_post_meta( $post_id, 'uacf7_redirect_' . $field['name'], true );
				}

				$forms[ $post_id ]['thankyou_page_url'] = $forms[ $post_id ]['page_id'] ? get_permalink( $forms[ $post_id ]['page_id'] ) : '';
			endwhile;
			wp_reset_postdata();
		endif;

		return $forms;
	}
    
    public function uacf7_get_options( $post_id ) {
		$fields = $this->fields();
		foreach ( $fields as $field ) {
			$values[ $field['name'] ] = get_post_meta( $post_id, 'uacf7_redirect_' . $field['name'], true );
		}
		return $values;
	}
    
    /*
    * Function create tab panel
    */
    public function uacf7_add_panel( $panels ) {
		$panels['uacf7-redirect-panel'] = array(
			'title'    => __( 'UACF7 Redirection', 'ultimate-addons-cf7' ),
			'callback' => array( $this, 'uacf7_create_redirect_panel_fields' ),
		);
		return $panels;
	}
    
    public function uacf7_non_ajax_redirection( $contact_form ) {
		$this->fields = $this->uacf7_get_options( $contact_form->id() );

		if ( isset( $this->fields ) && ! WPCF7_Submission::is_restful() ) {
			$submission = WPCF7_Submission::get_instance();

			if ( $submission->get_status() === 'mail_sent' ) {

				if ( 'to_url' === $this->fields['uacf7_redirect_to_type'] && $this->fields['external_url'] ) {
					$this->redirect_url = $this->fields['external_url'];
				}
				if( 'to_page' === $this->fields['uacf7_redirect_to_type'] && $this->fields['page_id'] ){
					$this->redirect_url = get_permalink( $this->fields['page_id'] );
				}

				// Open link in a new tab
				if ( isset( $this->redirect_url ) && $this->redirect_url ) {
					if ( 'on' === $this->fields['open_in_new_tab'] ) {
						$this->enqueue_new_tab_script = true;
					} else {
						wp_redirect( $this->redirect_url );
						exit;
					}
				}
			}
		}
	}
    
    /*
    * Function redirect fields
    */
    public function uacf7_create_redirect_panel_fields( $post ) {
        ?>
        <h2><?php echo esc_html__( 'UACF7 Redirection Settings', 'ultimate-addons-cf7' ); ?></h2>
                
        <p><?php echo esc_html__('This feature will help you to redirect contact form 7 after submission. You can Redirect users to a Thank you page or External page after user fills up the form. You can check this','ultimate-addons-cf7'); ?> <a target="_blank" href="<?php echo esc_url('https://youtu.be/mxcC1eQXxEI'); ?>"><?php echo esc_html__('video','ultimate-addons-cf7'); ?></a> <?php echo esc_html__('to learn more.','ultimate-addons-cf7'); ?></p>
        
        <fieldset>
          <?php
			$options = $this->uacf7_get_options($post->id());
			$uacf7_redirect_to_type = !empty($options['uacf7_redirect_to_type']) ? $options['uacf7_redirect_to_type'] : 'to_page';
			$uacf7_redirect_enable = get_post_meta( $post->id(), 'uacf7_redirect_enable', true );
			?>
			
			<p>
           	<label for="uacf7_redirect_enable">
           		<input class="uacf7_redirect_enable" id="uacf7_redirect_enable" name="uacf7_redirect_enable" type="checkbox" value="yes" <?php checked( 'yes', $uacf7_redirect_enable, true ); ?>> <?php echo esc_html__('Enable redirection'); ?>
           	</label><br>
           </p>
           
		   <div class="uacf7_default_redirect_wraper" style="margin: 20px;">
               <p>
               	<label for="uacf7_redirect_to_page">
               		<input class="uacf7_redirect_to_type" id="uacf7_redirect_to_page" name="uacf7_redirect[uacf7_redirect_to_type]" type="radio" value="to_page" <?php checked( 'to_page', $uacf7_redirect_to_type, true ); ?>> <?php echo esc_html__('Redirect to page'); ?>
               	</label><br>
               	<label for="uacf7_redirect_to_url">
               		<input class="uacf7_redirect_to_type" id="uacf7_redirect_to_url" name="uacf7_redirect[uacf7_redirect_to_type]" type="radio" value="to_url" <?php checked( 'to_url', $uacf7_redirect_to_type, true ); ?>> <?php echo esc_html__('Redirect to external URL'); ?>
               	</label>
               </p>
                <p class="uacf7_redirect_to_page">
                    <label for="uacf7-redirect-page">
    					<?php esc_html_e( 'Select a page to redirect', 'ultimate-addons-cf7' ); ?>   
    				</label><br>
    				<?php
    				$pages = get_posts(array(
                                'post_type'        => 'page',
                                'posts_per_page'   => -1,
                                'post_status'      => 'published',
                            ));
    				?>
    				<select name="uacf7_redirect[page_id]" id="uacf7-redirect-page">
    					<option value="0" <?php selected( 0, $options['page_id'] ); ?> >
    				<?php echo esc_html__( 'Choose Page', 'ultimate-addons-cf7' ); ?>
    					</option>
    
    					<?php foreach ( $pages as $page ) : ?>
    
    						<option value="<?php echo esc_attr($page->ID); ?>" <?php selected( $page->ID, $options['page_id'] ); ?>>
    							<?php echo esc_html($page->post_title); ?>
    						</option>
    
    					<?php endforeach; ?>
    				</select>
                </p>
                <p class="uacf7_redirect_to_url">
                    <input type="url" id="uacf7-external-url" name="uacf7_redirect[external_url]" class="large-text" value="<?php echo esc_html($options['external_url']); ?>" placeholder="<?php echo esc_html__( 'Enter an external URL', 'ultimate-addons-cf7' ); ?>">
                </p>
            
            </div>
            
            <?php ob_start(); ?>
            
            <!--Start Conditional redirect-->
            <div class="uacf7_conditional_redirect_wraper" style="margin: 20px;">
            	<div class="uacf7_conditional_redirect_add_btn">
            		<a href="#" class="button-primary uacf7_cr_btn">+ Add Condition</a> <a style="color:red" target="_blank" href="https://cf7addons.com/">(Pro)</a>
            		
            		<!--Start New row-->
            		<div style="display:none" class="uacf7_cr_copy">
						<li class="uacf7_conditional_redirect_condition">
							<span>If</span>
							<span>
								<select class="uacf7-field">
									<?php
									$all_fields = array();
									$all_fields = $post->scan_form_tags();
									?>
									<option value=""><?php echo esc_html( '-- Select field --', 'ultimate-addons-cf7' ) ?></option>
									<?php
									foreach ($all_fields as $tag) {
										if ($tag['name'] == '') continue;
									?>
									<?php 
									if( $tag['type'] == 'checkbox' ) { 

										$tag_name = $tag['name'].'[]';

									}else {

										$tag_name = $tag['name'];
									}
									?>
									<option><?php echo esc_html($tag['name']); ?></option>

									<?php
									}
									?>
								</select>
							</span>
							<span> Value == </span>
           					<span> <input type="text" placeholder="Value"> </span>
							<span> Redirect to </span>
           					<span><input type="text" placeholder="Redirect URL"></span>
           					<spna><a href="#" class="uacf7_cr_remove_row">x</a></spna>
						</li>
            		</div>
            		<!--End New row-->
            		
            	</div>
            	
            	<ul class="uacf7_conditional_redirect_conditions">
            		<li class="uacf7_conditional_redirect_condition">
            			<span>If</span>
            			<span>
            				<select class="uacf7-field">
								<?php
								$all_fields = array();
								$all_fields = $post->scan_form_tags();
								?>
								<option value=""><?php echo esc_html( '-- Select field --', 'ultimate-addons-cf7' ) ?></option>
								<?php
								foreach ($all_fields as $tag) {
									if ($tag['name'] == '') continue;
								?>
								<?php 
								if( $tag['type'] == 'checkbox' ) { 

									$tag_name = $tag['name'].'[]';

								}else {

									$tag_name = $tag['name'];
								}
								?>
								<option><?php echo esc_html($tag['name']); ?></option>

								<?php
								}
								?>
                            </select>
						</span>
           				<span> Value == </span>
           				<span> <input type="text" placeholder="Value"> </span>
           				<span> Redirect to </span>
           				<span><input type="text" placeholder="Redirect URL"></span>
           				<spna><a href="#" class="uacf7_cr_remove_row">x</a></spna>
            		</li>
            	</ul>
            	
            </div>
            <!--End Conditional redirect-->
            
            <?php 
            
            $uacf7_cr_pro_fields = ob_get_clean();
            
            echo apply_filters( 'uacf7_cr_pro_fields', $uacf7_cr_pro_fields, $post );
            ?>
            
            <?php ob_start(); ?>
            <p>
           	    <label for="uacf7_redirect_type">
           		    <input class="uacf7_redirect_type" id="uacf7_redirect_type" name="" type="checkbox" value="yes"> <?php echo esc_html__('Conditional Redirect'); ?>
           	    </label> <a style="color:red" target="_blank" href="https://cf7addons.com/">(Pro)</a><br>
            </p>
            <?php 
            $uacf7_redirect_type_html = ob_get_clean();
            echo apply_filters( 'uacf7_redirect_type_field', $uacf7_redirect_type_html, $post );
            ?>
            
            <p>
                <input id="uacf7_tab_target" type="checkbox" name="uacf7_redirect[target]" <?php checked( $options['target'], 'on', true ); ?>>
                <label for="uacf7_tab_target"><?php echo esc_html__( 'Open page in a new tab', 'ultimate-addons-cf7' ); ?></label>
            </p>

			<?php ob_start(); ?>
            <p>
                <input id="uacf7_redirect_tag_support" type="checkbox" name="">
                <label for="uacf7_redirect_tag_support"><?php echo esc_html__( 'Tags support to redirect URL', 'ultimate-addons-cf7' ); ?></label> <a style="color:red" target="_blank" href="https://cf7addons.com/">(Pro)</a>
				<span style="display:block;font-size:13px;color:#666">Enable support contact form 7 fields tags to use on custom redirect URL. Such as - www.yourdomain.com/?name=[your-name]</span>
			</p>
			<?php 
            $uacf7_redirect_tag_support = ob_get_clean();
            echo apply_filters( 'uacf7_redirect_tag_support', $uacf7_redirect_tag_support, $post );
            ?>

			<div class="uacf7-doc-notice">Not sure how to set this? Check our step by step documentation on <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/redirection/" target="_blank">Redirect to a Page or External URL</a>, <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/conditional-redirect/" target="_blank">Conditional Redirect</a> and <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/tag-support-whatsapp/" target="_blank">Tag Support</a>.</div>
        </fieldset>
        
        <?php
         wp_nonce_field( 'uacf7_redirection_nonce_action', 'uacf7_redirect_nonce' );
    }
    
    /*
    * Fields array
    */
    public function fields() {
        $fields = array(
            array(
                'name'  => 'uacf7_redirect_to_type',
                'type'  => 'radio',
            ),
			array(
                'name'  => 'page_id',
                'type'  => 'number',
            ),
            array(
                'name'  => 'external_url',
                'type'  => 'url',
            ),
            array(
                'name'  => 'target',
                'type'  => 'checkbox',
            ),
        );
        return $fields;
    }
    
    /*
    * Save meta value
    */
    public function uacf7_save_meta( $post ) {
        if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}
        if ( ! wp_verify_nonce( $_POST['uacf7_redirect_nonce'], 'uacf7_redirection_nonce_action' ) ) {
            return;
        }
        
        update_post_meta( $post->id(), 'uacf7_redirect_enable', sanitize_text_field( $_POST['uacf7_redirect_enable'] ) );
        
        $fields = $this->fields();
        $data = $_POST['uacf7_redirect'];
        
        foreach( $fields as $field ) {
            $value = isset($data[$field['name']]) ? $data[$field['name']] : '';
            
            switch( $field['type'] ) {
                    
                case 'radio':
                    $value = sanitize_text_field( $value );
                    break;
    
                case 'number':
                    $value = intval( $value );
                    break;

                case 'checkbox':
                    $value = sanitize_text_field( $value );
                    break;

                case 'url':
                    $value = sanitize_text_field( $value );
                    break;
            }
            
            update_post_meta( $post->id(), 'uacf7_redirect_' . $field['name'], $value );
        }
        
    }
    
    /*
    Enable conditional redirect
    */
    public function uacf7_redirect_enable() {
    	$args  = array(
    		'post_type'        => 'wpcf7_contact_form',
    		'posts_per_page'   => -1,
    	);
    	$query = new WP_Query( $args );
    
    	$forms = array();
    
    	if ( $query->have_posts() ) :
    
    		while ( $query->have_posts() ) :
    			$query->the_post();
    
                $post_id = get_the_ID();
                
                $uacf7_redirect = get_post_meta( get_the_ID(), 'uacf7_redirect_enable', true );
                
                if( !empty($uacf7_redirect) && $uacf7_redirect == 'yes' ) {
                
                    $forms[ $post_id ] = $uacf7_redirect;
                
                }
        
    		endwhile;
    		wp_reset_postdata();
    	endif;
    
    	return $forms;
    }
}
new UACF7_Redirection();


