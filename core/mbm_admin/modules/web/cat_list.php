<script language="javascript">
mbmSetContentTitle("<?=$lang["web"]["categories"]?>");
mbmSetPageTitle('<?=$lang["web"]["categories"]?>');
show_sub('menu9');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_GET['action']) && $DB->mbm_check_field('id',$_GET['id'],'web_cats')==1){
	switch($_GET['action']){
		case 'st':
			if($DB->mbm_query("UPDATE ".PREFIX."web_cats SET total_updated=total_updated+1,st='".$_GET['st']."' WHERE id='".$_GET['id']."'")==1){
				$result_txt = 'status updated.';
			}else{
				$result_txt = 'status update failed.';
			}
		break;
		case 'lev':
		break;
		case 'delete':
			if($DB->mbm_query("DELETE FROM ".PREFIX."web_cats WHERE id='".$_GET['id']."'")==1){
				$result_txt = 'Deleted.';
			}else{
				$result_txt = 'Delete failed.';
			}			
		break;
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
$q_web_cats = "SELECT * FROM ".PREFIX."web_cats WHERE lang='".$_SESSION['ln']."' ";
if($DB->mbm_check_field('cat_id',$_GET['cat_id'],'web_cats')==1){
	$q_web_cats .= "AND cat_id='".$_GET['cat_id']."' ";
}
$q_web_cats .= "ORDER BY pos";

$r_web_cats = $DB->mbm_query($q_web_cats);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="30" align="center">#</td>
    <td>name</td>
    <td width="100" >user</td>
    <td width="50" align="center" >st</td>
    <td width="50" align="center" >lev</td>
    <td width="75" align="center" >added</td>
    <td width="75" align="center" >updated</td>
    <td width="100" align="center" >hits</td>
    <td width="125" align="center" >action</td>
  </tr>
<?
	for($i=0;$i<$DB->mbm_num_rows($r_web_cats);$i++){
?>  
  <tr>
    <td bgcolor="#f5f5f5" align="center"><strong><?=($i+1)?>.</strong></td>
    <td bgcolor="#f5f5f5"><?
						echo '<strong>';
						if($DB->mbm_check_field('cat_id',$DB->mbm_result($r_web_cats,$i,"id"),"web_cats")==1){
							echo '<a href="index.php?module=web&cmd=cat_list&cat_id='
								.$DB->mbm_result($r_web_cats,$i,"id").'" title="click to view sub categories">'
								.$DB->mbm_result($r_web_cats,$i,"name").'</a>';
						}else{
							echo $DB->mbm_result($r_web_cats,$i,"name");
						}
						echo ''
							.'</strong> ['.$DB->mbm_result($r_web_cats,$i,"total_links")
							.']<br />'
							.$DB->mbm_result($r_web_cats,$i,"comment").' [id: '.$DB->mbm_result($r_web_cats,$i,"id").']'?></td>
    <td bgcolor="#f5f5f5"><?=$DB2->mbm_get_field($DB->mbm_result($r_web_cats,$i,"user_id"),'id','username','users')?></td>
    <td align="center" bgcolor="#f5f5f5"><a href="index.php?module=web&cmd=cat_list&id=<?=$DB->mbm_result($r_web_cats,$i,"id")?>&action=st&st=<?=(($DB->mbm_result($r_web_cats,$i,"st")+1)%2)?>&cat_id=<?=$_GET['cat_id']?>">
    <img src="images/icons/status_<?=$DB->mbm_result($r_web_cats,$i,"st")?>.png" border="0" />
    </a></td>
    <td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_web_cats,$i,"lev")?></td>
    <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_web_cats,$i,"date_added"))?></td>
    <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_web_cats,$i,"date_lastupdated"))
											.'<br />'.$DB->mbm_result($r_web_cats,$i,"total_updated")?> times</td>
    <td align="center" bgcolor="#f5f5f5"><?=number_format($DB->mbm_result($r_web_cats,$i,"hits"))?></td>
    <td align="center" bgcolor="#f5f5f5"><a href="#">edit</a> | 
    <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=web&cmd=cat_list&action=delete&id=<?=$DB->mbm_result($r_web_cats,$i,"id")?>cat_id=<?=$_GET['cat_id']?>')">delete</a></td>
  </tr>
<?
}
?>
</table>