<?
	error_reporting(E_ALL ^ E_NOTICE);
	unset($_GET['mBm'],$_POST['mBm'],$_SESSION['mBm'],$_REQUEST['mBm']);
	$mBm=1;
	if(substr_count($_SERVER['QUERY_STRING'],"%20")>0){
		die("HACKING ATTEMP....");
	}
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

	foreach($modules_active as $module_k=>$module_v){
		require_once(ABS_DIR."modules/".$module_v."/index.php");
	}
	foreach($module_include_dir as $include_folders_k=>$include_folders_v){
		mbm_include($include_folders_v,'php');
	}
	
	//check download session
	$q_sess = "SELECT COUNT(*) FROM ".PREFIX."fileshare_sessions WHERE session_id='".session_id()."' AND session_time>".(mbmTime()-($config_fileshare['next_file_dl_limit'][$_SESSION['lev']]*$config_fileshare['dl_timer'])/1000)."";
	$r_sess = $DB->mbm_query($q_sess);
	if($DB->mbm_result($r_sess,0)>0){
		header("Location: index.php?module=fileshare&cmd=dl&code=1&k=".$_GET['k']);
	}
	
	//fileshare iin filedownload eheljiinaa gej
	$q_file = "SELECT * FROM ".PREFIX."fileshare WHERE `key`='".$_GET['k']."'";
	$r_file = $DB->mbm_query($q_file);
	if($DB->mbm_num_rows($r_file)==1){
		
		$user_conf = mbmFileshareUserConfig($_SESSION['user_id']);
		$download_speed = $user_conf['dl_limit'];//$config_fileshare['dl_limit'][$_SESSION['lev']];
		//file dl session eheleh
		$data_fileshare_session['ip'] = getenv("REMOTE_ADDR");
		$data_fileshare_session['session_time'] = mbmTime();
		$data_fileshare_session['session_id'] = session_id();

		if($DB->mbm_check_field('session_id',session_id(),'fileshare_sessions')==1){
			$DB->mbm_query("UPDATE ".PREFIX."fileshare_sessions SET session_time='".time()."' WHERE session_id='".session_id()."' LIMIT 1");
		}else{
			$DB->mbm_insert_row($data_fileshare_session,'fileshare_sessions');
		}
		//file dl session duusav
		mbmDownloadWithLimit(
						array(
							'real_path'=>ABS_DIR.$DB->mbm_result($r_file,0,'abs_url'),//file iin original path
							'user_filename'=>$DB->mbm_result($r_file,0,"filename_orig"), //hereglegch yamar nereer tatah
							'mimetype'=>$DB->mbm_result($r_file,0,"mimetype"), //hereglegch yamar nereer tatah
							'download_rate'=>$download_speed, //tatah hurd  0.1 == 100bytes p/s
							'fileshare'=>1 //tatah hurd  0.1 == 100bytes p/s
							)
						);
	 
	 
		$DB->mbm_query("UPDATE ".PREFIX."stat_daily SET `dl`=`dl`+".HITS_BY." WHERE `y`='".date("Y")."' AND `m`='".date("m")."' AND `d`='".date("d")."'");
		$DB->mbm_query("UPDATE ".PREFIX."fileshare SET hits=hits+".HITS_BY.",days_to_save=days_to_save_reset,downloaded=downloaded+".HITS_BY.",session_time='".mbmTime()."'  WHERE `key`='".$_GET['k']."'");
	}else{
		header("Location: index.php?module=fileshare&cmd=dl&".$_SERVER['QUERY_STRING']);
	}
?>