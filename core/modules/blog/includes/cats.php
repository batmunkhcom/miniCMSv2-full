<?
function mbmBlogCategoryRec($c_id){
	global $DB, $Mas;
	
	if($c_id !=0){
		$q = "SELECT * FROM ".PREFIX."blog_cats WHERE st=1 AND id='".$c_id."'";
		$r = $DB->mbm_query($q);
		$Mas[$DB->mbm_result($r,0,"id")]= 1;
		mbmBlogCategoryRec($DB->mbm_result($r,$i,"cat_id"));
	}
}

function mbmBlogCategoryDesc($cid, $c_id){
	global $DB, $Mas;

	for($i=0; $i<99999; $i++){
		$Mas[$i]= 0;
	}
	$q = "SELECT * FROM ".PREFIX."blog_cats WHERE st=1 AND cat_id=0 OR cat_id='".$c_id."' ORDER BY pos";
	$r = $DB->mbm_query($q);
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$Mas[$DB->mbm_result($r,$i,"id")]= 1;
	}
	mbmBlogCategoryRec($c_id);
}

function mbmBlogShowCategory2($b_id, $htmls,$cid,$c_id,$padding_left=10,$class='menu'){
	global $DB, $Mas, $bufferCat;
	$q_menu = "SELECT * FROM ".PREFIX."blog_cats WHERE cat_id='".$cid."' AND blog_id='".$b_id."'  ORDER BY pos";
	$r_menu = $DB->mbm_query($q_menu);
	//if($DB->mbm_num_rows($r_menu) != 0){
		for($i=0;$i<$DB->mbm_num_rows($r_menu);$i++){
			//if($Mas[$DB->mbm_result($r_menu,$i,"id")] == 1){
				$buf = $htmls[2];
				$buf .= '<span style="padding-left:'.($padding_left*$DB->mbm_result($r_menu,$i,"sub")).'px" ><a class="blog_cat_link" href="';
				if($DB->mbm_result($r_menu,$i,"link") =='http://' || $DB->mbm_result($r_menu,$i,"link") == '' || $DB->mbm_result($r_menu,$i,"link")==NULL){
					$url='blog.php?module=blog&cmd=content&blog_id='.$b_id.'&cat_id='.$DB->mbm_result($r_menu,$i,"id");
				}else{
					if(substr_count($DB->mbm_result($r_menu,$i,"link"),"?")>0){
						$d='&';
					}else{
						$d='?';
					}
					$url = 'blog.php?redirect='.base64_encode($DB->mbm_result($r_menu,$i,"link").$d."cid=".$DB->mbm_result($r_menu,$i,"id"));
				}	
				$buf .= $url.'" title="'.$DB->mbm_result($r_menu,$i,"comment").'" class="'.$class.'" target="'.$DB->mbm_result($r_menu,$i,"target").'">'.$DB->mbm_result($r_menu,$i,"title").'</a></span>';
				$buf .=$htmls[3];
				$bufferCat .= $buf;
				//mbmBlogShowCategory2($htmls, $DB->mbm_result($r_menu,$i,"id"),$c_id,10, 'blog_cats');
			//}
		//}
	}
	return true;
}

function mbmBlogShowCategory($b_id, $htmls,$cat_id,$c_id,$padding_left=15,$class='blog_cats'){
	
	global $bufferCat;
	
	if($htmls[0]){
		$bufferCat = $htmls[0];
		$bufferCat .= $htmls[4];
		$bufferCat .= $htmls[5];
	}
	
	
	//mbmBlogCategoryDesc($cat_id, $c_id);
	mbmBlogShowCategory2($b_id, $htmls, $cat_id,$c_id,10,'blog_cats');
	
	if($htmls[1]){
		$bufferCat .= $htmls[1];
	}
	return $bufferCat;
}
?>
