<script language="javascript">
mbmSetContentTitle("<?=$lang["menu"]["content_user_permissions_list"]?>");
mbmSetPageTitle('<?=$lang["menu"]["content_user_permissions_list"]?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
  	<td width="50%">&nbsp;</td>
  	<td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">username:<br>
    <input name="username" value="<?=$_POST['username']?>" type="text" class="input" id="username" size="45"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" name="viewPermissions" id="viewPermissions" value="<?=$lang['menu']['button_permission_view']?>" class="button"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
</table>
</form>
<?
if(isset($_POST['viewPermissions']) || $_GET['u_id']){
	if(isset($_POST['username'])){
		$_user_id = $DB2->mbm_get_field($_POST['username'],'username','id','users');
	}else{
		$_user_id = $DB2->mbm_get_field($_GET['u_id'],'id','id','users');
	}
	if($_user_id == 0){
		echo '<div id="query_result">no such user found</div>';
	}else{
	echo '<h2>'.addslashes($_POST['username']).' '.$lang['menu']['content_user_permissions_list'].'</h2>';
	
	if(isset($_GET['action'])){
		switch($_GET['action']){
			case 'delete':
				if($DB->mbm_check_field('id',$_GET['id'],'menu_permissions')==1){
					$r_delete_process = $DB->mbm_query("DELETE FROM ".PREFIX."menu_permissions WHERE id='".$_GET['id']."'");
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
	?><table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
		<tr class="list_header">
            <td width="30" align="center"><strong>#</strong></td>
            <td><?=$lang["menu"]["menu"]?></td>
            <td width="100" align="center"><?=$lang["menu"]["permission_added_by"]?></td>
            <td width="30" align="center" title="normal">N</td>
            <td width="30" align="center" title="photo">P</td>
          <td width="30" align="center" title="video">V</td>
          <td width="30" align="center" title="read">R</td>
          <td width="30" align="center" title="write">W</td>
          <td width="30" align="center" title="edit">E</td>
          <td width="30" align="center" title="delete">D</td>
          <td width="50" align="center"><?=$lang['main']['status']?></td>
            <td width="50" align="center"><?=$lang['main']['level']?></td>
            <td width="75" align="center"><?=$lang['main']['date_added']?></td>
            <td width="100" align="center"><?=$lang['main']['date_lastupdated']?></td>
            <td width="100" align="center"><?=$lang['main']['action']?></td>
        </tr>
        <?
        $q_user_permissions = "SELECT * FROM ".PREFIX."menu_permissions WHERE user_id='".$_user_id."' ORDER BY admin_user_id, date_added";
		$r_user_permissions = $DB->mbm_query($q_user_permissions);

		for($i=0;$i<$DB->mbm_num_rows($r_user_permissions);$i++){
		?>
        <tr>
            <td align="center" bgcolor="#f5f5f5"><strong><?=($i+1)?>.</strong></td>
            <td bgcolor="#f5f5f5"><?=$DB->mbm_get_field($DB->mbm_result($r_user_permissions,$i,"menu_id"),"id","name","menus")?></td>
            <td bgcolor="#f5f5f5"><?=$DB2->mbm_get_field($DB->mbm_result($r_user_permissions,$i,"admin_user_id"),'id','username','users')?></td>
            <td align="center" bgcolor="#f5f5f5"><img src="images/icons/status_<?=$DB->mbm_result($r_user_permissions,$i,"normal")?>.png" /></td>
            <td align="center" bgcolor="#f5f5f5"><img src="images/icons/status_<?=$DB->mbm_result($r_user_permissions,$i,"is_photo")?>.png" /></td>
            <td align="center" bgcolor="#f5f5f5"><img src="images/icons/status_<?=$DB->mbm_result($r_user_permissions,$i,"is_video")?>.png" /></td>
            <td align="center" bgcolor="#f5f5f5"><img src="images/icons/status_<?=$DB->mbm_result($r_user_permissions,$i,"read")?>.png" /></td>
            <td align="center" bgcolor="#f5f5f5"><img src="images/icons/status_<?=$DB->mbm_result($r_user_permissions,$i,"write")?>.png" /></td>
            <td align="center" bgcolor="#f5f5f5"><img src="images/icons/status_<?=$DB->mbm_result($r_user_permissions,$i,"edit")?>.png" /></td>
            <td align="center" bgcolor="#f5f5f5"><img src="images/icons/status_<?=$DB->mbm_result($r_user_permissions,$i,"delete")?>.png" /></td>
            <td align="center" bgcolor="#f5f5f5"><img src="images/icons/status_<?=$DB->mbm_result($r_user_permissions,$i,"st")?>.png" /></td>
            <td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_user_permissions,$i,"lev")?></td>
            <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_user_permissions,$i,"date_added"))?></td>
            <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_user_permissions,$i,"date_lastupdated")).'<br />['.$DB->mbm_result($r_user_permissions,$i,"total_updated").']'?></td>
            <td align="center" bgcolor="#f5f5f5" width="145"><?
            	echo mbmAdminButtonEdit('index.php?module=menu&amp;cmd=menu_permission_edit&amp;id='.$DB->mbm_result($r_user_permissions,$i,"id"));
				echo mbmAdminButtonDelete('index.php?module=menu&cmd=menu_permissions_list&action=delete&id='.$DB->mbm_result($r_user_permissions,$i,"id").'&u_id='.$_user_id,$lang["menu"]["permission_confirm_del"]);
			?></td>
  </tr>
        <?
        }
		?>
       </table>
<?
	}
}
?>