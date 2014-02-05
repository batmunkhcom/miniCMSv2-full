<?PHP


//**************************ehleh********************************//
function mbmXMLParser($var = array(
								   'xml_file'=>'',
								   'tpl_file'=>'',
								   'feedtitle_limit'=>0,
								   'feeddesc_limit'=>0,
								   'itemtitle_limit'=>0,
								   'itemdesc_limit'=>0,
								   'limit'=>10,
								   'from_charset'=>'UTF-8'
								   )){


		  
	//New rss class initialization, with sample Url 
	$RSS = new Rss($var['xml_file']);
	$RSS->limit=$var['limit'];
	
	//Set HTML template for displaying rss items
	$rss_template = '';
	if(file_exists($var['tpl_file'])){
		$lines = file($var['tpl_file']);
		// Loop through our array, show HTML source as HTML source; and line numbers too.
		foreach ($lines as $line_num => $line) {
		   $rss_template .= ($line);
		}
	}else{
		$rss_template = RSS_TEMPLATE;
	}
	$RSS->Template=$rss_template;
	

	//cache dir
	$RSS->CashPath="/home/azmn/azmn_tmp/";
	
	
	//Get all elements of parsed RSS source into array $rssContent
	while($value=$RSS->parseItems()) $rssContent[]=$value;
	
	//Displaing array structure (for sample)
	if(is_array($rssContent)){
		foreach($rssContent as $k=>$v){
			$buf .= $v;
		}
	}
	if(isset($var['from_charset']) && $var['from_charset']!='UTF-8'){
		$buf = mb_convert_encoding($buf,"UTF-8",$var['from_charset']);
	}
	
	$str_replace[0] = array('дэлгэрэнгvйг www.olloo.mn - c');
	$str_replace[1] = array('');
	
	$buf = str_replace($str_replace[0],$str_replace[1],$buf);
	
	echo $buf;
}
?>