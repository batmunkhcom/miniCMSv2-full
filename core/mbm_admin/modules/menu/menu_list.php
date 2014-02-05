<script language="javascript">
mbmSetContentTitle("<?=$lang["menu"]["menu_list"]?>");
mbmSetPageTitle('<?= $lang["menu"]["menu_list"]?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
echo '<div align="center">';
	if(isset($_GET['menu_id'])) $menu_code = $_GET['menu_id'];
	else $menu_code =0;
	echo mbmBuildPath($menu_code);
echo '</div>';

if(isset($_GET['action'])){
	switch($_GET['action']){
		case 'pos':
			mbmMenuUpdatePos($_GET['id']);
			$result_txt = $lang['menu']['command_processed'];
		break;
		case 'st':
			$DB->mbm_query("UPDATE ".PREFIX."menus SET st='".$_GET['st']."' WHERE id='".$_GET['id']."'");
			$result_txt = $lang['menu']['command_processed'];
		break;
		case 'lev':
			$DB->mbm_query("UPDATE ".PREFIX."menus SET lev='".$_GET['lev']."' WHERE id='".$_GET['id']."'");
			$result_txt = $lang['menu']['command_processed'];
		break;
	}
	echo mbm_result($result_txt);
}

?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
  	<td width="39" align="center">#</td>
    <td width="253"><?= $lang['menu']['name']?></td>
    <td width="190" align="center" ><?=$lang["main"]["pos"]?></td>
    <td width="64" align="center"><?=$lang["main"]["level"]?></td>
    <td width="64" align="center"><?=$lang["main"]["status"]?></td>
    <td width="64" align="center"><?=$lang['menu']['menu_link']?></td>
    <td width="140" align="center"><?=$lang['menu']['hits']?></td>
	<td width="145" align="center"><?=$lang["main"]["action"]?></td>
  </tr>
  <?
  	$q_menu = "SELECT * FROM ".PREFIX."menus WHERE lang='".$_SESSION['ln']."' ";
	if(isset($_GET['menu_id']) && $_GET['menu_id']!='' ){
		$q_menu .= "AND menu_id='".$_GET['menu_id']."'";
	}else{
		$q_menu .= "AND menu_id='0' ";
	}
	$q_menu .= " ORDER BY pos";
	$r_menu = $DB->mbm_query($q_menu);

	for($i=0;$i<$DB->mbm_num_rows($r_menu);$i++){
  ?>
  <tr <?=mbmonMouse("#e2e2e2","#d2d2d2","")?> height="20">
  	<td align="center" class="bold"><?=($i+1)?>.</td>
	<td><a <?
	if($DB->mbm_check_field('menu_id',$DB->mbm_result($r_menu,$i,"id"),'menus')==0){
		echo 'href="#" onClick="alert(\''.$lang['error']['no_sub_menu'].'\')"';
	}else{
		echo 'href="index.php?module=menu&cmd=menu_list&menu_id='.$DB->mbm_result($r_menu,$i,"id").'"';
	}
	?>><?=$DB->mbm_result($r_menu,$i,"name")?></a> [<?=$DB->mbm_result($r_menu,$i,"id")?>]</td>
  	<td align="center"><select name="menu_pos" onchange="window.location='index.php?module=menu&cmd=menu_list&menu_id=<?=$_GET['menu_id']?>&action=pos&id=<?=$DB->mbm_result($r_menu,$i,"id")?>&pos='+this.value">
	<?
			echo '<option value="0">'.$lang['menu']['at_the_begin'].'</option>';
		for($j=0;$j<$DB->mbm_num_rows($r_menu);$j++){
			echo '<option value="'.($DB->mbm_result($r_menu,$j,"pos")+0.1).'" ';
			if($DB->mbm_result($r_menu,$j,"pos")==$DB->mbm_result($r_menu,$i,"pos")){
				echo 'selected';
			}
			echo '>'.$lang['menu']['after_menu'].' '.$DB->mbm_result($r_menu,$j,"name").'..</option>';
		}
			echo '<option value="9999999999">'.$lang['menu']['at_the_end'].'</option>';
	?>
	  </select>  	</td>
  	<td align="center">
	  <select name="menu_lev" onchange="window.location='index.php?module=menu&cmd=menu_list&menu_id=<?=$_GET['menu_id']?>&action=lev&id=<?=$DB->mbm_result($r_menu,$i,"id")?>&lev='+this.value">
		<?= mbmIntegerOptions(0, 5,$DB->mbm_result($r_menu,$i,"lev"));?>
	  </select></td>
	<td align="center">
	  <?
      echo '<a href="index.php?module=menu&cmd=menu_list&action=st&'
	  		.'id='.$DB->mbm_result($r_menu,$i,"id").'&st='
	  		.(($DB->mbm_result($r_menu,$i,"st")+1)%2)
			.'&menu_id='.MENU_ID.'">';
	  echo '<img src="images/icons/status_'.$DB->mbm_result($r_menu,$i,"st").'.png" border="0" />';
	  echo '</a>';
	  ?></td>
  	<td align="center"><?
	if($DB->mbm_result($r_menu,$i,"link")=='http://' || strlen($DB->mbm_result($r_menu,$i,"link"))<4){
		echo '#';
	}else{
		echo '<img src="images/url.png" border="0" style="cursor:hand" alt="'.$DB->mbm_result($r_menu,$i,"link").'">';
	}
	?></td>
  	<td align="center"><?=$DB->mbm_result($r_menu,$i,"hits")?></td>
  <td align="center"><a href="index.php?module=menu&cmd=menu_edit&id=<?=$DB->mbm_result($r_menu,$i,"id")?>"><img src="images/<?=$_SESSION['ln']?>/button_edit.png" border="0" alt="<?= $lang['main']['edit']?>" hspace="3" /></a><a href="#" onclick="confirmSubmit('<?=addslashes($lang['menu']['confirm_delete_menu'])?>','index.php?module=menu&cmd=menu_delete&id=<?= $DB->mbm_result($r_menu,$i,"id")?>&menu_id=<?= $DB->mbm_result($r_menu,$i,"menu_id")?>')">
  <img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" /></a></td>

  <?
  }
  ?>
</table>
<?

function mbmMenuSiteMap($menu_id=0){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."menus WHERE menu_id='".$menu_id."' ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	$buf = '';
	
	static $subaa=0;

	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<div style="padding-left:'.(20*$DB->mbm_result($r,$i,"sub")).'px">'.$DB->mbm_result($r,$i,"name").' ['.$DB->mbm_result($r,$i,"id").'-'.$DB->mbm_result($r,$i,"sub").']</div>';
		if($DB->mbm_check_field('menu_id',$DB->mbm_result($r,$i,"id"),'menus')==1){
			$buf .= mbmMenuSiteMap($DB->mbm_result($r,$i,"id"));
		}
	}
	return $buf;
}
//echo mbmMenuSiteMap();
?>