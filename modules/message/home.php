<?
if($_SESSION['lev'] == 0 || !isset($_SESSION['user_id'])){
	echo mbmError('Login required');
}else{

	$q_newmsg = "SELECT COUNT(id) FROM ".$DB->prefix."messages WHERE is_read=0 AND to_uid='".$_SESSION['id']."' ";
	$r_newmsg = $DB->mbm_query($q_newmsg);
	
	echo 'You have <big><strong>'.$DB->mbm_result($r_newmsg,0).'</strong></big> new messages.';
}
?>