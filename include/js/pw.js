/**
 * 
 */
function chkfield(d)
{
	if (d.old.value.length==0)
	{
		$("#msg").html("<font color=red>ERROR: Please enter old password...</font>");
		d.old.focus();
		return false;
	}
	if (d.new1.value.length==0)
	{
		$("#msg").html("<font color=red>ERROR: Please enter new password...</font>");
		d.new1.focus();
		return false;
	}
	if (d.new2.value.length==0)
	{
		$("#msg").html("<font color=red>ERROR: Please enter confirmed password...</font>");
		d.new2.focus();
		return false;
	}
	if (d.new1.value !== d.new2.value)
	{
		$("#msg").html("<font color=red>ERROR: New password and old password must be same...</font>");
		d.new1.focus();
		return false;
	}
}