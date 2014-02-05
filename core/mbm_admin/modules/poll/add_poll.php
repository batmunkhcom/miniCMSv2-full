<script language="javascript">
mbmSetContentTitle("<?= $lang['poll']['poll_add']?>");
mbmSetPageTitle('<?= $lang['poll']['poll_add']?>');
show_sub('menu6');
</script>
<?
if(!isset($mBm) || $mBm!=1)
	{ die('MNG miniCMS. by <a href="mailto:admin@mng.cc" title="send email to author">Batmunkh Moltov</a>');}

if(!isset($_GET['t']))
{	
?>
	<script language="javascript">
	<!--
	var a=window.prompt('how many answers?',"insert some number");
	function check_a(b)
	{
		if(b<10 && b>1){
			c = '1';
		}else{
			alert("insert number between 2-10");
			c = 0;
		}
		return c;
	}
	if(check_a(a)!='1'){
		history.go(0);
	}else{
		window.location="index.php?module=poll&cmd=add_poll&t="+a;
	}
	document.write('--'+a+'___');
	//-->
	</script>
<?
}
?>
<table width="100%" class="tbl_main1" border="0" cellpadding="0" cellspacing="3">
<form name="form1" method="post" action="index.php?module=poll&cmd=add_poll&t=<?=$_GET['t']?>">
<?
if(isset($_POST['submit']))
{	
	$dt['question_mn'] = $_POST['question_mn'];
	$dt['question_en'] = $_POST['question_en'];
	$dt['session'] = session_id();
	$dt['st'] = $_POST['status'];
	
//		foreach($dt as $k => $v)
//			echo $k.'-'.$v.'<br>';

	$r_addpoll = $DB->mbm_insert_row($dt, "poll");
	
	$q_ques= "SELECT id FROM ".PREFIX."poll WHERE session='".session_id()."'";
	$r_ques= $DB->mbm_query($q_ques);
	
	$data['poll_id']= $DB->mbm_result($r_ques,0,"id");
	$data['st']=$_POST['status'];
	$d['poll_id']=$data['poll_id'];
	for($i=1;$i<=$_GET['t'];$i++)
	{
		$d['answer_en']=addslashes($_POST["a".$i."_en"]);
		$d['answer_mn']=addslashes($_POST["a".$i."_mn"]);
		$DB->mbm_insert_row($d, 'poll_a');
	}
	if($DB->mbm_query("UPDATE ".PREFIX."poll SET session='' WHERE id='".$data['poll_id']."'")==1){
		$result_txt = $lang['poll']['command_add_processed'];
	}else{
		$result_txt = $lang['poll']['command_add_failed'];
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
	$b=1;
}
if(!isset($b))
{
?>
  <tr align="center">
    <td colspan="2"><strong><?=$lang['poll']['en']?></strong>
          <br>
          <?
	  $sw = new SPAW_Wysiwyg('question_en' /*name*/,stripslashes($_POST['question_en']) /*value*/,
                       'en' /*language*/, 'mini' /*toolbar mode*/, 'default' /*theme*/,
                       '250px' /*width*/, '100px' /*height*/);
			$sw->show();
	  ?>
      <br />
	  <strong><?=$lang['poll']['mn']?></strong><br>
        <?
	  $sw = new SPAW_Wysiwyg('question_mn' /*name*/,stripslashes($_POST['question_mn']) /*value*/,
                       'en' /*language*/, 'mini' /*toolbar mode*/, 'default' /*theme*/,
                       '250px' /*width*/, '100px' /*height*/);
			$sw->show();
	  ?>  
      </td>
    </tr>
	<?
	for($i=1;$i<=$_GET['t'];$i++)
	{
		echo '<tr height="25" align="center">';
			echo '<td class="bold" colspan="2">';
			// english starts
			echo 'English -> <input type="text" size=45 class="input" name="a'.$i.'_en" ';
			echo 'value="';
			if(isset($_POST['a'.$i.'_en'])){
				echo $_POST['a'.$i.'_en'];
			}else{
				echo $lang['poll']['answer'].' '.$i;
			}
			echo '">';
			// english ends & mongol starts
			echo ' Монгол -> <input type="text" size=45 class="input" name="a'.$i.'_mn" ';
			echo 'value="';
			if(isset($_POST['a'.$i.'_mn'])){
				echo $_POST['a'.$i.'_mn'];
			}else{
				echo $lang['poll']['answer'].' '.$i;
			}
			echo '">';
			// mongol ends
			echo '</td>';
		echo '</tr>';
	}
	?>
  <tr>
    <td width="40%" align="right"><?=$lang['poll']['status']?></td>
    <td><select name="status" class="input">
          <option value="0">
          <?= $lang['status'][0]?>
          </option>
          <option value="1">
          <?= $lang['status'][1]?>
          </option>
    </select></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input type="submit" class="button" name="submit" value="<?=$lang['poll']['poll_add']?>"></td>
  </tr>
<?
}
?>
</form>
</table>