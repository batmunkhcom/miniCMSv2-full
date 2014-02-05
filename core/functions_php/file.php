<?

//photo content ed nariin photo tatahad hereglegdeh uchir end baih shaardlagatai
function mbmDownloadWithLimit(
							$var = array(
								'real_path'=>'', //file iin original path
								'user_filename'=>'', //hereglegch yamar nereer tatah
								'download_rate'=>0.1, //tatah hurd  0.1 == 100bytes p/s
								'fileshare'=>0 //fileshare iin file mun eseh
								)){
 
    global $DB;
	
	//First, see if the file exists  
	$file = $var['real_path'];
	$speed = $var['download_rate'];
    if (!is_file($file)) {
        die("<b>404 File not found!</b>");
    }  
    //Gather relevent info about file
    $filename = basename($file);
    $file_extension = strtolower(substr(strrchr($filename,"."),1));
	
    // This will set the Content-Type to the appropriate setting for the file
    switch( $file_extension ) {
        case "exe":
            $ctype="application/octet-stream";
		break;
        case "zip":
            $ctype="application/zip";
        break;
        case "mp3":
            $ctype="audio/mpeg";
        break;
        case "mpg":
            $ctype="video/mpeg";
        break;
        case "avi":
            $ctype="video/x-msvideo";
        break;
        //  The following are for extensions that shouldn't be downloaded
        // (sensitive stuff, like php files)
		/*
        case "php":
			 $ctype= "text/html";
        break;
        case "htm":
			 $ctype= "text/html";
        break;
        case "html":
			 $ctype= "text/html";
        break;
        case "txt":
			 $ctype= "text/html";
            //die("<b>Cannot be used for ". $file_extension ." files!</b>");
        break;
        case "rar":
			 $ctype= "application/octet-stream";
        break;
        case "rar":
			 $ctype= "application/x-rar-compressed";
        break;
		*/
        default:
            $ctype="application/force-download";
        break;
    }
 	if(substr_count($var['mimetype'],'/')>0){
		$ctype = $var['mimetype'];
	}
    //  Begin writing headers
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Type: $ctype");
 
 
    $header='Content-Disposition: attachment; filename='.rawurlencode(str_replace(" ","_",$var['user_filename']));
    header($header);
    header("Accept-Ranges: bytes");
 
    $size = filesize($file);  
    //  check if http_range is sent by browser (or download manager)  
    if(isset($_SERVER['HTTP_RANGE'])) {
        // if yes, download missing part     
 
        $seek_range = substr($_SERVER['HTTP_RANGE'] , 6);
        $range = explode( '-', $seek_range);
        if($range[0] > 0) { $seek_start = intval($range[0]); }
        if($range[1] > 0) { $seek_end  =  intval($range[1]); }
 
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: " . ($seek_end - $seek_start + 1));
        header("Content-Range: bytes $seek_start-$seek_end/$size");
    } else {
        header("Content-Range: bytes 0-$seek_end/$size");
        header("Content-Length: $size");
    }  
    //open the file
    $fp = fopen("$file","rb");
 
    //seek to start of missing part  
    fseek($fp,$seek_start);
 
 	//session check eheleh
 	$sleep_i = 0;
	$data_fileshare_session['ip'] = getenv("REMOTE_ADDR");
	$data_fileshare_session['session_time'] = mbmTime();
	$data_fileshare_session['session_id'] = session_id();
	//session utguudiig beldej duusav
	
    //start buffered download
    while(!feof($fp)) {      
        //reset time limit for big files
        set_time_limit(0);      
        print(fread($fp,1024*$speed));
        flush();
        sleep(1);
		/*
		if($var['fileshare']==1){
			if(($sleep_i%5)==0){ //5-15 sec tutam session update hiih.
				if($DB->mbm_check_field('session_id',session_id(),'fileshare_sessions')==1){
					$DB->mbm_query("UPDATE ".PREFIX."fileshare_sessions SET session_time='".time()."' WHERE session_id='".session_id()."' LIMIT 1");
				}else{
					$DB->mbm_insert_row($data_fileshare_session,'fileshare_sessions');
				}
			}
		}
		$sleep_i++;
		*/
    }
	
	if($var['fileshare']==1){
		$DB->mbm_query("DELETE FROM ".PREFIX."fileshare_sessions WHERE session_id='".session_id()."' OR session_time<'".(mbmTime()-60*3)."'");
	}

    fclose($fp);
}
function mbmFileSizeMB($bytes=1024,$type='MB'){
	
	switch($type){
		case 'GB':
			$devide_by = (1024*1024*1024);
		break;
		case 'MB':
			$devide_by = (1024*1024);
		break;
		case 'KB':
			$devide_by = 1024;
		break;
		default:
			$devide_by = (1024*1024);
		break;
	}
	if($devide_by ==0 ){
		$devide_by = 1024*1024;
	}
	$result = number_format(($bytes/$devide_by),2,'.',',');
	
	if($bytes > 0) return number_format(($bytes/$devide_by),2,'.',',').' '.$type;
	else return '-';
}


function mbm_mime_type($filename=''){

}

function mbmSubStringFilename($var = array('txt'=>'','maxlength'=>'')){
	
	if(strlen($var['txt'])>$var['maxlength']){
		$fname = substr($var['txt'],0,($var['maxlength']-8)).'...'.substr($var['txt'],-8);	
	}else{
		$fname = $var['txt'];
	}
	return $fname;
}


function mbm_include_file($file=''){
	global $DB, $DB2,$lang,$PHPMAILER,$BBCODE,$censored_words;
    $mBm=1;
    
	$file = mbm_cleanup_filename($file);
	if(file_exists(ABS_DIR.$file)){
    	include_once(ABS_DIR.$file);
	}else{
    	return 'hacking attempt!!!!';
	}
	
    return true;
}

//файлын замыг засварлах функц
function mbm_cleanup_filename($filepath=''){
      
	  $filepath = str_replace("../","",$filepath);
      if(substr_count($filepath,"../")>0){
            mbm_cleanup_filename($filepath);
      }
      return $filepath;
} 

//for cache

function mbmFileContent($filename){

	$handle = fopen($filename, "rb");
	$contents = '';
	$f_size = 0;
	while (!feof($handle)) {
	 $contents .= fread($handle, 8192);
	 $f_size = $f_size + strlen($contents);
	}
	fclose($handle);
	return $contents;
}
function mbmFileSize($filename){

	$handle = fopen($filename, "rb");
	$contents = '';
	$f_size = 0;
	while (!feof($handle)) {
	 $contents .= fread($handle, 8192);
	 $f_size = $f_size + strlen($contents);
	}
	fclose($handle);
	return $f_size;
}
//for cache functions ends
?>