<script language="javascript">
mbmSetContentTitle("<?=$lang["dic"]["add_word_to_dic"]?>");
mbmSetPageTitle('<?=$lang["dic"]["add_word_to_dic"]?>');
show_sub('menu13');
</script>
<?		
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_POST['wordAdd'])){
	if(strlen($_POST['word'])<2){
		$result_txt = $lang['dic']['please_insert_word'];
	}elseif(strlen($_POST['comment'])<2){
		$result_txt = $lang['dic']['please_insert_comment'];
	}else{
		$data['dic_lang_id'] = $_POST['dic_lang_id'];
		$data['word'] = $_POST['word'];
		$data['comment'] = $_POST['comment'];
		$data['date_added'] = mbmTime();
		$data['date_lastupdated'] = $data['date_added'];
		$data['user_id'] = $_SESSION['user_id'];
		
		$r_word_add = $DB->mbm_insert_row($data,"dic_words");
		if($r_word_add==1){
			$result_txt = $lang['dic']['word_add_processed'];
			$b=1;
		}else{
			$result_txt = $lang['dic']['word_add_process_failed'];
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
if($b!=1){
?>
<form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="50%" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" bgcolor="#f5f5f5"><?=$lang['dic']['select_category']?>:<br>
      <select name="dic_lang_id" id="dic_lang_id" class="input">
      <?=mBmDicLangDropDown()?>
      </select>    </td>
    <td width="50%" bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['dic']['word']?>:<br />
      <input name="word" type="text" id="word" value="<?=$_POST['word']?>" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['dic']['word_comment']?>:<br />
      <textarea name="comment" cols="45" rows="3" id="comment"><?=$_POST['comment']?></textarea></td>
    <td bgcolor="#f5f5f5">orchuulga</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" name="wordAdd" id="wordAdd" value="<?=$lang['dic']['button_word_add']?>" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
</table>
</form>
<?
}
?>