<?
	unset($_GET['mBm'],$_POST['mBm'],$_SESSION['mBm'],$_REQUEST['mBm']);
	$mBm=1;
	
	unset($_GET['PHPSESSID']);
	require_once("../../config.php");
	include(ABS_DIR.INCLUDE_DIR."/includes/common.php");
	
	mbm_include(INCLUDE_DIR."classes",'php');
	mbm_include(INCLUDE_DIR."functions_php",'php');
	require_once(ABS_DIR.INCLUDE_DIR."includes/settings.php");
	
	
function mbmLoadJpeg($imgname) 
{
   $im = @imagecreatefromjpeg($imgname); /* Attempt to open */
   if (!$im) { /* See if it failed */
       $im  = imagecreatruecolor(150, 30); /* Create a blank image */
       $bgc = imagecolorallocate($im, 255, 255, 255);
       $tc  = imagecolorallocate($im, 0, 0, 0);
       imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
       /* Output an errmsg */
       imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
   }
   return $im;
}
if(isset($_GET['id']) && $_GET['id']!=''){
	$q_avatar_show = "SELECT name, filetype, size, content " .
			 "FROM ".USER_DB_PREFIX."user_avatars WHERE id='".$_GET['id']."'";

}elseif(isset($_GET['uid']) && $_GET['uid']!=''){
	$q_avatar_show = "SELECT name, filetype, size, content " .
			 "FROM ".USER_DB_PREFIX."user_avatars WHERE user_id='".$_GET['uid']."' LIMIT 1";

}
$r_avatar_show = $DB2->mbm_query($q_avatar_show );
if($DB2->mbm_num_rows($r_avatar_show)==1){
	list($name, $type, $size, $content) =  mysql_fetch_array($r_avatar_show);
	header("Content-length: $size");
	header("Content-type: image/$type");
	//header("Content-Disposition: attachment; filename=$name");
	echo $content;
}else{
	header("Content-type: image/jpeg");
	imagejpeg(mbmLoadJpeg(ABS_DIR.'images/user_avatars/tmp.jpg'));
}
exit;
?>