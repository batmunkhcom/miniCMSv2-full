<?	

function mbmBlogInstruction(){


	return 'Та БЛОГ үүёгэхийн тулд ГИШҮҮН болсон байх ёстой. ';
}

function mbmBlogUserLoginForm(){
	global $lang_blog;

	$buf = '<form name="form1" method="post" action="blog.php?login_action=userLogin">
	  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="loginTBL">
		<tr>
		  <td colspan="2" class="loginTitle">'.$lang_blog['users']['login_title'].'</td>
		</tr>
		<tr>
		  <td width="30%" align="right">'.$lang_blog['users']['login_username'].'</td>
		  <td><input type="text" size="15" name="username" id="username" class="input"></td>
		</tr>
		<tr>
		  <td align="right">'.$lang_blog['users']['login_password'].'</td>
		  <td><input type="password" size="15" name="password" id="password" class="input"></td>
		</tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td><input type="submit" name="loginButton" class="button" id="loginButton" value="'.$lang_blog['users']['login_button'].'"></td>
		</tr>
		<tr>
		  <td colspan="2" align="center"><a href="#">'.$lang_blog['users']['login_forgotpass'].'</a> | 
		  <a href="index.php?module=users&amp;cmd=registration">'.$lang_blog['users']['login_signup'].'</a></td>
		</tr>
	  </table>
	</form>
	';
	return $buf;
}

function mbmLastBlogContents($htmls, $limit=10){
	global $DB, $lang_blog;
	
	$qry = "SELECT * FROM ".PREFIX."blog_contents LIMIT ".$limit;
	$res = $DB->mbm_query($qry);
	
	$buf = '';
	$buf .= $htmls[0];
	for($i=0; $i< $DB->mbm_num_rows($res); $i++){
		$buf .= $htmls[2];
		$buf .= '<a class="blog_cat_link" href="blog.php?module=blog&cmd=content&blog_id='.$DB->mbm_result($res, $i, "blog_id").'&id='.$DB->mbm_result($res, $i, "id").'&cat_id='.$DB->mbm_result($res, $i, "cat_id").'" target="_blank">'.$DB->mbm_result($res, $i, "title").'</a>';
		$buf .= $htmls[3];	
	}
	
	$buf .= $htmls[1];
	
	return $buf;
}

function mbmComplex($b_id, $htmls, $tbl, $where, $order, $desc, $limit, $print){
		global $DB, $lang_blog;
		
		$qry = "SELECT * FROM ".PREFIX.$tbl.$where."ORDER BY ".$order." ".$desc." LIMIT ".$limit;
		$res = $DB->mbm_query($qry);
		
		$buf = '';
		$buf .= $htmls[0];
		$buf .= $htmls[4];
		$buf .= $htmls[5];
		for($i=0; $i< $DB->mbm_num_rows($res); $i++){
			$buf .= $htmls[2];
			if($print == "username"){
				$buf .= '<a class="blog_cat_link" href="blog.php?blog_id='.$DB->mbm_result($res, $i, "id").'" targt="_self">'.$DB->mbm_result($res, $i, "username").'</a>';
			}else{
				$buf .= '<a class="blog_cat_link" href="blog.php?module=blog&cmd=content&blog_id='.$DB->mbm_result($res, $i, "blog_id").'&id='.$DB->mbm_result($res, $i, "id").'&cat_id='.$DB->mbm_result($res, $i, "cat_id").'" target="_self">'.$DB->mbm_result($res, $i, "title").'</a>';
			}
			$buf .= $htmls[3];	
		}
		
		$buf .= $htmls[1];
		return $buf;
}

function mbmBlogShowContentComment($blog_id, $content_id=0){
	global $DB, $lang_blog;
	
	$q_comments = "SELECT * FROM ".PREFIX."blog_comments WHERE blog_content_id=".$content_id." ORDER BY id";
	$r_comments = $DB->mbm_query($q_comments);
	
	$buf = '';

	for($i=0;$i<$DB->mbm_num_rows($r_comments);$i++){
		$buf .= '<div id="BlogcontentComments">';
		$buf .= '<div id="BlogcontentCommentsTitle">';
		if($DB->mbm_result($r_comments,$i,'user_id') == 0){
			$buf .= $lang_blog['blog']['guest'].'</div>';
		}else{
			$buf .= $DB->mbm_get_field($DB->mbm_result($r_comments,$i,'user_id'),'id','username','users').'</div>';
		}
		$buf .= '<div id="BlogcontentDate">'.mbmTimeConverter($DB->mbm_result($r_comments,$i,'date_added'));
		$buf .= ' ('.$DB->mbm_result($r_comments,$i,'ip').')</div>';
		$buf .= '<div>'.$DB->mbm_result($r_comments,$i,'comment').'</div>';

		$buf .= '</div>';
	}
	return $buf;
}
function mbmBlogShowContentCommentForm($blog_id, $content_id=0){
	global $DB, $lang_blog;
	
	$buf = mbmBlogShowContentComment($blog_id, $content_id);
	$buf .= '<form action="" method="POST">';
		$buf .= '<div id="BlogcontentCommentFormTitle">';
			$buf .= $lang_blog['blog']['add_comment'];
		$buf .= '</div>';
		$buf .= '<div>';
			$buf .= '<textarea name="addcomment" cols="45" rows="5" class="textarea"></textarea>';
		$buf .= '</div>';
		$buf .= '<div>';
		$buf .= '<input name="i_d" type="hidden" value="'.$content_id.'">';
		$buf .= '<input name="submit_comment" type="submit" class="button" value="'.$lang_blog['blog']['insert'].'">';
		$buf .= '</div>';		
	$buf .= '</form>';
	
	return $buf;
}

function mbmBlogShowContentMore($blog_id, $htmls=array('','','',''), $id){
	global $DB, $lang_blog;

	$q_cnt = "SELECT * FROM ".PREFIX."blog_contents WHERE id='".$id."'";
	$r_cnt = $DB->mbm_query($q_cnt); 
	$buf = $htmls[0]; 
	$buf .= $htmls[2]; 

		if($DB->mbm_result($r_cnt,$i,"show_title")==1){
			$buf .= '<span id="BlogcontentTitle">'.$DB->mbm_result($r_cnt,$i,"title").'</span><br />';
		}
		if($DB->mbm_result($r_cnt,0,"show_content_short")){
			$buf .= '<span id="BlogcontentShort">';
	  		$buf .= stripslashes($DB->mbm_result($r_cnt,0,"content_short"));
			$buf .= '</span><br />';
		}
		$buf .= '<br /><span id="BlogcontentDate">'.$lang_blog['blog']['date_added'].'<strong>'.date("Y/m/d", $DB->mbm_result($r_cnt,0,"date_added")).'</span></strong><br />';
		$buf .= '<span id="BlogcontentMore">';
	  	$buf .= stripslashes($DB->mbm_result($r_cnt,0,"content_more"));
		$buf .= '</span><br />';

		$buf .= $htmls[3]; 
		$buf .= $htmls[1]; 
		
		if($DB->mbm_result($r_cnt,0,"hits") == 0 || $DB->mbm_result($r_cnt,0,"hits") == ''){
			$hts['hits'] =1;
		}else{
			$hts['hits'] = $DB->mbm_result($r_cnt,0,"hits") + 1;
		}
		$DB->mbm_update_row($hts, 'blog_contents', $id, 'id');
//		$buf .= mbmBlogShowContentComment($DB->mbm_result($r_cnt,0,"id"));
		$buf .= '<div>'.mbmBlogShowContentCommentForm($blog_id, $id).'</div>';
	return $buf;
}

function mbmBlogShowContentShort($blog_id, $htmls=array('','','',''), $cat_id, $start, $per_page, $archive=0){
	global $DB, $lang_blog;
	
	$q_cnt = "SELECT * FROM ".PREFIX."blog_contents WHERE cat_id='".$cat_id."' ORDER BY date_added DESC";
	
	$buf = $htmls[0]; 
	$r_cnt = $DB->mbm_query($q_cnt); 

	if($DB->mbm_num_rows($r_cnt) == 0){
		$buf .= '<div class="red">&nbsp;</div>';
	}else{
		if($DB->mbm_num_rows($r_cnt) > $per_page){
			$buf .= '<div>'.mbmNextPrev('blog.php?module=blog&cmd=content&blog_id='.$blog_id.'&cat_id='.$cat_id, $DB->mbm_num_rows($r_cnt),$start, $per_page).'</div>';
		}
	
		if(($start+$per_page) > $DB->mbm_num_rows($r_cnt)){
			$end= $DB->mbm_num_rows($r_cnt);
		}else{
			$end= $start+$per_page; 
		}
	
		for($i=$start;$i<$end;$i++){
			$buf .= $htmls[2];
			if($DB->mbm_result($r_cnt,$i,"show_title")==1){
				$buf .= '<span id="BlogcontentTitle">'.$DB->mbm_result($r_cnt,$i,"title").'</span><br />';
			}
				$buf .= '<span id="BlogcontentDate">'.$lang_blog['blog']['date_added'].': <strong>'.date("Y/m/d", $DB->mbm_result($r_cnt,$i,"date_added")).'</span></strong><br />';
				$buf .= '<span id="BlogcontentDate">'.$lang_blog['blog']['total_comments'].':   <strong>'.$DB->mbm_result($r_cnt,$i,"total_comments").'</span></strong><br />';
			if(strlen($DB->mbm_result($r_cnt,$i,"content_short"))<10){
				$buf .= '<span id="BlogcontentShort">';
				$buf .= stripslashes($DB->mbm_result($r_cnt,$i,"content_more"));
				$buf .= '</span>';
			}else{
				$buf .= '<span id="BlogcontentShort">';
				$buf .= stripslashes($DB->mbm_result($r_cnt,$i,"content_short"));
				$buf .= '</span>';
			}
			
 			$buf .= '<br /><a class="BlogcontentMoreLink" href="blog.php?module=blog&cmd=content&blog_id='.$blog_id.'&id='.$DB->mbm_result($r_cnt,$i,"id").'&cat_id='.$cat_id.'">'.$lang_blog['blog']['more'].'</a></p>';
			
			$buf .= $htmls[3];
		}
	}
	$buf .= $htmls[1]; 
	
	return $buf;
}

function mbmBlogShowContentArchive($blog_id, $htmls=array('','','',''), $cat_id, $start, $per_page, $archive=0){
	global $DB, $lang_blog;
	
	$q_cnt = "SELECT * FROM ".PREFIX."blog_contents WHERE blog_id=".$blog_id." ORDER BY date_added DESC";
	
	$buf = $htmls[0]; 
	$r_cnt = $DB->mbm_query($q_cnt); 

	if($DB->mbm_num_rows($r_cnt) == 0){
		$buf .= '<div class="red">&nbsp;</div>';
	}else{
		if($DB->mbm_num_rows($r_cnt) > $per_page){
			$buf .= '<div>'.mbmNextPrev('blog.php?module=blog&cmd=content&blog_id='.$blog_id.'&cat_id='.$cat_id, $DB->mbm_num_rows($r_cnt),$start, $per_page).'</div>';
		}
	
		if(($start+$per_page) > $DB->mbm_num_rows($r_cnt)){
			$end= $DB->mbm_num_rows($r_cnt);
		}else{
			$end= $start+$per_page; 
		}
	
		for($i=$start;$i<$end;$i++){
			if(date("Y-m", $DB->mbm_result($r_cnt, $i,"date_added")) == $archive){
			$buf .= $htmls[2];
			if($DB->mbm_result($r_cnt,$i,"show_title")==1){
				$buf .= '<span id="BlogcontentTitle">'.$DB->mbm_result($r_cnt,$i,"title").'</span><br />';
			}
			$buf .= '<span id="BlogcontentDate">'.$lang_blog['blog']['date_added'].': <strong>'.date("Y/m/d", $DB->mbm_result($r_cnt,$i,"date_added")).'</span></strong><br />';
			$buf .= '<span id="BlogcontentDate">'.$lang_blog['blog']['total_comments'].':   <strong>'.$DB->mbm_result($r_cnt,$i,"total_comments").'</span></strong><br />';
			if(strlen($DB->mbm_result($r_cnt,$i,"content_short"))<10){
				$buf .= '<span id="BlogcontentShort">';
				$buf .= stripslashes($DB->mbm_result($r_cnt,$i,"content_more"));
				$buf .= '</span>';
			}else{
				$buf .= '<span id="BlogcontentShort">';
				$buf .= stripslashes($DB->mbm_result($r_cnt,$i,"content_short"));
				$buf .= '</span>';
			}
			
 			$buf .= '<br /><a class="BlogcontentMoreLink" href="blog.php?module=blog&cmd=content&blog_id='.$blog_id.'&id='.$DB->mbm_result($r_cnt,$i,"id").'&cat_id='.$cat_id.'">'.$lang_blog['blog']['more'].'</a></p>';
			
			$buf .= $htmls[3];
			}
		}
	}
	$buf .= $htmls[1]; 
	
	return $buf;
}

?>
