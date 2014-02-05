function checkEmpty(frm)
{
	if (frm.username.value == "" || frm.password.value == "")
	{
		alert("Please enter username & password.");
		frm.username.focus();
		return false;
	}
	return true;
}