<?
header("Location: http://www.yadii.net/");
	error_reporting(E_ALL ^ E_NOTICE);

	unset($_GET['mBm'],$_POST['mBm'],$_SESSION['mBm'],$_REQUEST['mBm']);

	$mBm=1;

	if(substr_count($_SERVER['QUERY_STRING'],"%20")>0){

		//die("HACKING ATTEMP....");

	}

	//header("Location: http://www.unegui.net");

	unset($_GET['PHPSESSID']);

	if(isset($_GET['redirect'])){

		header("Location: ".base64_decode($_GET['redirect']));

	}

	require_once("config.php");

	include(ABS_DIR.INCLUDE_DIR."includes/common.php");

	

	if(!isset($_SESSION['ln'])){

		$_SESSION['ln']=DEFAULT_LANG;

	}

	if(!isset($_SESSION['lev'])){

		$_SESSION['lev']=0;

	}



	include(ABS_DIR.INCLUDE_DIR."lang/".$_SESSION['ln']."/index.php");

	mbm_include(INCLUDE_DIR."classes",'php');

	mbm_include(INCLUDE_DIR."functions_php",'php');

	require_once(ABS_DIR.INCLUDE_DIR."includes/settings.php");



	include_once(ABS_DIR."editors/spaw2/spaw.inc.php");

	

	foreach($modules_active as $module_k=>$module_v){

		require_once(ABS_DIR."modules/".$module_v."/index.php");

	}

	foreach($module_include_dir as $include_folders_k=>$include_folders_v){

		mbm_include($include_folders_v,'php');

	}

	

	include(ABS_DIR.INCLUDE_DIR."includes/header.php");

	#include("templates/".TEMPLATE."/index.php");

	include("tmp.php");

	include(ABS_DIR.INCLUDE_DIR."includes/footer.php");

?>