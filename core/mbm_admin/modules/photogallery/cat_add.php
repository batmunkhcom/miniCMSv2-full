<script language="javascript">
mbmSetContentTitle("<?=$lang['photogallery']['category_add']?>");
mbmSetPageTitle('<?=$lang['photogallery']['category_add']?>');
show_sub('menu15');

</script>
<?
if(isset($_POST['addPhotoCategory'])){
	$data["user_id"] = $_SESSION['user_id'];
	$data["gallery_id"] = 0;
	$data["sub"] = 0;
	$data["st"] = $_POST['st'];
	$data["name"] = $_POST['name'];
	$data["comment"] = $_POST['comment'];
	$data["date_added"] = mbmTime();
	$data["date_lastupdated"] = $data["date_added"];
	$data["total_updated"] = 0;
	$data["secret_key"] = mbmPhotoGalleryGenerateSecretKey();
	if($_POST['private']==1){
		$data["private"] = $_POST['private'];
	}
	if($_POST['user_upload']==1){
		$data["user_upload"] = $_POST['user_upload'];
	}
	if($data['name']==''){
		$result_txt = 'Insert some name';
	}else{
		$r_cat_add = $DB->mbm_insert_row($data,"galleries");
		if($r_cat_add==1){
			$result_txt = 'Successfully added';
			$b=1;
		}else{
			$result_txt = 'Add process failed.';
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
if($b!=1){
?>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="50%" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td bgcolor="#F5F5F5">Status:<br />
        <select name="st" id="st">
          <option value="0">
          <?= $lang['status'][0]?>
          </option>
          <option value="1">
          <?= $lang['status'][1]?>
          </option>
      </select></td>
    <td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr >
    <td bgcolor="#F5F5F5" >&nbsp;</td>
    <td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr >
    <td bgcolor="#F5F5F5" ><table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="50%" align="center" bgcolor="#e2e2e2">Private:</td>
        <td align="center" bgcolor="#e2e2e2">User upload:</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF"><input name="private" type="checkbox" id="private" value="1" /></td>
        <td align="center" bgcolor="#FFFFFF"><input name="user_upload" type="checkbox" id="user_upload" value="1" checked="checked" /></td>
      </tr>
    </table></td>
    <td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr >
    <td bgcolor="#F5F5F5" >&nbsp;</td>
    <td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr >
    <td bgcolor="#F5F5F5" >Name:<br />
      <input name="name" type="text" id="name" size="45" value="<?=$_POST['name']?>" class="input" /></td>
    <td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr >
    <td bgcolor="#F5F5F5" >&nbsp;</td>
    <td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr >
    <td bgcolor="#F5F5F5" >Comment:<br />
      <textarea name="comment" cols="45" rows="5" id="comemnt"><?=$_POST['comment']?></textarea></td>
    <td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr >
    <td bgcolor="#F5F5F5" >&nbsp;</td>
    <td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr >
    <td bgcolor="#F5F5F5" ><input type="submit" name="addPhotoCategory" class="button" id="addPhotoCategory" value="Add category" /></td>
    <td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
</table>
</form>
<?
}
?>