<script type="text/javascript" src="/include/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/include/js/facility.js?<?= time() ?>"></script>
<br>
<form id="frm_facility" name="frm_facility" enctype="multipart/form-data" method="post" onsubmit="javascript:return chk_field(this);">
    <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" name="FormAction" id="FormAction" value="<?= $FormAction ?>" />
    <input type="hidden" name="facility_id" id="facility_id" value="<?= $facility_id ?>" />
    <table align="center" border="0" cellpadding="2" cellspacing="0" width="500">
        <tr>
            <td align="left">
                <span id="msg"><font color="red"><?= ucwords(str_replace('_', ' ', $msg)) ?></font></span>
            </td>
        </tr>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="2" cellspacing="0">
                    <tr>
                        <td valign="middle"  height="30" align="center" colspan="2" bgcolor="seablue">
                            <span style="font-weight: bold; color: #FFFFFF">Facility <?= $FormAction ?></strong></span>

                        </td>
                    </tr>
                    <tr id="home_page_blk">
                        <td valign="middle" align="right" width="50%">Facility:</td>
                        <td>
                            <input type="text" name="name" id="name" value="<?=$name?>" /></td>
                    </tr>         	
                    <tr>
                        <td valign="middle" height="30" align="right">
                            <input type="submit" value="Submit" name="btn_submit">
                        </td>
                        <td valign="middle" height="30" align="left">
                            <input type="reset" value="Reset" name="btn_reset">
                        </td>
                    </tr>
                    </form>
                </table>
            </td>
            <td>
                Facilities:<br>
                <?=$facilities?>
            </td>
        </tr>
    </table>