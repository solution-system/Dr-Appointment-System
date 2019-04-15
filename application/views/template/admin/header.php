<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script type="text/javascript" src="/include/js/jquery.cookie.js"></script>
        <script language="javascript" type="text/javascript">
            $j = jQuery.noConflict();
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="stylesheet" href="/include/js/__jquery.tablesorter/docs/css/jq.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="/include/js/__jquery.tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
        <script type="text/javascript" src="/include/js/__jquery.tablesorter/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="/include/js/main.js"></script>
        <link rel="stylesheet" type="text/css" href="/include/css/admin_css.css" />
        <title>Clinic Management System :: Admin</title>
    </head>



    <body>


        <table width="1000" align="center" border="0" style="border:1px groove #999999;">

            <tr>
                <td align="center">
<span id="debug"></span>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <strong><CENTER><font size="18">

                                CLINIC MANAGEMENT SYSTEM
                                </font>    
                            </CENTER></strong>
                            </td>
                        </tr>                         
                        <?php
                        $ci = & get_instance();
                        if ($ci->session->userdata('username') <> "") {
                            print '
                                <input type="hidden" value="' . $ci->session->userdata('user_type') . '" name="user_type" id="user_type">
                                <input type="hidden" value="' . $ci->session->userdata('uid') . '" name="user_id" id="user_id">
                                <input type="hidden" value="' . date('m/d/Y',strtotime(date('m/d/Y')) + (24*3600*21)) . '" name="three_week" id="three_week">
                                <input type="hidden" value="' . date('m/d/Y') . '" name="current_date" id="current_date">
                                    ';
                            ?>                        
                            <tr>
                                <td>
                                    <table width="100%" border="0">
                                        <tr>
                                            <td nowrap>
                                                <h1>
                                                    <a href="/admin">Home</a>&nbsp;|&nbsp;
                                                    
                                                    <?php
                                                    if ($ci->session->userdata('ulevel') == '2' ) 
                                                        print '<a href="/admin/doctor/appointment/">Appointment</a>&nbsp;|&nbsp;';
                                                    if ($ci->session->userdata('ulevel') == '1' ) 
                                                        print '<a href="/admin/user/">User</a>&nbsp;|&nbsp;';
                                                    if ($ci->session->userdata('ulevel') == '0') 
                                                    {
                                                        ?>
                                                        <a href="/admin/user/">User</a>&nbsp;|&nbsp;
                                                        <a href="/admin/doctor/">Doctor</a>&nbsp;|&nbsp;
                                                        <a href="/admin/facility/">Facility</a>&nbsp;|&nbsp;
                                                        <a href="/admin/config/">Config</a>&nbsp;|&nbsp;
                                                    <?php
                                                    } 
                                                    else
                                                        print '<a href="/admin/account/">Account Info</a>&nbsp;|&nbsp;';
                                                    ?>
                                                    <a href="/admin/logout/">Logout</a>                                                                                                                                                                                                            
<!--                                                    <a href="javascript: update_link(jQuery('#user_type').val(), '/');">Home</a>&nbsp;|&nbsp;
                                                        <a href="javascript: update_link(jQuery('#user_type').val(), '/admin/account/');">Account Info</a>&nbsp;|&nbsp;
                                                        <?php
                                                        if ($ci->session->userdata('ulevel') == '2')
                                                            print '<a href="javascript: update_link(jQuery(\'#user_type\').val(), \'/admin/doctor/appointment/\');">Appointment</a>&nbsp;|&nbsp;';
                                                        if ($ci->session->userdata('ulevel') == '1')
                                                            print '<a href="javascript: update_link(jQuery(\'#user_type\').val(), \'/admin/user/\');">User</a>&nbsp;|&nbsp;';
                                                        // print 'user type: ' . $ci->session->userdata('ulevel') . '<br>';
                                                        if ($ci->session->userdata('ulevel') == '0') {
                                                            ?>
                                                            <a href="javascript: update_link(jQuery('#user_type').val(), '/admin/doctor/');">Doctor</a>&nbsp;|&nbsp;                                                
                                                            <a href="javascript: update_link(jQuery('#user_type').val(), '/admin/facility/');">Facility</a>&nbsp;|&nbsp;
                                                            <a href="javascript: update_link(jQuery('#user_type').val(), '/admin/config/');">Config</a>&nbsp;|&nbsp;
                                                            <?php
                                                        }
                                                        // else if ($ci->session->userdata('ulevel') == '1')
                                                        //    print '<a href="javascript: update_link(jQuery('#user_type').val(), '/admin/doctor/appointment/">Appointment</a>&nbsp;|&nbsp;   ';
                                                        ?>
                                                        <a href="/admin/logout/">Logout</a>                                     -->
                                                </h1>
                                            </td>
                                            <td>
                                                <a href="javascript: update_link(jQuery('#user_type').val(), '/admin/change_pass/');">
                                                    Change Password
                                                    <!-- <img src="/images/change_pass.png" border="0" /> -->
                                                </a>
                                                <br>
                                                    <span id="loading">Processing, <br>Please wait...<br><img alt="Dr. Website" title="Dr. Website" src='/images/loading.gif' border=0></span>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top" colspan="2" style="border-bottom:1px solid #999999;"></td>
                                                                    </tr>

                                                                    </table>
                                                                    <span id="msg"></span>
                                                                    </td></tr>
                                                                <?php } ?>

                                                                <tr>

                                                                    <td id="content">
                                                                        <?php
                                                                        if ($this->session->userdata('user_type') <> "")
                                                                            print 'Welcome ' . ucwords($this->session->userdata('user_type') . ' ' . $this->session->userdata('name')) . ', <br>';
                                                                        ?>
