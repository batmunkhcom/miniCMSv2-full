<?
function mbmUserPanel($user_id=0,$htmls=array('','','',''),$b_url='index.php?module=users&cmd=login'){
	global $DB2;
	
	if($_SESSION['user_id']!=0 && $DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==1 && $_SESSION['lev']>0){
		$buf = mbmUserMenus($user_id,$htmls);
	}else{ 
		if(strlen($_SERVER['QUERY_STRING'])<5){
			$b_url = DOMAIN.DIR;
		}else{
			$b_url = DOMAIN.DIR.'?'.$_SERVER['QUERY_STRING'];
		}
		$buf = mbmUserLoginForm($b_url);
	}
	return $buf;
}
function mbmUserMenus($user_id=0,$htmls=array('','','','')){
	global $DB2,$lang;
	$user_menus['index.php?module=users&amp;cmd=profile'] = $lang["users"]['user_profile'];
	$user_menus['index.php?module=users&amp;cmd=avatars'] = $lang["users"]['user_avatar'];
	//$user_menus['index.php?module=menu&cmd=play_videolist'] = $lang["menu"]["video_playlist"];
	//$user_menus['blog.php?blog_id='.$user_id] = $lang["users"]['user_blog'];
	if(mbmCheckMenuMultiplePermissions($user_id,array('write','normal'))==1){
		$user_menus['index.php?module=menu&cmd=content_add&type=normal'] = $lang["users"]['normal_content_add'];
		if(mbmCheckMenuMultiplePermissions($user_id,array('read','normal'))==1){
			$user_menus['index.php?module=menu&cmd=content_list&type=normal'] = $lang["users"]['normal_content_list'];
		}
	}
	if(mbmCheckMenuMultiplePermissions($user_id,array('write','is_photo'))==1){
		$user_menus['index.php?module=menu&cmd=content_add&type=photo'] = $lang["users"]['photo_content_add'];
		if(mbmCheckMenuMultiplePermissions($user_id,array('read','is_photo'))==1){
			$user_menus['index.php?module=menu&cmd=content_list&type=is_photo'] = $lang["users"]['photo_content_list'];
		}
	}
	if(mbmCheckMenuMultiplePermissions($user_id,array('write','is_video'))==1){
		$user_menus['index.php?module=menu&cmd=content_add&type=video'] = $lang["users"]['video_content_add'];
		if(mbmCheckMenuMultiplePermissions($user_id,array('read','is_video'))==1){
			$user_menus['index.php?module=menu&cmd=content_list&type=is_video'] = $lang["users"]['video_content_list'];
		}
	}
	//$user_menus['index.php?module=menu&cmd=menu_users'] = 'content management';
	$user_menus['index.php?module=photogallery&amp;cmd=photo_add'] = $lang["users"]['photo_add'];
	$user_menus['index.php?action=logout&url='.base64_encode("index.php")] = $lang["users"]['user_logout'];
	
	$buf .= '<div class="userPanelTitle">'.$lang['users']['login_title'].'</div>';
	$buf .= '<center>'.$DB2->mbm_get_field($user_id,'id','username','users').'<br />'.mbmUserAvatar($user_id).'</center>';
	foreach($user_menus as $k=>$v){
		$buf .= $htmls[2];
			$buf .= '<a href="'.$k.'">'.$v.'</a>';
		$buf .= $htmls[3];
	}
	if($DB2->mbm_check_field('id',$user_id,'users')==1){
		return $htmls[0].$buf.$htmls[1];
	}else{
		return '';
	}
}
function mbmUserLoginForm($back_url='index.php?module=users&cmd=login'){
	global $lang;

	$buf = '<form name="form1" method="post" action="index.php?action=userLogin&amp;url='.base64_encode($back_url).'">
	  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="loginTBL">
		<tr>
		  <td colspan="2" class="loginTitle">'.$lang['users']['login_title'].'</td>
		</tr>
		<tr>
		  <td width="30%" align="right">'.$lang['users']['login_username'].'</td>
		  <td><input type="text" size="15" name="username" id="username" class="login_input"></td>
		</tr>
		<tr>
		  <td align="right">'.$lang['users']['login_password'].'</td>
		  <td><input type="password" size="15" name="password" id="password" class="login_input"></td>
		</tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td><input type="submit" name="loginButton" class="login_button" id="loginButton" autocomplete="off" value="'.$lang['users']['login_button'].'"></td>
		</tr>
		<tr>
		  <td colspan="2" align="center"><a href="index.php?module=users&amp;cmd=recover_pw">'.$lang['users']['login_forgotpass'].'</a> | 
		  <a href="index.php?module=users&amp;cmd=registration">'.$lang['users']['login_signup'].'</a></td>
		</tr>
	  </table>
	</form>
	';
	return $buf;
}
function mbmUserAvatar($user_id=0){
	global $DB2;
	$buf = '<img src="modules/users/avatar_show.php?id='
					.$DB2->mbm_get_field($user_id,"user_id","id","user_avatars")
					.'" alt="'.$DB2->mbm_get_field($user_id,"user_id","username","users").'" />';
	return $buf;
}
function mbmUpdateUserScore($user_id=0,$score=0){
	global $DB2;

	if($_SESSION['user_id']>0){
		return $DB2->mbm_query("UPDATE ".$DB2->prefix."users SET score=score+".$score." WHERE id='".$user_id."' LIMIT 1");
	}else{
		return 0;
	}
}
?>