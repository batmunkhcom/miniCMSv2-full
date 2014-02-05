<?
function mbmShoppingShowCats($htmls=array(0=>'',1=>'',2=>'',3=>''),$cat_id=0,$padding_left=15,$classname=''){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."shop_cats WHERE id!=0 ";
	if($cat_id!=0){
		$q .= "AND shop_cat_id='".$cat_id."' ";
	}
	$q .= "ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	$buf .= $htmls[0];
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= $htmls[2];
			$buf .= '<a href="'.DOMAIN.DIR.'index.php?module=shopping&cmd=products&cat_id='.$DB->mbm_result($r,$i,"id").'" class="'.$classname.'">';
				$buf .= $DB->mbm_result($r,$i,"name");
			$buf .= '</a>';
		$buf .= $htmls[3];
		if($cat_id!=0 && $DB->mbm_check_field('shop_cat_id',$cat_id,'shop_cats')==1 && $_GET['cat_id']==$DB->mbm_result($r,$i,"id")){
			$buf .= mbmShoppingShowCats($htmls,$DB->mbm_result($r,$i,"id"),$padding_left,$classname);
		}
	}
	$buf .= $htmls[1];
	
	return $buf;
}
function mbmShoppingCat1($cat_id=0){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."shop_cats WHERE shop_cat_id='".$cat_id."' ";
	$q .= "ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<div class="catid1" onclick="mbmToggleDisplay(\'subCat_'.$i.'\')">';
				$buf .= $DB->mbm_result($r,$i,"name");
		$buf .= '</div>';
		
		$buf .= '<div id="subCat_'.$i.'" style="display:none;">';
		$q2 = "SELECT * FROM ".PREFIX."shop_cats WHERE shop_cat_id='".$DB->mbm_result($r,$i,"id")."' ";
		$q2 .= "ORDER BY pos";
		$r2 = $DB->mbm_query($q2);
		for($j=0;$j<$DB->mbm_num_rows($r2);$j++){
			$buf .= '<div id="catid2">';
				$buf .= '<a href="'.DOMAIN.DIR.'index.php?module=shopping&cmd=products&cat_id='.$DB->mbm_result($r2,$j,"id").'" class="catid2">';
				$buf .= $DB->mbm_result($r2,$j,"name").'</a>';
			$buf .= '</div>';
		}
		$buf .= '</div>';
	}
	return $buf;
}
function mbmShoppingSelectOneCatId($text=','){
	global $DB;
	$text = trim($text,',');
	$text = rtrim($text,',');
	$cats = explode(",",$text);
	
	return $cats[rand(0,(count($cats)-1))];
}

function mbmShoppingShowCatsUL($cat_id=0){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."shop_cats WHERE st='1' ";
	$q .= "AND shop_cat_id='".$cat_id."' ";
	$q .= "ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	//$buf .= '<ul>';
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<li>';
			$buf .= '<a href="'.DOMAIN.DIR.'index.php?module=shopping&cmd=products&cat_id='.$DB->mbm_result($r,$i,"id").'">';
				$buf .= $DB->mbm_result($r,$i,"name");
			$buf .= '</a>';
			if($DB->mbm_check_field('shop_cat_id',$cat_id,'shop_cats')==1){
				$buf .= mbmShoppingShowCatsUL($DB->mbm_result($r,$i,"id"));
			}
		$buf .= '</li>';
	}
	//$buf .= '</ul>';
	
	return '<ul>'.$buf.'</ul>';
}

function mbmShoppingSubCats($cat_id=0){
	global $DB;
	
	$q = "SELECT id FROM ".PREFIX."shop_cats WHERE shop_cat_id='".$cat_id."' AND st=1 ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	$buf = ',';
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= $DB->mbm_result($r,$i,"id").',';
	}
	
	return $buf;
}
function mbmShoppingSubCatsInArray($cat_id=0){
	global $DB;
	
	$q = "SELECT id,name FROM ".PREFIX."shop_cats WHERE shop_cat_id='".$cat_id."' AND st=1 ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	$buf = array();
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf[$DB->mbm_result($r,$i,"id")] = $DB->mbm_result($r,$i,"name").',';
	}
	
	return $buf;
}
function mbmGetUpperCatId($cat_id=0){
	global $DB;
	
	$upper_cat_id = $DB->mbm_get_field($cat_id,'id','shop_cat_id','shop_cats');
	if($DB->mbm_check_field('id',$cat_id,'shop_cats')==0){
		$return_id = 0;
	}elseif($upper_cat_id == 0){
		$return_id = $cat_id;
	}else{
		$return_id = mbmGetUpperCatId($upper_cat_id);
	}
	return $return_id;
}

function mbmShoppingCatBuildPath($cat_id){
	global $DB,$lang;
	static $sss='';
	$sss .= $cat_id.',';
	
	$upper_code = $DB->mbm_get_field($cat_id,"id","shop_cat_id","shop_cats");
	
	if($upper_code!='0'){
		mbmShoppingCatBuildPath($upper_code);
	}elseif(!isset($_GET['cat_id'])){
		return $lang['main']['home'];
	}
	$sss=rtrim($sss,",");
	$cat_ids = explode(",",$sss);
	
	if(is_array($cat_ids)){
		$cat_ids = array_reverse($cat_ids);
		foreach($cat_ids as $k =>$v){
			if($v!=0){
				$result .= '<a href="'.DOMAIN.DIR.'index.php?module=shopping&cmd=products&cat_id='.$v.'" title="'.$DB->mbm_get_field($v,"id","comment","shop_cats").'">';
				$result .= $DB->mbm_get_field($v,"id","name","shop_cats").'</a> &raquo; ';
			}
		}
	}else{
		$result = $shop_cats;
	}
	return '<a href="index.php" title="'.$lang['main']['home'].'" class="menuPath">'.$lang['main']['home'].'</a> &raquo; '.rtrim($result," &raquo; ");
}
?>