<div class="contentTitle">Горилогчийн анкет</div>
<?
if(isset($_POST['Urgiin_Ovog'])){
	$content = '';
	foreach($_POST as $k=>$v){
		$content .= $k.'-'.$v."<br />";
	}
	if(mbmSendEmail($_POST['Ner'].'|'.$_POST['Email'],'Uyanga|uyanga@most.mn','anket',$content) == 1){
		$result_txt = 'Илгээв';
		$b = 1;
	}else{
		$result_txt = 'Илгээж чадсангүй. Та дахин оролдоно уу.';
	}
	echo mbmError($result_txt);
	//mail('uyanga@most.mn','anket',$content);
}
if($b !=1){
?>
<div style="width:660px; overflow-x:auto;">
<form name="form1" method="post" action="" enctype="application/x-www-form-urlencoded">
<h4>Хавсаргах файлууд</h4>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td width="30%">Таны зураг /JPG файл/</td>
    <td ><input type="file" name="Your_Photo" id="Your_Photo" class="anket_file"></td>
  </tr>
  <tr>
    <td>Дипломны хуулбар /JPG файл/</td>
    <td><input type="file" name="Diplom_Photo" id="Diplom_Photo" class="anket_file"></td>
  </tr>
  <tr>
    <td>Иргэний үнэмлэхний хуулбар /JPG файл/</td>
    <td><input type="file" name="Passport_Photo" id="Passport_Photo" class="anket_file"></td>
  </tr>
  <tr>
    <td>3н үеийн намтар /MS WORD файл/</td>
    <td><input type="file" name="Profile_Doc" id="Profile_Doc" class="anket_file"></td>
  </tr>
  </table>
<h4>А. Товч танилцуулга
  </h4>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="25%" valign="top">Ургийн овог</td>
      <td width="25%" valign="top"><input type="text" name="Urgiin_Ovog" id="Urgiin_Ovog" class="anket_input"></td>
      <td width="25%" valign="top">Эцэг /эх/-ийн нэр</td>
      <td width="25%" valign="top"><input type="text" name="Etsgiin_Ner" id="Etsgiin_Ner" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top">Нэр</td>
      <td valign="top"><input type="text" name="Ner" id="Ner" class="anket_input"></td>
      <td valign="top">Хүйс</td>
      <td valign="top"><input type="text" name="Huis" id="Huis" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top">Төрсөн огноо</td>
      <td valign="top"><input type="text" name="Birthday" id="Birthday" class="anket_input"></td>
      <td valign="top">Яс үндэс</td>
      <td valign="top"><input type="text" name="Yas_Undes" id="Yas_Undes" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top">Төрсөн аймаг (хот)</td>
      <td valign="top"><input type="text" name="Tursun_gazar" id="Tursun_gazar" class="anket_input"></td>
      <td valign="top">сум,дүүрэг</td>
      <td valign="top"><input type="text" name="Sum_Duureg" id="Sum_Duureg" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top">Регистрийн дугаар</td>
      <td valign="top"><input type="text" name="Register_Number" id="Register_Number" class="anket_input"></td>
      <td valign="top">Иргэний үнэмлэхний дугаар</td>
      <td valign="top"><input type="text" name="Passport_Id" id="Passport_Id" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top">Гэрийн хаяг</td>
      <td valign="top"><textarea name="Geriin_Hayag" rows="4" class="anket_textarea" id="Geriin_Hayag"></textarea></td>
      <td valign="top">Утас</td>
      <td valign="top"><input type="text" name="Phone1" id="Phone1" class="anket_input">
      <br>
      <input type="text" name="Phone2" id="Phone2" class="anket_input" />
      <br>
      <input type="text" name="Phone3" id="Phone3" class="anket_input" /></td>
    </tr>
    <tr>
      <td valign="top">E-mail хаяг</td>
      <td valign="top"><input type="text" name="Email" id="Email" class="anket_input"></td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
  </table>
  <h4>Б. Хүсч буй ажлын талаархи мэдээлэл </h4>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="40%" valign="top">Таны сонирхож буй ажил албан тушаал</td>
      <td widvalign="top"><input type="text" name="Sonirhoj_bui_Alban_tushaal" id="Sonirhoj_bui_Alban_tushaal" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top">Хүсч буй цалингийн дээд доод хязгаар</td>
      <td valign="top"><input type="text" name="Tsalingiin_Hemjee" id="Tsalingiin_Hemjee" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top">Хэзээ ажилд орох боломжтой вэ?</td>
      <td valign="top"><input type="text" name="Hezee_Ajild_oroh_bolomjtoi_ve" id="Hezee_Ajild_oroh_bolomjtoi_ve" class="anket_input"></td>
    </tr>
  </table>
  <h4>В. Боловсрол</h4>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td valign="top">Хаана, ямар сургууль</td>
      <td valign="top">Элссэн огноо</td>
      <td valign="top">Төгссөн огноо</td>
      <td valign="top">Эзэмшсэн мэргэжил, зэрэг</td>
      <td valign="top">Зэрэг хамгаалсан сэдэв</td>
      <td valign="top">Голч дүн</td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="haana_yamar_surguuli[]" id="haana_yamar_surguuli" class="anket_input" /></td>
      <td align="center" valign="top"><input name="elssen_ognoo[]" type="text" class="anket_input" id="elssen_ognoo" size="6"></td>
      <td align="center" valign="top"><input name="Tugssun_Ognoo[]" type="text" class="anket_input" id="Tugssun_Ognoo" size="6"></td>
      <td valign="top"><input type="text" name="Ezemshsen_Mergejil[]" id="Ezemshsen_Mergejil" class="anket_input"></td>
      <td valign="top"><input type="text" name="Zereg_Hamgaalsan_Sedev[]" id="Zereg_Hamgaalsan_Sedev" class="anket_input"></td>
      <td align="center" valign="top"><input name="Golch_Dun" type="text" class="anket_input" id="Golch_Dun[]" size="6"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="haana_yamar_surguuli[]" id="haana_yamar_surguuli" class="anket_input" /></td>
      <td align="center" valign="top"><input name="elssen_ognoo[]" type="text" class="anket_input" id="elssen_ognoo" size="6"></td>
      <td align="center" valign="top"><input name="Tugssun_Ognoo[]" type="text" class="anket_input" id="Tugssun_Ognoo" size="6"></td>
      <td valign="top"><input type="text" name="Ezemshsen_Mergejil[]" id="Ezemshsen_Mergejil" class="anket_input"></td>
      <td valign="top"><input type="text" name="Zereg_Hamgaalsan_Sedev[]" id="Zereg_Hamgaalsan_Sedev" class="anket_input"></td>
      <td align="center" valign="top"><input name="Golch_Dun" type="text" class="anket_input" id="Golch_Dun[]" size="6"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="haana_yamar_surguuli[]" id="haana_yamar_surguuli" class="anket_input" /></td>
      <td align="center" valign="top"><input name="elssen_ognoo[]" type="text" class="anket_input" id="elssen_ognoo" size="6"></td>
      <td align="center" valign="top"><input name="Tugssun_Ognoo[]" type="text" class="anket_input" id="Tugssun_Ognoo" size="6"></td>
      <td valign="top"><input type="text" name="Ezemshsen_Mergejil[]" id="Ezemshsen_Mergejil" class="anket_input"></td>
      <td valign="top"><input type="text" name="Zereg_Hamgaalsan_Sedev[]" id="Zereg_Hamgaalsan_Sedev" class="anket_input"></td>
      <td align="center" valign="top"><input name="Golch_Dun" type="text" class="anket_input" id="Golch_Dun[]" size="6"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="haana_yamar_surguuli[]" id="haana_yamar_surguuli" class="anket_input" /></td>
      <td align="center" valign="top"><input name="elssen_ognoo[]" type="text" class="anket_input" id="elssen_ognoo" size="6"></td>
      <td align="center" valign="top"><input name="Tugssun_Ognoo[]" type="text" class="anket_input" id="Tugssun_Ognoo" size="6"></td>
      <td valign="top"><input type="text" name="Ezemshsen_Mergejil[]" id="Ezemshsen_Mergejil" class="anket_input"></td>
      <td valign="top"><input type="text" name="Zereg_Hamgaalsan_Sedev[]" id="Zereg_Hamgaalsan_Sedev" class="anket_input"></td>
      <td align="center" valign="top"><input name="Golch_Dun" type="text" class="anket_input" id="Golch_Dun[]" size="6"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="haana_yamar_surguuli[]" id="haana_yamar_surguuli" class="anket_input" /></td>
      <td align="center" valign="top"><input name="elssen_ognoo[]" type="text" class="anket_input" id="elssen_ognoo" size="6"></td>
      <td align="center" valign="top"><input name="Tugssun_Ognoo[]" type="text" class="anket_input" id="Tugssun_Ognoo" size="6"></td>
      <td valign="top"><input type="text" name="Ezemshsen_Mergejil[]" id="Ezemshsen_Mergejil" class="anket_input"></td>
      <td valign="top"><input type="text" name="Zereg_Hamgaalsan_Sedev[]" id="Zereg_Hamgaalsan_Sedev" class="anket_input"></td>
      <td align="center" valign="top"><input name="Golch_Dun" type="text" class="anket_input" id="Golch_Dun[]" size="6"></td>
    </tr>
  </table>
  <br>
<br>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="25%" valign="top">Сургалтын сэдэв, курс дамжааны нэр</td>
      <td width="25%" valign="top">Сургалт зохион байгуулсан байгууллага</td>
      <td width="25%" valign="top">Сургалтын хугацаа</td>
      <td width="25%" valign="top">Үнэлгээ</td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Kurs_damjaanii_ner[]" id="Kurs_damjaanii_ner" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Baiguullaga[]" id="Surgaltiin_Baiguullaga" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Hugatsaa[]" id="Surgaltiin_Hugatsaa" class="anket_input"></td>
      <td valign="top"><input type="text" name="Unelgee" id="Unelgee[]" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Kurs_damjaanii_ner[]" id="Kurs_damjaanii_ner" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Baiguullaga[]" id="Surgaltiin_Baiguullaga" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Hugatsaa[]" id="Surgaltiin_Hugatsaa" class="anket_input"></td>
      <td valign="top"><input type="text" name="Unelgee" id="Unelgee[]" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Kurs_damjaanii_ner[]" id="Kurs_damjaanii_ner" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Baiguullaga[]" id="Surgaltiin_Baiguullaga" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Hugatsaa[]" id="Surgaltiin_Hugatsaa" class="anket_input"></td>
      <td valign="top"><input type="text" name="Unelgee" id="Unelgee[]" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Kurs_damjaanii_ner[]" id="Kurs_damjaanii_ner" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Baiguullaga[]" id="Surgaltiin_Baiguullaga" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Hugatsaa[]" id="Surgaltiin_Hugatsaa" class="anket_input"></td>
      <td valign="top"><input type="text" name="Unelgee" id="Unelgee[]" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Kurs_damjaanii_ner[]" id="Kurs_damjaanii_ner" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Baiguullaga[]" id="Surgaltiin_Baiguullaga" class="anket_input"></td>
      <td valign="top"><input type="text" name="Surgaltiin_Hugatsaa[]" id="Surgaltiin_Hugatsaa" class="anket_input"></td>
      <td valign="top"><input type="text" name="Unelgee" id="Unelgee[]" class="anket_input"></td>
    </tr>
  </table>
  <h4>Г. Гадаад хэлний мэдлэгийн түвшин /Түвшинг сонгоно уу/</h4>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="20%" valign="top">Гадаад хэлний нэр</td>
      <td width="20%" valign="top">Ярьсныг ойлгох
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" align="center">Сайн</td>
            <td width="33%" align="center">Дунд</td>
            <td width="33%" align="center">Муу</td>
          </tr>
      </table></td>
      <td width="20%" valign="top">Өөрөө ярих
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" align="center">Сайн</td>
            <td width="33%" align="center">Дунд</td>
            <td width="33%" align="center">Муу</td>
          </tr>
      </table></td>
      <td width="20%" valign="top">Бичиж орчуулах
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" align="center">Сайн</td>
            <td width="33%" align="center">Дунд</td>
            <td width="33%" align="center">Муу</td>
          </tr>
      </table></td>
      <td width="20%" valign="top">Уншиж ойлгох
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" align="center">Сайн</td>
            <td width="33%" align="center">Дунд</td>
            <td width="33%" align="center">Муу</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="hel[]" id="hel" class="anket_input"></td>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio" value="sain"></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio2" value="dund"></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio3" value="muu"></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio4" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio5" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio6" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio7" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio8" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio9" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio10" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio11" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio12" value="muu" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="hel" id="hel21" class="anket_input" /></td>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio13" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio14" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio15" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio16" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio17" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio18" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio19" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio20" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio21" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio22" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio23" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio24" value="muu" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="hel" id="hel22" class="anket_input" /></td>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio25" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio26" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio27" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio28" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio29" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio30" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio31" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio32" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio33" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio34" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio35" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio36" value="muu" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="hel" id="hel23" class="anket_input" /></td>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio37" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio38" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio39" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio40" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio41" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio42" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio43" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio44" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio45" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio46" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio47" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio48" value="muu" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="hel" id="hel24" class="anket_input" /></td>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio49" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio50" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio51" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio52" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio53" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio54" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio55" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio56" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio57" value="muu" /></td>
        </tr>
      </table></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio58" value="sain" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio59" value="dund" /></td>
          <td width="33%" align="center"><input type="radio" class="input_radio" name="radio[]" id="radio60" value="muu" /></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <h4>Д. Ажлын туршлага</h4>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td valign="top">Байгууллагын нэр</td>
      <td colspan="2" align="center" valign="top">Ажилласан хугацаа</td>
      <td valign="top">Ажил, албан тушаалын нэр</td>
      <td valign="top">Хийж гүйцэтгэж байсан ажил үүргүүд</td>
      <td valign="top">Ажлаас гарах болсон шалтгаан</td>
      <td valign="top">Авч байсан цалин</td>
    </tr>
    <tr>
      <td valign="top"><input name="Baiguullagiin_Ner[]" type="text" class="anket_input" id="hel8" size="15" /></td>
      <td align="center" valign="top"><input name="Orson_Ognoo[]" type="text" class="anket_input" id="hel6" size="6" /></td>
      <td align="center" valign="top"><input name="Garsan_Ognoo[]" type="text" class="anket_input" id="hel7" size="6" /></td>
      <td valign="top"><input name="Alban_Tushaal[]" type="text" class="anket_textarea" id="Alban_Tushaal[]" value="" size="20" /></td>
      <td valign="top"><textarea name="Guitsetgesen_Ajil[]" cols="12" class="anket_textarea" id="Guitsetgesen_Ajil"></textarea></td>
      <td valign="top"><textarea name="Garsan_Shaltgaan[]" cols="12" class="anket_textarea" id="Garsan_Shaltgaan"></textarea></td>
      <td valign="top"><input name="Tsalin[]" type="text" class="anket_textarea" id="Tsalin" value="" size="10" /></td>
    </tr>
    <tr>
      <td valign="top"><input name="Baiguullagiin_Ner[]" type="text" class="anket_input" id="hel8" size="15" /></td>
      <td align="center" valign="top"><input name="Orson_Ognoo[]" type="text" class="anket_input" id="hel6" size="6" /></td>
      <td align="center" valign="top"><input name="Garsan_Ognoo[]" type="text" class="anket_input" id="hel7" size="6" /></td>
      <td valign="top"><input name="Alban_Tushaal[]" type="text" class="anket_textarea" id="Alban_Tushaal[]" value="" size="20" /></td>
      <td valign="top"><textarea name="Guitsetgesen_Ajil[]" cols="12" class="anket_textarea" id="Guitsetgesen_Ajil"></textarea></td>
      <td valign="top"><textarea name="Garsan_Shaltgaan[]" cols="12" class="anket_textarea" id="Garsan_Shaltgaan"></textarea></td>
      <td valign="top"><input name="Tsalin[]" type="text" class="anket_textarea" id="Tsalin" value="" size="10" /></td>
    </tr>
    <tr>
      <td valign="top"><input name="Baiguullagiin_Ner[]" type="text" class="anket_input" id="hel8" size="15" /></td>
      <td align="center" valign="top"><input name="Orson_Ognoo[]" type="text" class="anket_input" id="hel6" size="6" /></td>
      <td align="center" valign="top"><input name="Garsan_Ognoo[]" type="text" class="anket_input" id="hel7" size="6" /></td>
      <td valign="top"><input name="Alban_Tushaal[]" type="text" class="anket_textarea" id="Alban_Tushaal[]" value="" size="20" /></td>
      <td valign="top"><textarea name="Guitsetgesen_Ajil[]" cols="12" class="anket_textarea" id="Guitsetgesen_Ajil"></textarea></td>
      <td valign="top"><textarea name="Garsan_Shaltgaan[]" cols="12" class="anket_textarea" id="Garsan_Shaltgaan"></textarea></td>
      <td valign="top"><input name="Tsalin[]" type="text" class="anket_textarea" id="Tsalin" value="" size="10" /></td>
    </tr>
    <tr>
      <td valign="top"><input name="Baiguullagiin_Ner[]" type="text" class="anket_input" id="hel8" size="15" /></td>
      <td align="center" valign="top"><input name="Orson_Ognoo[]" type="text" class="anket_input" id="hel6" size="6" /></td>
      <td align="center" valign="top"><input name="Garsan_Ognoo[]" type="text" class="anket_input" id="hel7" size="6" /></td>
      <td valign="top"><input name="Alban_Tushaal[]" type="text" class="anket_textarea" id="Alban_Tushaal[]" value="" size="20" /></td>
      <td valign="top"><textarea name="Guitsetgesen_Ajil[]" cols="12" class="anket_textarea" id="Guitsetgesen_Ajil"></textarea></td>
      <td valign="top"><textarea name="Garsan_Shaltgaan[]" cols="12" class="anket_textarea" id="Garsan_Shaltgaan"></textarea></td>
      <td valign="top"><input name="Tsalin[]" type="text" class="anket_textarea" id="Tsalin" value="" size="10" /></td>
    </tr>
    <tr>
      <td valign="top"><input name="Baiguullagiin_Ner[]" type="text" class="anket_input" id="hel8" size="15" /></td>
      <td align="center" valign="top"><input name="Orson_Ognoo[]" type="text" class="anket_input" id="hel6" size="6" /></td>
      <td align="center" valign="top"><input name="Garsan_Ognoo[]" type="text" class="anket_input" id="hel7" size="6" /></td>
      <td valign="top"><input name="Alban_Tushaal[]" type="text" class="anket_textarea" id="Alban_Tushaal[]" value="" size="20" /></td>
      <td valign="top"><textarea name="Guitsetgesen_Ajil[]" cols="12" class="anket_textarea" id="Guitsetgesen_Ajil"></textarea></td>
      <td valign="top"><textarea name="Garsan_Shaltgaan[]" cols="12" class="anket_textarea" id="Garsan_Shaltgaan"></textarea></td>
      <td valign="top"><input name="Tsalin[]" type="text" class="anket_textarea" id="Tsalin" value="" size="10" /></td>
    </tr>
  </table>
  <h4>Е. Тусгай мэргэжлийн, гадаад хэлний, спортын болон бусад хүртсэн цол, сертификат, зэрэг</h4>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="50%">Цол, зэрэг, шагналын нэр</td>
      <td width="50%">Олгогдсон он, сар</td>
    </tr>
    <tr>
      <td><input type="text" name="Shagnal[]" id="Shagnal[]" class="anket_input"></td>
      <td><input type="text" name="shagnal_ognoo[]" id="shagnal_ognoo[]" class="anket_input"></td>
    </tr>
    <tr>
      <td><input type="text" name="Shagnal[]" id="Shagnal[]" class="anket_input"></td>
      <td><input type="text" name="shagnal_ognoo[]" id="shagnal_ognoo[]" class="anket_input"></td>
    </tr>
    <tr>
      <td><input type="text" name="Shagnal[]" id="Shagnal[]" class="anket_input"></td>
      <td><input type="text" name="shagnal_ognoo[]" id="shagnal_ognoo[]" class="anket_input"></td>
    </tr>
    <tr>
      <td><input type="text" name="Shagnal[]" id="Shagnal[]" class="anket_input"></td>
      <td><input type="text" name="shagnal_ognoo[]" id="shagnal_ognoo[]" class="anket_input"></td>
    </tr>
    <tr>
      <td><input type="text" name="Shagnal[]" id="Shagnal[]" class="anket_input"></td>
      <td><input type="text" name="shagnal_ognoo[]" id="shagnal_ognoo[]" class="anket_input"></td>
    </tr>
  </table>
  <h4>Ё. Гэр бүлийн байдал /зөвхөн ам бүлд байгаа хүмүүсийг бичнэ/</h4>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="20%" valign="top">Таны хэн болох</td>
      <td width="20%" valign="top">Овог, нэр</td>
      <td width="20%" valign="top">Төрсөн он, сар, өдөр</td>
      <td valign="top">Мэргэжил</td>
      <td width="20%" valign="top">Одоо эрхэлж буй ажил</td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Ger_bul_ner[]" id="textfield96" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ovog[]" id="textfield97" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_tursun_ognoo[]" id="textfield98" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_mergejil[]" id="textfield99" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ajil[]" id="textfield100" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Ger_bul_ner[]" id="textfield96" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ovog[]" id="textfield97" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_tursun_ognoo[]" id="textfield98" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_mergejil[]" id="textfield99" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ajil[]" id="textfield100" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Ger_bul_ner[]" id="textfield96" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ovog[]" id="textfield97" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_tursun_ognoo[]" id="textfield98" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_mergejil[]" id="textfield99" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ajil[]" id="textfield100" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Ger_bul_ner[]" id="textfield96" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ovog[]" id="textfield97" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_tursun_ognoo[]" id="textfield98" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_mergejil[]" id="textfield99" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ajil[]" id="textfield100" class="anket_input"></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="Ger_bul_ner[]" id="textfield96" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ovog[]" id="textfield97" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_tursun_ognoo[]" id="textfield98" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_mergejil[]" id="textfield99" class="anket_input"></td>
      <td valign="top"><input type="text" name="Ger_bul_ajil[]" id="textfield100" class="anket_input"></td>
    </tr>
  </table>
  <h4>Ж. Хувийн мэдээлэл</h4>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="30%">Таны давуу тал</td>
      <td ><textarea name="davuu_tal" class="anket_textarea" id="davuu_tal"></textarea></td>
    </tr>
    <tr>
      <td>Таны сул тал</td>
      <td><textarea name="sul_tal" class="anket_textarea" id="sul_tal"></textarea></td>
    </tr>
    <tr>
      <td>Зан чанар</td>
      <td><textarea name="zan_chanar" class="anket_textarea" id="zan_chanar"></textarea></td>
    </tr>
    <tr>
      <td>Сонирхол, Хобби</td>
      <td><textarea name="hobby" class="anket_textarea" id="hobby"></textarea></td>
    </tr>
    <tr>
      <td>Дуртай хичээл</td>
      <td><textarea name="durtai_hicheel" class="anket_textarea" id="durtai_hicheel"></textarea></td>
    </tr>
  </table>
  <h4>З. Таныг хамгийн сайн тодорхойлох хүний мэдээлэл</h4>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td valign="top">Овог нэр</td>
      <td valign="top">Таны хэн болох</td>
      <td valign="top">Эрхэлсэн ажил албан тушаал, ажлын газар</td>
      <td valign="top">Утас, email хаяг</td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="todorhoilogch_ovog_ner[]" id="todorhoilogch_ovog_ner" class="anket_input" /></td>
      <td valign="top"><input type="text" name="todorhoilogch_hen_bolo[]h" id="todorhoilogch_hen_boloh" class="anket_input" /></td>
      <td valign="top"><textarea name="todorhoilogch_ajil[]" class="anket_textarea" id="todorhoilogch_ajil"></textarea></td>
      <td valign="top"><input type="text" name="todorhoilogch_contacts[]" id="todorhoilogch_contacts" class="anket_input" /></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="todorhoilogch_ovog_ner2" id="todorhoilogch_ovog_ner2" class="anket_input" /></td>
      <td valign="top"><input type="text" name="todorhoilogch_hen_boloh2" id="todorhoilogch_hen_boloh2" class="anket_input" /></td>
      <td valign="top"><textarea name="todorhoilogch_ajil2" class="anket_textarea" id="todorhoilogch_ajil2"></textarea></td>
      <td valign="top"><input type="text" name="todorhoilogch_contacts2" id="todorhoilogch_contacts2" class="anket_input" /></td>
    </tr>
    <tr>
      <td valign="top"><input type="text" name="todorhoilogch_ovog_ner2" id="todorhoilogch_ovog_ner3" class="anket_input" /></td>
      <td valign="top"><input type="text" name="todorhoilogch_hen_boloh2" id="todorhoilogch_hen_boloh3" class="anket_input" /></td>
      <td valign="top"><textarea name="todorhoilogch_ajil2" class="anket_textarea" id="todorhoilogch_ajil3"></textarea></td>
      <td valign="top"><input type="text" name="todorhoilogch_contacts2" id="todorhoilogch_contacts3" class="anket_input" /></td>
    </tr>
    </table>
  <h4>И. Бусад</h4>
  <p>
    <textarea name="busad" class="anket_textarea" id="busad"></textarea>
  </p>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="50%">Анкетийг үнэн зөв бөглөсөн</td>
      <td width="50%">Огноо</td>
    </tr>
    <tr>
      <td><input type="text" name="Tanii_ner" id="textfield116" class="anket_input" /></td>
      <td><input type="text" name="Buglusun_ognoo" id="textfield117" class="anket_input" /></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="button" id="button" value="Илгээх" />
  </p>
  <p>Жич:</p>
  <ol>
    <li>Зураг хавсаргах</li>
    <li>Дипломны хуулбар /Хэрэв оюутан бол дүнгийн хуулбар/</li>
    <li>Иргэний үнэмлэхний хуулбар</li>
    <li>3-н үеийн намтар</li>
    <li>Бид таны анкет материалуудыг хүлээн авснаар таны өмнө ямар нэгэн хариуцлага хүлээхгүй болно</li>
  </ol>
</form>

</div>
<?
}
?>