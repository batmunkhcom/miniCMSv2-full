<script language="javascript">
mbmSetContentTitle("<?=$lang['main']['content_permissions']?>");
mbmSetPageTitle('<?=$lang['main']['content_permissions']?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
?>