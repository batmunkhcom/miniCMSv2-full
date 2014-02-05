<?
$config_fileshare = $GLOBALS['config_fileshare'];
?>
<div id="query_result" style="display:none;">Туршилтын хугацаанд хэрэглэгчид <?=$config_fileshare['dl_limit'][1]?>кв/с хурдаар татах авах болно.</div>
<iframe src="<?=DOMAIN.DIR?>html/ubr_file_upload.php?code=<?=md5($_SESSION['lev'])?>" border="0" style="border:0px; margin:0px;width:100%; height:220px; background-color:#FFFFFF;" id="uploadFrame"></iframe>

<br clear="all" />

<table width="100%" border="0" cellspacing="2" cellpadding="2">

  <tr>

    <td height="25" align="center" style="background-color:#c5ddff; padding-left:10px; font-weight:bold;">&nbsp;</td>

    <td width="150" align="center" style="background-color:#c5ddff; padding-left:10px; font-weight:bold;">Татах хурд</td>

    <td width="150" align="center" style="background-color:#c5ddff; padding-left:10px; font-weight:bold;">Хадгалах хугацаа*</td>

    <td width="150" align="center" style="background-color:#c5ddff; padding-left:10px; font-weight:bold;">Файл хуулах хэмжээ</td>

  </tr>

  <tr>

    <td bgcolor="#F0F7FF">Бүртгэлгүй хэрэглэгч</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['dl_limit'][0]?> KBps</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['days_to_save'][0]?> хоног</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['upload_max_size'][0]?> МВ</td>

  </tr>

  <tr>

    <td bgcolor="#F0F7FF">Энгийн хэрэглэгч</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['dl_limit'][1]?> KBps</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['days_to_save'][1]?> хоног</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['upload_max_size'][1]?> МВ</td>

  </tr>

  <tr>

    <td bgcolor="#F0F7FF">2 түвшинт хэрэглэгч</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['dl_limit'][2]?> KBps</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['days_to_save'][2]?> хоног</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['upload_max_size'][2]?> МВ</td>

  </tr>

  <tr>

    <td bgcolor="#F0F7FF">3 түвшинт хэрэглэгч</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['dl_limit'][3]?> KBps</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['days_to_save'][3]?> хоног</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['upload_max_size'][3]?> МВ</td>

  </tr>

  <tr>

    <td bgcolor="#F0F7FF">4 түвшинт хэрэглэгч</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['dl_limit'][4]?>
    KBps</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['days_to_save'][4]?> хоног</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['upload_max_size'][4]?> МВ</td>

  </tr>

  <tr>

    <td bgcolor="#F0F7FF"> 5 түвшинт хэрэглэгч</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['dl_limit'][5]?>
    KBps</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['days_to_save'][5]?> хоног</td>

    <td align="center" bgcolor="#F0F7FF"><?=$config_fileshare['upload_max_size'][5]?> МВ</td>

  </tr>

</table>

* - Хамгийн сүүлд татагдсанаас хойш татагдалгүй тухайн хугацаа хүрэхэд автоматаар устана.