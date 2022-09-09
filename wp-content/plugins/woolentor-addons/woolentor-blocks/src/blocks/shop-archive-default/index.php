<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( $block['is_editor'] ){
	\WooLentor_Default_Data::instance()->theme_hooks('woolentor-product-archive-addons');
}

$uniqClass 	 = 'woolentorblock-'.$settings['blockUniqId'];
$areaClasses = array( $uniqClass, 'woolentor_block_archive_default' );
!empty( $settings['className'] ) ? $areaClasses[] = $settings['className'] : '';
!empty( $settings['contentAlignment'] ) ? $areaClasses[] = 'woolentor-content-align-'.$settings['contentAlignment'] : '';

if( isset( $settings['saleTagShow'] ) && $settings['saleTagShow'] === false){
	$areaClasses[] = 'woolentor-archive-sale-badge-hide';
}else{
	!empty( $settings['saleTagPosition'] ) ? $areaClasses[] = 'woolentor-archive-sale-badge-'.$settings['saleTagPosition'] : '';
}
// Manage Column
!empty( $settings['columns']['desktop'] ) ? $areaClasses[] = 'woolentor-products-columns-'.$settings['columns']['desktop'] : 'woolentor-products-columns-4';
!empty( $settings['columns']['laptop'] ) ? $areaClasses[] = 'woolentor-products-columns-laptop-'.$settings['columns']['laptop'] : 'woolentor-products-columns-laptop-3';
!empty( $settings['columns']['tablet'] ) ? $areaClasses[] = 'woolentor-products-columns-tablet-'.$settings['columns']['tablet'] : 'woolentor-products-columns-tablet-2';
!empty( $settings['columns']['mobile'] ) ? $areaClasses[] = 'woolentor-products-columns-mobile-'.$settings['columns']['mobile'] : 'woolentor-products-columns-mobile-1';

if ( WC()->session && function_exists( 'wc_print_notices' ) ) {
	wc_print_notices();
}

if ( ! isset( $GLOBALS['post'] ) ) {
	$GLOBALS['post'] = null;
}

$options = [
	'query_post_type'	=> ! empty( $settings['paginate'] ) ? 'current_query' : '',
	'columns' 			=> $settings['columns']['desktop'],
	'rows' 				=> $settings['rows'],
	'paginate' 			=> !empty( $settings['paginate'] ) ? 'yes' : 'no',
	'editor_mode' 		=> $block['is_editor'],
];

if( !empty( $settings['paginate'] ) ){
	$options['paginate'] = 'yes';
	$options['allow_order'] = !empty( $settings['allowOrder'] ) ? 'yes' : 'no';
	$options['show_result_count'] = !empty( $settings['showResultCount'] ) ? 'yes' : 'no';
}else{
	$options['order'] 	= !empty( $settings['order'] ) ? $settings['order'] : 'desc';
	$options['orderby'] = !empty( $settings['orderBy'] ) ? $settings['orderBy'] : 'date';
}

$shortcode 	= new \Archive_Products_Render( $options );
$content 	= $shortcode->get_content();

echo '<div class="'.implode(' ', $areaClasses ).'">';
	if ( strip_tags( trim( $content ) ) ) {
		echo $content;
	} else{
		echo '<div class="products-not-found"><p class="woocommerce-info">' . esc_html__( 'No products were found matching your selection.','woolentor' ) . '</p></div>';
	}
echo '</div>';