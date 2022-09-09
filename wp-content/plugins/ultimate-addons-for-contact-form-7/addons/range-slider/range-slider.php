<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * range slider class
 */
class UACF7_range_Slider {

    /**
     * Constructor Function
     */

    public function __construct() {
        add_action( 'wpcf7_init', array( $this, 'add_shortcodes' ) );
        add_action( 'admin_init', array( $this, 'tag_generator' ) );
        add_action( 'wpcf7_editor_panels', array( $this, 'uacf7_add_tab_panel' ) );
        add_action( 'wpcf7_after_save', array( $this, 'uacf7_save_contact_form' ) );
        add_action( 'wpcf7_contact_form_properties', array( $this, 'uacf7_contact_form_properties' ), 10, 2 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_slider_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'uacf7_admin_enqueue_scripts' ) );
    } 

    /**
     * add form tag
     */
    
    public function add_shortcodes() {
        wpcf7_add_form_tag( array( 'uacf7_range_slider', 'uacf7_range_slider*' ),
            array( $this, 'slider_tag_handler_callback' ), array( 'name-attr' => true )
        );
    } 

    /**
     * Slider tag callback
     */
    public function slider_tag_handler_callback( $tag ) {

        $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type );

        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }

        $atts = array();
        $class .= ' uacf7-range-slider';
        $atts['class'] = $class;

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
        }

        $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

        $atts = wpcf7_format_atts( $atts );

        $show_value = !empty( $tag->get_option( 'show_value', '', true ) ) ? $tag->get_option( 'show_value', '', true ) : 'on';
        $handle = !empty( $tag->get_option( 'handle', '', true ) ) ? $tag->get_option( 'handle', '', true ) : '1';
        $min = !empty( $tag->get_option( 'min', '', true ) ) ? $tag->get_option( 'min', '', true ) : 0;
        $max = !empty( $tag->get_option( 'max', '', true ) ) ? $tag->get_option( 'max', '', true ) : 100;
        $default = !empty( $tag->get_option( 'default', '', true ) ) ? $tag->get_option( 'default', '', true ) : 100;
        $step = !empty( $tag->get_option( 'step', '', true ) ) ? $tag->get_option( 'step', '', true ) : 1;
        $steps = '0';
        for ($x = $step; $x <= $max; $x+=$step) {
            $steps .= ','.$x.''; 
          }  

        // return array for range style as $values[0]
        if ( $data = (array) $tag->get_data_option() ) {
            $tag->values = array_merge( $tag->values, array_values( $data ) );
        } 
        $values = $tag->values;
        $newValue = (esc_html( $default ) - esc_html( $min )) * 100 / (esc_html( $max)  - esc_html( $min));  

        ob_start(); 

        if ( $handle == 1 ) {
            echo '<div class="'. esc_attr( $tag->name ) .'">';
            if( $show_value == 'on'){
                ?>
                <label class="uacf7-slider-label">( Min: <?php echo esc_html( $min ); ?> Max: <?php echo esc_html( $max ) ?>)</label>
            <?php
            }
            ?>
            <span class="<?php echo esc_attr( $tag->name ) . '-value'; ?> uacf7-value"></span>
            <span class="wpcf7-form-control-wrap uacf7-slidecontainer uacf7-slider-handle" data-handle="<?php echo esc_attr( $handle ); ?>" data-min="<?php echo esc_attr( $min ); ?>" data-max="<?php echo esc_attr( $max ); ?>" data-default="<?php echo esc_attr( $default ); ?>">
                <input name="<?php echo esc_attr( $tag->name ); ?>" type="range" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" value="<?php echo esc_attr( $default ); ?>" class="uacf7-slider uacf7-range">
            </span>  
            </div>
            <script>

                document.querySelector(".<?php echo $tag->name . '-value'; ?>").innerHTML = document.querySelector(".<?php echo $tag->name ; ?> .uacf7-range").value; // Display the default slider value
                // Update the current slider value (each time you drag the slider handle)
                document.querySelector(".<?php echo $tag->name ; ?> .uacf7-range").oninput = function () {
                    document.querySelector(".<?php echo $tag->name . '-value'; ?>").innerHTML = this.value;
                }  
            </script>
            <?php 
        } elseif ( $handle == 2 ) {
            if( $show_value == 'on'){
                ?>
                <label class="uacf7-slider-label">( Min: <?php echo esc_html( $min ); ?> Max: <?php echo esc_html( $max ) ?>)</label>
            <?php
            }
            ?>
            <div class="multistep">
                <span class="wpcf7-form-control-wrap"><span class="uacf7-amount"><?php echo esc_attr( $min . "-" . $max ); ?></span>
                    <span class="uacf7-slider-handle"  data-handle="<?php echo esc_attr( $handle ); ?>" data-min="<?php echo esc_attr( $min ); ?>" data-max="<?php echo esc_attr( $max ); ?>" data-default="<?php echo esc_attr( $default ); ?>">
                        <input name="<?php echo esc_attr( $tag->name ) ?>" type="hidden" id="uacf7-amount" class="uacf7-slide_amount" readonly>                       
                        <div id="uacf7-slider-range" class="multistep_slide"></div>
                    </span>
                </span>
            </div> 
            <?php
        } 
        ?>
        
        <span>
            <?php echo $validation_error; ?>
        </span>
        <?php
        $default_layout = ob_get_clean(); 
        return apply_filters( 'uacf7_range_slider_style_pro_feature', $default_layout, $tag); 

    }

    /**
     * Tag Generator
     */
    public function tag_generator() {
        if ( !function_exists( 'wpcf7_add_tag_generator' ) ) {
            return;
        }

        wpcf7_add_tag_generator(
            'uacf7_range_slider',
            __( 'Range Slider', 'ultimate-addons-cf7' ),
            'uacf7-tg-pane-range-slider',
            array( $this, 'tg_panel_range_slider' )
        );

    }

    static function tg_panel_range_slider( $cf, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $uacf7_field_type = 'uacf7_range_slider';
        ?>
        <div class="control-box">
            <fieldset>
                <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php _e( 'Field Type', 'ultimate-addons-cf7' );?></th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><?php _e( 'Field Type', 'ultimate-addons-cf7' );?></legend>
                                <label><input type="checkbox" name="required" value="on"><?php _e( 'Required Field', 'ultimate-addons-cf7' );?></label>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'ultimate-addons-cf7' ) ); ?></label></th>
                        <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="tag-generator-panel-text-handle"><?php echo esc_html__( 'Show Values', 'ultimate-addons-cf7' ); ?></label></th>
                        <td>
                            <label for="show_value_on"><input type="radio" name="show_value" class="option" id="show_value_on" value="on"/> <?php echo esc_html( 'On' ); ?></label>
                            <label for="show_value_off"><input type="radio" name="show_value" class="option" id="show_value_off" value="off"/> <?php echo esc_html( 'Off' ); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="tag-generator-panel-text-handle"><?php echo esc_html__( 'Slider Type', 'ultimate-addons-cf7' ); ?></label></th>
                        <td>
                            <label for="single_handle"><input type="radio" name="handle" class="option" id="single_handle" value="1"/> <?php echo esc_html( 'Single Handle' ); ?></label>
                            <label for="double_handle"><input type="radio" name="handle" class="option" id="double_handle" value="2"/> <?php echo esc_html( 'Double Handle' ); ?></label>
                        </td>
                    </tr>
                    <?php ob_start() ?>
                        <tr class="">   
                            <th><label for="tag-generator-panel-range-style">Range Slider Style</label></th>                     
                            <td>
                                <select name="values" disabled class="values" id="tag-generator-panel-range-style">
                                    <option value="default">Default</option> 
                                </select>
                                <a href="https://cf7addons.com/preview/range-slider/pro" style="color:red">(Pro)</a>
                            </td>
                        </tr> 
                    <?php 
                        $range_style = ob_get_clean();
                        echo apply_filters( 'uacf7_range_slider_style_field', $range_style );
                    ?>
                    <tr>
                        <th scope="row"><label for="tag-generator-panel-text-min"><?php echo esc_html__( 'Minimum range', 'ultimate-addons-cf7' ); ?></label></th>
                        <td><input type="text" name="min" class="tg-min oneline option" id="tag-generator-panel-text-min" placeholder="15"  /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="tag-generator-panel-text-max"><?php echo esc_html__( 'Maximum range', 'ultimate-addons-cf7' ); ?></label></th>
                        <td><input type="text" name="max" class="tg-max oneline option" id="tag-generator-panel-text-max" placeholder="100" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="tag-generator-panel-text-default"><?php echo esc_html__( 'Default Value', 'ultimate-addons-cf7' ); ?></label></th>
                        <td><input type="text" name="default" class="tg-default oneline option" id="tag-generator-panel-text-default" placeholder="50" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="tag-generator-panel-text-step"><?php echo esc_html__( 'Range steps', 'ultimate-addons-cf7' ); ?></label></th>
                        <td><input type="text" name="step" class="tg-step oneline option" id="tag-generator-panel-text-step" placeholder="1" /></td>
                    </tr>
                </tbody>
                </table>
                <div class="uacf7-doc-notice uacf7-guide">You can set the styles of the slider from "UACF7 Range Slider" tab.</div>
                <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/range-slider-on-contact-form-7/" target="_blank">documentation</a>.</div>
            </fieldset>
        </div>
        <div class="insert-box">
             <input type="text" name="<?php echo esc_attr( $uacf7_field_type ); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />
            <div class="submitbox">
                <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'ultimate-addons-cf7' ) ); ?>" />
            </div>
        </div>
        <?php
}

    /**
     * Add  tab panel for Range Slider
     */
    public function uacf7_add_tab_panel( $panels ) {
        $panels['uacf7-range-slider-panel'] = array(
            'title'    => __( 'UACF7 Range Slider', 'ultimate-addons-cf7' ),
            'callback' => array( $this, 'uacf7_create_range_slider_panel_fields' ),
        );
        return $panels;

    }

    /**
     * Range Slider Panel Fields
     */

    public function uacf7_create_range_slider_panel_fields( $post ) {

        $selection_color = ! empty( get_post_meta( $post->id(), 'uacf7_range_selection_color', true )) ? get_post_meta( $post->id(), 'uacf7_range_selection_color', true ) : "#1e90ff" ;
        $handle_width = get_post_meta( $post->id(), 'uacf7_range_handle_width', true );
        $handle_height = get_post_meta( $post->id(), 'uacf7_range_handle_height', true );
        $handle_color = ! empty( get_post_meta( $post->id(), 'uacf7_range_handle_color', true )) ? get_post_meta( $post->id(), 'uacf7_range_handle_color', true ) : "#3498db";
        $border_radius = get_post_meta( $post->id(), 'uacf7_range_handle_border_radius', true );
        $range_slider_height = get_post_meta( $post->id(), 'uacf7_range_slider_height', true );
        ?>

        <h2><?php echo esc_html__( 'Range Slider Styles', 'ultimate-addons-cf7' ); ?></h2>
        <p><?php echo esc_html__( 'This feature will help you to edit the Styles of Range Slider of your form. Note that, all below fields are optional. If any field is not needed, leave them blank.', 'ultimate-addons-cf7' ); ?></p>
        <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/range-slider-on-contact-form-7/" target="_blank">documentation</a>.</div>
        <fieldset>
            <div class="uacf7-range-slider-style-wrapper">
                <div class="uacf7-range-slider-color col">
                    <h4><?php echo esc_html__( "Slider Selection Color", "ultimate-addons-cf7" ); ?></h4>
                    <input type="text" id="uacf7-selection-color" name="uacf7_range_selection_color" class="uacf7-color-picker" value="<?php echo esc_attr( $selection_color ); ?>" placeholder="<?php echo esc_html__( 'Selection Color', 'ultimate-addons-cf7' ); ?>">
                </div>
                <div class="range-slider-handle-color col">
                    <h4><?php echo esc_html__( "Slider Handle Color", "ultimate-addons-cf7" ); ?></h4>
                    <input type="text" id="uacf7-handle-color" name="uacf7_range_handle_color" class="uacf7-color-picker" value="<?php echo esc_attr( $handle_color ); ?>" placeholder="<?php echo esc_html__( 'Handle Color', 'ultimate-addons-cf7' ); ?>">
                </div>
                <div class="range-slider-handle-width col">
                    <h4><?php echo esc_html__( "Slider Handle Width (px)", "ultimate-addons-cf7" ); ?></h4>
                    <input type="number" id="uacf7-handle-width" name="uacf7_range_handle_width" class="uacf7-handle-width" value="<?php echo esc_attr( $handle_width ); ?>" placeholder="<?php echo esc_html__( 'Handle Width', 'ultimate-addons-cf7' ); ?>">
                </div>
                <div class="range-slider-handle-height col">
                    <h4><?php echo esc_html__( "Slider Handle Height (px)", "ultimate-addons-cf7" ); ?></h4>
                    <input type="number" id="uacf7-handle-height" name="uacf7_range_handle_height" class="uacf7-handle-height" value="<?php echo esc_attr( $handle_height ); ?>" placeholder="<?php echo esc_html__( 'Handle Height', 'ultimate-addons-cf7' ); ?>">
                </div>
                <div class="clear"></div>
                <div class="range-slider-handle-border-radius col">
                    <h4><?php echo esc_html__( "Handle Border Radius (px)", "ultimate-addons-cf7" ); ?></h4>
                    <input type="text" id="uacf7-handle-border-radius" name="uacf7_range_handle_border_radius" class="uacf7-handle-border-radius" value="<?php echo esc_attr( $border_radius ); ?>" placeholder="<?php echo esc_html__( 'Border Radius', 'ultimate-addons-cf7' ); ?>">
                </div>
                <div class="range-slider-height col">
                    <h4><?php echo esc_html__( "Slider Height  (px)", "ultimate-addons-cf7" ); ?></h4>
                    <input type="number" id="uacf7-handle-height" name="uacf7_range_slider_height" class="uacf7-slider-height" value="<?php echo esc_attr( $range_slider_height ); ?>" placeholder="<?php echo esc_html__( 'Slider Height', 'ultimate-addons-cf7' ); ?>">
                </div>
            </div>
        </fieldset>
    <?php

    wp_nonce_field( 'uacf7_range_slider_nonce_action', 'uacf7_range_slider_nonce' );

    }

    /**
     * Save Contact Form Tab options
     */
    public function uacf7_save_contact_form( $form ) {

        if ( !isset( $_POST ) || empty( $_POST ) ) {
            return;
        }
        if ( !wp_verify_nonce( $_POST['uacf7_range_slider_nonce'], 'uacf7_range_slider_nonce_action' ) ) {
            return;
        }

        update_post_meta( $form->id(), 'uacf7_range_selection_color', sanitize_text_field( $_POST['uacf7_range_selection_color'] ));
        update_post_meta( $form->id(), 'uacf7_range_handle_color', sanitize_text_field($_POST['uacf7_range_handle_color'] ));
        update_post_meta( $form->id(), 'uacf7_range_handle_width', sanitize_text_field($_POST['uacf7_range_handle_width'] ));
        update_post_meta( $form->id(), 'uacf7_range_handle_height', sanitize_text_field($_POST['uacf7_range_handle_height'] ));
        update_post_meta( $form->id(), 'uacf7_range_handle_border_radius', sanitize_text_field($_POST['uacf7_range_handle_border_radius'] ));
        update_post_meta( $form->id(), 'uacf7_range_slider_height', sanitize_text_field($_POST['uacf7_range_slider_height'] ));
    }

    /**
     * Contact Form Properties
     */
    public function uacf7_contact_form_properties( $properties, $cf ) {
        if ( !is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
            $form = $properties['form'];

            ob_start();

            $selection_color = !empty( get_post_meta( $cf->id(), 'uacf7_range_selection_color', true ) ) ? get_post_meta( $cf->id(), 'uacf7_range_selection_color', true ) : "#1e90ff";
            $handle_width = !empty( get_post_meta( $cf->id(), 'uacf7_range_handle_width', true ) ) ? get_post_meta( $cf->id(), 'uacf7_range_handle_width', true ) : '24';
            $handle_height = !empty( get_post_meta( $cf->id(), 'uacf7_range_handle_height', true ) ) ? get_post_meta( $cf->id(), 'uacf7_range_handle_height', true ) : '24';
            $handle_border_radius = !empty( get_post_meta( $cf->id(), 'uacf7_range_handle_border_radius', true ) ) ? get_post_meta( $cf->id(), 'uacf7_range_handle_border_radius', true ) : '24';
            $handle_color = !empty( get_post_meta( $cf->id(), 'uacf7_range_handle_color', true ) ) ? get_post_meta( $cf->id(), 'uacf7_range_handle_color', true ) : '#3498db';
            $range_slider_height = !empty( get_post_meta( $cf->id(), 'uacf7_range_slider_height', true ) ) ? get_post_meta( $cf->id(), 'uacf7_range_slider_height', true ) : 9;
            $handle_dynamic_position = ( $handle_height / 2 - $range_slider_height / 2 ) + 1;
            ?>
            <style>
                :root {
                    --uacf7-slider-Selection-Color: <?php echo esc_attr( $selection_color ); ?>;
                    --uacf7-slider-handle-color: <?php echo esc_attr( $handle_color ); ?>;
                    --uacf7-slider-handle-width: <?php echo esc_attr( $handle_width ) . "px"; ?>;
                    --uacf7-slider-handle-height: <?php echo esc_attr( $handle_height ) . "px"; ?>;
                    --uacf7-slider-handle-border-radius: <?php echo esc_attr( $handle_border_radius ) . "px"; ?>;
                    --uacf7-slider-range-slider-height: <?php echo esc_attr( $range_slider_height ) . "px"; ?>;
                }
                .uacf7-form-<?php echo esc_attr( $cf->id() ); ?> .ui-slider-horizontal .ui-slider-range {
                    background-color: <?php echo esc_attr( $selection_color ); ?>;
                    height: <?php echo esc_attr( $range_slider_height ) . "px"; ?>;
                }
                .uacf7-form-<?php echo esc_attr( $cf->id() ); ?> .ui-widget.ui-widget-content {
                    height: <?php echo esc_attr( $range_slider_height ) . "px"; ?>;
                    border: 1px solid <?php echo esc_attr( $selection_color ); ?>;
                    background-color: #EEE;
                }
                .uacf7-form-<?php echo esc_attr( $cf->id() ); ?> .ui-state-default, .ui-widget-content .ui-state-default{
                    background-color: <?php echo esc_attr( $handle_color ); ?>;
                    width: <?php echo esc_attr( $handle_width ) . "px"; ?>;
                    height: <?php echo esc_attr( $handle_height ) . "px"; ?>;
                    border-radius: <?php echo esc_attr( $handle_border_radius ) . "px"; ?>;
                    cursor: pointer;
                    border: none !important;
                    top: -8px;
                    position: absolute;
                    
                }
              
                .uacf7-form-<?php echo esc_attr( $cf->id() ); ?> .ui-slider-horizontal .ui-slider-handle {
                    top: -<?php echo esc_attr( $handle_dynamic_position ) ?>px;
                }
                .uacf7-form-<?php echo esc_attr( $cf->id() ); ?> input[type=range] {
                    background-color: <?php echo esc_attr( $selection_color ); ?>;
                    height: <?php echo esc_attr( $range_slider_height ) . "px"; ?>;
                    border-radius: 5px;
                }
                .uacf7-form-<?php echo esc_attr( $cf->id() ); ?> .ui-slider-horizontal{
                    height: <?php echo esc_attr( $range_slider_height ) . "px"; ?>;
                }
                .uacf7-form-<?php echo esc_attr( $cf->id() ); ?> .uacf7-slider::-webkit-slider-thumb {
                    -webkit-appearance: none;
                    appearance: none;
                    width: <?php echo esc_attr( $handle_width ) . "px"; ?>;
                    height: <?php echo esc_attr( $handle_height ) . "px"; ?>;
                    background:<?php echo esc_attr( $handle_color ); ?>;
                    border-radius: <?php echo esc_attr( $handle_border_radius ); ?>px;
                    cursor: pointer;
                }

                .uacf7-form-<?php echo esc_attr( $cf->id() ); ?> .uacf7-slider::-moz-range-thumb {
                    width: <?php echo esc_attr( $handle_width ) . "px"; ?>;
                    height: <?php echo esc_attr( $handle_height ) . "px"; ?>;
                    background: <?php echo esc_attr( $handle_color ); ?>;
                    border-radius: <?php echo esc_attr( $handle_border_radius ); ?>px;
                    cursor: pointer;
                }
            </style>

            <?php

            echo '<div class="uacf7-form-' . $cf->id() . '">' . $form . '</div>';
            $properties['form'] = ob_get_clean();

        }
        return $properties;
    }

    /**
     * Enqueue Slider scripts
     */
    public function enqueue_slider_scripts() { 
        wp_enqueue_script( 'uacf7-range-slider', UACF7_URL . 'addons/range-slider/js/range-slider.js', array( 'jquery', 'jquery-ui' ), false, true );
        wp_enqueue_style( 'jquery-ui-style', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
        wp_enqueue_style( 'range-slider-style', UACF7_URL . 'addons/range-slider/css/style.css' );
        wp_register_script( 'jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'jquery-ui' );
        
    }

    /**
     * Admin enqueue scripts
     */
    public function uacf7_admin_enqueue_scripts() {
        wp_enqueue_style( 'range-slider-style', UACF7_URL . 'addons/range-slider/css/style.css' );
        wp_enqueue_script( 'uacf7-admin-slider-color', UACF7_URL . 'addons/range-slider/js/admin.js', array( 'jquery' ) );
    }
}

new UACF7_range_Slider;