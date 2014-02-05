<?
function mbmSearchForm(){
	global $lang;
	$buf = '';
	$buf .= '<form name="searchForm" id="searchForm" method="post" action="'.DOMAIN.DIR.'modules/search/redirect.php" style="margin:0px;">
			  <input name="q" type="text" id="q" class="search_input" />
			  <input type="submit" name="Submit" value="'.$lang["search"]["button_search"].'" class="search_button">
			</form>';
	return $buf;
}


function mbmShowSearchResult($query=0){
	return mbmSearchContentResult($query);
}
function mbmSearchContentResult($keyword=''){
	global $DB,$lang;
	
	$kword = explode(" ",addslashes($keyword));
	
	$q_search = "SELECT * FROM ".PREFIX."menu_contents 
					WHERE st=1 AND lev<='".$_SESSION['lev']."' AND ";
	$q_search .= "( ";			
		if(is_array($kword)){
			foreach($kword as $k=>$v){
				$q_search .= "`title` LIKE '%".$v."%' OR 
								`content_short` LIKE '%".$v."%' OR 
								`content_more` LIKE '%".$v."%' OR 
								`tag` LIKE '%".$v."%' OR ";
			}
		}else{
			$q_search .= "`title` LIKE '%".$v."%' OR 
							`content_short` LIKE '%".$v."%' OR 
							`content_more` LIKE '%".$v."%' OR 
							`tag` LIKE '%".$v."%' OR ";
		}
		$q_search = rtrim($q_search,"OR ");
	$q_search .= ") ";			
	$q_search .= "ORDER BY date_added DESC";
	
	$r = $DB->mbm_query($q_search);
	
	
	$buf = '';
	$buf .= '<h2>'.$lang["search"]["Search"].' [ '.$lang["search"]["result_found"].': '.$DB->mbm_num_rows($r).']</h2>';
	
	
	if((START+PER_PAGE_CONTENTS) > $DB->mbm_num_rows($r)){
		$end= $DB->mbm_num_rows($r);
	}else{
		$end= START+PER_PAGE_CONTENTS; 
	}
	
	for($i=START;$i<$end;$i++){
		
		$s_menu_id__ = explode(",",$DB->mbm_result($r,$i,"menu_id"));
		$s_menu_id = $s_menu_id__[1];
		
		$buf .= '<div id="contentShort">';
			$buf .= '<div id="contentTitle" onclick="window.location=\'index.php?module=menu&amp;cmd=content&id='
				.$DB->mbm_result($r,$i,"id").'&menu_id='
				.$s_menu_id.'\'">'.mbmCleanUpHTML($DB->mbm_result($r,$i,"title")).'</div>';
			$buf .= '<div  id="mbmTimeConverter">'
				.mbmTimeConverter($DB->mbm_result($r,$i,"date_added"))
				.'</div>';

		if(strlen(mbmCleanUpHTML($content_short))>10){
			$content_short_p = $DB->mbm_result($r,$i,"content_short");
		}else{
			$content_short_p = $DB->mbm_result($r,$i,"content_more");
		}
		$content_short_p = mbmCleanUpHTML($content_short_p);
		
		$content_short_tmp = explode(" ",$content_short_p);
		
		$content_short = '';
		
		if(count($content_short_tmp)>25){
			$total_words = 24;
		}else{
			$total_words = (count($content_short_tmp)-1);
		}
		for($t_words=0;$t_words<$total_words;$t_words++){
			$content_short .= ' '.$content_short_tmp[$t_words];
		}
		$content_short .= '...';
		
		if( $DB->mbm_result($r,$i,"lev")>$_SESSION['lev']){
			$buf .= '<div id="query_result">'.$lang['error']['low_level_content'].'</div>';
		}elseif($DB->mbm_result($r,$i,"is_video")){
			$q_video_content = "SELECT * FROM ".PREFIX."menu_videos WHERE content_id='"
								.$DB->mbm_result($r,$i,"id")."' ORDER BY RAND() LIMIT 1";
			$r_video_content = $DB->mbm_query($q_video_content);
			$buf .= '<a href="index.php?module=menu&amp;cmd=content&id='
				.$DB->mbm_result($r,$i,"id").'&menu_id='
				.$s_menu_id.'">';
			$buf .= '<img hspace="5" border="0" src="img.php?type='
				.$DB->mbm_result($r_video_content,0,"image_filetype")
				.'&amp;f='
				.base64_encode($DB->mbm_result($r_video_content,0,"image_url"))
				.'&w=100'
				.'" align="left" class="thumb_img" />'
				.'</a>'
				.$content_short;
		}elseif($DB->mbm_result($r,$i,"is_photo")){
			$q_photo_content = "SELECT * FROM ".PREFIX."menu_photos WHERE content_id='"
								.$DB->mbm_result($r,$i,"id")."' ORDER BY RAND() LIMIT 1";
			$r_photo_content = $DB->mbm_query($q_photo_content);
			if($DB->mbm_num_rows($r_photo_content)==1){
				$buf .= '<a href="index.php?module=menu&amp;cmd=content&id='
					.$DB->mbm_result($r,$i,"id").'&menu_id='
					.$s_menu_id.'">';
				$buf .= '<img hspace="5" border="0" src="img.php?type='
					.$DB->mbm_result($r_photo_content,0,'filetype')
					.'&amp;f='
					.base64_encode($DB->mbm_result($r_photo_content,0,'url'))
					.'&w=100'
					.'" align="left" class="thumb_img" />';
				$buf .= '</a>';
			}
			$buf .= $content_short;
		}else{
			$buf .= $content_short;
		}
		/*
		$buf .= '<br >'.$lang['main']['url'].': index.php?module=menu&amp;cmd=content&id='
				.$DB->mbm_result($r,$i,"id").'&menu_id='
				.$s_menu_id
				.'<br clear="both" />';
		*/
		if( $DB->mbm_result($r,$i,"lev")>$_SESSION['lev']){
			$buf .= '<div id="query_result">'.$lang['error']['low_level_content'].'</div>';
		}else{
			$buf .= '<a href="index.php?module=menu&amp;cmd=content&id='
				.$DB->mbm_result($r,$i,"id").'&menu_id='
				.$s_menu_id.'" class="contentMoreLink">';
				if($DB->mbm_result($r,$i,"is_video")==1 || $DB->mbm_result($r,$i,"is_photo")==1){
					$buf .= $lang["main"]["more_watch_it"];
				}else{
					$buf .= $lang["main"]["more"];
				}
			$buf .= '</a>';
		}
		
		
		$buf .= '</div>';
		
	}
	$buf .= mbmNextPrev('index.php?module=search&cmd=search&menu_id='.MENU_ID.'&q='.$_GET['q'],$DB->mbm_num_rows($r),START,PER_PAGE_CONTENTS);

	if($DB->mbm_num_rows($r)==0){
		return $lang['search']['no_result'];
	}else{
		return $buf;
	}
}
?>