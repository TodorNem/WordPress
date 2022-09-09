;(function ($) {
    'use strict';
    
    if (_wpcf7 == null) {
        var _wpcf7 = wpcf7;
    }

    var uacf7_compose = _wpcf7.taggen.compose;

    _wpcf7.taggen.compose = function ( tagType, $form ) {

        var uacf7_tag_close = uacf7_compose.apply( this, arguments );

        if (tagType == 'conditional') uacf7_tag_close += "[/conditional]";

        return uacf7_tag_close;
    };

    var cfList = document.getElementsByClassName("uacf7-cf").length;

    var index = cfList;

    //Triggering the add new rule button
    jQuery('#uacf7-new-cf').on('click', function () {

        uacf7_add_conditional_rule();
        uacf7_cf_count();
        uacf7_remove();
        uacf7_replace_name_attr();

    });

    //Adding conditions in a rule
    function uacf7_add_condition(){
        jQuery(document).on( 'click', '.uacf7-add-condition', function (e) {
            
            e.preventDefault();
            
            var $this = jQuery(this);
			
            var $indexId = $this.attr('data-rule-id');

            var uacf7_new_entry_html = jQuery('#uacf7-new-entry .uacf7-condition-group .uacf7-conditions-wraper').html();

            $this.parent('.uacf7-cf').find('.uacf7-condition-group .uacf7-conditions-wraper').append(uacf7_new_entry_html.replace(/uacf7id/g, $indexId));
            
            //uacf7_replace_conditions_name();
            
            /*
            * Trigger the remove function
            */
            uacf7_remove();
            
            /*
            * Count conditions
            */
            var $total_contition = $this.parent('.uacf7-cf').find('.uacf7-conditions-wraper .uacf7-condition-wrap').length;
            
            $this.parent('.uacf7-cf').find('input#uacf7_conditions_count_ruleid').val($total_contition);

        });
    }
    uacf7_add_condition();

    //Count length of conditions
    function uacf7_cf_count() {

        var cfList = document.getElementsByClassName("uacf7-cf").length;
        jQuery('#uacf7-cf-count').val(cfList);

    }

    //Adding conditional rule
    function uacf7_add_conditional_rule() {

        var uacf7_new_entry_html = jQuery('#uacf7-new-entry').html();

        jQuery('<div id="uacf7-cf-' + index + '" class="uacf7-cf">' + (uacf7_new_entry_html.replace(/uacf7id/g, index)) + '</div>').appendTo('.uacf7-conditional-fields');

        index++;
    }
    
    //Replace rules conditions name with an uinque id
    function uacf7_replace_name_attr() {

        var $count = 0;
        jQuery('.uacf7-cf').each(function () {

            jQuery(this).find('.uacf7-field').each(function () {

                jQuery(this).attr('name', jQuery(this).attr('name').replace(/\b0\b/g, $count));
            });

            $count++;
        });
    }
    
    //Replace conditions name with an uinque id
    function uacf7_replace_conditions_name() {

        jQuery('.uacf7-cf .uacf7-conditions-wraper').each(function () {

            var $count = 0;
            jQuery(this).find('.uacf7-condition-wrap').each(function () {
                jQuery(this).find('.uacf7-field').each(function () {

                    //jQuery(this).attr('name', jQuery(this).attr('name')+'_uacf7childid');
                    jQuery(this).attr('name', jQuery(this).attr('name').replace(/uacf7childid/g, $count));
                    
                });
                $count++;
            });

        });
    }

    //Remove function
    function uacf7_remove() {

        jQuery('.uacf7-remove').on('click', function (e) {
            e.preventDefault();

            var $this = jQuery(this);

            //Remove field
            $this.parent().remove();

            //Replace fields name
            uacf7_replace_name_attr();
            //Count fields
            uacf7_cf_count();
        });
 
        jQuery('.uacf7-remove-group').on('click', function (e) {
            e.preventDefault();

            var $this = jQuery(this);

            //Remove field
            $this.parent().remove();
            
            //Replacing nammes
            //uacf7_replace_conditions_name();
            
        });

    }
    uacf7_remove();

    /*
    * Count conditions
    */
    jQuery('.uacf7-conditions-wraper').on('click', function (e) {
        e.preventDefault();
        
        var $total_contition = jQuery('.uacf7-condition-wrap', this).length;
        jQuery(this).parent('.uacf7-condition-group').find('input#uacf7_conditions_count_ruleid').val($total_contition);
    });
    
})(jQuery);