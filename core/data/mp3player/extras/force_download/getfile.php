<?php

/*

This is a sample PHP script that allows the mp3player/flvplayer/jpgrotator
to force-download a file, instead of opening it in a new screen or some 
mediaplayer. 

You can use it by placing it in the same folder as the SWF file and call 
this script in the link fields of the playlist XML (this example assumes 
you use the mp3player and want to let them download an mp3):

	<info>getfile.php?file=http://www.myserver.com/mysongs/mysong.mp3</info>

*/


// get the name
$filename = $_GET['file'];


// required for IE, otherwise Content-disposition is ignored
if(ini_get('zlib.output_compression')) {
  ini_set('zlib.output_compression', 'Off');
}



// build file headers
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

$ext = strToLower(substr($filename,strlen($filename)-3, 3));
if ($ext == "mp3" ) { header("Content-Type: audio/x-mp3"); } 
else if ($ext == "jpg") { header("Content-Type: image/jpeg"); }
else if ($ext == "flv") { header("Content-Type: video/flv"); }

header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename));


// refer to file and exit
readfile("$filename");
exit();

?>
    