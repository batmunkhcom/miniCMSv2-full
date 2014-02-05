<?

if($mBm!=1 || $_SESSION['lev']==0){

	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');

} 

echo '<div id="title_menu">'.$lang['user']['avatars'].'</div>';

	if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){

		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		
		$fp = fopen($tmpName, 'r');
		$content = fread($fp, $fileSize);
		$content = addslashes($content);
		fclose($fp);
		
		if(!get_magic_quotes_gpc()){
			$fileName = addslashes($fileName);
		}
		list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
		
		$fileType = $image_types[$type];
		
		if($DB2->mbm_check_field("user_id",$_SESSION['user_id'],"user_avatars")==0){
			$query = "INSERT INTO ".USER_DB_PREFIX."user_avatars (user_id,name, size, filetype, content ) ".
					 "VALUES ('".$_SESSION['user_id']."','$fileName', '$fileSize', '$fileType', '$content')";
		}else{
			$query = "UPDATE ".USER_DB_PREFIX."user_avatars SET name='$fileName',size= '$fileSize', filetype= '$fileType',content = '$content' 
						WHERE user_id='".$_SESSION['user_id']."' LIMIT 1";		
		}
		echo '<div id="query_result">';
		if($width>AVATAR_WIDTH || $height>AVATAR_HEIGHT){
			echo $lang["users"]["error_avatar_dimensions"];
		}elseif($fileSize>(AVATAR_FILESIZE*1024)){
			echo $lang["users"]["error_max_avatar_filesize"].ceil(AVATAR_FILESIZE/1024).'kb.';
		}else{
			$r_avatars = $DB2->mbm_query($query);
			if($r_avatars==1){
				echo $lang["users"]["command_avatar_uploaded"];
			}else{
				echo $lang["users"]["error_occurred"];
			}
		}
		echo '</div>';
	}

?>

<h2>Avatar</h2>
<strong><?=$lang["users"]["avatar_current"]?></strong>:<br />
<img src="modules/users/avatar_show.php?id=<?=$DB2->mbm_get_field($_SESSION['user_id'],"user_id","id","user_avatars")?>" vspace="5" /><br>

<br>


Таны хөрөг зураг (avatar) 120x120 пиксел хэмжээтэй байх хэрэгтэй. Та зургаа сонгоод ХӨРӨГ ЗУРАГ ОРУУЛАХ товчийг дарна уу.
<form method="post" enctype="multipart/form-data" action="">

<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">

<tr>

<td>

<input type="hidden" name="MAX_FILE_SIZE" value="<?=AVATAR_FILESIZE?>">

<input name="userfile" type="file" id="userfile" class="input">

<input name="upload" type="submit" id="upload" class="button" value="<?=$lang['users']['button_avatar_upload']?>" />

</td>

</tr>

</table>

</form>