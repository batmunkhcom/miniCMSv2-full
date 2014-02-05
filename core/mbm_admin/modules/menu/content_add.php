<script language="javascript">
mbmSetContentTitle("<?= $lang["menu"]["content_add"]?>");
mbmSetPageTitle('<?= $lang["menu"]["content_add"]?>');
show_sub('menu2');

function r(){
	var url='index.php?module=menu&cmd=content_add&type='+document.addContent.type.value+'&mid=';
	var menus = document.addContent.menu_id;
	var buf = '';
	for(i=0;i<menus.length;i++){
		if(menus[i].selected==true){
			buf = buf + menus[i].value+',';
		}
	}
	if(buf==''){
		window.alert('<?=addslashes($lang['menu']['select_menus'])?>');
	}else{
		window.location = url+buf;
	}
}
</script>
<?
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(!isset($_POST['Continue'])){
	// umnuh hereggui photos iig medeelliig baazaas tseverleh
	$q_clean_photos= "DELETE FROM ".PREFIX."menu_photos WHERE content_id=0;"; $DB->mbm_query($q_clean_photos);
}

if(isset($_GET['mid']) && $_GET['mid']!=''){
	$tmp_menus = explode(",",rtrim($_GET['mid'],","));
	echo '<h2>"'.$lang["menu"]["content_add"]." &raquo; ";
	foreach($tmp_menus as $k_menus=>$v_menus){
		$buf_menus .= $DB->mbm_get_field($v_menus,'id','name','menus').', ';
	}
	echo rtrim($buf_menus,', ');
	echo '"</h2>';
}
if(isset($_POST['st'])){
	$result_txt = '';
	
	$data['menu_id'] = ','.$_GET['mid'];
	$data['user_id'] = $_SESSION['user_id'];
	$data['lev'] = $_POST['lev'];
	$data['st'] = $_POST['st'];
	$data['title'] = $_POST['title'];
	$data['use_comment'] = $_POST['use_comment'];
	$data['cleanup_html'] = $_POST['cleanup_html'];
	$data['content_short'] = $_POST['content_short'];
	$data['tag'] = $_POST['tag'];
	if(isset($_POST['content_more'])){
		$data['content_more'] = $_POST['content_more'];
	}
	if(isset($_POST['show_title'])){
		$data['show_title'] = 1;
	}
	if($_POST['show_content_short']==1){
		$data['show_content_short'] = 1;
	}
	
	$date_added_exploded= explode("-",$_POST['date_added']);
	$data['date_added'] = mktime($_POST['hours'],$_POST['minutes'],$_POST['seconds'],$date_added_exploded[1],$date_added_exploded[0],$date_added_exploded[2]);

	$data['date_lastupdated'] = $data['date_added'];
	$data['session_id'] = session_id();
	
	switch($_GET['type']){
		case 'video':
			$data['is_video'] = 1;
			//upload video and thumbnail image
			$flv_filename = mbmTime().'-'.str_replace(" ","",basename($_FILES['videoFile']['name']));
			$flv_thumbnail = VIDEO_DIR.mbmTime().'-'.str_replace(" ","",basename($_FILES['imageFile']['name'])); 
			if(strtolower(substr($flv_filename,-3))!='flv' && $_POST['videoURLverify']!=1){
				$result_txt .= $lang['menu']['error_invalid_video_format'].'.<br />';
				$b=2;
			}
			
			$data_video['ip'] = getenv("REMOTE_ADDR");
			$data_video['date_added'] = mbmTime();
			$data_video['date_lastupdated'] = $data_video['date_added'];
			$data_video['user_id'] = $_SESSION['user_id'];
			$data_video['comment'] = $_POST['video_comment'];
			$data_video['title'] = $_POST['video_title'];
			
			
			$r_content_add = $DB->mbm_insert_row($data,"menu_contents");
			$tmp_content_id = $DB->mbm_get_field($data['session_id'],'session_id','id','menu_contents');
			if($r_content_add==1 && $b!=2){
				if($_POST['videoURLverify']==1){
					$data_video['url'] = $_POST['videoFileURL'];
					$data_video['filesize'] = $_POST['videoFileSIZE'];
					$data_video['duration'] = ($_POST['videoFileDURATIONh']*60*60)+($_POST['videoFileDURATIONm']*60)+$_POST['videoFileDURATIONs'];
				}elseif(!move_uploaded_file($_FILES['videoFile']['tmp_name'],ABS_DIR.VIDEO_DIR."/".$flv_filename)){
					$result_txt .= $lang['menu']['command_video_file_upload_failed'].'.<br />';
					$b=2;
				}else{
					$data_video['url'] = DOMAIN.DIR.VIDEO_DIR.$flv_filename;
					$data_video['filesize'] = $_FILES['videoFile']['size'];
					$data_video['duration'] = mbmGetFLVDuration(ABS_DIR.VIDEO_DIR.$flv_filename);
					$result_txt .= $lang['menu']['command_video_file_uploaded'].'.<br />';
				}
				if(file_exists(ABS_DIR.DIR.$_POST['videoImagePath'])){
					$flv_thumbnail = $_POST['videoImagePath'];
				}elseif(!move_uploaded_file($_FILES['imageFile']['tmp_name'],ABS_DIR.$flv_thumbnail)){
					$result_txt .= $lang['menu']['video_image_thumb_upload_failed'].'.<br />';
					$b=2;
				}
				if($b!=2){
					$data_video['image_url'] = $flv_thumbnail;
					list($data_video['image_width'], 
						$data_video['image_height'], 
						$photo_filetype, 
						$data_video['image_attr']) = getimagesize(ABS_DIR.$flv_thumbnail);
						$data_video['image_filetype'] = $image_types[$photo_filetype];
						$result_txt .= $lang['menu']['video_image_thumb_uploaded'].'.<br />';
				}
				$data_video['content_id'] = $tmp_content_id;
				if($b!=2){
					$r_video_add = $DB->mbm_insert_row($data_video,"menu_videos");
					if($r_video_add==1){
						$result_txt .= $lang["menu"]["command_add_processed"].'. <br />';
						$b=1;
					}else{
						$result_txt .= $lang['menu']['command_video_file_upload_failed'].'.<br />';
						$DB->mbm_query("DELETE FROM ".PREFIX."menu_contents WHERE id='".$tmp_content_id."'");
					}
				}else{
					$DB->mbm_query("DELETE FROM ".PREFIX."menu_contents WHERE id='".$tmp_content_id."'");
				}
			}else{
				$result_txt .= $lang["menu"]["command_add_failed"].'.<br />';
			}
		
		break;
		case 'photo':
			
				$data['is_photo'] = 1;
				$r_content_add = $DB->mbm_insert_row($data,"menu_contents");
				$tmp_content_id = $DB->mbm_get_field($data['session_id'],'session_id','id','menu_contents');
				$DB->mbm_query("UPDATE ".PREFIX."menu_contents SET session_id='' WHERE id='".$tmp_content_id."'");
				if($r_content_add==1){
					$result_txt .= $lang["menu"]["command_add_processed"].'.<br /> ';
					
					$name_array[0] = array('<','&','#','№','@','>','(',')',' ','%','$','^','"',"'");
					$name_array[1] = array('_','_','_','_','_','_','_','_','_','_','_','_','_','_');
					$b=1;
					foreach($_POST['img_title'] as $k=>$v){
						
						$photo_filename = mbmTime().'-'.basename(str_replace($name_array[0],$name_array[1],$_FILES['img_file']['name'][$k]));
						
						if(!move_uploaded_file($_FILES['img_file']['tmp_name'][$k],ABS_DIR.PHOTO_DIR.$photo_filename)){
							$result_txt .= $_FILES['img_file']['name'][$k].' '.$lang['menu']['command_image_file_upload_failed'].'.<br />';
							$b=2;
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
						
						if($b!=2){
							if($DB->mbm_insert_row($data_photo[$k],"menu_photos")==1){
								$result_txt .= $_FILES['img_file']['name'][$k].' '.$lang['menu']['command_image_info_added'].'.<br />';
							}else{
								$result_txt .= $_FILES['img_file']['name'][$k].' '.$lang['menu']['command_image_info_failed'].'.<br />';
								$DB->mbm_query("DELETE FROM ".PREFIX."menu_contents WHERE id='".$tmp_content_id."'");
							}
						}else{
							$DB->mbm_query("DELETE FROM ".PREFIX."menu_contents WHERE id='".$tmp_content_id."'");
						}
					}
				}else{
					$result_txt .= $lang["menu"]["command_add_failed"].'.<br />';
				}
		break;
		case 'normal':
			$data['content_more'] = $_POST['content_more'];
			$r_content_add = $DB->mbm_insert_row($data,"menu_contents");
			if($r_content_add==1){
				$result_txt .= $lang["menu"]["command_add_processed"].'.<br />';
				$b = 1;
			}else{
				$result_txt .= $lang["menu"]["command_add_failed"];
			}
		break;
		case 'youtube':
			$data['is_video'] = 2; //youtube videos
			//upload video and thumbnail image
			
			$data_video['ip'] = getenv("REMOTE_ADDR");
			$data_video['date_added'] = mbmTime();
			$data_video['date_lastupdated'] = $data_video['date_added'];
			$data_video['user_id'] = $_SESSION['user_id'];
			$data_video['category'] = $_POST['video_comment'];
			$data_video['title'] = $_POST['video_title'];
			$data_video['watch_url'] = $_POST['watchURL'];
			$data_video['author'] = $_POST['author'];
			$data_video['embed_code'] = $_POST['embed_code'];
			$data_video['url'] = $_POST['videoFileURL'];
			$data_video['filesize'] = $_POST['videoFileSIZE'];
			$data_video['duration'] = $_POST['videoFileDURATION'];
			$data_video['download_url'] = $_POST['download_url'];
			
			if(substr_count($data_video['url'],DOMAIN) > 0){
				//$data['is_video'] = 1; // youtube-s tatchihsan bol iim bolgono
			}
			
			$r_content_add = $DB->mbm_insert_row($data,"menu_contents");
			$tmp_content_id = $DB->mbm_get_field($data['session_id'],'session_id','id','menu_contents');
			
			if($r_content_add==1 && $b!=2){
				
				$flv_thumbnail = $_POST['videoImagePath'];				
				$data_video['image_url'] = $flv_thumbnail;
				
				if(file_exists(ABS_DIR.$flv_thumbnail)){
					list($data_video['image_width'], 
						$data_video['image_height'], 
						$photo_filetype, 
						$data_video['image_attr']) = getimagesize(ABS_DIR.$flv_thumbnail);
						$data_video['image_filetype'] = $image_types[$photo_filetype];
				}else{
						$data_video['image_width'] = 128;
						$data_video['image_height'] = 96;
						$data_video['image_attr'] = 'width="128" height="96" ';
						$data_video['image_filetype'] = 'jpg';
				}
				
				$data_video['content_id'] = $tmp_content_id;
				
				$r_video_add = $DB->mbm_insert_row($data_video,"menu_youtube");
				if($r_video_add==1){
					$result_txt .= $lang["menu"]["command_add_processed"].'. <br />';
					$b=1;
				}else{
					$result_txt .= $lang['menu']['command_video_file_upload_failed'].'.<br />';
					$DB->mbm_query("DELETE FROM ".PREFIX."menu_contents WHERE id='".$tmp_content_id."'");
				}
			}else{
				$result_txt .= $lang["menu"]["command_add_failed"].'.<br />';
			}
		
		break;
	}
	$DB->mbm_query("UPDATE ".PREFIX."menu_contents SET session_id=''");
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
			buf = buf + i + ']" value="'+i+'" class="input" /><br /><?=$lang['menu']['image_comment']?>:<br />';
		  buf = buf + '<textarea name="img_comment[';
		  buf = buf + i + ']" cols="45" rows="3" id="img_comment[';
		  buf = buf + i + ']" class="textarea">'+i+'</textarea>';
		}
		document.getElementById("images").innerHTML=buf;
	}
	</script>
<form name="addContent" method="post" action="" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
	<?
    if(!isset($_GET['type'])){
    ?>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["menu"]["content_type"]?>:<br>
          <select name="type" id="type">
            <option value="normal"><?=$lang["menu"]["content_normal"]?></option>
            <option value="video"><?=$lang["menu"]["content_video"]?></option>
            <option value="photo"><?=$lang["menu"]["content_photo"]?></option>
            <option value="youtube"><?=$lang["menu"]["content_youtube"]?></option>
          </select>      </td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td width="50%" bgcolor="#f5f5f5"><?=$lang['menu']['select_menus']?>:<br>
          <select name="menu_id" multiple="multiple" size="18" style="width:300px">
            <?=mbmShowMenuCombobox(0); ?>
          </select></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><input class="button" type="button" name="button" id="button" value="<?=$lang['menu']['button_continue']?>"
         onClick="r()"></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <?
    }elseif(strtolower($_GET['type'])=='youtube' && !isset($_POST['youtubeWatchUrl']) && !isset($_POST['st'])){
		?>
	  <tr>
        <td bgcolor="#f5f5f5">
        	<input name="youtubeWatchUrl" type="input" id="youtubeWatchUrl" value="http://www.youtube.com/watch?v=N1Te_03drhk" size="60"  /> - 
            <input name="download_true" type="checkbox" id="download_true" value="1" /> If you want to download video to your server then check it. Requires cURL.
        </td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
	  <tr>
        <td bgcolor="#f5f5f5"><input class="button" type="submit" name="gotoStep2" id="gotoStep2" value="<?=$lang['menu']['button_continue']?>"
         ></td>
        <td bgcolor="#f5f5f5">&nbsp;
        </td>
      </tr>
		<?
	}else{
		if(isset($_POST['youtubeWatchUrl'])){
			
			set_time_limit(0);
			
			$filename_video = 'youtube-'.time().'.flv';
			$filename_image = 'youtube-'.time().'.jpg';
			
			$youtube_video_info = mbmGetYoutubeVideo($_POST['youtubeWatchUrl']);
			$titleValue = $youtube_video_info['title'];
			$tagValue = $youtube_video_info['keywords'];
			$lengthValue = $youtube_video_info['length'];
			$descriptionValue = $youtube_video_info['description'];
			$thumbnailValue = $youtube_video_info['thumbnail'];
			$authorValue = $youtube_video_info['author'];
			$watchURLValue = $youtube_video_info['watchURL'];
			$viewCountValue = $youtube_video_info['viewCount'];
			$ratingValue = $youtube_video_info['rating'];
			$videoCategoryValue = $youtube_video_info['videoCategory'];	
			$embedCodeValue = $youtube_video_info['embed_code'];		
			$fileSize = 0;
			
			$tube = new youtube();
			$download_link = $tube->get($_POST['youtubeWatchUrl']);
			
			$orig_download_url  = $download_link;
			if($_POST['download_true'] == '1'){
				$video_dlURL = VIDEO_DIR.$filename_video;
				
				//downloading video
				mbmDownloadWithCURL($download_link,ABS_DIR.$video_dlURL);
				//if($fileSize>100000) $download_link = DOMAIN.DIR.$video_dlURL;
				if(file_exists(ABS_DIR.$video_dlURL)){
					$download_link = DOMAIN.DIR.$video_dlURL;
				}
				$fileSize = filesize(ABS_DIR.$video_dlURL);
				//downloading photo
				mbmDownloadWithCURL($thumbnailValue,ABS_DIR.VIDEO_DIR.$filename_image);
				$thumbnailValue = VIDEO_DIR.$filename_image;
				
				$from_youtube = 1;
			}
			
		}else{
			if($_POST['from_youtube'] == '1') {
				$from_youtube = 1;
			}else  {
				$from_youtube = 0;
			}
			
			$titleValue = $_POST['title'];
			$tagValue = $_POST['tag'];
			$lengthValue = $_POST['videoFileDURATION'];
			$descriptionValue = $_POST['content_short'];
			$thumbnailValue = $_POST['videoImagePath'];
			$author = $_POST['author'];
			$watchURL = $_POST['watchURL'];
			//$rating = $_POST[''];
			$videoCategory = $_POST['video_comment'];
			$fileSize = $_POST['videoFileSIZE'];
			$download_link = $_POST['videoFileURL'];
			$embedCodeValue = $_POST['embed_code'];	
			$orig_download_url = $_POST['download_url'];	
	    }
    ?>
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
            <?= mbmIntegerOptions(0, $_SESSION['lev'],$_POST['lev']); ?>
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
            <td align="center" bgcolor="#f5f5f5"><input name="show_title" type="checkbox" id="show_title" value="1" checked="checked" /></td>
            <td align="center" bgcolor="#f5f5f5"><input name="show_content_short" type="checkbox" id="show_content_short" value="1" /></td>
            <td align="center" bgcolor="#f5f5f5"><input name="use_comment" type="checkbox" id="use_comment" value="1" checked="checked" /></td>
            <td align="center" bgcolor="#f5f5f5"><input name="cleanup_html" type="checkbox" id="cleanup_html" value="1" /></td>
          </tr>
        </table></td>
        <td bgcolor="#f5f5f5">delgerengui uzehed short content garah esehiig todorhoiloh</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['menu']['content_title']?>:<br>
          <input name="title" type="text" size="45" value="<?=$titleValue;?>" id="title" /></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['menu']['date_to_publish']?>:<br>
          <script>
		  DateInput('date_added', true, 'DD-MM-YYYY');
          </script> <input name="hours" type="text" id="hours" value="<?=mbmDate("H")?>" size="4" maxlength="2" />
          : 
          <input name="minutes" type="text" id="minutes" value="<?=mbmDate("i")?>" size="4" maxlength="2" />
: 
<input name="seconds" type="text" id="seconds" value="<?=mbmDate("s")?>" size="4" maxlength="2" /> 
HH:MM:SS</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['main']['tags']?>:<br /><input name="tag" type="text" size="45" value="<?=$tagValue?>" id="tag" /></td>
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
				mbmShowHTMLEditor("both",'spaw2','spaw','all',array(0=>'',1=>'')
							,'en','100%',"400px");
                echo '</td></tr>';
            break;
            case 'video':
                echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_title'].':<br>
                        <input type="text" value="'.$_POST['video_title'].'"  name="video_title" size="45" /> </td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_title_help'].'</td>
                      </tr>';
                echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_file'].':<br>
                        <input type="file" value="'.$_POST['videoFile'].'"  name="videoFile" size="45" /> </td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['only_video_file_allowed'].'</td>
                      </tr>';
                echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_file'].':<br>
							<input type="checkbox" name="videoURLverify" value="1" /> - verify<br />
							<input type="text" value="'.$_POST['videoFileURL'].'"  name="videoFileURL" size="45" /> URL<br />
							<input type="text" value="'.$_POST['videoFileSIZE'].'"  name="videoFileSIZE" size="45" /> Bytes<br />
							<input type="text" value="'.$_POST['videoFileDURATIONh'].'"  name="videoFileDURATIONh" size="2" /> Hours 
							<input type="text" value="'.$_POST['videoFileDURATIONm'].'"  name="videoFileDURATIONm" size="2" /> Minutes 
							<input type="text" value="'.$_POST['videoFileDURATIONs'].'"  name="videoFileDURATIONs" size="2" /> Seconds<br />
							<input type="text" value="'.$_POST['videoImagePath'].'.jpg" 
									onblur="document.getElementById(\'flvImgThumb\').innerHTML=\'<img src='.DOMAIN.DIR.'\'+this.value+\'\\ width=100 />\'"
									name="videoImagePath" size="45" /> 
									image if it\s  next to with flv. uses abs dir.<div id="flvImgThumb"></div>
						</td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['only_video_file_allowed_url'].'</td>
                      </tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_image_thumb'].':<br>
                        <input type="file" value="'.$_POST['imageFile'].'" name="imageFile" size="45" /></td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['only_images_allowed'].'</td>
                      </tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">'.$lang['menu']['content_short'].':<br>
                        <textarea name="content_short" cols="45" rows="3" id="menu_comment">'.$_POST['content_short'].'</textarea></td>
                        <td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">'.$lang['menu']['video_comment'].':<br>
                        <textarea name="video_comment" cols="45" rows="3" id="menu_comment">'.$_POST['video_comment'].'</textarea></td>
                        <td bgcolor="#f5f5f5">&nbsp;</td></tr>';
            break;
            case 'photo':
                $q_current_images = "SELECT * FROM ".PREFIX."menu_photos WHERE content_id=0 ORDER BY id";
                $r_current_images = $DB->mbm_query($q_current_images);
                
                if($DB->mbm_num_rows($r_current_images)>0){
                    echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                    echo '<tr><td bgcolor="#f5f5f5">'.$lang['menu']['images_uploaded'].'<br />';
                        for($i=0;$i<$DB->mbm_num_rows($r_current_images);$i++){
                            echo ($i+1).'. '.$DB->mbm_result($r_current_images,$i,"url").'<br />';
                        }
                        echo '</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                    echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                }
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo ' <tr>
				<td bgcolor="#f5f5f5">'.$lang['menu']['images_total'].':<br />
				  <select name="img_total" id="img_total" class="input" onChange="mbmShowImageFields(this.value)">
					'.mbmIntegerOptions(1,88).'
				  </select>
				  <div id="images" style="display:block;"><br /><strong>1.</strong> '.$lang['menu']['image_file'].':<br />
				  <input name="img_file[1]" type="file" id="img_file[1]" size="45" class="input" />
				  <br />'.$lang['menu']['image_title'].':<br />
				  <input name="img_title[1]" type="text" id="img_title[1]" value="" size="45" class="input" />
				  <br />
				  '.$lang['menu']['image_comment'].':<br />
				  <textarea name="img_comment[1]" cols="45" rows="3" id="img_comment[1]" class="textarea"></textarea>
				  </div>      </td>
				<td bgcolor="#f5f5f5">&nbsp;</td>
			  </tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">'.$lang["menu"]["content_short"].':<br />
                        <textarea name="content_short" cols="45" rows="3" id="menu_comment">'.$_POST["content_short"].'</textarea></td>
                        <td bgcolor="#f5f5f5">&nbsp;</td></tr>';
    
            break;
			case 'youtube':
                echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_title'].':<br>
                        <input type="text" value="'.$titleValue.'"  name="video_title" size="45" /> </td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_title_help'].'</td>
                      </tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
				if($from_youtube == 1 || isset($_POST['from_youtube'])){
					echo '<tr>
							<td bgcolor="#f5f5f5">Download video to local server?<br>
							<input name="from_youtube" type="checkbox" id="from_youtube" value="1" checked="checked" /></td>
							<td bgcolor="#f5f5f5">&nbsp;</td>
						  </tr>';
	                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
				}
                echo '<tr>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['video_file'].':<br>
							<input type="text" value="'.$download_link.'"  name="videoFileURL" size="45" /> URL<br />
							<input type="text" value="'.$fileSize.'"  name="videoFileSIZE" size="45" /> Bytes<br />
							<input type="text" value="'.$lengthValue.'"  name="videoFileDURATION" size="4" /> Duration<br />
							<input type="text" value="'.$orig_download_url.'"  name="download_url" size="45" /> Youtube download url<br />
							<input type="text" value="'.$thumbnailValue.'" 
									onblur="document.getElementById(\'flvImgThumb\').innerHTML=\'<img src='.DOMAIN.DIR.'\'+this.value+\'\\ width=100 />\'"
									name="videoImagePath" size="45" /> 
									image if it\s  next to with flv. uses abs dir.<div id="flvImgThumb"></div>
						</td>
                        <td bgcolor="#f5f5f5">'.$lang['menu']['only_video_file_allowed_url'].'</td>
                      </tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">'.$lang['menu']['content_short'].':<br>
                        <textarea name="content_short" cols="45" rows="3" id="menu_comment">'.$descriptionValue.'</textarea></td>
                        <td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">'.$lang['menu']['video_comment'].':<br>
                        <textarea name="video_comment" cols="45" rows="3" id="menu_comment">'.$videoCategoryValue.'</textarea></td>
                        <td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">&nbsp;</td><td bgcolor="#f5f5f5">&nbsp;</td></tr>';
                echo '<tr><td bgcolor="#f5f5f5">Embed code:<br>
                        <textarea name="embed_code" cols="45" rows="3" id="embed_code">'.$embedCodeValue.'</textarea></td>
                        <td bgcolor="#f5f5f5">&nbsp;</td></tr>';
			break;
        }
      ?>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">
        <input type="submit" name="Continue" id="Continue" class="button" value="<?
        if($_GET['type']=='normal' || $_GET['type']=='video' || $_GET['type']=='photo'){
			echo $lang['menu']['button_'.$_GET['type'].'_content_add'];
		}else{
			echo $lang['menu']['button_continue'];
		}
		?>"></td>
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
