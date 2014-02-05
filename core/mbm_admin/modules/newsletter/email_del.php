<script language="javascript">

mbmSetContentTitle("Delete email address");

mbmSetPageTitle('Delete email address');

show_sub('menu16');

</script>

<?

if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){

	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');

}

if(isset($_POST['delete'])){

	

	$q_del = "DELETE FROM ".PREFIX."newsletter_emails WHERE email='".addslashes($_POST['email'])."' LIMIT 1";

	

	if($DB->mbm_query($q_del)==1){

		echo 'done';

	}else{

		echo ' try again';

	}

}

if($b!=1){

?>

<form name="form1" method="post" action="">

  <table width="100%" border="0" cellspacing="2" cellpadding="0">

    <tr>

      <td width="50%" bgcolor="#F5F5F5">Email to delete<br>

      <input name="email" type="text" id="email" size="30"></td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F9F9F9"><input type="submit" name="delete" id="delete" value="Delete email"></td>

      <td bgcolor="#F9F9F9">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F5F5F5">&nbsp;</td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

  </table>

</form>

<?

}

?>