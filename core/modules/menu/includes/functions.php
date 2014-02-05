<?
function mbmBuildUserPath($menu_code){
	global $DB,$lang;
	static $sss='';
	$sss .= $menu_code.',';
	
	$upper_code = $DB->mbm_get_field($menu_code,"id","menu_id","menus");
	
	if($upper_code!='0'){
		mbmBuildUserPath($upper_code);
	}elseif(!isset($_GET['menu_id'])){
		return $lang['main']['home'];
	}
	$sss=rtrim($sss,",");
	$menu_codes = explode(",",$sss);
	
	if(is_array($menu_codes)){
		$menu_codes = array_reverse($menu_codes);
		foreach($menu_codes as $k =>$v){
			$result .= '<a href="index.php?module=menu&amp;cmd=content&amp;menu_id='.$v.'&amp;start=0';
			$result .= '" style="color:#0099FF">';
			$result .= $DB->mbm_get_field($v,"id","name","menus").'</a> &raquo; ';
		}
	}else{
		$result = $menu_codes;
	}
	return '<a href="index.php">'.$lang['main']['home'].'</a> &raquo; '.rtrim($result," &raquo; ");
}
function mbmCheckMenuPermission($user_id=0,$type="read",$menu_id){
	global $DB;
	
	$q_check = "SELECT COUNT(*) FROM ".PREFIX."menu_permissions WHERE `$type`=1 AND user_id='".$user_id."' AND menu_id='".$menu_id."' LIMIT 1";
	$r_check = $DB->mbm_query($q_check);
	
	if($DB->mbm_result($r_check,0)>0){
		return 1;
	}else{
		return 0;
	}
}
//,5,6, geh met menunuudiin permission iig shalgaad ali neg n 0 bval 0 butsaana
function mbmCheckMenusPermission($user_id=0,$type="read",$menu_ids){
	global $DB;
	$menu_id_tmp = $menu_ids;
				
	$menu_ids = explode(",",rtrim($menu_id_tmp,","));

	$p=0;
	foreach($menu_ids as $kK=>$vV){
		if($p>0){
			if(mbmCheckMenuPermission($user_id,$type,$vV)==0){ //anhaar
				$PP=1;
			}
		}
		$p++;
	}
	if($PP!=1){
		return 1;
	}else{
		return 0;
	}
}
function mbmCheckMenuPermissionExists($user_id=0,$type="read"){
	global $DB;
	
	$q_check = "SELECT COUNT(*) FROM ".PREFIX."menu_permissions WHERE user_id='".$user_id."' AND `$type`=1";
	$r_check = $DB->mbm_query($q_check);
	
	if($DB->mbm_result($r_check,0)>0){
		return 1;
	}else{
		return 0;
	}
}
function mbmCheckMenuMultiplePermissions($user_id,$types=array('read','write')){
	global $DB;
	
	$q_check = "SELECT COUNT(*) FROM ".PREFIX."menu_permissions WHERE user_id='".$user_id."' ";
	foreach($types as $k=>$v){
		$q_check .= "AND `".$v."`='1' ";
	}
	$r_check = $DB->mbm_query($q_check);
	if($DB->mbm_result($r_check,0)>0){
		return 1;
	}else{
		return 0;
	}
}
function mbmUserPermissionMenus($permission="normal",$user_id=0){
	global $DB,$lang;
	
	$q_user_menus = "SELECT ".PREFIX."menu_permissions.menu_id, ".PREFIX."menus.name,".PREFIX."menus.id, 
							".PREFIX."menu_permissions.lev,".PREFIX."menu_permissions.st 
							FROM ".PREFIX."menu_permissions,".PREFIX."menus 
							WHERE ".PREFIX."menu_permissions.write=1 ";
	$q_user_menus .= "AND ".PREFIX."menu_permissions.".$permission."=1 ";
	$q_user_menus .= "AND ".PREFIX."menu_permissions.user_id='".$user_id."' AND "
					 .PREFIX."menu_permissions.menu_id=".PREFIX."menus.id ORDER BY ".PREFIX."menu_permissions.id ";
	$r_user_menus = $DB->mbm_query($q_user_menus);
	//echo $q_user_menus;
	$buf .= '<table width="100%" border="0" cellspacing="2" cellpadding="3" >';
		$buf .= '<tr>';
		for($i=0;$i<$DB->mbm_num_rows($r_user_menus);$i++){

				$st[] = $DB->mbm_result($r_user_menus,$i,"st");
				$lev[] = $DB->mbm_result($r_user_menus,$i,"lev");
				
				$buf .= '<td bgcolor="#f5f5f5">';
				$buf .= '<input type="checkbox" class="checkbox" name="menus[]" ';
					if($DB->mbm_num_rows($r_user_menus)==1){
						$buf .= ' checked ';
					}
				$buf .= ' value="'.$DB->mbm_result($r_user_menus,$i,"menu_id").'" /> '
					.$DB->mbm_result($r_user_menus,$i,"name");
					$buf .= '</td>';
				if((($i+1)%3)==0){
					$buf .= '</tr><tr>';
				}
		}
		
		$st_ = min($st);
		$lev_ = min($lev);
		
		$buf .= '</tr>';
		$buf .= '<tr><td>';
		$buf .= '<div>'.$lang['menu']['content_status'].':<br>
			    <select name="st" id="st" class="input">';
				if($st_==2){
					$buf .= mbmShowStOptions();
				}else{
					$buf .= '<option value="'.$st_.'">'.$lang['status'][$st_].'</option>';
				}
				$buf .= '
		        </select></div>';
		$buf .= '</td><td>';
		$buf .= '<div>'.$lang['menu']['content_level'].':<br>
			    <select name="lev" id="lev" class="input">'.mbmIntegerOptions(0, $lev_).'
		        </select></div>';
		$buf .= '</td>';
		$buf .= '<td></td></tr>';
		$buf .= '</table>';
		
		
	return $buf;
}

function mbmVideoEmbedCode($info=array(
								'flv_url'=>''
								)
						   ){
						   
	$buf = '<div id="videoEmbedCode">';
		$buf .= '<textarea class="videoEmbedCode_textarea" onclick="this.select()" cols="'.$info['textarea_cols'].'" rows="'.$info['textarea_rows'].'">';
			$player_code = mbmFlvPlayer(array(
								'height'=>FLV_PLAYER_HEIGHT,
								'width'=>FLV_PLAYER_WIDTH,
								'swf_player'=>FLV_PLAYER_URL,
								'title'=>FLV_PLAYER_TITLE,
								'titlesize'=>FLV_PLAYER_TITLESIZE,
								'flv_url'=>$info['flv_url'],
								'name'=>FLV_PLAYER_NAME,
								'autoplay'=>0,
								'showvolume'=>FLV_PLAYER_SHOWVOLUMEBUTTON,
								'showfullscreen'=>FLV_PLAYER_SHOWFULLSCREEN,
								'showstop'=>FLV_PLAYER_SHOWSTOPBUTTON,
								'showtime'=>FLV_PLAYER_SHOWTIME,
								'bgcolor'=>FLV_PLAYER_BGCOLOR,
								'buttoncolor'=>FLV_PLAYER_BUTTONCOLOR,
								'playercolor'=>FLV_PLAYER_PLAYERCOLOR,
								'bgcolor1'=>FLV_PLAYER_BGCOLOR1,
								'bgcolor2'=>FLV_PLAYER_BGCOLOR2,
								'buttonovercolor'=>FLV_PLAYER_BUTTONOVERCOLOR,
								'slidercolor1'=>FLV_PLAYER_SLIDERCOLOR1,
								'slidercolor2'=>FLV_PLAYER_SLIDERCOLOR2,
								'sliderovercolor'=>FLV_PLAYER_SLIDEROVERCOLOR,
								'loadingcolor'=>FLV_PLAYER_LOADINGCOLOR
								)
							);
				$buf .= str_replace("\n","",$player_code);
		$buf .= '</textarea>';
	$buf .= '</div>';
	
	return $buf;
}

function mbmSiteMap($menu_id=0){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."menus WHERE menu_id='".$menu_id."' AND st=1 AND lang='".$_SESSION['ln']."' ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	$buf = '<ul>';
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<li onclick="window.location=\''.mbmMenuLink($DB->mbm_result($r,$i,"id"),$DB->mbm_result($r,$i,"link")).'\'">';
		$buf .= $DB->mbm_result($r,$i,"name");
			if($DB->mbm_check_field('id',$DB->mbm_result($r,$i,"id"),"menus")==1){
				$buf .= mbmSiteMap($DB->mbm_result($r,$i,"id"));
			}
		$buf .= '</li>';
	}
	$buf .= '</ul>';
	
	return $buf;
}
?>