<script language="javascript">
mbmSetContentTitle("<?=$lang["forum"]["forum_add"]?>");
mbmSetPageTitle('<?=$lang["forum"]["forum_add"]?>');
show_sub('menu10');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['addForum'])){
	$data['forum_id'] = $_POST['forum_id'];
	if( $data['forum_id'] > 0 ){
		$data['sub'] = $DB->mbm_get_field($data['forum_id'],'id','sub','forums') + 1;
	}
	$data['st'] = $_POST['st'];
	$data['lev'] = $_POST['lev'];
	$data['pos'] = mbmForumMaxPos($data['forum_id']) + 1;
	$data['sticky'] = $_POST['sticky'];
	$data['announcement'] = $_POST['announcement'];
	$data['name'] = $_POST['name'];
	$data['comment'] = $_POST['comment'];
	$data['valid_days'] = $_POST['valid_days'];
	$data['lang'] = $_SESSION['ln'];
	$data['date_added'] = mbmTime();
	$data['date_lastupdated'] = $data['date_added'];
	$data['session_id'] = session_id();
	$data['session_time'] = mbmTime();
	$data['user_id'] = $_SESSION['user_id'];

	if(mbmCheckEmptyfield($data)){
		$result_txt = $lang['error']['empty_field'];
	}else{
		if($DB->mbm_insert_row($data,'forums')==1){
			$result_txt = $lang["forum"]["command_add_processed"];
			$b=1;
			if($data['forum_id']>0){
				$DB->mbm_query("UPDATE ".PREFIX."forums SET total_forums=total_forums+1 WHERE id='".$data['forum_id']."'");
			}
		}else{
			$result_txt = $lang["forum"]["command_add_failed"];
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
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
          <?=mbmForumCatOptions(0); ?>
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
          <?=mbmShowStOptions($_POST['st'])?>
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
          <?= mbmIntegerOptions(0, 5,$_POST['lev']); ?>
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
          <option value="1"><?=$lang['main']['yes']?></option>
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
          <option value="1"><?=$lang['main']['yes']?></option>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang["forum"]["valid_days"]?>:<br />
      <input name="valid_days" type="text" id="valid_days" value="9999999999" size="45" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang["forum"]["forum_name"]?>:<br />
      <input name="name" type="text" id="name" size="45" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$lang["forum"]["forum_comment"]?>:<br />
        <textarea name="comment" cols="45" rows="5" id="comment"></textarea></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" name="addForum" id="addForum" value="<?=$lang["forum"]["button_forum_add"]?>" /></td>
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