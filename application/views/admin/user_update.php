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
<script type="text/javascript" src="/include/js/user.js?<?=time()?>"></script>
<script type="text/javascript" src="/include/js/user_validation.js?<?=time()?>"></script>

<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">

<form autocomplete="off" enctype="multipart/form-data" method="post" action="" onsubmit="javascript:return chk_field(this);">

	  <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>" />
	  <input type="hidden" name="FormAction" id="FormAction" value="<?=$FormAction?>" />
	  <input type="hidden" name="temp_state" id="temp_state" value="<?=$temp_state?>" />
	  <input type="hidden" name="temp_city" id="temp_city" value="<?=$temp_city?>" />
	  <input type="hidden" name="temp_zip" id="temp_zip" value="<?=$temp_zip?>" />
  		<tr>
            <td align="center" style="font-weight: bold"><h1>User <?= $FormAction ?></h1></td>
        </tr>
        <tr>
            <td align="left"><span style="font-weight: bold" id="debug"></span></td>
        </tr>
		<?php
		if ($msg!='')
		{
   		print '<tr>
			         <td align="center"><font color=red>' . $msg . '</font></td>
		          </tr>';
		} ?>
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
                 <table border="0" cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="180">Doctor:</td>
                        <td height="30">
                            <?=get_dropdown('name', 'doctor', 'id', '', '', $FormAction, $doctor)?>
                        </td>
                    </tr>
                 </table>
            </td>
        </tr>
		<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="2">
					<tr>
						<td height="30" colspan="2" nowrap="nowrap"><u><strong>Personal Information</strong> </u></td>
						<td width="3%">&nbsp;</td>
						<td width="3%">&nbsp;</td>
						<!-- <td width="11%" nowrap="nowrap"><u><strong>Origin</strong></u></td> -->
						<td width="26%" height="30">&nbsp;</td>
					</tr>
					<tr>
						<td width="12%" nowrap="nowrap">Name:</td>
						<td width="16%" height="30">
						      <input value="<?=$name?>" name="name" type="text" id="name" />
						</td>
						<td>&nbsp;</td>
						<td nowrap="nowrap">Email:</td>
						<td height="30">
						   <input value="<?=$email?>" name="email" type="text" id="email" />
						</td>						
					</tr>
					<tr>
						<td nowrap="nowrap">Business Name:</td>
						<td height="30"><input value="<?=$business_name?>" name="business_name" type="text" id="business_name" /></td>
						<td>&nbsp;</td>
						<td nowrap="nowrap">Company Email Address:</td>
					  	<td height="30"><input value="<?=$company_email?>" name="company_email" type="text" id="company_email" /></td>
						<!-- <td nowrap="nowrap">State:</td>
						<td height="30">
                  	<select name="state" id="state" onChange="javascript: ajax_action('state', 'city', this.value);"></select>
						</td> -->
					</tr>
					<tr>
						<td nowrap="nowrap">Phone:</td>
						<td height="30">
						      <input value="<?=$phone1?>" name="phone1" type="text" id="phone1" />
						</td>
						<td>&nbsp;</td>

						<td nowrap="nowrap">Phone2:</td>
						<td height="30">
						      <input value="<?=$phone2?>" name="phone2" type="text" id="phone2" />
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap">Website:</td>
						<td height="30"><input value="<?=$web?>" size="30" name="web" type="text" id="web" /></td>
						<td>&nbsp;</td>					
					  <td nowrap="nowrap">Company Phone#: </td>
					  <td height="30"><input value="<?=$company_phone_no?>" name="company_phone_no" type="text" id="company_phone_no" /></td>
			  </tr>
					<tr>
					  <td nowrap="nowrap" valign="top">Address:</td>
						<td height="30">
							<TEXTAREA rows="4" cols="30" name="address" id="address"><?= $address ?></TEXTAREA> 
						      <!-- <input value="<?=$address?>" size="28" name="address" type="text" id="address" /> -->
						</td>
					  <td>&nbsp;</td>
					  <td nowrap="nowrap">&nbsp;</td>
					  <td height="30">&nbsp;</td>
			  </tr>
					
				</table>
			</td>
		</tr>

		<tr>
			<td align="center" height="30" id="loading">&nbsp;</td>
		</tr>
		<input value="<?=$user_zip?>" type="hidden" name="user_zip" id="user_zip">
		<input value="<?=$user_id?>" type="hidden" name="id" id="id">
		<input value="<?=$sError?>" type="hidden" name="has_error" id="has_error">
		<tr>
			<td  align="center" height="30">
			   <input type="submit" name="submit" value="Submit Directory Listing" />
			</td>
		</tr>
	</form>
</table>
