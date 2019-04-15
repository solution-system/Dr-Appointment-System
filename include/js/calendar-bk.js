pcount = 0;
day_num = 0;
year_num = 0;
month_num = 0;  
function remove_span(msg)
{
    var n= msg.lastIndexOf("<span");
    return msg.substring(0, n);
}
jQuery(document).ready(function() 
{
    /*
     *jQuery.strRemove = function(theTarget, theString) {
        return jQuery("<div/>").append(
            jQuery(theTarget, theString).remove().end()
        ).html();
    }; */
    jQuery("#doctor").change(function()
    {
        if (jQuery(this).val() !== '')
        {
            jQuery("#frm_dr").submit();
            jQuery("#frm_dr").submit();
        }
    });
    jQuery('#frm_div').hide();
    year_num = jQuery('#year').val();
    month_num = jQuery('#month').val(); 
    jQuery('.calendar .day').click(function() {
        day_num = jQuery(this).find('.day_num').html();               
        calid = jQuery(this).find('#calid').html();  
        arr = calid.split('|');
        calid = arr[0];
        timing = arr[1];
        title = 'Enter Appointment Detail for ' + month_num + '/' + day_num + '/' + year_num;
        dated = month_num + '/' + day_num + '/' + year_num;
        msg = jQuery(this).find('.content').html();
        // alert('msg: ' + msg);
        if (msg !== undefined)
            msg = remove_span(msg);
        // alert(msg);
        form_display(title, msg, dated, calid);
        alert(title + "\n2- " + msg + "\n3- " + dated + "\n4- " + calid + "\n5- " + timing);		
    });	
});

function insert(day_data)
{
    var temp = '';
    var qs = '/admin/doctor/add_calendar_data/' + 
         jQuery("#doctor_id").val() + '/' + 
         jQuery("#year").val() + '/' +
         jQuery("#month").val() + '/';
        // alert(day_num + '<br>' + day_data + '<br>' + qs);	                        
    //alert('insert1(day_data): ' + qs);	                        
    jQuery.ajax({
        url: qs,
        type: 'POST',
        async: false,
        data: {
            day: day_num,
            data: day_data
        },
        success: paypal					
    });	    
}
function paypal()
{
    if (jQuery("#user_type").val() == 'user')
    {        
        var url = '/proceed/payment/' + calid + '/';
        alert(url);
        jQuery("#frm_paypal").attr("action", url);
    } 
    else
    {
        location.reload();        
    }        
}
function submit_to_paypal(data, calid)
{
    try
    {
        jQuery("#return").val("http://dr.solutionsystem.net/update/" + calid); 
        document.frm_paypal.item_name.value = data;
        // alert(jQuery("#return").val());
        document.frm_paypal.submit();
    }
    catch(err)
    {
        txt="There was an error on this page.\n\n";
        txt+="Error description: " + err.message + "\n\n";
        txt+="Click OK to continue.\n\n";
        jQuery("#error").html(txt);
    }
}
function form_display(title, msg, dated, calid)
{
    // alert(msg);
    if (msg == '<br><img src="/images/reserved.gif" border="0">')
    {        
        jQuery("#error").html('ERROR: ' + dated + ' already reserved by another visitor. Please choose another available day/time.');
        jQuery("#title").html('');
        jQuery("#data").val('');
        jQuery("#dated").val('');
        jQuery('#frm_div').hide();
        
    }    
    else
    {            
        if (msg !== undefined)
        {
            var n = msg.replace(/<\/?[^>]+(>|$)/g, ""); 
            jQuery("#data").val(n);
        }
        jQuery("#dated").val(dated);
        jQuery("#calid").val(calid);
        jQuery("#error").html('');
        jQuery("#title").html(title);
        var qs = '/admin/doctor/app_detail/' + 
                jQuery("#doctor_id").val() + '/' + 
                jQuery("#year").val() + '/' +
                jQuery("#month").val() + '/' +
                jQuery("#user_id").val() + '/';
        alert(qs);
        jQuery.ajax({
            url: qs,
            type: 'POST',
            async: false,
            success: function (dataCheck) {
                console.log(dataCheck); // <==============================
                jQuery("#app_detail").htmll(dataCheck);
            }					
        });	    
        jQuery('#frm_div').show();
    }
        /*
        load('/appointment_detail.php?msg=' + encodeURIComponent(msg) + '&title=' + encodeURIComponent(title), function(response, status, xhr) {
        }
        if (status == "error") {
        var msg = "Sorry but there was an error: ";
            print_msg(msg + xhr.status + " " + xhr.statusText);
            }
        }); */
}
function myModal(title)
{
    var 
        modal=jQuery('<div/>', {
            'id':'alert',
            'html':'<iframe width=600 src="/appointment_detail.html"></iframe>'
        })
       .dialog({
           'title': title,
           'modal':true,
           'width':650,
           'height':'auto',
           'buttons': {
               'OK': function() { 
                   jQuery(this).dialog( "close" ); 
                   // do something, maybe call form.submit();
                }
            }
    });
    return false;
}