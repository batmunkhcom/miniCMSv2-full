<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}else{
	echo '<h2>Зургийн цомог</h2>';
	if(isset($_GET['cat_id']) && $_GET['cat_id']!=''){
		$catid = $_GET['cat_id'];
		echo '<div id="contentTitle">'.$DB->mbm_get_field($catid,'id','name','galleries').'</div>';
		echo mbmPhotosByGalleryId($catid,4,8888,1,0,'id','DESC',0,1);
	}else{
		echo mbmPhotoGalleryCategories(array(0=>'<div>',1=>'</div>',2=>'<div style="padding-left:20px;">',3=>'</div>'),2,2,2,88,0,'id','desc');
	}
}
?>