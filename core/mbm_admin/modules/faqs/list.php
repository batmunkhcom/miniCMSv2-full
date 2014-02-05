<script language="javascript">
mbmSetContentTitle("<?=$lang["faqs"]["questions_list"]?>");
mbmSetPageTitle('<?=$lang["faqs"]["questions_list"]?>');
show_sub('menu14');
</script>
<?
if($mBm!=1 && $modules_permissions['faqs']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}else{
?>
  <table width="100%" border="0" cellspacing="2" cellpadding="3">
  <?
  switch($_GET['action']){
  	case 'delete':
		$DB->mbm_query("DELETE FROM ".PREFIX."faqs WHERE id='".$_GET['id']."'");
	break;
  }
  
  	$q_faqs_new = "SELECT * FROM ".PREFIX."faqs ORDER BY id DESC";
	$r_faqs_new = $DB->mbm_query($q_faqs_new);
	
	if((START+PER_PAGE) > $DB->mbm_num_rows($r_faqs_new)){
		$end= $DB->mbm_num_rows($r_faqs_new);
	}else{
		$end= START+PER_PAGE; 
	}
	for($i=START;$i<$end;$i++){
	//for($i=0;$i<$DB->mbm_num_rows($r_faqs_new);$i++){
  ?>
    <tr>
      <td valign="top"><?=$lang["main"]["date_added"]?>: <strong><?=date("Y/m/d H:i:s",$DB->mbm_result($r_faqs_new,$i,"date_added"))?></strong><br />
        <?=$lang["main"]["name"]?>: <strong><?=$DB->mbm_result($r_faqs_new,$i,"name")?></strong><br />
        <?=$lang["main"]["email"]?>: <strong><?=$DB->mbm_result($r_faqs_new,$i,"email")?></strong><br />
        <?=$lang["country"]["ip"]?>: <strong><?=$DB->mbm_result($r_faqs_new,$i,"ip").' ['.mbmCountry($DB->mbm_result($r_faqs_new,$i,"ip")).']'?></strong><br />
        <?=$lang["main"]["action"]?> : <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=faqs&cmd=list&action=delete&id=<?=$DB->mbm_result($r_faqs_new,$i,"id")?>')"><?=$lang["main"]["delete"]?></a></td>
      <td valign="top"><strong><?=$DB->mbm_result($r_faqs_new,$i,"question")?></strong>
        <br />
      <?=$DB->mbm_result($r_faqs_new,$i,"answer")?>      </td>
    </tr>
    <?
    }
	?>
  </table>

<?	
}
?>