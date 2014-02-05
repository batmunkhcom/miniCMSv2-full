<script language="javascript">
mbmSetContentTitle("<?=$lang["faqs"]["new_questions"]?>");
mbmSetPageTitle('<?=$lang["faqs"]["new_questions"]?>');
show_sub('menu14');
</script>
<?
if($mBm!=1 && $modules_permissions['faqs']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}else{
?>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="2" cellpadding="3">
  <?
 if(isset($_POST['answerButton'])){
  	foreach($_POST['answer_it'] as $k=>$v){
		if($v==1){
			$data["total_updated"] = 1;
			$data["date_lastupdated"] = mbmTime();
			$data['question'] = $_POST['question'][$k];
			$data['answer'] = $_POST['answer'][$k];
			if($DB->mbm_update_row($data,"faqs",$k)==1){
				$result_txt = "#".$k." updated <br />";
				
				$q_faqs_info = "SELECT * FROM ".PREFIX."faqs WHERE id='".$k."'";
				$r_faqs_info = $DB->mbm_query($q_faqs_info);
				
				mbmSendEmail(ADMIN_NAME.'|'.ADMIN_EMAIL,$DB->mbm_result($r_faqs_info,0,"name").'|'.$DB->mbm_result($r_faqs_info,0,"email"),'tanii asuultand hariullaa','Tanii asuusan asuultand hariullaa. <a href="'.DOMAIN.DIR.'index.php?module=faqs&cmd=list" target="_blank">'.DOMAIN.DIR.'index.php?module=faqs&cmd=list</a> haygaar handaj hariutaa harna uu.<br /><br />'.SITE_SIGNATURE);
			}
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
  }
  switch($_GET['action']){
  	case 'delete':
		$DB->mbm_query("DELETE FROM ".PREFIX."faqs WHERE id='".$_GET['id']."'");
	break;
  }
  
  	$q_faqs_new = "SELECT * FROM ".PREFIX."faqs WHERE total_updated=0 ORDER BY id DESC";
	$r_faqs_new = $DB->mbm_query($q_faqs_new);
	for($i=0;$i<$DB->mbm_num_rows($r_faqs_new);$i++){
	//for($i=0;$i<$DB->mbm_num_rows($r_faqs_new);$i++){
  ?>
    <tr>
      <td valign="top"><?=$lang["main"]["date_added"]?>: <strong><?=date("Y/m/d H:i:s",$DB->mbm_result($r_faqs_new,$i,"date_added"))?></strong><br />
        <?=$lang["main"]["name"]?>: <strong><?=$DB->mbm_result($r_faqs_new,$i,"name")?></strong><br />
        <?=$lang["main"]["email"]?>: <strong><?=$DB->mbm_result($r_faqs_new,$i,"email")?></strong><br />
        <?=$lang["country"]["ip"]?>: <strong><?=$DB->mbm_result($r_faqs_new,$i,"ip").' ['.mbmCountry($DB->mbm_result($r_faqs_new,$i,"ip")).']'?></strong><br />
        <?=$lang["main"]["action"]?> : <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=faqs&cmd=new&action=delete&id=<?=$DB->mbm_result($r_faqs_new,$i,"id")?>')"><?=$lang["main"]["delete"]?></a></td>
      <td width="300" valign="top"><label><?=$lang["faqs"]["question"]?>:<br />
        <textarea name="question[<?=$DB->mbm_result($r_faqs_new,$i,"id")?>]" cols="45" rows="5" id="question[<?=$DB->mbm_result($r_faqs_new,$i,"id")?>]"><?=$DB->mbm_result($r_faqs_new,$i,"question")?></textarea>
      </label></td>
      <td valign="top"><?=$lang["faqs"]["answer_it"]?>
        <input type="checkbox" name="answer_it[<?=$DB->mbm_result($r_faqs_new,$i,"id")?>]" id="checkbox" value="1" align="absmiddle" />
        <br />
    <textarea name="<?='answer['.$DB->mbm_result($r_faqs_new,$i,"id").']';?>" cols="45" rows="5" id="answer"><?
    if(isset($_POST['answer'][$DB->mbm_result($r_faqs_new,$i,"id")])){
		echo $_POST['answer'][$DB->mbm_result($r_faqs_new,$i,"id")];
	}
	?>
    </textarea>     </td></tr>
    <?
    }
	?>
  </table>
  <div align="right">
    <input type="submit" name="answerButton" id="answerButton" class="button" value="<?=$lang["faqs"]["answer_all_checked"]?>" />
  </div>
</form>

<?	
}
?>
