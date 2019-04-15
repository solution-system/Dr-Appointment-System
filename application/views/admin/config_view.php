
<P align="right">
    <a href="/admin/config/add/">Add Config</a>
</P>
<p align="right"><?= $rec_now ?> of total: <?= $total ?></p>
<form action="/admin/config/delete/selected/" onSubmit="javascript:return chk_del('Facilty', this);" name="form1" method="post">
    <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>" />
    <?php
    print $table . '<p align=center>' . $msg . '</p>';
    if ($total > 0)
        print '
     	   <p align="center"> <br>
            <input type="hidden" name="FormAction" value="del_del_sel">
 				<input type="hidden" name="count" value="' . $total . '">
 				<input class="sbttn" type="submit" name="sbtn" value="Delete Config(s)">
      	</p>
     	</form>';
    print '
	 <p align="center">' . $this->pagination->create_links() . '</p>';
    ?>