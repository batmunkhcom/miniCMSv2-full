<?
function mbmZarCatMaxPos($cat_id=0){
	global $DB2;
	
	$q = "SELECT MAX(pos) FROM ".$DB2->prefix."zar_cats WHERE cat_id='".$cat_id."'";
	$r = $DB2->mbm_query($q);
	
	return $DB2->mbm_result($r,0);
}
function mbmZarCatsDropDown($cat_id=0){
	global $DB2;
	static $buf = '';
	
	$q = "SELECT * FROM ".$DB2->prefix."zar_cats WHERE cat_id='".$cat_id."' ORDER BY pos";
	$r = $DB2->mbm_query($q);
	
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		$buf .= '<option value="'.$DB2->mbm_result($r,$i,"id").'" ';
		$buf .= 'style="padding-left:'.($DB2->mbm_result($r,$i,"sub")*20).'px"';
		if($DB2->mbm_result($r,$i,"id")==$selected_id){
			$buf .= ' selected ';
		}
		$buf .= '>'.$DB2->mbm_result($r,$i,"name").'</option>';
		if($DB2->mbm_check_field('cat_id',$DB2->mbm_result($r,$i,"id"),'zar_cats')==1){
			$buf = mbmZarCatsDropDown($DB2->mbm_result($r,$i,"id"),$selected_id);
		}
	}
	return $buf;
}
function mbmZarDeleteCats($cat_id=0){
	global $DB2;
	
	$q = "SELECT * FROM ".$DB2->prefix."zar_cats WHERE cat_id='".$cat_id."' ORDER BY pos";
	$r = $DB2->mbm_query($q);
	
	$cats[$cat_id] = $cat_id;
	
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		if($DB2->mbm_check_field('cat_id',$DB2->mbm_result($r,$i,"id"),'zar_cats')==1){
			mbmZarDeleteCats($DB2->mbm_result($r,$i,"id"));
		}else{
			$cats[$DB2->mbm_result($r,$i,"id")] = $DB2->mbm_result($r,$i,"id");
		}
	}
	if(is_array($cats)){
		foreach($cats as $k=>$v){
			mbmZarDeleteContents($k);
			$DB2->mbm_query("DELETE FROM ".$DB2->prefix."zar_cats WHERE id='".$k."'");
		}
	}
	
	return true;
	
}
function mbmZarDeleteContents($cat_id=0){
	global $DB2;
	
	return $DB2->mbm_query("DELETE FROM ".$DB2->prefix."zar_contents WHERE cat_ids LIKE '%,".$cat_id.",%'");
}

function mbmZarTypesDropDown(){
	global $DB2;
	static $buf = '';
	
	$q = "SELECT * FROM ".$DB2->prefix."zar_types ORDER BY id ASC";
	$r = $DB2->mbm_query($q);
	
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		$buf .= '<option value="'.$DB2->mbm_result($r,$i,"id").'" ';
		$buf .= '>'.$DB2->mbm_result($r,$i,"name").'</option>';
	}
	return $buf;
}
?>