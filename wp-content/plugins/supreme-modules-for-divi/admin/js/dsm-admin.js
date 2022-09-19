(function($) {
    $(
        function() {
            $('select[name="dsm-header-footer-meta-box-options"]').change(function() {
            	if ($('select[name="dsm-header-footer-meta-box-options"]').val() == '404' || $('select[name="dsm-header-footer-meta-box-options"]').val() == 'search_no_result') {
            		$('.dsm-conditional-meta-box-options, .dsm-css-classes-meta-box-options, .dsm-footer-show-on-blank-template-meta-box-options, .dsm-footer-show-on-404-template-meta-box-options').css("display", "none");
            	} else {
            		$('.dsm-conditional-meta-box-options, .dsm-css-classes-meta-box-options, .dsm-footer-show-on-blank-template-meta-box-options, .dsm-footer-show-on-404-template-meta-box-options').css("display", "block");
            	}
                if ($('select[name="dsm-header-footer-meta-box-options"]').val() == 'top_header' || $('select[name="dsm-header-footer-meta-box-options"]').val() == '404' || $('select[name="dsm-header-footer-meta-box-options"]').val() == 'search_no_result') {
                    $('.dsm-remove-default-footer-meta-box-options, .dsm-footer-show-on-blank-template-meta-box-options, .dsm-footer-show-on-404-template-meta-box-options').css("display", "none");
                } else {
                    $('.dsm-remove-default-footer-meta-box-options, .dsm-footer-show-on-blank-template-meta-box-options, .dsm-footer-show-on-404-template-meta-box-options').css("display", "block");
                }
            });
        }
    )

}(jQuery));