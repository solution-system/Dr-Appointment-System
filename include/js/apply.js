jQuery.noConflict();
jQuery(document).ready(function(jQuery)
{
   jQuery('#ad_loading')
      .hide()  // hide it initially
      .ajaxStart(function() {
          jQuery(this).show();
      })
      .ajaxStop(function() {
          jQuery(this).hide();
   });
   ad_ajax_action('us_states', 'state', '');
   jQuery('input:radio[name=terms]')[0].checked = true;
   if (jQuery("#has_error").val() == "1")
	{
  		jQuery('.apply-form').slideToggle(800, function() {
    		jQuery('.product-form').slideUp(800);
			// jQuery("SELECT").selectbox();
  		});
	}
   else if (jQuery("#ad_has_error").val() == "1")
	{
  		jQuery('.product-form').slideToggle(800, function() {
    		jQuery('.apply-form').slideUp(800);
  		});
	}
	// alert(jQuery("#ad_has_error").val() + ' && ' + jQuery("#FormType").val() + '-->' + (jQuery("#ad_has_error").val() == "1") + ' && ' + (jQuery("#FormType").val() == "advertiser"))
   if (jQuery("#ad_has_error").val() == "1")
   {
       var state =jQuery("#ad_temp_state").val()
       jQuery("#ad_state").val(state);
       var city = jQuery("#ad_temp_city").val();
       var zip = jQuery("#ad_temp_zip").val();
       ad_ajax_action('state', 'city', state);
    	 ad_ajax_action('city', 'zip', city);
    	 jQuery("#ad_state option[value='']").remove();
    	 jQuery("#ad_city option[value='']").remove();
    	 jQuery("#ad_zip option[value='']").remove();
       jQuery("#ad_city").val(city);
       jQuery("#ad_zip").val(zip);
   }
   else if (jQuery("#has_error").val() == "1")
   {
       var state =jQuery("#temp_state").val()
       jQuery("#state").val(state);
       var city = jQuery("#temp_city").val();
       var zip = jQuery("#temp_zip").val();
       ajax_action('state', 'city', state);
    	 ajax_action('city', 'zip', city);
    	 jQuery("#state option[value='']").remove();
    	 jQuery("#city option[value='']").remove();
    	 jQuery("#zip option[value='']").remove();
       jQuery("#city").val(city);
       jQuery("#zip").val(zip);
   }
});
function ad_ajax_action(fld, targett, v)
{
   jQuery('#debug').html('');
	var qs = "FormAction=" + targett + "&filter=" + encodeURIComponent(v);
   debug('qs: ' + qs);
	jQuery('#ad_' + targett).empty();
   jQuery('#ad_zip').empty();
   jQuery.ajax({
      type: "POST",
      url: "/ajax_action.php",
      data: qs,
      dataType: "xml",
      async: false,
      success: function(xml) 
      {
      	var select = jQuery('#ad_' + targett);
      	jQuery(xml).find('menuitem').each(function()
      	{	
      		jQuery(this).find('value').each(function(){
      			var value = jQuery(this).text();
      			var str = value.split(', ');
      			debug(value);
      			select.append("<option class='ddindent' value='"+ str[0] +"'>" + str[1] + "</option>");
      		});
      	});
      },
      error: function(jqXHR, exception) {
           alert(jqXHR + ', ' + exception);
       }
    });
}
leftPos = 0;
topPos = 0;
function popup(slink)
{
    reallyCenterWindow();
    ElementWindow = window.open(slink, 'FirstWin',',scrollbars=yes,location=no,status=no,toolbars=no,width=1000,height=left='+leftPos+',top='+topPos);
    return false;
}
function reallyCenterWindow()
{
   
   if (screen)
   {
      leftPos = (screen.width / 2) - 251
      topPos = (screen.height / 2) - 162
   }
}