jQuery.noConflict();

jQuery(document).ready(function(jQuery)
{
    document.frm_facility.name.focus();
});
function chk_field(d)
{
   if (d.name.value.length==0)
   {
      alert('Enter Facility first...');
      d.name.focus();
       return false;
   }
}