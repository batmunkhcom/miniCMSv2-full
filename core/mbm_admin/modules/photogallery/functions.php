<?
function mbmPhotoGalleryGenerateSecretKey(){
	global $DB;
	$letter_A = "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z";
	$letters_a = strtolower($letter_A).$letter_A;
	
	$letter = explode(" ",$letters_a);
	
	$buf = '';
	$secret_key = $letter[rand(0,50)]
		.$letter[rand(0,50)]
		.rand(1000,9999).rand(1000,9999)
		.$letter[rand(0,50)]
		.$letter[rand(0,50)].rand(1000,9999);
	if($DB->mbm_check_field('secret_key',$secret_key,'galleries')==1){
		$buf = mbmPhotoGalleryGenerateSecretKey();
	}else{
		$buf = $secret_key;
	}
	return $buf;
}
?>