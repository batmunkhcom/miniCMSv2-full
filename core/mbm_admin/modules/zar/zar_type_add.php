<script language="javascript">
mbmSetContentTitle("zar type add");
mbmSetPageTitle('zar type add');
show_sub('menu17');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if($_POST['addZarTypes']){
		if(strlen($_POST['name'])<3){
			$result_txt = 'Please fill name field.';
		}else{
			$data['user_id'] = $_SESSION['user_id'];
			$data['name'] = $_POST['name'];
			$data['comment'] = $_POST['comment'];
			$data['date_added'] = mbmTime();
			if($DB2->mbm_insert_row($data,'zar_types')==1){
				$result_txt = 'Insert command processed.';
				$b=1;
			}else{
				$result_txt = 'Insert command failed.';
			}
		}
		echo '<div id="query_result">'.$result_txt.'</div>';
	}
if($b!=1){
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="50%" >&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">Name:<br>
      <input name="name" type="text" id="name" size="45" value="<?=$_POST['name']?>"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">Comment:<br>
      <textarea name="comment" cols="45" rows="3" id="comment"><?=$_POST['comment']?></textarea></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" class="button" name="addZarTypes" id="addZarTypes" value="add zar type"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  </table>
</form>
<?
}
$q_zar_types = "SELECT * FROM ".$DB2->prefix."zar_types ORDER BY name ASC";
$r_zar_types = $DB2->mbm_query($q_zar_types);
echo '<br /><br />';
for($i=0;$i<$DB2->mbm_num_rows($r_zar_types);$i++){
	echo '<a href="index.php?module=zar&cmd=zar_type_edit&id='.$DB2->mbm_result($r_zar_types,$i,'id').'">'.$DB2->mbm_result($r_zar_types,$i,'name').'</a><br />';
}
?>