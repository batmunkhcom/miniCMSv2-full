<script language="javascript">
mbmSetContentTitle("<?= $lang['users']['user_add']?>");
mbmSetPageTitle('<?= $lang['users']['user_add']?>');
show_sub('menu4');
</script>
<?		
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_POST['buttonRegister'])){
	$data['username']=$_POST['username'];
	$data['password']=md5($_POST['pass1']);
	$data['email']=$_POST['email'];
	//$data['birthday']=$_POST['birthday'];
	$data['gender']=$_POST['gender'];
	$data['firstname']=$_POST['firstname'];
	$data['lastname']=$_POST['lastname'];
	$data['mobile']=$_POST['mobile'];
	$data['st']=$_POST['st'];
	$data['lev']=$_POST['lev'];
	if($_POST['pass1']!=$_POST['pass2']){
		$result_txt = $lang["users"]["error_passwords_not_match"].'.<br />';
		$b=2;
	}
	if($DB2->mbm_check_field('username',$data['username'],'users')==1){
		$result_txt = $lang["users"]["already_exists_username"].'.<br />';
		$b=2;
	}
	if($DB2->mbm_check_field('email',$data['email'],'users')==1){
		$result_txt = $lang["users"]["already_exists_email"].'.';
		$b=2;
	}
	if($b!=2){
		if($DB2->mbm_insert_row($data,"users")==1){
			$b=1;
			$result_txt = $lang["users"]["command_processed"];
		}else{
			$result_txt = $lang["users"]["command_failed"];
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
if($b!=1){
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="50%" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" bgcolor="#f5f5f5"><?=$lang["users"]["sponsor"]?>:<br />
    <input name="sponsor" type="text" id="sponsor" size="45" /></td>
    <td width="50%" bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["main"]["level"]?>:<br />
        <select name="lev" id="lev" class="input">
          <?= mbmIntegerOptions(0, $_SESSION['lev'],$_POST['lev']); ?>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["main"]["status"]?>:<br />
        <select name="st" id="st" class="input">
          <option value="0">
          <?= $lang['status'][0]?>
          </option>
          <option value="1" <?
          	if($_POST['st']==1){
				echo ' selected ';
			}
		  ?>>
          <?= $lang['status'][1]?>
          </option>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["username"]?>:<br />
    <input name="username" type="text" id="username" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["password"]?>:<br />
      <input name="pass1" type="password" id="pass1" size="45" />    </td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["verify_password"]?>:<br />
    <input name="pass2" type="password" id="pass2" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["email"]?>:<br />
    <input name="email" type="text" id="email" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["firstname"]?>:<br />
    <input name="firstname" type="text" id="firstname" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["lastname"]?>:<br />
    <input name="lastname" type="text" id="lastname" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["birthday"]?>:<br />
    <input name="birthday" type="text" id="birthday" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["gender"]?>:<br />
      <label>
      <select name="gender" id="gender" class="input">
        <option value="M"><?=$lang["users"]["male"]?></option>
        <option value="F"><?=$lang["users"]["female"]?></option>
      </select>
      </label></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["mobile"]?>:<br />
    <input name="mobile" type="text" id="mobile" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input name="buttonRegister" type="submit" id="buttonRegister" value="<?=$lang["users"]["button_register_user"]?>" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
</table>
</form>
<?
}
?>