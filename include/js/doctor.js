var zips = 0;
var sel_state = '';
var sel_city = '';
var from_load = true;

jQuery.noConflict();
jQuery(document).ready(function(jQuery)
{
   if (jQuery("#membership_start").length)
   {
      jQuery("#membership_start").datepicker();
      jQuery("#membership_end").datepicker();
   }
   if (jQuery("#FormAction").val() == 'Add')
   	jQuery("#current_bl").html('');
   ajax_action('us_states', 'state', '');

   if ((jQuery("#FormAction").val() == 'Update') || ((jQuery("#has_error").val() == "1") && (jQuery("#FormType").val() !== "")))
	{
       var state =jQuery("#temp_state").val();
       // alert('temp state: ' + state);
	    jQuery("#state").val(state);
	    // alert('state: ' + jQuery("#state").val());
       var city = jQuery("#temp_city").val();
       var zip = jQuery("#temp_zip").val();
       ajax_action('state', 'city', state);
    	 ajax_action('city', 'zip', city);
    	 jQuery("#state option[value='']").remove();
    	 jQuery("#city option[value='']").remove();
    	 jQuery("#zip option[value='']").remove();
       jQuery("#city").val(city);
       jQuery("#zip").val(zip);
       jQuery("#cost").html('USD $' + jQuery("#fee").val());
       if (jQuery("#temp_entire_nation").val() == '1')
       {
           jQuery("#entire_nation").attr("checked", "checked");
           select_all("1", 'nation');
       }
       else
       {
         if (jQuery("#user_zip").length)
         {
            var uz = jQuery("#user_zip").val();
            // // debug('uz onload: ' + uz);
            if (uz !== "")
            {
               var pieces = uz.split('|');
               for (var num=0; num < (pieces.length - 1); num++)
               {
                  var piece=pieces[num];
                  // // debug('piece: ' + piece);
                  var p = piece.split(',');
                  state = p[0];
                  city = p[1];
                  zip  = p[2];
                  get_selected("onload", state, city, zip);
               }
            }
         }
     	}
   }
});

function isExist_zip(state, city, zip)
{
   var zip_out = state + ',' + city + ',' + zip;
   var uz = jQuery("#user_zip").val();
   if (uz !== "")
   {
       var pieces = uz.split('|');
   	 for (var num=0; num < pieces.length; num++)
   	 {
   		var piece=pieces[num];
   		if (zip_out == piece)
   		{
             return true;
             break;
   		}
   	 }
       return false;
   }
   else
      return false;
}
function del_zip(state, city, zip, zips)
{
   var zip_last = '';
   var zip_out = state + ',' + city + ',' + zip;
   var uz = jQuery("#user_zip").val();
   if (uz !== "")
   {
       var pieces = uz.split('|');
   	 for (var num=0; num < pieces.length; num++)
   	 {
   		var piece=pieces[num];
   		if (zip_out !== piece)
   		{
             zip_last = piece + '|' + zip_last;
   		}
          	
   	 }
   	 jQuery("#user_zip").val(zip_last);
   	 // debug('uz @ del_zip: ' + jQuery("#user_zip").val());
   }
   update_fee(zip, 'minus');
   jQuery("#zip_" + zips).hide();
   jQuery("#" + city).removeAttr("checked");
   jQuery("#" + zip).removeAttr("checked"); // uncheck the checkbox or radio
}
function get_selected(chk, state, city, zip)
{
   var zip_in = '';
   if (chk == 'onload')
   {
      zips = zips + 1;
      zip_in = state + '\', \'' + city + '\', \'' + zip + '\',\'' + zips;
      var rec = '<div id="zip_' + zips + '"><a OnClick="javascript: del_zip(\'' + zip_in + '\');" href="javascript:void(0);"><img src="/images/del.gif" border="0"></a>&nbsp;' + state + '&rarr;' + city + '&rarr;' + zip + '</div>';
      jQuery("#selected_zip").html(rec + jQuery("#selected_zip").html());
   }
   else if (chk)
   {
      if (!isExist_zip(state, city, zip))
      {
         zips = zips + 1;
         zip_in = state + '\', \'' + city + '\', \'' + zip + '\',\'' + zips;
         var rec = '<div id="zip_' + zips + '"><a OnClick="javascript: del_zip(\'' + zip_in + '\');" href="javascript:void(0);"><img src="/images/del.gif" border="0"></a>&nbsp;' + state + '&rarr;' + city + '&rarr;' + zip + '</div>';
         // alert(rec);
         jQuery("#selected_zip").html(rec + jQuery("#selected_zip").html());
         zip_in = state + ',' + city + ',' + zip + '|'
         jQuery("#user_zip").val(jQuery("#user_zip").val() + zip_in);
         update_fee(zip, 'plus');
         // // debug('uz @ get_selected: ' + jQuery("#user_zip").val());
      }   
   }
   else
      jQuery("#" + zip).attr("checked", "checked");
}
function get_zip(state, city)
{
     sel_city = city;
     jQuery("#" + city).attr("checked", "checked");
	  jQuery("#zip_list").html('<div align=center>Processing, <br>Please wait...<br><img src="/images/loading.gif" border=0></div>');
	  var sURL = "/get_location.php?state=" + encodeURI(state) + "&city=" + encodeURI(city) + "&FormAction=get_zip";
	  // alert(sURL);
     jQuery.ajax({
		type: "POST",
		   url: sURL,
		   dataType: "html",
		   async: false,
		   success: function(data)
		   {
            // alert(data);
				jQuery("#zip_list").html(data);
            // if (from_load == false)
				location.href = '#selected_home';
			},
		   error: function(jqXHR, exception) {
	           error_caught(jqXHR, exception);
	       }
		 });
}
function get_cities(state_name, state)
{
   sel_state = state;
   jQuery("#" + state).attr("checked", "checked");
   var entire = '<span style="float: right;" align="right"><label> <input name="entire_city" type="checkbox" id="entire_city" onclick="javascript: select_all(this.checked, \'city\');"/>Select Entire City Listing</label></span>';
   jQuery("#state_selected").html('');
   jQuery("#zip_list").html('');
   jQuery("#cities_list").html('<div align=center>Processing, <br>Please wait...<br><img src="/images/loading.gif" border=0></div>');
   jQuery.ajax({
	type: "POST",
	   url: "/get_location.php?state=" + state + "&FormAction=get_cities",
	   dataType: "html",
	   async: false,
	   success: function(data)
	   {
          if (data !== "")
          {
             jQuery("#state_selected").html('Selected State:<strong> ' + state_name + '</strong>&nbsp;&nbsp;' + entire + entire.replace(/city/g, "state").replace(/City/g, "State"));
 				jQuery("#cities_list").html(data);
 			}
		},
	   error: function(jqXHR, exception) {
            error_caught(jqXHR, exception);
       }
	});
}
function select_all(aChecked, area)
{
    if (area == 'city')
    {
      if (!aChecked)
        return;
      var collection = document.getElementById("zip_list").getElementsByTagName('INPUT');
      for (var x=0; x<collection.length; x++)
      {
        if (collection[x].type.toUpperCase()=='CHECKBOX')
        {
           collection[x].checked = aChecked;
           get_selected(aChecked, sel_state, sel_city, collection[x].value);
        }
      }
     }
     else if (area == 'state')
     {
         if (!aChecked)
           return;
         var list = get_state_cities_zip();
         // debug('list @ select_all: ' + list);
         var pieces = list.split('|');
      	for (var num=0; num < pieces.length; num++)
      	{
      		var piece=pieces[num].split(',');;
            if (piece !== "")
            {
               var s = piece[0];
               var c = piece[1];
               var z = piece[2];
               // // debug('s: ' + s + ' c: ' + c + ' z: ' + z);
               if ((s !== undefined) && (c !== undefined) && (z !== undefined))
                  get_selected(aChecked, s, c, z);
            }   
         }
      }
      else if (area == 'nation')
      {
         if (aChecked)
         {
            // jQuery('#a_div').fadeTo('slow',.3);

            jQuery("#entire_nation_column").fadeTo('slow',.3);
            jQuery("#entire_detail_column").fadeTo('slow',.3);
            jQuery('#entire_nation_column :input').attr('disabled', 'disabled');
            jQuery('#entire_nation_column :a').attr('disabled', 'disabled');
            jQuery('#entire_detail_column :input').attr('disabled', 'disabled');
            jQuery('#entire_detail_column :img').attr('disabled', 'disabled');
         }
         else
         {
            jQuery("#entire_nation_column").fadeTo('slow',1);
            jQuery("#entire_detail_column").fadeTo('slow',1);
            jQuery('#entire_nation_column :input').attr('disabled', '');
            jQuery('#entire_nation_column :a').attr('disabled', '');
            jQuery('#entire_detail_column :input').attr('disabled', '');
            jQuery('#entire_detail_column :img').attr('disabled', '');
         }
      }
}

function get_state_cities_zip()
{
	var list1 = '';
	var qs = 'state=' + sel_state + '&FormAction=get_state_cities_zip';
	// debug('qs @ get_state_cities_zip:' + qs);
	jQuery.ajax({
		type: "POST",
		   url: "/get_location.php",
		   data: qs,
		   dataType: "text",
		   async: false,
		   success: function(data)
		   {
            // debug('data @ get_state_cities_zip: ' + data);
				list1 = data;
			},
		   error: function(jqXHR, exception) {
	           error_caught(jqXHR, exception);
	       }
		 });
   // debug('list1 @ get_state_cities_zip: ' + list1);
	return list1;
}
function del_logo(user_id)
{
    var qs = 'user_id=' + user_id + '&FormAction=del_logo';
	// print_msg('qs @ get_state_cities_zip:' + qs);
	jQuery.ajax({
		type: "POST",
		   url: "/ajax_action_doctor.php",
		   data: qs,
		   success: function(data)
		   {
				jQuery("#current_bl").html('');
			},
		   error: function(jqXHR, exception) {
	           error_caught(jqXHR, exception);
	       }
		 });
}
function update_fee(zip, operation)
{
     var qs = 'zip=' + zip + '&FormAction=fee';
	// alert('qs @ get_state_cities_zip:' + qs);
	jQuery.ajax({
		type: "POST",
		   url: "/ajax_action_doctor.php",
		   data: qs,
		   async:false,
		   success: function(data)
		   {
            // debug('data: ' + data);
            if (data !== "")
            {
               // debug('operation: ' + operation);
               if (operation == 'plus')
      				jQuery("#fee").val(parseInt(jQuery("#fee").val()) + parseInt(data));
      			else
      				jQuery("#fee").val(parseInt(jQuery("#fee").val()) - parseInt(data));
      		}
      		else
            {
               if (operation == 'plus')
      				jQuery("#fee").val(parseInt(jQuery("#fee").val()) + 10);
      			else
      				jQuery("#fee").val(parseInt(jQuery("#fee").val()) - 10);
      		}
				jQuery("#cost").html("USD $" + jQuery("#fee").val());
			},
		   error: function(jqXHR, exception) {
	           error_caught(jqXHR, exception);
	       }
		 });
}