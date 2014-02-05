<h3><?=mbmShowByLang(array('mn'=>'Холбоо барих','en'=>'Contact us'))?></h3>

<?
echo mbmShowContents(array('','','',''),MENU_ID,array(
												   'show_briefInfo'=>0
												   ));
if(isset($_POST['name'])){
	
	$content = 'Phone : '.$_POST['phone'].'<br />';
	$content .= $_POST['comment'];
	
	
	$email_content = $content;
	$body  = $email_content;

		// Plain text body (for mail clients that cannot read HTML)
		$text_body  = '*************************************************************************'
					.mbmCleanUpHTML($email_content);
	
		$PHPMAILER->From = $_POST['email'];
		$PHPMAILER->FromName = $_POST['email'];
		$PHPMAILER->Subject = $_POST['subject'];
		
		$PHPMAILER->Body    = $body;
		//$PHPMAILER->AltBody = $text_body;
		$PHPMAILER->AddAddress("info@most.mn", 'MOST PSP');
		//$PHPMAILER->AddAddress("m.batmunkh@yahoo.com", 'MOST PSP');
	
		$PHPMAILER->ContentType = 'text/html';
		//$PHPMAILER->IsHTML(true);    
		if(!$PHPMAILER->Send()){
			$result_txt = 'Ямар нэгэн алдаа гарлаа. Дахин оролдоно уу';
		}else{
			$result_txt = mbmShowByLang(array('mn'=>'Таны мэйлийг хүлээн авлаа. Бид удахгүй тантай холбогдох болно.','en'=>'Thank you for contacting us. We will reply soon.'));
			$b = 1;
		}
		// Clear all addresses and attachments for next loop
		$PHPMAILER->ClearAddresses();
		$PHPMAILER->ClearAttachments();
		echo mbmError($result_txt);
}
if($b!=1){
?>
<form id="contactForm" name="contactForm" method="post" action="">
  
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="150"><?=mbmShowByLang(array('mn'=>'Таны нэр','en'=>'Name'))?>:</td>
        <td><input name="name" type="text" id="name" size="45" /></td>
      </tr>
      <tr>
        <td><?=mbmShowByLang(array('mn'=>'Имэйл хаяг','en'=>'Email'))?>:</td>
        <td><input name="email" type="text" id="email" size="45" /></td>
      </tr>
      <tr>
        <td><?=mbmShowByLang(array('mn'=>'Утасны дугаар','en'=>'Phone'))?>:</td>
        <td><input name="phone" type="text" id="phone" size="45" /></td>
      </tr>
      <tr>
        <td><?=mbmShowByLang(array('mn'=>'Гарчиг','en'=>'Subject'))?>:</td>
        <td><input name="subject" type="text" id="subject" size="45" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><textarea name="comment" cols="42" rows="5" id="comment" class="textarea"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
        <input type="submit" value="<?=mbmShowByLang(array('mn'=>'Илгээх','en'=>'Send'))?>"  />&nbsp;&nbsp;
        <input type="reset" value="<?=mbmShowByLang(array('mn'=>'Болих','en'=>'Reset'))?>"  />
        </td>
      </tr>
    </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
<?
}
?>