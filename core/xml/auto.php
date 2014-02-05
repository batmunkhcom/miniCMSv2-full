<?
switch($_GET['type']){
	case 'autocomplete':
		
		switch($_GET['list_type']){
			case 'firms':
				$q_firms_autocomplete = "SELECT name FROM ".$DB->prefix."auto_firms WHERE name LIKE '%".addslashes($_GET['q'])."%' AND country = '".(addslashes($_GET['country']))."' GROUP BY name ORDER BY name";
				$r_firms_autocomplete = $DB->mbm_query($q_firms_autocomplete);
				
				for($i=0;$i<$DB->mbm_num_rows($r_firms_autocomplete);$i++){
					$txt .= '<div onclick="';
					$txt .= 'document.getElementById(\'firm\').value=\''.$DB->mbm_result($r_firms_autocomplete,$i,"name").'\'';
					$txt .= '" >';
					$txt .=  $DB->mbm_result($r_firms_autocomplete,$i,"name");
					$txt .= '</div>';
				}
				if($DB->mbm_num_rows($r_firms_autocomplete) == 0){
					$txt .= $lang['main']['no_content'];
				}
			break;
			case 'marks':
				$q_marks_autocomplete = "SELECT name FROM ".$DB->prefix."auto_marks WHERE name LIKE '%".addslashes($_GET['q'])."%' AND tags LIKE '%".(addslashes($_GET['firm']))."%' GROUP BY name ORDER BY name";
				$r_marks_autocomplete = $DB->mbm_query($q_marks_autocomplete);
				
				for($i=0;$i<$DB->mbm_num_rows($r_marks_autocomplete);$i++){
					$txt .= '<div onclick="';
					$txt .= 'document.getElementById(\'mark\').value=\''.$DB->mbm_result($r_marks_autocomplete,$i,"name").'\'';
					$txt .= '" >';
					$txt .=  $DB->mbm_result($r_marks_autocomplete,$i,"name");
					$txt .= '</div>';
				}
				if($DB->mbm_num_rows($r_marks_autocomplete) == 0){
					$txt .= $lang['main']['no_content'];
				}
			break;
			default:
			break;
		}
	break;
}
?>