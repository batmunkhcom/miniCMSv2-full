<?

function mbmForumNewTopic($forum_id=0){
	global $lang;
	
	//$buf .= '<div id="forumNewTopic">';
		$buf .= '<a href="';
			if($_SESSION['lev']==0){
				$buf .= '#" onclick="alert(\''.addslashes($lang["forum"]["login_to_create_topic"]).'\')';
			}else{
				$buf .= 'index.php?module=forum&amp;cmd=new&amp;forum_id='.$forum_id.'';
			}
		$buf .='">';
			$buf .= '<img alt="'.$lang["forum"]["creat_topic"].'" vspace="5" hspace="4" src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/button_new_topic.png" border="0" />';
		$buf .= '</a>';
	//$buf .= '</div>';
	if($forum_id==0 || $_GET['forum_id']=='' || !isset($_GET['forum_id'])){
		return '';
	}
	return $buf;
}
function mbmForumReplyTopic($content_id=0){
	global $DB,$lang;
	
	$forum_id = $DB->mbm_get_field($content_id,'id','forum_id','forum_contents');
	
	//$buf .= '<div id="forumReplyTopic">';
		$buf .= '<a href="';
			if($_SESSION['lev']==0){
				$buf .= '#" onclick="alert(\''.addslashes($lang["forum"]["login_to_reply_topic"]).'\')';
			}else{
				$buf .= 'index.php?module=forum&amp;cmd=reply&amp;content_id='.$content_id.'&forum_id='.$forum_id.'';
			}
		$buf .='">';
			$buf .= '<img alt="'.$lang["forum"]["reply_topic"].'" vspace="5" hspace="4" src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/button_reply.png" border="0" />';
		$buf .= '</a>';
	//$buf .= '</div>';
	if($forum_id==0){
		return '';
	}
	return $buf;
}
?>