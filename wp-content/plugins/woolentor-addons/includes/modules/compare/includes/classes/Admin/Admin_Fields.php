<?php
namespace EverCompare\Admin;
/**
 * Admin Page Fields handlers class
 */
class Admin_Fields {

    private $settings_api;

    /**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Admin]
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct() {
        require_once( WOOLENTOR_ADDONS_PL_PATH .'includes/admin/include/settings_field_manager_default.php' );
        $this->settings_api = new \WooLentor_Settings_Field_Manager_Default();
        add_action( 'admin_init', [ $this, 'admin_init' ] );
    }

    public function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    // Options page Section register
    public function get_settings_sections() {
        $sections = array(

            array(
                'id'    => 'ever_compare_settings_tabs',
                'title' => esc_html__( 'Button Settings', 'ever-compare' ),
            ),
            
            array(
                'id'    => 'ever_compare_table_settings_tabs',
                'title' => esc_html__( 'Table Settings', 'ever-compare' )
            ),
            array(
                'id'    => 'ever_compare_style_tabs',
                'title' => esc_html__( 'Style Settings', 'ever-compare' ),
            )

        );
        return $sections;
    }

    // Options page field register
    protected function fields_settings() {

        $settings_fields = array(

            'ever_compare_settings_tabs' => array(

                array(
                    'name'  => 'btn_show_shoppage',
                    'label'  => __( 'Show button in product list page', 'ever-compare' ),
                    'desc'  => __( 'Show compare button in product list page.', 'ever-compare' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                ),

                array(
                    'name'  => 'btn_show_productpage',
                    'label'  => __( 'Show button in single product page', 'ever-compare' ),
                    'desc'  => __( 'Show compare button in single product page.', 'ever-compare' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                ),

                array(
                    'name'    => 'shop_btn_position',
                    'label'   => __( 'Shop page button position', 'ever-compare' ),
                    'desc'    => __( 'You can manage compare button position in product list page.', 'ever-compare' ),
                    'type'    => 'select',
                    'default' => 'after_cart_btn',
                    'options' => [
                        'before_cart_btn' => __( 'Before Add To Cart', 'ever-compare' ),
                        'after_cart_btn'  => __( 'After Add To Cart', 'ever-compare' ),
                        'top_thumbnail'   => __( 'Top On Image', 'ever-compare' ),
                        'use_shortcode'   => __( 'Use Shortcode', 'ever-compare' ),
                        'custom_position' => __( 'Custom Position', 'ever-compare' ),
                    ],
                ),

                array(
                    'name'    => 'shop_use_shortcode_message',
                    'headding'=> wp_kses_post('<code>[evercompare_button]</code> Use this shortcode into your theme/child theme to place the compare button.'),
                    'type'    => 'title',
                    'size'    => 'margin_0 regular',
                    'class' => 'depend_shop_btn_position_use_shortcode element_section_title_area message-info',
                ),

                array(
                    'name'    => 'shop_custom_hook_message',
                    'headding'=> esc_html__( 'Some themes remove the above positions. In that case, custom position is useful. Here you can place the custom/default hook name & priority to inject & adjust the compare button for the product loop.', 'ever-compare' ),
                    'type'    => 'title',
                    'size'    => 'margin_0 regular',
                    'class' => 'depend_shop_btn_position_custom_hook element_section_title_area message-info',
                ),

                array(
                    'name'        => 'shop_custom_hook_name',
                    'label'       => __( 'Hook name', 'ever-compare' ),
                    'desc'        => __( 'e.g: woocommerce_after_shop_loop_item_title', 'ever-compare' ),
                    'type'        => 'text',
                    'class'       => 'depend_shop_btn_position_custom_hook'
                ),

                array(
                    'name'        => 'shop_custom_hook_priority',
                    'label'       => __( 'Hook priority', 'ever-compare' ),
                    'desc'        => __( 'Default: 10', 'ever-compare' ),
                    'type'        => 'text',
                    'class'       => 'depend_shop_btn_position_custom_hook'
                ),

                array(
                    'name'    => 'product_btn_position',
                    'label'   => __( 'Product page button position', 'ever-compare' ),
                    'desc'    => __( 'You can manage compare button position in single product page.', 'ever-compare' ),
                    'type'    => 'select',
                    'default' => 'after_cart_btn',
                    'options' => [
                        'before_cart_btn' => __( 'Before Add To Cart', 'ever-compare' ),
                        'after_cart_btn'  => __( 'After Add To Cart', 'ever-compare' ),
                        'after_thumbnail' => __( 'After Image', 'ever-compare' ),
                        'after_summary'   => __( 'After Summary', 'ever-compare' ),
                        'use_shortcode'   => __( 'Use Shortcode', 'ever-compare' ),
                        'custom_position' => __( 'Custom Position', 'ever-compare' ),
                    ],
                ),

                array(
                    'name'    => 'product_use_shortcode_message',
                    'headding'=> wp_kses_post('<code>[evercompare_button]</code> Use this shortcode into your theme/child theme to place the compare button.'),
                    'type'    => 'title',
                    'size'    => 'margin_0 regular',
                    'class' => 'depend_product_btn_position_use_shortcode element_section_title_area message-info',
                ),

                array(
                    'name'    => 'product_custom_hook_message',
                    'headding'=> esc_html__( 'Some themes remove the above positions. In that case, custom position is useful. Here you can place the custom/default hook name & priority to inject & adjust the compare button for the single product page.', 'ever-compare' ),
                    'type'    => 'title',
                    'size'    => 'margin_0 regular',
                    'class' => 'depend_product_btn_position_custom_hook element_section_title_area message-info',
                ),

                array(
                    'name'        => 'product_custom_hook_name',
                    'label'       => __( 'Hook name', 'ever-compare' ),
                    'desc'        => __( 'e.g: woocommerce_after_single_product_summary', 'ever-compare' ),
                    'type'        => 'text',
                    'class'       => 'depend_product_btn_position_custom_hook'
                ),

                array(
                    'name'        => 'product_custom_hook_priority',
                    'label'       => __( 'Hook priority', 'ever-compare' ),
                    'desc'        => __( 'Default: 10', 'ever-compare' ),
                    'type'        => 'text',
                    'class'       => 'depend_product_btn_position_custom_hook'
                ),

                array(
                    'name'  => 'open_popup',
                    'label'  => __( 'Open popup', 'ever-compare' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'desc'    => __( 'You can manage the popup window from here.', 'ever-compare' ),
                ),

                array(
                    'name'        => 'button_text',
                    'label'       => __( 'Button text', 'ever-compare' ),
                    'desc'        => __( 'Enter your compare button text.', 'ever-compare' ),
                    'type'        => 'text',
                    'default'     => __( 'Compare', 'ever-compare' ),
                    'placeholder' => __( 'Compare', 'ever-compare' ),
                ),

                array(
                    'name'        => 'added_button_text',
                    'label'       => __( 'Added button text', 'ever-compare' ),
                    'desc'        => __( 'Enter your compare added button text.', 'ever-compare' ),
                    'type'        => 'text',
                    'default'     => __( 'Added', 'ever-compare' ),
                    'placeholder' => __( 'Added', 'ever-compare' ),
                ),

                array(
                    'name'    => 'button_icon_type',
                    'label'   => esc_html__( 'Button icon type', 'ever-compare' ),
                    'desc'    => esc_html__( 'Choose an icon type for the compare button from here.', 'ever-compare' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => [
                        'none'     => esc_html__( 'None', 'ever-compare' ),
                        'default'  => esc_html__( 'Default', 'ever-compare' ),
                        'custom'   => esc_html__( 'Custom', 'ever-compare' ),
                    ]
                ),

                array(
                    'name'    => 'button_custom_icon',
                    'label'   => esc_html__( 'Button custom icon', 'ever-compare' ),
                    'type'    => 'image_upload',
                    'options' => [
                        'button_label'        => esc_html__( 'Upload', 'ever-compare' ),   
                        'button_remove_label' => esc_html__( 'Remove', 'ever-compare' ),
                    ],
                    'desc'    => esc_html__( 'Upload you custom icon from here.', 'ever-compare' ),
                    'class'   => 'depend_button_icon_type_custom',
                ),

                array(
                    'name'    => 'added_button_icon_type',
                    'label'   => __( 'Added button icon type', 'ever-compare' ),
                    'desc'    => __( 'Choose an icon for the compare button from here.', 'ever-compare' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => [
                        'none'     => esc_html__( 'None', 'ever-compare' ),
                        'default'  => esc_html__( 'Default', 'ever-compare' ),
                        'custom'   => esc_html__( 'Custom', 'ever-compare' ),
                    ]
                ),

                array(
                    'name'    => 'added_button_custom_icon',
                    'label'   => __( 'Added button custom icon', 'ever-compare' ),
                    'type'    => 'image_upload',
                    'options' => [
                        'button_label'        => esc_html__( 'Upload', 'ever-compare' ),   
                        'button_remove_label' => esc_html__( 'Remove', 'ever-compare' ),   
                    ],
                    'class' => 'depend_added_button_icon_type_custom',
                ),

            ),

            'ever_compare_table_settings_tabs' => array(

                array(
                    'name'    => 'compare_page',
                    'label'   => __( 'Compare page', 'ever-compare' ),
                    'desc' => wp_kses_post('Select a compare page for compare table. It should contain the shortcode <code>[evercompare_table]</code>'),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => ever_compare_get_post_list()
                ),

                array(
                    'name'  => 'enable_shareable_link',
                    'label'  => __( 'Enable shareable link', 'ever-compare' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'desc'    => __( 'If you enable this you can easily share your compare page link with specific products.', 'ever-compare' ),
                ),

                array(
                    'name'    => 'linkshare_btn_pos',
                    'label'   => __( 'Share link button position', 'ever-compare' ),
                    'type'    => 'select',
                    'default' => 'right',
                    'options' => [
                        'left' => __('Left','ever-compare'),
                        'center' => __('Center','ever-compare'),
                        'right' => __('Right','ever-compare')
                    ],
                    'class'       => 'depend_enable_shareable_link'
                ),

                array(
                    'name'        => 'shareable_link_button_text',
                    'label'       => __( 'Share link button text', 'ever-compare' ),
                    'placeholder' => __( 'Copy shareable link', 'ever-compare' ),
                    'type'        => 'text',
                    'class'       => 'depend_enable_shareable_link'
                ),

                array(
                    'name'        => 'shareable_link_after_button_text',
                    'label'       => __( 'Text to show after link is copied', 'ever-compare' ),
                    'placeholder' => __( 'Copied', 'ever-compare' ),
                    'type'        => 'text',
                    'class'       => 'depend_enable_shareable_link'
                ),

                array(
                    'name'    => 'limit',
                    'label'   => esc_html__( 'Limit', 'quickswish' ),
                    'desc'    => esc_html__( 'You can manage your maximum compare quantity from here.', 'quickswish' ),
                    'type'    => 'number',
                    'min'              => 1,
                    'max'              => 1500,
                    'step'             => 1,
                    'default'          => 10,
                    'sanitize_callback' => 'floatval',
                ),

                array(
                    'name' => 'show_fields',
                    'label' => __('Show fields in table', 'ever-compare'),
                    'desc' => __('Choose which fields should be presented on the product compare page with table.', 'ever-compare'),
                    'type' => 'multicheckshort',
                    'options' => ever_compare_get_available_attributes(),
                    'default' => [
                        'title'         => esc_html__( 'title', 'ever-compare' ),
                        'ratting'       => esc_html__( 'ratting', 'ever-compare' ),
                        'price'         => esc_html__( 'price', 'ever-compare' ),
                        'add_to_cart'   => esc_html__( 'add_to_cart', 'ever-compare' ),
                        'description'   => esc_html__( 'description', 'ever-compare' ),
                        'availability'  => esc_html__( 'availability', 'ever-compare' ),
                        'sku'           => esc_html__( 'sku', 'ever-compare' ),
                        'weight'        => esc_html__( 'weight', 'ever-compare' ),
                        'dimensions'    => esc_html__( 'dimensions', 'ever-compare' ),
                    ],
                ),

                array(
                    'name'    => 'table_heading_section_title',
                    'headding'=> esc_html__( 'Custom heading', 'ever-compare' ),
                    'type'    => 'title',
                    'size'    => 'margin_0 regular',
                    'class' => 'element_section_title_area',
                ),

                array(
                    'name'    => 'table_heading',
                    'label'   => __( 'Fields heading text', 'ever-compare' ),
                    'desc'    => __( 'You can change heading text from here.', 'ever-compare' ),
                    'type'    => 'multitext',
                    'options' => ever_compare_table_heading()
                ),

                array(
                    'name' => 'reached_max_limit_message',
                    'label' => __('Reached maximum limit message', 'ever-compare'),
                    'desc' => __('You can manage message for maximum product added in the compare table.', 'ever-compare'),
                    'type' => 'textarea'
                ),

                array(
                    'name' => 'empty_table_text',
                    'label' => __('Empty compare page text', 'ever-compare'),
                    'desc' => __('Text will be displayed if user don\'t add any products to compare', 'ever-compare'),
                    'type' => 'textarea'
                ),

                array(
                    'name'        => 'shop_button_text',
                    'label'       => __( 'Return to shop button text', 'ever-compare' ),
                    'desc'        => __( 'Enter your return to shop button text.', 'ever-compare' ),
                    'type'        => 'text',
                    'default'     => __( 'Return to shop', 'ever-compare' ),
                    'placeholder' => __( 'Return to shop', 'ever-compare' ),
                ),

                array(
                    'name'        => 'image_size',
                    'label'       => __( 'Image size', 'ever-compare' ),
                    'desc'        => __( 'Enter your required image size.', 'ever-compare' ),
                    'type'        => 'multitext',
                    'options'     =>[
                        'width' => esc_html__( 'Width', 'ever-compare' ),
                        'height' => esc_html__( 'Height', 'ever-compare' ),
                    ],
                    'default' => [
                        'width'   => 300,
                        'height'  => 300,
                    ],
                ),

                array(
                    'name'  => 'hard_crop',
                    'label'  => __( 'Image Hard Crop', 'ever-compare' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                ),

            ),

            'ever_compare_style_tabs' => array(

                array(
                    'name'    => 'button_style',
                    'label'   => esc_html__( 'Button style', 'ever-compare' ),
                    'desc'    => esc_html__( 'Choose a style for the compare button from here.', 'ever-compare' ),
                    'type'    => 'select',
                    'default' => 'theme',
                    'options' => [
                        'default'   => esc_html__( 'Default', 'ever-compare' ),
                        'theme'     => esc_html__( 'Theme', 'ever-compare' ),
                        'custom'    => esc_html__( 'Custom', 'ever-compare' ),
                    ]
                ),

                array(
                    'name'    => 'table_style',
                    'label'   => esc_html__( 'Table style', 'ever-compare' ),
                    'desc'    => esc_html__( 'Choose a table style from here.', 'ever-compare' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => [
                        'default'   => esc_html__( 'Default', 'ever-compare' ),
                        'custom'    => esc_html__( 'Custom', 'ever-compare' ),
                    ]
                ),

                array(
                    'name'    => 'button_custom_style_area_title',
                    'headding'=> esc_html__( 'Button custom style', 'ever-compare' ),
                    'type'    => 'title',
                    'size'    => 'margin_0 regular',
                    'class' => 'depend_button_custom_style element_section_title_area',
                ),

                array(
                    'name'  => 'button_color',
                    'label' => esc_html__( 'Color', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the color of the button.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_button_custom_style',
                ),

                array(
                    'name'  => 'button_hover_color',
                    'label' => esc_html__( 'Hover Color', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the hover color of the button.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_button_custom_style',
                ),

                array(
                    'name'  => 'background_color',
                    'label' => esc_html__( 'Background Color', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the background color of the button.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_button_custom_style',
                ),

                array(
                    'name'  => 'hover_background_color',
                    'label' => esc_html__( 'Hover Background Color', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the hover background color of the button.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_button_custom_style',
                ),

                array(
                    'name'    => 'button_custom_padding',
                    'label'   => __( 'Padding', 'ever-compare' ),
                    'type'    => 'dimensions',
                    'options' => [
                        'top'   => esc_html__( 'Top', 'ever-compare' ),   
                        'right' => esc_html__( 'Right', 'ever-compare' ),   
                        'bottom'=> esc_html__( 'Bottom', 'ever-compare' ),   
                        'left'  => esc_html__( 'Left', 'ever-compare' ),
                        'unit'  => esc_html__( 'Unit', 'ever-compare' ),
                    ],
                    'class' => 'depend_button_custom_style',
                ),

                array(
                    'name'    => 'button_custom_margin',
                    'label'   => __( 'Margin', 'ever-compare' ),
                    'type'    => 'dimensions',
                    'options' => [
                        'top'   => esc_html__( 'Top', 'ever-compare' ),   
                        'right' => esc_html__( 'Right', 'ever-compare' ),   
                        'bottom'=> esc_html__( 'Bottom', 'ever-compare' ),   
                        'left'  => esc_html__( 'Left', 'ever-compare' ),
                        'unit'  => esc_html__( 'Unit', 'ever-compare' ),
                    ],
                    'class' => 'depend_button_custom_style',
                ),

                array(
                    'name'    => 'button_custom_border',
                    'label'   => __( 'Border width', 'ever-compare' ),
                    'type'    => 'dimensions',
                    'options' => [
                        'top'   => esc_html__( 'Top', 'ever-compare' ),   
                        'right' => esc_html__( 'Right', 'ever-compare' ),   
                        'bottom'=> esc_html__( 'Bottom', 'ever-compare' ),   
                        'left'  => esc_html__( 'Left', 'ever-compare' ),
                        'unit'  => esc_html__( 'Unit', 'ever-compare' ),
                    ],
                    'class' => 'depend_button_custom_style',
                ),
                array(
                    'name'  => 'button_custom_border_color',
                    'label' => esc_html__( 'Border Color', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the button color of the button.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_button_custom_style',
                ),

                array(
                    'name'    => 'button_custom_border_radius',
                    'label'   => __( 'Border Radius', 'ever-compare' ),
                    'type'    => 'dimensions',
                    'options' => [
                        'top'   => esc_html__( 'Top', 'ever-compare' ),   
                        'right' => esc_html__( 'Right', 'ever-compare' ),   
                        'bottom'=> esc_html__( 'Bottom', 'ever-compare' ),   
                        'left'  => esc_html__( 'Left', 'ever-compare' ),
                        'unit'  => esc_html__( 'Unit', 'ever-compare' ),
                    ],
                    'class' => 'depend_button_custom_style',
                ),

                array(
                    'name'    => 'table_custom_style_area_title',
                    'headding'=> esc_html__( 'Table custom style', 'ever-compare' ),
                    'type'    => 'title',
                    'size'    => 'margin_0 regular',
                    'class' => 'depend_table_custom_style element_section_title_area',
                ),

                array(
                    'name'  => 'table_border_color',
                    'label' => esc_html__( 'Border color', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the border color of the table.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_table_custom_style',
                ),

                array(
                    'name'    => 'table_column_padding',
                    'label'   => __( 'Column Padding', 'ever-compare' ),
                    'type'    => 'dimensions',
                    'options' => [
                        'top'   => esc_html__( 'Top', 'ever-compare' ),   
                        'right' => esc_html__( 'Right', 'ever-compare' ),   
                        'bottom'=> esc_html__( 'Bottom', 'ever-compare' ),   
                        'left'  => esc_html__( 'Left', 'ever-compare' ),
                        'unit'  => esc_html__( 'Unit', 'ever-compare' ),
                    ],
                    'class' => 'depend_table_custom_style',
                ),

                array(
                    'name'  => 'table_event_color',
                    'label' => esc_html__( 'Column background color (Event)', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the background color of the table event column.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_table_custom_style',
                ),

                array(
                    'name'  => 'table_odd_color',
                    'label' => esc_html__( 'Column background color (Odd)', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the background color of the table odd column.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_table_custom_style',
                ),

                array(
                    'name'  => 'table_heading_event_color',
                    'label' => esc_html__( 'Heading color (Event)', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the heading color of the table event column.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_table_custom_style',
                ),

                array(
                    'name'  => 'table_heading_odd_color',
                    'label' => esc_html__( 'Heading color (Odd)', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the heading color of the table odd column.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_table_custom_style',
                ),

                array(
                    'name'  => 'table_content_event_color',
                    'label' => esc_html__( 'Content color (Event)', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the content color of the table event column.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_table_custom_style',
                ),

                array(
                    'name'  => 'table_content_odd_color',
                    'label' => esc_html__( 'Content color (Odd)', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the content color of the table odd column.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_table_custom_style',
                ),

                array(
                    'name'  => 'table_content_link_color',
                    'label' => esc_html__( 'Content link color', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the content link color of the table.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_table_custom_style',
                ),

                array(
                    'name'  => 'table_content_link_hover_color',
                    'label' => esc_html__( 'Content link hover color', 'ever-compare' ),
                    'desc'  => wp_kses_post( 'Set the content link hover color of the table.', 'ever-compare' ),
                    'type'  => 'color',
                    'class' => 'depend_table_custom_style',
                ),

            ),

        );
        
        return $settings_fields;
    }

    public function plugin_page() {
        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'Compare Settings','ever-compare' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';
    }

    public function save_message() {
        if( isset( $_GET['settings-updated'] ) ) { 
            ?>
                <div class="updated notice is-dismissible"> 
                    <p><strong><?php esc_html_e('Successfully Settings Saved.', 'ever-compare') ?></strong></p>
                </div>
            <?php
        }
    }

}