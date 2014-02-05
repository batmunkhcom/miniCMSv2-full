<?
//########################################################
//#                   Cacher.php v1.0                    #
//#                  By Khaled Fadhel                    #
//#                alfadhil@hotmail.com                  #
//########################################################
//#                                                      #
//# Salalah-Network CGI Scripts                          #
//#   http://www.salalah.cjb.net                         #
//#                                                      #
//########################################################
//########################################################
//#                                                      #
//# You can redistribute this script or use it freely    #
//# as long as this header is not edited in the script.  #
//# *I would appreciate a link from you to the URL above.#
//########################################################
//# Description:                                         #
//#     This script allows you to cache the output of    #
//#     almost any script,to speed its execution.        #
//#     To do so launch this script instead of           #
//#     launching the script to be cached.               #
//########################################################
//#History                                               #
//#=======                                               #
//# Cacher.php v1.0:  17-01-2001                         #
//#      - First release                                 #
//########################################################

/* 
	A caching class, loosely based on
//#                   Cacher.php v1.0                    #
//#                  By Khaled Fadhel                    #
//#                alfadhil@hotmail.com                  #
	but now by:
	
	Martin Milner
	martin@newdomain.nl
	30-10-2001
	
	You MUST create a directory called cache and chmod it to 777 and the calss will store the cache files there, so you keep them
	seperated from the code. Use sensible file names for EVERYTHING or you will be sorry :(
	
	So the result is a cache object which you can call repeatedly from a script (as needed) with different arguments.
	This would aid the purpose of seperating the layout from the code (I advise everyone to use templates)
	
	you call the class like this	:
	$cacher = new Cacher(cache-time);
	now we have a nice cache-object
	$cacher->cache("phpscript", time to live(optional, you can leave it blank));
	
	example		:
	$cacher = new Cacher(60);
	$output = $cacher -> cache("http://www.YourDomain.com/test.php");
	
	it also supports arguments to the php file like:
	$output = $cacher -> cache("http://www.YourDomain.com/test.php?foo=bar", 10);
	
	please note the full pathname in the url 


changes:
	we don't need the global stuff anymore, its replaced by $this->foo wich is safer, note the changed name cachefile to 
	cacheFile
	
	yeah, the else in function cache is gone, if we get here everything is supposed to be okay :)
	this way we prevent a recursive loop which could lead to endless looping
	
	the function update() now returns something sensible when in error in stead of echo-ing it
	
	now it generates the filenames from the url so it supports arguments and path variables :) woohoo :)
*/

class Cacher {
	
	var $scriptUrl;
	var $cacheFile;
	var $period;
	var $content;
	var $error;

//constructor
	function cacher($period=60){
		$this->period = $period;
	}

//the main function. basically this does the business
	function cache($url, $period=0) {
		if ($period!=0){
			$this->period = $period;
		}
		$this->scriptURL = $url;
		$this->cacheFile = "cache/" . md5($url) . ".cache";
	    clearstatcache();
// I changed this, its down to 2 possible actions (yeah!) only the if is "slightly" more complicated...
	    if ( !file_exists($this->cacheFile) || ((time() - filemtime($this->cacheFile)) > $this->period) || !$f= fopen("$this->cacheFile","r") ){
		 	$error = $this->update();
//			unfortunately this is needed for after a update because the file didn't exist yet...
			$f = fopen("$this->cacheFile","r");
//			break if in error
			if ($error){
				return $error;
				break;
			}
		}
//		the result is stored in the variable content for if you need it later in any way
		$this->content = fread($f, filesize($this->cacheFile));
		fclose($f);
//		$this->content = time();
		return $this->content;
	}

/*
this function is normally not called directly. It is possible to call it directly though, if you want to force an update, like after a content edit.
*/

	function update($url=""){
		if($url==""){
			$url = $this->scriptURL;
		}
		if($this->cacheFile==""){
			$this->cacheFile = md5($url) . ".cache";
		}
		if($this->content = implode("", file("$url"))){
			if($w = fopen("$this->cacheFile","w")){
				fwrite($w,$this->content);
				fclose($w);
			}else{
		   		$this->error = "Unable to open the Cachefile for writing";
			}
		}else{
			$this->error =  "Unable to find the specified script";
		}
	return $this->error;
	}
}
?>
