<script language="javascript">
mbmSetContentTitle("<?= $lang['menu']['edit']?>");
mbmSetPageTitle('<?= $lang['menu']['edit']?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}

$c_mid = $_GET['id'];

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
		
		if($data['menu_id']!=$DB->mbm_get_field($data['menu_id'],'id','menu_id','menus')){
			$data['pos']= $DB->mbm_get_field($data['menu_id'],'id','pos','menus') + 1;
		}
		if(isset($_POST['linked']))
			{ $data['link']= $_POST['menu_link']; }	
		else
			{ $data['link']= 'http://'; }	
		$data['target']= $_POST['menu_target'];
		$data['lang']= $_SESSION['ln'];
		$data['name']= $_POST['menu_name'];
		$data['use_comment']= $_POST['use_comment'];
		$data['use_html']= $_POST['use_html'];
		$data['date_lastupdated']= mbmTime();
		$data['total_updated']= $DB->mbm_get_field($c_mid,"id","total_updated","menus")+1;
		$data['users_updated']= $DB->mbm_get_field($c_mid,"id","users_updated","menus").','
								.$_SESSION['user_id'].':'.date("Y/m/d H:i:s",$data['date_lastupdate']);
		$data['per_page']= $_POST['menu_pp'];
			
		if(mbmCheckEmptyfield($data)){
			$result_txt = $lang['error']['empty_field'];
		}else{
			$data['comment']=$_POST['menu_comment'];
			$add_process = $DB->mbm_update_row($data, 'menus',$c_mid);
			switch($add_process){
				case 0:
					$result_txt = $lang['menu']['update_failed'];
				break;
				case 1:
					$result_txt = $lang['menu']['update_success'];
					$b=1;
				break;
			}
			echo '<div id="query_result">'.$result_txt.'</div>';
		}
	}
if($b!=1){
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang['menu']['select_menus']?>:<br>
      <select name="menu_id">
        <option value="0">
          <?= $lang['menu']['set_as_main']?>
          </option>
        <?=mbmShowMenuCombobox(0,$DB->mbm_get_field($c_mid,"id","menu_id","menus")); ?>
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
      <?= mbmIntegerOptions(0, 5, $DB->mbm_get_field($c_mid,"id","lev","menus")); ?>
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
        <option value="1" <?
			if($DB->mbm_get_field($c_mid,"id","st","menus")==1){
				echo 'selected';
			}
        ?>>
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
      <input name="menu_pp" type="text" size="45" value="<?=$DB->mbm_get_field($c_mid,"id","per_page","menus")?>" /></td>
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
        <option value="1" <?
			if($DB->mbm_get_field($c_mid,"id","use_comment","menus")==1){
				echo 'selected';
			}
        ?>>
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
        <option value="1" <?
			if($DB->mbm_get_field($c_mid,"id","use_html","menus")==1){
				echo 'selected';
			}
        ?>>
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
      <input name="linked" type="checkbox" value="1" <?
      if($DB->mbm_get_field($c_mid,"id","link","menus")!='http://'){
	  	echo 'checked';
	  }
	  ?>>
      <input name="menu_link" type="text" id="menu_link" value="<?=$DB->mbm_get_field($c_mid,"id","link","menus")?>" size="45"> 
      <?=$lang["menu"]["link_target"]?>
      <select name="menu_target" id="menu_target">
        <option value="_self"><?=$lang["menu"]["link_target_self"]?></option>
        <option value="_blank" <?
			if($DB->mbm_get_field($c_mid,"id","target","menus")=='_blank'){
				echo 'selected';
			}
        ?>><?=$lang["menu"]["link_target_blank"]?></option>
      </select>      </td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["menu"]["name"]?>:<br>
        <input name="menu_name" value="<?=$DB->mbm_get_field($c_mid,"id","name","menus")?>" type="text" id="textfield4" size="45"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["menu"]["menu_comment"]?>:<br>
      <textarea name="menu_comment" cols="45" rows="3" id="menu_comment"><?=$DB->mbm_get_field($c_mid,"id","comment","menus")?></textarea></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" class="button" name="button" id="button" value="<?=$lang['menu']['button_menu_edit']?>"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
</table>
</form>
<?
}
?>