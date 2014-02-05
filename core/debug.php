<?
function mbmDebug(){
	mbm_test($_SESSION);
	mbm_test($_POST);
	mbm_test($_SESSION['userForm']);
	mbm_test($_COOKIE);
	mbm_test(session_get_cookie_params());
	echo session_name().' : '.session_id();
	
	 echo "<script type='text/javascript'>";
	 echo "document.cookie='AZSULJEE=".session_id()."';";
	 echo "</script>";

}
switch(DOMAIN){
	case 'http://www.unegui.com/':
	break;
	case 'http://www.chart10.com/':
	break;
	case 'http://ads.az.mn/':
	break;
	case 'http://php.az.mn/':
	break;
	case 'http://forum.az.mn/':
		mbmDebug();
	break;
	default:
	break;
}
?>
