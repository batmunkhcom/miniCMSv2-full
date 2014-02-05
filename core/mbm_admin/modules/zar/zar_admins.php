<script language="javascript">
mbmSetContentTitle("zar nemeh");
mbmSetPageTitle('zar nemeh');
show_sub('menu17');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  
if($_POST['addAdmin']){
	$admin_user_id = $DB2->mbm_get_field($_POST['username'],'username','id','users') ;
	if((int)($admin_user_id) == 0){
		$result_txt = 'no such user exists';
	}else{
		foreach($_POST['cat_id'] as $k=>$v){
			$q_check_user = "SELECT COUNT(id) FROM ".$DB2->prefix."zar_admins WHERE user_id='".$admin_user_id."' AND cat_id='".$v."'";
			$r_check_user = $DB2->mbm_query($q_check_user);
			if($DB2->mbm_result($r_check_user,0) == 0){
				$data['cat_id'] = $v;
				$data['user_id'] = $admin_user_id;
				$catname = $DB2->mbm_get_field($v,'id','name','zar_cats');
				if($DB2->mbm_insert_row($data,'zar_admins')==1){
					$result_txt .= '<div >';
					$result_txt .= 'added to <span>'.$catname.'</span>';
					$result_txt .= '</div>';
				}else{
					$result_txt .= '<div class="red">';
					$result_txt .= 'failed to add to <span>'.$catname.'</span>';
					$result_txt .= '</div>';
				}
				unset($data);
			}else{
					$result_txt .= '<div class="red">';
					$result_txt .= '<span>'.$catname.'</span> already exists';
					$result_txt .= '</div>';
			}
		}
		$b = 1;
	}
	echo mbmError($result_txt);
}
if($b!=1){
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr>
    <td width="50%" bgcolor="#f5f5f5">Select cat:<br>
      <select name="cat_id[]" size="10" id="cat_id" multiple="multiple" class="input" style="width:300px; font-weight:normal;">
      <?=mbmZarCatsDropDown()?>
      </select>    </td>
    <td width="50%" bgcolor="#f5f5f5">you can choose multiple categories using CONTROL button.</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">Username:<br />
      <input name="username" type="text" id="username" size="45" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" name="addAdmin" id="addAdmin" value="add user as admin" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  </table>
</form>
<?
}
$q_zar_admins = "SELECT ".$DB2->prefix."zar_admins.user_id,".$DB2->prefix."zar_admins.cat_id,".$DB2->prefix."users.username FROM ".$DB2->prefix."zar_admins,".$DB2->prefix."users WHERE ".$DB2->prefix."zar_admins.user_id=".$DB2->prefix."users.id ";
if(!isset($_GET['user_id'])){
	$q_zar_admins .= "GROUP BY ".$DB2->prefix."zar_admins.user_id ";
}else{
	$q_zar_admins .= "AND ".$DB2->prefix."zar_admins.user_id='".$_GET['user_id']."' ";
}
$q_zar_admins .= " ORDER BY ".$DB2->prefix."zar_admins.id DESC";
$r_zar_admins = $DB2->mbm_query($q_zar_admins);

?>
<h2>Zar admins</h2>
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="30" align="center">#</td>
    <td width="100">&nbsp;</td>
    <td>categories</td>
    <td width="120" align="center">Actions</td>
  </tr>
<?
for($i=0;$i<$DB2->mbm_num_rows($r_zar_admins);$i++){
	echo '<tr>';
		echo '<td align="center"><strong>'.($i+1).'.</strong></td>';
		echo '<td>'
				.'<a href="index.php?module=zar&cmd=zar_admins&user_id='.$DB2->mbm_result($r_zar_admins,$i,"user_id").'">'
				.$DB2->mbm_get_field($DB2->mbm_result($r_zar_admins,$i,"user_id"),'id','username','users')
				.'</a>'
				.'</td>';
		echo '<td>';
		if(!isset($_GET['user_id'])){
			echo ''
				.'<a href="index.php?module=zar&cmd=zar_admins&user_id='.$DB2->mbm_result($r_zar_admins,$i,"user_id").'">'
				 .'view cats'
				.'</a>'
				 .'';
		}else{
			echo $DB2->mbm_get_field($DB2->mbm_result($r_zar_admins,$i,"cat_id"),'id','name','zar_cats').', ';
		}
		echo '</td>';
		echo '<td align="center">';
			echo 'EDIT | DELETE';
		echo '</td>';
	echo '</tr>';
}
?>
</table>