;(function ($) {
    'use strict';
    $ ( document ).ready(function() {
      var count_data_shift = 0; 
      $(".uacf7-add-data-shift").click(function(e){ 
        e.preventDefault();
        var count_option = $(this).parent().find('.single_pre_populate_field_wrap select option').length; 
        if(count_option > count_data_shift ){ 
          var clone_field = $(this).parent().find('.single_pre_populate_field_wrap').html(); 
          clone_field = $(this).parent().find('.single_pre_populate_field_wrap_2').append(clone_field.replace('pre_populate_passing','pre_populate_passing_field').replace('display: none !important;', ''));
          count_data_shift++
        }else{
          alert('Total form field is '+count_option);
        }
        
      });
      $(".single_pre_populate_field_wrap_2").on('click', '.uacf7-remove-data-shift', function(e) { 
        e.preventDefault();
         $(this).parent().parent().remove(); 
      });
    });
})(jQuery);
