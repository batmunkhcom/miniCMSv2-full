<?
function mbmAutoCarTypesDropdown(){
	global $lang;
	
	$buf = '';
	
	foreach($lang["auto"]["types"] as $k=>$v){
		$buf .= '<option value="'.$k.'">'.$v.'</option>';
	}
	
	return $buf;
}
function mbmAutoFirms($type='dropdown',$country=0){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."auto_firms WHERE id!=0 ";
	if($country!=0){
		$q .= "AND country='".$country."'";
	}
	$q .= "ORDER BY id";
	$r = $DB->mbm_query($q);
	
	$buf = '';
	
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
	
		switch($type){
			case 'dropdown':
				$buf .= '<option value="'.$DB->mbm_result($r,$i,"id").'">';
					$buf .= $DB->mbm_result($r,$i,"name");
				$buf .= '</option>';
			break;
			default:
				$buf .= $DB->mbm_result($r,$i,"name");
			break;
		}		
	}
	
	return $buf;
}
?>