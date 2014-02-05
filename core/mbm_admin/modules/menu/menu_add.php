<script language="javascript">
mbmSetContentTitle("<?= $lang['menu']['menu_add']?>");
mbmSetPageTitle('<?= $lang['menu']['menu_add']?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['menu_id']))
	{	
		$data['menu_id']= $_POST['menu_id'];
		
		if($_POST['menu_id'] == 0){
			$data['sub']= '0';
		}else{
			$data['sub']= $DB->mbm_get_field($_POST['menu_id'], 'id','sub', 'menus') + 1;
		}
		
		$data['lev']= $_POST['menu_lev'];
		$data['st']= $_POST['menu_status'];
		
		$data['pos']= mbmMenuMaxPos($data['menu_id']) + 1;
		
		if(isset($_POST['linked'])){ 
			$data['link']= $_POST['menu_link']; 
		}else{ 
			$data['link']= 'http://'; 
		}	
		$data['target']= $_POST['menu_target'];
		$data['lang']= $_SESSION['ln'];
		$data['name']= $_POST['menu_name'];
		$data['use_comment']= $_POST['use_comment'];
		$data['use_html']= $_POST['use_html'];
		$data['date_added']= mbmTime();
		$data['date_lastupdated']=$data['date_added'];
		$data['per_page']= $_POST['menu_pp'];
		$data['user_id']= $_SESSION['user_id'];
			
		if(mbmCheckEmptyfield($data)){
			$result_txt = $lang['error']['empty_field'];
		}else{
			$data['comment']=$_POST['menu_comment'];
			$add_process = $DB->mbm_insert_row($data, 'menus');
			switch($add_process){
				case 0:
					$result_txt = $lang['menu']['add_failed'];
				break;
				case 1:
					$result_txt = $lang['menu']['add_success'];
					$b=1;
				break;
				case 2:
					$result_txt = $lang['menu']['add_exist'];
				break;
			}
			echo '<div id="query_result">'.$result_txt.'</div>';
		}
	}
if($b!=1){
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="50%" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['menu']['select_menus']?>:<br>
      <select name="menu_id">
        <option value="0">
          <?= $lang['menu']['set_as_main']?>
          </option>
        <?=mbmShowMenuCombobox(0); ?>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" bgcolor="#f5f5f5">&nbsp;</td>
    <td width="50%" bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['main']['level']?>:<br>
        <select name="menu_lev">
      <?= mbmIntegerOptions(0, 5); ?>
    </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['main']['status']?>:<br>
      <select name="menu_status">
        <option value="0">
          <?= $lang['status'][0]?>
          </option>
        <option value="1">
          <?= $lang['status'][1]?>
          </option>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["menu"]["per_page"]?>:<br>
      <input name="menu_pp" type="text" size="45" value="<?=PER_PAGE?>" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['menu']['use_content_comment']?>:<br>
      <select name="use_comment">
        <option value="0">
        <?=$lang['main']['no']?>
        </option>
        <option value="1">
        <?=$lang['main']['yes']?>
        </option>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['menu']['cleanup_short_content']?>:
      <br>
      <select name="use_html" id="use_html">
        <option value="0">
        <?=$lang['main']['no']?>
        </option>
        <option value="1">
        <?=$lang['main']['yes']?>
        </option>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["menu"]["menu_link"]?>:<br>
      <input name="linked" type="checkbox" value="1">
      <input name="menu_link" type="text" id="menu_link" value="http://" size="45"> 
      <?=$lang["menu"]["link_target"]?>
      <select name="menu_target" id="menu_target">
        <option value="_self"><?=$lang["menu"]["link_target_self"]?></option>
        <option value="_blank"><?=$lang["menu"]["link_target_blank"]?></option>
      </select>      </td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["menu"]["name"]?>:<br>
        <input name="menu_name" type="text" id="menu_name" size="45"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["menu"]["menu_comment"]?>:<br>
      <textarea name="menu_comment" cols="45" rows="3" id="menu_comment"></textarea></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" class="button" name="button" id="button" value="<?=$lang['menu']['button_menu_add']?>"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
</table>
</form>
<?
}
?>