<?
	function mbmShoppingCatOptions($cat_id=0){
		global $DB;
		static $buf = '';
		$q = "SELECT * FROM ".PREFIX."shop_cats WHERE shop_cat_id='".$cat_id."' AND lang='".$_SESSION['ln']."' ORDER BY pos";
		$r = $DB->mbm_query($q);
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
			$buf .= '<option value="'.$DB->mbm_result($r,$i,"id").'">';
				$buf .= str_repeat("-",($DB->mbm_result($r,$i,"sub")*5));
				$buf .= $DB->mbm_result($r,$i,"name");
			$buf .= '</option>';
			if($DB->mbm_check_field('shop_cat_id',$DB->mbm_result($r,$i,"id"),'shop_cats')==1){
				mbmShoppingCatOptions($DB->mbm_result($r,$i,"id"));
			}
		}
		return $buf;
	}
?>