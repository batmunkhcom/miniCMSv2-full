<script language="javascript">
mbmSetContentTitle("<?=$lang["menu"]["content_permissions_add"]?>");
mbmSetPageTitle('<?=$lang["menu"]["content_permissions_add"]?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 || $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
?>
<a href="index.php?module=menu&amp;cmd=menu_user_add">add permission</a> 
<form id="form1" name="form1" method="post" action="">
  <div align="center">
    <input name="username" type="text" id="username" size="45" />
    <input type="submit" name="button" id="button" value="view user" class="button" />
  </div>
</form>
<?
if($_POST['username'] || $_GET['u_id']){
	if($DB2->mbm_check_field('username',$_POST['username'],'users')==1 || $DB2->mbm_check_field('id',$_GET['u_id'],'users')==1){
		
		if(isset($_GET['u_id'])){
			$tmp_user_id = $_GET['u_id'];
			$tmp_username = $DB2->mbm_get_field($_GET['u_id'],'id','username','users'); 
		}else{
			$tmp_user_id = $DB2->mbm_get_field($_POST['username'],'username','id','users');
			$tmp_username = $_POST['username']; 
		}
		$_user_id = $tmp_user_id;
	echo '<h2>'.$tmp_username.'</h2>';
	if(isset($_GET['action'])){
		switch($_GET['action']){
			case 'delete':
				if($DB->mbm_check_field('id',$_GET['id'],'menu_users')==1){
					$r_delete_process = $DB->mbm_query("DELETE FROM ".PREFIX."menu_users WHERE id='".$_GET['id']."'");
					if($r_delete_process == 0){
						$result_txt .= $lang["menu"]["command_delete_failed"];
					}else{
						$result_txt .= $lang["menu"]["command_delete_processed"];
					}
				}
			break;
			default:
			break;
		}
		echo '<div id="query_result">'.$result_txt.'</div>';
	}
	?>
	<table width="100%" border="0" cellspacing="2" cellpadding="3" style="border:1px solid #dddddd;">
	  <tr class="list_header">
		<td width="30" align="center">#</td>
		<td><?=$lang["menu"]["menu"]?></td>
		<td width="30" align="center">N</td>
		<td width="30" align="center">P</td>
		<td width="30" align="center">V</td>
		<td width="30" align="center">W</td>
		<td width="30" align="center">E</td>
		<td width="30" align="center">D</td>
        <td width="50" align="center"><?=$lang['main']['status']?></td>
        <td width="50" align="center"><?=$lang['main']['level']?></td>
        <td width="75" align="center"><?=$lang['main']['date_added']?></td>
        <td width="100" align="center"><?=$lang['main']['date_lastupdated']?></td>
        <td width="50" align="center"><?=$lang['main']['total_updated']?></td>	
		<td width="125" align="center">Actions</td>
	  </tr>
      <?
      	$q_menu_users = "SELECT * FROM ".PREFIX."menu_users WHERE user_id='".$tmp_user_id."' ORDER BY id";
		$r_menu_users = $DB->mbm_query($q_menu_users);
		
		for($i=0;$i<$DB->mbm_num_rows($r_menu_users);$i++){
	  ?>
	  <tr>
	    <td align="center"><?=($i+1)?></td>
	    <td><?=$DB->mbm_get_field($DB->mbm_result($r_menu_users,$i,"menu_id"),'id','name','menus')?></td>
	    <td align="center" bgcolor="#f5f5f5" class="tblContents"><img src="images/icons/status_<?=$DB->mbm_result($r_menu_users,$i,"normal")?>.png" /></td>
	    <td align="center" bgcolor="#f5f5f5" class="tblContents"><img src="images/icons/status_<?=$DB->mbm_result($r_menu_users,$i,"is_photo")?>.png" /></td>
	    <td align="center" bgcolor="#f5f5f5" class="tblContents"><img src="images/icons/status_<?=$DB->mbm_result($r_menu_users,$i,"is_video")?>.png" /></td>
	    <td align="center" bgcolor="#f5f5f5" class="tblContents"><img src="images/icons/status_<?=$DB->mbm_result($r_menu_users,$i,"write")?>.png" /></td>
	    <td align="center" bgcolor="#f5f5f5" class="tblContents"><img src="images/icons/status_<?=$DB->mbm_result($r_menu_users,$i,"edit")?>.png" /></td>
	    <td align="center" bgcolor="#f5f5f5" class="tblContents"><img src="images/icons/status_<?=$DB->mbm_result($r_menu_users,$i,"delete")?>.png" /></td>
	    <td align="center" bgcolor="#f5f5f5" class="tblContents"><img src="images/icons/status_<?=$DB->mbm_result($r_menu_users,$i,"st")?>.png" /></td>
            <td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_menu_users,$i,"lev")?></td>
            <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_menu_users,$i,"date_added"))?></td>
            <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_menu_users,$i,"date_lastupdated"))?></td>
            <td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_menu_users,$i,"total_updated")?></td>
	    <td align="center" bgcolor="#f5f5f5" class="tblContents"><a href="index.php?module=menu&amp;cmd=menu_user_edit&amp;id=<?=$DB->mbm_result($r_menu_users,$i,"id")?>">
	      <?=$lang['main']['edit']?>
	    </a> | <a href="#" onclick="confirmSubmit('<?=$lang["menu"]["permission_confirm_del"]?>','index.php?module=menu&amp;cmd=menu_users&amp;action=delete&amp;id=<?=$DB->mbm_result($r_menu_users,$i,"id")?>&amp;u_id=<?=$_user_id?>')">
	    <?=$lang['main']['delete']?>
	    </a></td>
	  </tr>
      <?
      }
	  ?>
	</table>
<?
	}else{
		echo '<div id="query_result">no such user</div>';
	}
}
?>