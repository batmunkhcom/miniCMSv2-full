<?

//download file and exit
if(isset($_GET['dl'])){
	switch($_GET['dl']){
		case 'content_video':
			die("<h2>Uuchlaaraa. Site iin zugees  Video tataltiig haasan bolno... </h2>");
			if($DB->mbm_check_field('id',$_GET['id'],'menu_videos')==1){

				$file_url = $DB->mbm_get_field($_GET['id'],'id','url','menu_videos');
				//echo str_replace(DOMAIN.DIR,ABS_DIR,$file_url); exit;
				switch($_SESSION['lev']){
					case 1:
						$download_rate = 128;
					break;
					case 2:
						$download_rate = 256;
					break;
					case 3:
						$download_rate = 384;
					break;
					case 4:
						$download_rate = 512;
					break;
					case 5:
						$download_rate = 100000;
					break;
					default:
						$download_rate = 32;
					break;
				}
				//echo $file_url.' - ';
				//echo str_replace(DOMAIN.DIR,ABS_DIR,$file_url); exit;
				//if(file_exists(str_replace(DOMAIN.DIR,ABS_DIR,$file_url))) echo 1; exit;
				if($_SESSION['lev'] == 0){
					$file_url = DOMAIN.DIR.'index.php?module=users&cmd=registration';
				}
				mbmDownloadWithLimit(
					array(
						'real_path'=>str_replace(DOMAIN.DIR,ABS_DIR,$file_url), //file iin original path
						'user_filename'=>basename($file_url), //hereglegch yamar nereer tatah
						'download_rate'=>$download_rate //tatah hurd  0.1 == 100bytes p/s
						)
					);
				$q_update_info = "UPDATE ".PREFIX."menu_videos SET downloaded=downloaded+".HITS_BY." WHERE id='".$_GET['id']."'";
				$DB->mbm_query($q_update_info);
				/*
				header("Location: ".$file_url);
				*/
			}
		break;
		case 'content_photo':
			if($DB->mbm_check_field('id',$_GET['id'],'menu_photos')==1){

				$file_url = $DB->mbm_get_field($_GET['id'],'id','url','menu_photos');
				//echo str_replace(DOMAIN.DIR,ABS_DIR,$file_url); exit;
				mbmDownloadWithLimit(
					array(
						'real_path'=>ABS_DIR.$file_url, //file iin original path
						'user_filename'=>COOKIE_NAME.str_replace(PHOTO_DIR,'',$file_url),
						'download_rate'=>30 //tatah hurd  0.1 == 100bytes p/s
						)
					);
				$q_update_info = "UPDATE ".PREFIX."menu_photos SET downloaded=downloaded+".HITS_BY." WHERE id='".$_GET['id']."'";
				$DB->mbm_query($q_update_info);
			}
		break;
	}
	exit;
}
//download file ends

	
header('Content-type: application/rss+xml');

echo "<rss version=\"2.0\" xmlns:media=\"http://search.yahoo.com/mrss/\">";
	echo "<channel>
	<title>".mbmRSSecho(PAGE_TITLE)."</title>
	<link>".mbmRSSecho(DOMAIN)."</link>
	<description>".mbmRSSecho(PAGE_TITLE)."</description>
	<language>en-us</language>
	<pubDate>".mbmDate('Y-m-d H:i:s')."</pubDate>
	<lastBuildDate>".mbmDate('Y-m-d H:i:s')."</lastBuildDate>
	<generator>miniCMS v2 http://www.mng.cc/</generator>
	<managingEditor>".mbmRSSecho(ADMIN_NAME)."</managingEditor>
	<webMaster>".mbmRSSecho(ADMIN_EMAIL)."</webMaster>";
?>