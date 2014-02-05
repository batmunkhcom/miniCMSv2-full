<script language="javascript">
mbmSetContentTitle("<?= $lang['users']['users_list']?>");
mbmSetPageTitle('<?= $lang['users']['users_list']?>');
show_sub('menu4');
</script>
<?		
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  ?>
<form id="form1" name="searchUser" method="post" action="" onsubmit="alert('Click filter button');return false;">
  <div align="center">
    <input type="text" name="q" id="q" />
    <input type="button" name="button" id="button" value="Filter users" onclick="window.location='index.php?module=users&cmd=user_list&start=0&=25&q='+document.searchUser.q.value" />
  </div>
</form>
<?
	if(isset($_GET['action']) && $_GET['action']!=''){
		switch($_GET['action']){
			case 'st':
				
				if($DB2->mbm_check_field('id',$_GET['id'],'users')==0){
					$result_txt = $lang["users"]["no_such_user_exists"];
				}elseif($DB2->mbm_query("UPDATE ".USER_DB_PREFIX."users SET st='".$_GET['st']."' WHERE id='".$_GET['id']."'")==1){
					$result_txt = $lang["users"]["command_processed"];
				}else{
					$result_txt = $lang["users"]["command_failed"];
				}
			break;
			case 'lev':
				if($DB2->mbm_check_field('id',$_GET['id'],'users')==0){
					$result_txt = $lang["users"]["no_such_user_exists"];
				}elseif($DB2->mbm_query("UPDATE ".USER_DB_PREFIX."users SET lev='".$_GET['lev']."' WHERE id='".$_GET['id']."'")==1){
					$result_txt = $lang["users"]["command_processed"];
				}else{
					$result_txt = $lang["users"]["command_failed"];
				}
			break;
			case 'delete':
				$result_txt = 'Unavailable yet.';
			break;
		}
		echo '<div id="query_result">'.$result_txt.'</div>';
	}
  	$q_user = "SELECT * FROM ".$DB2->prefix."users WHERE  id>0 AND lev<='".$_SESSION['lev']."' ";
	if(isset($_GET['q'])){
		$q_user = "SELECT * FROM ".$DB2->prefix."users WHERE 
					username LIKE '%".addslashes($_GET['q'])."%' 
					OR email LIKE '%".addslashes($_GET['q'])."%' ";
	}
	if(isset($_GET['st'])){
		$q_user .= "AND st='".addslashes($_GET['st'])."' ";
	}
	$q_user .= "ORDER BY lev DESC";
	$r_user = $DB2->mbm_query($q_user);
	//echo $q_user;
	echo mbmNextPrev('index.php?module=users&cmd=user_list',$DB2->mbm_num_rows($r_user),START, PER_PAGE);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
  	<td width="75" align="center">#</td>
    <td><?=$lang["users"]["username"]?></td>
    <td width="150"><?=$lang["users"]["firstname"]?></td>
    <td width="150"><?=$lang["users"]["lastname"]?></td>
    <td width="70" align="center"><?=$lang["main"]["level"]?></td>
    <td width="50" align="center"><?=$lang["main"]["status"]?></td>
	<td colspan="2" align="center">&nbsp;</td>
	<?
	
	if((START+PER_PAGE) > $DB2->mbm_num_rows($r_user)){
		$end= $DB2->mbm_num_rows($r_user);
	}else{
		$end= START+PER_PAGE; 
	}
	for($i=START;$i<$end;$i++){
  ?>
  <tr <?=mbmonMouse("#e2e2e2","#d2d2d2","")?> height="20">
  	<td align="center" class="bold"><?=($i+1)?>.</td>
	<td><a title="<?=$DB2->mbm_result($r_user,$i,"email")?>" href="index.php?module=users&cmd=user_full&user_id=<?=$DB2->mbm_result($r_user,$i,"id")?>"><?=$DB2->mbm_result($r_user,$i,"username")?></a></td>
  	<td><?=$DB2->mbm_result($r_user,$i,"firstname")?></td>
  	<td><?=$DB2->mbm_result($r_user,$i,"lastname")?></td>
	<td align="center">
		<select name="user_lev" onchange="window.location='index.php?module=users&cmd=user_list&action=lev&lev='+this.value+'&id=<?=$DB2->mbm_result($r_user,$i,"id")?>'">
		<?= mbmIntegerOptions(1, $_SESSION['lev'], $DB2->mbm_result($r_user,$i,"lev"))?>;
		</select>	</td>
  	<td align="center">
	<a href="index.php?module=users&cmd=user_list&action=st&id=<?=$DB2->mbm_result($r_user,$i,"id")?>&st=<?
	if($DB2->mbm_result($r_user,$i,"st")==0){
		echo 1;
	}else{
		echo 0;
	}
	?>&start=<?=START?>">
	<img src="images/user_st<?=$DB2->mbm_result($r_user,$i,"st")?>.gif" border="0" /></a>  	</td>
  <td width="50" align="center"><a href="index.php?module=users&cmd=user_edit&id=<?=$DB2->mbm_result($r_user,$i,"id")?>" /><img src="images/<?=$_SESSION['ln']?>/button_edit.png" border="0" alt="<?= $lang['main']['edit']?>" hspace="3" /></a></td>
  <td width="50">
    <a href="#" onclick="confirmSubmit('<?=addslashes($lang['menu']['confirm_delete_menu'])?>','index.php?module=users&cmd=user_list&action=delete&id=<?= $DB2->mbm_result($r_user,$i,"id")?>')"><img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" /></a></td>
  </tr>
  <?
  }
  ?>
</table>
<?
	echo mbmNextPrev('index.php?module=users&cmd=user_list',$DB2->mbm_num_rows($r_user),START, PER_PAGE);
?>