<?

#######################=-##=-=##
#                              #
#  RSS parse engine v 1.0      #
#                              #
#  author: u0061mir@walla.com  #
#                              #
##=-##=-=#######################



//================ Configuration ========================================//


// Outer HTML Template

define(RSS_TEMPLATE,"<div><a href='%link%'><b>%title%</b></div><div></a<br>%description%></div>"); 




// Items per Page

//define(PER_PAGE,5);



// If you want display only One page of Items 
// And wantn't display pages splitting in the footer 

define(PAGES,1);





//RSS resource cashing timeout (seconds)

define(CASHE_TIMEOUT,3600);


//=======================================================================//

// Additional function for templates


function __tpl($tpl,$array){
 if(is_array($array) && $tpl){
    foreach($array as $key=>$val) $tpl = str_replace("%$key%",$val,$tpl);
    return $tpl;
 }
}





// Rss parse class


class Rss{

	var $Count=0;

	var $Template;

	var $Items=array();

	var $CashPath="/home/azmn/azmn_tmp/";

	var $limit = 10;

	function rss($url){

		global $Items;

                if(!$url) return ("RSS: url don't exists"); 
			

		$urlx=parse_url($url);
		
		//$Filename=$this->CashPath.$urlx[host].".rss";
		$Filename=$this->CashPath.base64_encode($url).".rss";


		$modifed=time()-@filemtime($Filename);




		if(!file_exists($Filename) || $modifed>CASHE_TIMEOUT){
		
			if( !($content = file_get_contents($url)) ) return ("RSS: sourse error");

			
			if(file_exists($Filename)){
				$rss_tmp=fopen($Filename,"w");
	
				fputs($rss_tmp,$content);
	
				 fclose($rss_tmp);
			}
			 
		}

		else $content = file_get_contents($Filename);

		preg_match_all("/<item>(.+)<\/item>/Uis",$content,$Items1,PREG_SET_ORDER);

	foreach($Items1 as $indx=>$var){

			$this->Items[$indx]=$var[1];

		}
	

	}



	function parseItems(){	

		$Item=$this->Items[$this->Count];

		if(!$Item) return FALSE;		

		$this->Count++;
		
		preg_match_all("/<(title|link|description)>(.+)<\/(\\1)>/is",$Item,$ParsedItem,PREG_SET_ORDER);
		
		$title = $ParsedItem[0][2];
		//$title = str_replace("&amp;","&",$title);
		
		//$ParsedArray[title]	  = htmlspecialchars($title,ENT_QUOTES);
		
		$ParsedArray[title]	  = mbmUnRSSecho($title);
		$ParsedArray[link]	  = urldecode($ParsedItem[1][2]);
		
		$desc = str_replace("<!--","",$ParsedItem[2][2]);
		$desc = str_replace("<!--","",$desc);
		$desc = str_replace("-->","",$desc);
		$desc = str_replace("<![CDATA[","",$desc);
		$desc = str_replace("]]>","",$desc);
		$desc = str_replace("&amp;","&",$desc);
		$desc = str_replace("&#60;","<",$desc);
		$desc = str_replace("&lt;","<",$desc);
		
		$ParsedArray[description] = mbmUnRSSecho($desc);//htmlspecialchars(mbmUnRSSecho($ParsedItem[2][2]),ENT_QUOTES);
		/*		
		$ParsedArray[title]	  = $ParsedItem[0][2];
		$ParsedArray[link]	  = urldecode($ParsedItem[1][2]);
		$ParsedArray[description] = $ParsedItem[2][2];
		*/

		return __tpl($this->Template,$ParsedArray);


	}	



}


?>