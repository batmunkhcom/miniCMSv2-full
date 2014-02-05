<script language="javascript">
mbmSetContentTitle("<?=$lang["auto"]["mark_add"]?>");
mbmSetPageTitle('<?=$lang["auto"]["mark_add"]?>');
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
	
	var firm = $("#firm");
	var firmResult = $("#firmResult");
	
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
		$('#firmResult').hide('fast');
	});
	
	$("#firm").live("keypress",function(){
		$('#firmResult').show();
		$("#firmResult").html('<img src="<?=DOMAIN.DIR?>images/loading.gif" border="0" />');
		$.ajax({
				type: "GET", url: "<?=DOMAIN.DIR?>xml.php?action=auto&type=autocomplete&list_type=firms&country="+country.attr("value"), data: "q="+firm.attr("value"),
				complete: function(data){
					firmResult.fadeIn();
					firmResult.html(data.responseText);
				}
			 });
	});
	$("#firmResult").click(function(){
		$('#firmResult').fadeOut(500);
	});
});
	//"<?=DOMAIN.DIR?>xml.php?action=country&type=autocomplete"
</script>
<?
if(isset($_POST['addMark'])){
	$data['country'] = $_POST['country'];
	$data['st'] = $_POST['st'];
	$data['lev'] = $_POST['lev'];
	$data['user_id'] = $_SESSION['user_id'];
	$data['lang'] = $_SESSION['ln'];
	$data['auto_firm_id'] = $DB->mbm_get_field($_POST['firm'],'name','id','auto_firms');
	$data['auto_type_id'] = $_POST['type_id'];
	$data['name'] = $_POST['name'];
	$data['comment'] = $_POST['comment'];
	$data['tags'] = $_POST['firm'].', '.$_POST['country'].', '.$data['auto_firm_id'].', '.$data['auto_type_id'].', '.$data['name'];
	$data['date_added'] = mbmTime();
	if($data['name']==''){
		$result_txt = $lang['autos']['empty_name_field'];
	}else{
		if($DB->mbm_insert_row($data,'auto_marks')==1){
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
    <td><div id="loadingData"></div></td>
  </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["country"]["country"]?>:<br />
            <input type="text" name="country" id="country" /><div id="countryResult" class="divResults"></div>
        </td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["auto"]["select_firm"]?>:<br />
        <input type="text" name="firm" id="firm" /><div id="firmResult" class="divResults"></div></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["auto"]["car_type"]?>:<br />
          <label>
          <select name="type_id" id="type_id">
			  <?=mbmOptionsFromArrays($lang["auto"]["types"]);?>
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
        <input type="submit" name="addMark" id="addMark" class="button" value="<?=$lang["auto"]["button_mark_add"]?>"></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
    
</table>
</form>
<?
}
?>
