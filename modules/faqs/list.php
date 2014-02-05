<?

if($mBm!=1){

	echo ('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');

}else{
	echo '<h2>'.$lang["faqs"]["faqs_title"].'</h2>';
	echo mbmFAQsForm(45,array('show_answers'=>0));
	echo mbmFAQsLastQuestions(PER_PAGE_FAQS,1);
}

?>
