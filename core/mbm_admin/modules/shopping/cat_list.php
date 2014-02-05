<script language="javascript">
mbmSetContentTitle("<?=$lang["shopping"]["categories"]?>");
mbmSetPageTitle('<?=$lang["shopping"]["categories"]?>');
show_sub('menu11');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['update_pos'])){
	foreach($_POST['pos'] as $k=>$v){
		$DB->mbm_query("UPDATE ".PREFIX."shop_cats SET pos='".$v."' WHERE id='".$k."'");
	}
}
if(isset($_GET['action'])){
	switch($_GET['action']){
		case 'lev':
			$DB->mbm_query("UPDATE ".PREFIX."shop_cats SET lev='".$_GET['lev']."' WHERE id='".$_GET['id']."'");
		break;
		case 'st':
			$DB->mbm_query("UPDATE ".PREFIX."shop_cats SET st='".$_GET['st']."' WHERE id='".$_GET['id']."'");
		break;
		case 'delete':
			$DB->mbm_query("DELETE FROM ".PREFIX."shop_cats WHERE id='".$_GET['id']."'");
			$DB->mbm_query("DELETE FROM ".PREFIX."shop_products WHERE cat_ids like '%,".$_GET['id'].",%'");
		break;
	}
}

$q_cats = "SELECT * FROM ".PREFIX."shop_cats WHERE lang='".$_SESSION['ln']."' ";
if(isset($_GET['cat_id']) && $_GET['cat_id']!=''){
	$q_cats .= "AND shop_cat_id=".$_GET['cat_id']." ";
}else{
	$q_cats .= "AND shop_cat_id=0 ";
}
$q_cats .= "ORDER BY pos";
$r_cats = $DB->mbm_query($q_cats);
?>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
    <tr class="list_header">
      <td width="30" align="center" >&nbsp;</td>
      <td>name</td>
      <td width="75">user</td>
      <td width="75" align="center">pos</td>
      <td width="50" align="center">lev</td>
      <td width="50" align="center">st</td>
      <td width="50" align="center">link</td>
      <td width="75" align="center">date added</td>
      <td width="75" align="center">lastupdate</td>
      <td width="150" align="center">Actions</td>
    </tr>
    <?
  for($i=0;$i<$DB->mbm_num_rows($r_cats);$i++){
  ?>
    <tr>
      <td align="center" valign="top"><strong>
        <?=($i+1)?>
        .</strong></td>
      <td valign="top"><?
		echo '<a href="';
			if($DB->mbm_check_field('shop_cat_id',$DB->mbm_result($r_cats,$i,"id"),'shop_cats')){
				echo 'index.php?module=shopping&cmd=cat_list&cat_id='.$DB->mbm_result($r_cats,$i,"id");
			}else{
				echo '#" onclick="alert(\'no sub cat\')"';
			}
		echo '">'
			.$DB->mbm_result($r_cats,$i,"name").'</a> ['.$DB->mbm_result($r_cats,$i,"id").']';
		echo '<br />'.$DB->mbm_result($r_cats,$i,"comment");
		?></td>
      <td valign="top"><?=$DB2->mbm_get_field($DB->mbm_result($r_cats,$i,"user_id"),'id','username','users')?></td>
      <td align="center" valign="top"><input name="pos[<?=$DB->mbm_result($r_cats,$i,"id")?>]" value="<?=$DB->mbm_result($r_cats,$i,"pos")?>" type="text" id="pos[]" size="5" /></td>
      <td align="center" valign="top"><select name="menu_lev" onchange="window.location='index.php?module=shopping&amp;cmd=cat_list&amp;cat_id=<?=$_GET['cat_id']?>&amp;action=lev&amp;lev='+this.value+'&amp;id=<?=$DB->mbm_result($r_cats,$i,"id")?>'">
          <?= mbmIntegerOptions(0, 5,$DB->mbm_result($r_cats,$i,"lev"));?>
      </select></td>
      <td align="center" valign="top"><?
	echo '<a href="index.php?module=shopping&cmd=cat_list&cat_id='.$_GET['cat_id'].'&action=st&st='.(($DB->mbm_result($r_cats,$i,"st")+1)%2).'&id='.$DB->mbm_result($r_cats,$i,"id").'">';
	  echo '<img src="images/icons/status_'.$DB->mbm_result($r_cats,$i,"st").'.png" border="0" />';
	  echo '</a>';
	?></td>
      <td align="center" valign="top"><?=$DB->mbm_result($r_cats,$i,"link")?></td>
      <td align="center" valign="top"><?=date("Y/m/d",$DB->mbm_result($r_cats,$i,"date_added"))?></td>
      <td align="center" valign="top"><?=date("Y/m/d",$DB->mbm_result($r_cats,$i,"date_lastupdated")).'<br />'.$DB->mbm_result($r_cats,$i,"total_updated")?></td>
      <td align="center" valign="top"><a href="index.php?module=shopping&amp;cmd=cat_edit&amp;id=<?=$DB->mbm_result($r_cats,$i,"id")?>">
        <img src="images/<?=$_SESSION['ln']?>/button_edit.png" border="0" alt="<?= $lang['main']['edit']?>" hspace="3" />
        </a> <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=shopping&amp;cmd=cat_list&amp;id=<?=$DB->mbm_result($r_cats,$i,"id")?>&amp;action=delete')">
        <img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" />
      </a></td>
    </tr>
    <?
  }
  ?>
  </table>
  <div align="center">
    <input type="submit" name="update_pos" id="update_pos" value="Update pos" />
  </div>
</form>
