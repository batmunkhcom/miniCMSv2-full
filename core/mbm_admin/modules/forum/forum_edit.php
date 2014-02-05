<script language="javascript">
mbmSetContentTitle("<?=$lang["forum"]["forum_edit"]?>");
mbmSetPageTitle('<?=$lang["forum"]["forum_edit"]?>');
show_sub('menu10');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['addForum'])){
	$data['forum_id'] = $_POST['forum_id'];
	if( $data['forum_id'] == 0 ){
		$sub = 0;
	}else{
		$data['sub'] = $DB->mbm_get_field($data['forum_id'],'id','sub','forums') + 1;
	}
	$data['st'] = $_POST['st'];
	$data['lev'] = $_POST['lev'];
	$data['sticky'] = $_POST['sticky'];
	$data['announcement'] = $_POST['announcement'];
	$data['name'] = $_POST['name'];
	$data['comment'] = $_POST['comment'];
	$data['valid_days'] = $_POST['valid_days'];
	$data['lang'] = $_SESSION['ln'];
	$data['date_lastupdated'] = mbmTime();
	$data['total_updated'] = $DB->mbm_get_field($_GET['id'],'id','total_updated','forums') + 1;
	$data['session_id'] = session_id();
	$data['session_time'] = mbmTime();

	if(mbmCheckEmptyfield($data)){
		$result_txt = $lang['error']['empty_field'];
	}else{
		if($DB->mbm_update_row($data,'forums',$_GET['id'])==1){
			$result_txt = $lang["forum"]["command_edit_processed"];
			$b=1;
			mbmForumUpdate($_GET['id'],$data['sub']);
		}else{
			$result_txt = $lang["forum"]["command_edit_failed"];
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
if($DB->mbm_check_field('id',$_GET['id'],'forums')==1){
	$q_forum_edit = "SELECT * FROM ".PREFIX."forums WHERE id='".$_GET['id']."'";
	$r_forum_edit = $DB->mbm_query($q_forum_edit);
}else{
	$b=1;
	echo '<div id="query_result">'.$lang["forum"]["no_such_forum"].'</div>';
}
if($b!=1){
?>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
    <tr class="list_header">
      <td width="40%">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang["forum"]["forum_select"]?>:<br />
        <select name="forum_id" id="forum_id">
          <option value="0">
          <?= $lang['forum']['set_as_main']?>
          </option>
          <?=mbmForumCatOptions(0,$DB->mbm_result($r_forum_edit,0,"forum_id")); ?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang['main']['status']?>
        :<br />
        <select name="st" id="st">
          <?=mbmShowStOptions($DB->mbm_result($r_forum_edit,0,"st"))?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang['main']['level']?>
        :<br />
        <select name="lev">
          <?= mbmIntegerOptions(0, $_SESSION['lev'],$DB->mbm_result($r_forum_edit,0,"lev")); ?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang["forum"]["sticky"]?>:<br />
        <select name="sticky" id="sticky">
          <option value="0"><?=$lang['main']['no']?></option>
          <option value="1" <?
          if($DB->mbm_result($r_forum_edit,0,"sticky")==1){
		  	echo 'selected';
		  }
		  ?>><?=$lang['main']['yes']?></option>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang["forum"]["announcement"]?>:<br />
        <select name="announcement" id="announcement">
          <option value="0"><?=$lang['main']['no']?></option>
          <option value="1" <?
          if($DB->mbm_result($r_forum_edit,0,"announcement")==1){
		  	echo 'selected';
		  }
		  ?>><?=$lang['main']['yes']?></option>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang["forum"]["valid_days"]?><br />
      <input name="valid_days" type="text" id="valid_days" value="<?=$DB->mbm_result($r_forum_edit,0,"valid_days")?>" size="45" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang["forum"]["forum_name"]?>:<br />
      <input name="name" type="text" id="name" value="<?=$DB->mbm_result($r_forum_edit,0,"name")?>" size="45" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang["forum"]["forum_comment"]?>:<br />
        <textarea name="comment" cols="45" rows="5" id="comment"><?=$DB->mbm_result($r_forum_edit,0,"comment")?></textarea></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" name="addForum" id="addForum" value="<?=$lang["forum"]["button_forum_edit"]?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?
}
?>