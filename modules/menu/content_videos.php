<?		
if($mBm!=1){
	echo '<div id="query_result">direct access not allowed</div>';
}elseif($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==0){
	echo '<div id="query_result">Please login first.</div>';
}elseif($DB->mbm_check_field('id',$_GET['content_id'],'menu_contents')){
	echo '<div id="query_result">No such content video found.</div>';
}else{
echo '<h2>'.$DB->mbm_get_field($_GET['content_id'],'id','title','menu_contents').'</h2>';
echo '<div align="center" id="contentTitle">
	<a href="index.php?module=menu&cmd=content_list">'.$lang["menu"]["all_content_list"].'</a> | 
	<a href="index.php?module=menu&cmd=content_list&type=normal">'.$lang["menu"]["normal_content_list"].'</a> | 
	<a href="index.php?module=menu&cmd=content_list&type=is_photo">'.$lang["menu"]["photo_content_list"].'</a> | 
	<a href="index.php?module=menu&cmd=content_list&type=is_video">'.$lang["menu"]["video_content_list"].'</a></div>';
?>
<table width="100%" border="0" cellspacing="2" cellpadding="3">
  <tr class="list_header">
    <td align="center">#</td>
    <td align="center"><?=$lang['menu']['filename']?></td>
    <td width="75" align="center"><?=$lang['menu']['video_duration']?></td>
    <td width="75" align="center"><?=$lang['menu']['filesize']?></td>
    <td width="100" align="center"><?=$lang['menu']['filehits']?></td>
    <td width="50" align="center"><?=$lang['menu']['ratings']?></td>
    <td width="50" align="center"><?=$lang['menu']['file_downloaded']?></td>
    <td width="75" align="center"><?=$lang['menu']['ip']?></td>
    <td width="75" align="center"><?=$lang['menu']['file_date_added']?></td>
    <td width="75" align="center"><?=$lang['menu']['file_total_updated']?></td>
    <td width="75" align="center"><?=$lang['menu']['file_date_lastupdated']?></td>
    <td width="100" align="center"><?=$lang['menu']['actions']?></td>
  </tr>
  
  <?
  switch($_GET['action']){
  	case 'delete':
		$r_delete_process = $DB->mbm_query("DELETE FROM ".PREFIX."menu_videos WHERE id='".$_GET['id']."' AND user_id='".$_SESSION['user_id']."' LIMIT 1");
		if($r_delete_process==1){
			$result_txt = $lang["menu"]["command_delete_processed"].'.';
		}else{
			$result_txt = $lang["menu"]["command_delete_failed"].'.';
		}
		echo '<div id="query_result">'.$result_txt.'</div>';
	break;
  	case 'edit':
	break;
  }
  $q_content_videos = "SELECT * FROM ".PREFIX."menu_videos WHERE content_id='".$_GET['content_id']."' AND user_id='".$_SESSION['user_id']."' ORDER BY id";
  $r_content_videos = $DB->mbm_query($q_content_videos);
  for($i=0;$i<$DB->mbm_num_rows($r_content_videos);$i++){
	echo	'<tr '.mbmonMouse("#e2e2e2","#d2d2d2","").'>
			<td align="center" bgcolor="#e2e2e2"><strong>'.($i+1).'.</strong></td>
			<td bgcolor="#e2e2e2"><a href="'.$DB->mbm_result($r_content_videos,$i,"url").'" title="download the video">'.basename($DB->mbm_result($r_content_videos,$i,"url")).'</a></td>
			<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_videos,$i,"duration").'</td>
			<td align="center" bgcolor="#e2e2e2">'.ceil($DB->mbm_result($r_content_videos,$i,"filesize")/1024).' kb</td>
			<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_videos,$i,"hits").'</td>
			<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_videos,$i,"ratings").'</td>
			<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_videos,$i,"downloaded").'</td>
			<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_videos,$i,"ip").'</td>
			<td align="center" bgcolor="#e2e2e2">'.date("Y/m/d",$DB->mbm_result($r_content_videos,$i,"date_added")).'</td>
			<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_videos,$i,"total_updated").'</td>
			<td align="center" bgcolor="#e2e2e2">'.date("Y/m/d",$DB->mbm_result($r_content_videos,$i,"date_lastupdated")).'</td>
			<td align="center" bgcolor="#e2e2e2">';
			
		$menu_id_tmp = $DB->mbm_get_field($DB->mbm_result($r_content_videos,$i,"content_id"),'id','menu_id','menu_contents');
		
		if(mbmCheckMenuPermission($_SESSION['user_id'],"delete",$menu_id_tmp)==1){
			echo '<a href="#" onclick="confirmSubmit(\''.$lang['confirm']['delete'].'\',\'index.php?module=menu&cmd=content_videos&content_id='
				.$_GET['content_id'].'&id='.$DB->mbm_result($r_content_videos,$i,"id").'&action=delete\')">'
				.$lang['main']['delete'].'</a>';
		}else{
			echo $lang['main']['delete'];
		}
		echo '</td>
		  </tr>';
		echo '<tr><td colspan="13" align="center">';
			echo '<strong>'.$DB->mbm_result($r_content_videos,$i,"title").'</strong><br />';
			echo '<img src="';
			if(substr_count($DB->mbm_result($r_content_videos,$i,"image_url"),DOMAIN.DIR)==1){
				echo $DB->mbm_result($r_content_videos,$i,"image_url");
			}else{
				echo DOMAIN.DIR.$DB->mbm_result($r_content_videos,$i,"image_url");
			}
			echo '" 
					alt="'.$DB->mbm_result($r_content_videos,$i,"image_url").'" />';
		echo '</td></tr>';
  }
  ?>
</table>
<?
}
?>