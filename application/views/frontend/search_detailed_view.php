<script type="text/javascript" src="/include/js/state_city_zip.js"></script>
<script type="text/javascript" src="/include/js/search.js"></script>
<br>
<form method="post" onsubmit="javascript:return chk_field(this);">
<table align="center" border="0" cellpadding="2" cellspacing="0" width="400">
  <tr>
   	<td  height="30" align="center" colspan="2">
         <strong>Search</strong>
   	</td>
	</tr>
  <tr>
  	<td align="right">Service:</td>
   <td>
      <select name="service" id="service">
   	<?php
      	foreach($services as $service):
		      print '<option value="' . $service['id'] . '" />' . $service['name'] . ' Service</option>';
         endforeach; ?>
   </td>
  </tr>
  <tr>
   <td align="right">Keyword:</td>
  	<td>
   	<input size="40" name="keyword" id="keyword">
	</td>
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
   	<td height="30" align="center" colspan="2">
      	<input type="submit" value="Show Data" name="btn">
   	</td>
	</tr>
	</form>
</table>