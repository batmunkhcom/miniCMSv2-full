<script language="javascript">
mbmSetContentTitle("<?=$lang["web"]["categories"]?>");
mbmSetPageTitle('<?=$lang["web"]["categories"]?>');
show_sub('menu17');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_GET['action']) && $DB2->mbm_check_field('id',$_GET['id'],'zar_cats')==1){
	switch($_GET['action']){
		case 'st':
			if($DB2->mbm_query("UPDATE ".$DB2->prefix."zar_cats SET total_updated=total_updated+1,st='".$_GET['st']."' WHERE id='".$_GET['id']."'")==1){
				$result_txt = 'status updated.';
			}else{
				$result_txt = 'status update failed.';
			}
		break;
		case 'lev':
		break;
		case 'delete':
			if(mbmZarDeleteCats($_GET['id'])){
				$result_txt = 'Deleted.';
			}else{
				$result_txt = 'Delete failed.';
			}			
		break;
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
$q_zar_cats = "SELECT * FROM ".$DB2->prefix."zar_cats WHERE id!=0 ";
if($DB2->mbm_check_field('cat_id',$_GET['cat_id'],'zar_cats')==1){
	$q_zar_cats .= "AND cat_id='".$_GET['cat_id']."' ";
}
$q_zar_cats .= "ORDER BY pos";

$r_zar_cats = $DB2->mbm_query($q_zar_cats);
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
    <td width="150" align="center" >action</td>
  </tr>
<?
	for($i=0;$i<$DB2->mbm_num_rows($r_zar_cats);$i++){
?>  
  <tr>
    <td bgcolor="#f5f5f5" align="center"><strong><?=($i+1)?>.</strong></td>
    <td bgcolor="#f5f5f5"><?
						echo '<strong>';
						if($DB2->mbm_check_field('cat_id',$DB2->mbm_result($r_zar_cats,$i,"id"),"zar_cats")==1){
							echo '<a href="index.php?module=zar&cmd=cat_list&cat_id='
								.$DB2->mbm_result($r_zar_cats,$i,"id").'" title="click to view sub categories">'
								.$DB2->mbm_result($r_zar_cats,$i,"name").'</a>';
						}else{
							echo $DB2->mbm_result($r_zar_cats,$i,"name");
						}
						echo ''
							.'</strong> ['.$DB2->mbm_result($r_zar_cats,$i,"total_links")
							.']<br />'
							.$DB2->mbm_result($r_zar_cats,$i,"comment").' [id: '.$DB2->mbm_result($r_zar_cats,$i,"id").']'?></td>
    <td bgcolor="#f5f5f5"><?=$DB2->mbm_get_field($DB2->mbm_result($r_zar_cats,$i,"user_id"),'id','username','users')?></td>
    <td align="center" bgcolor="#f5f5f5"><a href="index.php?module=zar&cmd=cat_list&id=<?=$DB2->mbm_result($r_zar_cats,$i,"id")?>&action=st&st=<?=(($DB2->mbm_result($r_zar_cats,$i,"st")+1)%2)?>&id=<?=$DB2->mbm_result($r_zar_cats,$i,"id")?>">
    <img src="images/icons/status_<?=$DB2->mbm_result($r_zar_cats,$i,"st")?>.png" border="0" />
    </a></td>
    <td align="center" bgcolor="#f5f5f5"><?=$DB2->mbm_result($r_zar_cats,$i,"lev")?></td>
    <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB2->mbm_result($r_zar_cats,$i,"date_added"))?></td>
    <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB2->mbm_result($r_zar_cats,$i,"date_lastupdated"))
											.'<br />'.$DB2->mbm_result($r_zar_cats,$i,"total_updated")?> times</td>
    <td align="center" bgcolor="#f5f5f5"><?=number_format($DB2->mbm_result($r_zar_cats,$i,"hits"))?></td>
    <td align="center" bgcolor="#f5f5f5">
    <a href="index.php?module=zar&amp;cmd=cat_edit&amp;id=<?=$DB2->mbm_result($r_zar_cats,$i,"id")?>"><img src="images/<?=$_SESSION['ln']?>/button_edit.png" border="0" alt="<?= $lang['main']['edit']?>" hspace="3" /></a> 
    <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=zar&cmd=cat_list&action=delete&id=<?=$DB2->mbm_result($r_zar_cats,$i,"id")?>&cat_id=<?=$_GET['cat_id']?>')"><img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" /></a></td>
  </tr>
<?
}
?>
</table>