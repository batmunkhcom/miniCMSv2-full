<?php
echo '<h2>YOUTUBE -с видео татах</h2>';
?>
<form method="post">
Та видео үздэг хаягийг оруулаад видео татах товчлуурыг дарснаар доор нь тухайн видеоны мэдээлэл гарах бөгөөд жижиг зургийн дэргэд "ЭНД ДАРНА УУ" гэдэг үг бүхий ТАТАХ холбоос гарна. Уг холбоос дээр дарж видеогоо татна уу. <br />
<strong>ВИДЕО НЬ video.flv НЭРТЭЙГЭЭР ТАТАГДАХЫГ АНХААРНА УУ!!!</strong>
<input name="url" type="text" style="width: 350px" value="http://www.youtube.com/watch?v=N1Te_03drhk">
<input type="submit" value="Видео татах" class="button"><br />
</form>
<br />
<hr>
<br />
<?php
if(isset($_POST['url'])){
 $videoWatchURL = $_POST['url'];
  $tube = new youtube();

  // Only required for restricted videos 
  // $tube->username = "userid";
  // $tube->password = "password";
  $download_link = $tube->get($_POST['url']);

  if($download_link) { 
	  ?>
	  <script language="javascript">
		  setTimeout("window.location='<?=$download_link;?>';",5000);
	  </script> 
	<?php 
  } else { ?>

    Файлыг татах явцад алдаа гарлаа. 

  <?php } 

}else{
	$videoWatchURL = "http://www.youtube.com/watch?v=N1Te_03drhk";
	$tube = new youtube();
	$download_link = $tube->get($videoWatchURL);
}

$video_info = mbmGetYoutubeVideo($videoWatchURL);
	echo '<div style="block; position:relative; display:block; clear:both; line-height:17px;">';
	echo '<img src="'. $video_info['thumbnail'].'" alt="'.addslashes( $video_info['title']).'" title="'.addslashes( $video_info['title']).'" border="0" align="left" hspace="5" />';
	echo '<strong>'. $video_info['title'].'</strong><br />';
	echo  $video_info['description'].'<br />';
	echo 'Хугацаа: '. $video_info['length'].'<br />';
	echo 'Нэмсэн: '. $video_info['author'].'<br />';
	echo 'Үзсэн: '. $video_info['viewCount'].'<br />';
	echo 'Татах: <a href="'.$download_link.'" target="_blank" title="Татах" style="color:red; font-size:18px; font-weight:bold;text-decoration:blink;">Видеог энд дарж татна уу.</a> <br />';
	echo '</div>';
	echo '<br />';
	echo $video_info['embed_code'];
echo '</div>';

?>