<?
function mbmPhotoGalleryCategories($htmls=array(0=>'',1=>'',2=>'',3=>''),$st=1,$private=0,$user_upload=0,$limit=1,$user_id=0,$order_by='id',$asc='desc'){
	global $DB;
	$q = "SELECT * FROM ".PREFIX."galleries WHERE id!=0 ";
	if($st<2){
		$q .= "AND st='".$st."' ";
	}
	if($private<2){
		$q .= "AND private='".$private."' ";
	}
	if($user_upload<2){
		$q .= "AND user_upload = '".$user_upload."' ";
	}
	if($user_id!=0){
		$q .= "AND user_id = '".$user_id."' ";
	}
	$q .= "ORDER BY ".$order_by." ".$asc." LIMIT ".$limit;
	$r = $DB->mbm_query($q);
	if($DB->mbm_num_rows($r)>0){
		$buf = $htmls[0];
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
			$buf .= $htmls[2];
			$buf .= '<a href="index.php?module=photogallery&cmd=cats&cat_id='.$DB->mbm_result($r,$i,"id")
					.'" title="'.$DB->mbm_result($r,$i,"comment").'">'
					.$DB->mbm_result($r,$i,"name").'</a>'; 
			$buf .= $htmls[3];
		}
		$buf .= $htmls[1];
	}else{
		$buf = '';
	}
	
	return $buf;
}
function mbmPhotosByGalleryId($gallery_id=0,$cols=3,$limit=10,$st=1,$private=0,$order_by='id',$asc='ASC',$user_id=0,$show_name = 0,$width=PHOTOGALLERY_THUMBNAIL_WIDTH,$height=100){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."gallery_files WHERE id!=0 ";
	if($gallery_id!=0){
		$q .= "AND gallery_id='".$gallery_id."' ";
	}
	if($private<2){
		$q .= "AND private='".$private."' ";
	}
	if($st<2){
		$q .= "AND st='".$st."' ";
	}
	if($user_id!=0){
		$q .= "AND user_id='".$user_id."' ";
	}
	$q .= "ORDER BY ".$order_by." ".$asc;
	
	$r = $DB->mbm_query($q);
	if($DB->mbm_num_rows($r)>0){
		if($limit>$DB->mbm_num_rows($r)){
			$limit = $DB->mbm_num_rows($r);
		}
		$tmp_ids = array();
		$buf = '<table width="100%" cellspacing="2" cellpadding="3" border="0">';
		$buf .= '<tr>';
		for($i=0;$i<$limit;$i++){
			$tmp_ids[] = $DB->mbm_result($r,$i,"id");
			$buf .= '<td valign="top" align="center">';
				$buf .= '<a href="index.php?module=photogallery&cmd=photo&id='.$DB->mbm_result($r,$i,"id").'">';
				$buf .= '<img src="img.php?type='.$DB->mbm_result($r,$i,"filetype")
						.'&w='.$width
						.'&h='.$height
						.'&f='.base64_encode($DB->mbm_result($r,$i,"url"))
						.'" border="0" alt="'.$DB->mbm_result($r,$i,"comment").'" />';
				if($show_name==1){
					$buf .= '<br />';
					$buf .= $DB->mbm_result($r,$i,"name");
				}
				$buf .= '</a>';
			$buf .= '</td>';
			if((($i+1)%$cols)==0){
				$buf .= '</tr>';
				$buf .= '<tr>';
			}
		}
		$buf .= '</tr>';
		$buf .= '</table>';
		$q_update_views = "UPDATE ".PREFIX."gallery_files SET views=views+1 WHERE ";
		foreach($tmp_ids as $kk=>$vv){
			$q_update_views .= "id='".$vv."' OR ";
		}
		$q_update_views = rtrim($q_update_views,"OR ");
		$r_update_views = $DB->mbm_query($q_update_views);
	}else{
		$buf = '';
	}
	return $buf;
}
function mbmPhotoGalleryCategoriesDropDown($st=1,$private=0,$user_upload=0,$limit=1,$user_id=0,$order_by='id',$asc='desc'){
	global $DB;
	$q = "SELECT * FROM ".PREFIX."galleries WHERE id!=0 ";
	if($st<2){
		$q .= "AND st='".$st."' ";
	}
	if($private<2){
		$q .= "AND private='".$private."' ";
	}
	if($user_upload<2){
		$q .= "AND user_upload = '".$user_upload."' ";
	}
	if($user_id!=0){
		$q .= "AND user_id = '".$user_id."' ";
	}
	$q .= "ORDER BY ".$order_by." ".$asc." LIMIT ".$limit;
	$r = $DB->mbm_query($q);
	if($DB->mbm_num_rows($r)>0){
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
			$buf .= '<option value="'.$DB->mbm_result($r,$i,"id").'">';
			$buf .= $DB->mbm_result($r,$i,"name"); 
			$buf .= '</option>';
		}
	}else{
		$buf = '';
	}
	
	return $buf;
}
?>