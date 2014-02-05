<?
function mbmBannerTypes($htmls=array(2=>'',3=>'')){
	$types = explode(",",BANNER_TYPES);
	$buf ='';
	foreach($types as $k=>$v){
		$buf .= $htmls[2];
			$buf .= $v;
		$buf .= $htmls[3];
	}
	return $buf;
}
?>