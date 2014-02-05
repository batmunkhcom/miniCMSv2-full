<script language="javascript">
mbmSetContentTitle("<?=$lang["web"]["edit_weblink"]?>");
mbmSetPageTitle('<?=$lang["web"]["edit_weblink"]?>');
show_sub('menu9');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_POST['updateLink'])){
	if(mbmCheckURL($_POST['url'])==0){
		$result_txt = 'Invalid web address';
	}elseif(strlen($_POST['name'])<3){
		$result_txt = 'please insert longer name';
	}elseif(strlen($_POST['comment'])<3){
		$result_txt = 'please insert longer web description';
	}elseif(strlen($_POST['keywords'])<3){
		$result_txt = 'please insert longer keword';
	}else{
		$data['cat_id']=$_POST['cat_id'];
		$data['name']=$_POST['name'];
		$data['st']=$_POST['st'];
		$data['lev']=$_POST['lev'];
		$data['comment']=$_POST['comment'];
		$data['keywords']=$_POST['keywords'];
		$data['url']=$_POST['url'];
		$data['user_id']=$_SESSION['user_id'];
		$data['date_lastupdated']=mbmTime();
		if($DB->mbm_update_row($data,"web_links",$_GET['id'])==1){
			$result_txt = 'update command processed.';
			$b=1;
		}else{
			$result_txt = 'update command failed.';
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
$q_weblink_edit = "SELECT * FROM ".PREFIX."web_links WHERE id='".$_GET['id']."'";
$r_weblink_edit = $DB->mbm_query($q_weblink_edit);
if($DB->mbm_num_rows($r_weblink_edit)!=1){
	echo '<div id="query_result">No such link exists.</div>';
}elseif($b!=1){
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="50%" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" bgcolor="#f5f5f5">Select cat:<br>
      <select name="cat_id" size="5" id="cat_id" class="input">
      <?=mbmWebCatsDropDown(0,$DB->mbm_result($r_weblink_edit,0,"cat_id"))?>
      </select>    </td>
    <td width="50%" bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"> level:<br>
        <select name="lev" id="lev" class="input">
          <?= mbmIntegerOptions(0, $_SESSION['lev'],$DB->mbm_result($r_weblink_edit,0,"lev")); ?>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">status:<br>
        <select name="st" id="st" class="input">
          <option value="0">
          <?= $lang['status'][0]?>
          </option>
          <option value="1" <?
          	if($DB->mbm_result($r_weblink_edit,0,"st")==1){
				echo ' selected ';
			}
		  ?>>
          <?= $lang['status'][1]?>
          </option>
      </select></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">Name:<br>
      <input name="name" type="text" id="name" size="45" value="<?=$DB->mbm_result($r_weblink_edit,0,"name")?>"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">Web address:<br>
      <input name="url" type="text" id="url" size="45" value="<?
	  if(strlen($DB->mbm_result($r_weblink_edit,0,"url"))>10){
	  	echo $DB->mbm_result($r_weblink_edit,0,"url");
	  }else{
	  	echo 'http://';
	  }?>"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">Description:<br>
      <textarea name="comment" cols="45" rows="3" id="comment"><?=$DB->mbm_result($r_weblink_edit,0,"comment")?></textarea></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">keywords:<br>
      <textarea name="keywords" cols="45" rows="3" id="keywords"><?=$DB->mbm_result($r_weblink_edit,0,"keywords")?></textarea></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" class="button" name="updateLink" id="updateLink" value="update link"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
 </table> 
</form>
<?
}
?>