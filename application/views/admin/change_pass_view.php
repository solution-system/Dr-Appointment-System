<script language="javascript" src="/include/js/pw.js"></script>
<h1>Change Password</h1>
<form autocomplete="off" method="post" onsubmit="javascript: return chkfield(this);" name="form1">
   <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>" />
   <input type="hidden" value="change_pass" name="FormAction" id="FormAction">
	<table width="100%" cellpadding=5 cellspacing=0>
		<tr>
			<td align="center" colspan="2">
				<div align="center" id="msg"><?=$msg?></div>
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="Text_bold">Old Password:</td>
			<td><input type="password" value="<?=$old?>" name="old" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="Text_bold">New Password:</td>
			<td><input type="password" value="<?=$new1?>" name="new1" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="Text_bold">Confim New Password:
			</td>
			<td><input type="password" value="<?=$new2?>" name="new2" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="Text_bold"><input type="submit"
				value="Submit" name="btn" class="sbttn">
			</td>
			<td><input type="reset" value="Reset" name="btn1" class="sbttn">
			</td>
		</tr>
	</table>
</form>
