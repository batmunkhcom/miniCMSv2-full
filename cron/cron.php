<? 
	error_reporting(E_ALL ^ E_NOTICE);
	unset($_GET['mBm'],$_POST['mBm'],$_SESSION['mBm'],$_REQUEST['mBm']);
	$mBm=1;
	if(substr_count($_SERVER['QUERY_STRING'],"%20")>0 && substr_count($_SERVER['QUERY_STRING'],'module=search&cmd=search')==0){
		die("HACKING ATTEMP....");
	}
	unset($_GET['PHPSESSID']);
	if(isset($_GET['redirect'])){
		header("Location: ".base64_decode($_GET['redirect']));
	}
	require_once("/home/azmn/public_html/yadii.net/config.php");
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
	
	$q_cron = "SELECT * FROM ".USER_DB_PREFIX."schedules WHERE st=0 GROUP BY email_to ORDER BY date_added LIMIT 20";
	$r_cron = $DB2->mbm_query($q_cron);
	
	for($i=0;$i<$DB2->mbm_num_rows($r_cron);$i++){
		// HTML body
		$body  = $DB2->mbm_result($r_cron,$i,"content");
	
		// Plain text body (for mail clients that cannot read HTML)
		$text_body  = '*************************************************************************'
					.mbmCleanUpHTML($DB2->mbm_result($r_cron,$i,"content"));
	
		$PHPMAILER->From = $DB2->mbm_result($r_cron,$i,"email_from");
		$PHPMAILER->FromName = $DB2->mbm_result($r_cron,$i,"name_from");
		$PHPMAILER->Subject = $DB2->mbm_result($r_cron,$i,"subject");
		
		$PHPMAILER->Body    = $body;
		$PHPMAILER->AltBody = $text_body;
		$PHPMAILER->AddAddress($DB2->mbm_result($r_cron,$i,"email_to"), $DB2->mbm_result($r_cron,$i,"name_to"));
	
		if(!$PHPMAILER->Send())
			echo "There has been a mail error sending to " . $DB2->mbm_result($r_cron,$i,"email_to") . "<br>";
		else
			echo 'sent to '.$DB2->mbm_result($r_cron,$i,"email_to")." \n";
		// Clear all addresses and attachments for next loop
		$PHPMAILER->ClearAddresses();
		$PHPMAILER->ClearAttachments();
		
		$DB2->mbm_query("UPDATE ".USER_DB_PREFIX."schedules SET st=1,date_sent='".mbmTime()."' WHERE id='".$DB2->mbm_result($r_cron,$i,"id")."'");

	}
	
	$DB2->mbm_query(
				"DELETE FROM azmn_sessions2 WHERE 
				modified<='"
				.date("Y-m-d H:i:s",
					mktime(
						date("H")-2,
						date("i"),
						date("s"),
						date("m"),
						date("d"),
						date("Y")
					)
				)."'");
	
?>