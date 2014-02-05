<?
function mbmCompanyCategories($order_by='name'){
	global $DB;
	
	$q = "SELECT * FROM ".$DB->prefix."company_categories ORDER BY ".$order_by;
	$r = $DB->mbm_query($q);
	$categories = array();
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$categories[$DB->mbm_result($r,$i,"id")] = $DB->mbm_result($r,$i,"name");
	}
	
	return $categories;
}
function mbmCompanyServices($order_by='name'){
	global $DB;
	
	$q = "SELECT * FROM ".$DB->prefix."services ORDER BY ".$order_by;
	$r = $DB->mbm_query($q);
	$services = array();
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$services[$DB->mbm_result($r,$i,"id")] = $DB->mbm_result($r,$i,"name");
	}
	
	return $services;
}
?>