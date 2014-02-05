<?	
function mbmShowContents(
						 $htmls=array('','','',''),
						 $menu_id=0,
						 $var = array(
								   'show_briefInfo'=>0,
								   'username'=>0,
								   )
						 ){
	global $DB;
	
	$buf = '';
	$r = mbmShowContentShort($menu_id,$var);
	
	if(isset($_GET['id']) && $_GET['cmd']=='content'){
		$buf .= mbmShowContentMore($htmls, $_GET['id']);
		//$buf .= '<hr style="clear:both;" /><h2>Ð¨Ð¸Ð½Ñ? Ð¼Ñ?Ð´Ñ?Ñ?Ð»Ð»Ò¯Ò¯Ð´</h2>';
		//$buf .= mbmShowNewContents($htmls,PER_PAGE_CONTENTS,"normal",$menu_id);
	}else{
		$buf .= $r;
	}

	return $buf;
}
function mbmShowContentShort($menu_id,$var = array(
												   'show_briefInfo'=>0,
												   'username'=>0,
												   )){
	global $DB,$lang;
	$q = "SELECT * FROM ".PREFIX."menu_contents WHERE date_added<'".mbmTime()."' ";

	if(isset($_GET['f']) && $_GET['f']==1){
		
	}else{
		$q .= "AND st=1 ";
	}
	if(is_array($menu_id)){
		//menu_id -g array bolgoj oruulval array-d bui menunuudiin medeelliig haruulna
		$q .= "AND ( ";
		foreach($menu_id as $k=>$v){
			$q .= "menu_id LIKE '%,".$k.",%' OR ";
		}
		$q = rtrim($q,"OR ");
		$q .= ") ";
	}elseif($menu_id!=0){
		$q .= "AND menu_id LIKE '%,".$menu_id.",%' ";
	}
	$query_string = '&amp;';
	
	//$q .= "AND is_video=0 AND is_photo=0 ";
	$q .= "ORDER BY ";
	if(isset($_GET['ob'])){
		$q .= $_GET['ob']." ";
		$query_string .= '&amp;ob='.$_GET['ob'];
	}else{
		$q .= "date_added ";
	}
	
	if(isset($_GET['asc'])){
		$q .= $_GET['asc']." ";
		$query_string .= '&amp;asc='.$_GET['asc'];
	}else{
		$q .= "DESC ";
	}
	
	
	$r = $DB->mbm_query($q);
	
	$buf = '';
	if((START+PER_PAGE_CONTENTS) > $DB->mbm_num_rows($r)){
		$end= $DB->mbm_num_rows($r);
	}else{
		$end= START+PER_PAGE_CONTENTS; 
	}
	for($i=START;$i<$end;$i++){
		
		$buf .= '<div id="contentShort">';
		if($DB->mbm_result($r,$i,"show_title")==1){
			$buf .= '<div class="contentTitle" onclick="window.location=\''.DOMAIN.DIR.'index.php?module=menu&amp;cmd=content&amp;id='
				.$DB->mbm_result($r,$i,"id").'&amp;menu_id='
				.mbmReturnMenuId($DB->mbm_result($r,$i,"menu_id")).'\'">'
				.mbmCleanUpHTML($DB->mbm_result($r,$i,"title")).'</div>';
			$buf .= '<div  class="mbmTimeConverter">'
				.mbmTimeConverter($DB->mbm_result($r,$i,"date_added"))
				.'</div>';
		}
		if($var['show_briefInfo']==1){
			$buf .= mbmContentBriefInfo(array(
										  'content_id'=>$DB->mbm_result($r,$i,"id"),
										  'user_id'=>$DB->mbm_result($r,$i,"user_id"),
										  'menu_id'=>$DB->mbm_result($r,$i,"menu_id"),
										  'hits'=>$DB->mbm_result($r,$i,"hits"),
										  'rating'=>$DB->mbm_result($r,$i,"id")
										  ));
		}
		if($DB->mbm_result($r,$i,"cleanup_html")==1){
			$content_short = mbmCleanUpHTML($DB->mbm_result($r,$i,"content_short"));
		}else{
			$content_short = $DB->mbm_result($r,$i,"content_short");
		}
		
		if($DB->mbm_result($r,$i,"is_video") == 1){
			$q_video_content = "SELECT * FROM ".PREFIX."menu_videos WHERE content_id='"
								.$DB->mbm_result($r,$i,"id")."' ORDER BY RAND() LIMIT 1";
			$r_video_content = $DB->mbm_query($q_video_content);
			$buf .= '<a href="index.php?module=menu&amp;cmd=content&amp;id='
				.$DB->mbm_result($r,$i,"id").'&amp;menu_id='
				.mbmReturnMenuId($DB->mbm_result($r,$i,"menu_id")).'">';
			$buf .= '<img hspace="5" border="0" src="'.DOMAIN.DIR.'img.php?type='
				.$DB->mbm_result($r_video_content,0,"image_filetype")
				.'&amp;f='
				.base64_encode($DB->mbm_result($r_video_content,0,"image_url"))
				.'&amp;w=100'
				.'" align="left" class="thumb_img" />'
				.'</a>'
				.$content_short;
		}elseif($DB->mbm_result($r,$i,"is_video") == 2){ //youtube content
			$q_video_content = "SELECT * FROM ".PREFIX."menu_youtube WHERE content_id='"
								.$DB->mbm_result($r,$i,"id")."' ORDER BY RAND() LIMIT 1";
			$r_video_content = $DB->mbm_query($q_video_content);
			$buf .= '<a href="index.php?module=menu&amp;cmd=content&amp;id='
				.$DB->mbm_result($r,$i,"id").'&amp;menu_id='
				.mbmReturnMenuId($DB->mbm_result($r,$i,"menu_id")).'">';
			$buf .= '<img hspace="5" border="0" src="'.DOMAIN.DIR.'img.php?type='
				.$DB->mbm_result($r_video_content,0,"image_filetype")
				.'&amp;f='
				.base64_encode($DB->mbm_result($r_video_content,0,"image_url"))
				.'&amp;w=100'
				.'" align="left" class="thumb_img" />'
				.'</a>'
				.$content_short;
		}elseif($DB->mbm_result($r,$i,"is_photo") ==1 ){
			$q_photo_content = "SELECT * FROM ".PREFIX."menu_photos WHERE content_id='"
								.$DB->mbm_result($r,$i,"id")."' ORDER BY RAND() LIMIT 1";
			$r_photo_content = $DB->mbm_query($q_photo_content);
			if($DB->mbm_num_rows($r_photo_content)==1){
				$buf .= '<a href="'.DOMAIN.DIR.'index.php?module=menu&amp;cmd=content&amp;id='
					.$DB->mbm_result($r,$i,"id").'&amp;menu_id='
					.mbmReturnMenuId($DB->mbm_result($r,$i,"menu_id")).'">';
				$buf .= '<img hspace="5" border="0" src="'.DOMAIN.DIR.'img.php?type='
					.$DB->mbm_result($r_photo_content,0,'filetype')
					.'&amp;f='
					.base64_encode($DB->mbm_result($r_photo_content,0,'url'))
					.'&amp;w=100'
					.'" align="left" class="thumb_img" />';
				$buf .= '</a>';
			}
			$buf .= $content_short;
		}else{
			$buf .= $content_short;
		}
		if($DB->mbm_result($r,$i,"is_video")==1 || $DB->mbm_result($r,$i,"is_photo")==1 || strlen($content_short)>10){
			$buf .= '<a href="'.DOMAIN.DIR.'index.php?module=menu&amp;cmd=content&amp;id='
				.$DB->mbm_result($r,$i,"id").'&amp;menu_id='
				.mbmReturnMenuId($DB->mbm_result($r,$i,"menu_id")).'" class="contentMoreLink">';
				if($DB->mbm_result($r,$i,"is_video")==1 || $DB->mbm_result($r,$i,"is_photo")==1){
					$buf .= $lang["main"]["more_watch_it"];
				}else{
					$buf .= $lang["main"]["more"];
				}
			$buf .= '</a>';
		}else{
			$buf .= $DB->mbm_result($r,$i,"content_more");
			$DB->mbm_query("UPDATE ".PREFIX."menu_contents SET hits=hits+".HITS_BY." WHERE id='".$DB->mbm_result($r,$i,"id")."'");
		}
		$buf .= '</div>';
		
	}
	$buf .= mbmNextPrev(''.DOMAIN.DIR.'index.php?module=menu&amp;cmd=content&amp;menu_id='.MENU_ID.$query_string,$DB->mbm_num_rows($r),START,PER_PAGE_CONTENTS);

	/*
	$htmls_video[0] = '<table width="100%" cellpadding="3" cellspacing="2" border="0" style="clear:both;"><tr>';
	$htmls_video[2] = '<td align="center" width="25%" valign="top">';
	$htmls_video[3] = '</td>';
	$htmls_video[1] = '</tr></table>';
    $buf .= mbmShowNewContents($htmls_video,4,"is_video",0);
    $buf .= mbmShowNewContents($htmls_video,4,"is_photo",0);
	*/

	if($DB->mbm_num_rows($r)==0){
		return $lang['menu']['no_content'];
	}else{
		return $buf;
	}
}
function mbmShowContentMore($htmls=array('','','',''), $id){
	global $DB,$DB2,$lang;

	$q_cnt = "SELECT * FROM ".PREFIX."menu_contents WHERE id='".$id."' ";
	if(isset($_GET['f']) && $_GET['f']==1){
	
	}else{
		$q_cnt .= "AND st='1' ";
	}
	$r_cnt = $DB->mbm_query($q_cnt); 
	if($DB->mbm_num_rows($r_cnt)==1){
		$buf = $htmls[2]; 
		if($DB->mbm_result($r_cnt,0,"show_title")==1){
			$buf .= '<div class="contentTitle">'.$DB->mbm_result($r_cnt,0,"title").'</div>';
		}
		$content_short = $DB->mbm_result($r_cnt,0,"content_short");
		$content_more = $DB->mbm_result($r_cnt,0,"content_more");
		
		if($DB->mbm_result($r_cnt,0,"lev")<=$_SESSION['lev']){
			if($DB->mbm_result($r_cnt,0,"show_content_short")==1){
				if($DB->mbm_result($r_cnt,0,"cleanup_html")==1){
					$buf .= mbmCleanUpHTML($content_short);
				}else{
					$buf .= $content_short;
				}
			}
			$buf .= '<div id="contentMore">';
			if($DB->mbm_result($r_cnt,0,"is_video")==1){
				$buf .= mbmShowContentVideos($DB->mbm_result($r_cnt,0,"id"));
			}elseif($DB->mbm_result($r_cnt,0,"is_video")==2){
				$buf .= mbmShowContentYoutube($DB->mbm_result($r_cnt,0,"id"));
			}elseif($DB->mbm_result($r_cnt,0,"is_photo")==1){
				$buf .= mbmShowContentPhotos($DB->mbm_result($r_cnt,0,"id"));
			}else{
				$buf .=$content_more;
			}
			$buf .= '</div>';
			if($DB->mbm_result($r_cnt,0,"is_video")==1){
				$content_type = 'video';
			}elseif($DB->mbm_result($r_cnt,0,"is_photo")==1){
				$content_type = 'photo';
			}else{
				$content_type = 'normal';
			}
			$buf .= mbmContentInformation(array(
													'id'=>$id,
													'title'=>$DB->mbm_result($r_cnt,0,"title"),
													'user_id'=>$DB->mbm_result($r_cnt,0,"user_id"),
													'hits'=>$DB->mbm_result($r_cnt,0,"hits"),
													'date_added'=>$DB->mbm_result($r_cnt,0,"date_added"),
													'session_time'=>$DB->mbm_result($r_cnt,0,"session_time"),
													'content_type'=>$content_type
												)
										  );
			if($DB->mbm_result($r_cnt,0,"use_comment")==1){
				$buf .= mbmShowContentCommentForm($id);
			}
		}else{
			$buf .= '<div id="query_result">'.$lang['error']['low_level_content'].'</div>';
		}
		$buf .= $htmls[3]; 
	
		$DB->mbm_query("UPDATE ".PREFIX."menu_contents SET hits=hits+".HITS_BY.",session_time='".mbmTime()."' WHERE id='".$id."'");
		
	}else{
			$buf = mbmError($lang["menu"]["no_such_content_exists"]); 
	}
	return $buf;
}
function mbmShowNewContents($htmls=array(0=>'',1=>'',2=>'',3=>''),$limit=10,$type="normal",$menu_id=0,$order_by='id',$asc='desc'){
	global $DB,$DB2,$lang;
	
	$q_contents = "SELECT * FROM ".PREFIX."menu_contents WHERE date_added<".mbmTime()." AND ";
	if($menu_id!=0){
		$q_contents .= "menu_id LIKE '%,".$menu_id.",%' AND ";
	}
	switch($type){
		case 'is_photo':
			$q_contents .= "is_photo=1 ";
		break;
		case 'is_video':
			$q_contents .= "is_video>0 ";
		break;
		case 'normal':
			$q_contents .= "is_video=0 AND is_photo=0 ";
		break;
	}
	$q_contents .= "AND st=1 ";
	//$q_contents .= "AND st=1 AND lev<='".$_SESSION['lev']."' ";
	$q_contents .= "ORDER BY ".$order_by." ".$asc." LIMIT ".$limit;
	
	$r_contents = $DB->mbm_query($q_contents);
	$buf = $htmls[0];
	for($i=0;$i<$DB->mbm_num_rows($r_contents);$i++){
		$buf .= $htmls[2];
		$content_menu_id = explode(',',$DB->mbm_result($r_contents,$i,"menu_id"));
		
		
		$c_title = $DB->mbm_result($r_contents,$i,"title");
		if(defined("CONTENT_TITLE_LENGTH")){
			if(mbm_strlen($c_title)>CONTENT_TITLE_LENGTH){
				$c_title = mbm_substr($c_title,CONTENT_TITLE_LENGTH).'...';
			}
		}
		
		$content_title = '<div id="contentListTitle" onclick="window.location=\'index.php?module=menu&amp;cmd=content&amp;menu_id='
						.$content_menu_id[1].'&amp;id='.$DB->mbm_result($r_contents,$i,"id").'\'" '
						.' title="'.addslashes($DB->mbm_result($r_contents,$i,"title")).'"'
						.'>'.$c_title.'</div>';
		$c_title = '';
		switch($type){
			case 'is_video':
				$buf .= '<a href="index.php?module=menu&amp;cmd=content&amp;menu_id='
					.$content_menu_id[1].'&amp;id='.$DB->mbm_result($r_contents,$i,"id").'">';
				$buf .= mbmMediaContentThumbImage(
									array(
											'content_id'=>$DB->mbm_result($r_contents,$i,"id"),
											'type'=>'video',
											'is_video'=>$DB->mbm_result($r_contents,$i,"is_video")
											)
								  );
				$buf .= '</a>';
				$buf .= $content_title;
				$no_more_link = 1;
			break;
			case 'is_photo':
				$buf .= '<a href="index.php?module=menu&amp;cmd=content&amp;menu_id='
					.$content_menu_id[1].'&amp;id='.$DB->mbm_result($r_contents,$i,"id").'">';
				$buf .= mbmMediaContentThumbImage(
									array(
										'content_id'=>$DB->mbm_result($r_contents,$i,"id"),
										'type'=>'photo'
										)
								  );
				$buf .= '</a>';
				$buf .= $content_title;
				$no_more_link = 1;
			break;
			case 'normal':
				$buf .= $content_title;
				if($DB->mbm_result($r_contents,$i,"cleanup_html")==1){
					$content_short = mbmCleanUpHTML($DB->mbm_result($r_contents,$i,"content_short"));
				}else{
					$content_short = $DB->mbm_result($r_contents,$i,"content_short");
				}
				$buf .= '<div id="contentShort">'.$content_short.'</div>';
			break;
		}
		if($no_more_link!=1){
			$buf .= '<a href="index.php?module=menu&amp;cmd=content&amp;menu_id='
				 .$content_menu_id[1].'&amp;id='.$DB->mbm_result($r_contents,$i,"id").'" class="contentMoreLink"  >'
				 .$lang["main"]["more"].'</a>';
		}
		$buf .= $htmls[3];
	}
	$buf .= $htmls[1];
	return $buf;
}
function mbmContentNews($htmls=array(0=>'',1=>'',2=>'',3=>''),$menu_id=0,$total_main=1,$total_contents=10,$orderby='id',$asc='DESC',$use_media=0,$show_more_button=0){
	global $DB,$DB2,$lang;
	
	$q_contents = "SELECT * FROM ".PREFIX."menu_contents WHERE st=1 AND date_added<".mbmTime()." ";
	if($use_media==0){
		$q_contents .= "AND is_video=0 AND is_photo=0 ";
	}
	if(is_array($menu_id)){
		//menu_id -g array bolgoj oruulval array-d bui menunuudiin medeelliig haruulna
		$q_contents .= "AND ( ";
		foreach($menu_id as $k=>$v){
			$q_contents .= "menu_id LIKE '%,".$k.",%' OR ";
		}
		$q_contents = rtrim($q_contents,"OR ");
		$q_contents .= ") ";
	}elseif($menu_id!=0){
		$q_contents .= "AND menu_id LIKE '%,".$menu_id.",%' ";
	}
	$q_contents .= "ORDER BY ".$orderby." ".$asc." LIMIT ".$total_contents;
	$r_contents = $DB->mbm_query($q_contents);
	
	$buf2 = $htmls[0];
	$buf = '';
	for($i=0;$i<$DB->mbm_num_rows($r_contents);$i++){
		$content_menu_id = explode(',',$DB->mbm_result($r_contents,$i,"menu_id"));
		if($DB->mbm_result($r_contents,$i,"cleanup_html")==1){
			$content_short = mbmCleanUpHTML($DB->mbm_result($r_contents,$i,"content_short"));
			if($total_main>0){
			$buf .= '<a href="index.php?module=menu&amp;cmd=content&amp;menu_id='
					.$content_menu_id[1].'&amp;id='.$DB->mbm_result($r_contents,$i,"id").'" class="contentMoreLink">'
					.$lang["main"]["more"].'</a>';
			}
		}else{
			$content_short = $DB->mbm_result($r_contents,$i,"content_short");
		}
		
		$c_title = $DB->mbm_result($r_contents,$i,"title");
		
		if(defined("CONTENT_TITLE_LENGTH")){
			if(mbm_strlen($c_title)>CONTENT_TITLE_LENGTH){
				$c_title = mbm_substr($c_title,CONTENT_TITLE_LENGTH).'...';
			}
		}
		
		if($i<$total_main){
			if($DB->mbm_result($r_contents,$i,"show_title")=='1'){
				$buf .= '<div class="contentTitle" onclick="window.location=\'index.php?module=menu&amp;cmd=content&amp;menu_id='
						.$content_menu_id[1]
						.'&amp;id='.$DB->mbm_result($r_contents,$i,"id")
						.'\'" '
						.' title="'.addslashes($DB->mbm_result($r_contents,$i,"title")).'"'
						.'>'.$c_title.'</div>';
			}
			if($total_contents>1){
				$buf .= '<div  class="mbmTimeConverter">'
					.mbmTimeConverter($DB->mbm_result($r_contents,$i,"date_added"))
					.'</div>';
			}
			$buf .= $content_short;
			if($show_more_button == '1'){
				$buf .= '<a href="index.php?module=menu&amp;cmd=content&amp;menu_id='
						.$content_menu_id[1].'&amp;id='.$DB->mbm_result($r_contents,$i,"id")
						.'" class="contentMoreLink">'.$lang['main']['more'].'</a>';
			}
		}else{
			$buf2 .= $htmls[2];
			$buf2 .= '<a href="index.php?module=menu&amp;cmd=content&amp;menu_id='
						.$content_menu_id[1].'&amp;id='.$DB->mbm_result($r_contents,$i,"id").'" title="'.addslashes($DB->mbm_result($r_contents,$i,"title")).'">'
						.$c_title
						.'</a>';
			$buf2 .= $htmls[3];
		}
		$c_title = '';
	}
	$buf .= $buf2.$htmls[1];
	
	return $buf;
}

function mbmContentInformation($info=array('id'=>0)){
	global $DB,$DB2,$lang;
	
	
	$buf .= '<div id="contentInformation">';
	$buf .= '<table width="100%" border="0" cellspacing="0" cellpadding="2">
			  <tr>
				<td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0" style="width:100%;">
				  <tr class="contentInformationTitle">
					<td width="33%" align="center">'.$lang["menu"]["content_added_by"].'</td>
					<td width="33%" align="center">'.$lang["main"]["hits"].'</td>
					<td width="33%" align="center">'.$lang["main"]["date_added"].'</td>
				  </tr>
				  <tr class="contentInformationInfo">
					<td align="center">'.$DB2->mbm_get_field($info['user_id'],'id','username','users').'</td>
					<td align="center">'.number_format($info['hits']).'</td>
					<td align="center">'.date("d/m/Y",$info['date_added']).'</td>
				  </tr>
				  <tr class="contentInformationInfo" >
					<td align="center">'.mbmAddRSSPage(array(
												'content_type'=>$info['content_type']
											   )
										 ).'</td>
					<td align="center">'.mbmShareThisPage(array(
												  'title'=>$info['title']
												 )
										   ).'</td>
					<td align="center">';
					if($info['content_type']!='video'){
						$buf .= mbmSend2Friend();
					}
				  $buf .= '</td>
				  </tr>';
				$buf .= '</table></td>';
				if($info['content_type'] != 'photo'){
					$buf .= '<td width="110" valign="top">';
					$buf .= mbmRating('content_'.$info['id'])
						 .'</td>';
				}
				$buf .= '
			  </tr>
			</table>
			';
	$buf .= '</div>';
		
	return $buf;
}

function mbmMediaContentThumbImage(
									$value=array(
												'content_id'=>0,
												'type'=>'video'
												)
								  ){
	global $DB;
	
	$buf = '';
	
	switch($value["type"]){
		case 'photo':
			$q_content_photo = "SELECT * FROM ".PREFIX."menu_photos WHERE content_id='".$value["content_id"]."' ORDER BY RAND() LIMIT 1";
			$r_content_photo = $DB->mbm_query($q_content_photo);
			if($DB->mbm_num_rows($r_content_photo)==1){
				$buf .= '<img src="';
				if(substr_count($DB->mbm_result($r_content_photo,0,"url"),DOMAIN.DIR)>0){
					$img_url = str_replace(DOMAIN.DIR,"",$DB->mbm_result($r_content_photo,0,"url"));
				}else{
					$img_url = $DB->mbm_result($r_content_photo,0,"url");
				}
				$img_type = $DB->mbm_result($r_content_photo,0,"filetype");
				$buf .= DOMAIN.DIR.'img.php?type='
						.$img_type
						.'&amp;f='
						.base64_encode($img_url)
						.'&amp;w=80';
				$buf .= '" border="0" hspace="5" class="thumb_img" />';
			}else{
				$buf = '';
			}
		break;
		case 'video':
			switch($value["is_video"]) {
				case 1:
					$videoTBL = 'menu_videos';
				break;
				case 2:
					$videoTBL = 'menu_youtube';
				break;
				default:
					$videoTBL = 'menu_videos';
				break;
			}
			$q_content_video = "SELECT * FROM ".PREFIX.$videoTBL." WHERE content_id='".$value["content_id"]."' ORDER BY RAND() LIMIT 1";
			$r_content_video = $DB->mbm_query($q_content_video);
			if($DB->mbm_num_rows($r_content_video)==1){
				$buf .= '<img src="'.DOMAIN.DIR;
				if(substr_count($DB->mbm_result($r_content_video,0,"url"),DOMAIN.DIR)>0){
					$img_url = str_replace(DOMAIN.DIR,"",$DB->mbm_result($r_content_video,0,"image_url"));
				}else{
					$img_url = $DB->mbm_result($r_content_video,0,"image_url");
				}
				$img_type = $DB->mbm_result($r_content_video,0,"image_filetype");
				$buf .= 'img.php?type='
						.$img_type
						.'&amp;f='
						.base64_encode($img_url)
						.'&amp;w=80';
				$buf .= '" border="0" hspace="5" class="thumb_img" />';
			}else{
				$buf = '';
			}
		break;
	}
	
	return $buf;
}
function mbmContentBriefInfo($var = array(
										  'content_id'=>0,
										  'user_id'=>0,
										  'menu_id'=>',0,',
										  'hits'=>0,
										  'rating'=>0
										  )){

	global $DB,$DB2,$lang;
	
	$buf = '<div class="contentBriefInfo" id="contentBriefInfo">
			<ul>';
		$buf .= '<li>';
			$buf .= '<span>'.$lang['main']['name'].':</span> ';
			$buf .= '<span class="briefValues">';
			$buf .= $DB2->mbm_get_field($var['user_id'],'id','username','users');
			$buf .= '</span>';
		$buf .= '</li>';
		$buf .= '<li>';
			$buf .= '<span>'.$lang["menu"]["category"].':</span> ';
			$buf .= '<span class="briefValues" title="'.addslashes(mbmReturnMenuNames($var['menu_id'])).'">';
			if(mbm_strlen(mbmReturnMenuNames($var['menu_id']))>20){
				$buf .= mbm_substr(mbmReturnMenuNames($var['menu_id']),20).'...';
			}else{
				$buf .= mbmReturnMenuNames($var['menu_id']);
			}
			$buf .= '</span>';
		$buf .= '</li>';
		$buf .= '<li>';
			$buf .= '<span>'.$lang['main']['hits'].':</span> ';
			$buf .= '<span class="briefValues">';
			$buf .= number_format($var['hits']);
			$buf .= '</span>';
		$buf .= '</li>';
		$buf .= '<li>';
			$buf .= '<span>'.$lang['rating']['result'].':</span> ';
			$buf .= '<span class="briefValues">';
			$buf .= mbmRatingResult('content_'.$var['content_id'],1);
			$buf .= '</span>';
		$buf .= '</li>';
		$buf .= '<li>';
			$buf .= '<span>'.$lang['menu']['content_comment'].':</span> ';
			$buf .= '<span class="briefValues">';
			$buf .= mbmContentCommentsTotal($var['content_id']);
			$buf .= '</span>';
		$buf .= '</li>';
	$buf .= '</ul></div><br clear="both" />';
	
	return $buf;
}
function mbmContentCommentsTotal($content_id=0){
	global $DB;
	
	$q = "SELECT COUNT(id) FROM ".PREFIX."menu_content_comments WHERE content_id='".$content_id."'";
	$r = $DB->mbm_query($q);
	
	return $DB->mbm_result($r,0);
}

function mbmNextPrevContent($date_added=123456789,$next=1,$menu_id=0){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."menu_contents WHERE st=1 AND ";
	if($next == '1'){
		$q .= "date_added>'".$date_added."' AND date_added<".mbmTime()." ";
		$ob = "ORDER BY date_added ASC";
		$next_sum = '&raquo;';
	}else{
		$q .= "date_added<'".$date_added."'";
		$prev_sum = '&laquo;';
		$ob = "ORDER BY date_added DESC";
	}
	$q .= " AND menu_id LIKE '%,".$menu_id.",%' ".$ob." LIMIT 1";
	$r = $DB->mbm_query($q);
	
	$buf = '';
	if($DB->mbm_num_rows($r)==1){
		$content_menu_id = explode(',',$DB->mbm_result($r,0,"menu_id"));
		$buf .= '<a href="index.php?module=menu&amp;cmd=';
		$buf .= $_GET['cmd'];
		$buf .= '&amp;id='.$DB->mbm_result($r,0,"id").'&amp;menu_id='.$menu_id.'" title="'.addslashes($DB->mbm_result($r,0,"title")).'">';
		$buf .= $prev_sum.' ';
		$c_title = $DB->mbm_result($r,0,"title");
		if(mbm_strlen($c_title)>CONTENT_TITLE_LENGTH){
			$c_title = mbm_substr($c_title,CONTENT_TITLE_LENGTH).'...';
		}
		$buf .= $c_title;
		$buf .= ' '.$next_sum;
		$buf .= '</a>';
	}
	
	return $buf;
}

function mbmGetImagesFromMenuContents(
								$var = array(
									  'field_name'=>'content_more',
									  'menu_id'=>0,
									  'limit'=>10,
									  'img_width'=>300,
									  'hspace'=>5,
									  'vspace'=>2,
									  'order_by'=>'RAND()'
									  )	 
								){
	//zuvhun JPG zurag haruulahaar shiidev. --> LIKE '%<img%.jpg%'
	global $DB;
	
	$q = "SELECT id,menu_id,".$var['field_name']." FROM ".$DB->prefix."menu_contents WHERE ".$var['field_name']." LIKE '%<img%.jpg%' ";
	if(is_array($var['menu_id'])){
		$q .= "AND ( ";
		foreach($var['menu_id'] as $k=>$v){
			$q .= "menu_id LIKE '%,";
			if($v!=0) $q .= $v;
			else $q .= $k;
			$q .= ",%' OR ";
		}
		$q = rtrim($q,"OR ");
		$q .= ") ";
	}elseif($var['menu_id'] != 0){
		$q .= "AND menu_id LIKE '%,".$var['menu_id'].",%' ";
	}
	$q .= "ORDER BY ".$var['order_by']." LIMIT ".$var['limit']."";

	$r = $DB->mbm_query($q);
	
	$buf = '';
	
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$dd = mbmGetImagesIntoArray(stripslashes($DB->mbm_result($r,$i,"content_more")));
		$buf .= '<a href="'.DOMAIN.DIR.'index.php?module=content&amp;cmd=content&amp;menu_id='.mbmReturnMenuId($DB->mbm_result($r,$i,"menu_id")).'&amp;id='.$DB->mbm_result($r,$i,"id").'" >';
		$buf .= '<img '.$dd[0][0][0].' '.$dd[0][0][1].' '.$dd[0][0][2].' width="'.$var['img_width'].'" vspace="'.$var['vspace'].'"  border="0" />';
		$buf .= '</a>';
	}
	return $buf;
}
?>