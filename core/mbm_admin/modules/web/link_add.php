<script language="javascript">
mbmSetContentTitle("<?=$lang["web"]["add_weblink"]?>");
mbmSetPageTitle('<?=$lang["web"]["add_weblink"]?>');
show_sub('menu9');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_POST['addLink'])){
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
		$data['date_added']=mbmTime();
		$data['date_lastupdated']=$data['date_added'];
		if($DB->mbm_insert_row($data,"web_links")==1){
			$result_txt = 'insert command processod.';
			$DB->mbm_query("UPDATE ".PREFIX."web_cats SET total_links=total_links+1 WHERE id='".$data['cat_id']."'");
			$DB->mbm_query("UPDATE ".PREFIX."web_cats SET total_links=total_links+1 WHERE id='".$DB->mbm_get_field($data['cat_id'],'id','cat_id','web_cats')."'");
			$b=1;
		}else{
			$result_txt = 'insert command failed.';
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
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
    <td width="50%" bgcolor="#f5f5f5">Select cat:<br>
      <select name="cat_id" size="5" id="cat_id" class="input">
      <?=mbmWebCatsDropDown(0,mbmWebCatsMinId())?>
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
          <?= mbmIntegerOptions(0, $_SESSION['lev'],$_POST['lev']); ?>
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
          	if($_POST['st']==1){
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
      <input name="name" type="text" id="name" size="45" value="<?=$_POST['name']?>"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">Web address:<br>
      <input name="url" type="text" id="url" size="45" value="<?
	  if(isset($_POST['url'])){
	  	echo $_POST['url'];
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
      <textarea name="comment" cols="45" rows="3" id="comment"><?=$_POST['comment']?></textarea></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">keywords:<br>
      <textarea name="keywords" cols="45" rows="3" id="keywords"><?=$_POST['keywords']?></textarea></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" class="button" name="addLink" id="addLink" value="add link"></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
 </table> 
</form>
<?
}
?>