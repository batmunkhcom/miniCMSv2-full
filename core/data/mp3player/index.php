<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jeroenwijering Flash MP3 Player</title>
</head>
<body style="margin:50px; text-align:center; background-color:#eeeeee;">

<h2>mp3player with playlist</h2>

<!-- 
Here starts the code you can to copy to your website. You can change the 'width' 
and 'height' parameters to whatever dimensions you want the player to be. Note
that these parameters appear twice, so you need to set them twice!
 -->

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="300" height="160" id="mp3player"
		codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" >
    <param name="movie" value="mp3player.swf" />
    <embed src="mp3player.swf" width="300" height="160" name="mp3player"
    	type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

<!-- this is the end of the code you need --> 


<h2>single mp3player</h2>

<!-- 
This is an example of how to use the mp3player for a 'single' song.
 -->
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="300" height="20"
		codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" >
    <param name="movie" value="mp3player.swf" />
    <param name="flashvars" value="file=mp3/homeland.mp3&autostart=false" />
    <embed src="mp3player.swf" width="300" height="20" flashvars="file=mp3/homeland.mp3&autostart=false" 
    	type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>


</body>
</html>
