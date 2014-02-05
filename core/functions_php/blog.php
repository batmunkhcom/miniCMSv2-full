<?
function mbmBlogResetPos($fieldname="cat_id",$fieldvalue=0,$tbl="blog_cats"){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX.$tbl." WHERE `".$fieldname."`='".$fieldvalue."' ORDER BY pos";
	$r = $DB->mbm_query($q);
	
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$DB->mbm_query("UPDATE ".PREFIX.$tbl." SET pos='".($i+1)."' WHERE `id`='".$DB->mbm_result($r,$i,"id")."'");
	}
	return true;
}

function mbmBlogDeleteContent($id){
	global $DB;

	$q = "SELECT * FROM ".PREFIX."blog_content WHERE `cat_id='".$id."' ORDER BY pos";
	$r = $DB->mbm_query($q);
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$DB->mbm_query("DELETE FROM ".PREFIX."blog_comment WHERE blog_content_id='".$DB->mbm_result($r,$i,"id")."'");
	}
	$DB->mbm_query("DELETE FROM ".PREFIX."blog_content WHERE cat_id='".$id."'");
	
	return true;
}

function mbmBlogDeleteCategory($id){
	global $DB;

	mbmBlogDeleteContent($id);
	$DB->mbm_query("DELETE FROM ".PREFIX."blog_cats WHERE id='".$id."'");

	return true;
}

function mbmBlogAddEditTab(){
	global $lang_blog;
	
	$buf = '';
	$buf .= '<div>';
	
	$buf .= '<a href="blog.php?module=blog&cmd=category&action=add">'.$lang_blog['blog']['cat_add'].'</a> | ';

	$buf .= '<a href="blog.php?module=blog&cmd=category&action=list">'.$lang_blog['blog']['cat_list'].'</a> | ';
	
	$buf .= '<a href="blog.php?module=blog&cmd=content_add&action=add">'.$lang_blog['blog']['content_add'].'</a> | ';
	
	$buf .= '<a href="blog.php?module=blog&cmd=content_add&action=list">'.$lang_blog['blog']['content_list'].'</a> | ';
	
	$buf .= '</div>';
	
	return $buf;
}

function mbmBlogIntegerOptions($ehleh,$hurtel,$selected_value=0){
	$buf= '';
	for($i=$ehleh;$i<=$hurtel;$i++){
		$buf .= '<option value="'.$i.'" ';
		if($selected_value==$i){
			$buf .= 'selected';
		}
		$buf .= '>'.$i.'</option>';
	}
	return $buf;
}

function mbmBlogShowCategoryCombobox($buf, $mid, $id=0){
	global $DB;
	
	$q_menu = "SELECT * FROM ".PREFIX."blog_cats WHERE cat_id='".$mid."' ORDER BY pos";
	$r_menu = $DB->mbm_query($q_menu);
	for($i=0;$i<$DB->mbm_num_rows($r_menu);$i++){
		if($id == $DB->mbm_result($r_menu,$i,"id")){
			$tmp= 'selected';
		}else{
			$tmp= '';
		}
		$buf .= '<option value="'.$DB->mbm_result($r_menu,$i,"id").'" '.$tmp.'>'.str_repeat("&nbsp;",($DB->mbm_result($r_menu,$i,"sub")*5)).$DB->mbm_result($r_menu,$i,"title").'</option>';		
	}
	return $buf;
}

function mbmBlogCategoryAdd()
{	
	global $lang_blog;
	
	$buf = '';
	$buf .= '<form name="form1" method="post" action="">';
  	$buf .= '<table width="100%" align="center">';
//	$buf .= '<tr><td width="40%" height="25" align="right">'.$lang_blog["blog"]["cat_id"].'</td>';
//	$buf .= '<td><select name="cat_id">';
//	$buf .= '<option value="0">'.$lang_blog['blog']['cat_set_as_main'].'</option>';
//	$buf .= mbmBlogShowCategoryCombobox('', 0).'</select></td></tr>';
	$buf .= '<tr><td height="25" align="right">'.$lang_blog['blog']['cat_name'].'</td>';
	$buf .= '<td><input type="text" name="cat_name" size="30" /></td></tr>';
	$buf .= '<tr><td height="25" align="right">'.$lang_blog['blog']['cat_st'].'</td>';
	$buf .= '<td><select name="cat_status">';
	$buf .= '<option value="0">'.$lang_blog['blog']['st_0'].'</option>';
	$buf .= '<option value="1">'.$lang_blog['blog']['st_1'].'</option>';
 	$buf .= '</select></td></tr>';
	$buf .=	'<tr><td height="25" align="right">'.$lang_blog['blog']['cat_verify'].'</td>';
	$buf .= '<td><select name="cat_verify">';
    $buf .= mbmBlogIntegerOptions(0, 1, 1).'</select></td></tr>';
  	$buf .= '<tr><td height="25" align="right">'.$lang_blog['blog']['cat_target'].'</td>';
  	$buf .= '<td><select name="cat_target">';
	$buf .= '<option value="_self">'.$lang_blog['blog']['link_target_self'].'</option>';
	$buf .= '<option value="_blank">'.$lang_blog['blog']['link_target_blank'].'</option>';
	$buf .= '</select></td></tr>';
    $buf .= '<tr><td height="25" align="right">'.$lang_blog['blog']['cat_link'].'</td>';
    $buf .= '<td><input name="linked" type="checkbox" value="1" />';
    $buf .= '&nbsp;'.$lang_blog['blog']['cat_http'].'<br />';
    $buf .= '<input type="text" name="cat_link" size="30" value="http://" /></td></tr>';
    $buf .= '<tr><td height="25" align="right">'.$lang_blog['blog']['cat_comment'].'</td>';
	$buf .= '<td><textarea name="cat_comment" cols="30"></textarea></td></tr>';
	$buf .= '<input type="hidden" name="_action" value="add" />';
	$buf .= '<tr><td height="25" align="right"></td>';
	$buf .= '<td><input type="submit" name="submit" value="'.$lang_blog['blog']['cat_add'].'"></td>';
	$buf .= '</table></form>';
	return $buf;
}

function mbmBlogCategoryEdit($id)
{
	global $DB, $lang_blog;
	
	$q_cat = "SELECT * FROM ".PREFIX."blog_cats WHERE ";
	if(isset($id) && $id !=0){
		$q_cat .= "id='".$id."'";
	}else{
		$q_cat .= "id='0'";
	}
	$r_cat = $DB->mbm_query($q_cat);
	for($i=0;$i<$DB->mbm_num_rows($r_cat);$i++){
	
	if($DB->mbm_result($r_cat,$i,"st") == 0){
		$stsel1 = 'selected';
		$stsel2 = '';
	}else{
		$stsel1 = '';
		$stsel2 = 'selected';
	}
	
	if($DB->mbm_result($r_cat,$i,"target") == '_self'){
		$trgrt1 = 'selected';
		$trgrt2 = '';
	}else{
		$trgrt1 = '';
		$trgrt2 = 'selected';
	}
	
	if($DB->mbm_result($r_cat,$i,"link") != 'http://'){
		$link_checked = 'checked"';
	}else{
		$link_checked = '';
	}
	
	$buf = '';
	$buf .= '<form name="form1" method="post" action="">
  			<table width="100%" align="center">';
//	$buf .= '<tr>';
//	$buf .= '<td width="40%" height="25" align="right">'.$lang_blog['blog']['cat_id'].'</td>';
//	$buf .= '<td>';
//	$buf .= '<select name="cat_id">';
//	$buf .= '<option value="0">'.$lang_blog['blog']['cat_set_as_main'].'</option>';
//	$buf .= mbmBlogShowCategoryCombobox('', 0, $DB->mbm_result($r_cat,$i,"cat_id")).'</select></td></tr>';
	$buf .= '<tr>
    		<td height="25" align="right">'.$lang_blog['blog']['cat_name'].'</td>
			<td><input type="text" name="cat_name" size="30" value="'.$DB->mbm_result($r_cat,$i,"title").'" /></td></tr>
			<tr>
			<td height="25" align="right">'.$lang_blog['blog']['cat_st'].'</td>
			<td>	  
			<select name="cat_status">
			<option value="0" '.$stsel1.'>'.$lang_blog['blog']['st_0'].'</option>
	  		<option value="1" '.$stsel2.'>'.$lang_blog['blog']['st_1'].'</option>
 	    	</select></td></tr>';
	$buf .=	'<tr>
      		<td height="25" align="right">'.$lang_blog['blog']['cat_verify'].'</td>
	  		<td><select name="cat_verify">
    		'.mbmBlogIntegerOptions(0, 1, $DB->mbm_result($r_cat,$i,"verify_comment")).'</select></td></tr>
  			<tr>
      		<td height="25" align="right">'.$lang_blog['blog']['cat_target'].'</td>
  	  		<td><select name="cat_target">
			<option value="_self" '.$trgt1.'>'.$lang_blog['blog']['link_target_self'].'</option>
			<option value="_blank" '.$trgt2.'>'.$lang_blog['blog']['link_target_blank'].'</option>
			</select></td></tr>
    		<tr>
      		<td height="25" align="right">'.$lang_blog['blog']['cat_link'].'</td>
      		<td><input name="linked" type="checkbox" '.$link_checked.' />
        	&nbsp;'.$lang_blog['blog']['cat_http'].'<br />
        	<input type="text" name="cat_link" size="30" value="'.$DB->mbm_result($r_cat,$i,"link").'" /></td></tr>
    		<tr>
			<td height="25" align="right">'.$lang_blog['blog']['cat_comment'].'</td>
			<td>
	  		<textarea name="cat_comment" cols="30">'.$DB->mbm_result($r_cat,$i,"comment").'</textarea></td></tr>
	  		<input type="hidden" name="_action" value="edit" />
			<input type="hidden" name="i_d" value="'.$id.'" />
			<tr>
			<td height="25" align="right">	</td>
			<td><input type="submit" name="submit" value="'.$lang_blog['blog']['cat_edit'].'"></td>
			</table>
			</form>';
		}
		return $buf;
}

function mbmBlogCategoryList($cat_id, $start, $per_page){
	
	global $DB, $lang_blog;
		
  	$q_cat = "SELECT * FROM ".PREFIX."blog_cats WHERE ";
	if(isset($cat_id) && $cat_id!='' ){
		$q_cat .= "cat_id='".$cat_id."'";
	}else{
		$q_cat .= "cat_id='0'";
	}
	$q_cat .= " ORDER BY pos";
	$r_cat = $DB->mbm_query($q_cat);
	
	$buf = '';	
	$buf .= mbmNextPrev("index.php?module=blog&cmd=category&action=list&cat_id=".$cat_id, $DB->mbm_num_rows($r_cat),$start, $per_page);
	
	$buf .=
		'<table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<tr class="list_header">
  		<td width="30" align="center">#</td>
    	<td width="200">'.$lang_blog['blog']['cat_name'].'</td>
    	<td width="70">'.$lang_blog['blog']['cat_st'].'</td>
    	<td >'.$lang_blog['blog']['cat_pos'].'</td>
    	<td width="200">&nbsp;'.$lang_blog['blog']['cat_link'].'</td>
    	<td width="70">'.$lang_blog['blog']['cat_target'].'</td>
    	<td width="50">&nbsp;</td>
		<td width="50">&nbsp;</td>
  		</tr>';
	
  	if(($start+$per_page) > $DB->mbm_num_rows($r_cat)){
		$end= $DB->mbm_num_rows($r_cat);
	}else{
		$end= $start+$per_page; 
	}

	for($i=$start;$i<$end;$i++){
		if($i%2 == 1){	$bg= 'bgcolor="#eeeeee"';
		}else{	$bg= '';	}			
    
  	$buf .= '<tr '.mbmonMouse("#e2e2e2","#d2d2d2","").' height="20"'.$bg.'>
  	<td align="center" class="bold">'.($i+1).'</td>
	<td><a ';
	if($DB->mbm_check_field('cat_id', $DB->mbm_result($r_cat,$i,"id"),'blog_cats')==0){
		$buf .=	' href="#" onClick="alert(\''.$lang_blog['error']['no_sub_menu'].'\')"';
	}else{
		$buf .= ' href="blog.php?module=blog&cmd=category&action=list&start='.$start.'&per_page='.$per_page.'&cat_id='.$DB->mbm_result($r_cat,$i,"id").'"';
	}
	$buf .= '>'.$DB->mbm_result($r_cat,$i,"title").'</a></td>
  	<td>
	<select name="cat_st" onchange="window.location=\''.DOMAIN.DIR.'blog.php?module=blog&cmd=category&action=list&id='.$DB->mbm_result($r_cat,$i,"id").'&st=\'+this.value+\'&actions=st&tbl=blog_cats\'">'.mbmShowStOptions($DB->mbm_result($r_cat,$i,"st")).'
	</select></td>
  	<td><select name="cat_pos" onchange="window.location=\''.DOMAIN.DIR.'blog.php?module=blog&cmd=category&action=list&id='.$DB->mbm_result($r_cat,$i,"id").'&pos=\'+this.value+\'&actions=pos&tbl=blog_cats\'">
	<option value="0">at the begin</option>';
	for($j=0;$j<$DB->mbm_num_rows($r_cat);$j++){
		$buf .= '<option value="'.($DB->mbm_result($r_cat,$j,"pos")+0.1).'" ';
		if($DB->mbm_result($r_cat,$j,"pos")==$DB->mbm_result($r_cat,$i,"pos")){
			$buf .= 'selected';
		}
			$buf .= '>After '.$DB->mbm_result($r_cat,$j,"title").'..</option>';
		}
		$buf .= '<option value="9999999999">at the end</option>';
	$buf .= '</select></td>
  	<td>&nbsp;'.$DB->mbm_result($r_cat,$i,"link").'</td>
  	<td><select name="cat_target" onchange="window.location=\''.DOMAIN.DIR.'blog.php?module=blog&cmd=category&action=list&id='.$DB->mbm_result($r_cat,$i,"id").'&target=\'+this.value+\'&actions=target&tbl=blog_cats\'">';
    $value= $DB->mbm_result($r_cat,$i,"target");
	$buf .= '<option value="_self" ';
	if($value=="_self") {
		$buf .=  'selected';
	}	
	$buf .= '> '.$lang_blog['blog']['link_target_self'];
	$buf .= '<option value="_blank" ';
	if($value=="_blank"){
		$buf .= 'selected';
	}
	$buf .= '> '.$lang_blog['blog']['link_target_blank'];
	$buf .= '</select></td>
    <td><input name="edit" type="button" value="'.$lang_blog['blog']['edit'].'" onclick="window.location=\'blog.php?module=blog&cmd=category&action=edit&start='.$start.'&per_page='.$per_page.'&id='.$DB->mbm_result($r_cat,$i,"id").'\'" /></td>
  	<td><input name="delete" type="button" value="'.$lang_blog['blog']['delete'].'" onclick="confirmSubmit(\''.addslashes($lang_blog["confirm_del"]).'\',\'blog.php?module=blog&cmd=category&action=delete&start='.$start.'&per_page='.$per_page.'&id='.$DB->mbm_result($r_cat,$i,"id").'&cat_id='.$DB->mbm_result($r_cat,$i,"cat_id").'\')"/></td>
  	<tr height="1" bgcolor="#DDDDDD"><td colspan="12"></td></tr>
  	</tr>';
  	}
	
	$buf .= '</table>';
	
	return $buf;
}

function mbmBlogContentAdd(){
	$buf = '';
	
	$buf .='<form name="form1" method="post" action="">
 	<table width="100%" align="center">
    <tr>
    <td width="40%" height="25" align="right">'.$lang['blog']['cat_id'].'</td>
    <td><select name="menu_id">
	<option value="0">'.$lang['blog']['cat_choose'].'</option>
    '.mbmBlogShowCategoryCombobox('', 0).'</select></td>
    <tr>
    <td height="25" align="right">'.$lang['blog']['content_title'].'</td>
    <td><input type="text" name="cnt_title" size="60"></td>
    <tr>
    <td height="25" align="right">&nbsp;</td>
    <td><input name="show_title" type="checkbox" value="1">'.$lang['blog']['content_sh_title'].'</td>
    <tr>
	<tr>
    <td height="25" align="right">&nbsp;</td>
    <td><input name="show_short" type="checkbox" value="1">'.$lang['blog']['content_sh_sh'].'</td>
	<tr>
    <td height="25" align="right">&nbsp;</td>
    <td><input name="use_comment" type="checkbox" value="1">'.$lang['blog']['use_comment'].'</td>
    <tr>
    <tr>
    <td height="25" colspan="2" align="center">&nbsp;</td>
    <tr>
    <td height="25" colspan="2" align="center">'.$lang['blog']['content_short'].'</td>
    <tr>
    <td height="25" colspan="2" align="center">';
	$sw = new SPAW_Wysiwyg('content_short' /*name*/,stripslashes($HTTP_POST_VARS['content_short']) /*value*/,
                       'en' /*language*/, 'full' /*toolbar mode*/, 'default' /*theme*/,
                       '550px' /*width*/, '150px' /*height*/);
		
	$buf .=	$sw->show();
	$buf .= '</td>
    <tr>
    <td height="25" colspan="2" align="center">&nbsp;</td>
    <tr>
      <tr>
    <td height="25" colspan="2" align="center">'.$lang['blog']['content_more'].'</td>
    <tr>
    <td height="25" colspan="2" align="center">';
	$sw = new SPAW_Wysiwyg('content_more' /*name*/,stripslashes($HTTP_POST_VARS['content_more']) /*value*/,
                       'en' /*language*/, 'full' /*toolbar mode*/, 'default' /*theme*/,
                       '550px' /*width*/, '150px' /*height*/);
		
	$buf .=	$sw->show();
	$buf .= '</td>
    <tr>
    <td height="25" align="right"></td>
    <td><input type="submit" name="Submit" value="'.$lang['blog']['content_add'].'"></td>
  	</table></form>';
	
	return $buf;
}

function mbmBlogContentEdit(){
	$buf ='';
	
	return $buf;
}

function mbmBlogContentList(){
	$buf ='';

	return $buf;
}

?>
