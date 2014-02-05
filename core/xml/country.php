<?
switch($_GET['type']){
	case 'autocomplete':
		$q_country_autocomplete = "SELECT name FROM ".$DB2->prefix."ip2country WHERE name LIKE '%".addslashes($_GET['q'])."%' AND name!='' GROUP BY name ORDER BY name";
		$r_country_autocomplete = $DB2->mbm_query($q_country_autocomplete);
		
		for($i=0;$i<$DB2->mbm_num_rows($r_country_autocomplete);$i++){
			$txt .= '<div onclick="';
			//$txt .= '$(\'input[name=country]\')=\'aaaaaa\';';
			$txt .= 'document.getElementById(\'country\').value=\''.$DB2->mbm_result($r_country_autocomplete,$i,"name").'\'';
			$txt .= '" class="countryCom">';
			//$res[$i] = $DB2->mbm_result($r_country_autocomplete,$i,"name");//."|".$DB2->mbm_result($r_country_autocomplete,$i,"name")."\n";
			$txt .=  $DB2->mbm_result($r_country_autocomplete,$i,"name");
			$txt .= '</div>';
		}
		if($DB->mbm_num_rows($r_country_autocomplete) == 0){
			$txt .= $lang['main']['no_content'];
		}
		//$txt .= json_encode($res);
	break;
}
?>