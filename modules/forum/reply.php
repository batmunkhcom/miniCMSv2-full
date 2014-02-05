<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if($_SESSION['lev']==0){
	$b=1;
	$result_txt = $lang["forum"]["login_to_reply_topic"];
}
if($DB->mbm_check_field('id',$_GET['content_id'],'forum_contents')==0){
	$b=1;
	$result_txt = 'no such topic exists';
}
echo mbmForumBuildPath($_GET['forum_id']);
$forum_id = $DB->mbm_get_field($_GET['content_id'],'id','forum_id','forum_contents');
if(isset($_POST['replyTopic'])){
	//check insert time
	$insertTime = mbmSessionGetTime($DB,PREFIX.'forum_contents');
	if(abs(mbmTime()-$insertTime)<60){
		$result_txt = $lang["forum"]["too_short_to_insert"];
		$b=1;
		mbmSessionClear($DB,PREFIX."forum_contents");
	}else{
		$data['forum_id'] = $forum_id;
		$data['user_id'] = $_SESSION['user_id'];
	
		if($_POST['bbcode']==1){
			$data['use_bbcode'] = 1;
		}
		if($_POST['html_code']==1){
			$data['use_html'] = 1;
		}
		if($_POST['smilies']==1){
			$data['use_smilies'] = 1;
		}
		if($_POST['signature']==1){
			$data['use_signature'] = 1;
		}
		$data['title'] = $_POST['title'];
		$data['content_id'] = $_GET['content_id'];
		$data['content_more'] = nl2br(htmlspecialchars($_POST['content_more']));
		$data['date_added'] = mbmTime();
		$data['date_lastupdated'] = $data['date_added'];
		$data['session_id'] = session_id();
		$data['session_time'] = mbmTime();
		if(mbmCheckEmptyField($data)){
			$result_txt = $lang["forum"]["fill_empty_fields"];
		}else{
			if($DB->mbm_insert_row($data,'forum_contents')==1){
				$result_txt = $lang["forum"]["command_topic_reply_prossesed"];
				$DB->mbm_query("UPDATE ".PREFIX."forum_contents SET date_lastupdated='".mbmTime()."',total_replies=total_replies+1 WHERE id='".$data['content_id']."'");
				mbmForumTotalContentUpdate($forum_id,$DB->mbm_get_field(session_id(),'session_id','id','forum_contents'),0);
				$b=1;
				$DB->mbm_query("UPDATE ".PREFIX."forums SET session_time=0 WHERE session_id='".session_id()."'");
			}else{
				$result_txt = $lang["forum"]["command_topic_reply_failed"];
			}
		}
	}
}
echo mbm_result($result_txt);
if($b!=1){
?>
<div id="forum_newContent"><?=$lang["forum"]["title_reply_topic"]?>
  <form id="post" name="post" method="post" action="">
<div id="forumNewContentTitle" style="padding-left:210px;">
  <input name="title" type="text" id="title" class="forum_input" value="<?
  if(isset($_POST['title'])){
  	echo $_POST['title'];
  }else{
  	echo 'RE: '.$DB->mbm_get_field($_GET['content_id'],'id','title','forum_contents');
  }
  ?>" size="45" />&nbsp;<?=$lang["forum"]["topic_title"]?>
 </div>
 <div id="forumNewContent">
   <?
	 // echo  mbmShowHTMLEditor("more",'spaw2','spaw','mini',array(0=>'1'),'en','95%',"400px");
	  echo mbmBBCODEtextarea('post','content_more');
  ?>
 </div>
<div id="forumOptions" style="padding-left:210px;"><strong>
  <?=$lang["forum"]["options"]?>
</strong><br />
   <input name="sticky" type="checkbox" id="sticky" value="1" />
	 <?=$lang["forum"]["sticky"]?><br />
     <input name="announcement" type="checkbox" id="announcement" value="1" />
     <?=$lang["forum"]["announcement"]?><br />
     <input name="smilies" type="checkbox" disabled="disabled" id="smilies" value="1" checked="CHECKED" />
     <?=$lang["forum"]["use_smilies"]?><br />
     <input name="bbcode" type="checkbox" id="bbcode" value="1" checked="checked" />
     <?=$lang["forum"]["use_bbcode"]?><br />
     <input name="html_code" type="checkbox" disabled="disabled" id="html_code" value="1" />
     <?=$lang["forum"]["use_html_code"]?><br />
     <input name="signature" type="checkbox" id="signature" value="1" checked="checked" />
     <?=$lang["forum"]["use_signature"]?>
 </div>
<div style="padding-left:210px;">
<input type="submit" name="replyTopic" id="replyTopic" value="<?=$lang["forum"]["button_reply_topic"]?>" class="forum_button" />
</div>
</form>
</div>
<div>
<? echo mbmForumContentPosts($_GET['content_id'],'id','asc',1);?>
</div>
<?
}
?>