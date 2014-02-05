<?
if($mBm!=1){
	echo '<div id="query_result">direct access not allowed</div>';
}elseif($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==0){
	echo '<div id="query_result">Please login first.</div>';
}else{
		if(isset($_POST['addPhotoNews'])){
		
		$menus_ids = ',';
		foreach($_POST['menus'] as $k=>$v){
			$menus_ids .= $v.',';
		}
		$data['menu_id'] = $menus_ids;
		$data['user_id'] = $_SESSION['user_id'];
		$data['st'] = $_POST['st'];
		$data['lev'] = $_POST['lev'];
		$data['is_photo'] = 1;
		$data['title'] = $_POST['title'];
		$data['content_short'] = $_POST['content_short'];
		$data['content_more'] = '';
		$data['show_title'] = $_POST['show_title'];
		$data['show_content_short'] = $_POST['use_short_content'];
		$data['cleanup_html'] = $_POST['cleanup_html'];
		$data['use_comment'] = $_POST['use_comment'];
		$data['date_added'] = mbmTime();
		$data['date_lastupdated'] = $data['date_added'];
		$data['session_id'] = session_id();
		if($DB->mbm_insert_row($data,"menu_contents")==1){
				$tmp_content_id = $DB->mbm_get_field($data['session_id'],'session_id','id','menu_contents');
				$DB->mbm_query("UPDATE ".PREFIX."menu_contents SET session_id='' WHERE id='".$tmp_content_id."'");
			foreach($_POST['img_title'] as $k=>$v){
				
				$photo_filename = mbmTime().'-'.basename($_FILES['img_file']['name'][$k]);
				
				if(!move_uploaded_file($_FILES['img_file']['tmp_name'][$k],ABS_DIR.PHOTO_DIR.$photo_filename)){
					$result_txt .= $_FILES['img_file']['name'][$k].' '.$lang['menu']['command_image_file_upload_failed'].'.<br />';
				}else{
					$result_txt .= $_FILES['img_file']['name'][$k].' '.$lang['menu']['command_image_file_uploaded'].'.<br />';
				}
				$data_photo[$k]["content_id"] = $tmp_content_id;
				$data_photo[$k]["user_id"] = $data['user_id'];
				list($data_photo[$k]["width"], 
						$data_photo[$k]["height"], 
						$photo_filetype, 
						$data_photo[$k]["attr"]) = getimagesize(ABS_DIR.PHOTO_DIR.$photo_filename);
				$data_photo[$k]["filesize"] = $_FILES['img_file']['size'][$k];
				$data_photo[$k]['filetype'] = $image_types[$photo_filetype];
				$data_photo[$k]['url'] = PHOTO_DIR.$photo_filename;
				$data_photo[$k]["title"] = $_POST['img_title'][$k];
				$data_photo[$k]["comment"] = $_POST['img_comment'][$k];
				$data_photo[$k]["ip"] = getenv("REMOTE_ADDR");
				$data_photo[$k]["date_added"] = $data['date_added'];
				$data_photo[$k]["date_lastupdated"] = $data['date_added'];
				
				if($DB->mbm_insert_row($data_photo[$k],"menu_photos")==1){
					$result_txt .= $_FILES['img_file']['name'][$k].' '.$lang['menu']['command_image_info_added'].'.<br />';
				}else{
					$result_txt .= $_FILES['img_file']['name'][$k].' '.$lang['menu']['command_image_info_failed'].'.<br />';
				}
			}
			$b=1;
		}else{
			$result_txt .= $lang["menu"]["command_add_failed"].'.<br />';
		}
			echo '<div id="query_result">'.$result_txt.'</div>';
	}
	if($b!=1){
	?><script language="javascript">
	
	function mbmShowImageFields(total){
		var a = document.contentForm;
		var buf = '';
		for(i=1;i<=total;i++){
			buf = buf + '<br /><strong>'+i+'</strong>. <?=$lang['menu']['image_file']?>:<br /><input size="45" type="file" name="img_file[';
			buf = buf + i + ']" id="img_file[';
			buf = buf + i + ']" class="input" /><br /><?=$lang['menu']['image_title']?>:<br /><input size="45" name="img_title[';
			buf = buf + i + ']" type="text" id="img_title[';
			buf = buf + i + ']" value="" class="input" /><br /><?=$lang['menu']['image_comment']?>:<br />';
		  buf = buf + '<textarea name="img_comment[';
		  buf = buf + i + ']" cols="45" rows="3" id="img_comment[';
		  buf = buf + i + ']" class="textarea"></textarea>';
		}
		document.getElementById("images").innerHTML=buf;
	}
	</script><form action="" name="contentForm" id="contentForm" method="post" enctype="multipart/form-data">
			<table width="100%" border="0" cellspacing="2" cellpadding="3">
			  <tr>
				<td colspan="2"><div><?=$lang['menu']['select_menus']?>:<br />
					  <?
				echo mbmUserPermissionMenus("is_photo",$_SESSION['user_id']);
				
				?>
				</div></td>
			  </tr>
			  <tr>
				<td width="40%">
				  <?=$lang['menu']['content_title']?>:<br>
					<input name="title" type="text" id="title" size="45" class="input">		  </td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><?=$lang["menu"]["content_short"]?>:<br /><textarea name="content_short" cols="45" rows="5" class="textarea" id="content_short"></textarea></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><table width="100%" border="0" cellspacing="2" cellpadding="3">
				  <tr class="list_header">
					<td width="25%" align="center"><?=$lang['menu']['show_content_title']?>:</td>
					<td width="25%" align="center"><?=$lang['menu']['use_short_content']?>:</td>
					<td width="25%" align="center"><?=$lang['menu']['use_content_comment']?>:</td>
					<td width="25%" align="center"><?=$lang['menu']['cleanup_short_content']?></td>
				  </tr>
				  <tr>
					<td align="center" bgcolor="#f5f5f5"><input name="show_title" type="checkbox" id="show_title" value="1" checked></td>
					<td align="center" bgcolor="#f5f5f5"><input name="use_short_content" type="checkbox" id="use_short_content" value="1" checked></td>
					<td align="center" bgcolor="#f5f5f5"><input name="use_comment" type="checkbox" id="use_comment" value="1" checked></td>
					<td align="center" bgcolor="#f5f5f5"><input name="cleanup_html" type="checkbox" id="cleanup_html" value="1" checked></td>
				  </tr>
				</table></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><?=$lang['menu']['images_total']?>:<br />
				  <select name="img_total" id="img_total" class="input" onChange="mbmShowImageFields(this.value)">
					<?=mbmIntegerOptions(1,8)?>
				  </select>
				  <div id="images" style="display:block;"><br /><strong>1.</strong> <?=$lang['menu']['image_file']?>:<br />
				  <input name="img_file[1]" type="file" id="img_file[1]" size="45" class="input" />
				  <br /><?=$lang['menu']['image_title']?>:<br />
				  <input name="img_title[1]" type="text" id="img_title[1]" value="" size="45" class="input" />
				  <br />
				  <?=$lang['menu']['image_comment']?>:<br />
				  <textarea name="img_comment[1]" cols="45" rows="3" id="img_comment[1]" class="textarea"></textarea>
				  </div>      </td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><input type="submit" name="addPhotoNews" id="addPhotoNews" class="button" value="<?=$lang['menu']['button_photo_content_add']?>" /></td>
				<td>&nbsp;</td>
			  </tr>
			</table>
			</form>
	<?
	}
}
?>