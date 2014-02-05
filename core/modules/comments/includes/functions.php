<?
function mBmCommentsForm($code='',$input_size=30,$textarea_cols=20){
	global $DB,$DB2;
	global $lang;
	
	$buf = '<form action="" method="post" name="formComments" id="formComments" >';
		$buf .= '<div id="commentsTitle">'.$lang['comments']['title'].'</div>';
		$buf .= '<div><input type="text" id="usernameComments" name="usernameComments" size="'.$input_size.'" value="';
		if( 1 == $DB2->mbm_check_field('id',$_SESSION['user_id'],'users') ){
			$buf .= $DB2->mbm_get_field($_SESSION['user_id'],'id','username','users');
			$buf .= '" disabled="disabled';
		}else{
			$buf .= $lang['comments']['guest'];
		}
		$buf .= '" class="commentsInput" /></div>';
		$buf .= '<div><textarea name="commentsContent" id="commentsContent" cols="'.$textarea_cols.'" class="commentsTextarea" ></textarea></div>';
		$buf .= '<div id="Krilleer" style="margin-bottom:12px;"></div>';
		$buf .= '<input type="hidden" name="commentCode" id="commentCode" value="'.$code.'" />';
		
		$captcha = rand(10000000,99999999);
		$_SESSION['captcha_'.$code] = $captcha;
		$buf .= '<div><img src="'.DOMAIN.DIR.'img.php?type=txt&txt='.$captcha.'&w=75&h=25" align="absmiddle" border="1" /> &laquo; '.$lang['comments']['captcha_code'].'<br />';
			$buf .= '<input type="text" name="captcha" id="captcha" size="12" /> &laquo; '.$lang['comments']['captcha_verfication_insert'];
		$buf .= '</div>';
		
		$buf .= '<div><input type="submit" name="submitComments" id="submitComments" value="'.$lang['comments']['button_submit'].'" /></div>';
	$buf .= '</form>';
	$buf .= '<div id="commentsLoading" style="display:block;"><img src="'.DOMAIN.DIR.'/images/loading.gif" border="0" /></div>';
	$buf .= '<div id="commentsResult"></div>';
	$buf .= mbmKharAduutBoldTextarea('commentsContent');
	return $buf;
}
function mbmCommentsList($var=array(
									'code'=>0,
									'code_like'=>0,
									'order_by'=>'id',
									'asc'=>'desc',
									'limit'=>10
									)){
	global $DB,$DB2,$lang;
	$q = "SELECT * FROM ".PREFIX."comments WHERE content!='' ";
		if($var['code']!=0){
			if($var['code_like']==1){
				$q .= "AND code LIKE '".$var['code']."%'";
			}else{
				$q .= "AND code='".$var['code']."'";
			}
		}
	$q .= "ORDER BY ".$var['order_by']." ".$var['asc']." LIMIT ".$var['limit']."";
	
	$r = $DB->mbm_query($q);
	
	$buf = '<div class="moduleComment">';
	
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$buf .= '<div class="moduleCommentTitle">';
			$extract_code = explode("_",$DB->mbm_result($r,$i,'code'));
			
			switch($extract_code[0]){
				case 'shop':
					$c_product_name = $DB->mbm_get_field($extract_code[1],'id','name','shop_products');
					$c_catid = mbmReturnShopCatId($DB->mbm_get_field($extract_code[1],'id','cat_ids','shop_products'));
					$c_link = DOMAIN.DIR.'index.php?module=shopping&amp;cmd=products&amp;cat_id='.$c_catid .'&id='.$extract_code[1];
					
					$buf .= '<a href="'.$c_link.'">';
						$buf .= $c_product_name;
					$buf .= '</a>';
				break;
				case 'w':
					$c_link = DOMAIN.DIR.'index.php?module=weather&cmd=bycode&code='.$extract_code[1];
					
					$buf .= '<a href="'.$c_link.'">';
						$buf .= $lang['weather']['code'][$extract_code[1]];
					$buf .= '</a>';
				break;
				case 'poll':
					$c_link = DOMAIN.DIR.'index.php?module=poll&cmd=view_vote&id='.$extract_code[1];
					
					$buf .= '<a href="'.$c_link.'">';
						$buf .= $DB->mbm_get_field($extract_code[1],'id','question_'.$_SESSION['ln'],'poll');
					$buf .= '</a>';
				break;
			}
		$buf .= '</div>';
		$buf .= '<div class="moduleCommentData">';
			$buf .= $DB->mbm_result($r,$i,'content');
		$buf .= '</div>';
		$buf .= '';
		$buf .= '';
		$buf .= '';
		$buf .= '';
		$buf .= '';
		$buf .= '';
	}
	
	$buf .= '</div>';
	return $buf;
}

function mbmReturnShopCatId($ids = ',0,'){
	$idnuud = explode(",",$ids);
	
	$total_id = (count($idnuud)-2);
	return $idnuud[rand(1,$total_id)];
}
?>