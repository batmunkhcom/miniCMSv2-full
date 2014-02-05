<script language="javascript">
mbmSetContentTitle("<?= $lang['poll']['delete']?>");
mbmSetPageTitle('<?= $lang['poll']['delete']?>');
show_sub('menu6');
</script><?	if(!isset($mBm) || $mBm!=1)
	{ die('MNG miniCMS. by <a href="mailto:admin@mng.cc" title="send email to author">Batmunkh Moltov</a>');}

	$DB->mbm_query("DELETE FROM ".PREFIX."polling WHERE id='".$_GET['id']."'");
	$DB->mbm_query("DELETE FROM ".PREFIX."poll_data WHERE poll_id='".$_GET['id']."'");
?>
<div align="center">
	<a href="index.php?module=poll&cmd=list_poll&start=<?= $_GET['start']?>&per_page=<?= $_GET['per_page']?>"><?= $lang['success'][3]?></a>
</div>