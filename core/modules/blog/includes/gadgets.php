<?
function mbmBlogUserProfile($b_id, $htmls){	
	global $DB, $lang_blog;
	
	$q_user = "SELECT * FROM ".USER_DB_PREFIX."users WHERE id=".$DB->mbm_get_field($b_id, "id", "user_id", "blog");
	$r_user = $DB->mbm_query($q_user);
	for($i=0;$i<$DB->mbm_num_rows($r_user);$i++){
	$buf = '';
	$buf .= $htmls[0];
	$buf .= $htmls[4];
	$buf .= $htmls[5];
	$bd = $DB->mbm_result($r_user, $i, "birthday");
	$age = mbmDate()-($bd[0]*1000 + $bd[1]*100 + $bd[2]*10 + $bd[3]);
	$buf .= '
	<tr><td width="100"><img src="modules/users/avatar_show.php?id='.$DB->mbm_get_field($DB->mbm_get_field($b_id, "id", "user_id", "blog"),"user_id","id","user_avatars").'" /></td><td width="140" valign="top">
	'.$DB->mbm_result($r_user, $i, "username").'<br />
	'.$DB->mbm_result($r_user, $i, "country").', '.$DB->mbm_result($r_user, $i, "city").'<br />
	'.$age.' / '.$lang_blog['blog'][$DB->mbm_result($r_user, $i, "gender")].'
	</td></tr>';
	$buf .= $htmls[1];
	}
	return $buf;
}

function mbmBlogContentArchive($b_id, $htmls){
	global $DB, $lang_blog;

	$qry = "SELECT * FROM ".PREFIX."blog_contents WHERE blog_id=".$b_id;
	$res = $DB->mbm_query($qry);
	$n= 0;

	for($i=0;$i<$DB->mbm_num_rows($res);$i++){
		$n++;
		$ar1[$n]= date("Y-m", $DB->mbm_result($res, $i, "date_added"));
	}
	
	$m= 0;
	for($i=1; $i<=$n; $i++){
		$k= 1;
		for($j=1; $j<=$m; $j++){
			if(($ar1[$i] == $ar2[$j]['date']) && $k){
				$k= 0;
				$p= $j;
			}
		}
		if($k){
			$m++;
			$ar2[$m]['counter']= 1;
			$ar2[$m]['date']= $ar1[$i];
		}else{
			$ar2[$p]['counter']++;
		}
	}
	
	$buf = '';
	$buf .= $htmls[0];
	$buf .= $htmls[4];
	$buf .= $htmls[5];
	
	for($i=1; $i<=$m; $i++){	
		$buf .= $htmls[2];
		$buf .= '<a class="blog_cat_link" href="blog.php?module=blog&cmd=content&blog_id='.$b_id.'&archive='.$ar2[$i]['date'].'">'.substr($ar2[$i]['date'], 0, 4).' он. '.(int)substr($ar2[$i]['date'], 5, 2).'-р сар. ('.$ar2[$i]['counter'].' бичлэг)</a> ';
		$buf .= $htmls[3];
	}
	$buf .= $htmls[1];	
	return $buf;
}

function mbmBlogCalendar($b_id, $htmls){
	global $lang_blog;
	
	$buf = '';
	$buf .= $htmls[0];
	$buf .= $htmls[4];
	$buf .= $htmls[5];
	$buf .= '
	<tr>
	<td colspan="2" height="22">
	</td>
	</tr>';
	$buf .= '
	<tr>
	<td colspan="2" height="22"">
	</td>';
	$buf .= $htmls[1];

	return $buf;
}

function mbmBlogFriends($b_id, $htmls){
	global $DB, $lang_blog;
	
	$qry = "SELECT friends FROM ".USER_DB_PREFIX."users WHERE id=".$DB->mbm_get_field($b_id, "id", "user_id", "blog");
	$res = $DB->mbm_query($qry);
	$frnds = explode(",", $DB->mbm_result($res, 0, "friends"));
	
	$buf = '';
	$buf .= $htmls[0];
	$buf .= $htmls[4];
	$buf .= $htmls[5];
	for($i=1; $i<count($frnds)-1; $i++){
		if($DB->mbm_get_field($frnds[$i],"username","enable_blog","users") == 1){
			$buf .= $htmls[2];
			$buf .= '<a class="blog_cat_link" href="blog.php?blog_id='.$DB->mbm_get_field($frnds[$i],"username","id","users").'" target="_blank">'.$frnds[$i].'</a>';
			$buf .= $htmls[3];	
		}
	}
	
	$buf .= $htmls[1];
	
	return $buf;
}

function mbmBlogBanners($b_id, $htmls, $bnnr){
	global $lang_blog;
	
	$buf = '';
	$buf .= $htmls[0];
	$buf .= $htmls[4];
	$buf .= $htmls[5];
	$buf .= mbmShowBanner($bnnr);
	$buf .= $htmls[1];

	return $buf;

}
?>