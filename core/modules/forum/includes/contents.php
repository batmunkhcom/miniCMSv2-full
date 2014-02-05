<?php

function mbmForumContentsList($forum_id=0,$order_by = 'id', $asc = 'asc'){
	global $DB,$DB2,$lang;
	
	$q = "SELECT * FROM ".PREFIX."forum_contents WHERE forum_id='".$forum_id."' AND content_id=0 ORDER BY ".$order_by." ".$asc;
	$r = $DB->mbm_query($q);
	$buf = '';
	
	$buf .= '<div class="forumUpperForumTitle">';
		$buf .= $DB->mbm_get_field($forum_id,'id','name','forums');
	$buf .= '</div>';
	
	$buf_sep = mbmForumNewTopic($forum_id);
	
	if($DB->mbm_num_rows($r)==0 && $forum_id!=0){
		$buf .= mbmError($lang["forum"]["no_such_topic"]);
	}else{
	
		$buf_sep .= mbmNextPrev('index.php?module=forum&cmd=forums&amp;forum_id='.$forum_id,$DB->mbm_num_rows($r),START,PER_PAGE_FORUM);
		
		$buf .= $buf_sep;
		$buf .= '<table class="forumListTable" border="1" width="100%" cellspacing="0" cellpadding="5">';
			$buf .= '<tr class="forumTopicListHeader">';
				$buf .= '<td>';
				$buf .= '</td>';
				$buf .= '<td>';
					$buf .= $lang["forum"]["topic"];
				$buf .= '</td>';
				$buf .= '<td width="75" align="center">'.$lang["forum"]["author"];
				$buf .= '</td>';
				$buf .= '<td width="50" align="center">'.$lang["forum"]["replies"];
				$buf .= '</td>';
				$buf .= '<td width="75" align="center">'.$lang["main"]["hits"];
				$buf .= '</td>';
				$buf .= '<td width="20%">'.$lang["forum"]["last_post"];
				$buf .= '</td>';
			$buf .= '</tr>';
		
		if((START+PER_PAGE_FORUM  ) > $DB->mbm_num_rows($r)){
			$end= $DB->mbm_num_rows($r);
		}else{
			$end= START+PER_PAGE_FORUM  ; 
		}
		for($i=START;$i<$end;$i++){
			$q_tmp_userinfo = "SELECT * FROM ".USER_DB_PREFIX."users WHERE id='".$DB->mbm_result($r,$i,"user_id")."'";
			$r_tmp_userinfo = $DB2->mbm_query($q_tmp_userinfo);
			$user_info_link = '#';
			$buf .= '<tr>';
				$buf .= '<td class="forumIcon">';
					$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/icon_topics.gif" />';
				$buf .= '</td>';
				$buf .= '<td class="forumListCel2">';
					$buf .= '<div id="forumListTitle">';
					$buf .= '<a href="index.php?module=forum&cmd=content&id='.$DB->mbm_result($r,$i,"id").'&forum_id='.$DB->mbm_result($r,$i,"forum_id").'">';
						$buf .= $DB->mbm_result($r,$i,"title");
					$buf .= '</a>';
					$buf .= '</div>';
					$buf .= '<a href="'.$user_info_link.'">';
					$buf .= $DB2->mbm_result($r_tmp_userinfo,0,"username").'</a>';
					$buf .= ' '.date("Y/m/d",$DB->mbm_result($r,$i,"date_added"));
				$buf .= '</td>';
				$buf .= '<td align="center" class="forumListCel3">';
					$buf .= '<a href="'.$user_info_link.'">';
					$buf .= $DB2->mbm_result($r_tmp_userinfo,0,"username").'</a>';
				$buf .= '</td>';
				$buf .= '<td align="center" class="forumListCel4">';
					$buf .= $DB->mbm_result($r,$i,"total_replies");
				$buf .= '</td>';
				$buf .= '<td align="center" class="forumListCel5">';
					$buf .= $DB->mbm_result($r,$i,"hits");
				$buf .= '</td>';
				$buf .= '<td width="20%" class="forumListCel6">';
					if($DB->mbm_result($r,$i,"last_content_id")==0){
						$tmp_username = $DB2->mbm_result($r_tmp_userinfo,0,"username");
						$tmp_content_id = $DB->mbm_result($r,$i,"id");
					}else{
						$tmp_username = $DB2->mbm_get_field($DB->mbm_result($r,$i,"last_content_user_id"),'id','username','users');
						$tmp_content_id = $DB->mbm_result($r,$i,"last_content_id");
					}
					$buf .= '<a href="'.$user_info_link.'">';
						$buf .= $tmp_username;
					$buf .= '</a>';
					$buf .= '<a href="index.php?module=forum&cmd=content&id='.$DB->mbm_result($r,$i,"id").'&forum_id='.$DB->mbm_result($r,$i,"forum_id").'#'.$tmp_content_id.'">';
						$buf .= ' &raquo; ';
					$buf .= '</a>';
					$buf .= '<br />';
					$buf .= date("Y/m/d",$DB->mbm_result($r,$i,'date_added'));
				$buf .= '</td>';
			$buf .= '</tr>';
		}
		$buf .= '</table>';
	}
	$buf .= $buf_sep;
	return $buf;
}
//forum iin content more gesen ug yumuu daa
function mbmForumContentPosts($content_id=0,$order_by='id',$asc='asc',$just_original_post=0){
	global $DB,$DB2,$lang,$BBCODE;
	
	$forum_id = $DB->mbm_get_field($content_id,'id','forum_id','forum_contents');
	
	$DB->mbm_query("UPDATE ".PREFIX."forum_contents SET hits=hits+".HITS_BY." WHERE id='".$content_id."'");
	
	$q = "SELECT * FROM ".PREFIX."forum_contents WHERE content_id='".$content_id."' ORDER BY ".$order_by." ".$asc;
	$r = $DB->mbm_query($q);
	
	$q_main = "SELECT * FROM ".PREFIX."forum_contents WHERE id='".$content_id."'";
	$r_main = $DB->mbm_query($q_main);
	
	$buf = '';
	$buf .= '<div class="forumUpperForumTitle">';
	$buf .= $DB->mbm_get_field($forum_id,'id','name','forums');
	$buf .= '</div>';
	
	if($just_original_post==0){
		$buf_sep = mbmNextPrev('index.php?module=forum&cmd=content&amp;id='.$content_id.'&amp;forum_id='.$forum_id,$DB->mbm_num_rows($r),START,PER_PAGE_FORUM);
		$buf_sep .= mbmForumReplyTopic($content_id);
	}else{
		$buf_sep ='';
	}	
	$buf .= $buf_sep.mbmForumNewTopic($forum_id); //next and reply button
	$buf .= '<table width="100%" cellpadding="0" cellspacing="0" class="forumPostTable">';
		$buf .= '<tr class="forumTopicListHeader">';
			$buf .= '<td class="forumTopicListHeader" colspan="2">';
				$buf .= mbmForumPostCommands($DB->mbm_result($r_main,0,"user_id"),$DB->mbm_result($r_main,0,"id"));
				$buf .= $DB->mbm_result($r_main,0,"title");
				$buf .= ' <span class="forumTimeConverter">['.mbmTimeConverter($DB->mbm_result($r_main,0,"date_added")).']</span>';
			$buf .= '</td>';
		$buf .= '</tr>';
		$buf .= '<tr>';
			$buf .= '<td class="forumContentCol_1">';
				$buf .= '<center><strong>'.$DB2->mbm_get_field($DB->mbm_result($r_main,0,"user_id"),'id','username','users')
						.'</strong></center>';
				$buf .= '<br />';
				$buf .= '<div align="center">'.mbmUserAvatar($DB->mbm_result($r_main,0,"user_id")).'</div>';
				$buf .= $lang["users"]["date_added"].': '.date("Y/m/d",$DB2->mbm_get_field($DB->mbm_result($r_main,0,"user_id"),'id','date_added','users'));
			$buf .= '</td>';
			$buf .= '<td class="forumContentCol_2">';
			$content_more = $DB->mbm_result($r_main,0,"content_more");
			if( 1 == $DB->mbm_result($r_main,0,"use_bbcode")){
				$buf .= $BBCODE->parse_bbcode($content_more);
			}else{
				$buf .= $content_more;
			}
			unset($content_more);
			$buf .= '</td>';
		$buf .= '</tr>';
		$buf .= '<tr>';
			$buf .= '<td class="forumContentCol_1">&nbsp;</td>';
			$buf .= '<td class="forumSignatureField">';
				if($DB->mbm_result($r_main,0,"use_signature")==1){
					$buf .= $DB2->mbm_get_field($DB->mbm_result($r_main,0,"user_id"),'id',"signature",'users');
				}
			$buf .= '</td>';
		$buf .= '</tr>';
		$buf .= '<tr>';
			$buf .= '<td align="center" class="forumPostFooter1">&nbsp;</td>';
			$buf .= '<td class="forumPostFooter2">';
				$buf .= mbmForumContactIcons($DB->mbm_result($r_main,0,"user_id"));
			$buf .= '</td>';
		$buf .= '</tr>';
		$buf .= '</table>';
	if($just_original_post==0){
		if((START+PER_PAGE_FORUM  ) > $DB->mbm_num_rows($r)){
			$end= $DB->mbm_num_rows($r);
		}else{
			$end= START+PER_PAGE_FORUM  ; 
		}
		for($i=START;$i<$end;$i++){
			
			unset($r_tmp_userinfo);
			$q_tmp_userinfo = "SELECT * FROM ".USER_DB_PREFIX."users WHERE id='".$DB->mbm_result($r,$i,"user_id")."' LIMIT 1";
			$r_tmp_userinfo = $DB2->mbm_query($q_tmp_userinfo);

			$buf .= '<table width="100%" cellpadding="0" cellspacing="0" class="forumPostTable">';
			$buf .= '<tr>';
				$buf .= '<td class="forumTopicListHeader" colspan="2"> ';
					$buf .= mbmForumPostCommands($DB->mbm_result($r,$i,"user_id"),$DB->mbm_result($r,$i,"id"));
					$buf .= '#'.($i+1).'.<a name="'.($i+2).'"></a> ';
					$buf .= $DB->mbm_result($r,$i,"title");
					$buf .= ' <span class="forumTimeConverter">['.mbmTimeConverter($DB->mbm_result($r,$i,"date_added")).']</span>';
			$buf .= '</td>';
			$buf .= '</tr>';
			$buf .= '<tr>';
				$buf .= '<td class="forumContentCol_1">';
					$buf .= '<center><strong>';
						$buf .= $DB2->mbm_result($r_tmp_userinfo,0,"username");
					$buf .= '</strong></center>';
					$buf .= '<br />';
					$buf .= '<div align="center">'.mbmUserAvatar($DB->mbm_result($r,$i,"user_id")).'</div>';
					$buf .= $lang["users"]["date_added"].': '.date("Y/m/d",$DB2->mbm_result($r_tmp_userinfo,0,"date_added"));
				$buf .= '</td>';
				$buf .= '<td class="forumContentCol_2">';
				$content_more = $DB->mbm_result($r,$i,"content_more");
				if( 1 == $DB->mbm_result($r,$i,"use_bbcode")){
					$buf .= $BBCODE->parse_bbcode($content_more);
				}else{
					$buf .= $content_more;
				}
				unset($content_more);
				$buf .= '</td>';
			$buf .= '</tr>';
			$buf .= '<tr>';
				$buf .= '<td align="center" class="forumContentCol_1">&nbsp;</td>';
				$buf .= '<td class="forumSignatureField">';
					if($DB->mbm_result($r,$i,"use_signature")==1){
						$buf .= $DB2->mbm_result($r_tmp_userinfo,0,"signature");
					}
				$buf .= '</td>';
			$buf .= '</tr>';
			$buf .= '<tr>';
				$buf .= '<td align="center" class="forumPostFooter1">&nbsp;</td>';
				$buf .= '<td class="forumPostFooter2">';
					$buf .= mbmForumContactIcons($DB2->mbm_result($r_tmp_userinfo,0,"id"));
				$buf .= '</td>';
			$buf .= '</tr>';
			$buf .= '</table>';
		}
	}
	$buf .= '</table>';
	$buf .= $buf_sep.mbmForumNewTopic($forum_id); //next and reply button
	if($DB->mbm_check_field('id',$content_id,'forum_contents')==0){
		return false;
	}
	return $buf;
}
?>