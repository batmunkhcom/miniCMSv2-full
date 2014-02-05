<?
switch($_GET['type']){
	case 'add':
		$data['content'] = ($_POST['content']);
		$data['date_added'] = mbmTime();
		$data['code'] = $_POST['code'];
		$data['ip'] = getenv("REMOTE_ADDR");
		$data['browser'] = $_SERVER['HTTP_USER_AGENT'];
		if( '' == $data['content']){
			$result_value = 'empty content';
			$b=2;
		}
		 $username= $DB2->mbm_get_field($_SESSION['user_id'],'id','username','users');
		if( 0 == $username ){
			if($_POST['name'] == ''){
				$data['name'] = $lang['comments']['guest'];
			}else{
				$data['name'] = ($_POST['name']);
			}
		}else{
			$data['name'] = $username;
		}
		$data['user_id'] = $_SESSION['user_id'];
		if($_POST['captcha']!=$_SESSION['captcha_'.$data['code']] || !isset($_SESSION['captcha_'.$data['code']]) || strlen($_POST['captcha'])!=8){
			$result_value .= 'invalid verification code. ';//$_POST['captcha'].'-'.$_SESSION['captcha'];
			$st=0;
		}else{
			if( 1 == $DB->mbm_insert_row($data,'comments')){
				$result_value .= 'comment inserted';//.$_POST['captcha'].'-'.$_SESSION['captcha'];
				$st=1;
				$_SESSION['captcha_'.$data['code']] = '';
				
				mbmUpdateUserScore($_SESSION['user_id'],1);

		}else{
				$result_value .= 'Error occurred try again please';
				$st=0;
			}
		}
		$txt .= '<div id="query_result">'.$result_value;
		if($st!=1) $txt .= ' <a href="#" onclick="$(\'#formComments\').show();return false;">[try again]</a>';
		$txt .= ' </div>';
	break;
}
$q_comments = "SELECT * FROM ".PREFIX."comments WHERE content!='' ";
if(isset($_POST['code'])){
	$q_comments .= "AND code='".addslashes($_POST['code'])."' ";
}
$q_comments .= "ORDER BY id";
$r_comments = $DB->mbm_query($q_comments);

for($i=0;$i<$DB->mbm_num_rows($r_comments);$i++){
	
	/*
	$txt .= "\n\t<comment name=\"".mbmCleanUpForXML($DB->mbm_result($r_comments,$i,"name"))."\" date_added=\""
			.mbmTimeConverter($DB->mbm_result($r_comments,$i,"date_added"))."\">";
	$txt .= mbmCleanUpForXML(mbmCleanUpHTML($DB->mbm_result($r_comments,$i,"content")));
	$txt .= "</comment>";
	*/
	
	$txt .= '<div class="commentUsername"> '.($i+1).'. '.mbmCleanUpForXML($DB->mbm_result($r_comments,$i,"name"))
		 .'<span class="mbmTimeConverterContentComment"> ['.mbmTimeConverter($DB->mbm_result($r_comments,$i,"date_added")).']</span>'
		 .'</div>';
	$txt .= '<div class="contentComments">';
	if($DB->mbm_result($r_comments,$i,"user_id")==0){
		$avatar_img = INCLUDE_DOMAIN.'images/guest.gif';
	}else{
		$avatar_img = DOMAIN.DIR.'modules/users/avatar_show.php?id='.$DB2->mbm_get_field($DB->mbm_result($r_comments,$i,"user_id"),'user_id','id','user_avatars');
	}
	$txt .= '<img src="'.$avatar_img.'" style="float:left" hspace="5" width="50" id="userAvatar" />';
	$txt .= mbmCleanUpForXML($DB->mbm_result($r_comments,$i,"content"));
	$txt .= '<br clear="both" />';
	$txt .= '</div>';
	if($i == ($DB->mbm_num_rows($r_comments)-1)){
		$txt .= '<a name="lastComment"></a>';
	}
}
?>