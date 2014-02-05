<?

function mbmGetFLVDuration($file){
	
	/*
	* ffmpeg iin tuslamjtai videonii hugatsaag todorhoiloh. 
	* ffmpeg bhaas gadna exec command idevhtei bh heregtei
	*/
	
	//$time = 00:00:00.000 helbertei bna
	$time =  exec("ffmpeg -i ".$file." 2>&1 | grep \"Duration\" | cut -d ' ' -f 4 | sed s/,//");
	
	
	$duration = explode(":",$time);
	
	$duration_in_seconds = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);
	
	return $duration_in_seconds;
	
	/* ene code n php iin tuslamjtai zuvhun flv file iin durationg todorhoilno
	// get contents of a file into a string
	if (file_exists($file)){
		$handle = fopen($file, "r");
		$contents = fread($handle, filesize($file));
		fclose($handle);
		
		if (strlen($contents) > 3){
			if (substr($contents,0,3) == "FLV"){
				$taglen = hexdec(bin2hex(substr($contents,strlen($contents)-3)));
				if (strlen($contents) > $taglen){
					$duration = hexdec(bin2hex(substr($contents,strlen($contents)-$taglen,3)));
					return ceil($duration/1000);
				}
			}
		}
	}
	return false;
	*/
}

function mbmFLVDurationToMinute($seconds=60){
	$hour = (int)($seconds/3600);
	$min = (int)(($seconds-$hour*3600)/60);
	$secs = ($seconds%60);
	if($secs<10){
		$secs = '0'.$secs;
	}
	if($min<10){
		$min = '0'.$min;
	}
	if($hour == 0) $hour = '';
	else $hour = $hour.':';
	return $hour.$min.':'.$secs;
}
?>