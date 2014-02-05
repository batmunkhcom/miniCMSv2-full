<?
if($mBm!=1){
	echo '<div id="query_result">direct access not allowed</div>';
}elseif($DB->mbm_check_field('id',$_SESSION['user_id'],'users')==0){
	echo '<div id="query_result">Please login first.</div>';
}else{
	$q_menu_users = "SELECT * FROM ".PREFIX."menu_users ORDER BY id DESC";
	$r_menu_users = $DB->mbm_query($q_menu_users);

	echo '<form action="" method="post">';
	echo '<select name="menus" id="menus" class="input">';
	for($i=0;$i<$DB->mbm_query($r_menu_users);$i++){
		echo '<option value="'.$DB->mbm_result($r_menu_users,$i,"menu_id").'">';
			echo $DB->mbm_get_field($DB->mbm_result($r_menu_users,$i,"menu_id"),'id','name','menus');
		echo '</option>';
	}
	echo '</select>';
	echo '</form>';
}
?>