<script language="javascript">
mbmSetContentTitle("Хэрэглэгч бүртгэлийн мэдээлэл");
mbmSetPageTitle('Хэрэглэгч бүртгэлийн мэдээлэл');
show_sub('menu4');
</script>
<?		
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
} 
/*
$q_tmp = "SELECT * FROM ".USER_DB_PREFIX."users ORDER BY RAND() limit 350";
$r_tmp = $DB->mbm_query($q_tmp);

for($i=0;$DB->mbm_num_rows($r_tmp);$i++){
	$DB->mbm_query("UPDATE mbm_users SET date_registered='2007-11-".rand(1,11)."' WHERE id='".$DB->mbm_result($r_tmp,$i,"id")."'");
}
*/
?>
<table width="100%" border="0" cellspacing="2" cellpadding="0" style="border:1px solid #DDDDDD;">
<?
	$user_total = $DB2->mbm_result($DB2->mbm_query("SELECT COUNT(*) FROM ".USER_DB_PREFIX."users"),0);
	$q_user_reg = "SELECT date_added,COUNT(*) FROM ".USER_DB_PREFIX."users GROUP BY FROM_UNIXTIME(date_registered,%Y-%m-%d)";
	$r_user_reg = $DB2->mbm_query($q_user_reg);
	echo '<tr>';
	for($i=0;$i<$DB2->mbm_num_rows($r_user_reg);$i++){
		echo '<td align="center" width="200" bgcolor="#e2e2e2">'
				.'<strong>'.$DB2->mbm_result($r_user_reg,$i,0).'</strong>'
				.' <br />'
				.mbmPercent($DB2->mbm_result($r_user_reg,$i,1),$user_total,rand(0,5)).'</td>';
		if(($i%5)==4){
			echo '</tr><tr>';
		}
	}
	echo '</tr>';
?>
</table>
