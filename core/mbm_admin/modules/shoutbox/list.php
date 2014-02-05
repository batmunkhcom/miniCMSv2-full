<script language="javascript">
mbmSetContentTitle("<?=$lang["shoutbox"]["title"]?>");
mbmSetPageTitle('<?= $lang["shoutbox"]["title"]?>');
show_sub('menu2');
</script>
<?		
	if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
		die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
	}
	if(isset($_GET['action'])){
		switch($_GET['action']){
			case 'delete':
				$q_data['comment'] = $lang["menu"]["comment_deleted_by"].' '.$DB2->mbm_get_field($_SESSION['user_id'],'id','username','users');
				
				$DB->mbm_query("DELETE FROM ".PREFIX."shoutbox WHERE id='".$_GET['id']."'");
				$result_txt = $lang["menu"]["comment_deleted"];
			break;
		}
		echo mbm_result($result_txt);
	}
	
  	$q_shoutbox = "SELECT * FROM ".PREFIX."shoutbox WHERE id!=0 ";
	$q_shoutbox .= " ORDER BY id DESC";
	$r_shoutbox = $DB->mbm_query($q_shoutbox);
	
	if((START+PER_PAGE) > $DB->mbm_num_rows($r_shoutbox)){
		$end= $DB->mbm_num_rows($r_shoutbox);
	}else{
		$end= START+PER_PAGE; 
	}
echo  mbmNextPrev('index.php?module=shoutbox&cmd=list'.$next_withmenu.$continue_url,$DB->mbm_num_rows($r_shoutbox),START,PER_PAGE);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
  	<td width="39" align="center">#</td>
    <td > </td>
	<td width="145" align="center"><?=$lang["main"]["action"]?></td>
  </tr>
  <?
	for($i=START;$i<$end;$i++){
  ?>
  <tr <?=mbmonMouse("#e2e2e2","#d2d2d2","")?> height="20">
  	<td align="center" class="bold"><?=($i+1)?>.</td>
	<td>
    <?
    	echo '<strong>';
		echo $DB->mbm_result($r_shoutbox,$i,"name").' - '.$DB->mbm_result($r_shoutbox,$i,"email");
		echo '</strong> ['.$DB->mbm_result($r_shoutbox,$i,"country").']';
		echo '<br />';
		echo $DB->mbm_result($r_shoutbox,$i,"content");
	?>
    </td>
  <td align="center">
  <a href="#" onclick="confirmSubmit('<?=addslashes($lang["menu"]["text_full_delete_comment"].' : '.$DB->mbm_result($r_shoutbox,$i,"id"))?>','index.php?module=shoutbox&cmd=list&action=delete&id=<?=$DB->mbm_result($r_shoutbox,$i,"id").$continue_url?>&v=1')">
  <img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" /></a>
  </td>
  </tr>
  <tr><td style="height:1px; border-bottom: 1px solid #DDDDDD;" colspan="8"></td></tr>
  <?
  }
  ?>
</table>