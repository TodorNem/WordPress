<?php
    
    defined( 'ABSPATH' ) || exit;
    
    if ( ! class_exists( 'Woo_Variation_Swatches_Manage_Cache' ) ) {
        class Woo_Variation_Swatches_Manage_Cache {
            
            protected static $_instance = null;
            
            protected function __construct() {
                $this->includes();
                $this->hooks();
                $this->init();
                do_action( 'woo_variation_swatches_manage_cache_loaded', $this );
            }
            
            public static function instance() {
                if ( is_null( self::$_instance ) ) {
                    self::$_instance = new self();
                }
                
                return self::$_instance;
            }
            
            protected function includes() {
            }
            
            protected function hooks() {
                
                // Attributes
                add_action( 'woocommerce_attribute_added', array( $this, 'clear_transient' ) );
                add_action( 'woocommerce_attribute_updated', array( $this, 'clear_transient' ) );
                add_action( 'woocommerce_attribute_deleted', array( $this, 'clear_transient' ) );
                // Products
                add_action( 'woocommerce_save_product_variation', array( $this, 'clear_transient' ) );
                add_action( 'woocommerce_update_product_variation', array( $this, 'clear_transient' ) );
                add_action( 'woocommerce_delete_product_variation', array( $this, 'clear_transient' ) );
                add_action( 'woocommerce_trash_product_variation', array( $this, 'clear_transient' ) );
                
                // WooCommerce -> Status -> Tools -> Clear transients
                add_action( 'woocommerce_delete_product_transients', array( $this, 'clear_transient' ) );
                add_action( 'getwooplugins_update_options', array( $this, 'clear_transient' ) );
                add_action( 'getwooplugins_delete_options', array( $this, 'clear_transient' ) );
            }
            
            protected function init() {
            }
            
            // start
            
            public function clear_transient() {
                
                // Increments the transient version to invalidate cache.
                if ( method_exists( 'WC_Cache_Helper', 'get_transient_version' ) ) {
                    WC_Cache_Helper::get_transient_version( 'wvs_template', true );
                    WC_Cache_Helper::get_transient_version( 'wvs_attribute_taxonomy', true );
                    WC_Cache_Helper::get_transient_version( 'wvs_archive_template', true );
                    WC_Cache_Helper::get_transient_version( 'wvs_variation_attribute_options_html', true );
                }
                
                if ( method_exists( 'WC_Cache_Helper', 'invalidate_cache_group' ) ) {
                    WC_Cache_Helper::invalidate_cache_group( 'wvs_template' );
                    WC_Cache_Helper::invalidate_cache_group( 'wvs_attribute_taxonomy' );
                    WC_Cache_Helper::invalidate_cache_group( 'wvs_archive_template' );
                    WC_Cache_Helper::invalidate_cache_group( 'wvs_variation_attribute_options_html' );
                }
            }
        }
    }
	