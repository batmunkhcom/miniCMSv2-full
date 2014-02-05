<script language="javascript">

mbmSetContentTitle("List newsletter");

mbmSetPageTitle('List newsletter');

show_sub('menu16');

</script>

<?

if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){

	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');

}

?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" style = "border: 1px solid rgb(221, 221, 221);">

  <tr class = "list_header">

    <td width="30" align="center">#</td>

    <td width="75" align="center">username</td>

    <td align="center">Subject</td>

    <td width="75" align="center">From name</td>

    <td width="125" align="center">From email</td>

    <td width="50" align="center">st</td>

    <td width="50" align="center">lev</td>

    <td width="75" align="center">per send</td>

    <td width="50" align="center">interval</td>

    <td width="75" align="center">hits</td>

    <td width="75" align="center">date added</td>

    <td width="100" align="center">Action</td>

  </tr>

<?

$q_newsletters = "SELECT * FROM ".PREFIX."newsletters ORDER BY id DESC";

$r_newsletters = $DB->mbm_query($q_newsletters);



for($i=0;$i<$DB->mbm_num_rows($r_newsletters);$i++){

?>

  <tr>

    <td height="25" align="center"><strong>

      <?=($i+1)?>

    </strong></td>

    <td><?=$DB2->mbm_get_field($DB->mbm_result($r_newsletters,$i,"user_id"),'id','username','users')?></td>

    <td><?=$DB->mbm_result($r_newsletters,$i,"subject")?></td>

    <td><?=$DB->mbm_result($r_newsletters,$i,"name_from")?></td>

    <td><?=$DB->mbm_result($r_newsletters,$i,"email_from")?></td>

    <td align="center"><?=$DB->mbm_result($r_newsletters,$i,"st")?></td>

    <td align="center"><?=$DB->mbm_result($r_newsletters,$i,"lev")?></td>

    <td align="center"><?=$DB->mbm_result($r_newsletters,$i,"per_send")?></td>

    <td align="center"><?=$DB->mbm_result($r_newsletters,$i,"intervals")?></td>

    <td align="center"><?

	echo $DB->mbm_result($r_newsletters,$i,"hits");

	?></td>

    <td align="center"><?=date("Y/m/d",$DB->mbm_result($r_newsletters,$i,"date_added"))?></td>

    <td align="center"><a href="#">Edit</a> | <a href="#">Delete</a></td>

  </tr>

<?

}

?>

</table>

