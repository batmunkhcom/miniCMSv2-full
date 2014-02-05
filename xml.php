<?
	error_reporting(E_ALL ^ E_NOTICE);
	unset($_GET['mBm'],$_POST['mBm'],$_SESSION['mBm'],$_REQUEST['mBm']);
	$mBm=1;
	unset($_GET['PHPSESSID']);
	require_once("config.php");
	if(!isset($_SESSION['lev'])){
		$_SESSION['lev']=0;
	}
	if(isset($_GET['redirect'])){
		header("Location: ".base64_decode($_GET['redirect']));
	}
	include(INCLUDE_DIR."includes/common.php");
	if(!isset($_SESSION['ln'])){
		$_SESSION['ln']=DEFAULT_LANG;
	}

	mbm_include(INCLUDE_DIR."classes",'php');
	mbm_include(INCLUDE_DIR."functions_php",'php');
	require_once(INCLUDE_DIR."includes/settings.php");
	
	
	foreach($modules_active as $module_k=>$module_v){
		require_once(ABS_DIR."modules/".$module_v."/index.php");
	}
	foreach($module_include_dir as $include_folders_k=>$include_folders_v){
		mbm_include($include_folders_v,'php');
	}
	
	include(ABS_DIR.INCLUDE_DIR."lang/".$_SESSION['ln']."/index.php");
	if(isset($_GET['start'])){
		define("START",$_GET['start']);
	}else{
		define("START",0);
	}
	if(!isset($_GET['menu_id']) || $DB->mbm_check_field('id',$_GET['menu_id'],'menus')==0){
		define("MENU_ID",0);
	}else{
		define("MENU_ID",$_GET['menu_id']);
		$DB->mbm_query("UPDATE ".PREFIX."menus SET hits=hits+1 WHERE id='".MENU_ID."'");
	}
	header("Content-type: text/xml");
	$txt = "<?xml encoding=\"utf-8\"?>\n";
	$txt = "\n<miniCMS>";
	if(file_exists(ABS_DIR.INCLUDE_DIR.'xml/'.$_GET['action'].'.php')){
		include_once(ABS_DIR.INCLUDE_DIR.'xml/'.$_GET['action'].'.php');
	}else{
		$txt .= "\n\t<result st='0' value='invalid attempt' />";
	}
	$txt .= "\n</miniCMS>";
	echo $txt;
?>