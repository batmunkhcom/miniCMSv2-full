<?
function mbmShowContentComment($var=array(
									'content_id'=>0,
									'limit'=>10,
									'order_by'=>'id',
									'asc'=>'ASC',
									'show_title'=>0
									)
								){
	global $DB,$DB2;
	
	$q_comments = "SELECT * FROM ".PREFIX."menu_content_comments WHERE id!=0 ";
	if($content_id!=0){
		$q_comments .= "AND content_id='".$var['content_id']."' ";
	}
	$q_comments .= " ORDER BY ".$var['order_by']." ".$var['asc'];
	if($var['limit']!=0){
		$q_comments .= " LIMIT ".$var['limit'];
	}
	
	$r_comments = $DB->mbm_query($q_comments);
	
	$buf = '';
	for($i=0;$i<$DB->mbm_num_rows($r_comments);$i++){
		$content_menu_id = explode(',',$DB->mbm_get_field($DB->mbm_result($r_comments,$i,'content_id'),'id','menu_id','menu_contents'));
		$buf .= '<div class="contentCommentsA">';
			$buf .= '<div class="contentCommentsTitle">';
				$buf .= '<a href="index.php?module=menu&amp;cmd=content&amp;menu_id='
						.$content_menu_id[1]
						.'&amp;id='.$DB->mbm_result($r_comments,$i,'content_id').'">';
				if($var['show_title']==1){
					$c_title = $DB->mbm_get_field($DB->mbm_result($r_comments,$i,'content_id'),'id','title','menu_contents');
					if(mbm_strlen($c_title)>40){
						$buf .= mbm_substr($c_title,40).'...';
					}else{
						$buf .= $c_title;
					}
					$c_title = '';
				}
				$buf .= '</a>';
				if($DB->mbm_result($r_comments,$i,'user_id')!=0){
					$buf .= ' [<a href="#'.$DB->mbm_result($r_comments,$i,'user_id').'">'.$DB2->mbm_get_field($DB->mbm_result($r_comments,$i,'user_id'),'id','username','users').'</a>]';
					$buf .= ' ';
				}
				$buf .= '<span style="font-weight:normal; color:#333333;">[ '.mbmTimeConverter($DB->mbm_result($r_comments,$i,'date_added')).' ]</span>';
			$buf .= '</div>';
			$buf .= '<div class="contentCommentsContent">';
			if($DB->mbm_result($r_comments,$i,"user_id")==0){
				$avatar_img = INCLUDE_DOMAIN.'images/guest.gif';
			}else{
				$avatar_img = DOMAIN.DIR.'modules/users/avatar_show.php?id='.$DB2->mbm_get_field($DB->mbm_result($r_comments,$i,"user_id"),'user_id','id','user_avatars');
			}
			$buf .= '<img src="'.$avatar_img.'" 
						 style="float:left" 
						 hspace="5" 
						 width="50" 
						 class="userAvatar"
						 title="'.addslashes($DB->mbm_result($r_comments,$i,"name")).'"
						alt="'.addslashes($DB->mbm_result($r_comments,$i,"name")).'" />';
				$buf .= str_replace("&lt;br /&gt;","<br />",mbmCleanUpHTML($DB->mbm_result($r_comments,$i,'comment')));
				$buf .= '<br clear="all" />';
			$buf .= '</div>';
		$buf .= '</div>';
	}
	return $buf;
}
function mbmShowContentCommentForm($content_id=0){
	global $DB,$DB2,$lang;
	
	$buf = '<br clear="both" />';
	$buf .= '<form action="" method="POST" name="contentCommentForm" id="contentCommentForm" >';
		$buf .= '<div id="contentCommentFormTitle">';
			$buf .= $lang["menu"]["content_comment_add"];
		$buf .= '</div>';
	
		$buf .= '<div>';
			$buf .= $lang["menu"]["content_comment_name"].'<br />';
			$buf .= '<input type="text" name="comment_name" id="comment_name" size="45" ';
			if($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==1){
				$buf .= 'value="'.$DB2->mbm_get_field($_SESSION['user_id'],'id','username','users').'" ';
				$buf .= 'disabled="disabled" ';
			}
			$buf .= 'class="input" />';
		$buf .= '</div>';
		$buf .= '<div>';
			$buf .= $lang["menu"]["content_comment"].'<br />';
			$buf .= '<textarea cols="45" rows="5" id="comment_content" name="comment_content" class="textarea"></textarea>';
		$buf .= '</div>';
		$buf .= '<div id="Krilleer" style="font-family:Tahoma; margin-bottom:12px;"></div>';
		$buf .= '<div>';
			$buf .= '<input type="hidden" name="content_id"  id="content_id" value="'.$content_id.'">';
			$buf .= '<input type="submit" name="commentSubmit" id="commentSubmit" class="button" value="'.$lang["menu"]["button_content_comment"].'">';
		$buf .= '</div>';		
	$buf .= '</form>';
	$buf .= '<div id="contentComments"></div>';
	$buf .= '<div id="moreContentComments" style="cursor:pointer; margin-bottom:20px; clear:both; display:block;"><strong>Өмнөх сэтгэгдлүүд &raquo;</strong></div>';
	$buf .= mbmKharAduutBoldTextarea('comment_content');
	$buf1 .= "<script language=\"javascript\">
		//setTimeout(\"mbmLoadXML('GET','xml.php?action=content_comment&amp;content_id=".$content_id."',mbmContentComments)\",5000);
		</script>";

	return $buf;
}
?>