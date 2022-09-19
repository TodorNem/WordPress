<?php
/*
Template Name: 404 Blank Page
*/

get_header();
?>
<div id="main-content">
<?php 
    $fourzerofour_args = array(
        'post_type' => 'dsm_header_footer',
        'meta_key'     => 'dsm-header-footer-meta-box-options',
        'meta_value'   => '404',
        'meta_type'    => 'post',
        'meta_query'     => array(
            array(
                'key'     => 'dsm-header-footer-meta-box-options',
                'value'   => '404',
                'compare' => '==',
                'type'    => 'post',
            ),
        ),
    );

    $fourzerofour_template = new WP_Query(
        $fourzerofour_args
    );

    if ( $fourzerofour_template->have_posts() ) {
        $fourzerofour_template_ID = $fourzerofour_template->post->ID;
        $fourzerofour_template_shortcode = do_shortcode( get_post_field( 'post_content', $fourzerofour_template_ID ) );
    ?>
        <article id="post-0" <?php post_class( 'not_found' ); ?>>
            <?php echo $fourzerofour_template_shortcode; ?>
        </article> <!-- .et_pb_post -->
    <?php } else {
        ?>
        <div class="container">
            <div id="content-area" class="clearfix">
                <div id="left-area">
                    <article id="post-0" <?php post_class( 'et_pb_post not_found' ); ?>>
                        <?php get_template_part( 'includes/no-results', '404' ); ?>
                    </article> <!-- .et_pb_post -->
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
        if ( !et_core_is_fb_enabled() && $footer_template_css['dsm-footer-show-on-404-template'][0] == 'yes' ) {
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