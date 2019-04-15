pcount = 0;
day_num = 0;
year_num = 0;
month_num = 0;  
function chk_3week(d)
{
    var ct = Date.parse(jQuery("#current_date").val());
    var w3 = Date.parse(jQuery("#three_week").val());
    var dt = Date.parse(d);
    // alert(ct + '<' + dt + '-->' + (ct > dt));
    if (dt > w3)
        return false
    else if (ct > dt)
        return false
    else
        return true;
}
function pay_now(calid, dataa, timing, day)
{
    jQuery('#tbl_app').slideDown();    
    jQuery("#title").html(jQuery("#title").html() + ' ' + timing);
    jQuery("#timing_lbl").html(timing);
    jQuery("#timing").val(timing);
    jQuery("#data").html(dataa);
    jQuery("#calid").val(calid);
    jQuery("#error").html('');
    jQuery("#day").val(day);
}
function remove_span(msg)
{
    var n= msg.lastIndexOf("<span");
    return msg.substring(0, n);
}
jQuery(document).ready(function() 
{    
    jQuery('#tbl_app').hide();
    jQuery("#doctor").change(function()
    {
        if (jQuery(this).val() !== '')
        {
            jQuery("#frm_dr").submit();
            jQuery("#frm_dr").submit();
        }
    });
    // jQuery('#frm_div').hide();
    year_num = jQuery('#year').val();
    month_num = jQuery('#month').val(); 
    jQuery('.calendar .day').click(function() {        
        jQuery('#tbl_app').slideUp();
        day_num = jQuery(this).find('.day_num').html();               
        title = 'Enter Appointment Detail for ' + month_num + '/' + day_num + '/' + year_num;
        dated = month_num + '/' + day_num + '/' + year_num;
        if (chk_3week(dated))
        {
            msg = jQuery(this).find('.content').html();
            // alert('msg: ' + msg);
            if (msg !== undefined)
                msg = remove_span(msg);
            // alert(msg);
            form_display(title, dated, day_num);
        }
        else
            jQuery("#error").html('ERROR: Online Appointment only available from today to three -weeks: ' + jQuery("#three_week").val() + '. Please try again.');
        //alert(title + "\n2- " + msg + "\n3- " + dated);		
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
function form_display(title, dated, day_num)
{
    jQuery("#dated").val(dated);
    jQuery("#calid").val(calid);
    jQuery("#error").html('');
    jQuery("#title").html(title);
    var qs = '/admin/doctor/app_detail/' + 
            jQuery("#doctor_id").val() + '/' + 
            jQuery("#year").val() + '/' +
            jQuery("#month").val() + '/' +
            day_num + '/' +
            jQuery("#user_id").val() + '/';
    // alert(qs);
    jQuery.ajax({
        url: qs,
        type: 'POST',
        async: false,
        success: function (dataCheck) {
            console.log(dataCheck); // <==============================
            jQuery("#app_detail").html(dataCheck);
        }					
    });	    
    jQuery('#frm_div').show();
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