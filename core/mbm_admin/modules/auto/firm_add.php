<script language="javascript" type="text/javascript" charset="utf-8">
mbmSetContentTitle("<?=$lang["auto"]["firm_add"]?>");
mbmSetPageTitle('<?=$lang["auto"]["firm_add"]?>');
show_sub('menu5');
</script>
<?
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
?>

<script type="text/javascript">

$().ready(function() {
	var country = $("#country");
	var countryResult = $("#countryResult");
		
	$("#country").live("keypress",function(){
		$('#countryResult').show();
		$("#countryResult").html('<img src="<?=DOMAIN.DIR?>images/loading.gif" border="0" />');
		$.ajax({
				type: "GET", url: "<?=DOMAIN.DIR?>xml.php?action=country&type=autocomplete", data: "q="+country.attr("value"),
				complete: function(data){
					countryResult.fadeIn();
					countryResult.html(data.responseText);
				}
			 });
	});
	$("#countryResult").click(function(){
		$('#countryResult').fadeOut(500);
	});
});
</script>
<?
if(isset($_POST['addFirm'])){
	$data['st'] = $_POST['st'];
	$data['lev'] = $_POST['lev'];
	$data['user_id'] = $_SESSION['user_id'];
	$data['lang'] = $_SESSION['ln'];
	$data['country'] = $_POST['country'];
	$data['name'] = $_POST['name'];
	$data['comment'] = $_POST['comment'];
	$data['date_added'] = mbmTime();
	if($data['name']==''){
		$result_txt = $lang['autos']['empty_name_field'];
	}else{
		if($DB->mbm_insert_row($data,'auto_firms')==1){
			$result_txt = $lang['autos']['command_add_processed'];
			$b=1;
		}else{
			$result_txt = $lang['autos']['command_add_failed'];
			$b=2;
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
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["country"]["country"]?>:<br />
          <input type="text" name="country" id="country" /><div id="countryResult" class="divResults"></div></td>
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
        <input type="submit" name="addFirm" id="addFirm" class="button" value="<?=$lang["auto"]["button_firm_add"]?>"></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
</table>
</form>
<?
}
?>
