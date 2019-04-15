
<table width="200" border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">                       
            <span id="app_detail"></span>
        </td>
    </tr>
    <tr>
        <td>
            <table width="200" border="0" id="tbl_app">
                <form id="frm_msg" 
                      name="frm_msg" 
                      method="post" 
                      action="/admin/doctor/add_calendar_data/<?= $doctor_id ?>/<?= $year ?>/<?= $month ?>/">
                    <input type="hidden" id="csrf_test_name" name="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" id="dated" name="dated" value="" />
                    <input type="hidden" id="calid" name="calid" value="" />
                    <input type="hidden" id="timing" name="timing" value="" />
                    <input type="hidden" id="day" name="day" value="" />
                    <tr>
                        <td bgcolor="darkblue" colspan="3" align="center">
                            <font color=white><span id="title"></span></font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><strong>Time:</strong></td>
                        <td>
                            <span id="timing_lbl"></span>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><strong>Message:</strong></td>
                        <td><textarea name="data" id="data" cols="30" rows="5">

                            </textarea></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">
                            <input type="submit" value="Pay Now">
                        </td>
                        <td>
<!--                            <input type="reset" value="Reset">-->
                        </td>
                        <td>&nbsp;</td>
                    </tr>
            </table>
            </form>
        </td>
    </tr>
</table>