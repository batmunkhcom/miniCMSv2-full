<?
switch($_GET['type']){
	case 'rate':
		$data['code'] = $_GET['code'];
		$data['user_id'] = $_SESSION['user_id'];
		$data['value'] = $_GET['value'];
		$data['date_added'] = mbmTime();
		$data['ip'] = getenv("REMOTE_ADDR");
		$r = $DB->mbm_insert_row($data,'ratings');
		
		mbmUpdateUserScore($_SESSION['user_id'],1);
		
		if($r==1){
			$txt .= "\n\t<rating name='Result:' value='ok' st='1' />";
		}else{
			$txt .= "\n\t<rating name='Result:' value='no' st='0' />";
		}
		$q_rating = "SELECT AVG(value) FROM ".PREFIX."ratings WHERE code='".$data['code']."'";
		$r_rating = $DB->mbm_query($q_rating);
		$txt .= "\n\t<rating name='".ceil($DB->mbm_result($r_rating,0))."' value='".ceil($DB->mbm_result($r_rating,0))."' st='0' />";
	break;
	default:
		$q_rating = "SELECT AVG(value) FROM ".PREFIX."ratings WHERE code='".$_GET['code']."'";
		$r_rating = $DB->mbm_query($q_rating);
		$txt .= "\n\t<rating name='".ceil($DB->mbm_result($r_rating,0))."' value='".ceil($DB->mbm_result($r_rating,0))."' st='0' />";
	break;
}
?>