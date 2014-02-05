<?
function mbmRating($code=0){
	global $DB,$lang;
	
	$q_rating = "SELECT AVG(value) FROM ".PREFIX."ratings WHERE code='".$code."'";
	$r_rating = $DB->mbm_query($q_rating);
	if($DB->mbm_result($r_rating,0)=='' || $DB->mbm_result($r_rating,0)==0){
		$aa = 0;
	}else{
		$aa = $DB->mbm_result($r_rating,0);
	}
	
	$q_total_ratings = "SELECT COUNT(*) FROM ".PREFIX."ratings WHERE code='".$code."'";
	$r_total_ratings = $DB->mbm_query($q_total_ratings);
	
	$aa = round($aa,0);
	
	$buf = '<div id="Rating" onmouseout="mbmClearRating()">
				<div class="ratingTitle">'.$lang['ratings']['ratings'].'</div>
				';
		if($_SESSION['lev'] == 0){
			$buf .= $lang['rating']['login_to_rate'];
		}elseif(mbmCheckRatedOrNot($_SESSION['user_id'],$code) == 0){
		//}elseif(mbmCheckRatedOrNot($_SESSION['user_id'],$code) != 1000){
			$buf .= '<div id="ratingValues">';
				$buf .='
					<div id="RatingValue0"></div>
					<div id="RatingValue1" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][1].'\',1)" onmouseout="mbmRatingHover(\''.$lang['rating'][1].'\',1)" onclick="mbmRateIt(1,\''.$code.'\')" ></div>
					<div id="RatingValue2" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][2].'\',2)" onmouseout="mbmRatingHover(\''.$lang['rating'][2].'\',2)" onclick="mbmRateIt(2,\''.$code.'\')" ></div>
					<div id="RatingValue3" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][3].'\',3)" onmouseout="mbmRatingHover(\''.$lang['rating'][3].'\',3)" onclick="mbmRateIt(3,\''.$code.'\')" ></div>
					<div id="RatingValue4" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][4].'\',4)" onmouseout="mbmRatingHover(\''.$lang['rating'][4].'\',4)" onclick="mbmRateIt(4,\''.$code.'\')" ></div>
					<div id="RatingValue5" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][5].'\',5)" onmouseout="mbmRatingHover(\''.$lang['rating'][5].'\',5)" onclick="mbmRateIt(5,\''.$code.'\')" ></div>';
				$buf .= '</div>';
		}else{
			$buf .= $lang['rating']['already_rated'];
		}
		$buf .= '
				<div id="RatingResult">'
				.$lang['rating']['result']
				.' <span style="font-weight:normal;">('.number_format($DB->mbm_result($r_total_ratings,0)).')</span>'
				.'<br /><img src="modules/ratings/star'.$aa.'.png" border="0" /></div>
			</div>';

	return $buf;
}
function mbmRatingResult($code=0,$type=0){
	/*
	$type:
	0 -> image
	1 -> float number
	*/
	global $DB,$lang;
	
	$q_rating = "SELECT AVG(value) FROM ".PREFIX."ratings WHERE code='".$code."'";
	$r_rating = $DB->mbm_query($q_rating);
	if($DB->mbm_result($r_rating,0)=='' || $DB->mbm_result($r_rating,0)==0){
		$aa = 0;
	}else{
		$aa = $DB->mbm_result($r_rating,0);
	}
	
	if($aa>0 && $aa<=1){
		$aa=0.5;
	}elseif($aa>1 && $aa<2){
		$aa=1.5;
	}elseif($aa>2 && $aa<3){
		$aa=2.5;
	}elseif($aa>3 && $aa<4){
		$aa=3.5;
	}elseif($aa>4 && $aa<5){
		$aa=4.5;
	}
	$q_total_ratings = "SELECT COUNT(*) FROM ".PREFIX."ratings WHERE code='".$code."'";
	$r_total_ratings = $DB->mbm_query($q_total_ratings);
	
	$aa = round($aa,2);
	
	switch($type){
		case 0:
			$buf = '<img src="modules/ratings/star'.$aa.'.png" alt="'.$aa.'" border="0" vspace="5" />';
		break;
		case 1:
			$buf = $aa;
		break;
		default:
			$buf = '<img src="modules/ratings/star'.$aa.'.png" alt="'.$aa.'" border="0" vspace="5" />';
		break;
	}

	return $buf;

}
function mbmRatingSmall(){
	global $DB,$lang;
	
		$buf = '<div id="Rating" onmouseout="mbmClearRating()">
				<div class="ratingTitle">'.$lang['ratings']['ratings'].'</div>
				<div id="ratingValues">
					<div id="RatingValue0"></div>
					<div id="RatingValue1" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][1].'\',1)" onmouseout="mbmRatingHover(\''.$lang['rating'][1].'\',1)" onclick="mbmRateIt(1,\''.$code.'\')" ></div>
					<div id="RatingValue2" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][2].'\',2)" onmouseout="mbmRatingHover(\''.$lang['rating'][2].'\',2)" onclick="mbmRateIt(2,\''.$code.'\')" ></div>
					<div id="RatingValue3" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][3].'\',3)" onmouseout="mbmRatingHover(\''.$lang['rating'][3].'\',3)" onclick="mbmRateIt(3,\''.$code.'\')" ></div>
					<div id="RatingValue4" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][4].'\',4)" onmouseout="mbmRatingHover(\''.$lang['rating'][4].'\',4)" onclick="mbmRateIt(4,\''.$code.'\')" ></div>
					<div id="RatingValue5" class="rating" onmouseover="mbmRatingHover(\''.$lang['rating'][5].'\',5)" onmouseout="mbmRatingHover(\''.$lang['rating'][5].'\',5)" onclick="mbmRateIt(5,\''.$code.'\')" ></div>
				</div>
				<div id="RatingResult" ><br />'
				.$lang['rating']['result']
				.' <span style="font-weight:normal;">('.number_format($DB->mbm_result($r_total_ratings,0)).')</span>'
				.'<br /><img src="modules/ratings/star'.$aa.'.png" border="0" /></div>
			</div>';
}
function mbmCheckRatedOrNot($user_id=0,$code){
	global $DB,$DB2;
	
	if($DB2->mbm_check_field('id',$user_id,'users') == 0){
		return 1;
	}
	
	$q = "SELECT COUNT(*) FROM ".$DB->prefix."ratings WHERE user_id='".$user_id."' AND code='".$code."' AND date_added>'".(mbmTime()-24*3600)."'";
	$r = $DB->mbm_query($q);
	if($DB->mbm_result($r,0)>0){
		return 1;
	}else{
		return 0;
	}
}
?>
