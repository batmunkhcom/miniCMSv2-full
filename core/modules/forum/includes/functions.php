<?
function mbmForumBuildPath($forum_id){
	global $DB,$lang;
	static $sss='';
	$sss .= $forum_id.',';
	
	$upper_code = $DB->mbm_get_field($forum_id,"id","forum_id","forums");
	
	if($upper_code!='0'){
		mbmForumBuildPath($upper_code);
	}elseif(!isset($_GET['forum_id'])){
		return $lang["forum"]["forum_home"];
	}
	$sss=rtrim($sss,",");
	$menu_codes = explode(",",$sss);
	
	if(is_array($menu_codes)){
		$menu_codes = array_reverse($menu_codes);
		foreach($menu_codes as $k =>$v){
			if($v!=0){
				$result .= '<a href="index.php?module=forum&cmd=forums&forum_id='.$v.'" style="color:#0099FF">';
				$result .= $DB->mbm_get_field($v,"id","name","forums").'</a> &raquo; ';
			}
		}
	}else{
		$result = $menu_codes;
	}
	$result = '<a href="index.php?module=forum&cmd=forums" style="color:#0099FF">'.$lang["forum"]["forum_home"].'</a> &raquo; '.rtrim($result," &raquo; ");
	if(isset($_GET['content_id'])){
		$c_id = $_GET['content_id'];
	}else{
		$c_id = $_GET['id'];
	}
	if($DB->mbm_check_field('id',$c_id,'forum_contents')==1){
		$result .= ' &raquo; '
					.'<a href="index.php?module=forum&cmd=content&id='.$c_id.'&forum_id='.$DB->mbm_get_field($c_id,'id','forum_id','forum_contents').'" style="color:#0099FF">'
					.$DB->mbm_get_field($c_id,'id','title','forum_contents')
					.'</a>';
	}
	return '<div id="forumPath">'.$result.'</div>';
}
function mbmForumContactIcons($user_id=0){
	
	$buf = '';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/settings.png" border="0" hspace="1" alt="" />';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/msg.png" border="0" hspace="1" alt="" />';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/email.png" border="0" hspace="1" alt="" />';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/www.png" border="0" hspace="1" alt="" />';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/yim.png" border="0" hspace="1" alt="" />';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/msn.png" border="0" hspace="1" alt="" />';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/icq.png" border="0" hspace="1" alt="" />';
	
	return $buf;
}
function mbmForumPostCommands($user_id=0,$post_id=0){

	$buf = '<div style="float:right;width:200px;">';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/quote.png" border="0" hspace="1" alt="" />';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/edit.png" border="0" hspace="1" alt="" />';
	$buf .= '<img src="'.DOMAIN.DIR.'templates/'.TEMPLATE.'/images/forum/delete.png" border="0" hspace="1" alt="" />';
	$buf .= '</div>';
	
	return $buf;

}
?>