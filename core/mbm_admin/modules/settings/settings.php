<script language="javascript">
mbmSetContentTitle("<?= $lang['settings']['main']?>");
mbmSetPageTitle('<?= $lang['settings']['main']?>');
show_sub('menu7');
</script><?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_POST['save_settings'])){
	$q_main_settings1 = "SELECT * FROM ".PREFIX."settings ORDER BY name";	
	$r_main_settings1 = $DB->mbm_query($q_main_settings1);
	for($i=0;$i<$DB->mbm_num_rows($r_main_settings1);$i++){	
		$DB->mbm_query("UPDATE ".PREFIX."settings SET value='".$_POST[$DB->mbm_result($r_main_settings1,$i,"name")]."' 
						WHERE name='".$DB->mbm_result($r_main_settings1,$i,"name")."' LIMIT 1");
	}
	echo '<div id="query_result">'.$lang["admin_settings"]["command_update_processed"].'.</div>';
	
}else{
$q_main_settings = "SELECT * FROM ".PREFIX."settings ORDER BY id";	
$r_main_settings = $DB->mbm_query($q_main_settings);
?>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="2" cellpadding="4" class="tblContent">
    <tr class="list_header">
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>Хувьсагчууд </td>
    </tr>
    <?
   	for($i=0;$i<$DB->mbm_num_rows($r_main_settings);$i++){	
	?>
    <tr>
      <td width="150" align="right" bgcolor="#f9f9f9"><?=$DB->mbm_result($r_main_settings,$i,"name")?></td>
      <td width="350"><textarea name="<?=$DB->mbm_result($r_main_settings,$i,"name")?>" cols="60" rows="3"><?=$DB->mbm_result($r_main_settings,$i,"value")?></textarea></td>
      <td bgcolor="#f9f9f9">{<?=strtoupper($DB->mbm_result($r_main_settings,$i,"name"))?>}</td>
    </tr>
    <?
    }
	?>
    <tr>
      <td align="right" bgcolor="#f9f9f9">&nbsp;</td>
      <td><input type="submit" name="save_settings" value="<?=$lang['main']['edit']?>" /></td>
      <td bgcolor="#f9f9f9">&nbsp;</td>
    </tr>
  </table>
</form>
<?
}
?>