<script language="javascript">
mbmSetContentTitle("list types");
mbmSetPageTitle('list types');
show_sub('menu11');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_GET['action'])){
	switch($_GET['action']){
		case 'st':
			$DB->mbm_query("UPDATE ".PREFIX."shop_types SET st='".$_GET['st']."' WHERE id='".$_GET['id']."'");
		break;
		case 'lev':
			$DB->mbm_query("UPDATE ".PREFIX."shop_types SET lev='".$_GET['lev']."' WHERE id='".$_GET['id']."'");
		break;
		case 'delete':
			$DB->mbm_query("DELETE FROM ".PREFIX."shop_types WHERE id='".$_GET['id']."'");
		break;
	}
}	
	
	$q_shop_types = "SELECT * FROM ".PREFIX."shop_types ORDER BY id";
	$r_shop_types = $DB->mbm_query($q_shop_types);

?>
    <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
      <tr class="list_header">
        <td width="30" align="center">#</td>
        <td>name</td>
        <td>st</td>
        <td>pos</td>
        <td width="100" align="center">Action</td>
      </tr>
      <?
      for($i=0;$i<$DB->mbm_num_rows($r_shop_types);$i++){
	  ?>
      <tr>
        <td align="center" bgcolor="#F5F5F5"><strong>
        <?=($i+1)?>
        </strong></td>
        <td bgcolor="#F5F5F5"><?=$DB->mbm_result($r_shop_types,$i,'name')?></td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td align="center" bgcolor="#F5F5F5"><a href="index.php?module=shopping&amp;cmd=product_edit&amp;cat_id=<?=$_GET['cat_id']?>&amp;id=<?=$DB->mbm_result($r_shop_types,$i,"id")?>">
          <?=$lang["main"]["edit"]?>
        </a> | <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=shopping&amp;cmd=product_list&amp;cat_id=<?=$_GET['cat_id']?>&amp;id=<?=$DB->mbm_result($r_shop_types,$i,"id")?>&amp;action=delete')">
        <?=$lang["main"]["delete"]?>
        </a></td>
      </tr>
      <?
      }
	  ?>
</table>