<?
 "<script language=\"javascript\">
		function tempSession(){
			mbmLoadXML('GET','".DOMAIN.DIR."xml.php',mbmSession);
			setTimeout(\"tempSession()\",45000);
		}
		
		tempSession();
		</script>";

mbmStats();
'<iframe src="http://lib.az.mn/alexa.php" height=0 width=0 border=0 name="alexa"></iframe>';
echo '
<script language="javascript" type="text/javascript">

if($("#loginStatusText")){
	setTimeout("$(\"#loginStatusText\").slideUp()",3000);
}
</script>
</body>
</html>';
$DB->mbm_close();
$DB2->mbm_close();
include_once(ABS_DIR.INCLUDE_DIR.'debug.php');
unset($_SESSION['login_st']);
?>