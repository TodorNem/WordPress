(function ($) {
	jQuery('.wpcf7-uacf7_country_dropdown').each(function(){
		var fieldId = jQuery(this).attr('id');
		var defaultCountry = jQuery(this).attr('country-code');
		
		$("#"+fieldId).countrySelect({
			defaultCountry: defaultCountry,
			// onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
			responsiveDropdown: true,
			preferredCountries: []
		});
	});
})(jQuery);
