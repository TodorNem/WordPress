<?php
/**
 * Plugin Name: Ultimate Addons for Contact Form 7
 * Plugin URI: https://cf7addons.com/
 * Description: 20+ Essential Addons for Contact form 7 including Conditional Fields, Multi Step Form, Thank you page Redirection, Columns Layout, WooCommerce Integration, Star Rating Fields, Range Slider and many more stunning Addons, all in one.
 * Version: 3.0.8
 * Author: Themefic
 * Author URI: https://themefic.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: ultimate-addons-cf7
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Class Ultimate_Addon_CF7
*/
class Ultimate_Addons_CF7 {
    
    /*
    * Construct function
    */
    public function __construct() {
        define( 'UACF7_URL', plugin_dir_url( __FILE__ ) );
        define( 'UACF7_ADDONS', UACF7_URL.'addons' );
        define( 'UACF7_PATH', plugin_dir_path( __FILE__ ) );
        
        //Plugin loaded
        add_action( 'plugins_loaded', array( $this, 'uacf7_plugin_loaded' ) );
    }
	
    /*
    * Ultimate addons loaded
    */
    public function uacf7_plugin_loaded() {
        //Register text domain
        load_plugin_textdomain( 'ultimate-addons-cf7', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
        
        if(class_exists('WPCF7')){
            //Init ultimate addons
            $this->uacf7_init();
        
        }else{
            //Admin notice
            add_action( 'admin_notices', array( $this, 'uacf7_admin_notice' ) );
        }
    }
    
    /*
    * Admin notice- To check the Contact form 7 plugin is installed
    */
     public function uacf7_admin_notice(){
        ?>
        <div class="notice notice-error">
            <p>
               <?php printf(
                __('%s requires %s to be installed and active. You can install and activate it from %s', 'ultimate-addons-cf7'), '<strong>Ultimate Addons for Contact Form 7</strong>', '<strong>Contact form 7</strong>', '<a href="'.admin_url('plugin-install.php?tab=search&s=contact+form+7').'">here</a>.'
            ); ?></p>
        </div>
        <?php
    }
    
    /*
    * Init ultimate addons
    */
    public function uacf7_init() {
        
        //Require ultimate functions
        require_once( 'inc/functions.php' );
        
        //Enqueue admin scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        
        //Require admin menu
        require_once( 'admin/admin-menu.php' );
        
        //Require ultimate addons
        require_once( 'addons/addons.php' );
    }
    
    //Enquene admin scripts
    public function enqueue_admin_scripts(){
        
        wp_enqueue_style( 'uacf7-admin-style', UACF7_URL . 'assets/css/admin-style.css', 'sadf' );
        
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'uacf7-admin-script', UACF7_URL . 'assets/js/admin-script.js', array('jquery'), null, true );
    }
    
}

/*
* Object - Ultimate_Addons_CF7
*/
$ultimate_addons_cf7 = new Ultimate_Addons_CF7();
