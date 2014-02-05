<?
function mbmMP3PlayerWithList($var = array(
										   'config_file'=>'',
										   'playlist_file'=>'',//INCLUDE_DOMAIN.'data/mp3player/playlist.php',
										   'width'=>'300',
										   'height'=>'200',
										   ''=>''
										   )){
	
	$buf = '';
	$buf .= '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="'.$var['width'].'" height="'.$var['height'].'" id="mp3player" 
					codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" >
				  <param name="movie" value="http://www.server.com/mp3player.swf" />
				  <param name="flashvars" value="config='.$var['playlist_file'].'&file='.$var['playlist_file'].'" />
				  <embed src="'.INCLUDE_DOMAIN.'data/mp3player/mp3player.swf" width="'.$var['width'].'" height="'.$var['height'].'" name="mp3player"
					flashvars="config='.$var['playlist_file'].'&file='.$var['playlist_file'].'" 
					type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
				</object>
				';
	$buf .= '';
	$buf .= '';
	
	return $buf;
}
?>