<script language="javascript">
mbmSetContentTitle("<?= $lang['menu']['menu_delete']?>");
mbmSetPageTitle('<?= $lang['menu']['menu_delete']?>');
show_sub('menu2');
</script><?	
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if($_SESSION['lev']<$modules_permissions['menu']){
	die("error");
}
	mbmDeleteMenu($_GET['id']);
	mbmResetMenuPos($_GET['menu_id']);
	$tmp= $_GET['menu_id'];
?>
<div id="query_result">
	<a href="index.php?module=menu&cmd=menu_list&menu_id=<?= $_GET['menu_id']?>"><?=$lang["success"]["delete_success"]?></a>
</div>