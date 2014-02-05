<script language="javascript">
mbmSetContentTitle("<?=$lang["menu"]["Comments"]?>");
mbmSetPageTitle('<?= $lang["menu"]["Comments"]?>');
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
			
			if($_GET['v']==1){
				$DB->mbm_query("DELETE FROM ".PREFIX."comments WHERE id='".$_GET['id']."'");
			}else{
				$DB->mbm_update_row($q_data,'comments',$_GET['id']);
			}
			$result_txt = $lang["menu"]["comment_deleted"];
		break;
	}
	echo mbm_result($result_txt);
}
?>
<form id="form1" name="form1" method="post" action="" onsubmit="window.location='index.php?module=menu&cmd=comments&content_id='+document.getElementById('cid').value; return false;">
  <div align="center">
    <input name="cid" type="text" id="cid" value="comment code here" />
    <input type="submit" name="button" id="button" value="<?=$lang["menu"]["button_view_comment"]?>" onclick="window.location='index.php?module=menu&cmd=comments&content_id='+document.getElementById('cid').value" />
  </div>
</form>
<?
  	$q_menu_content_comments = "SELECT * FROM ".PREFIX."comments WHERE id!=0 ";
	if(isset($_GET['content_id']) && $_GET['content_id']!='' ){
		$q_menu_content_comments .= "AND content_id='".$_GET['content_id']."'";
		
		$continue_url = '&content_id='.$_GET['content_id'];
	}
	$q_menu_content_comments .= " ORDER BY id DESC";
	$r_menu_content_comments = $DB->mbm_query($q_menu_content_comments);
	
	if((START+PER_PAGE) > $DB->mbm_num_rows($r_menu_content_comments)){
		$end= $DB->mbm_num_rows($r_menu_content_comments);
	}else{
		$end= START+PER_PAGE; 
	}
echo  mbmNextPrev('index.php?module=comments&cmd=list'.$next_withmenu.$continue_url,$DB->mbm_num_rows($r_menu_content_comments),START,PER_PAGE);
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
    	echo '<strong>'.$DB->mbm_result($r_menu_content_comments,$i,"name").'</strong> ['.$DB->mbm_result($r_menu_content_comments,$i,"id").'-'.$DB->mbm_result($r_menu_content_comments,$i,"code").']'.'<br />';
		echo $DB->mbm_result($r_menu_content_comments,$i,"content");
	?>
    </td>
  <td align="center"><a href="#" onclick="confirmSubmit('<?=addslashes($lang['menu']['confirm_delete_menu'])?>','index.php?module=comments&cmd=list&action=delete&id=<?=$DB->mbm_result($r_menu_content_comments,$i,"id").$continue_url?>')">
  <img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" /></a>
  <a href="#" onclick="confirmSubmit('<?=addslashes($lang["menu"]["text_full_delete_comment"].' : '.$DB->mbm_result($r_menu_content_comments,$i,"id"))?>','index.php?module=comments&cmd=list&action=delete&id=<?=$DB->mbm_result($r_menu_content_comments,$i,"id").$continue_url?>&v=1')">
  <img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" /></a>
  </td>
  </tr>
  <tr><td style="height:1px; border-bottom: 1px solid #DDDDDD;" colspan="8"></td></tr>
  <?
  }
  ?>
</table>