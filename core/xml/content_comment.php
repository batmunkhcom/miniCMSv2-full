<?
switch($_GET['type']){
	case 'add':
		$data["content_id"] = $_POST['content_id'];
		if($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==1){
			$data["name"] = $DB2->mbm_get_field($_SESSION['user_id'],'id','username','users');
			$data["user_id"] = $_SESSION['user_id'];
		}else{
			$data["name"] = $_POST['name'];
		}
		
		$content_comment = nl2br(rawurldecode($_POST['comment']));
		
		$data["comment"] =mbmCleanUpHTML( $content_comment.' ['.$_SESSION['country']['name'].']');
		$data["date_added"] = mbmTime();
		$data["ip"] = getenv("REMOTE_ADDR");
		$data["browser"] = $_SERVER['HTTP_USER_AGENT'];
		
		if(strlen($_POST['name'])<2){
			$result_txt = $lang["menu"]["comment_error_short_name"];
		}else{
			if($DB->mbm_insert_row($data,"menu_content_comments")==1){
				$result_txt = $lang["menu"]["comment_add_processed"];
			}else{
				$result_txt = $lang["menu"]["comment_add_failed"];
			}
		}
		
		mbmUpdateUserScore($_SESSION['user_id'],1);
	break;
}
if(isset($_POST['name'])){
	$txt .= '<div id="query_result">'.$result_txt."</div>";
	$jump_toLastComment = '<script language="Javascript">window.location=\'#lastComment\';</script>';
}

if($_GET['menu_id'] && $_GET['id']){
	$content_id = "AND content_id='".$_GET['id']."'";
}elseif($_GET['content_id']){
	$content_id = "AND content_id='".$_GET['content_id']."'";
}elseif($_POST['content_id']){
	$content_id = "AND content_id='".$_POST['content_id']."'";
}
$q_content_comments = "SELECT * FROM ".PREFIX."menu_content_comments WHERE comment!='' ".$content_id." ORDER BY id";

$r_content_comments = $DB->mbm_query($q_content_comments);

$total_comments = $DB->mbm_num_rows($r_content_comments);
for($i=0;$i<$total_comments;$i++){
	
	$txt .= '<div class="commentUsername"> ';
	if(($i+1)==$total_comments){
		$txt .= '<a name="lastComment" id="lastComment"></a>';
	}
		$txt .= ($i+1).'. '.mbmCleanUpForXML($DB->mbm_result($r_content_comments,$i,"name"))
			 .'<span class="mbmTimeConverterContentComment"> ['.mbmTimeConverter($DB->mbm_result($r_content_comments,$i,"date_added")).']</span>'
		 .'</div>';
	$txt .= '<div class="contentComments">';
	if($DB->mbm_result($r_content_comments,$i,"user_id")==0){
		$avatar_img = INCLUDE_DOMAIN.'images/guest.gif';
	}else{
		$avatar_img = DOMAIN.DIR.'modules/users/avatar_show.php?id='.$DB2->mbm_get_field($DB->mbm_result($r_content_comments,$i,"user_id"),'user_id','id','user_avatars');
	}
	$txt .= '<img src="'.$avatar_img.'" style="float:left" hspace="5" width="50" alt="'.$DB->mbm_result($r_content_comments,$i,"name").'" class="userAvatar" />';
	$txt .= mbmCleanUpHTML($DB->mbm_result($r_content_comments,$i,"comment"));
	$txt .= '<br clear="all" />';
	$txt .= '</div>';
}
$txt .= $jump_toLastComment;
?>