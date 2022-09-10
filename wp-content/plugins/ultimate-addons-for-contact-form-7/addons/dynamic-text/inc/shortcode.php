<?php 


// Current url Shortcode
if(!function_exists('UACF7_URL')){
    function UACF7_URL($val){ 
        $data = get_permalink();
        return $data;
    }
    add_shortcode('UACF7_URL', 'UACF7_URL'); 
}

// Blog Info Shortcode
if(!function_exists('UACF7_BLOGINFO')){
    function UACF7_BLOGINFO($val){ 
        if(!empty($val['attr'])){ 
           $data =  get_bloginfo($val['attr']); 
        }else{
            $data = get_bloginfo('name');
        }
        return $data;
    }
    add_shortcode('UACF7_BLOGINFO', 'UACF7_BLOGINFO');

}

// POST iNFO Info Shortcode
if(!function_exists('UACF7_POSTINFO')){
    function UACF7_POSTINFO($val){ 
        global $post; 
        $data = '';
        if($val['attr'] == 'post_permalink'){
            $data = get_permalink($post->ID);
        }elseif(!empty($val['attr'])){ 
            $post_attr = $val['attr'];
            $data =  $post->$post_attr;
        }else{
            $data = $post->post_title;
        }
        return $data;
    }
    add_shortcode('UACF7_POSTINFO', 'UACF7_POSTINFO');

}

// User Info Info Shortcode
if(!function_exists('UACF7_USERINFO')){
    function UACF7_USERINFO($val){  
        $data = '';
        if( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
            if(!empty($val['attr'])){
                $user_attr = $val['attr'];
                $data = $current_user->$user_attr;
            }else{
                $data = $current_user->user_nicename;
            } 
        }
        return $data;
    }
    add_shortcode('UACF7_USERINFO', 'UACF7_USERINFO');

}

// Post Custom Fields Shortcode
if(!function_exists('UACF7_CUSTOM_FIELDS')){
    function UACF7_CUSTOM_FIELDS($val){    
        $data ='';
        $value = explode("/",$val['attr']); 
        $id = $value[0];
        $custom_fields = $value[1];
        $data = '';
        if($id > 0){
            $data = get_post_meta($id, $custom_fields, true);
        }
        return $data;
    }
    add_shortcode('UACF7_CUSTOM_FIELDS', 'UACF7_CUSTOM_FIELDS');
}


?>