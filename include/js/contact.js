
jQuery.noConflict();
jQuery(document).ready(function(jQuery)
{
   ajax_action('us_states', 'state', '');
});
function contact_form()
{
   msg = '';
   // temp = '';
   if (jQuery("#to_email").length == 0)
   {
      if (jQuery("#to_email").val().length == 0)
         msg += "- Expert's email is not given, so contact is not possible for now...<br>";
   }
   if (jQuery("#first_name").length)
   {
      if (jQuery("#first_name").val().length == 0)
         msg += "- Enter the first-name first<br>";
   }
   if (jQuery("#last_name").length)
   {
      if (jQuery("#last_name").val().length == 0)
         msg += "- Enter the last-name first<br>";
   }
   if (jQuery("#email").length)
   {
      if (jQuery("#email").val().length == 0)
         msg += "- Enter the email first<br>";
      else if (validateEmail(jQuery("#email").val()) == false)
         msg += "- Enter valid email address<br>";
   }
   if (jQuery("#phone").length)
   {
      if (jQuery("#phone").val().length == 0)
         msg += "- Enter the phone# first<br>";
   }
   if (jQuery("#stat").length)
   {
      if (jQuery("#state option:selected").val().length == 0)
         msg += "- Select the state first<br>";
   }
   if (jQuery("#city").length)
   {
      if (count_combo("city") == '0')
         msg += "- Select the city first<br>";
      else if (jQuery("#city option:selected").val().length == 0)
         msg += "- Select the city first<br>";
   }
   if (jQuery("#FormAction").val() == '')
   {
      if (count_combo("zip") == '0')
         msg += "- Select the zip-code first<br>";
      else if (jQuery("#zip option:selected").val().length == 0)
         msg += "- Select the zip-code first<br>";
   }
   if (jQuery("#FormAction").val() == 'company_contact')
   {
      if (jQuery("#zip").val().length == 0)
         msg += "- Enter the zip-code first<br>";
      else if (jQuery("#zip").val().length !== 5)
         msg += jQuery("#zip").val().length + "- Enter valid zip-code first<br>";
   }
   if (jQuery("#comments").val().length == 0)
      msg += "- Enter the comments first<br>";
   if (msg !== "")
   {
       jQuery("#msg").html('<font color=red><b>Error: </b><br>' + msg + '</font>');
       return false;
   }
   else
   {
      jQuery('#loading')
      .hide()  // hide it initially
      .ajaxStart(function() {
          jQuery(this).show();
      })
      .ajaxStop(function() {
          jQuery(this).hide();
   });
   // alert(jQuery("#frm_contact").serialize());
      jQuery("#tbl_contact").hide();
      jQuery("#msg").html('');
      jQuery.ajax({
         type: "POST",
         url: "/sendmail.php",
         dataType: "html",
         data: jQuery("#frm_contact").serialize(),
         async: false,
         success: function(data)
         {
            if (data !== '1')
            {
               page_now = window.location.pathname.substring(window.location.pathname.lastIndexOf("/")+1);
               // alert(page_now);
               if (page_now !== 'contact')
               	person = 'Snell Experts';
               else
                  person = 'Site Administrator';
               msg = '<p align="center"><br><br>Your message has been sent to ' + person + '! ' +
                        	'<br><br></p>';
               if (page_now !== 'contact')
               	msg +=	'<div align=center>' +
               		'    <br><br><input type="button" onclick="javascript:disablePopup();" value="Close">' +
               		'</div>';
               jQuery("#contact_result").html(msg);
            }
         },
         error: function(jqXHR, exception) {
            alert(jqXHR + ', ' + exception);
         }
    });
    return false;
   }
}
function count_combo(combo)
{
   return jQuery('#' + combo + ' option').length;
}
