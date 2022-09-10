jQuery(document).ready(function () {
	//Conditional check
	function uacf7_redirect_conditional_field() {
		var uacf7_redirect_to_type = jQuery('input.uacf7_redirect_to_type:checked').val();

		if (uacf7_redirect_to_type == 'to_page') {
			jQuery('.uacf7_redirect_to_page').show();
			jQuery('.uacf7_redirect_to_url').hide();
		} else {
			jQuery('.uacf7_redirect_to_url').show();
			jQuery('.uacf7_redirect_to_page').hide();
		}
	}
	uacf7_redirect_conditional_field();
	
	jQuery('input.uacf7_redirect_to_type').on('change', function(){
		uacf7_redirect_conditional_field();
	});
	
	jQuery('.uacf7_conditional_redirect_add_btn .uacf7_cr_btn').on('click',function(e){
		e.preventDefault();
		var $uacf7_cr = jQuery('.uacf7_cr_copy').html().replace(/uacf7_cr_tagname/g, 'uacf7_cr_tn[]').replace(/uacf7_cr_field_value/g, 'uacf7_cr_field_val[]').replace(/uacf7_cr_redirect_to_url_value/g, 'uacf7_cr_redirect_to_url[]');
		jQuery($uacf7_cr).appendTo('.uacf7_conditional_redirect_conditions');
	});
	
	jQuery(document).on('click', '.uacf7_cr_remove_row', function (e) {
		e.preventDefault();

		var $this = jQuery(this);

		//Remove row
		$this.parents('.uacf7_conditional_redirect_condition').remove();

	});
	
	
	/* Conditional Redirect type */
	function uacf7_conditional_redirect_type() {
    
        if( jQuery('#uacf7_redirect_type').is(':checked') ) {
            
            jQuery('.uacf7_default_redirect_wraper').hide();
            jQuery('.uacf7_conditional_redirect_wraper').show();
        }else {
            jQuery('.uacf7_default_redirect_wraper').show();
            jQuery('.uacf7_conditional_redirect_wraper').hide();
        }
    }
    uacf7_conditional_redirect_type();
    
    jQuery('#uacf7_redirect_type').on('click', function(){
        uacf7_conditional_redirect_type();
    });
	
});