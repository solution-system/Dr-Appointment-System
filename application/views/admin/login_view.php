<font color=red><?=$sError?></font>
<?=form_open()?>
	<?=form_fieldset($u . ' Login Form')?>
      <?=form_hidden('ret_page', $ret_page)?>
		<div class="textfield">
			<?=form_label('Username:', 'username')?>
			<?=form_input('username', set_value('username', $username))?>
			

		</div>
		
		<div class="textfield">
			<?=form_label('Password:', 'password')?>
			<?=form_password('password')?>
			<?=form_error('password')?>
		</div>
		<div class="buttons">
			<?=form_submit('login', 'Login')?>
		</div>
		
	<?=form_fieldset_close()?>
<?=form_close();?>

<div>
    <button onclick="location.href = '/'" class="btn btn-primary btn-x" type="button">Change User Type</button>
</div>