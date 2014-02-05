<?
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>'.$page_title.'</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="index,follow" />
<meta name="description" content="'.mbmCleanUpHTML($meta_description).'" />
<meta name="keywords" content="'.mbmCleanUpHTML($meta_keyword).'" />
<meta name="language" content="en" /> 
<meta name="language" content="mn" /> 
<meta name="author" content="BATMUNKH Moltov" />';
if(strtolower(basename($_SERVER['PHP_SELF']))=='azmn.php'){
	echo '<base target="_blank">';
}
echo '<link rel="shortcut icon" title="Icon" href="favicon.ico" type="image/x-icon" />';
	
	mbm_include("templates/".TEMPLATE."/css",'css');	
	mbm_include(INCLUDE_DIR."functions_js",'js');	
	mbm_include(INCLUDE_DIR."functions_js",'php_js'); //php file iig JS bolgoj duudaj bna
	mbm_include(INCLUDE_DIR."functions_js/jquery",'js');
	
	
	if(is_dir(ABS_DIR."templates/".TEMPLATE."/includes/")){
		mbm_include("templates/".TEMPLATE."/includes",'js_template');
	}
	//module uudiiin JS iig oruulj ireh
	foreach($module_include_dir as $include_folders_k=>$include_folders_v){
		mbm_include($include_folders_v,'js');
	}
echo '</head>
<body>';
if(isset($_SESSION['login_st']) && strlen($_SESSION['login_st'])>2){
	echo '<div id="loginStatusText" style="
											margin:0px; 
											display:block; z-index:8888; 
											position:absolute; 
											top:0px; left:0px;
											width:100%;
											height:50px;
											padding:20px; 
											text-align:center; 
											background-color:#F5F5F5; 
											border:3px solid #DDD; 
											font-weight:bold;">';
		echo $_SESSION['login_st'];
	echo '</div>';
}
?>