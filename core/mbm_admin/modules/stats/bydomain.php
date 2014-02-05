<script language="javascript">
mbmSetContentTitle("Зочин илгээлтийг домэйноор харах");
mbmSetPageTitle('Зочин илгээлтийг домэйноор харах');
show_sub('menu99');
</script>
<form id="form1" name="form1" method="post" action="">
  <div align="center">
    http://www.
    <input type="text" name="q" id="q" />
    <input type="submit" name="button" id="button" value="   Харах   " />
  </div>
</form><?
if(isset($_POST['q'])){
	$q_stat_bydomain = "SELECT SUM(hits) FROM ".PREFIX."stat_referers WHERE domain LIKE '%".$_POST['q']."%'";
	$r_stat_bydomain = $DB->mbm_query($q_stat_bydomain);
	
	echo 'Нийт зочин илгээлт: <strong>'.$DB->mbm_result($r_stat_bydomain,0).'</strong>';
}
?>
