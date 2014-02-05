<script language="javascript">
mbmSetContentTitle("<?= $lang['user']['update_profile']?>");
mbmSetPageTitle('<?= $lang['user']['update_profile']?>');
show_sub('menu4');
</script>
<?		
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_POST['buttonEdit'])){
	
	if($_POST['pass2']!='' && $_POST['pass1']!=''){
		$data['password']=md5($_POST['pass1']);
	}
	if($_POST['username']!=$_POST['tmp_username']){
		$data['username']=$_POST['username'];
	}
	if($_POST['email']!=$_POST['tmp_email']){
		$data['email']=$_POST['email'];
	}
	
	$data['birthday']=$_POST['birthday'];
	$data['gender']=$_POST['gender'];
	$data['firstname']=$_POST['firstname'];
	$data['lastname']=$_POST['lastname'];
	$data['mobile']=$_POST['mobile'];
	$data['st']=$_POST['st'];
	$data['lev'] = $_POST['lev'];
	$data['administration'] = $_POST['administration'];
	if($_POST['pass1']!=$_POST['pass2']){
		$result_txt = $lang["users"]["error_passwords_not_match"].'.<br />';
		$b=2;
	}
	if($DB2->mbm_check_field('username',$data['username'],'users')==1 && isset($data['username'])){
		$result_txt = $lang["users"]["already_exists_username"].'.<br />';
		$b=2;
	}
	if($DB2->mbm_check_field('email',$data['email'],'users')==1 && isset($data['email'])){
		$result_txt = $lang["users"]["already_exists_email"].'.';
		$b=2;
	}
	if($b!=2){
		if($DB2->mbm_update_row($data,'users',$_GET['id'])==1){
			$b=1;
			$result_txt = $lang["users"]["profile_updated"].'.<br />';
		}else{
			$result_txt = $lang["users"]["profile_update_failed"].'.<br />';
			$b=2;
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
$q_user = "SELECT * FROM ".USER_DB_PREFIX."users WHERE id='".$_GET['id']."'";
$r_user = $DB2->mbm_query($q_user);
if($DB2->mbm_num_rows($r_user)!=1){
	$b=1;
	echo '<div id="query_result">'.$lang["users"]["no_such_user_exists"].'.</div>';
}
if($b!=1){
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="50%" >&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["main"]["level"]?>:<br />
        <select name="lev" id="lev" class="input">
          <?= mbmIntegerOptions(0, $_SESSION['lev'],$DB2->mbm_result($r_user,0,'lev')); ?>
      </select>
      <input type="hidden" name="tmp_username" id="tmp_username" value="<?
      if(isset($_POST['tmp_username'])){
	  	echo $_POST['tmp_username'];
	  }else{
	  	echo $DB2->mbm_get_field($_GET['id'],'id','username','users');
	  }
	  ?>" />
      <input type="hidden" name="tmp_email" id="tmp_email" value="<?
      if(isset($_POST['tmp_email'])){
	  	echo $_POST['tmp_email'];
	  }else{
	  	echo $DB2->mbm_get_field($_GET['id'],'id','email','users');
	  }
	  ?>" /></td>
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
          <option value="1" <? if($DB2->mbm_result($r_user,0,'st')==1) echo 'selected ';?>>
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
    <input name="username" type="text" id="username" value="<?=$DB2->mbm_result($r_user,0,'username')?>" size="45" /></td>
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
    <input name="email" type="text" id="email" value="<?=$DB2->mbm_result($r_user,0,'email')?>" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["firstname"]?>:<br />
    <input name="firstname" type="text" id="firstname" value="<?=$DB2->mbm_result($r_user,0,'firstname')?>" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["lastname"]?>:<br />
    <input name="lastname" type="text" id="lastname" value="<?=$DB2->mbm_result($r_user,0,'lastname')?>" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["users"]["birthday"]?>:<br />
    <input name="birthday" type="text" id="birthday" value="<?=$DB2->mbm_result($r_user,0,'birthday')?>" size="45" /></td>
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
        <option value="F" <?
        if($DB2->mbm_result($r_user,0,'gender')=='F'){
			echo 'selected ';
		}
		?>><?=$lang["users"]["female"]?></option>
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
    <input name="mobile" value="<?=$DB2->mbm_result($r_user,0,'mobile')?>" type="text" id="mobile" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">Administration</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><label>
      <textarea name="administration" cols="45" rows="5" id="administration" <?
      if($modules_permissions["users"]>$_SESSION['lev']){
	  	echo 'disabled="disabled" ';
	  }
	  ?>><?=$DB2->mbm_result($r_user,0,'administration')?></textarea>
    </label></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input name="buttonEdit" type="submit" id="buttonEdit" value="<?=$lang["users"]["button_profile_update"]?>" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
</table>
</form>
<?
}
?>