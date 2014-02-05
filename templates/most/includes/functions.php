<?

//v0,0,0,1
function mbmDropDownMenus2($menu_id=0){
	global $DB;
	if(!isset($_SESSION['mmmID'])){
		$_SESSION['mmmID'] = $menu_id;
	}
	
	$buf_s = '<div ';
	$buf_s .= ' id="menusDD"';
	$buf_s .= '>';

	$buf_e = '</div>';
	$buf = '';
	
	$q = "SELECT * FROM ".PREFIX."menus WHERE st='1' AND lev<='".$_SESSION['lev']."' AND lang='".$_SESSION['ln']."' ";
	$q .= "AND menu_id = '".$menu_id."' ";
	$q .= "ORDER BY pos";
	
	$r = $DB->mbm_query($q);
	$menus_total = $DB->mbm_num_rows($r);
	
	for($i=0;$i<$menus_total;$i++){
		$buf .= '<div class="menusDD" ';
			if($_SESSION['mmmID'] == $menu_id){
				$buf .= 'id="Menu'.$i.'"';
			}
		$buf .= '>';
		$buf .= '<a href="'.mbmMenuLink($DB->mbm_result($r,$i,"id"),$DB->mbm_result($r,$i,"link")).'">';
			$buf .= $DB->mbm_result($r,$i,"name");
		$buf .= '</a>';
		if($DB->mbm_check_field("menu_id",$DB->mbm_result($r,$i,"id"),"menus") == 1){
			$buf .= '<div class="menusDDsub" id="subMenu'.$i.'">';
			$buf .= '<div class="menusDDsubHeader"></div>';
			$buf .= '<div class="menusDDsubContent">';
				$buf .= mbmDropDownMenus2($DB->mbm_result($r,$i,"id"));
				$buf .= '<br clear="all" />';
				$buf .= '</div>';
				$buf .= '<div class="menusDDsubFooter"></div>';
			$buf .= '</div>';
		}
		$buf .= '</div>';
	}
	return $buf_s.$buf.$buf_e;
}

?>