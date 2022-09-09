(function ($) {

	$(document).ready(function ($) {

		// Tabs Start.
		// Change tab class and display content
		$('.tabs-nav a').on('click', function (event) {
		    event.preventDefault();

		    $('.tab-active').removeClass('tab-active');
		    $(this).parent().addClass('tab-active');
		    $('.tabs-stage .ui-sortable').hide();
		    $($(this).attr('href')).show();
		});

		$('.tabs-nav a:first').trigger('click'); // Default
		// Tabs end.

		$('.form-table').find('td').each(function(){
			var field = $(this).find('input').attr('id');
			$(this).parent().addClass( field );
		});

	});

})(jQuery);
