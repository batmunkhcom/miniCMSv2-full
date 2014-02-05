<?
function mbmWebCatsList($cat_id=0,$cols=2){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."web_cats WHERE cat_id='".$cat_id."' 
		 AND lang='".$_SESSION['ln']."' AND st=1 AND lev<='".$_SESSION['lev']."' ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	$buf = '<table cellpadding="3" cellspacing="2" width="100%" border="0">';
	$buf .= '<tr>';
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<td width="'.ceil(100/$cols).'%" valign="top">';
			$buf .= '<div id="webCats0">';
				$buf .= '<a href="index.php?module=web&cmd=web_links&cat_id='
					.$DB->mbm_result($r,$i,"id").'" class="webCats0_link">';
					$buf .= $DB->mbm_result($r,$i,"name");
				$buf .= '</a>';
			$buf .= '</div>';
			$q_subcats = "SELECT * FROM ".PREFIX."web_cats WHERE cat_id='".$DB->mbm_result($r,$i,"id")."' ORDER BY pos limit 6";
			$r_subcats = $DB->mbm_query($q_subcats);
			if($DB->mbm_num_rows($r_subcats)>5){
				$subcats = 5;
			}else{
				$subcats = $DB->mbm_num_rows($r_subcats);
			}
			$buf .= '<div id="webCats1">';
			for($j=0;$j<$subcats;$j++){
				$buf .= '<a href="index.php?module=web&cmd=web_links&cat_id='
					.$DB->mbm_result($r_subcats,$j,"id").'" class="webCats1_link">';
					$buf .= $DB->mbm_result($r_subcats,$j,"name");
				$buf .= '</a>'.', ';
			}
			$buf = rtrim($buf, ', ').'...';
			$buf .= '</div>';
			
		$buf .= '</td>';
		if((($i+1)%$cols)==0){
			$buf .= '</tr><tr>';
		}
	}
	$buf .= '</tr>';
	$buf .= '</table>';
	return $buf;
}
function mbmWebSubCatsList($cat_id=0,$cols=2){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."web_cats WHERE cat_id='".$cat_id."' 
		 AND lang='".$_SESSION['ln']."' AND st=1 AND lev<='".$_SESSION['lev']."' ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	$buf = '<table cellpadding="3" cellspacing="2" width="100%" border="0">';
	$buf .= '<tr>';
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<td width="'.ceil(100/$cols).'%" valign="top">';
			$buf .= '<div id="webCats0" >';
				$buf .= '<a href="index.php?module=web&cmd=web_links&cat_id='
						.$DB->mbm_result($r,$i,"id").'" class="webCats0_link">';
					$buf .= $DB->mbm_result($r,$i,"name");
				$buf .= '</a>';
			$buf .= '</div>';
			$q_web_links = "SELECT * FROM ".PREFIX."web_links WHERE cat_id='".$DB->mbm_result($r,$i,"id")."' ORDER BY RAND() LIMIT 3";
			$r_web_links = $DB->mbm_query($q_web_links);
			$buf .= '<div id="webCats1">';
			for($j=0;$j<$DB->mbm_num_rows($r_web_links);$j++){
				$buf .= '<a href="index.php?action=web&url='.(base64_encode($DB->mbm_result($r_web_links,$j,"url"))).''
						 .'&id='.$DB->mbm_result($r_web_links,$j,"id").'" class="webCats1_link">';
					$buf .= $DB->mbm_result($r_web_links,$j,"name");
				$buf .= '</a>'.', ';
			}
			$buf = rtrim($buf, ', ').'...';
			$buf .= '</div>';
			
		$buf .= '</td>';
		if((($i+1)%$cols)==0){
			$buf .= '</tr><tr>';
		}
	}
	$buf .= '</tr>';
	$buf .= '</table>';
	return $buf;
}
?>