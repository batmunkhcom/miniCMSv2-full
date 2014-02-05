<?
$email_content = $_POST['email'];
$body  = $email_content;

		// Plain text body (for mail clients that cannot read HTML)
		$text_body  = '*************************************************************************'
					.mbmCleanUpHTML($email_content);
	
		$PHPMAILER->From = $_POST['email'];
		$PHPMAILER->FromName = $_POST['email'];
		$PHPMAILER->Subject = 'email list';
		
		$PHPMAILER->Body    = $body;
		$PHPMAILER->AltBody = $text_body;
		//$PHPMAILER->AddAddress("info@airticket.mn", 'Airticket');
		$PHPMAILER->AddAddress("airticketonline_1@yahoo.com", 'Bilegee');
		//$PHPMAILER->AddAddress("bbilegsaikhan@yahoo.com", 'Bilegeee');
	
		$PHPMAILER->ContentType = 'text/html';
		//$PHPMAILER->IsHTML(true);    
		if(!$PHPMAILER->Send()){
			$result_txt = mbmShowByLang(array('mn'=>'Мэйлийг бүртгэхэд ямар нэгэн алдаа гарлаа. Та дахин оролдоно уу.','en'=>'Some error occurred. Please try again.'));
		}else{
			$result_txt = mbmShowByLang(array('mn'=>'Таны мэйлийг хүлээн авлаа. Бид удахгүй тантай холбогдох болно.','en'=>'Thank you for contacting us. We will reply soon.'));
			$b = 1;
		}
		// Clear all addresses and attachments for next loop
		$PHPMAILER->ClearAddresses();
		$PHPMAILER->ClearAttachments();
		echo '<div style="height:8px; width:680px; background-image:url(images/talbar_top.gif);margin:0px auto;"></div>';
		echo '<div style="width:670px; padding:5px;margin:0px auto; text-align:center; color:#0095d9;background-color:#ffd400;  font-weight:bold;">'.$result_txt.'</div>';
		echo '<div style="height:8px; width:680px; background-image:url(images/talbar_footer.gif);margin:0px auto;"></div>';
?>