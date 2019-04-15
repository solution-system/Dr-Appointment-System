function update_approved(uid, is_checked)
{
   //var temp = Update_Cookie("approved", uid);
   //alert(temp);
   //if (temp)
   //{
      var sURL = "/ajax_action_doctor.php?FormAction=approved&uid=" + uid + '&is_checked=' + is_checked;
      // alert(sURL);
      jQuery.ajax({
         type: "POST",
         url: sURL,
         dataType: "html",
         async: false,
         success: function(data)
         {
           return true;
      	},
         error: function(jqXHR, exception) {
              alert(jqXHR + ', ' + exception);
          }
       });
   //}
}
function chk_field(d, area)
{
   // alert(d.first_name);
   var msg = '';
   var temp = '';
   msg += (chk_length('', d.username, "enter"));
   msg += (chk_length('', d.password, "enter"));
   if (area == "")
      msg += (chk_length(area, d.name, "enter"));
   if (d.first_name !== undefined)
      msg += (chk_length(area, d.first_name, "enter"));
   if (d.last_name !== undefined)
      msg += (chk_length(area, d.last_name, "enter"));
   if (area == "")
      msg += (chk_length(area, d.address, "enter"));
   if (d.state !== undefined)
      msg += (chk_length(area, d.state, "select"));
   if (d.city !== undefined)
      msg += (chk_length(area, d.city, "select"));
   if (d.zip !== undefined)
      msg += (chk_length(area, d.zip, "select"));
   if (d.email !== undefined)
      msg += (chk_length(area, d.email, "enter"));
   if (d.phone1 !== undefined)
      temp = (chk_length(area, d.phone1, "enter"));
   if (temp !== "")
      msg += (validate_phone(d.phone1, "phone1", area));
   if (d.email !== undefined)
   {
      if (d.email.value !== "")
      {
         if (validateEmail(d.email.value) == false)
         {
            msg += "\n - Please enter valid email address";
            if (area == "")
               jQuery("#email").closest("td").removeClass("error");
         }
      }
   }
   if (d.budget !== undefined)
   {
      if ((d.budget.value == 'Example: $300 to $600 per month') || (d.budget.value == ''))
         msg += "\n - Please enter your budget";
   }

   if (jQuery("#business_logo").length)
	{
      if (jQuery("#business_logo").val() !== "")
   	{
   		var filename = jQuery("#business_logo").val().replace(/^.*[\\\/]/, '');
         if (chk_img_extension(filename))
   		{
   			msg += "\n - Invlid file-extension for business logo. Note: Only JPG, JPEG & GIF are allowed. Please try again...";
   			if (area == "")
      			jQuery("#business_logo").closest("td").removeClass("error");
   		}
   	}
   }
   if (d.phone2 !== undefined)
   {
      if (d.phone2.length)
      {
         if (d.phone2.value !== "")
            msg += (validate_phone(d.phone2, "phone2", area));
      }
   }
   if (jQuery("#membership_start").length)
   {
      var d1 = Date.parse(jQuery("#membership_start").val());
      var d2 = Date.parse(jQuery("#membership_end").val());
      // // alert(d1 + ' --> ' + d2);
      if (d1 > d2)
         msg += "\n - Start Date must be smaller than End Date.";
   }
   if (msg !== '')
   {
      // alert(replaceAll(msg, '_', ' '));
      alert(msg);
      return false;
   }
}
function validate_phone(phone, phone_id, area)
{
   if (phone !== undefined)
   {
      var ph = phone.value;
      var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})jQuery/;

      if (regexObj.test(ph))
      {
          var formattedPhoneNumber = ph.replace(regexObj, "(jQuery1) jQuery2-jQuery3");
          if (area == "")
             jQuery("#" + phone_id).val(formattedPhoneNumber);
          // alert('if: ');
          return '';
      }
      else
      {
         if (area == "")
            jQuery("#" + phone_id).closest("td").removeClass("error");
         // alert('else: ');
         return "\n - Please enter valid Phone#. These formats include 1234567890, 123-456-7890, 123.456.7890, 123 456 7890, (123) 456 7890, and all related combinations."
      }
   }
}

function validateEmail(sEmail)
{
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (!filter.test(sEmail))
    {
       return false;
    }
        
}

