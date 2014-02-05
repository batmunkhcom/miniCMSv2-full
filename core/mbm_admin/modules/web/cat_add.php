<script language="javascript">
mbmSetContentTitle("<?=$lang["web"]["add_category"]?>");
mbmSetPageTitle('<?=$lang["web"]["add_category"]?>');
show_sub('menu9');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if($_POST['addCat']){
		if(strlen($_POST['name'])<3){
			$result_txt = 'Please fill name field.';
		}else{
			$data['cat_id'] = $_POST['cat_id'];
			if($_POST['cat_id']!=0){
				$data['sub'] = $DB->mbm_get_field($_POST['cat_id'],'id','sub','web_cats')+1;
			}
			$data['user_id'] = $_SESSION['user_id'];
			$data['lang'] = $_SESSION['ln'];
			$data['st'] = $_POST['st'];
			$data['lev'] = $_POST['lev'];
			$data['pos'] = mbmWebCatsMaxPos($data['cat_id']);
			$data['name'] = $_POST['name'];
			$data['comment'] = $_POST['comment'];
			$data['date_added'] = mbmTime();
			$data['date_lastupdated'] = $data['date_added'];
			if($DB->mbm_insert_row($data,'web_cats')==1){
				$result_txt = 'Insert command processod.';
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" bgcolor="#f5f5f5">Select cat:<br>
      <select name="cat_id" size="5" id="cat_id" class="input">
        <option value="0" selected >set as main</option>
      <?=mbmWebCatsDropDown()?>
      </select>    </td>
    <td width="50%" bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">cat level:<br>
        <select name="lev" id="lev" class="input">
          <?= mbmIntegerOptions(0, $_SESSION['lev'],$_POST['lev']); ?>
              </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">cat status:<br>
        <select name="st" id="st" class="input">
          <option value="0">
          <?= $lang['status'][0]?>
          </option>
          <option value="1" <?
          	if($_POST['st']==1){
				echo ' selected ';
			}
		  ?>>
          <?= $lang['status'][1]?>
          </option>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
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
    <td bgcolor="#f5f5f5"><input type="submit" class="button" name="addCat" id="addCat" value="add category"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  </table>
</form>
<?
}
?>