<script language="javascript">
mbmSetContentTitle("Admin history");
mbmSetPageTitle('Admin history');
show_sub('menu7');
</script><?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  $q_admin_history = "SELECT * FROM ".PREFIX."admin_history ORDER BY id DESC";
$r_admin_history = $DB->mbm_query($q_admin_history);

if((START+50) > $DB->mbm_num_rows($r_admin_history)){
	$end= $DB->mbm_num_rows($r_admin_history);
}else{
	$end= START+50; 
}
echo mbmNextPrev('index.php?module=settings&cmd=admin_history',$DB->mbm_num_rows($r_admin_history),START,50);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" style="border:1px solid #dddddd;">
  <tr class="list_header">
    <td>Info</td>
    <td width="50" align="center">lev</td>
    <td width="125" align="center">date</td>
    <td width="100" align="center">ip</td>
    <td width="150" align="center">GET</td>
    <td width="150" align="center">POST</td>
    <td width="150" align="center">SESSION</td>
  </tr>
<?
for($i=START;$i<$end;$i++){
	?>
  <tr>
    <td bgcolor="#f5f5f5"><strong>Username:</strong> <?
	if($DB->mbm_result($r_admin_history,$i,"user_id")==''){
		echo 'Guest';
	}else{
		echo $DB2->mbm_get_field($DB->mbm_result($r_admin_history,$i,"user_id"),'id','username','users');
	}
	?><br />
      <strong>Page:</strong> <?=$DB->mbm_result($r_admin_history,$i,"page")?><br />
     <strong>Brwoser:</strong><?=$DB->mbm_result($r_admin_history,$i,"browser")?></td>
    <td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_admin_history,$i,"lev")?></td>
    <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d H:i:s",$DB->mbm_result($r_admin_history,$i,"date_added"))?></td>
    <td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_admin_history,$i,"ip").'<br />'.mbmCountry($DB->mbm_result($r_admin_history,$i,"ip"))?></td>
    <td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_admin_history,$i,"get_values")?></td>
    <td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_admin_history,$i,"post_values")?></td>
    <td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_admin_history,$i,"session_values")?></td>
  </tr><?
}
?>
</table>