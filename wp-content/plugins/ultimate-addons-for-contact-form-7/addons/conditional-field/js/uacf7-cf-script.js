;(function ($) {
    'use strict';

    jQuery(document).ready(function () {

        uacf7_cf_handler();

        jQuery(document).on('keyup', '.wpcf7-form input:not(.wpcf7-uacf7_country_dropdown, .wpcf7-uacf7_city, .wpcf7-uacf7_state, .wpcf7-uacf7_zip), .wpcf7-form textarea', function () {
            uacf7_cf_handler();
        });

        jQuery(document).on('change', '.wpcf7-form select:not(.wpcf7-uacf7_product_dropdown), .wpcf7-form input[type="radio"]:not(.uacf7-rating input[type="radio"])', function () {
            uacf7_cf_handler();
        });
        
        jQuery(document).on('change', 'input[type="checkbox"]', function () {
            uacf7_cf_handler();
        });

    });

    /*
     * Conditional script
     */
    function uacf7_cf_handler() {

        jQuery('form.wpcf7-form').each(function () {

            var contactFormId = jQuery('input[name="_wpcf7"]', this).val();

            var form = uacf7_cf_object[contactFormId];

            var $i = 0;
            
			jQuery(form).each(function(){
				var $uacf7_cf_conditions = form[$i]['uacf7_cf_conditions'];
				
				var $conditionsLength = $uacf7_cf_conditions['uacf7_cf_tn'].length;
				
				/*
				* Checking validation.
				*/
                if ( $conditionsLength > 0 && form[$i]['uacf7_cf_group'] != '' ) { /* If tag name not empty */

					/* Fileds value */
                    var vaL = jQuery('.wpcf7-form [name="' + $uacf7_cf_conditions['uacf7_cf_tn'] + '"]').val();

                    if (jQuery('.wpcf7-form [name="' + $uacf7_cf_conditions['uacf7_cf_tn'] + '"]').is("input[type='radio']")) {

                        var vaL = jQuery('.wpcf7-form [name="' + $uacf7_cf_conditions['uacf7_cf_tn'] + '"]:checked').val();
                    }
					
					/* 
					* Conditions
					*/
                    if ( form[$i]['uacf7_cf_hs'] == 'show' ) { /*-If show*/
						/* Hide by default, if 'show' */
                        jQuery('.uacf7_conditional.' + form[$i]['uacf7_cf_group'] + '').hide().addClass('uacf7-hidden');
					}
					
					var $conditionRule = '';
					var x;
					var $conditions = [];
					for (x = 0; x < $conditionsLength; x++) {
					  
                        var maybeChecked = '';
                        var maybeMultiple = '';
                        
                        if (jQuery('.wpcf7-form [name="' + $uacf7_cf_conditions['uacf7_cf_tn'][x] + '"]').is("input[type='radio']")) {

                            var maybeChecked = ':checked';
                        }
                        
                        var checkedItem = '';
                        
                        if( jQuery('.wpcf7-form [name="' + $uacf7_cf_conditions['uacf7_cf_tn'][x] + '"]').is("input[type='checkbox']") ) {
                            
                            var maybeChecked = ':checked';
                            var maybeMultiple = '[]';
                            
                            var checked_values = [];
                            jQuery('.wpcf7-form [name="' + $uacf7_cf_conditions['uacf7_cf_tn'][x] + '"]:checked').each(function(){
                                
                                checked_values.push( jQuery(this).val() );
                            });
                            
                            var index = checked_values.indexOf($uacf7_cf_conditions['uacf7_cf_val'][x]);
                            
                            var checkedItem = checked_values[index];
                            
                        }

						//Repeater support
						var tagName = $uacf7_cf_conditions['uacf7_cf_tn'][x].replace('[]', '');
						
						if( jQuery('.wpcf7-form [uacf-original-name="' + $uacf7_cf_conditions['uacf7_cf_tn'][x] + '"]').is("input[type='checkbox']") || jQuery('.wpcf7-form [uacf-original-name="' + $uacf7_cf_conditions['uacf7_cf_tn'][x] + '"]').is("input[type='radio']") ) {
                            
                            var maybeChecked = ':checked';
                            var maybeMultiple = '[]';
                            
                            var checked_values = [];
							//Repeater support
                            jQuery('.wpcf7-form-control-wrap.'+tagName+' input:checked').each(function(){
                                
                                checked_values.push( jQuery(this).val() );
                            });
                            
                            var index = checked_values.indexOf($uacf7_cf_conditions['uacf7_cf_val'][x]);
                            
                            var checkedItem = checked_values[index];
                            
                        }
						
                        var currentValue = jQuery('.wpcf7-form [name="' + $uacf7_cf_conditions['uacf7_cf_tn'][x] + '"]'+maybeChecked+'').val();
						
						if( typeof currentValue === 'undefined' ){
							var currentValue = jQuery('.wpcf7-form [uacf-original-name="' + $uacf7_cf_conditions['uacf7_cf_tn'][x] + '"]'+maybeChecked+'').val();
						}
						
						if( typeof currentValue === 'undefined' ){
							var currentValue = jQuery('.uacf7_repeater .wpcf7-form-control-wrap.'+tagName+' input'+maybeChecked+'').val();
						}

                        if( jQuery('.wpcf7-form [name="' + $uacf7_cf_conditions['uacf7_cf_tn'][x] + '"]').is("input[type='checkbox']") ) {
                            
                            if(typeof checkedItem === 'undefined') {
                                var currentValue = '';
                            }else {
                                var currentValue = checkedItem;
                            }

                        }
                        
						if( $uacf7_cf_conditions['uacf7_cf_operator'][x] == 'equal' ) {
                            
							if ( currentValue == $uacf7_cf_conditions['uacf7_cf_val'][x] ) {

								$conditions.push('true');

							}else {
								$conditions.push('false');

							}
						}

						if( $uacf7_cf_conditions['uacf7_cf_operator'][x] == 'not_equal' ) {

							if ( currentValue != $uacf7_cf_conditions['uacf7_cf_val'][x] ) {

								$conditions.push('true');

							}else {
								$conditions.push('false');

							}
						}

						if( $uacf7_cf_conditions['uacf7_cf_operator'][x] == 'greater_than' ) {
                            
							if ( parseInt(currentValue) > parseInt($uacf7_cf_conditions['uacf7_cf_val'][x]) ) {

								$conditions.push('true');

							}else {
								$conditions.push('false');

							}
						}

						if( $uacf7_cf_conditions['uacf7_cf_operator'][x] == 'less_than' ) {

							if ( parseInt(currentValue) < parseInt($uacf7_cf_conditions['uacf7_cf_val'][x]) ) {

								$conditions.push('true');

							}else {
								$conditions.push('false');

							}
						}

						if( $uacf7_cf_conditions['uacf7_cf_operator'][x] == 'greater_than_or_equal_to' ) {

							if ( parseInt(currentValue) >= parseInt($uacf7_cf_conditions['uacf7_cf_val'][x]) ) {

								$conditions.push('true');

							}else {
								$conditions.push('false');

							}
						}

						if( $uacf7_cf_conditions['uacf7_cf_operator'][x] == 'less_than_or_equal_to' ) {

							if ( parseInt(currentValue) <= parseInt($uacf7_cf_conditions['uacf7_cf_val'][x]) ) {

								$conditions.push('true');

							}else {
								$conditions.push('false');

							}
						}

					}

					if( form[$i]['uacf_cf_condition_for'] === 'all' ) {

						var equalResult = $conditions.indexOf("false");

						if ( form[$i]['uacf7_cf_hs'] == 'show' ) {

							if(equalResult == -1){ //IF not false and all true

								jQuery( '.uacf7_conditional.' + form[$i]['uacf7_cf_group'] +'').show().removeClass('uacf7-hidden');

							}else{

								jQuery( '.uacf7_conditional.' + form[$i]['uacf7_cf_group'] + '').hide().addClass('uacf7-hidden');
							}

						}else {

							if(equalResult == -1){ //IF not false and all true

								jQuery('.uacf7_conditional.' + form[$i]['uacf7_cf_group'] + '').hide().addClass('uacf7-hidden');

							}else{

								jQuery('.uacf7_conditional.' + form[$i]['uacf7_cf_group'] + '').show().removeClass('uacf7-hidden');
							}

						}
					}else {

						var orResult = $conditions.indexOf("true");

						if ( form[$i]['uacf7_cf_hs'] == 'show' ) {

							if(orResult != -1){ //IF true or false

								jQuery( '.uacf7_conditional.' + form[$i]['uacf7_cf_group'] +'').show().removeClass('uacf7-hidden');

							}else{

								jQuery( '.uacf7_conditional.' + form[$i]['uacf7_cf_group'] + '').hide().addClass('uacf7-hidden');
							}

						}else {

							if(orResult == -1){ //IF true or false

								jQuery('.uacf7_conditional.' + form[$i]['uacf7_cf_group'] + '').hide().addClass('uacf7-hidden');

							}else{

								jQuery('.uacf7_conditional.' + form[$i]['uacf7_cf_group'] + '').show().removeClass('uacf7-hidden');
							}

						}

					}
							
                }

                $i++;
            });

        });

        uacf7_skip_validation();
    }

    /*
     * Skip validation
     */
    function uacf7_skip_validation() {

        jQuery('form.wpcf7-form').each(function () {

            var $form = jQuery(this);
            var hidden_fields = [];
            jQuery('.uacf7_conditional', $form).each(function () {
                var $this = jQuery(this);

                if ($this.hasClass('uacf7-hidden')) {

                    $this.find('input,select,textarea').each(function () {
                        hidden_fields.push(jQuery(this).attr('name'));
                    });
                }
            });
            $form.find('[name="_uacf7_hidden_conditional_fields"]').val(JSON.stringify(hidden_fields));

            $form.on('submit', function () {
                uacf7_skip_validation();
            });

        });
    }

})(jQuery);
