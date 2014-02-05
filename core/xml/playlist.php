<?
	if((int)($_SESSION['user_id'])) { $userID = $_SESSION['user_id'];}
	if(isset($_POST['user_id'])){ $userID = $_POST['user_id'];}
	if(isset($_GET['user_id'])){ $userID = $_GET['user_id'];}
	if(!isset($_GET['user_id']) && !isset($_POST['user_id']) && !isset($_SESSION['user_id'])) { $userID=0; }
	if($_GET['private'] == 1){ $userID=$_SESSION['user_id']; }
	
	if(isset($_POST['playlist_id'])){ $playlist_id = $_POST['playlist_id'];}
	if(isset($_GET['playlist_id'])){ $playlist_id = $_GET['playlist_id'];}
	if(!isset($_GET['playlist_id']) && !isset($_POST['playlist_id'])) { $playlist_id=0; }
	
	switch($_GET['type']){
		case 'addToPlaylist':
			if($_SESSION['lev']>0){
				$data['user_id'] = $_SESSION['user_id'];
				$data['video_url'] = base64_decode($_POST['video_url']);
				$data['image_url'] = base64_decode($_POST['image_url']);
				$data['playlist_id'] = $_POST['playlist_id'];
				$data['title'] = $_POST['title'];
				$data['comment'] = $_POST['comment'];
				$data['date_added'] = mbmTime();
				
				if(mbmCheckVideoPlaylistFileExists($data['video_url'],$_SESSION['user_id'],$data['playlist_id']) == 0){
					if($DB2->mbm_insert_row($data,"video_playlists_files") == 1){
						$txt .= $lang["main"]["added_to_video_playlist"];
					}else{
						$txt .= $lang["main"]["not_added_to_video_playlist"];
					}
				}else{
					$txt .= $lang["main"]["already_exists_in_video_playlist"];
				}
			}else{
				$txt .= $lang["main"]["low_level_add_to_video_playlist"];
			}
		break;
		case 'createPlaylist':
			if($_SESSION['lev']>0){
				$data['user_id'] = $_SESSION['user_id'];
				$data['name'] = $_POST['name'];
				$data['st'] = 1;
				$data['comment'] = '';
				$data['date_added'] = mbmTime();
				$DB2->mbm_insert_row($data,"video_playlists");
			}else{
				$txt .= $lang["main"]["low_level_add_to_video_playlist"];
			}
		break;
		case 'get_playlistOptions':
			if($_SESSION['lev']>0){
				$q_playlist = "SELECT * FROM ".$DB2->prefix."video_playlists WHERE user_id='".$_SESSION['user_id']."' ORDER BY name";
				$r_playlist = $DB2->mbm_query($q_playlist);
				
				$playlist_options = '';	
				$playlist_options .= '<option value="0">'.$lang["main"]["default_video_playlist"].'</option>';
				
				for($i=0;$i<$DB2->mbm_num_rows($r_playlist);$i++){
					$playlist_options .= '<option value="'.$DB2->mbm_result($r_playlist,$i,"id").'" ';
					if($_POST['created'] == $DB2->mbm_result($r_playlist,$i,"name")){
						$playlist_options .= 'selected ';
					}
					$playlist_options .= '>'.$DB2->mbm_result($r_playlist,$i,"name").'</option>';
				}
				$playlist_options .= '<option value="new">'.$lang["main"]["create_video_playlist"].'</option>';
				$txt .= '<select id="videoPlaylistOption" name="videoPlaylistOption" onchange="mbmPlaylistAction(this.value)">'.$playlist_options.'</select>';
				$txt .= '<div id="addToPlaylist" style="cursor:pointer;" '
						.'onclick="mbmAddToPlaylist(document.getElementById(\'videoPlaylistOption\').value)" '
						.'>'.$lang["main"]["add_video_to_playlist"].'</div>';
			}
		break;
		case 'listPlaylists':
			if(isset($_POST['user_id'])){ $userID = $_POST['user_id'];}
			if(isset($_GET['user_id'])){ $userID = $_GET['user_id'];}
			if(!isset($_GET['user_id']) && !isset($_POST['user_id']) && !isset($_SESSION['user_id'])) { $userID=0; }
			if($_GET['private'] == 1){ $userID=$_SESSION['user_id']; }
			$txt .=  mbmVideoPlaylistsXML(array(
										   'user_id'=>$userID,
										   'order_by'=>'name',
										   'asc'=>'ASC',
										   'limit'=>30
										   ));
		break;
		case 'getVideosForPlaylistPlayer': //hereglegchdiin playlist iig gargana
			
			$q_playlist_videos = "SELECT * FROM ".$DB2->prefix."video_playlists_files WHERE playlist_id='".$playlist_id."' AND user_id='".$userID."' ORDER BY title";
			$r_playlist_videos = $DB2->mbm_query($q_playlist_videos);
			
			$txt .= '<table width="100%" border="0" cellspacing="2" cellpadding="3" style="border:1px solid #DDD;margin-top:12px;">
					  <tr class="bold">
						<td width="30" height="25" align="center" bgcolor="#DDDDDD">#</td>
						<td bgcolor="#DDDDDD"> -</td>
						<td width="120" align="center" bgcolor="#DDDDDD">Actions</td>
					  </tr>
					';
			for($i=0;$i<$DB2->mbm_num_rows($r_playlist_videos);$i++){
			$txt .= '<tr id="video'.$DB2->mbm_result($r_playlist_videos,$i,"id").'">
						<td align="center"><strong>'.($i+1).'.</strong></td>
						<td>'.$DB2->mbm_result($r_playlist_videos,$i,"title").'</td>
						<td align="center">
							<span style="cursor:pointer; padding:3px;" onClick="mbmPlayVideoByURL(document.getElementById(\'videoPlaylistPlayerPL\'),\''.$DB2->mbm_result($r_playlist_videos,$i,"video_url").'\')">Play</span>
							<span style="cursor:pointer; padding:3px;"><img src="'.DOMAIN.DIR.'mbm_admin/images/icons/status_0.png" border="0" onClick="mbmRemoveFromPlaylist('.$DB2->mbm_result($r_playlist_videos,$i,"id").')" /></span>
						</td>
					  </tr>';
			}
			$txt .= '';
			$txt .= '';
			$txt .= '';
			$txt .= '</table>';
		break;
		case 'removeFromPlaylist':
			if($DB2->mbm_get_field($_POST['id'],'id','user_id','video_playlists_files') == $_SESSION['user_id']){
				$DB2->mbm_query("DELETE FROM ".$DB2->prefix."video_playlists_files WHERE id='".(int)($_POST['id'])."' LIMIT 1");
			}else{
				$txt .= '<span class="red">not your file </span>';
			}
		break;
		case 'xml': //odoogoor ajillahgui bna
			if((int)($playlist_id) > 0 ){
				$playlist_name = $DB2->mbm_get_field($playlist_id,'id','title','video_playlists');
			}
			$q_playlist_videos = "SELECT * FROM ".$DB2->prefix."video_playlists_files WHERE playlist_id='".$playlist_id."' AND user_id='".$userID."' ORDER BY title";
			$r_playlist_videos = $DB2->mbm_query($q_playlist_videos);
			//$txt .= '<qqw><![CDATA['.$q_playlist_videos.']]></qqw>';
			//$txt .= '<qTotal><![CDATA['.$DB2->mbm_num_rows($r_playlist_videos).']]></qTotal>';
			$txt .= '
						<title>'.$playlist_name.'</title>
						<tracklist>';
						for($i=0;$i<$DB2->mbm_num_rows($r_playlist_videos);$i++){
						
							$txt .= '<track>
										<title>'.$DB2->mbm_result($r_playlist_videos,$i,"title").'</title>
										<creator>'.$DB2->mbm_get_field($DB2->mbm_result($r_playlist_videos,$i,"user_id"),'id','username','users').'</creator>
										<annotation>
											'.$DB2->mbm_result($r_playlist_videos,$i,"comment").'
										</annotation>
										<location>'
										.$DB2->mbm_result($r_playlist_videos,$i,"video_url")
										.'</location>
									</track>';
						}
				$txt .=	'</tracklist>
					';
		break;
	}
?>