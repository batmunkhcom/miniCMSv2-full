<?
function mbmShowHTMLEditor($fields="short",$theme='spaw2',$type='spaw',$toolbar='mini'/*all*/,$value=array(0=>'',1=>'')
							,$lang='en',$width='100%',$height="200px"){
	global $lang;
	//fields = short,more,both
	
	switch($type){
		case 'spaw':
			
			switch($fields){
				case 'short':
					$spaw_edit = new SpawEditor("content_short",$value[0],
                       $lang, $toolbar, $theme,
                       $width, $height);
					mbm_set_spaw_config($spaw_edit,$_SESSION['lev']);
					$spaw_edit->show();
				break;
				case 'more':
					$spaw_edit = new SpawEditor("content_more",$value[1]);
					mbm_set_spaw_config($spaw_edit,$_SESSION['lev']);
					$spaw_edit->show();
				break;
				case 'both':
					$spaw_edit = new SpawEditor("content_more",stripslashes($value[1]),
                       $lang, $toolbar, $theme,
                       $width, $height);
					mbm_set_spaw_config($spaw_edit,$_SESSION['lev']);
					$spaw_edit->addPage(new SpawEditorPage("content_short",$lang['menu']['content_short'],$value[0]));
					$spaw_edit->show();
				break;
			}
			
		break;
	}
}

function mbm_set_spaw_config($spaw,$userGroup=5){
	
	switch($userGroup){
		case 5:
			$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 1);
			$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 1);
		break;
		case 4:
			$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 0);
			$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 1);
		break;
		case 3:
			$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 0);
			$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 1);
		break;
		default:
			$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_modify', 0);
			$spaw->setConfigValueElement('PG_SPAWFM_SETTINGS', 'allow_upload', 0);
		break;
	}
	return true;
}

function mbmCheckEmptyField($data){
	$kk=0;
	foreach($data as $k => $v){
		if($v == '')
			$kk++;
	}
	return $kk;
}
function mbmShowStOptions($value=0){
	global $lang;
	$buf = '<option value="0" ';
		if($value==0) {
			$buf .=  'selected';
		}
	$buf .= '>'.$lang['status'][0];
	$buf .= '<option value="1" ';
		if($value==1){
			$buf .= 'selected';
		}
	$buf .= '>'.$lang['status'][1];
	return $buf;
}
function mbmIntegerOptions($ehleh,$hurtel,$selected_value=0){
	$buf= '';
	for($i=$ehleh;$i<=$hurtel;$i++){
		$buf .= '<option value="'.$i.'" ';
		if($selected_value==$i){
			$buf .= 'selected';
		}
		$buf .= '>'.$i.'</option>';
	}
	return $buf;
}
function mBmHTMLReplace ($input) {
 	$a = array("\n",'<','>','{','}','(',')');
 	$b = array('<br />','&lt;','&gt;','{','}','(',')');
	return str_replace($a,$b,$input);
}
function mbmCleanUpHTML($comment){
		
		$search = array ('@<script[^>]*?>.*?</script>@si', // Strip out javascript
					'@<[\/\!]*?[^<>]*?>@si',          // Strip out HTML tags
					'@([\r\n])[\s]+@',                // Strip out white space
					'@&(quot|#34);@i',                // Replace HTML entities
					'@&(amp|#38);@i',
					'@&(lt|#60);@i',
					'@&(gt|#62);@i',
					'@&(nbsp|#160);@i',
					'@&(iexcl|#161);@i',
					'@&(cent|#162);@i',
					'@&(pound|#163);@i',
					'@&(copy|#169);@i',
					'@&#(\d+);@e');                    // evaluate as php
	
		$replace = array (' ',
						 ' ',
						 '\1 ',
						 '" ',
						 '& ',
						 '< ',
						 '> ',
						 '  ',
						 chr(161).' ',
						 chr(162).' ',
						 chr(163).' ',
						 chr(169).' ',
						 'chr(\1) ');
		
		$comment = preg_replace($search, $replace, $comment);
		return $comment;
}

function mBmShowSWF($filename,$height,$width,$quality='high',$get_param=null,$parameters=array('name:value')){
	
	$buf = '<script type="text/javascript">
AC_FL_RunContent( \'codebase\',\'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\',\'width\',\''.$width.'\',\'height\',\''.$height.'\',\'src\',\'header\',\'quality\',\''.$quality.'\',\'pluginspage\',\'http://www.macromedia.com/go/getflashplayer\',\'movie\',\''.$filename.'\' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="'.$width.'" height="'.$height.'">
      <param name="movie" value="'.$filename.'.swf';
	  if($get_param!=null){
	  	$buf .='?'.$get_param;
	  }
	  $buf .= '" />
      <param name="quality" value="'.$quality.'" />';
	  foreach($parameters as $k=>$v){
	  	$a = explode(":",$v);
		if($a[0]!='name' && $a[1]!='value'){
			$buf .= '<param name="'.$a[0].'" value="'.$a[1].'" />';
		}
	  }
	  $buf .= '
      <embed src="'.$filename.'.swf';
	  if($get_param!=null){
	  	$buf .='?'.$get_param;
	  }
	  $buf .= '" quality="'.$quality.'" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'"></embed>
    </object></noscript>';

	return $buf;
}
function mbmCheckURL($a) {
	$d = explode("/",$a);
	
	$dd = explode(".",$d[2]);
	
	$b=1;
	
	//domainii urgutguliig shalgaj bna
	if(strlen($dd[count($dd)-1])>4){
		$b=2;
	}
	//undsen domain _ orsniig shalgaj bna
	if(substr_count($d[2],'_')>0){
		$b=3;
	}
	//undsen domaind . orson esehiig shalgaj bna
	if(substr_count($d[2],'.')==0){
		$b=4;
	}
	//domainii ehleliig shalgaj bna
	if(strtolower(substr($a,0,7))!='http://'){
		$b=5;
	}
	//hamgiin suuliin file iin urgutguliig shalgaj bna.
	$ddd=explode(".",$d[count($d)-1]); //hamgiin suuliin file iin urgutgul
	if(strlen($ddd[count($ddd)-1])>4 && substr_count($d[count($d)-1],'.')>0 && substr_count($d[count($d)-1],'?')==0){
		$b=6;
	}
	if($b==1){
		return $b;
	}else{
		return 0;
	}
}
function mbmLoginToNetworkButton(){
	$buf = '<div id="mbmLoginToNetworkButton">';
	$butsah = base64_encode(DOMAIN.DIR.basename($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING']);
	$sq = session_id();
	
    if($_SESSION['lev']==0){
		$buf .= '<a href="http://login.az.mn/?butsah='.$butsah.'&amp;sq='.$sq.'">Сүлжээнд нэвтрэх</a>';
	}else{
		$buf .= '<a href="http://login.az.mn/logout.php?butsah='.$butsah.'&amp;sq='.$sq.'">Гарах</a>';
	}
	$buf .= '</div>';
	return $buf;
}

//utf-8 cryll ugiin urtiig oloh
function mbm_strlen($str='') {
	$a[0] = array(chr(208),chr(209),chr(210),chr(211));
	$a[1] = array('','','','');
	$str = str_replace($a[0],$a[1],$str);
	return strlen($str);
} 
function mbm_substr( $txt='',$limit = 40){
    $buf = '';
    $k=0; //үсгийн байрлалыг тодорхойлоход ашиглагдана.
    
    for($i=0;$i<strlen($txt);$i++){
        
        $k++;
        
        $buf .= $txt{$i};
        if(ord($txt{$i})>207 && ord($txt{$i})<212){ //крилл үсэг үсэг байх тохиолдолд хийх үйлдэл
            $i++;
            $buf .= $txt{$i};
        }
        if($k>=$limit){ //авах үсгийн хязгаарт хүрмэгч зогсоно
            return $buf;
        }
    }
    return $buf;
} 

function mbmRSSecho($str=''){
		
	$replace1 = array(0=>'&',1=>'#',2=>'<',3=>'>',4=>'"');	
	$replace2 = array(0=>'&amp;',1=>'&ne;',2=>'&lt;',3=>'&gt;',4=>'&quot;');
	
	$txt = str_replace($replace1,$replace2,$str);
	
	return $txt;
}

function mbmUnRSSecho($str=''){
		
	$replace1 = array(0=>'&',1=>'#',2=>'<',3=>'>',4=>'"');	
	$replace2 = array(0=>'&amp;',1=>'&ne;',2=>'&lt;',3=>'&gt;',4=>'&quot;');
	
	$txt = str_replace($replace2,$replace1,$str);
	
	return $txt;
}
function mbmCleanUpForXML($str=''){
	$array[0] = array('&','<','#','№');
	$array[1] = array('&amp;','&lt;','&Dagger;','&Dagger;');
	return str_replace($array[0],$array[1],$str);
}
function mbmKharAduutBoldTextarea($field_id = ''){

	$buf = '<script type="text/javascript">K2.Bolgoodoh(document.getElementById("'.$field_id.'"));</script>';
	
	return $buf;
}

function mbmToggleImage($onclick_action='',$type="up"){
	
	if($type == 'up'){
		$toggle_default_img = INCLUDE_DOMAIN.'images/toggleup.png';
	}else{
		$toggle_default_img = INCLUDE_DOMAIN.'images/toggledown.png';
	}
		
	$toggle_up_img = INCLUDE_DOMAIN.'images/toggleup.png';
	$toggle_down_img = INCLUDE_DOMAIN.'images/toggledown.png';
		
	$buf = '<img alt="toggle" src="'.$toggle_default_img.'" border="0" width="15" style="cursor:pointer" 
				onclick="'.$onclick_action.';$(this).show(function(){ 
				   if($(this).attr(\'src\')==\''.$toggle_up_img.'\'){
					  $(this).attr({src:\'/'.$toggle_down_img.'\',title: \'expand\'});
					 }else {
						 $(this).attr({src:\''.$toggle_up_img.'\',title: \'close\'});
					  }
					if($(this).attr(\'src\').substr(0,1) == \'/\'){
						thisSRC = $(this).attr(\'src\').substr(1);
					}else{
						thisSRC = $(this).attr(\'src\');
					}
					$(this).attr({src:thisSRC});
					});" align="right" />';
	return $buf;
}
?>