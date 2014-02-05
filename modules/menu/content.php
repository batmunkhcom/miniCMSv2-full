<?
if($mBm!=1){
	die("direct access not allowed.");
}else{
	//echo '<h2>'.$DB->mbm_get_field(MENU_ID,'id','name','menus').'</h2>';
	$DB->mbm_query("UPDATE ".PREFIX."menus SET hits=hits+".HITS_BY." WHERE id='".MENU_ID."' LIMIT 1");
	
	echo mbmShowContents(array('','','',''),MENU_ID,array(
												   'show_briefInfo'=>0
												   ));
	
}

?>