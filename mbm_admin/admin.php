<? 
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
	
	
	if(isset($_POST['user']))
	{
		$q_user=@$DB2->mbm_query("SELECT * FROM ".USER_DB_PREFIX."users WHERE username='".addslashes($_POST['user'])."' AND `password`='".md5($_POST['pass'])."' LIMIT 1") or die($DB2->mbm_error());

		if(@$DB2->mbm_num_rows($q_user)==1){
			if(@$DB2->mbm_result($q_user,0,"lev")>2){
				$_SESSION['lev']=$DB2->mbm_result($q_user,0,"lev");
				$_SESSION['user_id']=@$DB2->mbm_result($q_user,0,"id");
				header("Location: ".DOMAIN.DIR."mbm_admin/index.php");
			}else{
				header("Location: admin.php?level=0");
			}
		}else{
			header("Location: admin.php?access=1");
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>miniCMS :: Administration Area</title>
<link href="css/form.css" rel="stylesheet" type="text/css">
<link href="css/main.css" rel="stylesheet" type="text/css">
<link href="css/contents.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.tbl_main1 {
	border: 1px solid #d2d2d2;
	background-color:#f5f5f5;
}

//-->
</style>
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="450"><form name="form1" method="post" action="admin.php">
      <table width="300"  border="0" align="center" cellpadding="0" cellspacing="0" class="tbl_main1">
        <tr>
          <td height="40" align="center"><span class="title gold">miniCMS&trade; :: <?=$lang['main']['admin_area']?></span></td>
        </tr>
        <tr>
          <td height="5"></td>
        </tr>
        <tr>
          <td><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#e7e7e7" class="border1">
              <tr>
                <td width="20%" rowspan="5" align="center"><img src="images/mnglogo.jpg" alt="mBm TECHNOLOGY LOGO" width="52" height="52" border="1"></td>
                <td width="28%" align="right">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="28%" align="right" class="bold"><?=$lang['main']['username']?></td>
                <td><input name="user" type="text" class="input" id="user" maxlength="15"></td>
              </tr>
              <tr>
                <td width="28%" align="right" class="bold"><?=$lang['main']['password']?></td>
                <td><input name="pass" type="password" class="input" id="pass"></td>
              </tr>
              <tr>
                <td width="28%" align="right">&nbsp;</td>
                <td><input name="Submit" type="submit" class="button" value="<?=$lang['main']['login']?>"></td>
              </tr>
              <tr>
                <td width="28%" align="right">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="5"></td>
        </tr>
      </table>
      <p align="center">&copy; since 2006<? if(date("Y")>2006) echo '-'.date("Y");?>
         <a href="http://www.mng.cc" target="_blank">mBm TECHNOLOGY LLC</a> Allrights reserved.<br> 
        <span class="d2">Administration area best viewed with resolution at least 1024x768
		</span></p>
    </form></td>
  </tr>
</table>
</body>
</html>
