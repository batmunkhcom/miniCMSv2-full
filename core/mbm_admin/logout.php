<?
	include_once("../config.php"); 
	include(ABS_DIR.INCLUDE_DIR."includes/common.php");
	foreach($_SESSION as $k=>$v){
		unset($_SESSION[$k]);
	}
	session_destroy();
	header("Location: admin.php");
?>