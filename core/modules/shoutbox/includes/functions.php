<?
function mbmShoutboxForm($input_size=20,$height=200){
	global $DB,$DB2,$lang;
	
	$buf .= '<form action="" method="POST" name="shoutboxForm" id="shoutboxForm">';
	$buf .= '<div id="shoutboxTitle">'.$lang['shoutbox']['title'];
	$buf .= '</div>';
	$buf .= '<div>';
	$buf .= '<input type="text" name="shoutbox_name" id="shoutbox_name" class="shoutbox_input" value="';
	if($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==1){
		$buf .= $DB2->mbm_get_field($_SESSION['user_id'],'id','username','users');
		$buf .= '" disabled="disabled';
	}else{
		$buf .= $lang['main']['name'];
	}
	$buf .= '" />';
	$buf .= '</div>';
	$buf .= '<div>';
	$buf .= '<input type="text" name="shoutbox_email" id="shoutbox_email" class="shoutbox_input" value="';
	if($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==1){
		$buf .= $DB2->mbm_get_field($_SESSION['user_id'],'id','email','users');
		$buf .= '" disabled="disabled';
	}else{
		$buf .= $lang['main']['email'];
	}
	$buf .= '" />';
	$buf .= '</div>';
	$buf .= '<div>';
	$buf .= '<textarea name="shoutbox_content" id="shoutbox_content" class="shoutbox_textarea" cols="'.($input_size+3).'" rows="3">';
	$buf .= '</textarea>';
	$buf .= '</div>';
	$buf .= '<div>';
	$buf .= '<input type="submit" name="shoutbox_submit" id="shoutbox_submit" class="shoutbox_button" value="'.$lang['shoutbox']['button_send'].'" />';
	$buf .= '</div>';
	$buf .= '</form>';
	$buf .= '<div id="shoutboxLoading"><img src="'.DOMAIN.DIR.'/images/loading.gif" border="0" /></div>';
	$buf .= '<div id="shoutboxResult"></div>';
	
	return $buf;
}
?>