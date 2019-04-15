function ajax_action(fld, targett, v)
{
  return;
   // jQuery('#debug').html('');
   // alert(fld + ' -->' + jQuery("#" + fld + " option:selected").text());
   if (fld == 'us_states')
   {
      // alert(fld + ' -->' + jQuery("#state option:selected").text());
      jQuery("#result").html('<p>Select option(s) or click any link for search now... State: ' + jQuery("#state option:selected").text() + ' </p>');
   }
   else
      jQuery("#result").html('<p>Select option(s) or click any link for search now... State: ' + jQuery("#state option:selected").text() + ' City: ' + v + '</p>');
	var qs = "FormAction=" + targett + "&filter=" + encodeURIComponent(v);
   debug('qs: ' + qs);
	jQuery('#' + targett).empty();
	if (targett == 'city')
	{
       // alert(targett + '-->' + jQuery('#zip').length);
       jQuery('#zip').empty();
	}
   jQuery('#zip').empty();
   jQuery.ajax({
    type: "POST",
       url: "/admin/state_xml",
       data: qs,
       dataType: "xml",
       async: false,
       success: function(xml) 
       {
        var select = jQuery('#' + targett);
        //jQuery(xml).find('menuitem').each(function()
        //{ 
          jQuery(this).find('value').each(function(){
            var value = jQuery(this).text();
            var str = value.split(', ');
            // debug(value);
            select.append("<option class='ddindent' value='"+ str[0] +"'>" + str[1] + "</option>");
          });
       // });
      },
       error: function(jqXHR, exception) {
              alert(jqXHR + ', ' + exception);
          }
     });
}
function show_result(str)
{
    if (jQuery("#result").length)
    {
      if (str !== "")
      {
        str = jQuery("#result").html().replace("<p>", "").replace("</p>", "") + str;
        jQuery("#result").html("<p>" + str + "</p>");
      }
    }
}
