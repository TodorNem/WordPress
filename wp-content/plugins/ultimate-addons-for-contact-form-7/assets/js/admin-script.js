(function( $ ) {
    $(function() {
         
        // Add Color Picker to all inputs that have 'color-field' class
        $( '.uacf7-color-picker' ).wpColorPicker();
         
    });
})( jQuery );

function uacf7_settings_tab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("uacf7-tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

//Add style to all UACF7 tags
jQuery('.thickbox.button').each(function(){
	var str = jQuery(this).attr('href');

	if (str.indexOf("uacf7") >= 0){
		jQuery(this).css({"backgroundColor": "#487eb0", "color": "white", "border-color": "#487eb0"});
	}
	if (str.indexOf("uarepeater") >= 0){
		jQuery(this).css({"backgroundColor": "#487eb0", "color": "white", "border-color": "#487eb0"});
	}
	if (str.indexOf("conditional") >= 0){
		jQuery(this).css({"backgroundColor": "#487eb0", "color": "white", "border-color": "#487eb0"});
	}
});

//Multistep script
jQuery(document).ready(function(){
    uacf7_progressbar_style();
});
jQuery('#uacf7_progressbar_style').on('change',function(){
    uacf7_progressbar_style();
});
function uacf7_progressbar_style(){
    if( jQuery('#uacf7_progressbar_style').val() == 'default' || jQuery('#uacf7_progressbar_style').val() == 'style-1' ){
        jQuery('.multistep_field_column.show-if-pro').hide();
    }else{
        jQuery('.multistep_field_column.show-if-pro').show();
    }
    
    if( jQuery('#uacf7_progressbar_style').val() == 'style-2' || jQuery('#uacf7_progressbar_style').val() == 'style-3' || jQuery('#uacf7_progressbar_style').val() == 'style-6' ){
        jQuery('.multistep_field_column.show-if-left-progressbar').show();
    }else{
        jQuery('.multistep_field_column.show-if-left-progressbar').hide();
    }
    
    if( jQuery('#uacf7_progressbar_style').val() == 'style-6' ){
        jQuery('.multistep_field_column.show-if-style-6').show();
    }else{
        jQuery('.multistep_field_column.show-if-style-6').hide();
    }
    
    if( jQuery('#uacf7_progressbar_style').val() == 'style-6' ){
        jQuery('.step-title-description').show();
    }else{
        jQuery('.step-title-description').hide();
    }
}
