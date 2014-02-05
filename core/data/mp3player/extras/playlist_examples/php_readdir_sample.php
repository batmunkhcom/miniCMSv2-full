<?php

/*
This is a sample file that reads through a directory, filters the mp3//jpg/flv 
files and builds a playlist from it. After looking through this file, you'll 
probably 'get the idea' and'll be able to setup your own directory. This 
example uses the mp3player.
*/



// search for mp3 files. set this to '.flv' or '.jpg' for the other scripts 
$filter = ".mp3";
// path to the directory you want to scan
$directory = "my_songs";



// read through the directory and filter files to an array
@$d = dir($directory);
if ($d) { 
	while($entry=$d->read()) {  
		$ps = strpos(strtolower($entry), $filter);
		if (!($ps === false)) {  
			$items[] = $entry; 
		} 
	}
	$d->close();
	sort($items);
}



// third, the playlist is built in an xspf format
// we'll first add an xml header and the opening tags .. 
header("content-type:text/xml;charset=utf-8");

echo "<?xml version='1.0' encoding='UTF-8' ?>\n";
echo "<playlist version='1' xmlns='http://xspf.org/ns/0/'>\n";
echo "	<title>Sample PHP Generated Playlist</title>\n";
echo "	<info>http://www.jeroenwijering.com/</info>\n";
echo "	<trackList>\n";

// .. then we loop through the mysql array ..
for($i=0; $i<sizeof($items); $i++) {
	echo "		<track>\n";
	echo "			<annotation>".($i+1).". ".$items[$i]."</annotation>\n";
	echo "			<location>".$directory.'/'.$items[$i]."</location>\n";
	echo "			<info></info>\n";
	echo "		</track>\n";
}
 
// .. and last we add the closing tags
echo "	</trackList>\n";
echo "</playlist>\n";



/*
That's it! You can feed this playlist to the SWF by setting this as it's 'file' 
parameter in HTML. Assuming you use the mp3player, the HTML code looks like this:

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="300" height="350" id="mp3player"
		codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
    <param name="movie" value="mp3player.swf?file=php_readdir_sample.php" />
    <param name="wmode" value="transparent" />
    <embed src="mp3player.swf?file=php_readdir_sample.php" wmode="transparent" width="300" height="350" name="mp3player" 
    	type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

*/

?>