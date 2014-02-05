<script language="javascript" type="text/javascript" charset="utf-8">
mbmSetContentTitle("<?=$lang["auto"]["car_add"]?>");
mbmSetPageTitle('<?=$lang["auto"]["car_add"]?>');
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
	
	var mark = $("#mark");
	var markResult = $("#markResult");
	
	$("#country").live("keypress",function(){
		$('#countryResult').show();
		$("#countryResult").html('<img src="<?=DOMAIN.DIR?>images/loading.gif" border="0" />');
		$.ajax({
				type: "GET", url: "<?=DOMAIN.DIR?>xml.php?action=country&type=autocomplete", data: "q="+country.attr("value"),
				complete: function(data){
					countryResult.fadeIn();
					countryResult.html(data.responseText);
					$('#firmResult').hide('fast');
					$('#markResult').hide('fast');
				}
			 });
	});
	$("#countryResult").click(function(){
		$('#countryResult').fadeOut(500);
	});
	
	$("#firm").live("keypress",function(){
		$('#firmResult').show();
		$("#firmResult").html('<img src="<?=DOMAIN.DIR?>images/loading.gif" border="0" />');
		$.ajax({
				type: "GET", url: "<?=DOMAIN.DIR?>xml.php?action=auto&type=autocomplete&list_type=firms&country="+country.attr("value"), data: "q="+firm.attr("value"),
				complete: function(data){
					firmResult.fadeIn();
					firmResult.html(data.responseText);
					$('#countryResult').hide('fast');
					$('#markResult').hide('fast');
				}
			 });
	});
	$("#firmResult").click(function(){
		$('#firmResult').fadeOut(500);
	});
	$("#mark").live("keypress",function(){
		$('#markResult').show();
		$("#markResult").html('<img src="<?=DOMAIN.DIR?>images/loading.gif" border="0" />');
		$.ajax({
				type: "GET", url: "<?=DOMAIN.DIR?>xml.php?action=auto&type=autocomplete&list_type=marks&country="+country.attr("value")+"&firm="+firm.attr("value"), data: "q="+mark.attr("value"),
				complete: function(data){
					markResult.fadeIn();
					markResult.html(data.responseText);
					$('#countryResult').hide('fast');
					$('#firmResult').hide('fast');
				}
			 });
	});
	$("#markResult").click(function(){
		$('#markResult').fadeOut(500);
	});
	
	
	// zurag upload idevhjuuleh
	$("#use_images").click(function(){
		if ($('#use_images:checked').val() == '1'){
			$('#imageFiles').show('fast');
			$('#files_list').show('fast');
		}else{
			$('#imageFiles').hide('slow');
			$('#files_list').hide('slow');
		}
	});
	
	
	//mashinuu photnuud ehelev
	var maxCarPhotos = 20;
	$('#imageFiles').after('<div id="files_list" style="display:none; margin-top:12px;border:1px solid black;padding:5px;background:#fff;font-size:x-small;"><strong><?=$lang['main']['file']?> (<?=$lang['main']['maximum']?> '+maxCarPhotos+'):</strong></div>');
		$("input.upload").change(function(){
		makeList(this, maxCarPhotos);
	});

	function makeList(obj, fm) {
		if($('input.upload').size() > fm) {alert('<?=$lang["auto"]["max_car_photos"]?> '+fm); obj.value='';return true;}
		
		$(obj).hide();
		$(obj).parent().prepend('<input type="file" class="upload" name="carPhotos[]" />').find("input").change(function() {makeList(this, fm)});
		var v = obj.value;
		if(v != '') {
			$("div#files_list").append('<div>'+v+'&nbsp;<input type="button" class="remove" value="<?=$lang['main']['delete']?>" /></div>')
			.find("input").click(function(){
				$(this).parent().remove();
				$(obj).remove();
				return true;
			});
		}
	
	};
	
	//mashinuu photnuud duusav


});

</script>
<?
if(isset($_POST['country'])){
	
	$data['st'] = $_POST['st'];
	$data['lev'] = $_POST['lev'];
	$data['user_id'] = $_SESSION['user_id'];
	$data['country'] = $_POST['country'];
	$data['firm_id'] = $DB->mbm_get_field($_POST['firm'],'name','id','auto_firms');
	$data['mark_id'] = $DB->mbm_get_field($_POST['mark'],'name','id','auto_marks');
	$data['model'] = $_POST['model'];
	$data['price'] = $_POST['price'];
	$data['currency'] = $_POST['currency'];
	$data['auto_type'] = $_POST['auto_type'];
	$data['name'] = $_POST['name'];
	$data['content_short'] = $_POST['content_short'];
	$data['content_more'] = $_POST['content_more'];
	$data['date_made'] = $_POST['date_made'];
	$data['date_imported'] = $_POST['date_imported'];
	$data['doors'] = $_POST['doors'];
	$data['color'] = $_POST['color'];
	$data['seats'] = $_POST['seats'];
	$data['quality'] = $_POST['quality'];
	$data['steering'] = $_POST['steering'];
	$data['abs'] = $_POST['abs'];
	$data['fuel'] = $_POST['fuel'];
	$data['cylinders'] = $_POST['cylinders'];
	$data['mileage'] = $_POST['mileage'];
	$data['engine'] = $_POST['engine'];
	$data['transmission'] = $_POST['transmission'];
	$data['fuel_in100km'] = $_POST['fuel_in100km'];
	$data['date_added'] = mbmTime();
	$data['session_id'] = session_id();
	$data['session_time'] = mbmTime();
	$data['tags'] = $data['country'].', '
					.$_POST['firm'].', '
					.$_POST['mark'].', '
					.$lang["auto"]["quality"][$data['quality']].', '
					.$lang["auto"]["steering"][$data['steering']].', '
					.$lang["auto"]["fuel"][$data['fuel']].', '
					.$lang["auto"]["types"][$data['auto_type']].', '
					.$lang["auto"]["color"][$data['color']].', '
					.$lang["auto"]["transmission"][$data['transmission']].', '
					.$data['model'].', ';
	
	if($DB->mbm_insert_row($data,'auto_cars') ==  1){
	
	$car_inserted_id = $DB->mbm_get_field($data['session_id'],'session_id','id','auto_cars');
	
	$result_txt .= 'Машины мдээлэл нэмэгдэв.<br />';
	
	$data_info['car_id'] = $car_inserted_id;
	$data_info['name'] = $_POST['seller_name'];
	$data_info['phone'] = $_POST['seller_phone'];
	$data_info['email'] = $_POST['seller_email'];
	$data_info['comment'] = $_POST['seller_comment'];
	$data_info['date_added'] = $data['date_added'];
	$data_info['session_time'] = $data['session_time'];
	$data_info['session_id'] = $data['session_id'];
		
		if($DB->mbm_insert_row($data_info,'auto_car_info') == 1){
			
			$result_txt .= 'Хувь хүний мэдээлэл нэмэгдлээ.<br />';
			
			$b = 1;
			
			if($_POST['use_images'] == '1'){
				if(is_array($_FILES['carPhotos']['name'])){
					
					$name_array[0] = array('<','&','#','№');
					$name_array[1] = array('_','_','_','_');
					
					//i==0 deer hooson file bh bolno. tiimees i-g 1-s ehluulj bna
					for($i=1;$i<count($_FILES['carPhotos']['name']);$i++){
						
						$photo_filename = mbmTime().'-'.basename(str_replace($name_array[0],$name_array[1],$_FILES['carPhotos']['name'][$i]));
		
						if(!move_uploaded_file($_FILES['carPhotos']['tmp_name'][$i],ABS_DIR.PHOTO_DIR.$photo_filename)){
							$result_txt .= $_FILES['carPhotos']['name'][$i].' '.$lang['menu']['command_image_file_upload_failed'].'.<br />';
						}else{
							$result_txt .= $_FILES['carPhotos']['name'][$i].' '.$lang['menu']['command_image_file_uploaded'].'.<br />';
						}
						$data_photo[$i]["car_id"] = $car_inserted_id;
						$data_photo[$i]["user_id"] = $data['user_id'];
						list($data_photo[$i]["width"], 
								$data_photo[$i]["height"], 
								$photo_filetype, 
								$data_photo[$i]["attr"]) = getimagesize(ABS_DIR.PHOTO_DIR.$photo_filename);
						$data_photo[$i]["filesize"] = $_FILES['carPhotos']['size'][$i];
						$data_photo[$i]['filetype'] = $image_types[$photo_filetype];
						$data_photo[$i]['url'] = PHOTO_DIR.$photo_filename;
						$data_photo[$i]["title"] = $data['model'];
						$data_photo[$i]["comment"] = $data['tags'];
						$data_photo[$i]["ip"] = getenv("REMOTE_ADDR");
						$data_photo[$i]["date_added"] = $data['date_added'];
						$data_photo[$i]["date_lastupdated"] = $data['date_added'];
						
						if($DB->mbm_insert_row($data_photo[$i],"auto_car_photos")==1){
							$result_txt .= $_FILES['img_file']['name'][$i].' '.$lang['menu']['command_image_info_added'].'.<br />';
						}else{
							$result_txt .= $_FILES['img_file']['name'][$i].' '.$lang['menu']['command_image_info_failed'].'.<br />';
						}
					}
				}
			}
		}else{
			$DB->mbm_query("DELETE FROM ".PREFIX."auto_cars WHERE session_id='".$data['session_id']."' LIMIT 1");
			$b = 2;
		}	
	}
	$DB->mbm_query("UPDATE ".PREFIX."auto_cars SET session_id='' WHERE session_id='".session_id()."'");
	//mbm_test($data);
	
	echo '<div id="query_result">'.$result_txt.'</div>';
}
if($b!=1){
?>
<form name="addCar" method="post" action="" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="2" cellpadding="3">
    <tr class="list_header">
      <td><?=$lang['main']['main_info']?></td>
      <td><?=$lang['main']['additional_info']?></td>
    </tr>
    <tr valign="top">
      <td width="50%"><table width="99%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
        <tr>
          <td bgcolor="#F5F5F5"><?=$lang['main']['status']?>
            :<br />
            <select name="st" id="st">
              <?=mbmShowStOptions($_POST['st'])?>
            </select></td>
        </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5"><?=$lang['main']['level']?>
            :<br />
            <select name="lev">
              <?= mbmIntegerOptions(0, $_SESSION['lev'],$_POST['lev']); ?>
            </select></td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5"><?=$lang['main']['country']?>
            :<br />
            <input name="country" type="text" id="country" value="<?=$_POST['country']?>" size="45" /><div id="countryResult" class="divResults"></div></td>
        </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#F5F5F5"><?=$lang['auto']['firm']?>
            :<br />
            <input name="firm" type="text" id="firm" size="45" value="<?=$_POST['firm']?>" /><div id="firmResult" class="divResults"></div></td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5"><?=$lang['auto']['mark']?>
            :<br />
            <input name="mark" type="text" id="mark" size="45" value="<?=$_POST['mark']?>" /><div id="markResult" class="divResults"></div></td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5"><?=$lang['auto']['model']?>:<br />
            <input name="model" type="text" id="model" value="<?=$_POST['model']?>" size="45" /></td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5"><?=$lang['auto']['price']?>:<br />
            <input name="price" type="text" id="price" size="30" value="<?=$_POST['price']?>" />
            <select name="currency" id="currency">
            <?=mbmOptionsFromArrays($lang["auto"]["currency"])?>
            </select></td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#F5F5F5"><?=$lang['main']['name']?>
            :<br />
            <input name="name" type="text" id="name" size="45" value="<?=$_POST['name']?>" /></td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5"><? mbmShowHTMLEditor("both",'spaw2','spaw','all',array(0=>$_POST['content_short'],1=>$_POST['content_more'])
							,'en','100%',"300px");?></td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
        <tr>
          <td bgcolor="#F5F5F5">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="99%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
        <tr>
          <td width="25%" valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["date_made"]?>:<br />
            <select name="date_made" id="date_made">
            <?= mbmIntegerOptions((mbmDate("Y")-20), mbmDate("Y"),$_POST['date_made']); ?>
            </select></td>
          <td width="25%" valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["date_imported"]?>:<br />
            <select name="date_imported" id="date_imported">
            <?= mbmIntegerOptions((mbmDate("Y")-20), mbmDate("Y"),$_POST['date_imported']); ?>
            </select></td>
          <td width="25%" valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["car_doors"]?>:<br />
            <select name="doors" id="doors">
            <?= mbmIntegerOptions(1,50,$_POST['doors']); ?>
            </select></td>
          <td width="25%" valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["car_seats"]?>:<br />
            <select name="seats" id="seats">
            <?= mbmIntegerOptions(1,50,$_POST['seats']); ?>
            </select></td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["car_transmission"]?>:<br />
            <select name="transmission" id="transmission">
            <?=mbmOptionsFromArrays($lang["auto"]["transmission"],$_POST['transmission']);?>
            </select></td>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["car_steering"]?>:<br />
            <select name="steering" id="steering">
            <?=mbmOptionsFromArrays($lang["auto"]["steering"],$_POST['steering']);?>
            </select></td>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["car_abs"]?>:<br />
            <select name="abs" id="abs">
              <option value="0"><?=$lang['main']['no']?></option>
              <option value="1" <?
              if($_POST['abs'] == 1){
				  echo 'selected';
			  }
			  ?>><?=$lang['main']['yes']?></option>
            </select></td>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["cylinders"]?>:<br />
            <select name="cylinders" id="cylinders">
            <?= mbmIntegerOptions(1,10,$_POST['cylinders']); ?>
            </select></td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["car_fuel"]?>:<br />
            <select name="fuel" id="fuel">
            <?=mbmOptionsFromArrays($lang["auto"]["fuel"],$_POST['fuel']);?>
            </select></td>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["fuel_in100km"]?>:<br />
            <input name="fuel_in100km" type="text" id="fuel_in100km" size="10" value="<?=$_POST['fuel_in100km']?>" /></td>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["mileage"]?>:<br />
            <input name="mileage" type="text" id="mileage" size="10" value="<?=$_POST['mileage']?>" /></td>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["engine"]?>:<br />
            <input name="engine" type="text" id="engine" size="10" value="<?=$_POST['engine']?>" /></td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["car_quality"]?>:<br />
            <select name="quality" id="quality">
            <?=mbmOptionsFromArrays($lang["auto"]["quality"],$_POST['quality']);?>
            </select></td>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["car_type"]?>:<br />
            <select name="auto_type" id="auto_type">
              <?=mbmOptionsFromArrays($lang["auto"]["types"],$_POST['auto_type']);?>
            </select></td>
          <td valign="top" bgcolor="#F5F5F5"><?=$lang["auto"]["car_color"]?>:<br />
            <select name="color" id="color">
              <?=mbmOptionsFromArrays($lang["auto"]["color"],$_POST['color']);?>
            </select></td>
          <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
        </tr>
      </table>
        <table width="99%" border="0" cellspacing="2" cellpadding="3" class="tblContents" style="margin-top:12px;">
          <tr>
            <td bgcolor="#F5F5F5"><strong><?=$lang["auto"]["car_photos"]?>:</strong></td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5"><input name="use_images" type="checkbox" id="use_images" value="1" />
              <?=$lang["auto"]["check_this_to_use_car_photos"]?></td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5">
            <div id="imageFiles" style="display:none;">
            <input type="file" id="carPhotos" class="upload" name="carPhotos[]" /><br />
            </div>
            </td>
          </tr>
      </table>
        <table width="99%" border="0" cellspacing="2" cellpadding="3" class="tblContents" style="margin-top:12px;">
          <tr>
            <td bgcolor="#F5F5F5"><strong><?=$lang["auto"]["seller_info"]?></strong></td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5"><?=$lang["auto"]["seller_name"]?>:<br />
            <input name="seller_name" type="text" id="seller_name" size="45" value="<?=$_POST['seller_name']?>" /></td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5"><?=$lang["auto"]["seller_phone"]?>:<br />
            <input name="seller_phone" type="text" id="seller_phone" size="45" value="<?=$_POST['seller_phone']?>" /></td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5"><?=$lang["auto"]["seller_email"]?>:<br />
            <input name="seller_email" type="text" id="seller_email" size="45" value="<?=$_POST['seller_email']?>" /></td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5"><?=$lang["auto"]["seller_comment"]?>:<br />
            <textarea name="seller_comment" cols="45" rows="5" id="seller_comment"><?=$_POST['seller_comment']?></textarea></td>
          </tr>
          <tr>
            <td bgcolor="#F5F5F5">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
  <br />
  <input type="submit" class="button" name="addCarButton" id="button" value="<?=$lang["auto"]["button_car_add"]?>" />
</form>
<?
}
?>