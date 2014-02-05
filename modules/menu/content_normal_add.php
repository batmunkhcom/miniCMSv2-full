<?
if($mBm!=1){
	echo '<div id="query_result">direct access not allowed</div>';
}elseif($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==0){
	echo '<div id="query_result">Please login first.</div>';
}else{
	if(isset($_POST['addNormalNews'])){
		
		$menus_ids = ',';
		if(is_array($_POST['menus'])){
			foreach($_POST['menus'] as $k=>$v){
				$menus_ids .= $v.',';
			}
		}
		$data['menu_id'] = $menus_ids;
		$data['user_id'] = $_SESSION['user_id'];
		$data['st'] = $_POST['st'];
		$data['lev'] = $_POST['lev'];
		$data['title'] = $_POST['title'];
		$data['content_short'] = $_POST['content_short'];
		$data['content_more'] = $_POST['content_more'];
		$data['show_title'] = $_POST['show_title'];
		$data['show_content_short'] = $_POST['show_content_short'];
		$data['cleanup_html'] = $_POST['cleanup_html'];
		$data['use_comment'] = $_POST['use_comment'];
		$data['date_added'] = mbmTime();
		$data['date_lastupdated'] = $data['date_added'];

		if(ctype_alnum(str_replace(",","",$data['menu_id']))==false){
			$result_txt .= 'select at least 1 menu please.<br />';
		}elseif($DB->mbm_insert_row($data,"menu_contents")==1){
			$result_txt .= $lang["menu"]["command_add_processed"].'<br />';
			$b=1;
		}else{
			$result_txt .= $lang["menu"]["command_add_failed"].'<br />';
		}
			echo '<div id="query_result">'.$result_txt.'</div>';
	}
	if($b!=1){
	?><script language="javascript">
	
	
	</script><form action="" name="contentForm" id="contentForm" method="post" enctype="multipart/form-data">
			<table width="100%" border="0" cellspacing="2" cellpadding="3">
			  <tr>
				<td colspan="2"><div><?=$lang['menu']['select_menus']?>:<br />
					  <?
				echo mbmUserPermissionMenus("normal",$_SESSION['user_id']);
				
				?>
				</div></td>
			  </tr>
			  <tr>
				<td width="40%">
				  <?=$lang['menu']['content_title']?>:<br>
					<input name="title" type="text" id="title" size="45" class="input">		  </td>
				<td>&nbsp;</td>
			  </tr>
			  
			  <tr>
				<td><table width="100%" border="0" cellspacing="2" cellpadding="3">
				  <tr class="list_header">
					<td width="25%" align="center"><?=$lang['menu']['show_content_title']?>:</td>
					<td width="25%" align="center"><?=$lang['menu']['use_short_content']?>:</td>
					<td width="25%" align="center"><?=$lang['menu']['use_content_comment']?>:</td>
					<td width="25%" align="center"><?=$lang['menu']['cleanup_short_content']?></td>
				  </tr>
				  <tr>
					<td align="center" bgcolor="#f5f5f5"><input name="show_title" type="checkbox" id="show_title" value="1" checked></td>
					<td align="center" bgcolor="#f5f5f5"><input name="show_content_short" type="checkbox" id="show_content_short" value="1" checked></td>
					<td align="center" bgcolor="#f5f5f5"><input name="use_comment" type="checkbox" id="use_comment" value="1" checked></td>
					<td align="center" bgcolor="#f5f5f5"><input name="cleanup_html" type="checkbox" id="cleanup_html" value="1"></td>
				  </tr>
				</table></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2"><?
			//mbmShowHTMLEditor("both",'spaw2','spaw');
			mbmShowHTMLEditor("both",'spaw2','spaw','all',array(0=>'',1=>'')
							,'en','100%',"200px");
			?></td>
			  </tr>
			  <tr>
				<td><input type="submit" name="addNormalNews" id="addNormalNews" class="button" value="<?=$lang['menu']['normal_content_add']?>" /></td>
				<td>&nbsp;</td>
			  </tr>
			</table>
			</form>
	<?
	}
}
?>