<?php

/*

Flash isn't allowed to read XML files from another server than it's own. 
For these security reasons you cannot directly read an external RSS feed.
If you have access to php, this script poses a wourkaround for that. 

First, enter the full URL of the external podcast you want to link to down here.
Second, upload this file to the same directory as the mp3player/flvplayer/jpgrotator.
Third, set this php script in the file variable in the HTML embed code (this
example assumes you use the mp3player):

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="300" height="200" id="mp3player"
		codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" >
    <param name="movie" value="mp3player.swf?file=getfeed.php" />
    <param name="wmode" value="transparent" />
    <embed src="mp3player.swf?file=getfeed.php" wmode="transparent" width="300" height="200" name="mp3player" 
    	type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

*/




// get the name
$filename = $_GET['file'];


// build file headers
header("content-type:text/xml;charset=utf-8");


// refer to file and exit
readfile("$filename");
exit();

?>
    