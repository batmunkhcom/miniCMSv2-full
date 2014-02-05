<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if($_SESSION['lev']==0){
	$b=1;
	$result_txt = $lang["forum"]["login_to_create_topic"];
}
if($DB->mbm_check_field('id',$_GET['forum_id'],'forums')==0){
	$b=1;
	$result_txt = $lang["forum"]["no_such_forum"];
}
echo mbmForumBuildPath($_GET['forum_id']);
if(isset($_POST['newTopic'])){
	//check insert time
	$insertTime = $DB->mbm_get_field(session_id(),'session_id','date_added','forum_contents');
	if(abs(mbmTime()-$insertTime)<60){
		$result_txt = $lang["forum"]["too_short_to_insert"];
		$b=1;
	}else{
		$data['forum_id'] = $_GET['forum_id'];
		$data['user_id'] = $_SESSION['user_id'];
		if($_POST['sticky']){
			$data['sticky'] = $_POST['sticky'];
		}
		if($_POST['announcement']==1){
		$data['announcement'] = $_POST['announcement'];
		}
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
		$data['content_more'] = nl2br(htmlspecialchars($_POST['content_more']));
		$data['date_added'] = mbmTime();
		$data['date_lastupdated'] = $data['date_added'];
		$data['session_id'] = session_id();
		$data['session_time'] = mbmTime();
		if(mbmCheckEmptyField($data)){
			$result_txt = $lang["forum"]["fill_empty_fields"];
		}else{
			$data['content_id'] = 0;
			if($DB->mbm_insert_row($data,'forum_contents')==1){
				$result_txt = $lang["forum"]["command_topic_creat_prossesed"];
				mbmForumTotalContentUpdate($_GET['forum_id'],$DB->mbm_get_field(session_id(),'session_id','id','forum_contents'),1);
				$b=1;
				$DB->mbm_query("UPDATE ".PREFIX."forum_contents SET session_time=0,session_id='' WHERE session_id='".session_id()."'");
			}else{
				$result_txt = $lang["forum"]["command_topic_creat_failed"];
			}
		}
	}
}
echo mbm_result($result_txt);
if($b!=1){
?>
<div id="forum_newContent">
<div class="forum_creatTopicTitle"><?=$lang["forum"]["title_creat_topic"]?></div>
<form id="post" name="post" method="post" action="">
<div id="forumNewContentTitle" style="padding-left:210px;">
  <input name="title" type="text" id="title" class="forum_input" size="45" value="<?=$_POST['title']?>" />&nbsp;<?=$lang["forum"]["topic_title"]?>
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
     <input name="smilies" type="checkbox" disabled="disabled" id="smilies" value="1" checked="checked" />
     <?=$lang["forum"]["use_smilies"]?><br />
     <input name="bbcode" type="checkbox" id="bbcode" value="1" checked="checked" />
     <?=$lang["forum"]["use_bbcode"]?><br />
     <input name="html_code" type="checkbox" disabled="disabled" id="html_code" value="1" checked="checked" />
     <?=$lang["forum"]["use_html_code"]?><br />
     <input name="signature" type="checkbox" id="signature" value="1" checked="checked" />
     <?=$lang["forum"]["use_signature"]?>
 </div>
<div style="padding-left:210px;">
<input type="submit" name="newTopic" id="newTopic" value="<?=$lang["forum"]["button_creat_topic"]?>" class="forum_button" />
</div>
</form>
</div>
<?
}
?>