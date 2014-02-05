<?
function mbmFAQsForm($input_size=20,$var=array(
											   'show_answers'=>1
											   )){
	global $DB,$lang;
	$buf = '';
	
	$buf .= '<div id="faqsTitle">'.$lang["faqs"]["ask_question"].'</div><a name="faq_form"></a>';
	$buf .= '<form action="" method="POST" name="FAQsForm" id="FAQsForm">';
		$buf .= '<div>';
		$buf .= '<input type="text" class="input_faqs" name="faqs_name" id="faqs_name" size="'.$input_size.'" /> *'.$lang["faqs"]["faqs_name"];
		$buf .= '</div>';
		$buf .= '<div>';
		$buf .= '<input type="text" class="input_faqs" name="faqs_email" id="faqs_email" size="'.$input_size.'" /> *'.$lang["faqs"]["faqs_email"];
		$buf .= '</div>';
		$buf .= '<div>';
		$buf .= '<textarea type="text" class="textarea_faqs" cols="'.($input_size+5).'" rows="5" name="faqs_content" id="faqs_content" >';
		$buf .= $lang["faqs"]["question_here"];
		$buf .= '</textarea>*';
		$buf .= '</div>';
		$buf .= '<div id="Krilleer" style="margin-bottom:12px;"></div>';
		$buf .= '<div>';
		$buf .= '<input type="submit" name="faqs_button" id="faqs_button" class="button_faqs" value="'.$lang["faqs"]["button_send_question"].'" />';
		$buf .= '</div>';
	$buf .= '</form>';
	$buf .= '<div id="faqsLoading" style="display:block;"><img src="'.DOMAIN.DIR.'/images/loading.gif" border="0" /></div>';
	if($var['show_answers'] !=0 ) $buf .= '<div id="faqsResult" style="display:block;"></div>';
	$buf .= mbmKharAduutBoldTextarea('faqs_content');
	
	return $buf;
}

function mbmFAQsLastQuestions($limit=5,$answered=0){
	global $DB,$lang;
	
	$buf = '';
	$q = "SELECT * FROM ".PREFIX."faqs WHERE lang='".$_SESSION['ln']."' ";
	if($answered==1){
		$q .= "AND total_updated>0 ";
	}
	$q .= "ORDER BY id DESC";
	$r = $DB->mbm_query($q);
	
	if($limit>$DB->mbm_num_rows($r)){
		$limit = $DB->mbm_num_rows($r);
	}
	if($_GET['cmd']=='list'){
		if((START+PER_PAGE_FAQS) > $DB->mbm_num_rows($r)){
			$limit= $DB->mbm_num_rows($r);
		}else{
			$limit= START+PER_PAGE_FAQS; 
		}
	}
	$buf .= '<div id="FAQsList">';
	for($i=START;$i<$limit;$i++){
		if(($i%2)==0){
			$bgcolor = '#f5f5f5';
		}else{
			$bgcolor = '#f9f9f9';
		}
			$buf .= '<div class="faqsQuestion" ';
			if($_GET['cmd']=='list'){
				$buf .= 'onclick="mbmToggleDisplay(\'FAQsAnswer'.$DB->mbm_result($r,$i,"id").'\')" ';
				$buf .= 'style="cursor:pointer;" ';
			}
			$buf .= '>';
				$buf .= '<strong>'.($i+1).'. '.str_replace("<","&lt;",$DB->mbm_result($r,$i,"question")).'</strong>';
			$buf .= '</div>';
			$buf .= '<span> ['.mbmTimeConverter($DB->mbm_result($r,$i,"date_added")).']</span>';
			$buf .= '<div class="faqsAnswer">';
				if($_GET['cmd']=='list'){
					$buf .= '<div id="FAQsAnswer'.$DB->mbm_result($r,$i,"id").'" style="display:none;">';
					if($DB->mbm_result($r,$i,"total_updated")==0){
						$buf .= $lang["faqs"]["no_answer"];
					}else{
						$buf .= $DB->mbm_result($r,$i,"answer");
					}
					$buf .= '<span style="color:#cccccc;"> ['.mbmTimeConverter($DB->mbm_result($r,$i,"date_lastupdated")).']</span>';
					$buf .= '</div>';
				}else{
					$buf .= str_replace("<","&lt;",$DB->mbm_result($r,$i,"answer"));
				}
			$buf .= '</div>';
	}
	$buf .= '</div>';
	if($_GET['cmd']!='list'){
		$buf .= '<div id="faqsMore"><a href="index.php?module=faqs&amp;cmd=list">'.$lang["faqs"]["all_questions"].'</a></div>';
	}else{
		$buf .= mbmNextPrev(DOMAIN.DIR.'index.php?module=faqs&amp;cmd=list',$DB->mbm_num_rows($r),START,PER_PAGE_FAQS);
	}

	return $buf;
}
?>