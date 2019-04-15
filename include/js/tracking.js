jQuery(document).ready(function($)
{
   $("#start_date").datepicker();
   $("#end_date").datepicker();
   ajax_action('us_states', 'state', '');
});
function chk_field(d)
{
   var d1 = Date.parse($("#start_date").val());
   var d2 = Date.parse($("#end_date").val());
   // alert(d1 + ' --> ' + d2);
   if ((d1 !== "") && (d2 !== ""))
   {
      if (d1 > d2)
         alert("\n - Start Date must be smaller than End Date.");
   }      
}
$(function()
{
   var state =$("#temp_state").val()
   $("#state").val(state);
   var city = $("#temp_city").val();
   var zip = $("#temp_zip").val();
   ajax_action('state', 'city', state);
   ajax_action('city', 'zip', city);
   $("#city").val(city);
   $("#zip").val(zip);
});