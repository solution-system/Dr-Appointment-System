//jQuery.noConflict();
//jQuery(document).ready(function(jQuery)
//{
//   jQuery.noConflict();
//   ajax_action('us_states', 'state', '');
//});
function ajax_action(fld, targett, v)
{
   var vSelect = '';
	var qs = "FormAction=" + targett + "&filter=" + encodeURIComponent(v);
   // var targett = jQuery('#' + targ).attr('id');
   // debug('targett: ' + targett + '--- qs: ' + qs);
   if (jQuery('.zip_name').length)
      jQuery('.zip_name').empty();
	jQuery.ajax({
      type: "GET",
      url: "/ajax_action.php",
      data: qs,
      dataType: "xml",
      async: false,
      success: function(xml) 
      {
      	var selectId = jQuery('.' + targett + '_name');
      	debug('selectId: ' + selectId.attr('id'));
      	jQuery(xml).find('menuitem').each(function()
      	{	
      		jQuery(this).find('value').each(function()
      		{
      			var value = jQuery(this).text();
      			var str = value.split(', ');
      			//debug(i++ + ' ==> ' + jQuery(this).text());
      			vSelect +="<option class='ddindent' value='"+ str[0] +"'>" + str[1] + "</option>";
      		});
      	});
         jQuery(selectId).html( vSelect );
      },
      error: function(jqXHR, exception)
      {
           alert(jqXHR + ', ' + exception);
      }
   });
}