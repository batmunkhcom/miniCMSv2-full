<script language="javascript">
mbmSetContentTitle("<?= $lang['poll']['poll_list']?>");
mbmSetPageTitle('<?= $lang['poll']['poll_list']?>');
show_sub('menu6');
</script>
<?
if(!isset($mBm) || $mBm!=1)
	{ die('MNG miniCMS. by <a href="mailto:admin@mng.cc" title="send email to author">Batmunkh Moltov</a>');}
?>
<table width="100%"  border="0" cellspacing="1" cellpadding="0" class="tbl_main1">
 <tr height="25"  class="list_header">
	<td width="30" align="center">#</td>
    <td>&nbsp;<?=$lang['poll']['name']?></td>
  	<td width="200"><?=$lang['poll']['total']?></td>
    <td width="100"><?=$lang['menu']['status']?></td>
  </tr>
  <?
  switch($_GET['action']){
  	case 'st':
		$DB->mbm_query("UPDATE ".PREFIX."poll SET st='".$_GET['st']."' WHERE id='".$_GET['id']."'");
	break;
  }
  	$q_poll= $DB->mbm_query("SELECT * FROM ".PREFIX."poll ORDER BY id DESC");
	for($i=0; $i< $DB->mbm_num_rows($q_poll); $i++)
	{
  ?> 
    <tr <?=mbmonMouse("#e2e2e2","#d2d2d2","")?> height="20">
  	<td align="center" class="bold"><?=($i+1)?>.</td>
    <td class="bold">&nbsp;<a href="../index.php?module=poll&cmd=view_vote&id=<?= $DB->mbm_result($q_poll,$i,"id")?>" target="_blank"><?= $DB->mbm_result($q_poll,$i,"question_".$_SESSION['ln'])?></a></td>
    <td><?
		echo $DB->mbm_num_rows($DB->mbm_query("SELECT * FROM ".PREFIX."poll_r WHERE poll_id='".$DB->mbm_result($q_poll,$i,"id")."'"));
	?></td>
    <td width="75"><select name="poll_st" onchange="window.location='index.php?module=poll&cmd=list_poll&action=st&st=<?=(($DB->mbm_result($q_poll,$i,"st")+1)%2)?>&id=<?=$DB->mbm_result($q_poll,$i,"id")?>'">
		<?=mbmShowStOptions($DB->mbm_result($q_poll,$i,"st"))?>
	  </select></td>
  </tr>
  <tr height="1" bgcolor="#999999"><td colspan="4"></td></tr>
  <?
	}
  ?>
 
</table>
