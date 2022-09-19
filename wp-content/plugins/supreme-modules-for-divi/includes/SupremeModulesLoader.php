<?php
/*Temporary fix*/
if ( ! function_exists( 'et_core_is_fb_enabled' ) ) :
	function et_core_is_fb_enabled() {
		return function_exists( 'et_fb_is_enabled' ) && et_fb_is_enabled();
	}
endif;
if ( ! function_exists( 'et_divi_divider_style_choices' ) ) :
	/**
	 * Returns divider style choices
	 *
	 * @return array
	 */
	function et_divi_divider_style_choices() {
		return apply_filters(
			'et_divi_divider_style_choices',
			array(
				'solid'  => esc_html__( 'Solid', 'Divi' ),
				'dotted' => esc_html__( 'Dotted', 'Divi' ),
				'dashed' => esc_html__( 'Dashed', 'Divi' ),
				'double' => esc_html__( 'Double', 'Divi' ),
				'groove' => esc_html__( 'Groove', 'Divi' ),
				'ridge'  => esc_html__( 'Ridge', 'Divi' ),
				'inset'  => esc_html__( 'Inset', 'Divi' ),
				'outset' => esc_html__( 'Outset', 'Divi' ),
			)
		);
	}
endif;
/*End of Temporary fix*/
