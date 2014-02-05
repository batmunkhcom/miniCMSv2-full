<?

	if(file_exists(base64_decode($_GET['abs_url']))){

		$data['duration'] = base64_decode($_GET['duration']);

		$data['filename_orig'] = base64_decode($_GET['filename']);

		$data['dl_url'] = base64_decode($_GET['dl_url']);

		$data['abs_url'] = str_replace(ABS_DIR,"",base64_decode($_GET['abs_url']));

		$data['filesize'] = base64_decode($_GET['filesize']);

		$data['mimetype'] = base64_decode($_GET['mimetype']);

		$data['user_id'] = $_SESSION['user_id'];

		$data['session_time'] = mbmTime();

		$data['date_added'] = mbmTime();

		$user_conf = mbmFileshareUserConfig($_SESSION['user_id']);

		$data['days_to_save'] = $user_conf['days_to_save'];//$config_fileshare['days_to_save'][$_SESSION['lev']];

		$data['days_to_save_reset'] = $user_conf['days_to_save'];

		$data['key'] = mbmGenerateFileMD5();

		$data['key_delete'] = md5($data['key'].'-del');

		$data['st'] = 1;

		$data['country'] = $_SESSION['country']['name'];

		

		$r_tags[0] = array('.','-','_');

		$r_tags[1] = array(' ',' ',' ');

		

		$data['tags'] = str_replace($r_tags[0],$r_tags[1],$data['filename_orig']);

		

		if($DB->mbm_check_field('abs_url',$data['abs_url'],'fileshare')==0){

			$DB->mbm_insert_row($data,'fileshare');

		}

		

		echo '<div style="text-align:center;background-color:#fefbe6;

	border: 1px solid #fef1b2; padding:5px;">';

		echo 'Зарцуулсан хугацаа: <br />

				<strong>'.$data['duration'].' секунд</strong><br /><br />';

		echo 'Файлын нэр: <br />

				<strong>'.$data['filename_orig'].'</strong><br /><br />';

		echo 'Татах холбоос: <br />';

			'<strong>'.DOMAIN.DIR.'?k='.$data['key'].'</strong><br /><br />';

			echo '<strong>'.DOMAIN.DIR.''.$data['key'].'</strong><br /><br />';

		echo 'Устгах холбоос:<br />

			<strong>'.DOMAIN.DIR.'index.php?k='.$data['key'].'&action=delete&del_key='.$data['key_delete'].'</strong><br /><br />';

		echo '</div>';

	}else{

		echo mbmError('file not exists');

	}

?>