<?
function mbmReturnMenuNames($menu_ids=','){
	global $DB;
	
	$menus = explode(",",rtrim($menu_ids,","));
	
	$buf = '';
	$i=0;
	foreach($menus as $k=>$v){
		if($i>0){
			$buf .= $DB->mbm_get_field($v,'id','name','menus').', ';
		}
		$i++;
	}
	return rtrim($buf,", ");
}

function mbmReturnMenuId($menu_ids=','){
	
	$ids = explode(",",rtrim($menu_ids,','));	
	$arrays = count($ids);
	
	return $ids[rand(1,($arrays-1))];
}
function mbmBuildPath($menu_code){
	global $DB,$lang;
	static $sss='';
	$sss .= $menu_code.',';
	
	$upper_code = $DB->mbm_get_field($menu_code,"id","menu_id","menus");
	
	if($upper_code!='0'){
		mbmBuildPath($upper_code);
	}elseif(!isset($_GET['menu_id'])){
		return $lang['main']['home'];
	}
	$sss=rtrim($sss,",");
	$menu_codes = explode(",",$sss);
	
	if(is_array($menu_codes)){
		$menu_codes = array_reverse($menu_codes);
		foreach($menu_codes as $k =>$v){
			if($v!=0){
				$result .= '<a href="index.php?module=menu&cmd=menu_list&menu_id='.$v.'" style="color:#0099FF">';
				$result .= $DB->mbm_get_field($v,"id","name","menus").'</a> &raquo; ';
			}
		}
	}else{
		$result = $menu_codes;
	}
	return '<a href="index.php?module=menu&cmd=menu_list">'.$lang['main']['home'].'</a> &raquo; '.rtrim($result," &raquo; ");
}
function mbmDeleteContents($content_id){
	global $DB;
	
	$DB->mbm_query("DELETE FROM ".PREFIX."menu_videos WHERE content_id='".$content_id."'");
	$DB->mbm_query("DELETE FROM ".PREFIX."menu_photos WHERE content_id='".$content_id."'");
	$DB->mbm_query("DELETE FROM ".PREFIX."menu_contents WHERE id='".$content_id."'");
	
	return true;
}
function mbmDeleteMenuContents($menu_id){
	global $DB;
	
	$DB->mbm_query("DELETE FROM ".PREFIX."menu_videos WHERE menu_id = ',".$menu_id.",'");
	$DB->mbm_query("DELETE FROM ".PREFIX."menu_photos WHERE menu_id = ',".$menu_id.",'");
	$DB->mbm_query("DELETE FROM ".PREFIX."menu_contents WHERE menu_id = ',".$menu_id.",'");
	
	return true;
}
function mbmDeleteMenu($id){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."menus WHERE menu_id='".$id."'";
	$r = $DB->mbm_query($q);
	if($DB->mbm_num_rows($r)==0){
		$DB->mbm_query("DELETE FROM ".PREFIX."menus WHERE id='".$id."'");
		mbmDeleteMenuContents($id);
	}else{
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
			mbmDeleteMenu($DB->mbm_result($r,$i,"id"));
		}
	}
	return true;
}

function mbmShowMenuCombobox($mid=0, $id=0){
	global $DB;
	
	$q_menu = "SELECT * FROM ".PREFIX."menus WHERE menu_id='".$mid."' AND lang='".$_SESSION['ln']."' ORDER BY pos";
	$r_menu = $DB->mbm_query($q_menu);
		if($DB->mbm_num_rows($r_menu) != 0){
		for($i=0;$i<$DB->mbm_num_rows($r_menu);$i++){
			if($id == $DB->mbm_result($r_menu,$i,"id")){
				$tmp= 'selected';
			}else{
				$tmp= '';
			}
			echo '<option value="'.$DB->mbm_result($r_menu,$i,"id").'" '.$tmp.' ';
				if($id==$DB->mbm_result($r_menu,$i,"id")){
					echo 'selected ';
				}
				echo '>'.str_repeat("&nbsp;",($DB->mbm_result($r_menu,$i,"sub")*5)).$DB->mbm_result($r_menu,$i,"name");
			echo '</option>';			
			mbmShowMenuCombobox($DB->mbm_result($r_menu,$i,"id"), $id);
		}
	}
	
	return true;
}
function mbmMenuMaxPos($menu_id=0){
	global $DB;
	$q_menu = "SELECT MAX(pos) FROM ".PREFIX."menus WHERE menu_id='".$menu_id."' AND lang='".$_SESSION['ln']."'";
	$r_menu = $DB->mbm_query($q_menu);
	return $DB->mbm_result($r_menu,0);
}
function mbmResetMenuPos($menu_id=0){
	global $lang;
	global $DB;
	
	$q_menu_pos = "SELECT * FROM ".PREFIX."menus WHERE menu_id='".$menu_id."' AND lang='".$_SESSION['ln']."' ORDER BY pos";
	$r_menu_pos = $DB->mbm_query($q_menu_pos);
	
	for($i=0;$i<$DB->mbm_num_rows($r_menu_pos);$i++){
		$DB->mbm_query("UPDATE ".PREFIX."menus SET pos='".($i+1)."' WHERE id='".$DB->mbm_result($r_menu_pos,$i,"id")."'");
	}
	return true;
}

function mbmMenuUpdatePos($menu_id=0 /*update hiigdej bui menu id*/){
	global $DB;
	if(isset($_GET['pos'])){
		$DB->mbm_query("UPDATE ".PREFIX."menus SET pos='".$_GET['pos']."' WHERE id='".$_GET['id']."'");
		$upper_menu_id = $DB->mbm_get_field($_GET['id'],'id','menu_id','menus');
		mbmResetMenuPos($upper_menu_id);
	}
	return true;
}

function mbmContentCommentsTotal($content_id=0){
	global $DB;
	
	$q = "SELECT COUNT(id) FROM ".PREFIX."menu_content_comments WHERE content_id='".$content_id."'";
	$r = $DB->mbm_query($q);
	
	return $DB->mbm_result($r,0);
}
function mbmCheckDeeperMenu($menu_id=0,$deepr_menu_id=0){
	global $DB;
	
}
?>