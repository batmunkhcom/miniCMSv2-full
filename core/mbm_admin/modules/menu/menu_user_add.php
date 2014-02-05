<script language="javascript">
mbmSetContentTitle("<?=$lang["menu"]["content_permissions_add"]?>");
mbmSetPageTitle('<?=$lang["menu"]["content_permissions_add"]?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 || $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['addPermissions'])){
	$result_txt = '';
	if($DB2->mbm_check_field('username',$_POST['username'],'users')==0){
		$result_txt .= $lang["users"]["no_such_user_exists"].' <br />';
		$b=2;
	}
	if($_POST['read']!=1 && $_POST['write']!=1 && $_POST['edit']!=1 && $_POST['delete']!=1){
		$result_txt .= $lang["menu"]["select_at_least_one_permission"].'.<br />';
		$b=2;
	}
	if(!is_array($_POST['menu_ids'])){
		$result_txt .= $lang["menu"]["select_at_least_one_menu"].'<br />';
		$b=2;
	}
	if($b!=2){
		$data['user_id'] = $DB2->mbm_get_field($_POST['username'],'username','id','users');
		$data['st'] = $_POST['st'];
		$data['lev'] = $_POST['lev'];
		$data['admin_user_id'] = $_SESSION['user_id'];
		$data['comment'] = $_POST['comment'];
		$data['date_added'] = mbmTime();
		$data['date_lastupdated'] = $data['date_added'];
		$data['total_updated'] = 0;
				
		if(isset($_POST['read'])) $data['read'] = $_POST['read'];		
		if(isset($_POST['write'])) $data['write'] = $_POST['write'];
		if(isset($_POST['edit'])) $data['edit'] = $_POST['edit'];
		if(isset($_POST['delete'])) $data['delete'] = $_POST['delete'];
		if(isset($_POST['is_photo'])) $data['is_photo'] = $_POST['is_photo'];
		if(isset($_POST['is_video'])) $data['is_video'] = $_POST['is_video'];
		if(isset($_POST['normal'])) $data['normal'] = $_POST['normal'];
		
		foreach($_POST['menu_ids'] as $k_menus=>$v_menus){
			$data['menu_id'] = $v_menus;
			
			$q_check_user_permission = "SELECT COUNT(*) FROM ".PREFIX."menu_users 
										WHERE user_id='".$data['user_id']." ' 
										AND menu_id='".$data['menu_id']."' ";
			$r_check_user_permission = $DB->mbm_query($q_check_user_permission);
			if($DB->mbm_result($r_check_user_permission,0)!=0){
				$r_menus[$data['menu_id']] = 0;
			}else{
				$r_menus[$data['menu_id']] = $DB->mbm_insert_row($data,'menu_users');
			}
			unset($data['menu_id']);
		}
		foreach($r_menus as $k_result=>$v_result){
			if($v_result==1){
				$result_txt .= $DB->mbm_get_field($k_result,'id','name','menus').' '.$lang["menu"]["permission_processed"].'.<br />';
				$b=1;
			}else{
				$result_txt .= '<span class="red">';
				$b=0;
				$result_txt .= $DB->mbm_get_field($k_result,'id','name','menus').' '.$lang["menu"]["permission_process_failed"].'.</span><br />';
			}
		}
		if($b!=2 && $b!=0){
			$b=1;
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
if($b!=1){
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
  	<td width="50%">&nbsp;</td>
  	<td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["main"]["username"]?>:<br>
    <input name="username" value="<?=$_POST['username']?>" type="text" class="input" id="username" size="45"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['menu']['select_menus']?>:<br>
      <select name="menu_ids[]" multiple="multiple" size="8" style="width:200px">
        <?=mbmShowMenuCombobox(0); ?>
            </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['main']['status']?>:<br>
        <select name="st" id="st">
          <?=mbmShowStOptions($_POST['st'])?>
          <option value="2"><?=$lang['menu']['status_any']?></option>
        </select>    </td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['main']['level']?>:<br>
        <select name="lev">
          <?= mbmIntegerOptions(0, 5,$_POST['lev']); ?>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['menu']['content_permissions']?>:<br>
      <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="25%" height="25" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_read"]?></td>
        <td width="25%" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_write"]?></td>
        <td width="25%" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_edit"]?></td>
        <td width="25%" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_delete"]?></td>
      </tr>
      <tr>
        <td height="25" align="center" bgcolor="#eeeeee"><input name="read" type="checkbox" id="read" value="1" <?
        if($_POST['read']==1){
			echo 'checked';
		}
		?>></td>
        <td align="center" bgcolor="#eeeeee"><input type="checkbox" name="write" id="write" value="1" <?
        if($_POST['write']==1){
			echo 'checked';
		}
		?>></td>
        <td align="center" bgcolor="#eeeeee"><input type="checkbox" name="edit" id="edit" value="1" <?
        if($_POST['edit']==1){
			echo 'checked';
		}
		?>></td>
        <td align="center" bgcolor="#eeeeee"><input type="checkbox" name="delete" id="delete" value="1" <?
        if($_POST['delete']==1){
			echo 'checked';
		}
		?>></td>
      </tr>
    </table>
      <table width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td width="25%" height="25" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_photo"]?></td>
          <td width="25%" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_video"]?></td>
          <td width="25%" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_normal"]?></td>
          <td width="25%" align="center" bgcolor="#dddddd">&nbsp;</td>
        </tr>
        <tr>
          <td height="25" align="center" bgcolor="#eeeeee"><input name="is_photo" type="checkbox" id="is_photo" value="1" <?
        if($_POST['is_photo']==1){
			echo 'checked';
		}
		?> /></td>
          <td align="center" bgcolor="#eeeeee"><input type="checkbox" name="is_video" id="is_video" value="1" <?
        if($_POST['is_video']==1){
			echo 'checked';
		}
		?> /></td>
          <td align="center" bgcolor="#eeeeee"><input type="checkbox" name="normal" id="normal" value="1" <?
        if($_POST['normal']==1){
			echo 'checked';
		}
		?> /></td>
          <td align="center" bgcolor="#eeeeee">&nbsp;</td>
        </tr>
      </table></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["main"]["comment"]?>:<br>
      <textarea name="comment" cols="45" rows="3" id="comment" class="input"><?=$_POST['comment']?></textarea></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" name="addPermissions" id="addPermissions" value="<?=$lang['menu']['button_permission_add']?>" class="button"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
</table>
</form>
<?
}
?>