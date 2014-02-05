<?
function mbmAutoFirms($vars = array(
									'order_by'=>'name',
									'html_0'=>'',
									'html_1'=>'',
									'class'=>'makers'
									)){
	global $DB;
	
	$q = "SELECT * FROM ".$DB->prefix."auto_firms ";
	
	if($vars['order_by']!=''){
		$q .= "ORDER BY ".$vars['order_by'];
	}
	
	$r = $DB->mbm_query($q);
	
	$buf = '';
	
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= $vars['html_0'];
			$buf .= '<a href="#" class="'.$vars['class'].'">';
			$buf .= $DB->mbm_result($r,$i,"name");
			$buf .= '</a>';
		$buf .= $vars['html_1'];
	}
	
	$buf .= '';
	
	return $buf;
}
?>