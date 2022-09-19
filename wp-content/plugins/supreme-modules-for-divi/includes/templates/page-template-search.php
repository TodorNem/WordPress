<?php
/*
Template Name: Search Page
*/

get_header();
?>
<div id="main-content">
<?php 
    $search_no_result_args = array(
        'post_type' => 'dsm_header_footer',
        'meta_key'     => 'dsm-header-footer-meta-box-options',
        'meta_value'   => 'search_no_result',
        'meta_type'    => 'post',
        'meta_query'     => array(
            array(
                'key'     => 'dsm-header-footer-meta-box-options',
                'value'   => 'search_no_result',
                'compare' => '==',
                'type'    => 'post',
            ),
        ),
    );

    $search_no_result_template = new WP_Query(
        $search_no_result_args
    );

    if ( $search_no_result_template->have_posts() ) {
        $search_no_result_template_ID = $search_no_result_template->post->ID;
        $search_no_result_template_shortcode = do_shortcode( get_post_field( 'post_content', $search_no_result_template_ID ) );
        echo $search_no_result_template_shortcode;
    } else {
        ?>
        <div class="container">
            <div id="content-area" class="clearfix">
                <div id="left-area">
                    <?php get_template_part( 'includes/no-results', '404' ); ?>
                </div> <!-- #left-area -->
                <?php get_sidebar(); ?>
            </div> <!-- #content-area -->
        </div> <!-- .container -->
    <?php     
    }
?>

</div> <!-- #main-content -->

<?php
    $footer_args = array(
        'post_type' => 'dsm_header_footer',
        'meta_key'     => 'dsm-header-footer-meta-box-options',
        'meta_value'   => 'footer',
        'meta_type'    => 'post',
        'meta_query'     => array(
            array(
                'key'     => 'dsm-header-footer-meta-box-options',
                'value'   => 'footer',
                'compare' => '==',
                'type'    => 'post',
            ),
        ),
    );

    $footer_template = new WP_Query(
        $footer_args
    );

    $footer_css_args = array(
        'post_type' => 'dsm_header_footer',
        'meta_key'     => 'dsm-css-classes-meta-box-options',
        'value' => '',
        'meta_type'    => 'post',
        'meta_query'     => array(
            array(
                'key'     => 'dsm-css-classes-meta-box-options',
                'value'   => '',
                'compare' => '!=',
                'type'    => 'post',
            ),
        ),
    );

    $footer_css_template = new WP_Query(
        $footer_css_args
    );

    if ( $footer_template->have_posts() ) {
        if( !function_exists('dsm_fix_shortcodes') ) {
            function dsm_fix_shortcodes($content){
                $array = array (
                    '<p>[' => '[', 
                    ']</p>' => ']', 
                    ']<br />' => ']'
                );
                $content = strtr($content, $array);
                return $content;
            }
            add_filter('the_content', 'dsm_fix_shortcodes');
        }
        $footer_template_ID = $footer_template->post->ID;
        $footer_template_shortcode = do_shortcode( get_post_field( 'post_content', $footer_template_ID ) );
        $footer_template_css = get_post_custom($footer_template_ID);

        if ( $footer_template_css['dsm-css-classes-meta-box-options'][0] != '' ) {
            $footer_template_css_output = get_post_meta( $footer_css_template->post->ID, 'dsm-css-classes-meta-box-options', true );
        } else {
            $footer_template_css_output = '';
        }
        if ( !et_core_is_fb_enabled() ) {
            $footer_output = sprintf(
                '<footer id="dsm-footer" class="%2$s" itemscope="itemscope" itemtype="https://schema.org/WPFooter">%1$s</footer>
                ',
                $footer_template_shortcode,
                ( '' !== $footer_template_css_output ? 'dsm-footer ' . $footer_template_css_output : 'dsm-footer' )
            );
            echo $footer_output;
        }
    }
    get_footer();