; (function ($) {
    jQuery(document).ready(function ($) {
        $('.tg-bgcolor').wpColorPicker({
            change: function(event,ui){
                var bgcolor = ui.color.toString();
                $(this).val(bgcolor);
                $(this).val(bgcolor);
            }
        });
    });
})(jQuery);