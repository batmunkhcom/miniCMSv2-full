<?
function mbmForumList($forum_id=0){
	global $DB,$DB2,$lang;
	
	$q = "SELECT * FROM ".PREFIX."forums WHERE forum_id='";
	if($DB->mbm_check_field('id',$forum_id,'forums')==0){
		$q .= "0";
	}else{
		$q .= $forum_id;
	}
	$q .= "' AND st=1 AND lev<='".$_SESSION['lev']."' ";
	$q .= "ORDER BY announcement,sticky desc,pos";
	
	$r = $DB->mbm_query($q);
	
	$buf = '';
	
	if($forum_id!=0){
		$buf .= '<div class="forumUpperForumTitle">';
		$buf .= $DB->mbm_get_field($forum_id,'id','name','forums');
		$buf .= '</div>';
	}
	$buf .= '<table class="forumListTable" border="1" width="100%" cellspacing="0" cellpadding="5">';
		if($forum_id!=0){
			$buf .= '<tr class="forumListHeader">';
				$buf .= '<td width="30">';
				$buf .= '</td>';
				$buf .= '<td>';
					$buf .= $lang["forum"]["forum_name"];
				$buf .= '</td>';
				$buf .= '<td width="75" align="center">'.$lang["forum"]["subforums"];
				$buf .= '</td>';
				$buf .= '<td width="75" align="center">'.$lang["forum"]["topics"];
				$buf .= '</td>';
				$buf .= '<td width="20%">'.$lang["forum"]["last_post"];
				$buf .= '</td>';
			$buf .= '</tr>';
		}
		if((START+PER_PAGE_FORUM  ) > $DB->mbm_num_rows($r)){
			$end= $DB->mbm_num_rows($r);
		}else{
			$end= START+PER_PAGE_FORUM  ; 
		}
		for($i=START;$i<$end;$i++){
			if($forum_id==0){
					$buf .= mbmForumList($DB->mbm_result($r,$i,"id"));
			}else{
				$buf .= '<tr >';
					$buf .= '<td class="forumIcon">';
						$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/icon_forum.gif" />';
					$buf .= '</td>';
					$buf .= '<td class="forumListCel2">';
						$buf .= '<div id="forumListTitle">';
						$buf .= '<a href="index.php?module=forum&amp;cmd=forums&forum_id='.$DB->mbm_result($r,$i,"id").'" >';
							$buf .= $DB->mbm_result($r,$i,"name");
						$buf .= '</a>';
						$buf .= '</div>';
						$buf .= $DB->mbm_result($r,$i,"comment");
					$buf .= '</td>';
					$buf .= '<td align="center" class="forumListCel3">';
						$buf .= $DB->mbm_result($r,$i,"total_forums");
					$buf .= '</td>';
					$buf .= '<td align="center" class="forumListCel4">';
						$buf .= $DB->mbm_result($r,$i,"total_topics");
					$buf .= '</td>';
					$buf .= '<td class="forumListCel5">';
							$q_last_content = "SELECT * FROM ".PREFIX."forum_contents WHERE id='".$DB->mbm_result($r,$i,"last_content_id")."'";
							$r_last_content = $DB->mbm_query($q_last_content);
							if($DB->mbm_num_rows($r_last_content)==1){
								$buf .= '<a href="index.php?module=forum&cmd=content&id='.$DB->mbm_result($r_last_content,0,'id').'&forum_id='.$DB->mbm_result($r_last_content,0,'forum_id').'">';
									$buf .= $DB->mbm_result($r_last_content,0,'title').'<br />';
								$buf .= '</a>';
								$buf .= $DB2->mbm_get_field($DB->mbm_result($r_last_content,0,'user_id'),'id','username','users');
								$buf .= '<br />';
								$buf .= date("Y/m/d",$DB->mbm_result($r_last_content,0,'date_added'));
							}else{
								$buf .= '<a href="#">';
									$buf .= $DB2->mbm_get_field($DB->mbm_result($r,$i,'user_id'),'id','username','users');
								$buf .= '</a>';
								$buf .= '<br />';
								$buf .= date("Y/m/d",$DB->mbm_result($r,$i,'date_added'));
							}
					$buf .= '</td>';
				$buf .= '</tr>';
			}
		}
	$buf .= '</table>';
	if($DB->mbm_get_field($forum_id,'id','sub','forums')!=0){ //forum iin home deer hevlehgui buguud zuvhun daraah forumuuudiing list deer l hevelne
		$buf .= mbmNextPrev('index.php?module=forum&cmd=forums&amp;forum_id='.$forum_id,$DB->mbm_num_rows($r),START,PER_PAGE_FORUM);
		$buf .= '<div class="forumTopicTitle">'.$lang["forum"]["topics"].'</div>';
		$buf .= mbmForumContentsList($forum_id,'date_lastupdated', 'desc');
	}
	return $buf;
}
function mbmForumTotalContentUpdate($forum_id=0,$last_content_id=0,$update_topic=0){
	global $DB;
	if($forum_id!=0){
		$q = "UPDATE ".PREFIX."forums SET total_contents=total_contents+1,last_content_id='".$last_content_id."' ";
		if($update_topic==1){
			$q .= ',total_topics=total_topics+1 ';
		}
		$q .= "WHERE id='".$forum_id."'";
		$DB->mbm_query($q);
		mbmForumTotalContentUpdate($DB->mbm_get_field($forum_id,'id','forum_id','forums'),$last_content_id,$update_topic);
	}
	return true;
}
?>