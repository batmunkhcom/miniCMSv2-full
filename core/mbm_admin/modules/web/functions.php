<?
function mbmWebCatsDropDown($cat_id=0,$selected_id=0){
	global $DB;
	static $buf = '';
	
	$q = "SELECT * FROM ".PREFIX."web_cats WHERE cat_id='".$cat_id."' AND lang='".$_SESSION['ln']."' ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<option value="'.$DB->mbm_result($r,$i,"id").'" ';
		$buf .= 'style="padding-left:'.($DB->mbm_result($r,$i,"sub")*20).'px"';
		if($DB->mbm_result($r,$i,"id")==$selected_id){
			$buf .= ' selected ';
		}
		$buf .= '>'.$DB->mbm_result($r,$i,"name").'</option>';
		if($DB->mbm_check_field('cat_id',$DB->mbm_result($r,$i,"id"),'web_cats')==1){
			$buf = mbmWebCatsDropDown($DB->mbm_result($r,$i,"id"),$selected_id);
		}
	}
	return $buf;
}
function mbmWebCatsMaxPos($cat_id=0){
	global $DB;
	
	$q = "SELECT MAX(pos) FROM ".PREFIX."web_cats WHERE cat_id='".$cat_id."' AND lang='".$_SESSION['ln']."'";
	$r = $DB->mbm_query($q);
	
	return $DB->mbm_result($r,0);
}
function mbmWebCatsMinId(){
	global $DB;
	
	$q = "SELECT MIN(id) FROM ".PREFIX."web_cats WHERE  lang='".$_SESSION['ln']."'";
	$r = $DB->mbm_query($q);
	
	return $DB->mbm_result($r,0);
}
?>