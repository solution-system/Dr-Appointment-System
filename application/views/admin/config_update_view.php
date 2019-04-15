<script type="text/javascript" src="/include/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/include/js/config.js?<?= time() ?>"></script>
<br>
<form id="frm_config" name="frm_config" enctype="multipart/form-data" method="post" onsubmit="javascript: if ((this.config_variable.value == '') || (this.config_value.value == '')) { alert('Enter Config Variable and Config Value first...'); return false; } ">
    <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" name="FormAction" id="FormAction" value="<?= $FormAction ?>" />
    <input type="hidden" name="config_id" id="config_id" value="<?= $config_id ?>" />
    <table align="center" border="0" cellpadding="2" cellspacing="0" width="500">
        <tr>
            <td align="left">
                <span id="msg"><font color="red"><?= ucwords(str_replace('_', ' ', $msg)) ?></font></span>
            </td>
        </tr>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="2" cellspacing="0" width="500">
                    <tr>
                        <td valign="middle"  height="30" align="center" colspan="2" bgcolor="#C5735A">
                            <span style="font-weight: bold; color: #FFFFFF">Config <?= $FormAction ?></strong></span>

                        </td>
                    </tr>
                    <tr id="home_page_blk">
                        <td valign="middle" align="right" width="50%">Config Variable:</td>
                        <td>
                            <input size="40" type="text" name="config_variable" id="config_variable" value="<?=$config_variable?>" /></td>
                    </tr>         	
                    <tr id="home_page_blk">
                        <td valign="top" align="right" width="50%">Config Value:</td>
                        <td>
                            <textarea name="config_value" id="config_value" rows="5" cols="30"><?=$config_value?></textarea></td>
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
        </tr>
    </table>