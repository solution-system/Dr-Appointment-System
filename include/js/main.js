d=0;
pcount=0;
jQuery.noConflict();

function update_link(user_type, url)
{
    //alert('url 111: ' + url);
    var in_session = "0";
    try
    {
    jQuery.ajax({
        url: '/chk_session',
        async: false,
        success: function(data) 
        {
            in_session = data;
        },
        error: function (data, status, e)
        {
            alert(e);
        }
    });
    }
    catch (ex)
    {
        alert(ex);
    }
    //alert('url 333: ' + in_session);                
    if (in_session == "1")
    {
        // alert('url 222: ' + url);
        location.href=url;
    }		
    else
    {
        // alert('url else: ' + '/admin/login/' + user_type + url);
        location.href='/admin/login/' + user_type + url;
    }
        
}
jQuery(document).ready(function(jQuery)
{
    jQuery.ajaxSetup({
        data: {
            csrf_test_name: jQuery.cookie('csrf_cookie_name')
        }
    });

    if (jQuery("#table_sort").length)
    {
        jQuery("#table_sort").tablesorter({
            sortList: [[1,0]],         
            headers: {
                0: {
                    sorter: false
                },
                7: {
                    sorter: false
                },
                8: {
                    sorter: false
                },
                9: {
                    sorter: false
                },
                10: {
                    sorter: false
                },
                11: {
                    sorter: false
                }
            }
        });
    }
    jQuery('#loading')
    .hide()  // hide it initially
    .ajaxStart(function() {
        jQuery(this).show();
    })
    .ajaxStop(function() {
        jQuery(this).hide();
    }); 

});
function rec_active(ctrl, b, tables)
{
    var newb;
    var update = false;
    var title = '';
    if (b == "1")
    {
        title = 'In-active';
        newb = 0;
    }
    else
    {
        title = 'Active';
        newb = 1;
    }
    var sURL = "/ajax_action.php?id=" + ctrl + "&tables=" + tables + "&b=" + newb + "&FormAction=toggle_active";
    // alert(sURL);
    jQuery.ajax({
        type: "POST",
        url: sURL,
        dataType: "html",
        async: false,
        success: function(data)
        {
            // alert('data: ' + data);
            update = true;
        },
        error: function(jqXHR, exception) {
            error_caught(jqXHR, exception);
        }
    });
    if (update)
    {
        var td = jQuery("td a#active_link" + ctrl).parent();
        var htmls = '<a id="active_link' + ctrl + '" href="javascript:void(0);" OnClick="javascript:rec_active(' + ctrl + ', ' + newb + ', \'user\');"><img id="active_' + ctrl + '" src="/images/banned_' + b + '.png" title="' + title + '" alt="' + title + '" border="0"></a>';
        // alert(htmls);
        td.html(htmls);

    // <a id="active_link107" href="javascript:void(0);" OnClick="javascript:rec_active(107, 0, 'user');"><img id="active_107" src="/images/banned_1.png" title=In-active alt=In-active border="0"></a>

    }
}
function rec_banned(ctrl, b, tables)
{
    var newb;
    var update = false;
    if (b == "1")
        newb = 0;
    else
        newb = 1;
    var sURL = "/ajax_action.php?id=" + ctrl + "&tables=" + tables + "&b=" + newb + "&FormAction=toggle";
    // alert(sURL);
    jQuery.ajax({
        type: "POST",
        url: sURL,
        dataType: "html",
        async: false,
        success: function(data)
        {
            update = true;
        },
        error: function(jqXHR, exception) {
            error_caught(jqXHR, exception);
        }
    });
    if (update)
    {
        var td = jQuery("td a#link" + ctrl).parent();
        td.html('<a id="link' + ctrl + '" href="javascript:void(0);" OnClick="javascript:rec_banned(' + ctrl + ', ' + newb + ', \'ads\');"><img id="ban_' + ctrl + '" src="/images/banned_' + newb + '.png" border="0"></a>');
    }
}
function chk_img_extension(file)
{
    var extension = file.substr( (file.lastIndexOf('.') +1) ).toLowerCase();
    switch(extension) 
    {
        case 'jpg':
        case 'gif': 
        case 'png':
            return false;
            break;
        default:
            return true;
    }
}
function chk_length(area, fld, punch)
{
    if (fld !== undefined)
    {
        // debug('fld @ chk_length: ' + fld);
        if ((fld.value !== undefined) && (fld.value.length == 0))
        {
            if (area== "")
                jQuery('#' + fld.id).closest("td").addClass("error");
            // var f = fld.name;
            return "\n - Please " + punch + " " + fld.name;
        }
        else
        {
            jQuery('#' + fld.id).closest("td").removeClass("error");
            return "";
        }
    }
}

function chk_all(d)
{
    var f = document.form1;
    for(var i = 0; i < f.elements.length; i++)
    {
        if( f.elements[i].type=='checkbox')
            f.elements[i].checked = d;
    }
}
function chk_del(title, d)
{
    has_checked=0;
    for(var i = 0; i < d.elements.length; i ++)
    {
        if(d.elements[i].type=='checkbox')
        {	
            if (d.elements[i].checked==1)
                has_checked=1;
        }
    }
    if (has_checked==0)
    {
        alert("Select atleast one " + title + " for delete...");
        return false;
    }
    else
        return confirm("Delete all selected " + title + "?\n\nNote: All information related to the " + title + ", will also be deleted?\n\nDelete?");
}
function debug(str)
{
    d++;
    jQuery("#debug").html(jQuery("#debug").html() + '---------<br>' + d + ') ' + str + '<br>----------<br>');
}
function error_caught(jqXHR, exception)
{
    if (jqXHR.status === 0) {
        alert('Not connect.\n Verify Network.');
    } else if (jqXHR.status == 404) {
        alert('Requested page not found. [404]');
    } else if (jqXHR.status == 500) {
        alert('Internal Server Error [500].');
    } else if (exception === 'parsererror') {
        alert('Requested JSON parse failed.');
    } else if (exception === 'timeout') {
        alert('Time out error.');
    } else if (exception === 'abort') {
        alert('Ajax request aborted.');
    } else {
        alert('Uncaught Error.\n' + jqXHR.responseText);
    }
}
function print_msg(str)
{
    pcount++;
    if (jQuery("#msg").length)
        jQuery("#msg").html("<b>" + pcount + ")</b> " + str + "<br>" + jQuery("#msg").html());
}

