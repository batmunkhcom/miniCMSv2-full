<?
switch($_GET['type']){
	case 'video':
		$query_continue = "AND is_video=1 ";
		
	break;
	case 'photo':
		$query_continue = "AND is_photo=1 ";
	break;
	case 'normal':
		$query_continue = "AND is_video=0 AND is_photo=0 ";
	break;
	default:
		$query_continue = "";
	break;
}


if($DB->mbm_check_field('id',$_GET['id'],'menu_contents')==1){
	$query_continue .= "AND id='".$_GET['id']."' ";
}
if($DB->mbm_check_field('id',$_GET['menu_id'],'menus')==1){
	$query_continue .= "AND menu_id LIKE '%,".$_GET['menu_id'].",%' ";
}
if($_GET['order_by']=='downloaded' && $_GET['type']=='video'){
	$q_contents = "SELECT * FROM ".PREFIX."menu_videos WHERE id!=0 ";
	$just_video = 1;

}else{
	$q_contents = "SELECT * FROM ".PREFIX."menu_contents WHERE st=1 ".$query_continue." GROUP BY content_short ";
}
	if(isset($_GET['order_by'])){
		 $ob = addslashes($_GET['order_by']);
	 }else{
		 $ob = "id ";
	 }
	 if(isset($_GET['asc'])){
		 $as = addslashes($_GET['asc']);
	 }else{
		 $as = "DESC ";
	 }
	 $q_contents .= "ORDER BY ".$ob." ".$as;
	 
	 $r_contents = $DB->mbm_query($q_contents);
	 
	 if(isset($_GET['lm']) && $_GET['lm']<100){
		$end_content = $_GET['lm'];
	 }elseif($DB->mbm_num_rows($r_contents)<100){
		$end_content = $DB->mbm_num_rows($r_contents);
	 }else{
		$end_content = 100;
	 }
	 
	 $buf_rss = '';
	 
	 for($i=0;$i<$end_content;$i++){
		 if($just_video==1){
		 	$this_content_id = $DB->mbm_result($r_contents,$i,"content_id");
		 	$this_menu_id = $DB->mbm_get_field($this_content_id,'id','menu_id','menu_contents');
			 $this_description = $DB->mbm_result($r_contents,$i,"comment");
			 $this_hits = $DB->mbm_result($r_contents,$i,"downloaded");
			 $this_id = $DB->mbm_result($r_contents,$i,"content_id");
			 $this_title = $DB->mbm_get_field($this_content_id,'id','title','menu_contents');
		 }else{
			 $this_menu_id = $DB->mbm_result($r_contents,$i,"menu_id");
		 	 $this_content_id = $DB->mbm_result($r_contents,$i,"id");
			 $this_description = $DB->mbm_result($r_contents,$i,"content_short");
			 $this_hits = $DB->mbm_result($r_contents,$i,"hits");
			 $this_id = $DB->mbm_result($r_contents,$i,"id");
			 $this_title = $DB->mbm_result($r_contents,$i,"title");
		 }
		$buf_rss .= "<item>\n";
			$buf_rss .= "<title>".($this_title)."</title>\n";
			$buf_rss .= "<link>".mbmRSSecho(DOMAIN.'index.php?module=menu&cmd=content&menu_id='
					.mbmReturnMenuId($this_menu_id)
					.'&id='.$this_id)
					."</link>\n";
			$buf_rss .= "<author>".mbmRSSecho($DB2->mbm_get_field($DB->mbm_result($r_contents,$i,"user_id"),'id','username','users'))."</author>\n";
			if($DB->mbm_result($r_contents,$i,"date_added") > 0){
			$buf_rss .= "<pubDate>".date("Y-m-d H:i:s",$DB->mbm_result($r_contents,$i,"date_added"))."</pubDate>\n";
			}
			$buf_rss .= "<description>";
			//$buf_rss .= "<![CDATA[\n";
									
				switch($_GET['type']){
					case 'photo':
						$buf_rss .= mbmRSSecho(mbmMediaContentThumbImage(
										array(
											'content_id'=>$this_content_id,
											'type'=>$_GET['type']
											)
									  ));
						$q_grabVideoPhoto = "SELECT * FROM ".$DB->prefix."menu_photos WHERE content_id='".$DB->mbm_result($r_contents,$i,"id")."' ORDER BY RAND()";
						$r_grabVideoPhoto = $DB->mbm_query($q_grabVideoPhoto);
						$video_photo_file = '<media:group>
												<media:credit role="author">'.$DB2->mbm_get_field($DB->mbm_result($r_contents,$i,"user_id"),'id','username','users').'</media:credit>
												<media:content url="'.DOMAIN.DIR.$DB->mbm_result($r_grabVideoPhoto,0,"url").'" type="image/'.$DB->mbm_result($r_grabVideoPhoto,0,"filetype").'" />
											</media:group>';
					break;
					case 'video':
						$buf_rss .= mbmRSSecho(mbmMediaContentThumbImage(
										array(
											'content_id'=>$this_content_id,
											'type'=>$_GET['type']
											)
									  ));
						$q_grabVideoPhoto = "SELECT * FROM ".$DB->prefix."menu_videos WHERE content_id='".$DB->mbm_result($r_contents,$i,"id")."' ORDER BY RAND() LIMIT 1";
						$r_grabVideoPhoto = $DB->mbm_query($q_grabVideoPhoto);
						$video_photo_file = '<media:group>
											<media:credit role="author">'.$DB2->mbm_get_field($DB->mbm_result($r_contents,$i,"user_id"),'id','username','users').'</media:credit>
											<media:content url="'.$DB->mbm_result($r_grabVideoPhoto,0,"url").'" type="video/x-flv" />
											<media:thumbnail url="'.$DB->mbm_result($r_grabVideoPhoto,0,"image_url").'" />
										</media:group>';
					break;
				}
			if($_GET['short']!='no'){
				$this_description = str_replace("src=\"/","src=\"".DOMAIN.DIR,$this_description);
				$buf_rss .= mbmRSSecho($this_description);
			}
			$buf_rss .= mbmRSSecho('<br clear="both" />');
			//$buf_rss .= ($lang['main']['hits'].': '.$this_hits);
			//$buf_rss .= "\n]]>";
			$buf_rss .= "</description>\n";
			$buf_rss .= $video_photo_file."\n";
		$buf_rss .= "</item>\n";
	 }
 echo $buf_rss;
?>