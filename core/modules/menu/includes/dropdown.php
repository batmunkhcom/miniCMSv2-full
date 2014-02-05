<?

//v0,0,0,1
function mbmDropDownMenus2__($menu_id=0){
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

//v 0.0.2 -> use LI
function mbmDropDownMenus($menu_id=0){
	global $DB;
	static $k=0;
	
	$buf_s = '<ul ';
	switch($k){
		case 0:
			$buf_s .= ' class="dropdown"';
		break;
		case 1:
			$buf_s .= ' class="sub_menu"';
		break;
	}
	$buf_s .= '>';
	$buf_e = '</ul>';
	$buf = '';
	
	$q = "SELECT * FROM ".PREFIX."menus WHERE st='1' AND lev<='".$_SESSION['lev']."' AND lang='".$_SESSION['ln']."' ";
	$q .= "AND menu_id = '".$menu_id."' ";
	$q .= "ORDER BY pos";
	
	$r = $DB->mbm_query($q);
	
	$k++;
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<li>';
			$buf .= '<a href="'.mbmMenuLink($DB->mbm_result($r,$i,"id"),$DB->mbm_result($r,$i,"link")).'">';
				$buf .= $DB->mbm_result($r,$i,"name");
			$buf .= '</a>';
			if($DB->mbm_check_field("menu_id",$DB->mbm_result($r,$i,"id"),"menus") == 1){
				$buf .= mbmDropDownMenus($DB->mbm_result($r,$i,"id"));
			}
		$buf .= '</li>';
	}
	
	return $buf_s.$buf.$buf_e;
}



//v0.01
function mbmMenuDropDown($menu_id=0,$class='menu'){
	global $DB;
	
	$buf_header =  '<table border="0" class="dropDownTable" id="dropDownTable" cellspacing="0" cellpadding="0"><tr>';
	//$buf_header =  '<table class="dropDownTable" align="center" cellspacing="0" cellpadding="0"><tr>';
	$q_menu_header = "SELECT * FROM ".PREFIX."menus 
					WHERE menu_id='".$menu_id."' AND st=1 AND lev<='".$_SESSION['lev']."' 
					AND lang='".$_SESSION['ln']."' ORDER BY pos";
	$r_menu_header = $DB->mbm_query($q_menu_header);
	$menu_total = $DB->mbm_num_rows($r_menu_header);
	
	for($i=0;$i<$menu_total;$i++){
		$has_submenu = $DB->mbm_check_field('menu_id',$DB->mbm_result($r_menu_header,$i,"id"),'menus');
		
		//$buf_header .= '<td width="125" ';
		$menu_width= floor(100/$menu_total);
		$buf_header .= '<td width="'.$menu_width.'%" class="menupriavte'.$DB->mbm_result($r_menu,$i,"id").' ';
		if(MENU_ID == $DB->mbm_result($r_menu_header,$i,"id")){
			$buf_header .= 'dropdown_menu_selected';
		}else{
			$buf_header .= 'menu_dropdown';
		}
		$buf_header .= '" ';
		//if($has_submenu==1){
			$buf_header .= 'onmouseout="document.getElementById(\'dropDownComment\').innerHTML=\'\';" ';
			//if($DB->mbm_check_field('menu_id',$DB->mbm_result($r_menu_header,$i,"id"),'menus')==1){
				$buf_header .= 'onmouseover="mbmShowSub('.($i+1).');document.getElementById(\'dropDownComment\').innerHTML=\'';
				$buf_header .= addslashes($DB->mbm_result($r_menu_header,$i,"comment"));
				$buf_header .= '\'"';
			//}
		//}
		$buf_header .= ' >';
		$buf_header .= '<div style="position:relative;" id="submenu_main"><a href="'.mbmMenuLink($DB->mbm_result($r_menu_header,$i,"id"),$DB->mbm_result($r_menu_header,$i,"link")).'" title="';
		if($DB->mbm_result($r_menu_header,$i,"comment")==''){
			$buf_header .= $DB->mbm_result($r_menu_header,$i,"name");
		}else{
			$buf_header .= $DB->mbm_result($r_menu_header,$i,"comment");
		}
		$buf_header .= '" class="menupriavte'.$DB->mbm_result($r_menu,$i,"id").' ';
		if(MENU_ID == $DB->mbm_result($r_menu_header,$i,"id")){
			//$buf_header .= 'dropdown_menu_selected';
		}else{
		}
		$buf_header .= $class.$DB->mbm_result($r_menu_header,$i,"sub");
		$buf_header .= '" target="'.$DB->mbm_result($r_menu_header,$i,"target").'">'.$DB->mbm_result($r_menu_header,$i,"name");
		$buf_header .= '</a>';
		$buf_header .= mbmShowNewContentNotify();
			if($has_submenu==1){
				$buf_header .= '<div id="submenu'.($i+1).'" ';
				if($has_submenu==1){
					$buf_header .= 'class="menuprivate'.$DB->mbm_result($r_menu,$i,"id").' submenu" ';
				}
				$buf_header .= 'onmouseout="mbmToggleDisplay(\'submenu'.($i+1).'\');document.getElementById(\'dropDownComment\').innerHTML=\'';
					$buf_header .= addslashes($DB->mbm_result($r_menu_header,$i,"comment"));
					$buf_header .= '\'">';
					$buf_header .= mbmShowMenuById(array(0=>'<div id="submenu">',1=>'</div>'),$DB->mbm_result($r_menu_header,$i,"id"),'submenu_drop').'';
				$buf_header .= '</div>';
			}else{
				//$buf_header .= '<div style="padding:5px; font-weight:normal;" onmouseover="mbmShowSub('.($i+1).')">'
				//				.$DB->mbm_result($r_menu_header,$i,"comment");
				//$buf_header .= '</div>';
			}
		$buf_header .= '</div>';
		$buf_header .= '</td>';
	}
	
	$buf_header .= '</tr></table>';
	$buf_header .= '<script language="javascript" type="text/javascript">
					function mbmShowSub(id){
						for(i=1;i<='.$menu_total.';i++){
							if(document.getElementById(\'submenu\'+i)) document.getElementById(\'submenu\'+i).style.display=\'none\';
						}
						if(document.getElementById(\'submenu\'+id)) document.getElementById(\'submenu\'+id).style.display=\'block\';
					}
					</script>';
	return $buf_header;
}
?>