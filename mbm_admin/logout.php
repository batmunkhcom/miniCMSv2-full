<?
	error_reporting(E_ALL ^ E_NOTICE);
	unset($_GET['mBm'],$_POST['mBm'],$_SESSION['mBm'],$_REQUEST['mBm']);
	$mBm=1;
	unset($_GET['PHPSESSID']);
	require_once("../config.php");
	include(ABS_DIR.INCLUDE_DIR."includes/common.php");
	if(!isset($_SESSION['ln'])){
		$_SESSION['ln']=DEFAULT_LANG;
	}
	
	include(ABS_DIR.INCLUDE_DIR."lang/".$_SESSION['ln']."/index.php");
	
	mbm_include(INCLUDE_DIR."classes",'php');
	mbm_include(INCLUDE_DIR."functions_php",'php');
	require_once(ABS_DIR.INCLUDE_DIR."includes/settings.php");
	
	mbmAdminHistory();
	
	include_once(ABS_DIR."editors/spaw2/spaw.inc.php");
	
	if(mbmRestrict()==false){
		header("Location: ".DOMAIN.DIR."mbm_admin/admin.php");
	}
	foreach($modules_active as $module_k=>$module_v){
		require_once(ABS_DIR.INCLUDE_DIR."mbm_admin/modules/".$module_v."/index.php");
	}
	
	if(isset($_GET['start'])){
		define("START",$_GET['start']);
	}else{
		define("START",0);
	}
	if(is_dir(ABS_DIR."templates/".TEMPLATE."/includes/")){
		mbm_include("templates/".TEMPLATE."/includes",'php');
	}
	if(isset($_GET['lang'])){
		if(file_exists(ABS_DIR.INCLUDE_DIR.'lang/'.$_GET['lang'].'/index.php')){
			$_SESSION['ln'] = $_GET['lang'];
			header("Location: index.php");
		}
	}
	foreach($_SESSION as $k=>$v){
		unset($_SESSION[$k]);
	}
	session_destroy();
	header("Location: admin.php");
?>