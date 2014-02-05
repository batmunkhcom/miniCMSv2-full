<script language="javascript">

function checkForm(){
	el = document.getElementById('bookingAir');
	txt = '';
	
	if(el.haanaas.value == '' || el.haanaas.value == 'Хаанаас'){
		alert( '<?=mbmShowByLang(array('mn'=>'Хаанаас нисэх чиглэлээ оруулна уу','en'=>'Please select departure city'))?>');
		//el.haanaas.style.border="1px solid #FF0000";
		return false;
	}else if(el.haashaa.value == '' || el.haashaa.value == 'Хаашаа'){
		alert( '<?=mbmShowByLang(array('mn'=>'Хаашаа нисэх чиглэлээ оруулна уу','en'=>'Please select destination city'))?>');
		//el.haanaas.style.border="1px solid #333";
		//el.haashaa.style.border="1px solid #FF0000";
		return false;
	}else if(el.surname.value == ''){
		alert( '<?=mbmShowByLang(array('mn'=>'Овгоо оруулна уу','en'=>'Your surname please!'))?>');
		//el.haashaa.style.border="1px solid #333";
		return false;
	}else if(el.name.value == ''){
		alert( '<?=mbmShowByLang(array('mn'=>'Нэрээ оруулна уу','en'=>'Your name please!'))?>');
		return false;
	}else if(el.email.value == ''){
		alert( '<?=mbmShowByLang(array('mn'=>'Имэйл хаягаа оруулна уу','en'=>'Please enter your e-mail address!'))?>');
		return false;
	}else if(el.mobile.value == ''){
		alert( '<?=mbmShowByLang(array('mn'=>'Гар утасны дугаараа оруулна уу','en'=>'Please enter your mobile number!'))?>');
		return false;
	}else{
		el.submit();
	}
	
	
	/*else if(el.work_phone.value == ''){
		alert( 'Ажлын утасны дугаараа оруулна уу');
		return false;
	}else if(el.home_phone.value == ''){
		alert( 'Гэрийн утасны дугаараа оруулна уу');
		return false;
	}*/
}
function toggleDate(st){
	el = document.getElementById('bookingAir');
	switch(st){
		case 0:
			el.date_tocome_Year_ID.disabled=true;
			el.date_tocome_Month_ID.disabled=true;
			el.date_tocome_Day_ID.disabled=true;
		break;
		case 1:
			el.date_tocome_Year_ID.disabled=false;
			el.date_tocome_Month_ID.disabled=false;
			el.date_tocome_Day_ID.disabled=false;
		break;
	}
}
</script>

<div style="padding-left:40px;">
  <?
if(isset($_POST['comments'])){
	
$email_content = '<div style="width:520px;">';	
$email_content .= '<center><img src="http://www.airticket.mn/images/email_top.gif" vspace="5" /></center>';
$email_content .= '<div style="display:block; text-align:right; margin:10px;"></div>';
$email_content .= '<table border="0" align="center" cellpadding="3" cellspacing="2" style="border-collapse:collapse;width:500px;" width="500">
  <tr>
    <td>№: <span style="border:1px solid #DDD; width:150px; padding:3px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
    <td align="right">Хүлээн авсан огноо: <span style="border:1px solid #DDD; width:150px; padding:3px;">'.date("Y-m-d H:i:s").'</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="180">1.Овог</td>
    <td style="border:1px solid #DDD;">'.$_POST['surname'].'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>2.Нэр</td>
    <td style="border:1px solid #DDD;">'.$_POST['name'].'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>3.Хаанаас</td>
    <td style="border:1px solid #DDD;">'.$_POST['haanaas'].'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>4.Хаашаа</td>
    <td style="border:1px solid #DDD;">'.$_POST['haashaa'].'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
		<table border="0" align="center" cellpadding="3" cellspacing="2" width="100%" >
			<tr>
				<td width="180">5.Нэг талдаа</td>
				<td width="80" style="border:1px solid #DDD;">&nbsp;';
				if($_POST['helber'] == 1) $email_content .= 'Тийм';
				$email_content .= '</td>
			    <td align="center">6.Хоёр талдаа </td>
				<td style="border:1px solid #DDD;" width="80">&nbsp;';
				if($_POST['helber'] == 2 ) $email_content .=  'Тийм';
				$email_content .= '</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
		<table border="0" align="center" cellpadding="3" cellspacing="2" width="100%" >
			<tr>
				<td height="40" width="180">7.Явах өдөр </td>
				<td width="100" style="border:1px solid #DDD;">'.$_POST['date_tofly1'].'</td>
			    <td width="100" align="center">8.Ирэх өдөр  </td>';
				if($_POST['helber'] == 2){
					$email_content .= '
					<td style="border:1px solid #DDD;">'.$_POST['date_tocome1'].'</td>';
				}else{
					$email_content .= '<td>-</td>';
				}
				$email_content .= '
			</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>9.Хуваарийн төлөв</td>
    <td style="border:1px solid #DDD;">'.$_POST['todorhoigui'].'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>10.Зорчигчийн тоо</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="120">Том хүн :</td>
        <td style="border:1px solid #DDD;">'.$_POST['niit_tomhun'].'</td>
      </tr>
      <tr>
        <td>2-12 настай:</td>
        <td style="border:1px solid #DDD;"> '.$_POST['niit_huuhed'].'</td>
      </tr>
      <tr>
        <td>0-2 настай: </td>
        <td style="border:1px solid #DDD;">'.$_POST['niit_nyalkh'].'</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>11.Авиа компани</td>
    <td style="border:1px solid #DDD;">'.$_POST['airlines'].'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>12.Ангилал</td>
    <td style="border:1px solid #DDD;">'.$_POST['classes'].'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>13.Холбоо барих хаяг</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="1">
      <tr>
        <td width="100">Мэйл хаяг: </td>
        <td style="border:1px solid #DDD;">'.$_POST['email'].'&nbsp;</td>
      </tr>
      <tr>
        <td>Гар утас : </td>
        <td style="border:1px solid #DDD;">'.$_POST['mobile'].'&nbsp;</td>
      </tr>
      <tr>
        <td>Ажлын утас :</td>
        <td style="border:1px solid #DDD;">'.$_POST['work_phone'].'&nbsp;</td>
      </tr>
      <tr>
        <td>Гэрийн утас</td>
        <td style="border:1px solid #DDD;">'.$_POST['home_phone'].'&nbsp;</td>
      </tr>
      <tr>
        <td>Факс</td>
        <td style="border:1px solid #DDD;">'.$_POST['fax'].'&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" height="100">14.Санал хүсэлт</td>
    <td valign="top" style="border:1px solid #DDD;">'.$_POST['comments'].'&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>';
$email_content .= '<center><img src="http://www.airticket.mn/images/email_footer.gif" vspace="5" /></center>';
$email_content .= '</div>';


		/*
		if(mbmSendEmail($_POST['name'].'|'.$_POST['email'],'M.Batmunkh|m.batmunkh@yahoo.com','hi. test',$email_content) == 1){
			$result_txt = 'Таны захиалгыг хүлээн авлаа. Бид удахгүй таньтай холбогдох болно.';
			$b = 1;
		}else{
			$result_txt = "Захиалгыг илгээхэд ямар нэгэн алдаа гарлаа. Та дахин оролдоно уу.";
		}
		*/
		$body  = $email_content;
	
		// Plain text body (for mail clients that cannot read HTML)
		$text_body  = '*************************************************************************'
					.mbmCleanUpHTML($email_content);
	
		$PHPMAILER->From = $_POST['email'];
		$PHPMAILER->FromName = $_POST['name'];
		$PHPMAILER->Subject = 'online zahialga';
		
		$PHPMAILER->Body    = $body;
		//$PHPMAILER->AltBody = $text_body;
		$PHPMAILER->AddAddress("airtiiz@yahoo.com", 'Airticket');
		$PHPMAILER->AddAddress("bilegsaikhan@airticket.mn", 'Airticket');
		$PHPMAILER->AddAddress("airticketonline_1@yahoo.com", 'Bilegee');
		$PHPMAILER->AddAddress("info@airticket.mn", 'Airticket');
		//$PHPMAILER->AddAddress("bilegsaikhan@eznis.com", 'Airticket');
		//$PHPMAILER->AddAddress("m.batmunkh@yahoo.com", 'Airticket');
		//$PHPMAILER->AddAddress("info@yadii.net", 'Airticket');
		//$PHPMAILER->AddAddress("admin@mng.cc", 'Airticket');
		//$PHPMAILER->AddAddress("bbilegsaikhan@yahoo.com", 'Bilegeee');
	
		$PHPMAILER->ContentType = 'text/html';
		$PHPMAILER->IsHTML(true);     
		if(!$PHPMAILER->Send()){
			$result_txt = mbmShowByLang(array('mn'=>"Захиалгыг илгээхэд ямар нэгэн алдаа гарлаа. Та дахин оролдоно уу.",'en'=>'Some error occurred. Please try again'));
		}else{
			$result_txt = mbmShowByLang(array('mn'=>'Таны захиалгыг хүлээн авлаа. Бид удахгүй тантай холбогдох болно.<br />
							Манай компанийг сонгон үйлчлүүлж байгаа танд баярлалаа!','en'=>'We have received your reservation.We will contact you very soon.
Thank you for choosing our company !'));
			$b = 1;
		}
		// Clear all addresses and attachments for next loop
		$PHPMAILER->ClearAddresses();
		$PHPMAILER->ClearAttachments();
		echo '<div style="height:8px; width:680px; background-image:url(images/talbar_top.gif);margin:0px auto;"></div>';
		echo '<div style="width:670px; padding:5px;margin:0px auto; text-align:center; color:#0095d9;background-color:#ffd400;  font-weight:bold;">'.$result_txt.'</div>';
		echo '<div style="height:8px; width:680px; background-image:url(images/talbar_footer.gif);margin:0px auto;"></div>';
		//echo mbmError($result_txt);
		/*
		echo $email_content;
		*/
		
}
if($b!=1){

echo mbmShowContents(array('','','',''),mbmShowByLang(array('mn'=>'392','en'=>'406')),array(
												   'show_briefInfo'=>1
												   ));
?>
  <form id="bookingAir" name="bookingAir" method="post" action="" onsubmit="checkForm();return false;"><h3>1. <?=mbmShowByLang(array('mn'=>'Нислэгийн мэдээлэл','en'=>'Flight information'))?></h3>
  <table width="80%" border="0" align="center" cellpadding="3" cellspacing="2">
    <tr>
      <td width="155"><strong><?=mbmShowByLang(array('mn'=>'Хаанаас','en'=>'From'))?></strong></td>
      <td><span style="margin:0px;">
        <input name="haanaas" type="text" id="haanaas" value="<?
        if(isset($_POST['haanaas'])) echo $_POST['haanaas'];
		else echo mbmShowByLang(array('mn'=>'Хаанаас','en'=>'From'));
		?>" size="32" onfocus="if(this.value=='<?=mbmShowByLang(array('mn'=>'Хаанаас','en'=>'From'))?>') this.value=''" />
      *</span></td>
    </tr>
    <tr>
      <td><strong><?=mbmShowByLang(array('mn'=>'Хаашаа','en'=>'To'))?></strong></td>
      <td><span style="margin:0px;">
        <input name="haashaa" type="text" id="haashaa" value="<?
        if(isset($_POST['haashaa'])) echo $_POST['haashaa'];
		else echo mbmShowByLang(array('mn'=>'Хаашаа','en'=>'To'));
		?>" size="32" onfocus="if(this.value=='<?=mbmShowByLang(array('mn'=>'Хаашаа','en'=>'To'))?>') this.value=''" />
      *</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><span style="margin:0px;">
        <input name="helber" type="radio" id="helber" value="2" checked="checked" onclick="toggleDate1(1,'#butsah2');" />
        <?=mbmShowByLang(array('mn'=>'Хоёр тал','en'=>'Round trip'))?>
        <input type="radio" name="helber" id="helber2" value="1" onclick="toggleDate1(0,'#butsah2');" <?
        if($_POST['helber'] == '1') {
			echo ' checked="checked" ';
			$bbbbbbbbbb = '<script>setTimeOut("toggleDate1(0,\'#butsah2\')",4000);</script>';
		}
		?> />
        <?=mbmShowByLang(array('mn'=>'Нэг тал','en'=>'One way'))?></span></td>
    </tr>
    <tr>
      <td><strong><?=mbmShowByLang(array('mn'=>'Нисэх өдөр','en'=>'Departure date'))?></strong></td>
      <td><script>
					  DateInput('date_tofly1', true, 'YYYY-MM-DD' <?
								if($_POST['date_tofly']) echo ',\''.$_POST['date_tofly'].'\'';
								elseif($_POST['date_tofly1']) echo ',\''.$_POST['date_tofly1'].'\'';
								?>);
				    </script></td>
    </tr>
    <tr>
      <td><strong><?=mbmShowByLang(array('mn'=>'Буцаж ирэх','en'=>'Return date'))?></strong></td>
      <td>
        <div id="butsah2">
        <script>
					  DateInput('date_tocome1', true, 'YYYY-MM-DD' <?
								if($_POST['date_tocome']) echo ',\''.$_POST['date_tocome'].'\'';
								elseif($_POST['date_tocome1']) echo ',\''.$_POST['date_tocome1'].'\'';
								?>);
				  </script>
        </div>
        </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><span style="margin:0px;">
        <input name="todorhoigui" type="radio" id="helber3" value="<?=mbmShowByLang(array('mn'=>'Дээрхи хуваарь өөрчлөгдөнө','en'=>'Schedule will be changed'))?>" />
        <?=mbmShowByLang(array('mn'=>'Дээрхи хуваарь өөрчлөгдөнө','en'=>'Schedule will be changed'))?>
  <input name="todorhoigui" type="radio" id="helber4" value="<?=mbmShowByLang(array('mn'=>'Дээрхи хуваарь зөв','en'=>'Schedule is correct'))?>" checked="CHECKED" <?
        if($_POST['helber'] == '1') echo ' checked="checked"';
		?> /> 
        <?=mbmShowByLang(array('mn'=>'Дээрхи хуваарь зөв','en'=>'Schedule is correct'))?>
  </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top"><strong><?=mbmShowByLang(array('mn'=>'Зорчигчийн тоо','en'=>'Number of passengers'))?></strong></td>
      <td valign="top">
      	<strong><?=mbmShowByLang(array('mn'=>'Том хүн','en'=>'Adults'))?></strong>
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="100"> <?=mbmShowByLang(array('mn'=>'Том хүн','en'=>'Adults'))?> (12+):</td>
    <td><select name="niit_tomhun" id="niit_tomhun">
      <?= mbmIntegerOptions(1, 10,$_POST['niit_tomhun']); ?>
      </select></td>
    </tr>
</table>
        <br clear="all" />
        <strong><?=mbmShowByLang(array('mn'=>'Хүүхэд','en'=>'Child & Infant'))?></strong>
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="100"><?=mbmShowByLang(array('mn'=>'0-2 настай','en'=>'Infant'))?> : </td>
    <td><select name="niit_nyalkh" id="niit_nyalkh">
      <?= mbmIntegerOptions(0, 10,$_POST['niit_nyalkh']); ?>
      </select></td>
    </tr>
  <tr>
    <td><?=mbmShowByLang(array('mn'=>'2-12 настай','en'=>'Child'))?>:</td>
    <td><select name="niit_huuhed" id="niit_huuhed">
      <?= mbmIntegerOptions(0, 10,$_POST['niit_huuhed']); ?>
      </select></td>
    </tr>
</table></td>
    </tr>
    <tr>
      <td><strong><?=mbmShowByLang(array('mn'=>'Авиа компани','en'=>'Airline'))?></strong></td>
      <td><select name="airlines">
                                                        <option value="сонгоогүй"><?=mbmShowByLang(array('mn'=>'Авиа компаниа сонгоно уу','en'=>'Please select an airline'))?></option>

                            <option value="1">OM / MIAT Mongolian Airlines</option>
<option >KE   / Korean Air</option>
<option>CA / Air China</option>
<option >UA / United Airlines</option>
<option >SU / Aeroflot</option>
<option >Any Airlines</option>
                    </select></td>
    </tr>
    <tr>
      <td><strong><?=mbmShowByLang(array('mn'=>'Зэрэглэл','en'=>'Class of service'))?></strong></td>
      <td><select name="classes">
      		<option value=""><?=mbmShowByLang(array('mn'=>'Зэрэглэлээ сонгоно уу','en'=>'Please select a class'))?></option>
            <option value="Энгийн / Economy"><?=mbmShowByLang(array('mn'=>'Энгийн','en'=>'Economy'))?> </option>
            <option value="Бизнес / Business"><?=mbmShowByLang(array('mn'=>'Бизнес','en'=>'Business'))?> </option>
            <option value="1-p зэрэглэл / First"><?=mbmShowByLang(array('mn'=>'1-p зэрэглэл','en'=>'First'))?> </option>
          </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </table><h3>2. <?=mbmShowByLang(array('mn'=>'Зорчигчийн мэдээлэл','en'=>'Passenger information'))?></h3>
    <table width="80%" border="0" align="center" cellpadding="3" cellspacing="2">
    <tr>
      <td width="150"><strong><?=mbmShowByLang(array('mn'=>'Овог','en'=>'Surname'))?></strong></td>
      <td><input name="surname" type="text" id="surname" size="30" value="<?
      if(isset($_POST['surname'])) echo addslashes($_POST['surname']);
	  ?>" />
      *</td>
    </tr>
    <tr>
      <td><strong><?=mbmShowByLang(array('mn'=>'Нэр','en'=>'Name'))?></strong></td>
      <td><input name="name" type="text" id="name" size="30" value="<?
      if(isset($_POST['name'])) echo addslashes($_POST['name']);
	  ?>" />
      *</td>
    </tr>
        <tr>
          <td><strong><?=mbmShowByLang(array('mn'=>'Мэйл хаяг','en'=>'Email'))?></strong></td>
          <td><input name="email" type="text" id="email" size="30" />
          *</td>
        </tr>
        <tr>
          <td><strong><?=mbmShowByLang(array('mn'=>'Гар утас','en'=>'Mobile'))?></strong></td>
          <td><input name="mobile" type="text" id="mobile" size="30" />
          *</td>
        </tr>
        <tr>
          <td><strong> <?=mbmShowByLang(array('mn'=>'Ажлын утас','en'=>'Office Tel.'))?></strong></td>
          <td><input name="work_phone" type="text" id="work_phone" size="30" /></td>
        </tr>
        <tr>
          <td><strong><?=mbmShowByLang(array('mn'=>'Гэрийн утас','en'=>'Home Tel.'))?></strong></td>
          <td><input name="home_phone" type="text" id="home_phone" size="30" /></td>
        </tr>
        <tr>
          <td><strong><?=mbmShowByLang(array('mn'=>'Факс','en'=>'Fax'))?></strong></td>
          <td><input name="fax" type="text" id="fax" size="30" /></td>
        </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </table><h3>3. <?=mbmShowByLang(array('mn'=>'Санал хүсэлт','en'=>'Suggestions & comments'))?></h3>
    <table width="80%" border="0" align="center" cellpadding="3" cellspacing="2">
    <tr>
      <td width="150" valign="top"></td>
      <td valign="top"><textarea name="comments" cols="45" rows="5" id="comments"></textarea></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">
      <img src="templates/airticketmn/images/<?=mbmShowByLang(array('mn'=>'flight_button_mn.jpg','en'=>'flight_button_en.jpg'))?>" onclick="checkForm();" hspace="5" style="cursor:pointer;" />
      <!-- <input type="submit" name="send" id="send" value="<?=mbmShowByLang(array('mn'=>'Нислэг захиалах','en'=>'Book flight'))?>" class="zakhialakhButton" /> //--></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    </table>
</form>
<?
}
?>
</div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          