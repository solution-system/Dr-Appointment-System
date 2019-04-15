jQuery.noConflict();
jQuery(document).ready(function($) 
{	
   jQuery('#loading')
      .hide()  // hide it initially
      .ajaxStart(function() {
          jQuery(this).show();
      })
      .ajaxStop(function() {
          jQuery(this).hide();
   });
   load_heading();
});
function load_heading()
{
   var link1 = jQuery("#link1").val();
   var text1 = jQuery("#text1").val();
   var link2 = jQuery("#link2").val();
   var text2 = jQuery("#text2").val();
   var text3 = jQuery("#text3").val();
   var link3 = jQuery("#link3").val();
   var htmls = '';
   if ((text1 !== "") && (text1 !== undefined))
      htmls += '<a href="/locate/result/' + link1 + '"><span class="green">' + text1 + '</span></a>';
   if ((text2 !== "") && (text2 !== undefined))
      htmls += '<span class="grey">></span><a href="/locate/result/' + link2 + '"><span class="blue-light">' + text2 + '</span></a>';
   if ((text3 !== "") && (text3 !== undefined))
      htmls += '<span class="grey">></span><span class="num">' + text3 + '</span>';
    // alert('htmls: ' + htmls);
    jQuery("#result_id").html(htmls);
}
function show_state_city(state)
{
   jQuery(".page-title").html('<span class="orange2">Locate an Expert –</span> Select City or Use Advanced Search');
   jQuery("#locate_main").html('');
   var sURL = "/location_city.php?state=" + state;
   // alert(sURL);
   jQuery.ajax({
      type: "POST",
      url: sURL,
      dataType: "html",
      async: false,
      success: function(data)
      {
        jQuery("#locate_main").html(data);
   	},
      error: function(jqXHR, exception) {
           alert(jqXHR + ', ' + exception);
       }
    });
}
function show_state_city_zip(state, city)
{
   jQuery(".city-left").html(state + ' -> ' + city + ' - Type in a letter to make finding a city faster');
   var sURL = "/location_zip.php?state=" + state + "&city=" + city;
   // alert(sURL);
   jQuery.ajax({
      type: "POST",
      url: sURL,
      dataType: "html",
      async: false,
      
      success: function(data)
      {
        jQuery("#locate_" + state + "_" + city).html(data);
   	},
      error: function(jqXHR, exception) {
           alert(jqXHR + ', ' + exception);
       }
    });
}
function chk_field(ctrls)
{
    // debug('');
    val_exist = false;
    url = '';
    var ser = '';
    // // debug('val_exist: ' + val_exist);
    for (i=1; (i <= ctrls); i++)
    {
       // // debug('i-->' + jQuery("#service" + i).val());
       if (jQuery("#service" + i).val() !== "")
       {
          ser += jQuery("#service" + i).val() + '+';
          val_exist = true;
       }
    }
    if (ser !== "")
    {
      ser =  ser.substring(0, ser.length-1);
      url += '/' + ser + "-service";
    }

    // // debug('val_exist2: ' + val_exist);
   if (jQuery("#state").length)
   {
      // // debug('state: ' + jQuery("#state").val());
      if ((jQuery("#state").val() !== null) && (jQuery("#state").val() !== ""))
      {
         url += '/' + jQuery("#state").val() + '-us-state';
         val_exist = true;
      }
   }
   if (jQuery("#city").length)
   {
      // // debug('city: ' + jQuery("#city").val());
      if ((jQuery("#city").val() !== null) && jQuery("#city").val() !== "")
      {
         url += '/' + jQuery("#city").val() + '-us-city';
         val_exist = true;
      }
   }
   if (jQuery("#zip").length)
   {
      // // debug('zip: ' + jQuery("#zip").val());
      if ((jQuery("#zip").val() !== null) &&  (jQuery("#zip").val() !== "") && (jQuery("#zip").val() !== "Zip Code:"))
      {
         url += '/' + jQuery("#zip").val() + '-zipcode'; 
         val_exist = true;
      }
   }
   if (jQuery("#company_name").length)
   {
      // // debug('company_name: ' + jQuery("#company_name").val());
      if ((jQuery("#company_name").val() !== null) &&  (jQuery("#company_name").val() !== "") && (jQuery("#company_name").val() !== "Search by company"))
      {
         url += '/' + jQuery("#company_name").val() + '-company';
         val_exist = true;
      }
   }
   // // debug('val_exist3: ' + val_exist);
   if (val_exist == false)
   {
       // debug('<font color=maroon><b>ERROR: </b>Select any option for search first...</font>');
       return false;
   }
   else
   {
      // // debug('url: ' + url);
      location.href = "/locate/result" + url.toLowerCase();;
      return false;
   }
}
function toggle_read_more(uid, act)
{
   jQuery("#read_more" + uid).toggle();
   if (act == "1")
   {
      jQuery("#read_more" + uid + "_dot").hide();
      jQuery("#read_more" + uid + "_href").hide();
      jQuery("#read_less" + uid + "_href").show();

   }
   else
   {
     jQuery("#read_more" + uid + "_dot").show();
     jQuery("#read_more" + uid + "_href").show();
     jQuery("#read_less" + uid + "_href").hide();
   }

}
function chk_approved(uid)
{
   var temp = Check_Cookie("approved", uid);
   // debug('chk_approved temp: ' + temp + '-->' + uid);
   // alert('chk_approved temp: ' + temp + '-->' + uid);
   if (temp)
   {
      jQuery('#approved_' + uid).html('<span style="color:#3e6b08; background-color:#FFFFFF;">Snell Expert Approved</span>');
   }
   else
   {
      jQuery('#approved_' + uid).html('<label><span class="blue-light">Snell Expert Approve</span></label> <input type="checkbox" class="check" onclick="javascript: update_approved(' + uid + ');"/>');
   }
}
function update_approved(uid)
{
   var temp = Update_Cookie("approved", uid);
   //alert(temp);
   if (temp)
   {
      var sURL = "/ajax_action.php?FormAction=approved&uid=" + uid;
      // alert(sURL);
      jQuery.ajax({
         type: "POST",
         url: sURL,
         dataType: "html",
         async: false,
         success: function(data)
         {
           jQuery('#approved_' + uid).html('<span style="color:#3e6b08; background-color:#FFFFFF;">Snell Expert Approved</span>');
      	},
         error: function(jqXHR, exception) {
              alert(jqXHR + ', ' + exception);
          }
       });
   }
}
function Update_Cookie(cookie_name, uid)
{
   var temp=Cookies.get(cookie_name);
   if (temp!=null && temp!="")
   {
      var x,arr = temp.split("|");
      for (i=0;i<arr.length;i++)
      {
         x=arr[i];
         if (x==uid)
         {
            return true;
         }
      }
      // setCookie(cookie_name, temp + "|" + uid);
      Cookies.set(cookie_name, temp + "|" + uid, null, '/', '.snellexperts.com');
      return true;
   }
   else
   {
      Cookies.set(cookie_name, uid, null, '/', '.snellexperts.com');
      return true;
   }
}
function Check_Cookie(cookie_name, uid)
{
   var temp = Cookies.get(cookie_name);
   // debug('Check_Cookie temp: ' + temp + '-->' + uid);
   if (temp!=null && temp!="")
   {
      var x,arr = temp.split("|");
      for (i=0;i<arr.length;i++)
      {
         x=arr[i];
         if (x==uid)
         {
            // debug('Check_Cookie x: ' + x + '-->' + uid);
            return true;
         }
      }
      return false;
   }
   else
   {
      // setCookie(cookie_name, uid,365);
      return false;
   }
}