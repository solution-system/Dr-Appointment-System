<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"
   	rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<!--<script type="text/javascript" src="/include/js/date.js"></script>-->
<script type="text/javascript" src="/include/js/state_city_zip.js"></script>
<script type="text/javascript" src="/include/js/tracking.js?<?=time()?>"></script>
<br>
<form action="/admin/tracking/search" method="post" onsubmit="javascript:return chk_field(this);">
   <input type="hidden" name="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>" />
   <input type="hidden" name="FormAction" id="FormAction" value="tracking" />
   <input type="hidden" name="temp_state" id="temp_state" value="<?=$state?>" />
   <input type="hidden" name="temp_city" id="temp_city" value="<?=$city?>" />
   <input type="hidden" name="temp_zip" id="temp_zip" value="<?=$zip?>">
<table id="tracking_search" align="center" border="1" cellpadding="2" cellspacing="0" width="400">
  <tr>
   	<td  height="30" align="center" colspan="2" bgcolor="#C5735A">
   	  <span style="font-weight: bold; color: #FFFFFF"><strong>Tracking</strong></span>
   	</td>
	</tr>
  <tr>
  	<td align="right" width="50%">Start Date:</td>
   <td><input size="10" readonly value="<?=$start_date?>" type="text" name="start_date" id="start_date" /></td>
  </tr>
  <tr>
  	<td align="right">End Date:</td>
   <td><input size="10" readonly value="<?=$end_date?>" type="text" name="end_date" id="end_date" /></td>
  </tr>
  <tr>
  	<td align="right">Company Name:</td>
   <td><input size="30" value="<?=$company?>" type="text" name="company" id="company" /></td>
  </tr>
  <tr>
   <td align="right">State:</td>
  	<td>
   	<select name="state" id="state" onChange="javascript: ajax_action('state', 'city', this.value);"></select>
	</td>
  </tr>
  <tr>
  	<td align="right">City:</td>
	<td>
		<select name="city" id="city" onChange="javascript: ajax_action('city', 'zip', this.value);"></select>
	</td>
  </tr>
  <tr>
  	<td align="right">Zip-code:</td>
	<td>
			<select name="zip" id="zip"></select>
	</td>
  </tr>
  <tr>
  	<td align="right" valign="top">Field-Clicked:</td>
	<td>
	  <!--<select id="field_clicked" name="field_clicked">
	     <option value=""></option>-->
		<?php
                // print_r($fields);                
		 $sel = '';
		 $i = '';
      	if (is_array($fields))
      	{
         	for ($i=0; $i < count($fields); $i=($i+2))
         	{
                 //   print $i . ' - ' . $this->input->get("field_clicked_" . $i) . '<br>';
         	  if ($this->input->get("field_clicked_" . $i) == $fields[($i+1)])
         	     $sel = ' CHECKED ';
         	  else
         	     $sel = '';
         	  print '<input name="field_clicked_' . $i . '" id="field_clicked_' . $i . '" type="checkbox" ' . $sel . ' value="' . $fields[($i+1)] . '"><font size=-2>' . $fields[$i] . '<br></font>'; // . '</option>';
            }
         }
      	?>
      <!--</select>  -->
	</td>
  </tr>
  <tr>
   	<td height="30" align="center" colspan="2">
      	<input type="submit" value="Show Data" name="btn">
   	</td>
	</tr>
	</form>
</table>
<p align="right"><?=$total_msg?></p>
<form action="/admin/tracking/delete/selected/" onSubmit="javascript:return chk_del('Tracking', this);" name="form1" method="post">
<input type="hidden" name="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>" />
<?php
print $table . '<p align=center>' . $msg . '</p>';
if ($rec_now > 0)
    		print '
     	   <p align="center"> <br>
            <input type="hidden" name="FormAction" value="del_del_sel">
 				<input type="hidden" name="count" value="' . $rec_now . '">
 				<input class="sbttn" type="submit" name="sbtn" value="Delete Ad(s)">
      	</p>
     	</form>';
	print '
	 <p align="center">' . $this->pagination->create_links() . '</p>';
?>