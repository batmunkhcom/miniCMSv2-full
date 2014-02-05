<script language="javascript">
mbmSetContentTitle("<?=$lang["menu"]["content_permissions_add"]?>");
mbmSetPageTitle('<?=$lang["menu"]["content_permissions_add"]?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 || $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['updatePermissions'])){
	$result_txt = '';
	
	if($_POST['read']!=1 && $_POST['write']!=1 && $_POST['edit']!=1 && $_POST['delete']!=1){
		$result_txt .= $lang["menu"]["select_at_least_one_permission"].'.<br />';
		$b=2;
	}
	if($b!=2){
		$data['st'] = $_POST['st'];
		$data['lev'] = $_POST['lev'];
		$data['admin_user_id'] = $_SESSION['user_id'];
		$data['comment'] = $_POST['comment'];
		$data['date_lastupdated'] = mbmTime();
		$data['total_updated'] = $DB->mbm_get_field($_GET['id'],'id','total_updated','menu_users')+1;
		
		if(isset($_POST['read'])) $data['read'] = $_POST['read'];
		else $data['read'] = 0;
		if(isset($_POST['write'])) $data['write'] = $_POST['write'];
		else $data['write'] = 0;
		if(isset($_POST['edit'])) $data['edit'] = $_POST['edit'];
		else $data['edit'] = 0;
		if(isset($_POST['delete'])) $data['delete'] = $_POST['delete'];
		else $data['delete'] = 0;
		if(isset($_POST['is_photo'])) $data['is_photo'] = $_POST['is_photo'];
		else $data['is_photo'] = 0;
		if(isset($_POST['is_video'])) $data['is_video'] = $_POST['is_video'];
		else $data['is_video'] = 0;
		if(isset($_POST['normal'])) $data['normal'] = $_POST['normal'];
		else $data['normal'] = 0;
		
		if($DB->mbm_update_row($data,'menu_users',$_GET['id'])==1){
			$result_txt = $lang["menu"]["update_success"];
			$b=1;
		}else{
			$result_txt = $lang["menu"]["update_failed"];
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
      <td bgcolor="#f5f5f5"><?=$lang["main"]["username"]?>
        :<br />
        <strong>
          <?=$DB2->mbm_get_field($DB->mbm_get_field($_GET['id'],'id','user_id','menu_users'),'id','username','users')?>
        </strong></td>
      <td bgcolor="#f5f5f5">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#f5f5f5">&nbsp;</td>
      <td bgcolor="#f5f5f5">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#f5f5f5"><?=$lang['main']['status']?>
        :<br />
        <select name="st" id="st">
          <?=mbmShowStOptions($DB->mbm_get_field($_GET['id'],'id','st','menu_users'))?>
          <option value="2" <?
          if($DB->mbm_get_field($_GET['id'],'id','st','menu_users')==2){
		  	echo 'selected';
		  }
		  ?>>
            <?=$lang['menu']['status_any']?>
          </option>
        </select>
      </td>
      <td bgcolor="#f5f5f5">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#f5f5f5">&nbsp;</td>
      <td bgcolor="#f5f5f5">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#f5f5f5"><?=$lang['main']['level']?>
        :<br />
        <select name="lev">
          <?= mbmIntegerOptions(0, 5,$DB->mbm_get_field($_GET['id'],'id','lev','menu_users')); ?>
      </select></td>
      <td bgcolor="#f5f5f5">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#f5f5f5">&nbsp;</td>
      <td bgcolor="#f5f5f5">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#f5f5f5"><?=$lang['main']['content_permissions']?>
        :<br />
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="25%" height="25" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_read"]?></td>
            <td width="25%" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_write"]?></td>
            <td width="25%" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_edit"]?></td>
            <td width="25%" align="center" bgcolor="#dddddd"><?=$lang["menu"]["permission_delete"]?></td>
          </tr>
          <tr>
            <td height="25" align="center" bgcolor="#eeeeee"><input name="read" type="checkbox" id="read" value="1" <?
        if($DB->mbm_get_field($_GET['id'],'id','read','menu_users')==1){
			echo ' checked="checked" ';
		}
		?> /></td>
            <td align="center" bgcolor="#eeeeee"><input type="checkbox" name="write" id="write" value="1" <?
        if($DB->mbm_get_field($_GET['id'],'id','write','menu_users')==1){
			echo ' checked="checked" ';
		}
		?> /></td>
            <td align="center" bgcolor="#eeeeee"><input type="checkbox" name="edit" id="edit" value="1" <?
        if($DB->mbm_get_field($_GET['id'],'id','edit','menu_users')==1){
			echo ' checked="checked" ';
		}
		?> /></td>
            <td align="center" bgcolor="#eeeeee"><input name="delete" type="checkbox" id="delete" value="1" <?
        if($DB->mbm_get_field($_GET['id'],'id','delete','menu_users')==1){
			echo ' checked="checked" ';
		}
		?> /></td>
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
         if($DB->mbm_get_field($_GET['id'],'id','is_photo','menu_users')==1){
			echo ' checked="checked" ';
		}
		?> /></td>
            <td align="center" bgcolor="#eeeeee"><input type="checkbox" name="is_video" id="is_video" value="1" <?
         if($DB->mbm_get_field($_GET['id'],'id','is_video','menu_users')==1){
			echo ' checked="checked" ';
		}
		?> /></td>
            <td align="center" bgcolor="#eeeeee"><input type="checkbox" name="normal" id="normal" value="1" <?
         if($DB->mbm_get_field($_GET['id'],'id','normal','menu_users')==1){
			echo ' checked="checked" ';
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
      <td bgcolor="#f5f5f5"><?=$lang["main"]["comment"]?>
        :<br />
        <textarea name="comment" cols="45" rows="3" id="comment" class="input"><?=$DB->mbm_get_field($_GET['id'],'id','comment','menu_users')?>
  </textarea></td>
      <td bgcolor="#f5f5f5">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#f5f5f5">&nbsp;</td>
      <td bgcolor="#f5f5f5">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#f5f5f5"><input type="submit" name="updatePermissions" id="updatePermissions" value="<?=$lang['menu']['button_permission_edit']?>" class="button" /></td>
      <td bgcolor="#f5f5f5">&nbsp;</td>
    </tr>
  </table>
</form>
<?
}
?>