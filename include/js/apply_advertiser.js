
jQuery.noConflict();
jQuery(document).ready(function(jQuery)
{
   var $radios = jQuery('input:radio[name=ad_terms]');
    if($radios.is(':checked') === false)
    {
        $radios.filter('[value=1]').attr('checked', true);
    }
});
function chk_advertiser(d, area)
{
   // alert(d.ad_first_name);
   var msg = '';
   var temp = '';

   if (d.ad_first_name !== undefined)
      msg += (chk_length(area, d.ad_first_name, "enter"));
   if (d.ad_last_name !== undefined)
      msg += (chk_length(area, d.ad_last_name, "enter"));
   if (d.ad_address !== undefined)
      msg += (chk_length(area, d.ad_address, "enter"));
   if (d.ad_state !== undefined)
      msg += (chk_length(area, d.ad_state, "select"));
   if (d.ad_city !== undefined)
      msg += (chk_length(area, d.ad_city, "select"));
   if (d.ad_zip !== undefined)
      msg += (chk_length(area, d.ad_zip, "select"));
   if (d.ad_budget !== undefined)
   {
      if ((d.ad_budget.value == 'Example: $300 to $600 per month') || (d.ad_budget.value == ''))
         msg += "\n - Please enter your budget";
   }

   if (d.ad_email !== undefined)
      msg += (chk_length(area, d.ad_email, "enter"));
   if (d.ad_company_email !== undefined)
      msg += (chk_length(area, d.ad_company_email, "enter"));
   if (d.ad_phone1 !== undefined)
      temp = (chk_length(area, d.ad_phone1, "enter"));
   if (temp !== "")
      msg += (validate_phone(d.ad_phone1, "phone1", area));
   if (d.ad_email !== undefined)
   {
      if (d.ad_email.value !== "")
      {
         if (validateEmail(d.ad_email.value) == false)
         {
            msg += "\n - Please enter valid email address";
         
               jQuery("#ad_email").closest("td").removeClass("error");
         }
      }
   }
   if (jQuery("#ad_business_logo").length)
	{
      if (jQuery("#ad_business_logo").val() !== "")
   	{
   		var filename = jQuery("#ad_business_logo").val().replace(/^.*[\\\/]/, '');
         if (chk_img_extension(filename))
   		{
   			msg += "\n - Invlid file-extension for business logo. Note: Only JPG, JPEG, GIF & PNG are allowed.ad_ Please try again...";
   			if (area == "")
      			jQuery("#ad_business_logo").closest("td").removeClass("error");
   		}
   	}
   }
   if (d.ad_phone2 !== undefined)
   {
      if (d.ad_phone2.length)
      {
         if (d.ad_phone2.value !== "")
            msg += (validate_phone(d.ad_phone2, "phone2", area));
      }
   }
   if (jQuery("#ad_membership_start").length)
   {
      var d1 = Date.parse(jQuery("#ad_membership_start").val());
      var d2 = Date.parse(jQuery("#ad_membership_end").val());
      // // alert(d1 + ' --> ' + d2);
      if (d1 > d2)
         msg += "\n - Start Date must be smaller than End Date.";
   }
   if (msg !== '')
   {
      alert(replaceAll(replaceAll(msg, '_', ' '), ' ad ', ' Product Advertiser '));
      return false;
   }
}
