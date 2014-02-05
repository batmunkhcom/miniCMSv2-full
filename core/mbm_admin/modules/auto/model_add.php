<script language="javascript">
mbmSetContentTitle("<?=$lang["auto"]["model_add"]?>");
mbmSetPageTitle('<?=$lang["auto"]["model_add"]?>');
show_sub('menu5');

</script>
<?
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['addMark'])){
	$data['country'] = $_POST['country'];
	$data['auto_firm_id'] = $_POST['firm_id'];
	$data['auto_mark_id'] = $_POST['mark_id'];
	$data['auto_type_id'] = $DB->mbm_get_field($data['auto_mark_id'],'id','auto_type_id','auto_marks');
	$data['st'] = $_POST['st'];
	$data['lev'] = $_POST['lev'];
	$data['name'] = $_POST['name'];
	$data['comment'] = $_POST['comment'];
	$data['user_id'] = $_SESSION['user_id'];
	$data['lang'] = $_SESSION['ln'];
	$data['date_added'] = mbmTime();
	$data['date_lastupdated'] = $data['date_added'];
	if($data['name']==''){
		$result_txt = $lang['autos']['empty_name_field'];
	}else{
		if($DB->mbm_insert_row($data,'auto_models')==1){
			$result_txt = $lang['autos']['command_add_processed'];
			$b=1;
		}else{
			$result_txt = $lang['autos']['command_add_failed'];
		}
	}
	echo mbmError($result_txt);
}
if($b!=1){
?>
<form name="addFirm" method="post" action="" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="50%" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
	<?
    if(!isset($_GET['type'])){
    ?>
      <?
    }else{
    ?>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["country"]["country"]?>:<br />
          <select name="country" size="5" class="input" id="country">
            <?=mbmCountryList('dropdown')?>
          </select></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["auto"]["select_firm"]?>:<br />
          <label>
          <select name="firm_id" size="5" id="firm_id">
          </select>
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
       <tr>
        <td bgcolor="#f5f5f5"><?=$lang["auto"]["select_mark"]?>:<br />
          <label>
          <select name="mark_id" size="5" id="mark_id">
          </select>
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['main']['status']?>
          :<br />
          <select name="st" id="st">
            <?=mbmShowStOptions($_POST['st'])?>
          </select>        </td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['main']['level']?>
          :<br />
          <select name="lev">
            <?= mbmIntegerOptions(0, $_SESSION['lev'],$_POST['lev']); ?>
        </select></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["main"]["name"]?>:<br />
          <label>
          <input name="name" type="text" id="name" size="45" />
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["main"]["comment"]?>:<br />
          <label>
          <textarea name="comment" cols="45" rows="5" id="comment"></textarea>
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">
        <input type="submit" name="addModel" id="addModel" class="button" value="<?=$lang["auto"]["button_model_add"]?>"></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
    <?
    }
    ?>
</table>
</form>
<?
}
?>
