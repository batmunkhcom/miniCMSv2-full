<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%"><?=mbmShowBanner('contact_'.$_SESSION['ln'])?></td>
    <td width="50%">
    
<h3><?=mbmShowByLang(array('mn'=>'Сэтгэгдэл илгээх','en'=>'Suggesstions & comments'))?></h3>
<?

if(isset($_POST['sendF'])){
	
	$content = '';
	$content .= $_POST['comment'];
	
	
	$email_content = $content;
$body  = $email_content;

		// Plain text body (for mail clients that cannot read HTML)
		$text_body  = '*************************************************************************'
					.mbmCleanUpHTML($email_content);
	
		$PHPMAILER->From = $_POST['email'];
		$PHPMAILER->FromName = $_POST['email'];
		$PHPMAILER->Subject = $_POST['name'].' - sanal setgegdel';
		
		$PHPMAILER->Body    = $body;
		//$PHPMAILER->AltBody = $text_body;
		$PHPMAILER->AddAddress("bilegsaikhan@airticket.mn", 'Bill');
		$PHPMAILER->AddAddress("info@airticket.mn", 'Info airticket');
		$PHPMAILER->AddAddress("ceo@silkroad.mn", 'CEO');
	
		$PHPMAILER->ContentType = 'text/html';
		//$PHPMAILER->IsHTML(true);    
		if(!$PHPMAILER->Send()){
			$result_txt = "Илгээлээ";
		}else{
			$result_txt = 'Ямар нэгэн алдаа гарлаа. Дахин оролдоно уу';
			$b = 1;
		}
		// Clear all addresses and attachments for next loop
		$PHPMAILER->ClearAddresses();
		$PHPMAILER->ClearAttachments();
		echo '<div style="height:8px; width:680px; background-image:url(images/talbar_top.gif);margin:0px auto;"></div>';
		echo '<div style="width:670px; padding:5px;margin:0px auto; text-align:center; color:#0095d9;background-color:#ffd400;  font-weight:bold;">'.$result_txt.'</div>';
		echo '<div style="height:8px; width:680px; background-image:url(images/talbar_footer.gif);margin:0px auto;"></div>';
	
	
	echo mbmError($result_txt);
}
if($b!=1){
?>
<form id="contactForm" name="contactForm" method="post" action="">
  <h3>
    <input name="name" type="text" id="name" size="45" />
    <?=mbmShowByLang(array('mn'=>'Нэр','en'=>'Name'))?></h3>
  <h3>
    <input name="email" type="text" id="email" size="45" />
    <?=mbmShowByLang(array('mn'=>'Мэйл','en'=>'Email'))?></h3>
  <p>
    <textarea name="comment" cols="42" rows="5" id="comment" class="textarea"></textarea>
  </p>
  <p>
  <img src="templates/airticketmn/images/<?=mbmShowByLang(array('mn'=>'button_send_mn.jpg','en'=>'button_send_en.jpg'))?>" onclick="document.contactForm.submit()" style="cursor:pointer; margin-left:-4px; margin-top:-2px;" />
  </p>
</form>
<?
}
?>
<br clear="all" />
    </td>
  </tr>
</table>