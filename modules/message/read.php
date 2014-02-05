<?
if($_SESSION['lev'] == 0 || !isset($_SESSION['user_id'])){
	echo mbmError('Login required');
}else{
	
	$q_getinfo = "SELECT * FROM ".$DB->prefix."messages WHERE id='".addslashes($_GET['id'])."'";
	$r_getinfo = $DB->mbm_query($q_getinfo);
		
	if($DB->mbm_num_rows($r_getinfo) == 1){
		echo '<h1>'.$DB->mbm_result($r_getinfo,0,'subject').'</h1>';
		
		echo 'From: '.$DB2->mbm_get_field($DB->mbm_result($r_getinfo,0,'from_uid'),'id','username','users').'<br />';
		echo 'Date: '.date("Y/m/d H:i:s",$DB->mbm_result($r_getinfo,0,'date_added')).'<br />';
		echo 'Priority: '.$GLOBALS['msg_priority'][$DB->mbm_result($r_getinfo,0,'priority')].'<br />';
		echo 'Box: '.$DB->mbm_result($r_getinfo,0,'box').'<br />';
		echo '<br /><br /><br />';
		echo $DB->mbm_result($r_getinfo,0,'content').'<br />';
		echo '<br /><br /><br />';
	}
	
	$DB->mbm_query("UPDATE ".$DB->prefix."messages SET is_read=1,date_read='".mbmTime()."' WHERE id='".$DB->mbm_result($r_getinfo,0,'id')."'");
	
}
?>