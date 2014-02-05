<?  
function mbmShowBanner($type=''){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."banners 
				WHERE type='".$type."' 
				AND st=1 
				AND lev<='".$_SESSION['lev']."' 
				AND hits<=max_hits ";
	$q .= "ORDER BY RAND() LIMIT 1";
	$r = $DB->mbm_query($q);
	if($DB->mbm_num_rows($r)==0){
		$buf = '';
	}else{
		$buf = '<div title="'.addslashes($DB->mbm_result($r,0,'comment')).'" class="banner" ';
		if(strlen(str_replace("http://","",$DB->mbm_result($r,0,'link')))>10){
			$buf .= 'onclick="window.open(\'index.php?action=banner&amp;id='.$DB->mbm_result($r,0,'id')
				.'&amp;url='.base64_encode($DB->mbm_result($r,0,'link')).'\',\'banner\',\'scrollbars=1,toolbar=1,addressbar=1\')"';
		}
		$buf .= '>';
				$buf .= $DB->mbm_result($r,0,'content');
		$buf .='
				</div>';
		$DB->mbm_query("UPDATE ".PREFIX."banners SET hits=hits+".HITS_BY." WHERE id='".$DB->mbm_result($r,0,'id')."'");
	}
	return $buf;
}
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

function mbmShowBannerByMenu($type=''){
	global $DB;
	
	/*
		banner nemehdee ner talbart menu nii ID-g oruulj ugnu. tegsneer zzuvhun tuhain menu nii medeelliig uzehed garch irne
	*/
	
	$q = "SELECT * FROM ".PREFIX."banners 
				WHERE type='".$type."' AND name='".MENU_ID."' 
				AND st=1 
				AND lev<='".$_SESSION['lev']."' 
				AND hits<=max_hits "; 
	$q .= "ORDER BY RAND() LIMIT 1";
	$r = $DB->mbm_query($q);
	if($DB->mbm_num_rows($r)==0){
		$buf = '';
	}else{
		$buf = '<div title="'.addslashes($DB->mbm_result($r,0,'comment')).'" id="banner" ';
		if(strlen(str_replace("http://","",$DB->mbm_result($r,0,'link')))>10){
			$buf .= 'onclick="window.open(\'index.php?action=banner&amp;id='.$DB->mbm_result($r,0,'id')
				.'&amp;url='.base64_encode($DB->mbm_result($r,0,'link')).'\',\'banner\',\'scrollbars=1,toolbar=1,addressbar=1\')"';
		}
		$buf .= '>';
				$buf .= $DB->mbm_result($r,0,'content');
		$buf .='</div>';
		$DB->mbm_query("UPDATE ".PREFIX."banners SET hits=hits+".HITS_BY." WHERE id='".$DB->mbm_result($r,0,'id')."'");
	}
	return $buf;
}
?>
