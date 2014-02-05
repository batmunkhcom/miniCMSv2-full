<?
function mbmIp2Long($ip) {
	$ex = explode(".", $ip);
	if (count($ex)!=4) return -1;
	list($a, $b, $c, $d) = $ex;
	$a = $a*16777216;
	$b = $b*65536;
	$c = $c*256;
	return $a+$b+$c+$d;
}
function mbmCountryList($type='dropdown',$selected=0){
	global $DB2;
	
	$q_countries = "SELECT * FROM ".USER_DB_PREFIX."ip2country WHERE name!='' GROUP BY name ORDER BY name";
	$r_countries = $DB2->mbm_query($q_countries);
	
	$buf = '';
	
	for($i=0;$i<$DB2->mbm_num_rows($r_countries);$i++){
		switch($type){
			case 'dropdown':
				$buf .= '<option value="'.$DB2->mbm_result($r_countries,$i,"name").'" ';
				if($selected != 0 && $DB2->mbm_result($r_countries,$i,"name") == $selected){
					$buf .= 'selected ';
				}elseif(mbmCountry()==$DB2->mbm_result($r_countries,$i,"name")){
					$buf .= 'selected ';
					$yes = 1;
				}
				$buf .= '>';
				$buf .= $DB2->mbm_result($r_countries,$i,"name").'</option>';
			break;
		}
	}
	return $buf;
}
function mbmCountry($ip = 0){
	global $DB2;
	
	if($ip==0){
		$ip = getenv("REMOTE_ADDR");
	}
	$longip = mbmIp2Long($ip);
	$q_country = "SELECT name FROM ".USER_DB_PREFIX."ip2country WHERE ip1<=inet_aton('".$ip."') AND ip2>=inet_aton('".$ip."') LIMIT 1";
	$r_country = $DB2->mbm_query($q_country);
	if($DB2->mbm_num_rows($r_country)==0){
		$country = 'UNKNOWN';
	}else{
		$country = $DB2->mbm_result($r_country,0);
	}
	if(strlen($country)>21){
		//return substr($country,0,21).'...';
	}else{
	}
	return $country;
}
?>