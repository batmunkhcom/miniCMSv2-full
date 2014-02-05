<?
switch($_GET['type']){
	case 'flvduration':
		$file = ($_GET['f']);
		$duration = mbmGetFLVDuration(ABS_DIR.$file);
		$txt .= "\n\t<file duration='".$duration."' />";
	break;
	case 'content_photo':
		
		$q_fileinfo = "SELECT * FROM ".PREFIX."menu_photos WHERE id='".$_GET['id']."'";
		$r_fileinfo = $DB->mbm_query($q_fileinfo);
		
		
		exit;
		$txt .= "\n\t<file duration='".DOMAIN.DIR.$DB->mbm_get_field($_GET['id'],'id','url','menu_photos')."' />";
		
	break;
}
?>