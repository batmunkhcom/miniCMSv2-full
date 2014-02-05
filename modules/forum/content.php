<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if($DB->mbm_check_field('id',$_GET['id'],'forum_contents')==0){
	$b=1;
	$result_txt = $lang["forum"]["no_such_topic"];
}
echo mbmForumBuildPath($_GET['forum_id']);
if($DB->mbm_get_field($_GET['content_id'],'id','lev','forum_id')>$_SESSION['lev']){
	$b=1;
	$result_txt = $lang["forum"]["low_level"];
}

$forum_id = $DB->mbm_get_field($_GET['id'],'id','forum_id','forum_id');
echo mbm_result($result_txt);
if($b!=1){

	echo '<div id="forumContents">';
		echo mbmForumContentPosts($_GET['id'],'id','asc');
	echo '</div>';
}
?>