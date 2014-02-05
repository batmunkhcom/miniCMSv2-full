<?
switch($_GET['type']){
	case 'allalbums':
		$q_photoalbums = "SELECT * FROM ".PREFIX."galleries WHERE id!=0 ";
		if($_GET['st']<2){
			$q_photoalbums .= "AND st='".$_GET['st']."' ";
		}
		if($_GET['private']<2){
			$q_photoalbums .= "AND private='".$_GET['private']."' ";
		}
		$q_photoalbums .= " ORDER BY ";
		if(isset($_GET['order_by']) && $_GET['order_by']!=''){
			$q_photoalbums .= $_GET['order_by'];
		}else{
			$q_photoalbums .= "id";
		}
		$q_photoalbums .= " ".$_GET['asc']." ";
		$r_photoalbums = $DB->mbm_query($q_photoalbums);
		for($i=0;$i<$DB->mbm_num_rows($r_photoalbums);$i++){
			$txt .= "\t".'<album name="'.$DB->mbm_result($r_photoalbums,$i,'name').'">';
				
				$q_photos = "SELECT * FROM ".PREFIX."gallery_files WHERE gallery_id='".$DB->mbm_result($r_photoalbums,$i,'id')."' ORDER BY id";
				$r_photos = $DB->mbm_query($q_photos);
				for($j=0;$j<$DB->mbm_num_rows($r_photos);$j++){
					$txt .= "\t\t"
								.'<image info="'.$DB->mbm_result($r_photos,$j,'comment')
								.'" thumb_path="'.DOMAIN.DIR.'img.php?type='.$DB->mbm_result($r_photos,$j,'filetype').'&amp;w=64&amp;f='
								.base64_encode(DOMAIN.DIR.$DB->mbm_result($r_photos,$j,'url'))
								.'" big_path="'.DOMAIN.DIR.'img.php?type='.$DB->mbm_result($r_photos,$j,'filetype').'&amp;w=';
					if($DB->mbm_result($r_photos,$j,'width')<400){
						$txt .= $DB->mbm_result($r_photos,$j,'width');
					}else{
						$txt .= 400;
					}
					$txt .= '&amp;f='
								.base64_encode(DOMAIN.DIR.$DB->mbm_result($r_photos,$j,'url')).'"/>'
						 ."\n";
				}
				
			$txt .= "\t".'</album>';
		}
	break;
}
?>