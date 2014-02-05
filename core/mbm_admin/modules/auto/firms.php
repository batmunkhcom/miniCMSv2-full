<script language="javascript" type="text/javascript" charset="utf-8">
mbmSetContentTitle("<?=$lang["auto"]["car_firms"]?>");
mbmSetPageTitle('<?=$lang["auto"]["car_firms"]?>');
show_sub('menu5');



</script>
<?
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_GET['action'])){
	switch($_GET['action']){
		case 'delete';
			$DB->mbm_query("DELETE FROM ".PREFIX."auto_firms WHERE id='".addslashes($_GET['id'])."' LIMIT 1");
		break;
		case 'st';
			$DB->mbm_query("UPDATE ".PREFIX."auto_firms SET st='".addslashes($_GET['st'])."' WHERE id='".addslashes($_GET['id'])."' LIMIT 1 ");
		break;
	}
}

$q_firms = "SELECT * FROM ".PREFIX."auto_firms ORDER BY name";
$r_firms = $DB->mbm_query($q_firms);
?>
<div style="width:100px; padding:10px; border:1px solid #DDD; background-color:#F5F5F5; font-weight:bold; text-align:center; float:right; margin:5px;"><a href="index.php?module=auto&amp;cmd=firm_add"><?=$lang['auto']['firm_add']?></a></div>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="30" align="center" >#</td>
    <td><?=$lang['main']['name']?></td>
    <td width="150" align="center" ><?=$lang['main']['country']?></td>
    <td width="75" align="center"><?=$lang['main']['username']?></td>
    <td width="50" align="center" ><?=$lang['main']['status']?></td>
    <td width="75" align="center" ><?=$lang['main']['date_added']?></td>
    <td width="150" align="center"><?=$lang['main']['action']?></td>
  </tr>
  <?
  for($i=0;$i<$DB->mbm_num_rows($r_firms);$i++){
  ?>
  <tr>
    <td align="center" class="bold"><?=($i+1)?>.</td>
    <td><?=$DB->mbm_result($r_firms,$i,"name")?></td>
    <td align="center" ><?=$DB->mbm_result($r_firms,$i,"country")?></td>
    <td align="center"><?=$DB2->mbm_get_field($DB->mbm_result($r_firms,$i,"user_id"),'id','username','users')?></td>
    <td align="center" ><?
    if($DB->mbm_result($r_firms,$i,"st")==1){
		$st_con = 'status_1.png'; 
	}else{
		$st_con = 'status_0.png'; 
	}
	echo '<a href="index.php?module=auto&cmd=firms&action=st&id='.$DB->mbm_result($r_firms,$i,"id").'&st=';
		echo abs(($DB->mbm_result($r_firms,$i,"st")%2)-1);
	echo '"';
	echo '<img src="images/icons/'.$st_con.'" border="0" />';
	echo '</a>';
	?></td>
    <td align="center" ><?=date("Y/m/d",$DB->mbm_result($r_firms,$i,"date_added"))?></td>
    <td align="center">
    <a href="index.php?module=auto&amp;cmd=firm_edit&amp;id=<?=$DB->mbm_result($r_firms,$i,"id")?>"><img src="images/<?=$_SESSION['ln']?>/button_edit.png" border="0" alt="<?= $lang['main']['edit']?>" hspace="3" /></a>
    <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=auto&cmd=firms&id=<?=$DB->mbm_result($r_firms,$i,"id")?>&action=delete')">
    <img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" /></a>
    </td>
  </tr>
  <?
  }
  ?>
</table>
</form>
