<script type="text/javascript" src="/include/js/user_validation.js?<?= time() ?>"></script>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
        <td height="30" colspan="4"><span style="font-weight: bolder">View/Edit User</span> </td>

        <td height="30" colspan="4" align="center">
            <?= form_open(base_url() . 'admin/user') ?>
            <?= form_label('Search By Name:', 'SearchByName') ?>
            <?= form_input('name', set_value('name', $name)) ?>
            <?= form_submit('search', 'Go') ?>
            <?= form_close(); ?>
        </td>

        <td align="right">
            <a href="/admin/user/add/">Add User</a>
        </td>
    </tr>
</table>


<?php
if ($msg <> '')
    print '
       <p align="center">' . $msg . '</p>';
if (!$user)
    print '
       <p align="center">No user found.</p>';
else {
    print '
 	<form action="/admin/user/delete/selected/" onSubmit="javascript:return chk_del(\'user\', this);" name="form1" method="post">
   <input type="hidden" id="csrf_test_name" name="csrf_test_name" value="' . $this->security->get_csrf_hash() . '" />
 	<p align="right">' . $rec_now . ' of total: ' . $total . '</p>
 	<table id="table_sort" class="tablesorter">
      <thead>
		<tr>
		  <th width="39" align="center">
         <input type="checkbox" onclick="javascript: chk_all(this.checked);"/>	
		  </th>
		  <th width="151">Name</th>
		  <th width="163">Company Email</th>
		  <th width="270">Address</th>
                  <th width="85">Appointment</th>';
            if ($this->session->userdata('ulevel') == 0)
		  print '<th width="85">Doctor</th>';
		  print '<th width="85">Active</th>
		  <th width="85">Ban</th>
		  <th colspan="2"></th>
		</tr>
     </thead>
    <tbody>
   ';
    foreach ($user as $user):
        $user_count++;
        ?>
        <tr class="row" onmouseover="this.className = 'mover';" onmouseout="this.className = 'mouseout';">
            <td align="center">
                <input type="checkbox" name="user_<?= $user_count ?>" value="<?= $user['id'] ?>">
            </td>
            <td nowrap><?= $user['name'] ?></td>
            <td nowrap><?= $user['company_email'] ?></td>
            <td nowrap><?= $user['address'] . ' ' . $user['zip'] . ' ' . $user['city'] . ', ' . $user['state'] ?></td>
            <td nowrap><?= $user['appointment'] ?></td>
            <?php
            if ($this->session->userdata('ulevel') == 0)
                print '<td nowrap>' . $user['doctor'] . '</td>';
            ?>
            <td nowrap><?= $user['active'] ?></td>
            <td nowrap><?= $user['banned'] ?></td>
            <td align="center">
                <a href="/admin/user/edit/<?= $user['id'] ?>">
                    <img width="20" heigth="20" src="/images/edit_icon.gif" border="0" align="center">
                </a>
            </td>
            <td align="center">
                <a href="/admin/user/delete/<?= $user['id'] ?>" onclick="javascript: return confirm('Sure to delete this User: <?= $user['name'] ?>?');">
                    <img src="/images/del.gif" border="0" align="center">
                </a>
            </td>
        </tr>
        <?php
    endforeach;
    print '
	</tbody>
</table>
<p align="center">' . $this->pagination->create_links() . '</p>
<p align=center>
	<input type="hidden" name="FormAction" value="user_del_sel">
	<input type="hidden" name="count" value="' . $total . '">
	<input class="sbttn" type="submit" name="sbtn" value="Delete User">
</p>
</form>';
}
?>

