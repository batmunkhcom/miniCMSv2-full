<?

if($mBm!=1){

	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');

}elseif($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==0){

	echo '<div id="errorMain">Please login first.</div>';

}else{

	if(isset($_POST['uploadImage'])){
		if($_POST['name']==''){
			$result_txt = 'empty name field.';

		}else{

			if($_POST['private']==1){
				$data['private'] = 1;

			}
			$data_photo['gallery_id'] = $_POST['gallery_id'];

			$data_photo['name'] = $_POST['name'];
			$data_photo['comment'] = $_POST['comment'];
			$data_photo['user_id'] = $_SESSION['user_id'];
			$data_photo['date_added'] = mbmTime();
			$data_photo['date_lastupdated'] = $data_photo['date_added'];
			$data_photo['total_updated'] = 0;
			$data_photo['use_comment'] = $_POST['use_comment'];
			$data_photo['use_rating'] = 0;
			$data_photo['st'] = 1;

			

			$photo_filename = $_SESSION['user_id'].'-'.mbmTime().'-'.basename($_FILES['img_file']['name']);

			

			if(!move_uploaded_file($_FILES['img_file']['tmp_name'],ABS_DIR.GALLERY_DIR.$photo_filename)){

				$result_txt .= $_FILES['img_file']['name'].' '.$lang['menu']['command_image_file_upload_failed'].'.<br />';

				$b=2;

			}else{

				$result_txt .= $_FILES['img_file']['name'].' '.$lang['menu']['command_image_file_uploaded'].'.<br />';

			}

			list($data_photo["width"], 

					$data_photo["height"], 

					$photo_filetype, 

					$data_photo["attr"]) = getimagesize(ABS_DIR.GALLERY_DIR.$photo_filename);

			$data_photo["filesize"] = $_FILES['img_file']['size'];

			$data_photo['filetype'] = $image_types[$photo_filetype];

			$data_photo['url'] = GALLERY_DIR.$photo_filename;

			$data_photo["ip"] = getenv("REMOTE_ADDR");

			

			if($b!=2){

				if($DB->mbm_insert_row($data_photo,"gallery_files")==1){

					$result_txt .= $_FILES['img_file']['name'].' '.$lang['menu']['command_image_info_added'].'.<br />';

					$b=1;

				}else{

					$result_txt .= $_FILES['img_file']['name'].' '.$lang['menu']['command_image_info_failed'].'.<br />';

				}

			}

		}

		echo '<div id="query_result">'.$result_txt.'</div>';

	}

	if($b!=1){

	?>

	<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">

	  <table width="100%" border="0" cellspacing="3" cellpadding="2">

		<tr>

		  <td>Gallery:<br />

			<select name="gallery_id" id="gallery_id">

			<?=mbmPhotoGalleryCategoriesDropDown(1,0,2,888,0,'id','desc')?>

			</select>

		  </td>

		  <td>&nbsp;</td>

		</tr>

		<tr>

		  <td>is Private:<br />

		  <input name="private" type="checkbox" id="private" value="1" />
		  <br />
		  Use comment<br />
		  <input name="use_comment" type="checkbox" id="use_comment" value="1" /></td>

		  <td>&nbsp;</td>

		</tr>

		<tr>

		  <td width="50%">name:<br />

		  <input name="name" type="text" id="name" class="input" size="30" /></td>

		  <td>&nbsp;</td>

		</tr>

		<tr>

		  <td>Image file:<br />

		  <input name="img_file" type="file" id="img_file" size="30" /></td>

		  <td>&nbsp;</td>

		</tr>

		<tr>

		  <td>comment:<br />

			<textarea name="comment" cols="30" rows="3" id="comment" class="textarea"></textarea></td>

		  <td>&nbsp;</td>

		</tr>

		<tr>

		  <td><input type="submit" name="uploadImage" class="button" id="uploadImage" value="upload" /></td>

		  <td>&nbsp;</td>

		</tr>

	  </table>

	</form>

	<?	

	}

}

?>