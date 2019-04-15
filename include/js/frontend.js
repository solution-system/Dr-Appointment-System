var ff = '';
jQuery.noConflict();

jQuery(document).ready(function(jQuery)
{
   jQuery.ajaxSetup({
        data: {
            csrf_test_name: jQuery.cookie('csrf_cookie_name')
        }
    });

   jQuery.noConflict();
   // setInterval("setBlink();",100);
   if (jQuery('#keyword_original').length)
      jQuery('#keyword').val(jQuery('#keyword_original').val());
   jQuery('#loading')
      .hide()  // hide it initially
      .ajaxStart(function() {
          jQuery(this).show();
      })
      .ajaxStop(function() {
          jQuery(this).hide();
   }); 
//   fg_hideform('fg_formContainer','fg_backgroundpopup');
});
function ajaxStart_local()
{
   jQuery('#loading_' + ff).show();
}
function ajaxStop_local()
{
   jQuery('#loading_' + ff).hide();
}
function get_info(id, fld)
{
   ff = fld;
   var qs = "FormAction=get_info&user_id=" + id + "&fld=" + fld;
   jQuery.ajax({
		type: "POST",
		   url: "/ajax_action.php",
		   data: qs,
		   dataType: "text",
		   ajaxStart: window['ajaxStart_local'],
		   ajaxStop: window['ajaxStop_local'],
		   success: function(data)
		   {
            jQuery("#fld_" + fld + "_" + id).text(data);
			},
		   error: function(jqXHR, exception) {
	           alert(jqXHR + ', ' + exception);
	       }
	});
}
function chk_search(kw)
{
   kw = trim(kw);
   // alert('kw: ' + kw);
   if (kw == '')
   {
      return false;
   }
   else
   {
      location.href='/search/processing/' + kw;
      return false;
   }
}

function setBlink()
{
   jQuery("#blink").fadeOut(1000, function () {
       jQuery("#blink").fadeIn();
   });
}
function trim(str, chars) {
	return ltrim(rtrim(str, chars), chars);
}
 
function ltrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
function debug(str)
{
   jQuery("#debug").html(jQuery("#debug").html() + "<br>" + str);
}
function replaceAll(txt, replace, with_this) {
  return txt.replace(new RegExp(replace, 'g'),with_this);
}

function write_data(str)
{
   // alert('/include/write_data.php?data=');
    jQuery.ajax({
               type: "POST",
               url: '/include/write_data.php?data=' + str,
               dataType: "text",
               async: false,
               success: function(data)
               {
                  update = true;
               },
               error: function(jqXHR, exception) {
                    error_caught(jqXHR, exception);
                }
               });
}