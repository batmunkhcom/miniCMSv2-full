<?
switch($_GET['type']){
	case 'contentPhotoDetail':
		$p_id = addslashes($_POST['id']);
		$q_photo_detail = "SELECT * FROM ".PREFIX."menu_photos WHERE id='".$p_id."'";
		$r_photo_detail = $DB->mbm_query($q_photo_detail);
		if($DB->mbm_num_rows($r_photo_detail)==1){
			$txt11 .= '<script>$("#lightbox-image-details-caption").html("<strong>'
																	  	.addslashes($DB->mbm_result($r_photo_detail,0,"title")).'</strong>: 
													<span style=\"font-weight:normal;\">'.addslashes($DB->mbm_result($r_photo_detail,0,"comment")).'</span>");</script>';
			$txt .= '<div style="float:right;">'
						.$DB->mbm_result($r_photo_detail,0,"comment")
						.'<br />'
						.'<div >'
						//.mbmRatingSmall('contentPhotoT'.$DB->mbm_result($r_photo_detail,0,"id"))
						.mbmRating('contentPHoto_'.$DB->mbm_result($r_photo_detail,0,"id"))
						.'</div>'
					.'</div>';
			$txt .= '<div style="float:left;">'.$lang["menu"]["content_added_by"].': '.$DB2->mbm_get_field($DB->mbm_result($r_photo_detail,0,"user_id"),'id','username','users').'<br />';
			$txt .= $lang['menu']['filename'].': '.str_replace(PHOTO_DIR,"",$DB->mbm_result($r_photo_detail,0,"url")).'<br />';
			$txt .= $lang['menu']['image_width'].': '.$DB->mbm_result($r_photo_detail,0,"width").'px<br />';
			$txt .= $lang['menu']['image_height'].': '.$DB->mbm_result($r_photo_detail,0,"height").'px<br />';
			$txt .= $lang['menu']['filesize'].': '.mbmFileSizeMB($DB->mbm_result($r_photo_detail,0,"filesize"),"KB").'<br />';
			$txt .= $lang['menu']['filetype'].': '.strtoupper($DB->mbm_result($r_photo_detail,0,"filetype")).'<br />';
			$txt .= $lang['menu']['file_downloaded'].': '.$DB->mbm_result($r_photo_detail,0,"downloaded").'<br />';
			$txt .= $lang['menu']['filehits'].': '.$DB->mbm_result($r_photo_detail,0,"hits").'<br />';
			$txt .= $lang['menu']['file_date_added'].': '.date("Y/m/d",$DB->mbm_result($r_photo_detail,0,"date_added")).'<br />';
			$txt .= '</div>';
			$DB->mbm_query("UPDATE ".PREFIX."menu_photos SET hits=hits+".HITS_BY." WHERE id='".$p_id."'");
		}else{
			$txt .=''.$lang['main']['no_content'].'...';
		}
	break;
}
$txt .= '';
?>