<?php
$this->load->helper("my_helper");
?>
<link
    href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"
    rel="stylesheet" type="text/css" />
<script
src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script
src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="/include/js/date.js"></script>
<script type="text/javascript" src="/include/js/state_city_zip.js"></script>
<script type="text/javascript" src="/include/js/doctor.js?<?= time() ?>"></script>
<script type="text/javascript" src="/include/js/doctor_validation.js?<?= time() ?>"></script>

<table width="100%" border="0" align="center" cellpadding="0"
       cellspacing="0">

    <form autocomplete="off" enctype="multipart/form-data" method="post" action="" onsubmit="javascript:return chk_field(this, '');">

        <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>" />
        <input type="hidden" name="FormAction" id="FormAction" value="<?= $FormAction ?>" />
        <input type="hidden" name="temp_state" id="temp_state" value="<?= $temp_state ?>" />
        <input type="hidden" name="temp_city" id="temp_city" value="<?= $temp_city ?>" />
        <input type="hidden" name="temp_zip" id="temp_zip" value="<?= $temp_zip ?>" />
        <tr>
            <td align="center" style="font-weight: bold"><h1>Doctor <?= $FormAction ?></h1></td>
        </tr>
        <tr>
            <td align="left"><span style="font-weight: bold" id="debug"></span></td>
        </tr>
        <?php
        if ($msg != '') {
            print '<tr>
                        <td align="center">' . $msg . '</td>
                 </tr>';
        }
        ?>
        <tr>
            <td><u><strong>Login Credential</strong> </u>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="12%">Username:</td>
                        <td width="16%" height="30">
                            <input maxlength="50" value="<?= $username ?>" name="username" type="text" id="username" />
                        </td>
                        <td>&nbsp;</td>
                        <td width="100">Password:</td>
                        <td height="30">
                            <input maxlength="50" value="<?= $password ?>" size="28" name="password" type="password" id="password" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><hr></td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                        <td height="30" colspan="2"><u><strong>Personal</strong> </u></td>
                        <td width="3%">&nbsp;</td>
                        <td width="11%">&nbsp;</td>
                        <td width="26%" height="30"><u><strong>Origin</strong> </u></td>
                        <td width="32%" height="30"><u><strong>Origin</strong> </u></td>
                    </tr>
                    <tr>
                        <td width="12%">Name:</td>
                        <td width="16%" height="30">
                            <input value="<?= $name ?>" name="name" type="text" id="name" />
                        </td>
                        <td>&nbsp;</td>
                        <td valign="top">Address:</td>
                        <td height="30">
                            <TEXTAREA rows="4" cols="30" name="address" id="address"><?= $address ?></TEXTAREA> 
                        </td>
                        <td height="30">Website #1: <input value="<?= $web1 ?>" size="30" name="web1" type="text" id="web1" /></td>
                    </tr>
                    <tr>
                        <td>Business Name:</td>
                        <td height="30"><input value="<?= $business_name ?>" name="business_name" type="text" id="business_name" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <!-- <td>State:</td>
                        <td height="30">
                            <select name="state" id="state" onChange="javascript: ajax_action('state', 'city', this.value);"></select>
                        </td> -->
                        <td height="30">Website #2: <input value="<?= $web2 ?>" size="30" name="web2" type="text" id="web2" />
                        </td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td height="30">
                            <input value="<?= $email ?>" name="email" type="text" id="email" />
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <!-- <td>City:</td>
                        <td height="30">
                            <select name="city" id="city" onChange="javascript: ajax_action('city', 'zip', this.value);"></select>
                        </td> -->
                        <td height="30">Website #3: <input value="<?= $web3 ?>" size="30" name="web3" type="text" id="web3" />
                        </td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td height="30">
                            <input value="<?= $phone1 ?>" name="phone1" type="text" id="phone1" />
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <!-- <td>Zip code:</td>
                        <td height="30">
                            <select name="zip" id="zip"></select>
                        </td> -->
                        <td height="30">Website #4: <input value="<?= $web4 ?>" size="30" name="web4" type="text"
                                                         id="web4" /></td>
                    </tr>
                    <tr>
                        <td>Phone2:</td>
                        <td height="30">
                            <input value="<?= $phone2 ?>" name="phone2" type="text" id="phone2" />
                        </td>
                        <td>&nbsp;</td>
                        <td>Business Logo:</td>
                        <td height="30"><input name="business_logo" type="file" id="business_logo" />
                        </td>
                        <td height="30">
                            <table>
                                <tr>
                                    <td nowrap valign="top">Type of Insurance:</td>
                                    <td valign="top"><?=typeofdr('type_of_insurance', $type_of_insurance, $FormAction)?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td colspan="2" height="30"><u><strong>Facility:</strong> </u></td>                        
                                </tr>
                                <tr>
                                    <?php
                                    if (is_array($services)) {
                                        $i = 0;
                                        foreach ($services as $service):
                                            $i++;
                                            ?>

                                            <td height="30">
                                                <label>
                                                    <input   name="service<?= $i ?>"
                                                             type="checkbox"
                                                             id="service<?= $i ?>"
                                                             <?= $service['is_selected'] ?>
                                                             value="<?= $service['id'] ?>" /><?= $service['name'] ?> Service
                                                </label>
                                            </td>
                                            <?php
                                            if ($i % 2 == "0")
                                                print '</tr><tr>';
                                        endforeach;
                                    }
                                    ?>
                                </tr>
                            </table>
                        </td>
                        <td></td>
                        <td nowrap valign="top">Type of Doctor:</td>
                        <td valign="top">
                            <?=typeofdr('type_of_doctor', $type_of_doctor, $FormAction)?>
                        </td>
                        <td valign="top" id="current_bl" style="padding-left:20" colspan="2">
                            <?php
                            if ($business_logo <> "")
                                print '<a href="#">
                                            <img src="/images/del.gif"
                                              border=0
                                              href="javascript:void(0);"
                                              onclick="javascript: if (confirm(\'Sure to delete Business Logo?\')) del_logo(\'' . $doctor_id . '\');"></a>
                                              Current Business Logo:<br>
                                             <img  src="/business_logo/' . $business_logo . '" border="1">';
                            ?>           
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width=100%>
                    <tr>
                        <td nowrap>Company Phone#:</td>
                        <td height="30">
                            <input value="<?= $company_phone_no ?>" size="50" name="company_phone_no" type="text" id="company_phone_no" />
                        </td>
                        <td>&nbsp;</td>
                        <td nowrap>Company Email Address:</td>
                        <td height="30">
                            <input value="<?= $company_email ?>" size="50" name="company_email" type="text" id="company_email" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width=100%>
                    <tr>
                        <td nowrap>Areas of Coverage:</td>
                        <td><input value="<?= $area_coverage ?>" size="50" name="area_coverage" type="text" id="area_coverage" /></td>
                        <td>&nbsp;</td>
                        <td nowrap>Certifications and Accreditations:</td>
                        <td height="30">
                            <input value="<?= $certification ?>" size="50" name="certification" type="text" id="certification" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
                <table align="center" width="90%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="50%" height="30"><u><strong>Business Keywords (Comma Separated):</strong>
                    </u></td>
            <td width="50%" height="30"><u><strong>Business Description:</strong>
        </u></td>
        </tr>
        <tr>
            <td width="50%" align=center>
                <textarea name="business_keyword" cols="50" rows="10" id="business_keyword"><?= $business_keyword ?></textarea>
            </td>
            <td width="50%" align=center>
                <textarea name="business_desc" cols="50" rows="10" id="business_desc"><?= $business_desc ?></textarea>
            </td>
        </tr>       
        <input value="<?= $doctor_id ?>" type="hidden" name="id" id="id">
        <tr>
            <td  align="center" height="30">
                <input type="submit" name="submit" value="Submit Directory Listing" />
            </td>
        </tr>
</form>
</table>
