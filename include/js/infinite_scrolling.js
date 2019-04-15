var page = 1;
var n = 0;
jQuery(document).ready(function(jQuery)
{
   // jQuery('#loading').hide();
   jQuery('#loading')
      .hide()  // hide it initially
      .ajaxStart(function() {
          jQuery(this).show();
      })
      .ajaxStop(function() {
          jQuery(this).hide();
   });
});
jQuery(window).scroll(function ()
{
   if(jQuery(window).scrollTop() + jQuery(window).height() == jQuery(document).height())
   {
      a = 3;
      n++;
      d = 3;
      page = (a + (n - 1) * d);
      var actual_count = jQuery("#actual_count").val();
      if(page < actual_count)
      {
         var pathname = window.location.pathname;
         pathname = pathname.replace("/result/", "/infinite_scrolling/");
         //write_data(jQuery(".ebay-main").html());
         debug(pathname + '/' + page);
         jQuery.ajax({
             type: "POST",
             url: pathname + '/' + page,
             async:false,
             success: function(res)
             {
                 jQuery('#loading').remove();
                 jQuery('.ebay-main').append(res);
                 //write_data(jQuery(".ebay-main").html());
             }
         });
      }
      else
         jQuery('#loading').hide();
   }
});