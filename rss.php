<?
	error_reporting(E_ALL ^ E_NOTICE);
	unset($_GET['mBm'],$_POST['mBm'],$_SESSION['mBm'],$_REQUEST['mBm']);
	$mBm=1;
	unset($_GET['PHPSESSID']);
	require_once("config.php");
	
	if(isset($_GET['redirect'])){
		header("Location: ".base64_decode($_GET['redirect']));
	}
	include(ABS_DIR.INCLUDE_DIR."includes/common.php");

	mbm_include(INCLUDE_DIR."classes",'php');
	mbm_include(INCLUDE_DIR."functions_php",'php');
	require_once(ABS_DIR.INCLUDE_DIR."includes/settings.php");
	
	
	if(!isset($_SESSION['ln'])){
		$_SESSION['ln']=DEFAULT_LANG;
	}
	if(!isset($_SESSION['lev'])){
		$_SESSION['lev']=0;
	}
	foreach($modules_active as $module_k=>$module_v){
		require_once(ABS_DIR."modules/".$module_v."/index.php");
	}
	foreach($module_include_dir as $include_folders_k=>$include_folders_v){
		mbm_include($include_folders_v,'php');
	}
	
	include(ABS_DIR.INCLUDE_DIR."lang/".$_SESSION['ln']."/index.php");
	
	include_once(ABS_DIR.INCLUDE_DIR.'rss/header.php');
	if(file_exists(ABS_DIR.INCLUDE_DIR.'rss/'.$_GET['action'].'.php')){
		include_once(ABS_DIR.INCLUDE_DIR.'rss/'.$_GET['action'].'.php');
	}else{
		include_once(ABS_DIR.INCLUDE_DIR.'rss/default.php');
	}
	include_once(ABS_DIR.INCLUDE_DIR.'rss/footer.php');
?>