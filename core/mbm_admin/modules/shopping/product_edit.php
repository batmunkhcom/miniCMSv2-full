<script language="javascript">
mbmSetContentTitle("update product");
mbmSetPageTitle('update product');
show_sub('menu11');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['updateProduct'])){

	$data['cat_ids'] = ',';
	
	foreach($_POST['cat_id'] as $k=>$v){
		$data['cat_ids'] .= $v.',';
	}
	$data['user_id'] = $_SESSION['user_id'];
	$data['st'] = $_POST['st'];
	$data['lev'] = $_POST['lev'];
	$data['type_id'] = $_POST['type_id'];
	if($data['cat_ids']==','){
		$b=2;
		$result_txt = 'Cat songo';
	}
	$data['price'] = $_POST['price'];
	$data['name'] = $_POST['name'];
	$data['content_short'] = $_POST['content_short'];
	$data['content_more'] = $_POST['content_more'];
	$data['date_added'] = mbmTime();
	$data['date_lastupdated'] = $data['date_added'];
	$data['image_thumb'] = $_POST['image_thumb'];
	$thumb_image = $data['image_thumb']; 
	
	if(mbmCheckEmptyfield($data)){
		$result_txt = $lang['error']['empty_field'];
	}else{
		if($_POST['price_sale']!=''){
			$data['price_sale'] = $_POST['price_sale'];
		}else{
			$data['price_sale'] = 0;
		}
		if($_POST['is_digital']==1){
			$data['file_size'] = 1;
			$data['file_type'] = 1;
		}
		list($data_video['image_width'], 
					$data['image_height'], 
					$photo_filetype, 
					$data['image_attr']) = getimagesize(ABS_DIR.$thumb_image);
		$data['image_filetype'] = $image_types[$photo_filetype];
		$data['image_filesize'] = $_FILES['image_thumb']['size'];
		if($b!=2){
			if($DB->mbm_update_row($data,"shop_products",$_GET['id'])==1){
				$result_txt = $lang["shopping"]["command_update_processed"];
				$b=1;
			}else{
				$result_txt = $lang["shopping"]["command_update_failed"];
			}
		}else{
			$result_txt = $lang["shopping"]["command_update_failed"];
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
if($DB->mbm_check_field('id',$_GET['id'],'shop_products')==0){
	echo '<div id="query_result">no such product exists</div>';
}else{
	$q_product_edit = "SELECT * FROM ".PREFIX."shop_products WHERE id='".$_GET['id']."'";
	$r_product_edit = $DB->mbm_query($q_product_edit);
	if($b!=1){
	?><form name="addProduct" method="post" action="" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
	  <tr class="list_header">
		<td width="40%" >&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td bgcolor="#F5F5F5"><?=$lang["shopping"]["select_category"]?>:<br />
		  <select name="cat_id[]" size="5" multiple="multiple" id="cat_id" style="width:300px;">
		  <?=mbmShoppingCatOptions(0)?>
		  </select>    </td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">&nbsp;</td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">Type:<br />
			  <select name="type_id" id="type_id">
			  <option value="0">none</option>
			<?=$DB->mbm_show_select_options("shop_types","name",$DB->mbm_result($r_product_edit,0,'type_id'))?>
			</select>        </td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">&nbsp;</td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5"><?=$lang['main']['status']?>:<br>
			  <select name="st" id="st">
			  <?=mbmShowStOptions($DB->mbm_result($r_product_edit,0,'st'))?>
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
				<?= mbmIntegerOptions(0, 5,$DB->mbm_result($r_product_edit,0,'lev')); ?>
			  </select></td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">&nbsp;</td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">Price:<br />
			<label>
			<input name="price" type="text" value="<?=$DB->mbm_result($r_product_edit,0,'price')?>" id="price" size="45" />
			</label></td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">&nbsp;</td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">Price sale:<br />
			<input name="price_sale" type="text" value="<?=$DB->mbm_result($r_product_edit,0,'price_sale')?>" id="price_sale" size="45" /></td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">&nbsp;</td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">image thumb:<br />
			<input name="image_thumb" type="text" ondblclick="imgSRC(this.value)" value="<?=$DB->mbm_result($r_product_edit,0,'image_thumb')?>" id="image_thumb" size="45" />
            <div id="imgSRC" style="display:none;"></div>
            <script language="javascript" type="text/javascript">
            function imgSRC(url){
				sr = document.getElementById('imgSRC');
				sr.style.display='block;'
				sr.innerHTML = '<img src="<?=DOMAIN.DIR?>'+url+'" />';
			}
            </script>
            </td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">&nbsp;</td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">is_digital
			<input name="is_digital" type="checkbox" id="is_digital" value="1" <?
            if($DB->mbm_result($r_product_edit,0,'is_digital')==1){
				echo 'checked="checked"';
			}
			?> />
			<br />
			<input name="file_url" type="text" id="file_url" value="<?
            if($DB->mbm_result($r_product_edit,0,'is_digital')==1){
				echo $DB->mbm_result($r_product_edit,0,'file_url');
			}
			?>" size="45" /></td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">&nbsp;</td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  
		  <tr>
			<td bgcolor="#f5f5f5">product name
			  :<br />
			<label>
			<input name="name" type="text" id="name" value="<?=$DB->mbm_result($r_product_edit,0,'name')?>" size="45" />
			</label></td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">&nbsp;</td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2" bgcolor="#f5f5f5"><?
		  mbmShowHTMLEditor("both",'spaw2','spaw','all',array(0=>$DB->mbm_result($r_product_edit,0,'content_short'),1=>$DB->mbm_result($r_product_edit,0,'content_more'))
								,'en','100%',"400px");
			?></td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5">&nbsp;</td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
		  <tr>
			<td bgcolor="#f5f5f5"><label>
			  <input type="submit" name="updateProduct" id="updateProduct" value="<?=$lang["shopping"]["button_update"]?>" />
			</label></td>
			<td bgcolor="#f5f5f5">&nbsp;</td>
		  </tr>
	</table>  
	</form>
	<?
	}
}
?>