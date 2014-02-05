<?

function mbmShowContentVideos($content_id=0){
	global $DB;
	
	$q_videos = "SELECT * FROM ".PREFIX."menu_videos WHERE content_id='".$content_id."' ORDER BY id ";
	$r_videos = $DB->mbm_query($q_videos);

	for($i=0;$i<$DB->mbm_num_rows($r_videos);$i++){
		$buf .= mbmFlvPlayer(array(
								'height'=>FLV_PLAYER_HEIGHT,
								'width'=>FLV_PLAYER_WIDTH,
								'swf_player'=>FLV_PLAYER_URL,
								'title'=>FLV_PLAYER_TITLE,
								'titlesize'=>FLV_PLAYER_TITLESIZE,
								'flv_url'=>$DB->mbm_result($r_videos,$i,"url"),
								'name'=>FLV_PLAYER_NAME,
								'autoplay'=>FLV_PLAYER_AUTOPLAY,
								'showvolume'=>FLV_PLAYER_SHOWVOLUMEBUTTON,
								'showfullscreen'=>FLV_PLAYER_SHOWFULLSCREEN,
								'showstop'=>FLV_PLAYER_SHOWSTOPBUTTON,
								'showtime'=>FLV_PLAYER_SHOWTIME,
								'bgcolor'=>FLV_PLAYER_BGCOLOR,
								'buttoncolor'=>FLV_PLAYER_BUTTONCOLOR,
								'playercolor'=>FLV_PLAYER_PLAYERCOLOR,
								'bgcolor1'=>FLV_PLAYER_BGCOLOR1,
								'bgcolor2'=>FLV_PLAYER_BGCOLOR2,
								'buttonovercolor'=>FLV_PLAYER_BUTTONOVERCOLOR,
								'slidercolor1'=>FLV_PLAYER_SLIDERCOLOR1,
								'slidercolor2'=>FLV_PLAYER_SLIDERCOLOR2,
								'sliderovercolor'=>FLV_PLAYER_SLIDEROVERCOLOR,
								'loadingcolor'=>FLV_PLAYER_LOADINGCOLOR,
								'autoload'=>1,
								'showiconplay'=>0,
								'showplayer'=>'always',
								'buffer'=>5
								)
							);
		$DB->mbm_query("UPDATE ".PREFIX."menu_videos SET hits=hits+".HITS_BY.",session_time='".mbmTime()."' WHERE id='".$DB->mbm_result($r_videos,$i,"id")."'");

		$buf .= '<div class="contentTitleVideo">'.$DB->mbm_result($r_videos,$i,"title").'</div>';
		$buf .= '<div id="videoComment">';
		$buf .= $DB->mbm_result($r_videos,$i,"comment");
		$buf .= '</div>';
		if(VIDEO_INFO_SHOW=='1'){
			$buf .= mbmShowVideoInfo(array(
										'id'=>$DB->mbm_result($r_videos,$i,"id"),
										'title'=>$DB->mbm_result($r_videos,$i,"title"),
										'downloaded'=>$DB->mbm_result($r_videos,$i,"downloaded"),
										'flv_url'=>$DB->mbm_result($r_videos,$i,"url"),
										'filesize'=>$DB->mbm_result($r_videos,$i,"filesize"),
										'duration'=>$DB->mbm_result($r_videos,$i,"duration"),
										'date_added'=>$DB->mbm_result($r_videos,$i,"date_added"),
										'date_lastupdated'=>$DB->mbm_result($r_videos,$i,"date_lastupdated"),
										'total_updated'=>$DB->mbm_result($r_videos,$i,"total_updated"),
										'hits'=>$DB->mbm_result($r_videos,$i,"hits")
										)
									);
		}
	}
	return $buf;
}

function mbmShowVideoInfo($info=array()){

	global $lang;
	
	$buf ='<div id="videoInfo">';
		$buf .= '<div id="videoInfoRow1">';
		$buf .= '</div>';
		$buf .= '<div id="videoInfoRow2">';
			$buf .= '<div id="videoInfoTitle1" class="videoInfoTitle" onmouseover="mbmVideoInfoDisplay(1,4)">'.$lang["menu"]["video_share"];
			$buf .= '<div id="videoInfoContent1" class="videoInfoContent" onmouseout="mbmVideoInfoDisplay(0,4)">';
					$buf .= mbmShareThisPage(array(
												  'title'=>$info['video_title']
												 )
										   );
					$buf .= mbmAddRSSPage(array(
												'content_type'=>'video'
											   )
										 );
					$buf .= mbmSend2Friend();
					$buf .= '<div style="margin-bottom:3px; position:relative;">';
						$buf .= '<img src="'.INCLUDE_DOMAIN.'images/icons/icon_embedcode.png" border="0" onclick="mbmToggleDisplay(\'videoEmbedCode\'); document.getElementById(\'send2Friend\').style.display=\'none\';" />';
						
						// embed code start
						$info['textarea_cols'] = 45;
						$info['textarea_rows'] = 8;
						$buf .= mbmVideoEmbedCode($info);
						//embed code ends
					$buf .= '</div>';
				$buf .= '</div>';
			$buf .= '</div>';
			
			
			$buf .= '<div id="videoInfoTitle2" class="videoInfoTitle" onmouseover="mbmVideoInfoDisplay(2,4)">'.$lang["menu"]["video_save"];
				$buf .= '<div id="videoInfoContent2" class="videoInfoContent" onmouseout="mbmVideoInfoDisplay(0,4)">';
					$buf .= '<div><a href="rss.php?dl=content_video&amp;id='.$info['id'].'" target="_blank">'.$lang["menu"]["video_download"].'</a></div>';
					$buf .= '<div>
								<a href="#" onclick="mbmAddBookmark(\''
																.'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'\',
																document.title,
																\''.$lang["main"]["bookmark_success"].'\');
													 return false;">'
								.$lang["menu"]["video_favorite_it"]
								.'</a>
							 </div>';
				$buf .= '</div>';
			$buf .= '</div>';
			
			
			$buf .= '<div id="videoInfoTitle3" class="videoInfoTitle" onmouseover="mbmVideoInfoDisplay(3,4)">'.$lang["menu"]["video_info"];
				$buf .= '<div id="videoInfoContent3" class="videoInfoContent" onmouseout="mbmVideoInfoDisplay(0,4)">';
					$buf .= '<div>'.$lang["main"]["hits"].': <strong>'.$info['hits'].'</strong></div>';
					$buf .= '<div>'.$lang["main"]["date_added"].': <strong>'.date("d/m/Y H:i:s",$info['date_added']).'</strong></div>';
					$buf .= '<div>'.$lang["menu"]["filesize"].': <strong>'.mbmFileSizeMB($info['filesize']).'</strong></div>';
					$buf .= '<div>'.$lang['menu']['video_duration'].': <strong>'.mbmFLVDurationToMinute($info['duration']).'</strong></div>';
					$buf .= '<div>'.$lang["menu"]["video_downloaded"].': <strong>'.$info['downloaded'].'</strong></div>';
				$buf .= '</div>';
			$buf .= '</div>';
			
			
			$buf .= '<div id="videoInfoTitle4" class="videoInfoTitle" onmouseover="mbmVideoInfoDisplay(4,4)">'.$lang["menu"]["video_playlist"];
				$buf .= '<div id="videoInfoContent4" class="videoInfoContent" onmouseout="mbmVideoInfoDisplay(0,4)">';
					$buf .= '<div id="addToPlaylist">
								<a href="#" onclick="mbmLoadXML(\'GET\',\'xml.php?action=menu_playlist&amp;flv_url='
								.base64_encode($info['flv_url']) //videonii url. menu_videos table
								.'&amp;title='.base64_encode($info['title'])
								.'&amp;type=add&amp;playlist_id=0\',mbmAddToPlayList);return false;">'
								.$lang["menu"]["video_save_to_playlist"]
								.'</a>
							 </div>';
					$buf .= '<div id="removeFromPlaylist">
								<a href="#" onclick="mbmLoadXML(\'GET\',\'xml.php?action=menu_playlist&amp;flv_url='
								.base64_encode($info['flv_url']) //videonii url. menu_videos table
								.'&amp;title='.base64_encode($info['title'])
								.'&amp;type=remove&amp;playlist_id=0\',mbmRemoveFromPlayList);return false;">'
								.$lang["menu"]["video_remove_from_list"]
								.'</a>
							 </div>';
					$buf .= '<div>
								<a href="index.php?module=menu&amp;cmd=play_videolist">'
								.$lang["menu"]["video_play_playlist"]
								.'</a>
							 </div>';
					$buf .= '<div>
								<a href="#" onclick="alert(\'Sorry, not available yet\');return false;">'
								.$lang["menu"]["video_manage_playlist"]
								.'</a>
							 </div>';
				$buf .= '</div>';
			$buf .= '</div>';
			$buf .= '';
		$buf .= '</div>';
		$buf .= '<div id="videoInfoRow3">';
		$buf .= '</div>';
		$buf .= '<div id="videoInfoRow4">';
		$buf .= '</div>';
		$buf .= '<div id="videoInfoRow5">';
		$buf .= '</div>';
		$buf .= '<script type="text/javascript">';
		$buf .= '</script>';
		$buf .= '';
		$buf .= '';
		$buf .= '';
	$buf .= '</div>';
	
	return $buf;
}


function mbmShowVideoPlaylistButton($var = array(
												 'video_url'=>'',
												 'image_url'=>'',
												 'text'=>'Playlist',
												 'duration'=>''
												 )){
	$buf ='<div id="videoPlaylistButton" video_url="'.base64_encode($var['video_url']).'" image_url="'.base64_encode(DOMAIN.DIR.$var['image_url']).'" duration="'.$var['duration'].'">';
		$buf .= '<a href="#" onclick="return false;">'.$var['text'].'</a>';
		$buf .='<div id="videoPlaylists">';
		$buf .='</div>';
	$buf .='</div>';
	
	return $buf;
}
function mbmCheckVideoPlaylistFileExists($video_url='',$user_id=0, $playlist_id=0){
	global $DB2;
	
	$q = "SELECT COUNT(*) FROM ".$DB2->prefix."video_playlists_files WHERE user_id='".$user_id."' AND video_url='".$video_url."' AND playlist_id='".$playlist_id."'";
	$r = $DB2->mbm_query($q);
	
	if($DB2->mbm_result($r,0) == 1){
		return 1;
	}else{
		return 0;
	}
}
function mbmVideoPlaylistsXML($var = array(
										   'user_id'=>0,
										   'order_by'=>'date_added',
										   'asc'=>'DESC',
										   'limit'=>10
										   )){
	global $DB2,$lang;
	
	$q_playlists = "SELECT * FROM ".$DB2->prefix."video_playlists WHERE st=1 ";
	if($var['user_id']!=0){
		$q_playlists .= "AND user_id='".$var['user_id']."' ";
	}
	
	if(!isset($var['order_by'])){
		$var['order_by'] = 'date_added';
	}
	if(!isset($var['asc'])){
		$var['asc'] = 'DESC';
	}
	if(!isset($var['limit'])){
		$var['limit'] = 10;
	}
	$q_playlists .= "AND id IN (SELECT playlist_id FROM ".$DB2->prefix."video_playlists_files)";
	
	$q_playlists .= "ORDER BY ".$var['order_by']." ".$var['asc']." LIMIT ".$var['limit'];
	
	$r_playlists = $DB2->mbm_query($q_playlists);
	
	$buf = '';

	$buf .= '<gallery Name="'.$lang["main"]["default_video_playlist"].'">';
		$buf .= mbmVideoPlaylistsSongsXML(0,$var['user_id']);
	$buf .= '</gallery>';
	for($i=0;$i<$DB2->mbm_num_rows($r_playlists);$i++){
		
		/*
		$buf .= '<folder name="'.$DB2->mbm_result($r_playlists,$i,"name").'">'.mbmVideoPlaylistsSongsXML($DB2->mbm_result($r_playlists,$i,"id"),$var['user_id']).'
				</folder>';
		*/
		$buf .= '<gallery Name="'.$DB2->mbm_result($r_playlists,$i,"name").'">';
			$buf .= mbmVideoPlaylistsSongsXML($DB2->mbm_result($r_playlists,$i,"id"),$var['user_id']);
		$buf .= '</gallery>';
	}
	return $buf;
}
function mbmVideoPlaylistsSongsXML($playlist_id=0,$user_id=0){
	global $DB2;
	
	$q = "SELECT * FROM ".$DB2->prefix."video_playlists_files WHERE playlist_id='".$playlist_id."' ";
	if($user_id!=0){
		$q .=  "AND user_id='".$user_id."'";
		//$q .= "AND playlist_id IN (SELECT id FROM ".$DB2->prefix."video_playlists WHERE user_id='".$user_id."') ";
	}
	$q .= "ORDER BY date_added";
	$r = $DB2->mbm_query($q);
	
	$buf = '';
	
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		
		/*
		$buf .= '<video file="http://yadii.net/videos/ariunaa/ariunaa-amidral_chamd_durladag.flv" name="'.addslashes($DB2->mbm_result($r,$i,"title")).'">
					<![CDATA[
						<img src="'.DOMAIN.DIR.'img.php?type=jpg&amp;f='.base64_encode($DB2->mbm_result($r,$i,"image_url")).'&amp;w=80&amp;h=80" align="left" hspace="5" />'
						.addslashes($DB2->mbm_result($r,$i,"comment")).'
					]]>
				</video>';
		*/
			$buf .= '<video 
							Thumb="'.DOMAIN.DIR.'img.php?type=jpg&amp;f='.base64_encode($DB2->mbm_result($r,$i,"image_url")).'&amp;w=80&amp;h=80" 
							VideoClip="'.$DB2->mbm_result($r,$i,"video_url").'" 
							Title="'.$DB2->mbm_result($r,$i,"title").'" 
							Copy="';
					if($DB2->mbm_result($r,$i,"comment")!= '0'){
						$buf .= $DB2->mbm_result($r,$i,"comment");
					}else{
						$buf .= $DB2->mbm_result($r,$i,"title");
					}
			$buf .= '" />';
	}
	
	return $buf;
}
?>