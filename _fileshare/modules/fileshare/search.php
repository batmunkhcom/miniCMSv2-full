<h2>Файл хайлт
</h2>
<div align="center" style="margin-bottom:6px; margin-top:6px;">
<form id="form1" name="form1" method="post" action="" onsubmit="window.location='index.php?module=fileshare&cmd=search&q='+this.q.value;return false;">
    <input name="q" type="text" id="q" size="60" />
  <input type="submit" name="button" id="button" value="Хайх" />
</form>
</div><br />
<br />
<script language="javascript">
mbmSetPageTitle('Файл хайлт :: <?=$_GET['q']?>');
</script>
<?
if(isset($_GET['q'])){
	$q_search = "SELECT * FROM ".PREFIX."fileshare WHERE is_private!=1 AND (filename_orig LIKE '%".addslashes($_GET['q'])."%' OR tags LIKE '%".addslashes($_GET['q'])."%')";
	$r_search = $DB->mbm_query($q_search);
	
	echo '<div style="margin-bottom:12px; border-bottom:1px solid #DDDDDD; padding-bottom:5px;">';
		echo 'Нийт <big><strong>'.$DB->mbm_num_rows($r_search).'</strong></big> файл олдлоо.';
	echo '</div>';
	
	echo '<div style="float:right; width:120px; display:block; padding:5px; background-color:#F5F5F5; border:1px solid #DDDDDD;">';
		echo mbmShowBanner('right_1');
			echo '<hr size="1" />';
		echo mbmShowBanner('right_2');
	echo '</div>';
 	if((START+50) > $DB->mbm_num_rows($r_search)){
		$end= $DB->mbm_num_rows($r_search);
	}else{
		$end= START+50; 
	}
	for($i=START;$i<$end;$i++){
	//for($i=0;$i<$DB->mbm_num_rows($r_search);$i++){
		echo '<strong>'.($i+1).'. ';
		echo mbmFilshareLink(array('key'=>$DB->mbm_result($r_search,$i,"key"),'name'=>$DB->mbm_result($r_search,$i,"filename_orig")));
		//echo '<a href="?k='.$DB->mbm_result($r_search,$i,"key").'">'.$DB->mbm_result($r_search,$i,"filename_orig").'</a>';
		echo '</strong>';
		echo '<br />';
		echo '<br />';
		//echo 'Filetype: '.$DB->mbm_result($r_search,$i,"mimetype");
		//echo '<br />';
		echo 'Файлын хэмжээ: '.mbmFileSizeMB($DB->mbm_result($r_search,$i,"filesize"));
		echo '<br />';
		//echo 'days to delete: '.mbmFileSizeMB($DB->mbm_result($r_search,$i,"days_to_save"));
		//echo '<br />';
		echo 'Татагдсан: '.$DB->mbm_result($r_search,$i,"downloaded");
		echo '<br />';
		echo 'Нэмэгдсэн огноо: '.date("Y/m/d H:i:s",$DB->mbm_result($r_search,$i,"date_added"));
		echo '<br />';
		echo 'Сүүлд татагдсан: '.date("Y/m/d H:i:s",$DB->mbm_result($r_search,$i,"session_time"));
		echo '<br />';
		echo '<br />';
		echo '<br />';
	}
}
?>