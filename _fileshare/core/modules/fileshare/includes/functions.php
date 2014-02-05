<?
function mbmGenerateFileMD5(){
	global $DB;
	
	$key = md5(rand(1,99999999999));
	
	if($DB->mbm_check_field('key',$key,'fileshare')==1){
		$key = mbmGenerateFileMD5();
	}
	
	return $key;
}

function mbmDeleteFileFileshare($var = array(
										'del_key'=>'',
										'key'=>''
										)){
	
	global $DB,$lang,$ftp_config;
	
	$q_checkfile = "SELECT id,abs_url,filename_orig FROM ".PREFIX."fileshare WHERE `key`='".$var['key']."' AND `key_delete`='".$var['del_key']."' LIMIT 1";
	$r_checkfile = $DB->mbm_query($q_checkfile);
	
	if($DB->mbm_num_rows($r_checkfile)==1){
		$conn_id = @ftp_connect($ftp_config['server']);
		$ftp_login = @ftp_login($conn_id,$ftp_config['username'],$ftp_config['password']);

		$file_to_delete = $ftp_config['web_root'].str_replace(ABS_DIR,'',$DB->mbm_result($r_checkfile,0,'abs_url'));
		
		if(@ftp_delete($conn_id ,$file_to_delete )==1){
			$DB->mbm_query("DELETE FROM ".PREFIX."fileshare  WHERE `key`='".$var['key']."' AND `key_delete`='".$var['del_key']."' LIMIT 1");
			$buf = '<strong>Файлыг устгав</strong>';
		}else{
			$buf = 'Файлыг устгаж чадсангүй. Алдаа гарлаа.';
		}
	}else{
		$buf = 'Уг файл олдсонгүй.';
	}
	
	//$buf .= $DB->mbm_result($r_checkfile,0,'abs_url').'-'.$DB->mbm_num_rows($r_checkfile).'-';
	return $buf;
}

function mbmFileshareSumStats($type='downloaded'){
	global $DB;
	
	$q = "SELECT SUM(".$type.") FROM ".PREFIX."fileshare";
	$r = $DB->mbm_query($q);
	
	return $DB->mbm_result($r,0);
}

function mbmFileshareFilelist($var =array(
										  'order_by'=>'id',
										  'asc'=>'asc',
										  'user_id'=>0,
										  'lev'=>0,
										  'st'=>1,
										  'copyright'=>0,
										  'limit'=>10,
										  'html_0'=>'',
										  'html_1'=>'',
										  'is_private'=>1,
										  'class'=>'',
										  'show_downloads'=>0)){

	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."fileshare WHERE id!=0 ";
	if($var['is_private']!=2){
		$q .= "AND is_private='".$var['is_private']."' ";
	}
	if($var['lev']!=0){
		$q .= "AND lev='".$var['lev']."' ";
	}
	if($var['st']!=0){
		$q .= "AND st='".$var['st']."' ";
	}
	if($var['user_id']!=0){
		$q .= "AND user_id='".$var['user_id']."' ";
	}
	
	$q .= "ORDER BY ".$var['order_by']." ".$var['asc']." LIMIT ".$var['limit']."";
	
	$r = $DB->mbm_query($q);
	
	$buf = '';
	
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= $var['html_0'];
		$buf .= '<a href="'.DOMAIN.DIR.$DB->mbm_result($r,$i,"key").'" class="'.$var['class'].'">';
			$buf .= ($i+1).'. '.mbmSubStringFilename(array('txt'=>$DB->mbm_result($r,$i,"filename_orig"),'maxlength'=>25));
		$buf .= '</a>';
		if($var['show_downloads']==1){
			$buf .= ' ['.$DB->mbm_result($r,$i,"downloaded").']';
		}
		$buf .= $var['html_1'];
	}
	
	return $buf;
}

function mbmFileshareUserConfig($user_id=0){
	global $DB,$config_fileshare;
	
	$user_config = array();
	
	$q = "SELECT * FROM ".PREFIX."fileshare_config WHERE user_id='".$user_id."' ORDER BY id DESC LIMIT 1";
	$r = $DB->mbm_query($q);
	
	if($DB->mbm_num_rows($r)==1){
		if($DB->mbm_result($r,0,"days_to_save")>0){
			$user_config['days_to_save'] = $DB->mbm_result($r,0,"days_to_save");
		}else{
			$user_config['days_to_save'] = $config_fileshare['days_to_save'][$_SESSION['lev']];
		}
		if($DB->mbm_result($r,0,"dl_limit")>0){
			$user_config['dl_limit'] = $DB->mbm_result($r,0,"dl_limit");
		}else{
			$user_config['dl_limit'] =$config_fileshare['dl_limit'][$_SESSION['lev']];
		}
	}else{
			$user_config['dl_limit'] =$config_fileshare['dl_limit'][$_SESSION['lev']];
			$user_config['days_to_save'] = $config_fileshare['days_to_save'][$_SESSION['lev']];		
	}
	
	return $user_config;
}
function mbmFilshareLink($var=array(
									'key'=>'',
									'name'=>'',
									'target'=>'_self'
									)){
	return '<a href="'.DOMAIN.DIR.'?k='.$var['key'].'" target="'.$var['target'].'">'.$var['name'].'</a>';
}

?>