<?
switch($_GET['type']){
	case 'add':
		
		if($_SESSION['lev']==0){
			$result_txt = $lang["users"]["please_login"];
		}elseif($DB->mbm_check_field('url',base64_decode($_GET['flv_url']),'menu_videos')==0){
			$result_txt = "Invalid content provided ".base64_decode($_GET['flv_url']);
		}else{

			$data['user_id'] = $_SESSION['user_id'];
			$data['name'] = "default";
			$data['comment'] = "default playlist";
			$data['date_added'] = mbmTime();
			$data['video_urls'] = $_GET['title'].':'.$_GET['flv_url'].',';

			if($DB->mbm_check_field('user_id',$_SESSION['user_id'],'menu_video_playlist')==0){
				
				$r_playlist = $DB->mbm_insert_row($data,"menu_video_playlist");
			}else{
				$r_playlist = $DB->mbm_query("UPDATE ".PREFIX."menu_video_playlist SET video_urls=CONCAT(REPLACE(video_urls,'".$data['video_urls']."',''),'".$data['video_urls']."') WHERE user_id='".$_SESSION['user_id']."'");
			}
			
			
			if($r_playlist==1){
				$result_txt = $lang['menu']['added_to_playlist'];
				$ajax_st = 1;
			}else{
				$result_txt = $lang['menu']['error_playlist'];
				$ajax_st = 0;
			}
		}
	break;
	case 'remove':

		$r_playlist = $DB->mbm_query("UPDATE ".PREFIX."menu_video_playlist SET video_urls=REPLACE(video_urls,'".$_GET['title'].":".$_GET['flv_url'].",','') WHERE user_id='".$_SESSION['user_id']."'");
					
		if($r_playlist==1){
			$result_txt = $lang['menu']['removed_from_playlist'];
			$ajax_st = 1;
		}else{
			$result_txt = $lang['menu']['error_playlist'];
			$ajax_st = 0;
		}
	break;
}
$txt .= "\n\t<comment st='".$ajax_st."'>&lt;span class=red&gt;".$result_txt."&lt;/;span&gt;</comment>";
?>