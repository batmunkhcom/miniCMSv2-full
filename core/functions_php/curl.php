<?
function getPage($url,$post = false,$cookie = false)
{
    $pURL = parse_url($url);    
    $curl = new Curl($pURL['host']);
                    
    if (strstr($url,'https://')) 
    {
        $curl->secure = true;	
    }
    
    if ($post) {
    	return $curl->post($url,$post);
    } else {
        return $curl->get($url);
    }
    
}

function mbmDownloadWithCURL($fileURL='',$saveFile=''){
	$fp = fopen ($saveFile, 'w+');//This is the file where we save the information
	$ch = curl_init($fileURL);//Here is the file we are downloading
	curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}
?>