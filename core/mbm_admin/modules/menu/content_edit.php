<script language="javascript">
mbmSetContentTitle("<?= $lang["menu"]["content_edit"]?>");
mbmSetPageTitle('<?= $lang["menu"]["content_edit"]?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}

if(isset($_POST['st'])){
	$result_txt = '';

	if(is_array($_POST['menu_id'])){
		$tmp_menus = $_POST['menu_id'];
		foreach($tmp_menus as $k_menus=>$v_menus){
			$buf_menus .= $v_menus.',';
		}
		$data['menu_id'] = ','.$buf_menus ;
		//print_r($_POST['menu_id']);
	}
	//$data['user_id'] = $_SESSION['user_id'];
	$data['lev'] = $_POST['lev'];
	$data['st'] = $_POST['st'];
	$data['title'] = $_POST['title'];
	
	$data['tag'] = $_POST['tag'];
	if($_POST['use_comment']==1){
		$data['use_comment'] = $_POST['use_comment'];
	}else{
		$data['use_comment'] = 0;
	}
	if($_POST['cleanup_html']==1){
		$data['cleanup_html'] = $_POST['cleanup_html'];
	}else{
		$data['cleanup_html'] = 0;
	}
	
	$data['content_short'] = $_POST['content_short'];
	if(isset($_POST['content_more'])){
		$data['content_more'] = $_POST['content_more'];
	}
	if(isset($_POST['show_title'])){
		$data['show_title'] = 1;
	}else{
		$data['show_title'] = 0;
	}
	if($_POST['show_content_short']==1){
		$data['show_content_short'] = 1;
	}else{
		$data['show_content_short'] = 0;
	}
	$data['date_lastupdated'] = mbmTime();
	
	$date_added_exploded= explode("-",$_POST['date_added']);
	$data['date_added'] = mktime($_POST['hours'],$_POST['minutes'],$_POST['seconds'],$date_added_exploded[1],$date_added_exploded[0],$date_added_exploded[2]);

	switch($_GET['type']){
		case 'video':
			$data['is_video'] = 1;
			//upload video and thumbnail image
			$flv_filename = mbmTime().'-'.basename($_FILES['videoFile']['name']);
			$flv_thumbnail = $_POST['imageFile']; 
			if(strtolower(substr($flv_filename,-3))!='flv' && $_POST['videoURLverify']!=1){
				$result_txt .= $lang['menu']['error_invalid_video_format'].'.<br />';
				$b=2;
			}
			
			$data_video['title'] = $_POST['video_title'];			
			$data_video['ip'] = getenv("REMOTE_ADDR");
			$data_video['date_lastupdated'] = mbmTime();
			//$data_video['user_id'] = $_SESSION['user_id'];
			$data_video['comment'] = nl2br($_POST['comment']);
			
			
			$r_content_add = $DB->mbm_update_row($data,"menu_contents",$_GET['id']);
			$tmp_content_id = $_GET['id'];
			if($r_content_add==1 && $b!=2){
				if($_POST['videoURLverify']=='1'){
					$data_video['url'] = $_POST['videoFileURL'];
					$data_video['filesize'] = $_POST['videoFileSIZE'];
					$data_video['duration'] = $_POST['videoFileDURATION'];
				}elseif(!move_uploaded_file($_FILES['videoFile']['tmp_name'],ABS_DIR.VIDEO_DIR."/".$flv_filename)){
					$result_txt .= $lang['menu']['command_video_file_upload_failed'].'.<br />';
					$b=2;
				}else{
					$data_video['url'] = DOMAIN.DIR.VIDEO_DIR.$flv_filename;
					$data_video['filesize'] = $_FILES['videoFile']['size'];
					$data_video['duration'] = ceil(mbmGetFLVDuration(ABS_DIR.VIDEO_DIR.$flv_filename)/1000);
					$result_txt .= $lang['menu']['command_video_file_uploaded'].'.<br />';
				}
				$data_video['image_url'] = $flv_thumbnail;
				list($data_video['image_width'], 
					$data_video['image_height'], 
					$photo_filetype, 
					$data_video['image_attr']) = getimagesize(ABS_DIR.$flv_thumbnail);
					$data_video['image_filetype'] = $image_types[$photo_filetype];
						
				$data_video['content_id'] = $tmp_content_id;
				
				if($b!=2){
					$r_video_add = $DB->mbm_update_row($data_video,"menu_videos",$DB->mbm_get_field($tmp_content_id,'content_id','id','menu_videos'));
					if($r_video_add==1){
						$result_txt .= $lang["menu"]["update_success"].'. <br />';
						$b=1;
					}else{
						$result_txt .= $lang['menu']['command_video_file_upload_failed'].'.<br />';
					}
				}else{
					$result_txt .= $lang["menu"]["update_failed"].'.<br />';
				}
			}else{
				$result_txt .= $lang["menu"]["update_failed"].'.<br />';
			}
			
		break;
		case 'photo':
			
				$data['is_photo'] = 1;
				$r_content_add = $DB->mbm_update_row($data,"menu_contents",$_GET['id']);
				if($r_content_add==1){
					$result_txt .= $lang["menu"]["update_success"].'.<br /> ';
					$b=1;
					$tmp_content_id = $_GET['id'];
					
					foreach($_POST['img_title'] as $k=>$v){
						
						$photo_filename = $_POST['img_file'][$k];
						
						$data_photo[$k]["content_id"] = $tmp_content_id;
						//$data_photo[$k]["user_id"] = $data['user_id'];
						list($data_photo[$k]["width"], 
								$data_photo[$k]["height"], 
								$photo_filetype, 
								$data_photo[$k]["attr"]) = getimagesize(ABS_DIR.$photo_filename);
						$data_photo[$k]["filesize"] = filesize(ABS_DIR.$photo_filename);
						$data_photo[$k]['filetype'] = $image_types[$photo_filetype];
						$data_photo[$k]['url'] = $photo_filename;
						$data_photo[$k]["title"] = $_POST['img_title'][$k];
						$data_photo[$k]["comment"] = $_POST['img_comment'][$k];
						$data_photo[$k]["ip"] = getenv("REMOTE_ADDR");
						$data_photo[$k]["date_lastupdated"] = mbmTime();

						if($b!=2){
							if($DB->mbm_update_row($data_photo[$k],"menu_photos",$k)==1){
								$result_txt .= $_POST['img_file'][$k].' '.$lang['menu']['command_image_info_updated'].'.<br />';
							}else{
								$result_txt .= $_POST['img_file'][$k].' '.$lang['menu']['command_image_info__update_failed'].'.<br />';
							}
						}
					}
				}else{
					$result_txt .= $lang["menu"]["command_update_failed"].'.<br />';
				}
		break;
		case 'youtube':
			$data['content_more'] = $_POST['content_more'];
			$r_content_add = $DB->mbm_update_row($data,"menu_contents",$_GET['id']);
			if($r_content_add==1){
				$result_txt .= $lang["menu"]["update_success"].'.<br />';
				$b = 1;
			}else{
				$result_txt .= $lang["menu"]["command_update_failed"];
			}
		break;
		case 'normal':
			$data['content_more'] = $_POST['content_more'];
			$r_content_add = $DB->mbm_update_row($data,"menu_contents",$_GET['id']);
			if($r_content_add==1){
				$result_txt .= $lang["menu"]["update_success"].'.<br />';
				$b = 1;
			}else{
				$result_txt .= $lang["menu"]["command_update_failed"];
			}
		break;
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
if($DB->mbm_check_field('id',$_GET['id'],'menu_contents')==0){
	echo '<div id="query_result">'.$lang["menu"]["no_such_content_exists"].'</div>';
}elseif($b!=1){
$q_content_edit = "SELECT * FROM ".PREFIX."menu_contents WHERE id='".$_GET['id']."'";
$r_content_edit = $DB->mbm_query($q_content_edit);
switch($_GET['type']){
	case 'video':
		$q_total_videos = "SELECT * FROM ".PREFIX."menu_videos WHERE content_id='".$DB->mbm_result($r_content_edit,0,"id")."'";
		$r_total_videos = $DB->mbm_query($q_total_videos);
		$total_videos = $DB->mbm_num_rows($r_total_videos);
	break;
	case 'photo':
		$q_total_images = "SELECT * FROM ".PREFIX."menu_photos WHERE content_id='".$DB->mbm_result($r_content_edit,0,"id")."'";
		$r_total_images = $DB->mbm_query($q_total_images);
		$total_images = $DB->mbm_num_rows($r_total_images);
	break;
}
?>
<form name="addContent" method="post" action="" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
	<tr>
        <td bgcolor="#f5f5f5"><?=$lang["main"]["status"]?>:<br>
          <select name="st" id="st">
          <?=mbmShowStOptions($DB->mbm_result($r_content_edit,0,"st"))?>
          </select>      </td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["main"]["level"]?>:<br>
          <select name="lev">
            <?= mbmIntegerOptions(0, 5,$DB->mbm_result($r_content_edit,0,"lev")); ?>
          </select></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><table width="100%" border="0" cellspacing="2" cellpadding="3">
          <tr class="list_header">
            <td width="25%" align="center"><?=$lang['menu']['show_content_title']?>:</td>
            <td width="25%" align="center"><?=$lang['menu']['use_short_content']?>:</td>
            <td width="25%" align="center"><?=$lang['menu']['use_content_comment']?></td>
            <td width="25%" align="center"><?=$lang['menu']['cleanup_short_content']?></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#f5f5f5"><input name="show_title" type="checkbox" id="show_title" value="1" <?
            if($DB->mbm_result($r_content_edit,0,"show_title")==1){
				echo 'checked="checked" ';
			}
			?> /></td>
            <td align="center" bgcolor="#f5f5f5"><input name="show_content_short" type="checkbox" id="show_content_short" value="1" <?
            if($DB->mbm_result($r_content_edit,0,"show_content_short")==1){
				echo 'checked="checked" ';
			}
			?> /></td>
            <td align="center" bgcolor="#f5f5f5"><input name="use_comment" type="checkbox" id="use_comment" value="1" <?
            if($DB->mbm_result($r_content_edit,0,"use_comment")==1){
				echo 'checked="checked" ';
			}
			?>  /></td>
            <td align="center" bgcolor="#f5f5f5"><input name="cleanup_html" type="checkbox" id="cleanup_html" value="1" <?
            if($DB->mbm_result($r_content_edit,0,"cleanup_html")==1){
				echo 'checked="checked" ';
			}
			?>  /></td>
          </tr>
        </table></td>
        <td bgcolor="#f5f5f5">delgerengui uzehed short content garah esehiig todorhoiloh</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">Title:<br>
          <input name="title" type="text" size="45" value="<?=addslashes($DB->mbm_result($r_content_edit,0,"title"))?>" id="title" /></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['menu']['date_to_publish']?>:<br>
          <script>
		  DateInput('date_added', true, 'DD-MM-YYYY','<?=date("d-m-Y",$DB->mbm_result($r_content_edit,0,"date_added"))?>');
          </script> <input name="hours" type="text" id="hours" value="<?=date("H",$DB->mbm_result($r_content_edit,0,"date_added"))?>" size="4" maxlength="2" />
          : 
          <input name="minutes" type="text" id="minutes" value="<?=date("i",$DB->mbm_result($r_content_edit,0,"date_added"))?>" size="4" maxlength="2" />
: 
<input name="seconds" type="text" id="seconds" value="<?=date("s",$DB->mbm_result($r_content_edit,0,"date_added"))?>" size="4" maxlength="2" /> 
HH:MM:SS</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['main']['tags']?>:<br /><input name="tag" type="text" size="45" value="<?=$DB->mbm_result($r_content_edit,0,"tag")?>" id="tag" /></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <?
        switch($_GET['type']){
            case 'normal':
                echo '<tr><td colspan="2">';
				mbmShowHTMLEditor("both",'spaw2','spaw','all',array(0=>$DB->mbm_result($r_content_edit,0,"content_short"),1=>$DB->mbm_result($r_content_edit,0,"content_more"))
							,'en','100%',"400px");
                echo '</td></tr>';
            break;
            case 'video':
				echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_title'].':<br>
                        <input type="text" value="'.$DB->mbm_result($r_total_videos,0,"title").'"  name="video_title" size="45" /> </td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_title_help'].'</td>
                      </tr>';
                echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_file'].':<br>
                        <input type="file" value="'.$_POST['videoFile'].'"  name="videoFile" size="45" /> </td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['only_video_file_allowed'].'</td>
                      </tr>';
                echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_file'].':<br>
							<input type="checkbox" name="videoURLverify" value="1" checked="checked" /> - verify<br />
							<input type="text" value="'.$DB->mbm_result($r_total_videos,0,"url").'"  name="videoFileURL" size="45" /> URL<br />
							<input type="text" value="'.$DB->mbm_result($r_total_videos,0,"filesize").'"  name="videoFileSIZE" size="45" /> Bytes<br />
							<input type="text" value="'.$DB->mbm_result($r_total_videos,0,"duration").'"  name="videoFileDURATION" size="45" /> Seconds
						</td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['only_video_file_allowed_url'].'</td>
                      </tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_image_thumb'].':<br>
                        <input type="text" value="'.$DB->mbm_result($r_total_videos,0,"image_url").'" name="imageFile" size="45" /></td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['only_images_allowed'].'</td>
                      </tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">'.$lang['menu']['content_short'].':<br>
                        <textarea name="content_short" cols="45" rows="3" id="content_short">'.$DB->mbm_result($r_content_edit,0,"content_short").'</textarea></td>
                        <td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">'.$lang['menu']['video_comment'].':<br>
                        <textarea name="comment" cols="45" rows="3" id="menu_comment">'.$DB->mbm_result($r_total_videos,0,"comment").'</textarea></td>
                        <td bgcolor="#f5f5f5">&nbsp;</td></tr>';
            break;
            case 'photo':
                for($k=0;$k<$total_images;$k++){
					echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td>&nbsp;</td></tr>';
					echo ' <tr>
					<td><strong>'.($k+1).'.</strong> '.$lang['menu']['image_file'].':<br />
					  <input name="img_file['.$DB->mbm_result($r_total_images,$k,"id").']" type="text" value="'.$DB->mbm_result($r_total_images,$k,"url").'" id="img_file['.$DB->mbm_result($r_total_images,$k,"id").']" size="45" class="input" />
					  <br />'.$lang['menu']['image_title'].':<br />
					  <input name="img_title['.$DB->mbm_result($r_total_images,$k,"id").']" type="text" value="'.htmlspecialchars($DB->mbm_result($r_total_images,$k,"title")).'" id="img_title['.$DB->mbm_result($r_total_images,$k,"id").']" size="45" class="input" />
					  <br />
					  '.$lang['menu']['image_comment'].':<br />
					  <textarea name="img_comment['.$DB->mbm_result($r_total_images,$k,"id").']" cols="45" rows="3" id="img_comment['.$DB->mbm_result($r_total_images,$k,"id").']" class="textarea">'.htmlspecialchars($DB->mbm_result($r_total_images,$k,"comment")).'</textarea>
					  </td>
					<td bgcolor="#f5f5f5">&nbsp;</td>
				  </tr>';
    			}
				echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td>&nbsp;</td></tr>';
				echo '<tr><td bgcolor="#f5f5f5">'.$lang["menu"]["content_short"].':<br />
						<textarea name="content_short" cols="45" rows="3" id="content_short">'.htmlspecialchars($DB->mbm_result($r_content_edit,0,"content_short")).'</textarea></td>
						<td bgcolor="#f5f5f5">&nbsp;</td></tr>';
            break;
        }
      ?>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><select name="menu_id[]" multiple="multiple" size="18" style="width:300px">
          <?=mbmShowMenuCombobox(0); ?>
        </select></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">
        <input type="submit" name="Continue" id="Continue" class="button" value="<?
        if($_GET['type']=='normal' || $_GET['type']=='video' || $_GET['type']=='photo'){
			echo $lang['menu']['button_'.$_GET['type'].'_content_update'];
		}else{
			echo $lang['menu']['button_continue'];
		}
		?>"></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
</table>
</form>
<?
}
?>
