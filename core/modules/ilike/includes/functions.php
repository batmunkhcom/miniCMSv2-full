<?
function mbmIlike($var = array(
							   'up'=>1,
							   'down'=>0,
							   'active'=>0,
							   'code'=>''
							   )){
	global $DB2,$lang;
	
	//$var['code'] = base64_encode(DOMAIN.$var['code']);
	
	$q = "SELECT COUNT(value) FROM ".$DB2->prefix."ilike WHERE `type`='1' AND code='".$var['code']."'";
	$r = $DB2->mbm_query($q);
	
	$buf = '<span id="Ilike"><span id= "IlikeValues">';
	if($var['up']==1){
		$buf .= '<img src="'.INCLUDE_DOMAIN.'images/ilike_up.png" ';
		if($var['active']==1){
			$buf .= 'id="IlikeUp" name="IlikeUp" ';
		}
		$buf .= 'border="0" alt="I like" />';
	}
	if($var['down']==1){
		$buf .= '<img src="'.INCLUDE_DOMAIN.'images/ilike_down.png" ';
		if($var['active']==1){
			$buf .= 'id="IlikeDown" name="IlikeDown" ';
		}
		$buf .= 'alt="i don\'t like" border="0" />';
	}
	$buf .= ' <strong>'.$DB2->mbm_result($r,0).'</strong> хүн дуртай';
	$buf .= '</span>';
		$buf .= '<span id="IlikeLoading">';
		$buf .= '</span>';
		$buf .= '<span id="IlikeCode" name="IlikeCode" style="display:none;">'.$var['code'].'</span>';
	$buf .= '</span>';
	
	if($var['code']==''){
		$buf = '';
	}
	return $buf;
}
function mbmTotalIlikes($var = array(
							   'up'=>1,
							   'down'=>0,
							   'code'=>''
							   )){
	global $DB2;
	if($var['up']==1){
		$type = 1;
	}else{
		$type = -1;
	}
	$q = "SELECT SUM(value) FROM ".$DB2->prefix."ilike WHERE type='".$type."'";
	$r = $DB2->mbm_query($r);
	
	return $DB2->mbm_result($r,0);
}
?>