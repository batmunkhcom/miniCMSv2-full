<?php
include_once("config.php");
// File and new size
$filename = base64_decode($_GET['f']);
if(substr_count($filename,'http://') > 0){
	$filename = base64_decode($_GET['f']);
}else{
	$filename = $config["abs_dir"].str_replace("%20","",base64_decode($_GET['f']));
}
$percent = $_GET['p']/100;
// Get new sizes
list($width, $height) = getimagesize($filename);
if($width == 0 || !isset($width) || $width == '') $width = 1;
if($height == 0 || !isset($height) || $height == '') $height = 1;
if(isset($_GET['p'])){
	$newwidth = $width * $percent;
	$newheight = $height * $percent;
}else{
	if(!ctype_digit($_GET['h'])){
		$newheight = ($_GET['w']/$width)*$height;
	}else{
		$newheight = $_GET['h'];
	}
	if(!ctype_digit($_GET['w'])){
		$newwidth = ($_GET['h']/$height)*$width;
	}else{
		$newwidth = $_GET['w'];
	}
	if(!ctype_digit($_GET['w']) && !ctype_digit($_GET['h'])){
		$newheight = 100;
		$newwidth = 100;
	}
}
if(!isset($_GET['action'])){
	switch(strtolower($_GET['type'])){
		case 'jpg':
			// Content type
			header('Content-type: image/jpeg');
			// Load
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = imagecreatefromjpeg($filename);
			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			// Output
			imagejpeg($thumb);
		break;
		case 'gif':
			// Content type
			header('Content-type: image/gif');// Load
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = imagecreatefromgif($filename);
			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			// Output
			imagegif($thumb);
		break;
		case 'png':
			// Content type
			header('Content-type: image/png');
			// Load
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = imagecreatefrompng($filename);
			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			// Output
			imagepng($thumb);
		break;
		case 'txt':
			header("Content-type: image/png");
			$txt = $_GET['txt'];
			$width=(strlen($txt)*10)*1;
			$im = @imagecreate($width, 22)
			or die("Cannot Initialize new GD image stream");
			$background_color = imagecolorallocate($im, 51, 51, 51);
			$text_color = imagecolorallocate($im, 255, 255, 255);
			imagestring($im, 4, 5, 5,  $txt, $text_color);
			imagepng($im);
			imagedestroy($im);
		break;
	}
}else{
	switch($_GET['action']){
		case 'crop':
			//cropImage(225, 165, $filename, strtolower($_GET['type']), '/path/to/dest/image.jpg');
		break;
	}
}
//image function
//     cropImage(225, 165, '/path/to/source/image.jpg', 'jpg', '/path/to/dest/image.jpg');
	function cropImage($nw, $nh, $source, $stype, $dest) {
		$size = getimagesize($source);
		$w = $size[0];
		$h = $size[1];
		switch($stype) {
			case 'gif':
				$simg = imagecreatefromgif($source);
			break;
			case 'jpg':
				$simg = imagecreatefromjpeg($source);
			break;
			case 'png':
				$simg = imagecreatefrompng($source);
			break;
		}
		$dimg = imagecreatetruecolor($nw, $nh);
		$wm = $w/$nw;
		$hm = $h/$nh;
		$h_height = $nh/2;
		$w_height = $nw/2;
		if($w> $h) {
			$adjusted_width = $w / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
		} elseif(($w <$h) || ($w == $h)) {
			$adjusted_height = $h / $wm;
			$half_height = $adjusted_height / 2;
			$int_height = $half_height - $h_height;
			imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h);
		} else {
			imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
		}
		imagejpeg($dimg,$dest,100);
	}

?>