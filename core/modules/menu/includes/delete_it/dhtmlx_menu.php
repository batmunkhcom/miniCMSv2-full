<?
	function mbmDHTMLXmenuXML($var = array(
									'menu_id'=>0,
									'st'=>1,
									'lev'=> 0
									)){
									
		return "\t".'<tree id="0">'."\n".mbmDHTMLXmenuXMLtree($var)."\t".'</tree>'."\n";
		//return "\t".mbmDHTMLXmenuXMLtree($var)."\n";
	}
	
	function mbmDHTMLXmenuXMLtree($var = array(
									'menu_id'=>0,
									'st'=>1,
									'lev'=> 0
									)){
		global $DB,$DB2;
		
		$q = "SELECT * FROM ".PREFIX."menus WHERE menu_id='".$var['menu_id']."' ";
		$q .= "AND st='".$var['st']."' ";
		$q .= "AND lev<=".$var['lev']." ";
		$q .= "ORDER BY pos";
		
		$r = $DB->mbm_query($q);
		
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
			
			$sub_yes = $DB->mbm_check_field('menu_id',$DB->mbm_result($r,$i,"id"),'menus');
			
			$buf .= "\t\t".'<item 
						id = "'.$DB->mbm_result($r,$i,"id").'" 
						text = "'.$DB->mbm_result($r,$i,"name").'"
						im0 = "'.$DB->mbm_result($r,$i,"id").'a.gif" 
						im1 = "'.$DB->mbm_result($r,$i,"id").'b.gif" 
						im2 = "'.$DB->mbm_result($r,$i,"id").'c.gif" 
						child = "';
				if($sub_yes==1){
					$buf .= '1';
				}else{
					$buf .= '0';
				}
				$buf .= '" >';
			if($sub_yes==1){
				$var['menu_id'] = $DB->mbm_result($r,$i,"id");
				
				//$buf .= '<userdata name="url">guide.html</userdata>'."\n";
				
				$buf .= mbmDHTMLXmenuXMLtree($var);
			}
			$buf .= '</item>'."\n";
		}
		
		return $buf."\n";
	}
	
	function mbmDHTMLXmenuLoad(){
		
		$buf = '<div id="mbmDHTMLXmenu"></div><script>';
		$buf .= 'tree=new dhtmlXTreeObject("mbmDHTMLXmenu",200,400,0);'."\n";
		$buf .= 'tree.setXMLAutoLoading("xml.php?action=menu_dhtmlx");'."\n";
		$buf .= 'tree.loadXML("xml.php?action=menu_dhtmlx");'."\n";
		//$buf .= 'loadTree();'."\n";
		$buf .= '</script>'."\n";
		
		return $buf;
	}
?>