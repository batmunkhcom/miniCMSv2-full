<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}else{
	echo '<h2>'.$lang['web']['web_directory'].'</h2>';
	$cat_id = $_GET['cat_id'];
	if($DB->mbm_check_field('id',$cat_id,'web_cats')==1){
		$cat_sub = (int)($DB->mbm_get_field($cat_id,'id','sub','web_cats'));
		switch($cat_sub){
			case 0:
				echo '<a href="index.php?module=web&cmd=web_links">up one level</a>';
				echo mbmWebSubCatsList($cat_id,2);
			break;
			case 1:
				echo '<div id="contentTitle">'.$DB->mbm_get_field($cat_id,'id','name','web_cats').'</div>';
				$q_weblinks = "SELECT * FROM ".PREFIX."web_links WHERE cat_id='".$cat_id."' AND st=1 ORDER BY date_added";
				$r_weblinks = $DB->mbm_query($q_weblinks);
				$content_bg_color = array(0=>'#FFFFFF',1=>'#F5F5F5');
				if((START+PER_PAGE) > $DB->mbm_num_rows($r_weblinks)){
					$end= $DB->mbm_num_rows($r_weblinks);
				}else{
					$end= START+PER_PAGE; 
				}
				for($i=START;$i<$end;$i++){
				//for($i=0;$i<$DB->mbm_num_rows($r_weblinks);$i++){
					echo '<div style="
									padding:5px;
									background-color:'.$content_bg_color[$i%2].';
									">';
					echo '<div id="contentListTitle">'.$DB->mbm_result($r_weblinks,$i,"name").'</div>';
					echo $DB->mbm_result($r_weblinks,$i,"comment").'';
					echo '<div style="
									margin-top:6px;
									margin-bottom:6px;
									text-align:center;
									padding-top:3px;
									padding-bottom:3px;
									background-color:#e2e2e2;
									border:1px solid #DDDDDD;">';
					echo $lang['web']['clicked'].': <strong>'.number_format($DB->mbm_result($r_weblinks,$i,"hits")).'</strong>'
						 .' | '.$lang['web']['hits'].': <strong>'.number_format($DB->mbm_result($r_weblinks,$i,"views")).'</strong>'
						 .' | '.$lang['web']['date_added'].': <strong>'.date("Y/m/d",$DB->mbm_result($r_weblinks,$i,"date_added")).'</strong>'
						 .' | <a href="index.php?action=web&url='.(base64_encode($DB->mbm_result($r_weblinks,$i,"url"))).''
						 .'&id='.$DB->mbm_result($r_weblinks,$i,"id").'" target="_blank" >'.$lang['web']['visit_link'].'</a>'
						 .' | ';//<a href="#">'.$lang['web']['report_invalid_link'].'</a>';
					echo '</div>';
					echo '</div>';
					$viewed_ids[] = $DB->mbm_result($r_weblinks,$i,"id");
				}
				if(is_array($viewed_ids)){
					$q_update_viewed = "UPDATE ".PREFIX."web_links SET views=views+1 WHERE ";
					foreach($viewed_ids as $k=>$v){
						$q_update_viewed .= "id='".$v."' OR ";
					}
					$r_update_viewed = $DB->mbm_query(rtrim($q_update_viewed," OR "));
				}
				echo  mbmNextPrev('index.php?module=web&cmd=web_links&cat_id='.$cat_id,$DB->mbm_num_rows($r_weblinks),START,PER_PAGE);
				echo '<a href="index.php?module=web&cmd=web_links">'.$lang['web']['up_one_level'].'</a>';
				echo mbmWebSubCatsList($DB->mbm_get_field($cat_id,'id','cat_id','web_cats'),2);
			break;
		}
	}else{
		echo mbmWebCatsList();
	}
}
?>