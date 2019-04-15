
<form method="post" onsubmit="javascript: if (this.detail.value == '') { alert('Enter detail first...'); this.detail.focus(); return false; } ">
<table align="center" border="0" align="center" cellpadding="3" cellspacing="0">
   <tr>
      <td height="30" align="center"><span style="font-weight: bold">Search News:</span>
        <input name="detail" type="text" id="detail" value="<?=$detail?>" />
        <input type="submit" name="Submit" value="Go" />
      </td>
      <td align="right"><?=$rec_now?> Total News</td>
   </tr>
</table>
</form>
<form action="/news/delete/selected/" onSubmit="javascript:return chk_del('News', this);" name="form1" method="post">
<?php
print $table . '<p align=center>' . $msg . '</p>';
?>