<?	
	if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if($_SESSION['lev']<5){
		die("error");
	}
	
	$DB->mbm_query("DELETE FROM ".PREFIX."banners WHERE id='".$_GET['id']."'");
//	mbmResetMenuPos($_GET['menu_id']);
?>
<div align="center">
	<a href="index.php?module=banner&cmd=banner_list&menu_id=<?= $_GET['menu_id']?>"><?= $lang['success'][3]?></a>
</div>