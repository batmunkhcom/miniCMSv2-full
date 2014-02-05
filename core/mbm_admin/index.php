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
	if($_SESSION['lev']>4){
		$spaw_upload = true;
	}else{
		$spaw_upload = false;
	}
	$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', $spaw_upload);
	$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', $spaw_upload); 
	
	
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=PAGE_TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="index,follow" />
<meta name="description" content="Mongol video Mongolian clip youtube music song singer Монгол дуу клип видео мэндчилгээ " />
<meta name="keywords" content="Mongol video Mongolian clip youtube music song singer Монгол дуу клип видео мэндчилгээ " /><meta name="language" content="mn" /> 
<meta name="author" content="BATMUNKH Moltov" />
<link rel="shortcut icon" title="Icon" href="favicon.ico" type="image/x-icon" />
<?
	mbm_include("mbm_admin/css",'css');
	
	mbm_include(INCLUDE_DIR."functions_js",'js');
?>
</head>

<body>
<script language="javascript">
<!--
function show_sub(id){
	//total_menu = document.getElementById("menu_main").length;
	for(var i=1;i<=101;i++){
		//if(document.getElementById("menu"+i)) document.getElementById("menu"+i).style.display='none';
		if($('menu'+i)) $("menu"+i).hide();
	}
	if(document.getElementById(id).style.display!='none'){
		//document.getElementById(id).style.display='none';
		$(id).fadeOut(500);
	}else{
		//document.getElementById(id).style.display='list-item';
		$(id).fadeIn(500);
	}
	//alert(total_menu);
	return true;
}
//-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" bgcolor="#265CA6" style="background-image:url(images/header_blue.jpg);
    						background-repeat:no-repeat;">
                            <div style="float:right; margin:5px;">
                           	<a href="index.php?lang=mn" style="color:#FFFFFF;">Mongolian</a> | 
                            <a href="index.php?action=lang&amp;lang=en" style="color:#FFFFFF;">English</a> | 
                            <a href="index.php?action=lang&amp;lang=cn" style="color:#FFFFFF;">Chinese</a>                            
                            </div>
<img src="images/logo.gif" alt="MNG Logo" width="32" height="32" hspace="8" align="middle" />
                            <span class="white bold">miniCMS&trade; v2.0</span>
    </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="180" valign="top"><?
        include_once(ABS_DIR.INCLUDE_DIR."mbm_admin/menu_left.php");
		?>
          <div id="copyright">since &copy; 2003<br />mBm TECHNOLOCY LLC<br />
<small style="font-weight:normal;">Web Development Company </small> </div></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="1" bgcolor="#e4e4e5"></td>
          </tr>
          <tr>
            <td height="1" bgcolor="#d5d5d6"></td>
          </tr>
          <tr>
            <td height="1" bgcolor="#FFFFFF"></td>
          </tr>
          <tr>
            <td height="1" bgcolor="#e3e1e0"></td>
          </tr>
          <tr>
            <td height="26" background="images/content_title_bg.jpg" style="background-repeat:repeat-x;padding-left:15px;"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="90%"><div id="title_box"><img src="images/mnglogo14x14.gif" hspace="3" style="float:left"; />v2.0</div>
                      <span id="content_title" style="padding-left:10px; padding-top:5px;"></span></td>
                  <td align="right"><?=$DB2->mbm_get_field($_SESSION['user_id'],'id','username','users')?></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="13" background="images/content_title_footer_bg.jpg" style="background-repeat:repeat-x;"></td>
          </tr>
          <tr>
            <td height="40" background="images/content_title2_bg.jpg" style="background-repeat:repeat-x;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td><?
			if(file_exists(ABS_DIR.INCLUDE_DIR."mbm_admin/modules/".$_GET['module']."/".$_GET['cmd'].".php")){
				if($_SESSION['lev']>=$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')>=$modules_permissions[$_GET['module']]){
					include_once(ABS_DIR.INCLUDE_DIR."mbm_admin/modules/".$_GET['module']."/".$_GET['cmd'].".php");
				}else{
					echo '<div id="query_result">'.$lang['admin_content']['low_level'].'</div>';
				}
			}else{		
				include_once(ABS_DIR.INCLUDE_DIR."mbm_admin/home.php");
			}
		
	?></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="40" background="images/content_title2_bg.jpg" style="background-repeat:repeat-x;">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>	
</body>
</html>