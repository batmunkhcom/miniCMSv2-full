<?

function mbmShowContentPhotos($content_id=0){
	global $DB,$lang;
	
	$q_photos = "SELECT * FROM ".PREFIX."menu_photos WHERE content_id='".$content_id."'";
	$r_photos = $DB->mbm_query($q_photos);
	
	$buf = '';/*'<marquee truespeed direction="left" scrollamount="1" 
				scrolldelay="3"  onmouseover="this.stop()" 
				onmouseout="this.start()" >';*/
	$buf .= '<div id="thumbPhotos" style="display:block;clear:both;">';
	for($i=0;$i<$DB->mbm_num_rows($r_photos);$i++){
		if(substr_count($DB->mbm_result($r_photos,$i,"url"),DOMAIN.DIR)>0){
			$img_url = str_replace(DOMAIN.DIR,"",$DB->mbm_result($r_photos,$i,"url"));
		}else{
			$img_url = $DB->mbm_result($r_photos,$i,"url");
		}
		if($DB->mbm_result($r_photos,$i,"width")<NEWS_PHOTO_WIDTH){
			$photo_w = $DB->mbm_result($r_photos,$i,"width");
		}else{
			$photo_w = NEWS_PHOTO_WIDTH;
		}
		$image_url_full = ''.DOMAIN.DIR.'img.php?type='
					.$DB->mbm_result($r_photos,$i,'filetype')
					.'&amp;f='
					.base64_encode($img_url)
					.'&amp;w='
					.$photo_w;
		
		$image_download_url = DOMAIN.DIR.'rss.php?dl=content_photo&amp;id='.$DB->mbm_result($r_photos,$i,'id');
		
		$buf1 .= '<span class="imageTitle'.$DB->mbm_result($r_photos,$i,"id").'" ><strong>'
				.$DB->mbm_result($r_photos,$i,"title").'</strong></span>';
		$buf .= '<a href="'.$image_url_full.'" title="'.$DB->mbm_result($r_photos,$i,"title").'" downloadUrl="'.$image_download_url.'" photoId="'.$DB->mbm_result($r_photos,$i,"id").'">';
		//$buf .= $DB->mbm_result($r_photos,$i,"title").'<br />';
			
			$buf .= '<img border="0" src="'.DOMAIN.DIR.'img.php?type='
						.$DB->mbm_result($r_photos,$i,'filetype')
						.'&amp;f='
						.base64_encode($img_url)
						.'&amp;w=80&amp;h=80'
						.'" align="absmiddle"';
			$buf .='" class="thumb_img"  alt="'.$DB->mbm_result($r_photos,$i,"comment").'" bigImg="'.$image_download_url.'" />';
		$buf .= '</a>';
		$buf1 .= '<div class="imageComment'.$DB->mbm_result($r_photos,$i,"id").'" >'
				.$DB->mbm_result($r_photos,$i,"comment").'</div>';
		$buf1 .= '<a href="'.$image_download_url.'" class="imageDownload" target="_blank">'.$lang["menu"]["photo_orig_size"].'</a>';
		
		$DB->mbm_query("UPDATE ".PREFIX."menu_photos SET hits=hits+".HITS_BY.",session_time='".mbmTime()."' WHERE id='".$DB->mbm_result($r_photos,$i,"id")."'");
	}
	$buf .= "</div><br clear='both' />";
	return $buf;
}

/*

function mbmShowContentPhotos($content_id=0){
	global $DB,$lang;
	
	$q_photos = "SELECT * FROM ".PREFIX."menu_photos WHERE content_id='".$content_id."'";
	$r_photos = $DB->mbm_query($q_photos);
	
	$buf .= '<div id="thumbPhotos" style="display:block; overflow-y:auto; height:300px;">';
	$buf .= '<table cellspacing="2" align="center" cellpadding="3" border="0"></tr>';
	for($i=0;$i<$DB->mbm_num_rows($r_photos);$i++){
		if(substr_count($DB->mbm_result($r_photos,$i,"url"),DOMAIN.DIR)>0){
			$img_url = str_replace(DOMAIN.DIR,"",$DB->mbm_result($r_photos,$i,"url"));
		}else{
			$img_url = $DB->mbm_result($r_photos,$i,"url");
		}
		if($DB->mbm_result($r_photos,$i,"width")<NEWS_PHOTO_WIDTH){
			$photo_w = $DB->mbm_result($r_photos,$i,"width");
		}else{
			$photo_w = NEWS_PHOTO_WIDTH;
		}
		$image_url_full = 'img.php?type='
					.$DB->mbm_result($r_photos,$i,'filetype')
					.'&amp;f='
					.base64_encode($img_url)
					.'&amp;w='
					.$photo_w;
		$buf .= '<td width="100" valign="top" align="center">';
		$buf .= '<img hspace="5" border="0" src="img.php?type='
					.$DB->mbm_result($r_photos,$i,'filetype')
					.'&amp;f='
					.base64_encode($img_url)
					.'&amp;w=80'
					.'" align="absmiddle"';
		$buf .='" onclick="mbmShowImage(\''.$image_url_full.'\',\''.$photo_w.'\',\''.$DB->mbm_result($r_photos,$i,"id").'\')"
				style="cursor:pointer;" class="thumb_img" />';
		$buf .= '<br /><a href="rss.php?dl=content_photo&amp;id='.$DB->mbm_result($r_photos,$i,'id').'" target="_blank">'.$lang["menu"]["photo_orig_size"].'</a>';
		$buf .= '<div id="imageTitle'.$DB->mbm_result($r_photos,$i,"id").'" style="display:none;"><strong>'
				.$DB->mbm_result($r_photos,$i,"title").'</strong></div>
				<div id="imageComment'.$DB->mbm_result($r_photos,$i,"id").'" style="display:none;"><br />'
				.$DB->mbm_result($r_photos,$i,"comment").'</div>';
		$buf .= '</td>';
		if((int)(NEWS_PHOTO_THUMB_COLUMS)>0){
			$thumb_colums=NEWS_PHOTO_THUMB_COLUMS;
		}else{
			$thumb_colums=5;
		}
		if((($i+1)%$thumb_colums)==0){
			$buf .= '</tr><tr>';
		}
		$DB->mbm_query("UPDATE ".PREFIX."menu_photos SET hits=hits+".HITS_BY.",session_time='".mbmTime()."' WHERE id='".$DB->mbm_result($r_photos,$i,"id")."'");
	}
	$buf .= '</tr></table>';
	$buf .= '</div>';
	//$buf .= '</marquee>';
	
	$buf .= '<script language="Javascript">
			 	function mbmShowImage(image_url,image_width,image_id){
					document.getElementById(\'loading_img\').style.display=\'block\';
					targetDiv = document.getElementById("imageFull");
					targetDiv.innerHTML = \'\';
					targetDiv.innerHTML = targetDiv.innerHTML + document.getElementById("imageTitle"+image_id).innerHTML;
					if(document.getElementById("imageComment"+image_id).innerHTML!=""){
						targetDiv.innerHTML = targetDiv.innerHTML+document.getElementById("imageComment"+image_id).innerHTML;
					}
					targetDiv.innerHTML = targetDiv.innerHTML + \'<center><img src="\'+image_url+\'" style="cursor:pointer" /></center>\'; 
					setTimeout("document.getElementById(\'loading_img\').style.display=\'none\'",5000);
				}
			 </script>';
	
	$mainImage = '<div style="
							margin-top:12px;
							margin-bottom:12px;
							border:5px solid #e2e2e2;
							background-color:#f5f5f5;
							padding:10px;
							text-align:left;
						align="center" 
						id="imageFull">';
	$mainImage .= '</div>';
	$mainImage .= '<div id="loading_img" style="display:none;" align="center"><img src="images/web/loading.gif" border="0" /></div>';
	return $mainImage.$buf;
}
*/
?>