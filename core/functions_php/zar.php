<?
define("ZAR_DELETE_DURATION",3600*24*7);
define("ZAR_PER_PAGE",50);
define("ZAR_DEFAULT_MAX_HITS",10000);

function mbmShowZar($var = array(
								 'user_id'=>0,
								 'phone'=>0,
								 'order_by'=>'date_added',
								 'asc'=>'DESC',
								 'type'=>'sms',
								 'content'=>'% %',
								 'limit'=>1
								 )){
	global $DB2,$lang;
	
	if(!isset($var['order_by'])) $var['order_by'] = 'RAND()';
	if(!isset($var['asc'])) $var['asc'] = 'DESC';
	if(!isset($var['type'])) $var['type'] = 'sms';
	if(!isset($var['limit'])) $var['limit'] = 1;
	if(!isset($var['phone'])) $var['phone'] = 0;
	if(!isset($var['user_id'])) $var['user_id'] = 0;
	
	$q = "SELECT * FROM ".$DB2->prefix."zar WHERE type='".$var['type']."' AND max_hits>=hits ";
	if($var['user_id'] !=0 ) $q .= "AND user_id='".$var['user_id']."' ";
	if($var['phone'] !=0 ) $q .= "AND phone LIKE '".$var['phone']."' ";
	if($var['content'] !=0 ) $q .= "AND content LIKE '".$var['content']."' ";
	$q .= "ORDER BY ".$var['order_by']." ".$var['asc']." LIMIT ".$var['limit'];
	
	$r = $DB2->mbm_query($q);
	
	$buf = '';
	$buf .= '<div class="zarItem">';
	
	$zar_ids = '';
	
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		$buf .= mbmCleanUpHTML($DB2->mbm_result($r,$i,"content"));
		$buf .= '<br /><br />';
		$buf .= 'Утас: <strong>'.$DB2->mbm_result($r,$i,"phone").'</strong>';
		$buf .= '<br clear="both" />';
		$zar_ids .= "id='".$DB2->mbm_result($r,$i,"id")."' OR ";
	}
	$buf .= '<div style="text-align:right;"><a href="http://zar.az.mn/index.php?module=zar&cmd=sms&menu_id=2" target="_blank">дэлгэрэнгүй...</a></div>';
	$buf .= '</div>';
	

	$zar_ids = rtrim($zar_ids,"OR ");
	$update_q = "UPDATE ".$DB2->prefix."zar SET hits=hits+1 WHERE ".$zar_ids;
	
	$DB2->mbm_query($update_q);
	
	return $buf;
}

function mbmSMSprint(){
	
	$buf .= '<div style="margin-bottom:5px; display:block; padding:5px;border:1px solid #DDD; background-color:#F5F5F5; position:relative;">';
		$buf .= '<div style="width:120px; float:left">';
			$buf .= '<img src="http://lib.az.mn/images/mobile_ops.gif" border="0" alt="sms advertisement" />';
		$buf .= '</div>';
		$buf .= '<div class="button_yellow" style="position:absolute; top:5px; right:5px">';
			
			$buf .= '<a href="http://zar.az.mn/index.php?module=menu&cmd=content&menu_id=4" style="float:right; font-weight:normal; font-size:11px; text-decoration:underline;margin-right:5px;" target="_blank">Тусламж!!!</a>';
			$buf .= '<span style="font-size:14px; font-weight:bold; color:#0000ff;float:left;margin-left:5px; ">&raquo;156789</span>';
		$buf .= '</div>';
		
		$buf .= '<br clear="all" />';
			$buf .= '<div style="padding-bottom:5px; border-bottom:1px solid #FF0000; color:#FF0000;">';
			$buf .= 'Та <strong>156789</strong> дугаар руу зараа явуулснаар таны зар тус бүр 30 секундын турш нийт 1000 удаа харагдана.';
			$buf .= '</div>';
		$buf .= '<br clear="both" />';
	$buf .= '<div id="zarItems"></div>';
	$buf .= '</div>';
	
	return $buf;
}


function mbmShowZarHorizontal($var = array(
								 'user_id'=>0,
								 'phone'=>0,
								 'order_by'=>'date_added',
								 'asc'=>'DESC',
								 'type'=>'sms',
								 'content'=>'% %',
								 'limit'=>1
								 )){
	global $DB2,$lang;
	
	//if(!isset($var['order_by'])) $var['order_by'] = 'date_added';
	//if(!isset($var['asc'])) $var['asc'] = 'DESC';
	if(!isset($var['type'])) $var['type'] = 'sms';
	if(!isset($var['limit'])) $var['limit'] = 1;
	if(!isset($var['phone'])) $var['phone'] = 0;
	if(!isset($var['user_id'])) $var['user_id'] = 0;
	
	$q = "SELECT * FROM ".$DB2->prefix."zar WHERE type='".$var['type']."' ";//AND max_hits>=hits 
	if($var['user_id'] !=0 ) $q .= "AND user_id='".$var['user_id']."' ";
	if($var['phone'] !=0 ) $q .= "AND phone LIKE '".$var['phone']."' ";
	if($var['content'] !=0 ) $q .= "AND content LIKE '".$var['content']."' ";
	//$q .= "ORDER BY ".$var['order_by']." ".$var['asc']." LIMIT ".$var['limit'];
	$q .= "ORDER BY hits ASC LIMIT ".$var['limit'];
	
	$r = $DB2->mbm_query($q);
	
	$buf = '';
	$buf .= '<div class="zarItemHorizontal">';
	
	$zar_ids = '';
	
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		$buf .= '<span style="padding-right:10px; padding-left:10px; border-right:1px solid #666;">';
		$buf .= mbmCleanUpHTML($DB2->mbm_result($r,$i,"content"));
		$buf .= ' <strong>Утас: '.$DB2->mbm_result($r,$i,"phone").'</strong>';
		$buf .= '</span>';
		$zar_ids .= "id='".$DB2->mbm_result($r,$i,"id")."' OR ";
	}	

	$buf .= '</div>';
	$zar_ids = rtrim($zar_ids,"OR ");
	$update_q = "UPDATE ".$DB2->prefix."zar SET hits=hits+1 WHERE ".$zar_ids;
	
	//$DB2->mbm_query($update_q);
	
	return $buf;
}
?>