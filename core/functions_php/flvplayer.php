<?

function mbmFlvPlayer($flvPlayerVars = array()){
	if($flvPlayerVars['name'] == '' || !isset($flvPlayerVars['name'])){
		$flvPlayerVars['name'] = 'videoPlayer';
	}
	$buf = '<object type="application/x-shockwave-flash" data="'.$flvPlayerVars['swf_player'].'" 
				width="'.$flvPlayerVars['width'].'" 
				height="'.$flvPlayerVars['height'].'"
				name="'.$flvPlayerVars['name'].'"
				id="'.$flvPlayerVars['name'].'">
				<param name="movie" value="'.$flvPlayerVars['swf_player'].'" />
				<param name="allowFullScreen" value="true" />
				<param name="wmode" value="opaque" />
				<param name="FlashVars" 
					value="autoplay='.$flvPlayerVars['autoplay']
					.'&amp;autoload='.$flvPlayerVars['autoload']
					.'&amp;title='.$flvPlayerVars['title']
					.'&amp;flv='.$flvPlayerVars['flv_url']
					.'&amp;showvolume='.$flvPlayerVars['showvolume']
					.'&amp;showfullscreen='.$flvPlayerVars['showfullscreen']
					.'&amp;showstop='.$flvPlayerVars['showstop']
					.'&amp;showtime='.$flvPlayerVars['showtime']
					.'&amp;buttoncolor='.$flvPlayerVars['buttoncolor']
					.'&amp;playercolor='.$flvPlayerVars['playercolor']
					.'&amp;bgcolor1='.$flvPlayerVars['bgcolor1']
					.'&amp;bgcolor2='.$flvPlayerVars['bgcolor2']
					.'&amp;buttonovercolor='.$flvPlayerVars['buttonovercolor']
					.'&amp;slidercolor1='.$flvPlayerVars['slidercolor1']
					.'&amp;slidercolor2='.$flvPlayerVars['slidercolor2']
					.'&amp;sliderovercolor='.$flvPlayerVars['sliderovercolor']
					.'&amp;loadingcolor='.$flvPlayerVars['loadingcolor']
					.'&amp;titlesize='.$flvPlayerVars['titlesize']
					.'&amp;showiconplay='.$flvPlayerVars['showiconplay']
					.'&amp;showplayer='.$flvPlayerVars['showplayer']
					.'&amp;buffer='.$flvPlayerVars['buffer'].'" />';

	$buf .= '</object>';
	
	$file_extention = substr($flvPlayerVars['flv_url'],-3);
	
	switch($file_extention){
		case 'f4v':
			$file_path = $flvPlayerVars['flv_url'];
		break;
		case 'flv':
			$file_path = $flvPlayerVars['flv_url'];
		break;
		case 'mp4':
			$file_path = $flvPlayerVars['flv_url'];
		break;
		default:
			$file_path = $flvPlayerVars['flv_url'];
		break;
	}
	
	$buf = "
			<div id='".$flvPlayerVars['name']."''>".DOMAIN.DIR."images/loading.gif</div>
			
			<script type='text/javascript'>
			  var so = new SWFObject('".INCLUDE_DOMAIN."data/jwplayer/player.swf','".$flvPlayerVars['name']."PL','".$flvPlayerVars['width']."','".$flvPlayerVars['height']."','9','#ffffff');
			  so.addParam('allowfullscreen','true');
			  so.addParam('allowscriptaccess','always');
			  so.addParam('wmode','opaque');
			  so.addVariable('file','".$file_path."');
			  so.addVariable('plugins','gapro-1');
			  so.addVariable('gapro.accountid','UA-6849739-2');
			  so.addVariable('bufferlength','2');
			  so.addVariable('skin','".INCLUDE_DOMAIN."data/jwplayer/skin/modieus.swf');
			  so.write('".$flvPlayerVars['name']."');
			</script>
			";
			
	$buf = '<embed id="videoPlayer" name="videoPlayer" src="'.INCLUDE_DOMAIN.'data/jwplayer/player.swf" 
		allowfullscreen="true" 
		width="'.$flvPlayerVars['width'].'" 
		height="'.$flvPlayerVars['height'].'"
		flashvars="logo='.$flvPlayerVars['title'].'&bufferlength=30&file='.$file_path.'&amp;skin='.INCLUDE_DOMAIN.'data/jwplayer/skin/modieus.swf&amp;plugins=gapro-1&gapro.accountid=UA-6849739-2" 
		>';
		
	return $buf;
}


function mbmFlvPlayerMulti($flvPlayerVars = array()){

	if(isset($_POST['playlist_id'])){
		$xml_file = rawurlencode($flvPlayerVars['xml_file'].'&amp;playlist_id='.$_POST['playlist_id']);
	}else{
		$xml_file = $flvPlayerVars['xml_file'];
	}
	$buf = '<embed id="videoPlayer" name="videoPlayer" src="'.INCLUDE_DOMAIN.'data/jwplayer/player.swf" 
allowfullscreen="true" 
width="'.$flvPlayerVars['width'].'" 
height="'.$flvPlayerVars['height'].'"
flashvars="logo='.$flvPlayerVars['title'].'&bufferlength=2&file='.$xml_file.'&amp;skin='.INCLUDE_DOMAIN.'data/jwplayer/skin/modieus.swf&playlist=bottom" 
>';
	
	
	if($flvPlayerVars['name'] == '' || !isset($flvPlayerVars['name'])){
		$flvPlayerVars['name'] = 'videoPlayer';
	}
	$buf = "
			<div id='".$flvPlayerVars['name']."'></div>
			
			<script type='text/javascript'>
			  var so = new SWFObject('".INCLUDE_DOMAIN."data/jwplayer/player.swf','".$flvPlayerVars['name']."PL','".$flvPlayerVars['width']."','".$flvPlayerVars['height']."','9','#ffffff');
			  so.addParam('allowfullscreen','true');
			  so.addParam('allowscriptaccess','always');
			  so.addParam('wmode','opaque');
			  so.addVariable('file','".$xml_file."');
			  so.addVariable('plugins','gapro-1');
			  so.addVariable('gapro.accountid','UA-6849739-2');
			  so.addVariable('skin','".INCLUDE_DOMAIN."data/jwplayer/skin/modieus.swf');
			  so.addVariable('playlist','bottom');
			  so.write('".$flvPlayerVars['name']."');
			</script>
			";
	return $buf;
}
function mbmFlvPlayerStream($flvPlayerVars = array()){
	$buf = '<embed src="'.INCLUDE_DOMAIN.'data/jwplayer/player.swf" 
		allowfullscreen="true" 
		width="'.$flvPlayerVars['width'].'" 
		height="'.$flvPlayerVars['height'].'"
		flashvars="logo='.$flvPlayerVars['title'].'&bufferlength=2&file='.str_replace(DOMAIN.DIR,"",$flvPlayerVars['flv_url']).'&amp;streamer=rtmp://www.yadii.net/live&amp;skin='.INCLUDE_DOMAIN.'data/jwplayer/skin/modieus.swf" 
		>';

return $buf;
}
?>