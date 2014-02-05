<script language="javascript">
mbmSetContentTitle("<?=$lang['photogallery']['categories']?>");
mbmSetPageTitle('<?=$lang['photogallery']['categories']?>');
show_sub('menu15');

</script>
<?
if(isset($_GET['action'])){
	switch($_GET['action']){
		case 'st':
			$r_action = $DB->mbm_query("UPDATE ".PREFIX."galleries SET st='".$_GET['st']."' WHERE id='".$_GET['id']."'");
			if($r_action == 1){
				$result_txt = 'Stats updated';
			}else{
				$result_txt = 'status update process failed.';
			}
		break;
		case 'delete':
			$r_action = $DB->mbm_query("DELETE FROM ".PREFIX."galleries WHERE id='".$_GET['id']."'");
			if($r_action == 1){
				$result_txt = 'delete command processed.';
			}else{
				$result_txt = 'delete command failed.';
			}
		break;
		case 'private':
			$r_action = $DB->mbm_query("UPDATE ".PREFIX."galleries SET private='".$_GET['private']."' WHERE id='".$_GET['id']."'");
			if($r_action == 1){
				$result_txt = 'private has been set.';
			}else{
				$result_txt = 'private has not been set.';
			}
		break;
		case 'user_upload':
			$r_action = $DB->mbm_query("UPDATE ".PREFIX."galleries SET user_upload='".$_GET['user_upload']."' WHERE id='".$_GET['id']."'");
			if($r_action == 1){
				$result_txt = 'user_upload permission has been set';
			}else{
				$result_txt = 'user_upload permission has not been set';
			}
		break;
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td align="center" width="30">#</td>
    <td>name</td>
    <td width="75">username</td>
    <td width="100" align="center">secret key</td>
    <td width="50" align="center">st</td>
    <td width="50" align="center">private</td>
    <td width="50" align="center">user_upload</td>
    <td width="75" align="center">date_added</td>
    <td width="75" align="center">date_lastupdated</td>
    <td width="100">Actions</td>
  </tr>
  <?
  $q_photogalleries = "SELECT * FROM ".PREFIX."galleries ORDER BY id DESC";
  $r_photogalleries = $DB->mbm_query($q_photogalleries);
	if((START+PER_PAGE) > $DB->mbm_num_rows($r_photogalleries)){
	$end= $DB->mbm_num_rows($r_photogalleries);
	}else{
	$end= START+PER_PAGE; 
	}
	for($i=START;$i<$end;$i++){
	echo '
	  <tr>
		<td align="center" width="30"><strong>'.($i+1).'.</strong></td>
		<td>'.$DB->mbm_result($r_photogalleries,$i,"name")
		.'<br />['.$DB->mbm_result($r_photogalleries,$i,"comment").']'
		.'</td>
		<td>'.$DB2->mbm_get_field($DB->mbm_result($r_photogalleries,$i,"user_id"),'id','username','users').'</td>
		<td align="center">'.$DB->mbm_result($r_photogalleries,$i,"secret_key").'</td>
		<td align="center"><a href="index.php?module=photogallery&cmd=cats&action=st&st='
		.(($DB->mbm_result($r_photogalleries,$i,"st")+1)%2).'&id='.$DB->mbm_result($r_photogalleries,$i,"id").'&start='.START.'">
		<img src="images/icons/status_'.$DB->mbm_result($r_photogalleries,$i,"st").'.png" border="0" />
		</a></td>
		<td align="center"><a href="index.php?module=photogallery&cmd=cats&action=private&private='
		.(($DB->mbm_result($r_photogalleries,$i,"private")+1)%2).'&id='.$DB->mbm_result($r_photogalleries,$i,"id").'&start='.START.'">
		<img src="images/icons/status_'.$DB->mbm_result($r_photogalleries,$i,"private").'.png" border="0" />
		</a></td>
		<td align="center"><a href="index.php?module=photogallery&cmd=cats&action=user_upload&user_upload='
		.(($DB->mbm_result($r_photogalleries,$i,"user_upload")+1)%2).'&id='.$DB->mbm_result($r_photogalleries,$i,"id").'&start='.START.'">
		<img src="images/icons/status_'.$DB->mbm_result($r_photogalleries,$i,"user_upload").'.png" border="0" />
		</a></td>
		<td align="center">'.date("Y/m/d",$DB->mbm_result($r_photogalleries,$i,"date_added")).'</td>
		<td align="center">'.date("Y/m/d",$DB->mbm_result($r_photogalleries,$i,"date_lastupdated"))
			 .'<br />['.$DB->mbm_result($r_photogalleries,$i,"total_updated").']</td>
		<td align="center"><a href="#">edit</a> | 
		<a href="#">delete</a></td>
	  </tr>';
	}
  ?>
</table>