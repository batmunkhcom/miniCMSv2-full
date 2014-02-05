<?

function mbmYahooWearther(
						  $var = array(
						  	'location_code'=>'MGXX0003',
						  	'image_size'=>'small',
						  	'unit'=>'c'
						  )
						  ){
	global $lang;
	
	$img_dir = "http://l.yimg.com/us.yimg.com/i/us/we/52/";
	$big_img_dir = "http://l.yimg.com/us.yimg.com/i/us/nws/weather/gr/"; //PNG zurag
	
	$weather_feed = file_get_contents("http://weather.yahooapis.com/forecastrss?p=".$var['location_code']."&u=".$var['unit']);
	
	//Creating Instance of the Class
	$xmlObj    = new XmlToArray($weather_feed);
	//Creating Array
	$arrayData = $xmlObj->createArray();
	
	$buf = '<div id="WeatherBox">';
	$buf .= '<div id="WeatherTitle">';
	$buf .= $lang["weather"]["at_the_moment"].' (';
	if(isset($lang['weather']['code'][$var['location_code']])){
		$buf .= $lang['weather']['code'][$var['location_code']];
	}else{
		$buf .= $arrayData['rss']['channel'][0]['yweather:location']['city'];
	}
	$buf .= ') </div>';
		$buf .= '<img src="';
			switch($var['image_size']){
				case 'big':
					$img_complete_url = $big_img_dir.$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['code'].'n.png';
				break;
				default:
					$img_complete_url = $img_dir.$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['code'].'.gif';
				break;
			}
		$buf .= $img_complete_url.'" algin="left" hspace="5">';
		$buf .= '<big><strong>'.$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['temp'].'&deg;'.$arrayData['rss']['channel'][0]['yweather:units']['temperature'].'</strong></big><br />';
		$buf .= $lang["weather"][$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['code']].'<br /><br />';
		$buf .= $lang["weather"]["wind_speed"].': '.mbmKPHtoMPS(array(
							'km'=>$arrayData['rss']['channel'][0]['yweather:wind']['speed'])).' м/с<br />';
		$buf .= '<br clear="both" />'.$lang["weather"]["tomorrow"].':<br />';
		//$buf .= '<img src="'.$img_dir.$arrayData['rss']['channel'][0]['item'][0]['yweather:forecast']['code'].'.gif" algin="left" hspace="5">';
		$buf .= $lang["weather"]["high"].': '.$arrayData['rss']['channel'][0]['item'][0]['yweather:forecast']['high'].'&deg;'.$arrayData['rss']['channel'][0]['yweather:units']['temperature'].', ';
		$buf .= $lang["weather"]["low"].': '.$arrayData['rss']['channel'][0]['item'][0]['yweather:forecast']['low'].'&deg;'.$arrayData['rss']['channel'][0]['yweather:units']['temperature'].'<br />';
		$buf .= $lang["weather"][$arrayData['rss']['channel'][0]['item'][0]['yweather:forecast']['code']].'<br />';
		$buf .= '<br />'.$lang["weather"]["sunrise"].': '.$arrayData['rss']['channel'][0]['yweather:astronomy']['sunrise'].'<br />';
		$buf .= $lang["weather"]["sunset"].': '.$arrayData['rss']['channel'][0]['yweather:astronomy']['sunset'].'<br />';
		$buf .= mbmWeatherLink($lang['main']['more']);
	$buf .= '</div>';
	
	mbmWeatherStat(array(
						'code'=>$var['location_code']
						)
					);
	
	return  $buf;
	
}


function mbmYahooWeartherMore(
						  $var = array(
						  	'location_code'=>'MGXX0003',
						  	'unit'=>'c'
						  )
						  ){
	global $lang;
	
	$weather_feed = file_get_contents("http://weather.yahooapis.com/forecastrss?p=".$var['location_code']."&u=".$var['unit']);
	
	//Creating Instance of the Class
	$xmlObj    = new XmlToArray($weather_feed);
	//Creating Array
	$arrayData = $xmlObj->createArray();
	
	$weather_code = $arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['code'];
	$weather_unit = '&deg;'.$arrayData['rss']['channel'][0]['yweather:units']['temperature'];
	
	$buf = '<div id="locationTitle">'.$lang['weather']['code'][$var['location_code']].'</div>';
	$buf .= '<div id="weatherContainer">';
		$buf .= '<div id="weatherCol1">';
			$buf .= '<div class="weatherValue">'.$lang["weather"][$weather_code];
			//$buf .= ' ('.$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['temp'].$weather_unit.')';
			$buf .= '</div>';
			$buf .= '<div>';
				$buf .= $lang["weather"]["barometer"].' : '.$arrayData['rss']['channel'][0]['yweather:atmosphere']['pressure'].' '.$arrayData['rss']['channel'][0]['yweather:units']['pressure'];
				$buf .= '<br />';
				$buf .= $lang["weather"]["humidity"].' : '.$arrayData['rss']['channel'][0]['yweather:atmosphere']['humidity'].'%';
				$buf .= '<br />';
				$buf .= $lang["weather"]["visibility"].' : '.$arrayData['rss']['channel'][0]['yweather:atmosphere']['visibility'].' '.$arrayData['rss']['channel'][0]['yweather:units']['distance'];
				$buf .= '<br />';
				$buf .= $lang["weather"]["wind_speed"].' : '.mbmKPHtoMPS(array(
							'km'=>$arrayData['rss']['channel'][0]['yweather:wind']['speed'])).' м/с';
				$buf .= '<br />';
				$buf .= $lang["weather"]["geo_lat"].' '.$arrayData['rss']['channel'][0]['item'][0]['geo:lat'].'<br />';
				$buf .= $lang["weather"]["geo_long"].' '.$arrayData['rss']['channel'][0]['item'][0]['geo:long'];
				$buf .= '<hr />';
				$buf .= $lang["weather"]["sunrise"].' : '.$arrayData['rss']['channel'][0]['yweather:astronomy']['sunrise'];
				$buf .= '<br />';
				$buf .= $lang["weather"]["sunset"].' : '.$arrayData['rss']['channel'][0]['yweather:astronomy']['sunset'];
				$buf .= '<br />';
			$buf .= '</div>';
		$buf .= '</div>';
		$buf .= '<div id="weatherCol2">';
			$buf .= '<div style="
								background-image:url(http://l.yimg.com/us.yimg.com/i/us/nws/weather/gr/'.$weather_code.'n.png); 
								background-repeat:no-repeat;
								padding-left:40px;
								padding-right:30px;
								padding-top:85px;
								padding-bottom:10px;
								position:relative;">';
			
			$buf .= '<div class="weatherValueRight">'
					.'<div class="weatherTitle">'.$lang["weather"]["at_the_moment"]
					.'</div>'
					.$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['temp']
					.$weather_unit
					.'</div>';
			
			$vv =  mbmWeatherGetTodayValue($arrayData['rss']['channel'][0]['item'][0]['description']);
			$buf .= '<strong>'.$lang["main"]["today"].'</strong><br />';
			$buf .= $lang["weather"]["high"].': '.$vv[0].$weather_unit.', ';
			$buf .= $lang["weather"]["low"].': '.$vv[1].$weather_unit;
			$buf .= '</div>';
		$buf .= '</div>';
	$buf .= '</div>';
		
	mbmWeatherStat(array(
						'code'=>$var['location_code']
						)
					);
	
	return $buf;

}

function mbmYahooWeartherTomorrow(
						  $var = array(
						  	'location_code'=>'MGXX0003',
						  	'unit'=>'c'
						  )
						  ){
	global $lang;
	
	$weather_feed = file_get_contents("http://weather.yahooapis.com/forecastrss?p=".$var['location_code']."&u=".$var['unit']);
	
	//Creating Instance of the Class
	$xmlObj    = new XmlToArray($weather_feed);
	$weather_unit = '&deg;'.strtoupper($var['unit']);
	//Creating Array
	$arrayData = $xmlObj->createArray();
	
	$forecast_code = $arrayData['rss']['channel'][0]['item'][0]['yweather:forecast']['code'];
	$buf .= '<div id="weatherTomorrow">';
		$buf .= '<div id="weatherTomorrowTitle">'.$lang["main"]["tomorrow"].'</div>';
			$buf .= '<div style="
							text-align:center;
							font-weight:bold;
							">';
				$buf .= '<img src="http://l.yimg.com/us.yimg.com/i/us/we/52/'.$forecast_code.'.gif" vspace="3" /><br />';
				$buf .= $lang['weather'][$forecast_code];
			$buf .= '</div>';
		$buf .= $lang["main"]["Date"].': '.date("Y.m.d",mbmTime()+(3600*24)).'';
		$buf .= '<br />';
		$buf .= $lang["weather"]["high"].': '.$arrayData['rss']['channel'][0]['item'][0]['yweather:forecast']['high'].$weather_unit;
		$buf .= '<br />';
		$buf .= $lang["weather"]["low"].': '.$arrayData['rss']['channel'][0]['item'][0]['yweather:forecast']['low'].$weather_unit;
	$buf .= '</div>';

	return $buf;

}


function mbmWeatherLocations(
								$var = array(
									'show_hits'=>0,
									'columns'=>2,
									'html_0'=>'<ul>',
									'html_1'=>'</ul>',
									'html_2'=>'<li>',
									'html_3'=>'</li>'
								)
							){
	global $lang;
	
	$per_column = ceil(count($lang['weather']['code'])/$var['columns']);
	$i = 1;
	
	asort($lang['weather']['code']);
	
	$buf .= '<div id="weatherLocationsCol_0">';
	$buf .= $var['html_0'];
	foreach($lang['weather']['code'] as $k=>$v){
		if(($i%$per_column)==0){
			$buf .= $var['html_1'];
			$buf .= '</div>';
			$buf .= '<div id="weatherLocationsCol_'.ceil($i/$per_column).'">';
			$buf .= $var['html_0'];
		}
		$buf .= $var['html_2'];
		$buf .= '<a href="index.php?module=weather&amp;cmd=bycode&amp;code='.$k.'">'.$v.'</a>'.' ('.mbmWeatherHits(array('code'=>$k)).')';
		$buf .= $var['html_3'];
		$i++;
	}
	$buf .= $var['html_1'];
	$buf .= '</div>';
	
	return $buf;
}


function mbmWeatherGetTodayValue($txt_){
	
	$txt = explode("<BR /><b>Forecast:</b><BR />",$txt_);
	
	$txt_today = explode("<br />",$txt[1]);
	
	$txt_today_value = explode("High: ",$txt_today[0]); //$txt_today[1] bol margaashiihiig butsaana
	
	$txt_value = explode(" Low: ",$txt_today_value[1]);
	return $txt_value;
}

function mbmYahooWeartherSmall(
						  $var = array(
						  	'location_code'=>'MGXX0003',
						  	'image_size'=>'small',
						  	'unit'=>'c'
						  )
						  ){
	global $lang;
	
	$img_dir = "http://l.yimg.com/us.yimg.com/i/us/we/52/";
	$big_img_dir = "http://l.yimg.com/us.yimg.com/i/us/nws/weather/gr/"; //PNG zurag
	
	$weather_feed = file_get_contents("http://weather.yahooapis.com/forecastrss?p=".$var['location_code']."&u=".$var['unit']);
	
	//Creating Instance of the Class
	$xmlObj    = new XmlToArray($weather_feed);
	//Creating Array
	$arrayData = $xmlObj->createArray();
	
	$buf = '<div id="WeatherBox">';
		//$buf .= '<img src="';
			switch($var['image_size']){
				case 'big':
					$img_complete_url = $big_img_dir.$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['code'].'n.png';
				break;
				default:
					$img_complete_url = $img_dir.$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['code'].'.gif';
				break;
			}
		//$buf .= $img_complete_url.'" algin="left" hspace="5">';
		$buf .= '<div id="WeatherTitle">';
		$buf .= ''.$lang['weather']['code'][$var['location_code']].'</div>';
		$buf .= '<big><strong>'.$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['temp'].'&deg;'.$arrayData['rss']['channel'][0]['yweather:units']['temperature'].'</strong></big><br />';
		$buf .= $lang["weather"][$arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['code']].'<br />';
		$buf .= mbmWeatherLink($lang['main']['more']);
	$buf .= '</div>';
	mbmWeatherStat(array(
						'code'=>$var['location_code']
						)
					);
	return  $buf;
	
}
function mbmWeatherStat($var = array(
								'code'=>'MGXX0003'
								)
						){
	global $DB;
	
	
	if(isset($_GET['u'])){
		$uid = $_GET['u'];
	}elseif($_SESSION['user_id']>0){
		$uid = $_SESSION['user_id'];
	}else{
		$uid = 0;
	}
	
	$var['user_id'] = $uid;
	$code = $var['code'];
	
	if($code !=''){
		$q_check_existance = "SELECT COUNT(id) FROM ".PREFIX."stat_weather WHERE code='".$code."'";
		$r_check_existance = $DB->mbm_query($q_check_existance);
		
		if($DB->mbm_result($r_check_existance,0)==1){
			$buf = $DB->mbm_query("UPDATE ".PREFIX."stat_weather SET hits=hits+".HITS_BY." WHERE code='".$code."' ");
		}else{
			$data['code'] = $code;
			$data['hits'] = HITS_BY;
			$data['user_id'] = 0;//$var['user_id']; //odoohondoo shuud yamar user haruulj bui n hamaagui tootsoolj bna.
			$buf = $DB->mbm_insert_row($data,'stat_weather');
		}
	}
	return $buf;
}

function mbmWeatherHits($var = array(
								'code'=>'MGXX0003',
								'user_id' =>0
								)){
	global $DB;
	
	$q = "SELECT SUM(hits) FROM ".PREFIX."stat_weather WHERE code='".$var['code']."' ";
	if($var['user_id']!=0){
		$q .= "AND user_id='".$var['code']."'";
	}
	
	$r = $DB->mbm_query($q);
	
	return $DB->mbm_result($r,0);
}

function mbmWeatherLink($txt=''){
	
	$buf = '<div style="float:right; display:block;margin-top:0px;">';
		$buf .= '<small>';
			$buf .= '<a href="http://weather.az.mn" target="_blank">';
			$buf .= $txt;
			$buf .= '</a>';
		$buf .= '</small>';
	$buf .= '</div>';
	
	return $buf;
}

function mbmYahooWeartherHistory(
						  $var = array(
						  	'unit'=>'c'
						  )
						  ){
	global $lang,$DB;
	foreach($lang['weather']['code'] as $k=>$v){
		
		//$buf .= '<a href="index.php?module=weather&amp;cmd=bycode&amp;code='.$k.'">'.$v.'</a>'.' ('.mbmWeatherHits(array('code'=>$k)).')';

		$weather_feed = file_get_contents("http://weather.yahooapis.com/forecastrss?p=".$k."&u=".$var['unit']);
		
		//Creating Instance of the Class
		$xmlObj    = new XmlToArray($weather_feed);
		//Creating Array
		$arrayData = $xmlObj->createArray();
		
		$weather_unit = '&deg;'.$arrayData['rss']['channel'][0]['yweather:units']['temperature'];
		
		$data['code'] = $k;
		$data['y'] = mbmDate("Y");
		$data['m'] = mbmDate("m");
		$data['d'] = mbmDate("d");
		$data['barometer'] = $arrayData['rss']['channel'][0]['yweather:atmosphere']['pressure'].' '.$arrayData['rss']['channel'][0]['yweather:units']['pressure'];
		$data['humidity'] = $arrayData['rss']['channel'][0]['yweather:atmosphere']['humidity'].'%';
		$data['visibility'] = $arrayData['rss']['channel'][0]['yweather:atmosphere']['visibility'].' '.$arrayData['rss']['channel'][0]['yweather:units']['distance'];
		$data['wind_speed'] = mbmKPHtoMPS(array(
								'km'=>$arrayData['rss']['channel'][0]['yweather:wind']['speed'])).' м/с';
		$data['sunrise'] = $arrayData['rss']['channel'][0]['yweather:astronomy']['sunrise'];
		$data['sunset'] = $arrayData['rss']['channel'][0]['yweather:astronomy']['sunset'];
				
		$vv =  mbmWeatherGetTodayValue($arrayData['rss']['channel'][0]['item'][0]['description']);
		$data['degree_max'] = $vv[0].$weather_unit;
		$data['degree_min'] = $vv[1].$weather_unit;
		$data['condition_code'] = $arrayData['rss']['channel'][0]['item'][0]['yweather:condition']['code'];
		
		//print_r($data);
		//echo '<hr />';
		$DB->mbm_insert_row($data,"weather_history");
		print_r($data).'<hr />';
		unset($data);
	}
	//return $buf;

}
?>