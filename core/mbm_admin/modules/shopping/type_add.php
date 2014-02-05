<script language="javascript">
mbmSetContentTitle("add type");
mbmSetPageTitle('add type');
show_sub('menu11');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['insertType'])){
	$data["st"] = $_POST['st'];
	$data["lev"] = $_POST['lev'];
	$data["user_id"] = $_SESSION['user_id'];
	$data["lang"] = $_SESSION['ln'];
	$data["name"] = $_POST['name'];
	$data["comment"] = $_POST['comment'];
	$data["date_added"] = mbmTime();
	$data["date_lastupdated"] = $data["date_added"];
	
	if(mbmCheckEmptyfield($data)){
		$result_txt = $lang['error']['empty_field'];
	}else{
		if($DB->mbm_insert_row($data,"shop_types")==1){
			$result_txt = $lang["shopping"]["command_insert_processed"];
			$b=1;
		}else{
			$result_txt = $lang["shopping"]["command_insert_failed"];
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
if($b!=1){
?><form name="addContent" method="post" action="" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="40%" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['main']['status']?>:<br>
          <select name="st" id="st">
          <?=mbmShowStOptions($_POST['st'])?>
          </select>      </td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['main']['level']?>:<br>
          <select name="lev">
            <?= mbmIntegerOptions(0, 5,$_POST['lev']); ?>
          </select></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["menu"]["name"]?>
          :<br />
        <label>
        <input name="name" type="text" id="name" value="<?=$_POST['name']?>" size="45" />
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["menu"]["menu_comment"]?>:<br />
          <label>
          <textarea name="comment" cols="45" rows="3" id="comment"><?=$_POST['comment']?></textarea>
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><label>
          <input type="submit" name="insertType" id="insertType" value="<?=$lang["shopping"]["button_insert"]?>" />
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
</table>  
</form>
<?
}
?>