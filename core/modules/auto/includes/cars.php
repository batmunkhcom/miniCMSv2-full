<?
function mbmAutoCars($var = array(
								  'tags'=>'tag1,tag2',
								  'limit'=>5,
								  'order_by'=>'date_added',
								  'asc'=>'DESC'
								  )){
	global $DB;
	
	$buf = '<div id="autoCarsList">';
	$tags = '';
	
	$tags_prepare = explode(",",$var['tags']);
	if(count($tags_prepare)>0){
		foreach($tags_prepare as $k=>$v){
			$tags .= " tags LIKE '%".$v."%' OR";
		}
		$tags = rtrim($tags," OR");
	}else{
		$tags = $var['tags'];
	}
	
	$q = "SELECT * FROM ".PREFIX."auto_cars WHERE st='1' AND lev<='".$_SESSION['lev']."' ";
	if($var['tags']!=''){
		$q .= "AND (".$tags.") ";
	}
	
	$q .= "ORDER BY ";
	
	if(isset($var['order_by'])){
		$q .= $var['order_by']." ";
	}else{
		$q .= "date_added ";
	}
	if(isset($var['asc'])){
		$q .= $var['asc']." ";
	}else{
		$q .= "DESC ";
	}
	
	$q .= "LIMIT "; 
	
	if(isset($var['limit'])){
		$q .= "".$var['limit'];
	}else{
		$q .= " 5 ";
	}
	$r = $DB->mbm_query($q);
	
	$buf .= '<ul>';
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<li>'
					  .'<a href="'.DOMAIN.DIR.'index.php?module=auto&amp;cmd=details&id='.$DB->mbm_result($r,$i,"id").'">'
					  .mbmAutoGetCarThumb(
									  array(
											'car_id'=>$DB->mbm_result($r,$i,"id")
											)
									 )
					  .$DB->mbm_result($r,$i,"model")
					  .' ('.$DB->mbm_result($r,$i,"price").' '.$DB->mbm_result($r,$i,"currency").')'
					  .'</a>'
					  //.'<br />'.mbm_substr($DB->mbm_result($r,$i,"tags"),20)
					  .'</li>';
	}
	$buf .= '</ul>';
	
	$buf .= '</div>';
	
	return $buf;
}

function mbmAutoGetCarThumb($var = array(
									 'car_id'=>0
									 )){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."auto_car_photos WHERE car_id='".$var['car_id']."' ORDER BY RAND() LIMIT 1";
	$r = $DB->mbm_query($q);
	
	$buf = '';
	if($DB->mbm_num_rows($r) == 1){
		$buf_filepath = DOMAIN.DIR.'img.php?type='.$DB->mbm_result($r,0,"filetype").'&f='.base64_encode($DB->mbm_result($r,0,"url"));
	}else{
		$buf_filepath = DOMAIN.DIR.'img.php?type=gif&f='.base64_encode(INCLUDE_DOMAIN.'images/no_image.gif');
	}
		$buf .= '<img alt="'.$var['car_id'].'" src="'.$buf_filepath.'&w=100&h=100" class="carThumb" />';
	$buf .= '';
	
	return $buf;
}

function mbmAutoCarInfo($var = array(
									 'car_id'=>0
									 )){
	global $DB,$lang;
	
	$q = "SELECT * FROM ".PREFIX."auto_cars WHERE id='".$var['car_id']."' AND st='1' AND lev<='".$_SESSION['lev']."'";
	$r = $DB->mbm_query($q);
	
	$buf = '';
	
	if($DB->mbm_num_rows($r) == 1){
		$buf .= '<h2>'.$DB->mbm_result($r,0,"model").'</h2>';
		$buf .= '<div id="autoCarInfo">';
		$buf .= '<ul>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["main"]["country"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"country");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["firm"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_get_field($DB->mbm_result($r,0,"firm_id"),'id','name','auto_firms');
			$buf .= '</li>';
				
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["mark"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_get_field($DB->mbm_result($r,0,"mark_id"),'id','name','auto_marks');
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["model"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"model");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["date_made"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"date_made");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["date_imported"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"date_imported");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["car_doors"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"doors");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["car_color"].':';
				$buf .= '</span>';
				$buf .= $lang["auto"]["color"][$DB->mbm_result($r,0,"color")];
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["car_seats"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"seats");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["car_quality"].':';
				$buf .= '</span>';
				$buf .= $lang["auto"]["quality"][$DB->mbm_result($r,0,"quality")];
			$buf .= '</li>';
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["car_steering"].':';
				$buf .= '</span>';
				$buf .= $lang["auto"]["steering"][$DB->mbm_result($r,0,"steering")];
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["car_abs"].':';
				$buf .= '</span>';
				$buf .= $lang["auto"]["abs"][$DB->mbm_result($r,0,"abs")];
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["car_fuel"].':';
				$buf .= '</span>';
				$buf .= $lang["auto"]["fuel"][$DB->mbm_result($r,0,"fuel")];
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["cylinders"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"cylinders");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["mileage"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"mileage");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["engine"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"engine");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["car_transmission"].':';
				$buf .= '</span>';
				$buf .= $lang["auto"]["transmission"][$DB->mbm_result($r,0,"transmission")];
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["auto"]["fuel_in100km"].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"fuel_in100km");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang["main"]["date_added"].':';
				$buf .= '</span>';
				$buf .= date("Y/m/d",$DB->mbm_result($r,0,"date_added"));
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang['main']['hits'].':';
				$buf .= '</span>';
				$buf .= $DB->mbm_result($r,0,"hits");
			$buf .= '</li>';
			
			$buf .= '<li>';
				$buf .= '<span>';
					$buf .= $lang['main']['last_viewed'].':';
				$buf .= '</span>';
				$buf .= mbmTimeConverter($DB->mbm_result($r,0,"session_time"));
			$buf .= '</li>';
	
		$buf .= '</ul>';
		$buf .= '</div>';
		$buf .= '<br clear="both" />';
		
		$buf .= mbmAutoCarPhotosLightbox(array(
									 'car_id'=>$var['car_id']
									 ));
		
		$buf .= mbmAutoCarOwner(array(
									 'car_id'=>$var['car_id']
									 ));
		$buf .= '<br clear="both" />';
		$buf .= '<div id="autoCarContentShort">';
				$buf .= $DB->mbm_result($r,0,"content_short");
		$buf .= '</div><br clear="both" />';
		$buf .= '<div id="autoCarContentMore">';
				$buf .= $DB->mbm_result($r,0,"content_more");
		$buf .= '</div>';
		$buf .= '';
		$DB->mbm_query("UPDATE ".PREFIX."auto_cars SET hits=hits+".HITS_BY.",session_time='".mbmTime()."' WHERE id='".$var['car_id']."'");
	}else{
		$buf = $lang['main']['no_content'];
	}
	
	
	return $buf;
}

function mbmAutoCarPhotos($var = array(
									 'car_id'=>0
									 )){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."auto_car_photos WHERE car_id='".$var['car_id']."' ORDER BY id";
	$r = $DB->mbm_query($q);
	
	$buf = '<div id="autoCarPhotos">';
	$buf .= '<div id="autoCarBigPhoto"></div>';
		$buf .= '<ul id="autoCarPhotosContent">';
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
			$buf .= '<li class="autoCarPhotosImage">';
				
				$buf .= '<span>'.($i+1).'</span>';
				
				$buf_filepath = DOMAIN.DIR.'img.php?type='.$DB->mbm_result($r,$i,"filetype").'&f='.base64_encode($DB->mbm_result($r,$i,"url")).'&w=500';
				$buf_filepath_thumb = DOMAIN.DIR.'img.php?type='.$DB->mbm_result($r,$i,"filetype").'&f='.base64_encode($DB->mbm_result($r,$i,"url"))."&amp;w=80&amp;h=80";
				$buf .= '<img alt="'.$var['car_id'].'" src="'.$buf_filepath_thumb.'" class="autoCarPhoto" bigPhotoUrl="'.$buf_filepath.'"  />';
			$buf .= '</li>';
		}
		$buf .= '</ul>';
	$buf .= '</div>';
	
	$buf .= '<script>
			</script>';
	
	return $buf;
}


function mbmAutoCarPhotosLightbox($var = array(
									 'car_id'=>0
									 )){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."auto_car_photos WHERE car_id='".$var['car_id']."' ORDER BY id";
	$r = $DB->mbm_query($q);
	
	$buf = '<div id="autoCarPhotosLightbox">';
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
				$buf_filepath = DOMAIN.DIR.'img.php?type='.$DB->mbm_result($r,$i,"filetype").'&f='.base64_encode($DB->mbm_result($r,$i,"url")).'&w=500';
				$buf_filepath_thumb = DOMAIN.DIR.'img.php?type='.$DB->mbm_result($r,$i,"filetype").'&f='.base64_encode($DB->mbm_result($r,$i,"url"))."&w=80&amp;h=80";
				
				$buf .= '<a href="'.$buf_filepath.'" downloadUrl="'.$buf_filepath.'">';
				$buf .= '<img alt="'.$var['car_id'].'" src="'.$buf_filepath_thumb.'" class="autoCarPhoto"  />';
				$buf .= '</a>';
		}
	$buf .= '</div>';
	
	return $buf;
}

function mbmAutoCarOwner($var = array(
									 'car_id'=>0
									 )){
	global $DB,$lang;
	
	$q = "SELECT * FROM ".PREFIX."auto_car_info WHERE car_id='".$var['car_id']."' ORDER BY id ";
	$r = $DB->mbm_query($q);
	
	$buf = '<div id="autoCarOwner">';
	$buf .= '<span>';
		$buf .= $lang["auto"]["seller_info"].':';
	$buf .= '</span>';
	
	if($DB->mbm_num_rows($r)>0){
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
			$buf .= '<ul>';
				$buf .= '<li>';
					$buf .= '<span>';
						$buf .= $lang["auto"]["seller_name"].':';
					$buf .= '</span>';
					$buf .= $DB->mbm_result($r,$i,"name");
				$buf .= '</li>';
				$buf .= '<li>';
					$buf .= '<span>';
						$buf .= $lang["auto"]["seller_phone"].':';
					$buf .= '</span>';
					$buf .= $DB->mbm_result($r,$i,"phone");
				$buf .= '</li>';
				$buf .= '<li>';
					$buf .= '<span>';
						$buf .= $lang["auto"]["seller_email"].':';
					$buf .= '</span>';
					$buf .= $DB->mbm_result($r,$i,"email");
				$buf .= '</li>';
				$buf .= '<li>';
					$buf .= '<span>';
						$buf .= $lang["auto"]["seller_comment"].':';
					$buf .= '</span>';
					$buf .= $DB->mbm_result($r,$i,"comment");
				$buf .= '</li>';
			$buf .= '</ul>';
		}
	}else{
		$buf = '';
	}
	$buf .= '</div>';
	return $buf;
	
}
?>