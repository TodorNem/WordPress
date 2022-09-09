<?php

if( !function_exists( 'uacf7_addons_included' ) ) {

    function uacf7_addons_included(){
    
        //Addon - Ultimate redirect
        if( uacf7_checked('uacf7_enable_redirection') != '' ){
            require_once( 'redirection/redirect.php' );
        }

        //Addon - Ultimate conditional field
        if( uacf7_checked('uacf7_enable_conditional_field') != '' ){
            require_once( 'conditional-field/conditional-fields.php' );
        }

        //Addon - Ultimate field Column
        if( uacf7_checked('uacf7_enable_field_column') != '' ){
            require_once( 'column/column.php' );
        }

        //Addon - Ultimate Placeholder
        if( uacf7_checked('uacf7_enable_placeholder') != '' ){
            require_once( 'placeholder/placeholder.php' );
        }

        //Addon - Ultimate Mutlistep
        if( uacf7_checked('uacf7_enable_multistep') != '' ){
            require_once( 'multistep/multistep.php' );
        }

        //Addon - Ultimate Style
        if( uacf7_checked('uacf7_enable_uacf7style') != '' ){
            require_once( 'styler/uacf7style.php' );
        }

        //Addon - Ultimate Product Dropdown
        if( uacf7_checked('uacf7_enable_product_dropdown') != '' ){
            require_once( 'product-dropdown/product-dropdown.php' );
        }

        //Addon - Ultimate Star Rating
        if( uacf7_checked('uacf7_enable_star_rating') != '' ){
            require_once( 'star-rating/star-rating.php' );
        }

        //Addon - Ultimate Price Slider
        if( uacf7_checked( 'uacf7_enable_range_slider') != ''){
            require_once( 'range-slider/range-slider.php');
        }
		
        //Addon - Country Dropdown
        if( uacf7_checked( 'uacf7_enable_country_dropdown_field') != ''){
            require_once( 'country-dropdown/country-dropdown.php');
        }

        //Addon - Mailchimp
        if( uacf7_checked( 'uacf7_enable_mailchimp') != ''){
            require_once( 'mailchimp/mailchimp.php');
        }
		
        //Addon - Dynamic Text
        if( uacf7_checked( 'uacf7_enable_dynamic_text') != ''){
            require_once( 'dynamic-text/dynamic-text.php');
        }
		
    }
}

uacf7_addons_included();