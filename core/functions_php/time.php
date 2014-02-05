<?

function mbmTime(){
	global $config;
	$result = (time()+(TIME_ZONE*60*60));
	return $result;
}

function mbmDate($type="Y"){
	global $config;
	$result = date("$type",mbmTime());
	return $result;
}
function mBmTimeConverter($time=0){
	global $lang;
	
	$now = mbmTime();
	$total_seconds = $now - $time;
	$minutes = floor($total_seconds/60);
	$hours = floor($minutes/60);
	$days = floor($hours/24);
	$months =floor($days/30); 
	$years = floor($months/12);
	$seconds = ($total_seconds%60);
	$buf = '';
	if($years>0){
		$year = $years;
	}
	if($months>0){
		$month = ($months%12);
	}
	if($days>0){
		$day = ($days%30);
	}
	if($hours>0){
		$hour = ($hours%24);
	}
	if($minutes>0){
		$minute= ($minutes%60);
	}
	
	if($years==0){
		$result = $month;
		if($day>0){
			$result .= ' '.$lang["main"]["months"].' '.$day.' '.$lang["main"]["days_ago"];
		}else{
			$result .= ' '.$lang["main"]["months_ago"];
		}
	}else{
		$result = $year;
		if($month>0){
			$result .= ' '.$lang["main"]["years"].' '.$month.' '.$lang["main"]["months_ago"];
		}else{
			$result .= $lang["main"]["years_ago"];
		}
	}
	if($months==0){
		$result = $day;
		if($hour>0){
			$result .= ' '.$lang["main"]["days"].' '.$hour.' '.$lang["main"]["hours_ago"];
		}else{
			$result .= ' '.$lang["main"]["days_ago"];
		}
	}
	if($days==0){
		$result = $hour;
		if($minute>0){
			$result .= ' '.$lang["main"]["hours"].' '.$minute.' '.$lang["main"]["minutes_ago"];
		}else{
			$result .= ' '.$lang["main"]["hours_ago"];
		}
	}
	if($hours==0){
		$result = $minute;
		if($seconds>0){
			$result .= ' '.$lang["main"]["minutes"].' '.$seconds.' '.$lang["main"]["seconds_ago"];
		}else{
			$result .= ' '.$lang["main"]["minutes_ago"];
		}
	}
	if($minutes==0){
		$result = $seconds.' '.$lang["main"]["seconds_ago"];
	}
	
	return $result;
}

?>