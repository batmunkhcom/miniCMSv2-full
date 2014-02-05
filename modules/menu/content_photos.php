<?		
if($mBm!=1){
	echo '<div id="query_result">direct access not allowed</div>';
}elseif($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==0){
	echo '<div id="query_result">Please login first.</div>';
}elseif($DB->mbm_check_field('id',$_GET['content_id'],'menu_contents')==0){
	echo '<div id="query_result">No such content photos found.</div>';
}else{
echo '<h2>'.$DB->mbm_get_field($_GET['content_id'],'id','title','menu_contents').'</h2>';
echo '<div align="center" id="contentTitle">
	<a href="index.php?module=menu&cmd=content_list">'.$lang["menu"]["all_content_list"].'</a> | 
	<a href="index.php?module=menu&cmd=content_list&type=normal">'.$lang["menu"]["normal_content_list"].'</a> | 
	<a href="index.php?module=menu&cmd=content_list&type=is_photo">'.$lang["menu"]["photo_content_list"].'</a> | 
	<a href="index.php?module=menu&cmd=content_list&type=is_video">'.$lang["menu"]["video_content_list"].'</a></div>';
  switch($_GET['action']){
  	case 'delete':
		
		$r_delete_process = $DB->mbm_query("DELETE FROM ".PREFIX."menu_photos WHERE id='".$_GET['id']."' AND user_id='".$_SESSION['user_id']."' LIMIT 1");
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
?>
<table width="100%" border="0" cellspacing="2" cellpadding="3">
  
  <?
  $q_content_photos = "SELECT * FROM ".PREFIX."menu_photos WHERE content_id='".$_GET['content_id']."' AND user_id='".$_SESSION['user_id']."' ORDER BY id";
  $r_content_photos = $DB->mbm_query($q_content_photos);
  for($i=0;$i<$DB->mbm_num_rows($r_content_photos);$i++){
  	echo '<tr><td colspan="2" style="
									color:#333333; 
									padding:3px; 
									font-weight:bold;
									background-color:#f5f5f5;">';
	echo ($i+1).'. '.$DB->mbm_result($r_content_photos,$i,"title").'</td></tr>';
	echo '<tr><td align="center" style="margin-bottom:12px;">';
		echo '<img src="img.php?type='.$DB->mbm_result($r_content_photos,$i,"filetype").'&f='.base64_encode($DB->mbm_result($r_content_photos,$i,"url")).'&w=';
		if($DB->mbm_result($r_content_photos,$i,"width")<300){
			echo $DB->mbm_result($r_content_photos,$i,"width");
		}else{
			echo 300;
		}
		echo '"alt="'.$DB->mbm_result($r_content_photos,$i,"url").'" />';
	echo '</td>';
	echo '<td width="300" valign="top">';
		echo '<table width="100%" border="1" cellspacing="2" cellpadding="3" style="border-collapse:collapse;">';
				echo	'<tr>
				<td>'.$lang['menu']['filename'].'</td><td bgcolor="#e2e2e2">'.basename($DB->mbm_result($r_content_photos,$i,"url")).'</td></tr><tr>
				<td>'.$lang['menu']['filetype'].'</td><td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"filetype").'</td></tr><tr>
				<td>'.$lang['menu']['filesize'].'</td><td align="center" bgcolor="#e2e2e2">'.ceil($DB->mbm_result($r_content_photos,$i,"filesize")/1024).' kb</td></tr><tr>
				<td>'.$lang['menu']['filehits'].'</td><td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"hits").'</td></tr><tr>
				<td>'.$lang['menu']['ratings'].'</td><td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"ratings").'</td></tr><tr>
				<td>'.$lang['menu']['file_downloaded'].'</td><td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"downloaded").'</td></tr><tr>
				<td>'.$lang['menu']['ip'].'</td><td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"ip").'</td></tr><tr>
				<td>'.$lang['menu']['file_date_added'].'</td><td align="center" bgcolor="#e2e2e2">'.date("Y/m/d",$DB->mbm_result($r_content_photos,$i,"date_added")).'</td></tr><tr>
				<td>'.$lang['menu']['file_total_updated'].'</td><td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"total_updated").'</td></tr><tr>
				<td>'.$lang['menu']['file_date_lastupdated'].'</td><td align="center" bgcolor="#e2e2e2">'.date("Y/m/d",$DB->mbm_result($r_content_photos,$i,"date_lastupdated")).'</td></tr><tr>
				<td>'.$lang['menu']['actions'].'</td><td align="center" bgcolor="#e2e2e2">';
				
				$menu_id_tmp = $DB->mbm_get_field($DB->mbm_result($r_content_photos,$i,"content_id"),'id','menu_id','menu_contents');
				
				if(mbmCheckMenuPermission($_SESSION['user_id'],"delete",$menu_id_tmp)==1){
					echo '<a href="#" onclick="confirmSubmit(\''.$lang['confirm']['delete'].'\',\'index.php?module=menu&cmd=content_videos&content_id='
						.$_GET['content_id'].'&id='.$DB->mbm_result($r_content_photos,$i,"id").'&action=delete\')">'
						.$lang['main']['delete'].'</a>';
				}else{
					echo $lang['main']['delete'];
				}
				echo '</td>
				  </tr>';
		echo '</table><br /><br /><br />';
		echo $DB->mbm_result($r_content_photos,$i,"comment");
	echo '</td>';
	echo '</tr>';
  }
  ?>
</table><?
}
?>
