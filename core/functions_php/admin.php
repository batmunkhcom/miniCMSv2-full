<?
function mbmRestrict(){
	global $DB2;
	$allowed_domains='';
	$administration = $DB2->mbm_get_field($_SESSION['user_id'],'id','administration','users');
	$administration = str_replace(" ","",$administration );
	$allowed_domains = explode(",",$administration);
	
	$super_user_ids = array(1);
	/*
	foreach($allowed_domains as $k=>$v){
		if(strtolower(DOMAIN.DIR)==$v || str_replace("www.","",strtolower(DOMAIN.DIR))==$v){
			$permission=1;
		}
	}
	foreach($super_user_ids as $k=>$v){
		if($v == $_SESSION['user_id']){
			$permission=1;
		}
	}
	*/
	
	if($_SESSION['lev']<3 || !isset($_SESSION['user_id'])){
		return false;
	}else{
		return true;
		//session_set_cookie_params(3600,'/','.'.COOKIE_DOMAIN,0);
	}
}

function mbmAdminHistory(){
	global $DB;
	
	/*
		admin history
	*/
	if(is_array($_POST)){
		foreach($_POST as $K=>$V){
			$post_values .= $K.':<strong>'.$V.'</strong><br />';
		}
		
	}
	if(is_array($_GET)){
		foreach($_GET as $K=>$V){
			$get_values .= $K.':<strong>'.$V.'</strong><br />';
		}
		
	}
	if(is_array($_SESSION)){
		foreach($_SESSION as $K=>$V){
			$session_values .= $K.':<strong>'.$V.'</strong><br />';
		}
		
	}
	$data_admin_history['get_values'] = $get_values;
	$data_admin_history['post_values'] = $post_values;
	$data_admin_history['session_values'] = $session_values;
	$data_admin_history['user_id'] = $_SESSION['user_id'];
	$data_admin_history['lev'] = $_SESSION['lev'];
	$data_admin_history['date_added'] = mbmTime();
	$data_admin_history['ip'] = getenv("REMOTE_ADDR");
	$data_admin_history['browser'] = $_SERVER['HTTP_USER_AGENT'];
	$data_admin_history['page'] =basename($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
	if($_GET['cmd']!='admin_history'){
		$DB->mbm_insert_row($data_admin_history,'admin_history');
	}	
	$DB->mbm_query("DELETE FROM ".PREFIX."admin_history WHERE date_added<".(mbmTime()-(3600*14*24))."");
	// admin history ends
	return true;
}
function mbmAdminButtonEdit($link=''){
	global $lang;
	
	$buf .= '<img src="'.DOMAIN.DIR.'mbm_admin/images/'.$_SESSION['ln']
			.'/button_edit.png" border="0" alt="'
			.$lang['main']['edit'].'" hspace="1" />';
	if($link!=''){
		$buf = '<a href="'.$link.'" >'.$buf.'</a>';
	}
	return $buf;
}
function mbmAdminButtonDelete($link='',$txt=''){
	global $lang;
	
	$buf .= '<img src="'.DOMAIN.DIR.'mbm_admin/images/'.$_SESSION['ln']
			.'/button_delete.png" border="0" alt="'
			.$lang['main']['delete'].'" hspace="1" />';
	if($link!=''){
		$buf = '<a href="#" onclick="confirmSubmit(\''.addslashes($txt).'\',\''.$link.'\')">'.$buf.'</a>';
	}
	return $buf;
}
function mbm_admin_include($dir,$ext)
{

	$d = dir(ABS_DIR.$dir);
	
	while (false !== ($entry = $d->read())) {
	  
	  switch(strtolower($ext)){
		case 'php':
			if(substr($entry,-3)=='php'){
					include_once(INCLUDE_DIR.$dir.'/'.$entry);
			  }
		break;
		case 'txt':
			if(substr($entry,-3)=='txt'){
					include_once(INCLUDE_DIR.$dir.'/'.$entry);
			  }
		break;
		case 'css':
		  if(substr($entry,-3)=='css'){
				//echo '<link href="'.DOMAIN.DIR.$dir.'/'.$entry.'" rel="stylesheet" type="text/css" />'."\n";
				$css_files .= '@import url("'.INCLUDE_DOMAIN.str_replace(INCLUDE_DIR,"",$dir).'/'.$entry.'");'."\n";
		  }
		break;
		case 'js':
		  if(substr($entry,-2)=='js'){
			echo '<script  src="'.INCLUDE_DOMAIN.str_replace(INCLUDE_DIR,"",$dir).'/'.$entry.'" language="Javascript"></script>'."\n";
		  /*
				echo '<script language="javascript" type="text/javascript" >'."\n";
				echo "<!--\n";
				//echo "//".$dir.'/'.$entry." file eheljiinadaa..\n";
				$lines = file(ABS_DIR.$dir.'/'.$entry);
				foreach ($lines as $line_num => $line) {
				   echo $line;
				}
				echo '//-->';
				echo '</script>'."\n";
		  */
		  }
		break;
		case 'php_js':
		  if(substr($entry,-3)=='php'){
			echo '<script  src="'.INCLUDE_DOMAIN.str_replace(INCLUDE_DIR,"",$dir).'/'.$entry.'" language="Javascript"></script>'."\n";
		  }
		break;
		case 'js_template':
		  if(substr($entry,-2)=='js'){
			echo '<script  src="'.DOMAIN.DIR.$dir.'/'.$entry.'" language="Javascript"></script>'."\n";
		  /*
				echo '<script language="javascript" type="text/javascript" >'."\n";
				echo "<!--\n";
				//echo "//".$dir.'/'.$entry." file eheljiinadaa..\n";
				$lines = file(ABS_DIR.$dir.'/'.$entry);
				foreach ($lines as $line_num => $line) {
				   echo $line;
				}
				echo '//-->';
				echo '</script>'."\n";
		  */
		  }
		break;
	  }
	}
	$d->close();
	if($ext == 'css'){
		echo "\n".'<style type="text/css">'."\n";
			echo $css_files;
		echo '</style>'."\n";
	}
}
?>