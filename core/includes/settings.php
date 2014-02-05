<?
$censored_words[0] = array(' sex ',' fuck ',' shaa ',' shaa ',' pizda',' huts ');
$censored_words[1] = array(' s*x ',' f*ck ',' sh** ',' sh** ',' p**da',' h*ts ');
$BBCODE = new BBCODE();
$DB = new DB($config);
$DB2 = new DB($config_user);
$PHPMAILER = new phpmailer();

if(defined("DB_CHARSET")){
	$DB->mbm_query("SET NAMES ".DB_CHARSET);
}
if(defined("CORE_DB_CHARSET")){
	$DB2->mbm_query("SET NAMES ".CORE_DB_CHARSET);
}

$q_settings = "SELECT * FROM ".PREFIX."settings ";
$r_settings = $DB->mbm_query($q_settings);
for($i=0;$i<$DB->mbm_num_rows($r_settings);$i++){
	if($DB->mbm_result($r_settings,$i,"name")=='COPYRIGHT'){
		$settings_value = $DB->mbm_result($r_settings,$i,"value")
						  .'<br /><a href="http://www.mng.cc" target="_blank" class="copyright">'
						  .'Developed by: miniCMS&trade; v2</a>';
	}else{
		$settings_value = $DB->mbm_result($r_settings,$i,"value");
	}
	define(strtoupper($DB->mbm_result($r_settings,$i,"name")),$settings_value);
}
if($_SESSION['lev']>0 && !isset($_SESSION['user']['username'])){
	$q_userinformation = "SELECT * FROM ".USER_DB_PREFIX."users WHERE id='".$_SESSION['user_id']."'";
	$r_userinformation = $DB2->mbm_query($q_userinformation);
	if($DB2->mbm_num_rows($r_userinformation)==1){
		$_SESSION['user']['username'] = $DB2->mbm_result($r_userinformation,0,"username");
		$_SESSION['user']['sesssion_id'] = $DB2->mbm_result($r_userinformation,0,"session_id");
		$_SESSION['user']['session_time'] = $DB2->mbm_result($r_userinformation,0,"session_time");
		$_SESSION['user']['ip_lastlogin'] = $DB2->mbm_result($r_userinformation,0,"ip_lastlogin");
		$_SESSION['user']['date_added'] = date("Y/m/d",$DB2->mbm_result($r_userinformation,0,"date_added"));
		$_SESSION['user']['score'] = $DB2->mbm_result($r_userinformation,0,"score");
		$_SESSION['user']['name'] = $DB2->mbm_result($r_userinformation,0,"firstname").' '.$DB2->mbm_result($r_userinformation,0,"lastname");
		$_COOKIE['uid'] = $_SESSION['user_id'];		
	}
}
$DB2->mbm_query("UPDATE ".$DB2->prefix."users SET session_time='".time()."' WHERE id='".$_SESSION['user_id']."'");
$_SESSION['ip'] = getenv("REMOTE_ADDR");
if(!is_array($_SESSION['country'])){
	if(function_exists("mbmCountry")){
	$_SESSION['country']['name'] = mbmCountry();
	}
}

	if(isset($_GET['login'])){
		header("Location: index.php?".str_replace($_GET['login'],"",$_SERVER['QUERY_STRING']));
	}
//undsen action uud
	if(isset($_GET['action'])){
		switch($_GET['action']){
			case 'lang':
				if(file_exists(ABS_DIR.INCLUDE_DIR."lang/".$_GET['lang']."/index.php")){
					$_SESSION['ln'] = $_GET['lang'];
				}else{
					$_SESSION['ln'] = DEFAULT_LANG;
				}
				header("Location: ".DOMAIN.DIR."index.php");
			break;
			case 'verification': //user registration verification process
				if($DB2->mbm_check_field('id',$_GET['UID'],'users')==1){
					$activation_key = $DB2->mbm_get_field($_GET['UID'],'id','activation_key','users');
					if($activation_key!=$_GET['key']){
						$result_txt = 'invalid_key';
					}else{
						$data_update_ver['activation_key'] = '';
						$data_update_ver['st'] = 1;
						
						if($DB2->mbm_update_row($data_update_ver,'users',$_GET['UID'])==1){
							$result_txt = 'verification_accepted';
						}else{
							$result_txt = 'verification_failed';
						}
					}
				}else{
					$result_txt = 'invalid_user';
				}
				header("Location: ".base64_decode($_GET['url'])."&r=".$result_txt);
			break;
			case 'userLogin':
				if(isset($_POST['loginButton'])){
					
					$_SESSION['login_st'] = '';
					
					$q_userlogin = "SELECT * FROM ".USER_DB_PREFIX."users WHERE username='".$_POST['username']."' 
								   AND password='".md5($_POST['password'])."' LIMIT 1";
					$r_userlogin = $DB2->mbm_query($q_userlogin);
					
					if($DB2->mbm_num_rows($r_userlogin)==1){
						if($DB2->mbm_result($r_userlogin,0,'activation_key')!=''){
							$result_txt = 'login=not_activated';
							$login_status = 1;
						}elseif($DB2->mbm_result($r_userlogin,0,'st')==0){
							$result_txt = 'login=user_disabled';
							$login_status = 2;
						}else{
							$_SESSION['user_id'] = $DB2->mbm_result($r_userlogin,0,'id');
							$_SESSION['lev'] = $DB2->mbm_result($r_userlogin,0,'lev');
							//$_SESSION['ln']=$DB->mbm_result($r_userlogin,0,'lang');
							$data_login['session_id'] = '';
							$data_login['session_time'] = mbmTime();
							$data_login['ip_lastlogin'] = getenv("REMOTE_ADDR");
							$data_login['date_lastlogin'] = mbmTime();
							$data_login['total_logins'] = ($DB2->mbm_get_field($_SESSION['user_id'],'id','total_logins','users')+1);
							$eee = $DB2->mbm_update_row($data_login,'users',$_SESSION['user_id']);
							$result_txt = 'login=1';
							$login_status = 3;
							if($_SESSION['lev']>0){
								$DB2->mbm_query("UPDATE ".$DB2->prefix."users SET score=score+1 WHERE id='".$_SESSION['user_id']."' LIMIT 1");
							}
							$_SESSION['login_st'] = $DB2->mbm_result($r_userlogin,0,'firstname').' '.$DB2->mbm_result($r_userlogin,0,'lastname').' та тавтай морилно уу!';
						}
					}else{
						$result_txt = 'login=invalid_login';
						$login_status = 4;
						$_SESSION['login_st'] = '<span style="color:red;">Хэрэглэгчийн нэр эсвэл нууц үг буруу байна.</span>';
					}
					if(substr_count(base64_decode($_GET['url']),"?")==0){
						$go_redirect = str_replace($result_txt,'',base64_decode($_GET['url'])).'?'.$result_txt;
					}else{
						$go_redirect = str_replace($result_txt,'',base64_decode($_GET['url'])).'&'.$result_txt;
					}
					//header("Location: ".$go_redirect );
					//header("Location: ".DOMAIN.DIR."index.php?azSid=".session_id()."&action=jump&url=".$_GET['url']);
				}
			break;
			case 'logout';
				$_SESSION['login_st'] = $_SESSION['user']['name'].' та дараа дахин зочлоорой! Баяртай.';
				unset($_COOKIE[COOKIE_NAME]);
				$_SESSION['lev']=0;
				unset($_SESSION['user_id'],$_SESSION['user']);
				$_SESSION['ln']=DEFAULT_LANG;
				$data_logout['session_id'] = '';
				$data_logout['session_time'] = 0;
				//header("Location: ".DOMAIN.DIR."index.php?action=jump&url=".$_GET['url']);
			break;
			case 'jump';
				header("Location: ".base64_decode($_GET['url']));
			break;
			case 'banner':
				$DB->mbm_query("UPDATE ".PREFIX."banners SET clicked=clicked+".HITS_BY." WHERE id='".$_GET['id']."'");
				
				if($_SESSION['lev']>0){
					$DB2->mbm_query("UPDATE ".$DB2->prefix."users SET score=score+2 WHERE id='".$_SESSION['user_id']."' LIMIT 1");
				}
				
				header("Location: ".base64_decode($_GET['url']));
			break;
			case 'web':
				$DB->mbm_query("UPDATE ".PREFIX."web_links SET hits=hits+".HITS_BY.",views=views+".HITS_BY." WHERE id='".$_GET['id']."'");
				header("Location: ".base64_decode($_GET['url']));
			break;
		}


	}
	//undsen actionuud duusjiina.
	if(isset($_GET['start'])){
		define("START",$_GET['start']);
	}else{
		define("START",0);
	}
	if(!isset($_GET['menu_id']) || $DB->mbm_check_field('id',$_GET['menu_id'],'menus')==0){
		define("MENU_ID",0);
	}else{
		define("MENU_ID",$_GET['menu_id']);
		$DB->mbm_query("UPDATE ".PREFIX."menus SET hits=hits+".HITS_BY." WHERE id='".MENU_ID."'");
	}
	if(is_dir(ABS_DIR."templates/".TEMPLATE."/includes/")){
		mbm_include("templates/".TEMPLATE."/includes",'php');
	}
	
	switch($_GET['module']){
		case 'menu':
			switch($_GET['cmd']){
				case 'content':
					if($DB->mbm_check_field('id',$_GET['id'],'menu_contents') == 1){
						
						$tmp_desc = mbmCleanUpHTML($DB->mbm_get_field($_GET['id'],'id','content_short','menu_contents'));
						$tmp_desc = addslashes($tmp_desc);
						
						$page_title = $DB->mbm_get_field($_GET['id'],'id','title','menu_contents');
						$meta_description = $tmp_desc;
						$meta_keyword = $page_title.' '.$tmp_desc;
					}elseif(MENU_ID==0){
						$page_title = PAGE_TITLE;
						$meta_description = str_replace("http://"," ",DOMAIN);
							$meta_description = str_replace("/"," ",$meta_description);
							$meta_description = str_replace("."," ",$meta_description);
						$meta_keyword = "miniCMS is PHP and MySQL based Web Content Management System. It is copyrighted to and developed by Batmunkh Moltov.";
					}else{
						$page_title = $DB->mbm_get_field($_GET['menu_id'],'id','name','menus');
						$meta_description = mbmCleanUpHTML($DB->mbm_get_field($_GET['menu_id'],'id','comment','menus'));
						$meta_keyword = $meta_description.' '.$page_title;
					}
				break;
			}
		break;
		case 'shopping':
			switch($_GET['cmd']){
				case 'products':
					if($DB->mbm_check_field('id',$_GET['id'],'shop_products')==1){
						$tmp_desc = mbmCleanUpHTML($DB->mbm_get_field($_GET['id'],'id','content_short','shop_products'));
						$tmp_desc = addslashes($tmp_desc);
						
						$page_title = $DB->mbm_get_field($_GET['id'],'id','name','shop_products');
						$meta_description = $tmp_desc;
						$meta_keyword = $page_title.' '.$tmp_desc;
					}else{
						$page_title = $DB->mbm_get_field($_GET['cat_id'],'id','name','shop_cats');
						$meta_description = mbmCleanUpHTML($DB->mbm_get_field($_GET['cat_id'],'id','comment','shop_cats'));
						$meta_keyword = $meta_description.' '.$page_title;
					}
				break;
			}
		break;
		default:
			$page_title = PAGE_TITLE;
			$meta_description = str_replace("http://"," ",DOMAIN);
				$meta_description = str_replace("/"," ",$meta_description);
				$meta_description = str_replace("."," ",$meta_description);
			$meta_keyword = "miniCMS is PHP and MySQL based Web Content Management System. It is copyrighted to and developed by Batmunkh Moltov.";
		break;
	}
	if($page_title == '0')	$page_title = PAGE_TITLE;
?>