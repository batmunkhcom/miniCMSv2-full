<div style="width:468px;">

<?

if($mBm!=1){

	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');

}elseif($DB->mbm_check_field('id',$_GET['id'],'gallery_files')==0){

	echo '<h2>Хэрэглэгчийн зургийн цомог</h2>';

	echo '<div id="query_result">Уг зураг олдсонгүй.</div>';

}else{

	echo '<h2>Хэрэглэгчийн зургийн цомог</h2>';

	

	$DB->mbm_query("UPDATE ".PREFIX."gallery_files SET hits=hits+".HITS_BY.",views=views+".HITS_BY." WHERE id='".$_GET['id']."'");

	

	$q_photo_file = "SELECT * FROM ".PREFIX."gallery_files WHERE id='".$_GET['id']."'";

	$r_photo_file = $DB->mbm_query($q_photo_file);

	echo '<div id="contentTitle">'.$DB->mbm_result($r_photo_file,0,"name").'</div>';

	echo '<img src="img.php?type='.$DB->mbm_result($r_photo_file,0,"filetype")

						.'&w=';

	if(PHOTOGALLERY_MAX_PHOTO_WIDTH>$DB->mbm_result($r_photo_file,0,"width")){

		echo $DB->mbm_result($r_photo_file,0,"width");

	}else{

		echo PHOTOGALLERY_MAX_PHOTO_WIDTH;

	}

	echo '&f='.base64_encode($DB->mbm_result($r_photo_file,0,"url"))

		 .'" border="0" alt="'.$DB->mbm_result($r_photo_file,0,"comment").'" />';

	echo '<br />'.$DB->mbm_result($r_photo_file,0,"comment");

	?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" style="border:1px solid #DDDDDD; margin-bottom:12px; margin-top:12px;">

  <tr>

    <td width="25%" height="25" align="center" bgcolor="#f5f5f5"><strong>Нэмсэн</strong></td>

    <td width="25%" align="center" bgcolor="#f5f5f5"><strong>Файл хэмжээ</strong></td>

    <td width="25%" align="center" bgcolor="#f5f5f5"><strong>Үзэлт</strong></td>

    <td width="25%" align="center" bgcolor="#f5f5f5"><strong>Огноо</strong></td>

  </tr>

  <tr>

    <td align="center"><?=$DB2->mbm_get_field($DB->mbm_result($r_photo_file,0,"user_id"),'id','username','users')?></td>

    <td align="center"><?=mbmFileSizeMB($DB->mbm_result($r_photo_file,0,"filesize"))?></td>

    <td align="center"><?=$DB->mbm_result($r_photo_file,0,"hits")?></td>

    <td align="center"><?=date("Y/m/d",$DB->mbm_result($r_photo_file,0,"date_added"))?></td>

  </tr>

</table>

<?

	echo mBmCommentsForm("pg_".$DB->mbm_result($r_photo_file,0,"id"),45,30);

}

?>

</div>