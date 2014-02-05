<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
} 
echo mbmForumBuildPath($_GET['forum_id']);
	if($DB->mbm_check_field('forum_id',$_GET['forum_id'],'forums')==1){
		echo mbmForumList($_GET['forum_id']);
	}else{
		echo mbmForumContentsList($_GET['forum_id'],'session_time','desc');
	}
?>