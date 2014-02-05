<?php

/*
This is a sample file that extracts a list of records from a mysql database and 
builds a playlist from it. After looking through this file, you'll probably
'get the idea' and'll be able to connect the mp3player/flvplayer/jpgrotator
to your own database. This example uses the mp3player.
*/



// first connect to database
$dbcnx = @mysql_connect("localhost","USER","PASS");
$dbselect = @mysql_select_db("DATABASE");
if ((!$dbcnx) || (!$dbselect)) { echo "Can't connect to database"; }



// next, query for a list of titles, files and links.
$query = "SELECT title,file,link FROM mp3_table";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());



// third, the playlist is built in an xspf format
// we'll first add an xml header and the opening tags .. 
header("content-type:text/xml;charset=utf-8");

echo "<?xml version='1.0' encoding='UTF-8' ?>\n";
echo "<playlist version='1' xmlns='http://xspf.org/ns/0/'>\n";
echo "	<title>Sample PHP Generated Playlist</title>\n";
echo "	<info>http://www.jeroenwijering.com/</info>\n";
echo "	<trackList>\n";

// .. then we loop through the mysql array ..
while($row = @mysql_fetch_array($result)) {
	echo "		<track>\n";
	echo "			<annotation>".$row['title']."</annotation>\n";
	echo "			<location>".$row['file']."</location>\n";
	echo "			<info>".$row['link']."</info>\n";
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
    <param name="movie" value="mp3player.swf?file=php_mysql_sample.php" />
    <param name="wmode" value="transparent" />
    <embed src="mp3player.swf?file=php_mysql_sample.php" wmode="transparent" width="300" height="350" name="mp3player" 
    	type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

*/

?>