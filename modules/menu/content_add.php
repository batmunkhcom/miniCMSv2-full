<?
if($mBm!=1){
	echo '<div id="query_result">direct access not allowed</div>';
}elseif($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==0){
	echo '<div id="query_result">Please login first.</div>';
}else{
	switch($_GET['type']){
		case 'photo':
			if(mbmCheckMenuMultiplePermissions($_SESSION['user_id'],array('write','is_photo'))==0){
				$result_txt = $lang["menu"]["no_permission_to_add_photo_content"];
				$write_permission_denied=1;
			}
			$add_filename = 'content_photo_add.php';
		break;
		case 'video':
			if(mbmCheckMenuMultiplePermissions($_SESSION['user_id'],array('write','is_video'))==0){
				$result_txt = $lang["menu"]["no_permission_to_add_video_content"];
				$write_permission_denied=1;
			}
			$add_filename = 'content_video_add.php';
		break;
		case 'normal':
			if(mbmCheckMenuMultiplePermissions($_SESSION['user_id'],array('write','normal'))==0){
				$result_txt = $lang["menu"]["no_permission_to_add_normal_content"];
				$write_permission_denied=1;
			}
			$add_filename = 'content_normal_add.php';
		break;
	}
	if($write_permission_denied==1){
		echo '<div id="query_result">'.$result_txt.'</div>';
	}else{
		if(file_exists(ABS_DIR."modules/menu/".$add_filename)){
			require_once(ABS_DIR."modules/menu/".$add_filename);
		}else{
			echo '<div id="query_result">'.$lang["menu"]["no_such_command_exists"].'</div>';
		}
	}
}
?>