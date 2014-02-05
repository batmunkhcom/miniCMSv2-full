<script language="javascript">
mbmSetContentTitle("<?=$lang["companies"]["add_company"]?>");
mbmSetPageTitle('<?=$lang["companies"]["add_company"]?>');
show_sub('menu18');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}

switch($_GET['action']){
	case 'delete':
		if($DB->mbm_query("DELETE FROM ".$DB->prefix."companies WHERE id='".(int)($_GET['id'])."' LIMIT 1")==1){
			$result_txt  = 'deleted';
		}else{
			$result_txt = 'Error occurred.';
		}
	break;
	case 'st':
		if($DB->mbm_query("UPDATE ".$DB->prefix."companies SET st='".(int)($_GET['st'])."' WHERE id='".(int)($_GET['id'])."' LIMIT 1")==1){
			$result_txt  = 'st updated';
		}else{
			$result_txt = 'Error occurred.';
		}
	break;
}
if(strlen($result_txt)>3){
	echo mbmError($result_txt);
}

$q_companies = "SELECT * FROM ".$DB->prefix."companies ORDER BY date_added DESC";
$r_companies = $DB->mbm_query($q_companies);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="30" align="center">#</td>
    <td>name</td>
    <td ></td>
    <td></td>
    <td width="50" align="center">st</td>
    <td width="145" align="center">Actions</td>
  </tr>
<?
for($i=0;$i<$DB->mbm_num_rows($r_companies);$i++){
	echo '  <tr valign="top">
				<td width="30" align="center"><strong>'.($i+1).'.</strong></td>
				<td>';
		echo '<img src="'.DOMAIN.DIR.$DB->mbm_result($r_companies,$i,"logo").'" width="100" align="left" hspace="5" />';
		echo '<h3>'.$DB->mbm_result($r_companies,$i,"name_mn").'</h3>';
		echo $DB->mbm_result($r_companies,$i,"name_en").'<br />';
		echo 'phone : '.$DB->mbm_result($r_companies,$i,"phone").'<br />';
		echo 'email : '.$DB->mbm_result($r_companies,$i,"email").'<br />';
		echo 'web : '.$DB->mbm_result($r_companies,$i,"web").'<br />';
		echo 'address : '.$DB->mbm_result($r_companies,$i,"address").'<br />';
		echo '</td>
				<td ></td>
				<td></td>
				<td align="center">';
      echo '<a href="index.php?module=companies&cmd=companies&action=st&'
	  		.'id='.$DB->mbm_result($r_companies,$i,"id").'&st='
	  		.(($DB->mbm_result($r_companies,$i,"st")+1)%2)
			.'">';
	  echo '<img src="images/icons/status_'.$DB->mbm_result($r_companies,$i,"st").'.png" border="0" />';
	  echo '</a>';
		echo '</td>
				<td align="center">';
		echo '<a href="index.php?module=companies&cmd=company_edit&id='.$DB->mbm_result($r_companies,$i,"id").'"><img src="images/'.$_SESSION['ln'].'/button_edit.png" border="0" alt="'.$lang['main']['edit'].'" hspace="3" /></a>
		<a href="#" onclick="confirmSubmit(\''.addslashes($lang['menu']['confirm_delete_menu']).'\',\'index.php?module=companies&cmd=companies&action=delete&id='.$DB->mbm_result($r_companies,$i,"id").'\')">
  <img src="images/'.$_SESSION['ln'].'/button_delete.png" border="0" alt="'.$lang['main']['delete'].'" /></a>';
		echo '</td>
			  </tr>';
}
?>
</table>