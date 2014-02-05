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
		case 'xml': //odoogoor ajillahgui bna
			if((int)($playlist_id) > 0 ){
				$playlist_name = $DB2->mbm_get_field($playlist_id,'id','title','video_playlists');
			}
			$q_playlist_videos = "SELECT * FROM ".$DB2->prefix."video_playlists_files WHERE playlist_id='".$playlist_id."' AND user_id='".$userID."' ORDER BY title";
			$r_playlist_videos = $DB2->mbm_query($q_playlist_videos);
			for($i=0;$i<$DB2->mbm_num_rows($r_playlist_videos);$i++){
			
				$buf_rss .= '<item>
							<title>'.$DB2->mbm_result($r_playlist_videos,$i,"title").'</title>
							<link>http://www.yadii.net/</link>
							<description>'.$DB2->mbm_result($r_playlist_videos,$i,"comment").'</description>
							<media:group>
								<media:credit role="author">'.$DB2->mbm_get_field($DB2->mbm_result($r_playlist_videos,$i,"user_id"),'id','username','users').'</media:credit>
								<media:content url="'.$DB2->mbm_result($r_playlist_videos,$i,"video_url").'" type="video/x-flv" />
								<media:thumbnail url="'.$DB2->mbm_result($r_playlist_videos,$i,"image_url").'" />
							</media:group>
						</item>';
			}
		break;
	}
	echo $buf_rss;
?>