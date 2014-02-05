<script language="javascript">

mbmSetContentTitle("Add newsletter");

mbmSetPageTitle('Add newsletter');

show_sub('menu16');

</script>

<?

if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){

	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');

}

if(isset($_POST['add'])){

	$data['st'] = $_POST['st'];

	$data['lev'] = $_POST['lev'];

	$data['user_id'] = $_SESSION['user_id'];

	$data['name_from'] = $_POST['name_from'];

	$data['email_from'] = $_POST['email_from'];

	$data['subject'] = $_POST['subject'];

	$data['content'] = $_POST['content'];

	$data['per_send'] = $_POST['per_send'];

	$data['intervals'] = $_POST['intervals'];

	$data['date_added'] = mbmTime();

	

	if($DB->mbm_insert_row($data,'newsletters')==1){

		echo 'done';

		$b=1;

	}else{

		echo ' try again';

	}

}

if($b!=1){

?>

<form name="form1" method="post" action="">

  <table width="100%" border="0" cellspacing="2" cellpadding="0">

    <tr>

      <td width="50%" bgcolor="#F5F5F5">Name from<br>

      <input name="name_from" type="text" id="name_from" size="30"></td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F9F9F9">&nbsp;</td>

      <td bgcolor="#F9F9F9">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F5F5F5">Email from<br>

      <input name="email_from" type="text" id="email_from" size="30"></td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F9F9F9">&nbsp;</td>

      <td bgcolor="#F9F9F9">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F5F5F5">Per send<br>

      <input name="per_send" type="text" id="per_send" size="30"></td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F9F9F9">&nbsp;</td>

      <td bgcolor="#F9F9F9">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F5F5F5">Interval (in minutes)<br>

      <input name="intervals" type="text" id="intervals" size="30"></td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F9F9F9">&nbsp;</td>

      <td bgcolor="#F9F9F9">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F5F5F5">Status<br>

        <input name="st" type="text" id="st" size="30"></td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F9F9F9">&nbsp;</td>

      <td bgcolor="#F9F9F9">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F5F5F5">Level<br>

        <input name="lev" type="text" id="lev" size="30"></td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F9F9F9">&nbsp;</td>

      <td bgcolor="#F9F9F9">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F5F5F5">Subject<br>

      <input name="subject" type="text" id="subject" size="30"></td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F9F9F9">Content (HTML code)<br>

      <textarea name="content" cols="60" rows="9" id="content"></textarea></td>

      <td bgcolor="#F9F9F9">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F5F5F5">&nbsp;</td>

      <td bgcolor="#F5F5F5">&nbsp;</td>

    </tr>

    <tr>

      <td bgcolor="#F9F9F9"><input type="submit" name="add" id="add" value="Add newsletter">

      <input type="submit" name="preview" id="preview" value="Preview newsletter"></td>

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