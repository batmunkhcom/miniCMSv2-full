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
		$data['is_video'] = 1;
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
			
				
				$video_filename = mbmTime().'-'.basename($_FILES['video_file']['name']);
				$photo_filename = mbmTime().'-'.basename($_FILES['img_file']['name']);
				
				if(!move_uploaded_file($_FILES['img_file']['tmp_name'],ABS_DIR.VIDEO_DIR.$photo_filename)){
					$result_txt .= $_FILES['img_file']['name'].' '.$lang['menu']['command_image_file_upload_failed'].'.<br />';
				}else{
					$result_txt .= $_FILES['img_file']['name'].' '.$lang['menu']['command_image_file_uploaded'].'.<br />';
				}
				if(!move_uploaded_file($_FILES['video_file']['tmp_name'],ABS_DIR.VIDEO_DIR.$video_filename)){
					$result_txt .= $_FILES['video_file']['name'].' '.$lang['menu']['command_video_file_upload_failed'].'.<br />';
				}else{
					$result_txt .= $_FILES['video_file']['name'].' '.$lang['menu']['command_video_file_uploaded'].'.<br />';
				}
				$data_video["content_id"] = $tmp_content_id;
				$data_video["user_id"] = $data['user_id'];
				list($data_video["image_width"], 
						$data_video["image_height"], 
						$photo_filetype, 
						$data_video["image_attr"]) = getimagesize(ABS_DIR.VIDEO_DIR.$photo_filename);
				$data_video["filesize"] = $_FILES['img_file']['size'];
				$data_video['image_filetype'] = $image_types[$photo_filetype];
				$data_video['image_url'] = VIDEO_DIR.$photo_filename;
				$data_video['url'] = DOMAIN.DIR.VIDEO_DIR.$video_filename;
				$data_video['duration'] = ceil(mbmGetFLVDuration(ABS_DIR.VIDEO_DIR.$flv_filename)/1000);
				$data_video["title"] = $_POST['video_title'];
				$data_video["comment"] = $_POST['video_comment'];
				$data_video["ip"] = getenv("REMOTE_ADDR");
				$data_video["date_added"] = $data['date_added'];
				$data_video["date_lastupdated"] = $data['date_added'];
				
				if($DB->mbm_insert_row($data_video,"menu_videos")==1){
					$result_txt .= $_FILES['video_file']['name'].' '.$lang['menu']['command_video_info_added'].'.<br />';
				}else{
					$result_txt .= $_FILES['video_file']['name'].' '.$lang['menu']['command_video_info_failed'].'.<br />';
				}
			
			$b=1;
		}else{
			$result_txt .= $lang["menu"]["command_add_failed"].'.<br />';
		}
		echo '<div id="query_result">'.$result_txt.'</div>';
}
if($b!=1){
?><script language="javascript">

</script><form action="" name="contentForm" id="contentForm" method="post" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		  <tr>
		    <td colspan="2"><div><?=$lang['menu']['select_menus']?>:<br />
				  <?
			echo mbmUserPermissionMenus("is_video",$_SESSION['user_id']);
			
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
                <td align="center" bgcolor="#f5f5f5"><input name="cleanup_html" type="checkbox" id="cleanup_html" value="1"></td>
              </tr>
            </table></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
			<td><div id="images" style="display:block;"><?=$lang['menu']['video_file']?>:<br />
			    <input name="video_file" type="file" id="video_file" size="45" class="input" />
		      <br />
			  <?=$lang['menu']['video_image_thumb']?>:<br />
			  <input name="img_file" type="file" id="img_file" size="45" class="input" />
			  <br />
			  <?=$lang['menu']['video_title']?>:<br />
			  <input name="video_title" type="text" id="video_title" value="" size="45" class="input" />
			  <br />
			  <?=$lang['menu']['video_comment']?>:<br />
			  <textarea name="video_comment" cols="45" rows="3" id="video_comment" class="textarea"></textarea>
		    </div>      </td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td><input type="submit" name="addPhotoNews" id="addPhotoNews" class="button" value="<?=$lang['menu']['button_video_content_add']?>" /></td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		</form>
	<?
    }
}
?>