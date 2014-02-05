<script language="javascript">
mbmSetContentTitle("<?=$lang["menu"]["content_list"]?>");
mbmSetPageTitle('<?=$lang["menu"]["content_list"]?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_GET['action'])) {
	switch($_GET['action']){
	case 'delete':
		mbmDeleteContents($_GET['id']);
	break;
	case 'st':
		$DB->mbm_query("UPDATE ".PREFIX."menu_contents SET st='".$_GET['st']."' WHERE id='".$_GET['id']."' LIMIT 1");
	break;
	case 'lev':
		$DB->mbm_query("UPDATE ".PREFIX."menu_contents SET lev='".$_GET['lev']."' WHERE id='".$_GET['id']."' LIMIT 1");
	break;
	}
	echo '<div id="query_result">'.$lang['menu']['command_processed'].'.</div>';
}
$q_contents = "SELECT * FROM ".PREFIX."menu_contents WHERE id!=0 ";
if($_GET['menu_id'] && $DB->mbm_check_field('id',$_GET['menu_id'],'menus')==1){
	$q_contents .= "AND menu_id LIKE '%,".$_GET['menu_id'].",%' ";
	$next_withmenu = '&menu_id='.$_GET['menu_id'];
}
$q_contents .= "ORDER BY date_added DESC";
$r_contents = $DB->mbm_query($q_contents);

?>
<form id="form1" name="form1" method="post" action="">
  <div align="center" style="margin:12px;">
    <select name="menu_id" size="18" style="width:400px;" 
     onchange="window.location='index.php?module=menu&cmd=content_list&menu_id='+this.value">
      <option value="0">
      <?=$lang['menu']['select_menus']?>
      </option>
      <?=mbmShowMenuCombobox(0); ?>
    </select>
  </div>
</form><?
echo  mbmNextPrev('index.php?module=menu&cmd=content_list'.$next_withmenu,$DB->mbm_num_rows($r_contents),START,PER_PAGE);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" style="border:1px solid #dddddd;">
  <tr class="list_header">
    <td width="30" align="center">&nbsp;</td>
    <td><?=$lang['menu']['content_title']?></td>
    <td width="120"><?=$lang['main']['username']?></td>
    <td width="50" align="center"><?=$lang["menu"]["content_type"]?></td>
    <td width="100" align="center"><?=$lang["menu"]["content_hits"]?></td>
    <td width="50" align="center">HTML</td>
    <td width="50" align="center"><?=$lang["menu"]["content_comment"]?></td>
    <td width="75" align="center"><?=$lang["main"]["date_added"]?></td>
    <td width="50" align="center"><?=$lang["main"]["status"]?></td>
    <td width="50" align="center"><?=$lang["main"]["level"]?></td>
    <td width="145" align="center"><?=$lang["main"]["action"]?></td>
  </tr><?

  	if((START+PER_PAGE) > $DB->mbm_num_rows($r_contents)){
		$end= $DB->mbm_num_rows($r_contents);
	}else{
		$end= START+PER_PAGE; 
	}
	for($i=START;$i<$end;$i++){
//for($i=0;$i<$DB->mbm_num_rows($r_contents);$i++){
?>
  <tr <?=mbmonMouse("#e2e2e2","#d2d2d2","")?>>
    <td align="center"><strong><?=($i+1)?>.</strong></td>
    <td><?
	echo mbm_substr($DB->mbm_result($r_contents,$i,"title"),30);
	if(mbm_strlen($DB->mbm_result($r_contents,$i,"title"))>30){
		echo '...';
	}
	?></td>
    <td><?=$DB2->mbm_get_field($DB->mbm_result($r_contents,$i,"user_id"),"id","username","users")?></td>
    <td align="center"><?
	if($DB->mbm_result($r_contents,$i,"is_video")==1){
		$content_type = '<a href="index.php?module=menu&amp;cmd=content_videos&amp;content_id='
						.$DB->mbm_result($r_contents,$i,"id").'" title="view video">';
		$content_type .= 'V (';
		$content_type .= $DB->mbm_result($DB->mbm_query("SELECT COUNT(*) FROM ".PREFIX."menu_videos WHERE content_id='"
							.$DB->mbm_result($r_contents,$i,"id")."'"),0);
		$content_type .= ') &raquo;</a>';					
	}elseif($DB->mbm_result($r_contents,$i,"is_video")==2){
		$content_type = '<a href="index.php?module=menu&amp;cmd=youtube_videos&amp;content_id='
						.$DB->mbm_result($r_contents,$i,"id").'" title="view video">';
		$content_type .= 'U (';
		$content_type .= $DB->mbm_result($DB->mbm_query("SELECT COUNT(*) FROM ".PREFIX."menu_youtube WHERE content_id='"
							.$DB->mbm_result($r_contents,$i,"id")."'"),0);
		$content_type .= ') &raquo;</a>';		
	}elseif($DB->mbm_result($r_contents,$i,"is_photo")==1){
		$content_type = '<a href="index.php?module=menu&amp;cmd=content_photos&amp;content_id='
						.$DB->mbm_result($r_contents,$i,"id").'" title="view photos">';
		$content_type .= 'PH (';
		$content_type .=  $DB->mbm_result($DB->mbm_query("SELECT COUNT(*) FROM ".PREFIX."menu_photos WHERE content_id='"
							.$DB->mbm_result($r_contents,$i,"id")."'"),0);
		$content_type .= ') &raquo;</a>';
	}else{
		$content_type = 'N &raquo;';
	}
	echo $content_type;
	?></td>
    <td align="center"><?=number_format($DB->mbm_result($r_contents,$i,"hits"))?></td>
    <td align="center"><?
    if($DB->mbm_result($r_contents,$i,"use_html")==1){
		$use_html = 'Y'; 
	}else{
		$use_html = 'N'; 
	}
	echo $use_html;
	?></td>
    <td align="center"><?
    if($DB->mbm_result($r_contents,$i,"use_comment")==1){
		$com_con = 'Y ('.mbmContentCommentsTotal($DB->mbm_result($r_contents,$i,"id")).')'; 
	}else{
		$com_con = 'N'; 
	}
	echo $com_con;
	?></td>
    <td align="center"><?=date("Y/m/d H:i:s",$DB->mbm_result($r_contents,$i,"date_added"))?></td>
    <td align="center"><?
    if($DB->mbm_result($r_contents,$i,"st")==1){
		$st_con = 'status_1.png'; 
	}else{
		$st_con = 'status_0.png'; 
	}
	echo '<a href="index.php?module=menu&cmd=content_list&action=st&id='.$DB->mbm_result($r_contents,$i,"id").'&st=';
		echo abs(($DB->mbm_result($r_contents,$i,"st")%2)-1);
	echo '"';
	echo '<img src="images/icons/'.$st_con.'" border="0" />';
	echo '</a>';
	?></td>
    <td align="center"> <select class="input" name="lev" 
    		onchange="window.location='index.php?module=menu&cmd=content_list&action=lev&menu_id=<?=MENU_ID?>&id=<?=$DB->mbm_result($r_contents,$i,"id")?>&lev='+this.value">
    <?= mbmIntegerOptions(0, $_SESSION['lev'],$DB->mbm_result($r_contents,$i,"lev")); ?>
    </select></td>
    <td align="center"><a href="index.php?module=menu&amp;cmd=content_edit&amp;id=<?=$DB->mbm_result($r_contents,$i,"id")?>&type=<?
    if($DB->mbm_result($r_contents,$i,"is_photo")==1){
		echo 'photo';
	}elseif($DB->mbm_result($r_contents,$i,"is_video")==1){
		echo 'video';
	}elseif($DB->mbm_result($r_contents,$i,"is_video")==2){
		echo 'youtube';
	}else{
		echo 'normal';
	}
	?>"><img src="images/<?=$_SESSION['ln']?>/button_edit.png" border="0" alt="<?= $lang['main']['edit']?>" hspace="3" /></a>
    <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=menu&cmd=content_list&id=<?=$DB->mbm_result($r_contents,$i,"id")?>&action=delete')">
    <img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" /></a></td>
  </tr><?
}
  ?>
</table>
