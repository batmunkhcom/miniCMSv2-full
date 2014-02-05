<?
if($mBm!=1){
	echo '<div id="query_result">direct access not allowed</div>';
}elseif($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==0){
	echo '<div id="query_result">Please login first.</div>';
}else{
	echo '<h2>'.$lang["menu"]["content_list"].'</h2>';
	echo '<div align="center" id="contentTitle">
	<a href="index.php?module=menu&cmd=content_list">'.$lang["menu"]["all_content_list"].'</a> | 
	<a href="index.php?module=menu&cmd=content_list&type=normal">'.$lang["menu"]["normal_content_list"].'</a> | 
	<a href="index.php?module=menu&cmd=content_list&type=is_photo">'.$lang["menu"]["photo_content_list"].'</a> | 
	<a href="index.php?module=menu&cmd=content_list&type=is_video">'.$lang["menu"]["video_content_list"].'</a></div>';
	
	switch($_GET['action']){
		case 'delete':
			$q_delete_user_content[] = "DELETE FROM ".PREFIX."menu_photos WHERE content_id='".$_GET['id']."' AND user_id='".$_SESSION['user_id']."'";
			$q_delete_user_content[] = "DELETE FROM ".PREFIX."menu_videos WHERE content_id='".$_GET['id']."' AND user_id='".$_SESSION['user_id']."'";
			$q_delete_user_content[] = "DELETE FROM ".PREFIX."menu_contents WHERE id='".$_GET['id']."' AND user_id='".$_SESSION['user_id']."'";
			foreach($q_delete_user_content as $k=>$v){
				$DB->mbm_query($v);
			}
			$result_txt = $lang["menu"]["command_delete_processed"];
			echo '<div id="query_result">'.$result_txt.'</div>';
		break;
	}
	
	$q_user_contents = "SELECT * FROM ".PREFIX."menu_contents WHERE user_id='".$_SESSION['user_id']."' ";
	if($_GET['type']=='is_video' || $_GET['type']=='is_photo' ){
		$q_user_contents .= "AND ".$_GET['type']."=1 ";
	}elseif($_GET['type']=='normal' ){
		$q_user_contents .= "AND is_video=0 AND is_photo=0 ";
	}
	$q_user_contents .= "ORDER BY id DESC";
	$r_user_contents = $DB->mbm_query($q_user_contents);
	
	echo mbmNextPrev('index.php?module=menu&cmd=content_list&type='.$_GET['type'],$DB->mbm_num_rows($r_user_contents),START,PER_PAGE);
	
	echo '<table cellspacing="2" cellpadding="3" border="0" width="100%">';
		if((START+PER_PAGE) > $DB->mbm_num_rows($r_user_contents)){
			$end= $DB->mbm_num_rows($r_user_contents);
		}else{
			$end= START+PER_PAGE; 
		}
			echo '<tr class="tblHeader">';
				echo '<td width="75" align="center">'.$lang["menu"]["content_type"].'</td>';
				echo '<td width="75" align="center">'.$lang["menu"]["content_hits"].'</td>';
				echo '<td width="30" align="center">'.$lang["menu"]["content_level"].'</td>';
				echo '<td width="30" align="center">'.$lang["menu"]["content_status"].'</td>';
				echo '<td width="75" align="center">'.$lang["menu"]["content_date_added"].'</td>';
				echo '<td width="75" align="center">'.$lang["menu"]["content_date_lastupdated"].'</td>';
				echo '<td width="20" align="center">'.$lang["menu"]["content_total_updated"].'</td>';
				echo '<td width="100" align="center">'.$lang["menu"]["content_actions"].'</td>';
			echo '</tr>';
		$bgcolor_cell = array(0=>'#f9f9f9',1=>'#f5f5f5');
		for($i=START;$i<$end;$i++){
			echo '<tr bgcolor="'.$bgcolor_cell[($i%2)].'">';
				echo '<td colspan="10"><strong>'.$lang["menu"]["content"].' #'.($i+1).'.</strong><br /> ';
					echo $DB->mbm_result($r_user_contents,$i,"title").'<br />';
					echo '/'.mbmReturnMenuNames($DB->mbm_result($r_user_contents,$i,"menu_id")).'/';
				echo '</td>';
			echo '</tr>';
			echo '<tr bgcolor="'.$bgcolor_cell[($i%2)].'">';
				echo '<td align="center">';
					if($DB->mbm_result($r_user_contents,$i,"is_video")==1){
						$content_type = 'V ';
						if(mbmCheckMenusPermission($_SESSION['user_id'],'read',$DB->mbm_result($r_user_contents,$i,"menu_id"))==1){
							$content_type .= '<a href="index.php?module=menu&amp;cmd=content_videos&amp;content_id='
											.$DB->mbm_result($r_user_contents,$i,"id").'" title="view video">';
							$content_type .= '(';
							$content_type .= $DB->mbm_result($DB->mbm_query("SELECT COUNT(*) FROM ".PREFIX."menu_videos WHERE content_id='"
												.$DB->mbm_result($r_user_contents,$i,"id")."'"),0);
							$content_type .= ') &raquo;</a>';
						}					
					}elseif($DB->mbm_result($r_user_contents,$i,"is_photo")==1){
						$content_type = 'PH ';
						if(mbmCheckMenusPermission($_SESSION['user_id'],'read',$DB->mbm_result($r_user_contents,$i,"menu_id"))==1){
							$content_type .= '<a href="index.php?module=menu&amp;cmd=content_photos&amp;content_id='
											.$DB->mbm_result($r_user_contents,$i,"id").'" title="'.$lang['menu']['view_photo_files'].'">';
							$content_type .= '(';
							$content_type .=  $DB->mbm_result($DB->mbm_query("SELECT COUNT(*) FROM ".PREFIX."menu_photos WHERE content_id='"
												.$DB->mbm_result($r_user_contents,$i,"id")."'"),0);
							$content_type .= ') &raquo;</a>';
						}
					}else{
						$content_type = 'N &raquo;';
					}
					echo $content_type;
				echo '</td>';
				echo '<td align="center">'.$DB->mbm_result($r_user_contents,$i,"hits").'</td>';
				echo '<td align="center">'.$DB->mbm_result($r_user_contents,$i,"lev").'</td>';
				echo '<td align="center"><img src="'.DOMAIN.DIR.'mbm_admin/images/icons/status_'
					.$DB->mbm_result($r_user_contents,$i,"st").'.png" border="0" /></td>';
				echo '<td align="center">'.date("Y/m/d",$DB->mbm_result($r_user_contents,$i,"date_added")).'</td>';
				echo '<td align="center">'.date("Y/m/d",$DB->mbm_result($r_user_contents,$i,"date_lastupdated")).'</td>';
				echo '<td align="center">'.$DB->mbm_result($r_user_contents,$i,"total_updated").'</td>';
				echo '<td align="center">';
				
				if(mbmCheckMenusPermission($_SESSION['user_id'],'edit',$DB->mbm_result($r_user_contents,$i,"menu_id"))==1){
					echo '<a href="#" >'
					.$lang['main']['edit'].'</a>';
				}else{
					echo $lang['main']['edit'];
				}
				echo ' | ';
				if(mbmCheckMenusPermission($_SESSION['user_id'],'delete',$DB->mbm_result($r_user_contents,$i,"menu_id"))==1){
					echo '<a href="#" onclick="confirmSubmit(\''.$lang['confirm']['delete'].'\',\'index.php?module=menu&cmd=content_list&content_id='
					.$_GET['content_id'].'&id='.$DB->mbm_result($r_user_contents,$i,"id").'&action=delete\')">'
					.$lang['main']['delete'].'</a>';
				}else{
					echo $lang['main']['delete'];
				}
				echo '</td>';
			echo '</tr>';
			
		}
	echo '</table>';
}
?>