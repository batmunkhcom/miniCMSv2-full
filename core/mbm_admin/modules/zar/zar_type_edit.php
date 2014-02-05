<script language="javascript">
mbmSetContentTitle("zar type edit");
mbmSetPageTitle('zar type edit');
show_sub('menu17');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if($_POST['editZarTypes']){
		if(strlen($_POST['name'])<3){
			$result_txt = 'Please fill name field.';
		}else{
			$data['user_id'] = $_SESSION['user_id'];
			$data['name'] = $_POST['name'];
			$data['comment'] = $_POST['comment'];
			$data['date_added'] = mbmTime();
			if($DB2->mbm_update_row($data,'zar_types',$_GET['id'])==1){
				$result_txt = 'update command processed.';
				$b=1;
			}else{
				$result_txt = 'update command failed.';
			}
		}
		echo '<div id="query_result">'.$result_txt.'</div>';
	}
$q_zar_types = "SELECT * FROM ".$DB2->prefix."zar_types WHERE id='".$_GET['id']."'";
$r_zar_types = $DB2->mbm_query($q_zar_types);
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
      <input name="name" type="text" id="name" size="45" value="<?=$DB2->mbm_result($r_zar_types,0,'name')?>"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">Comment:<br>
      <textarea name="comment" cols="45" rows="3" id="comment"><?=$DB2->mbm_result($r_zar_types,0,'comment')?></textarea></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" class="button" name="editZarTypes" id="editZarTypes" value="edit zar type"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  </table>
</form>
<?
}
?>