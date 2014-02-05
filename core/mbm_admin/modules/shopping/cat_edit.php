<script language="javascript">
mbmSetContentTitle("<?=$lang["shopping"]["add_category"]?>");
mbmSetPageTitle('<?= $lang["shopping"]["add_category"]?>');
show_sub('menu11');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['updateCat'])){
	$data["shop_cat_id"] = $_POST['cat_id'];
	if($data["shop_cat_id"]!=0){
		$data["sub"] = $DB->mbm_get_field($data["shop_cat_id"],'id','sub','shop_cats')+1;
	}
	$data["st"] = $_POST['st'];
	$data["lev"] = $_POST['lev'];
	$data["user_id"] = $_SESSION['user_id'];
	$data["lang"] = $_SESSION['ln'];
	$data["pos"] = $DB->mbm_get_field($data["shop_cat_id"],'id','pos','shop_cats')+1;
	if($_POST['linked']==1){
		$data["link"] = $_POST['link'];
		$data["target"] = $_POST['target'];
	}
	$data["name"] = $_POST['name'];
	$data["comment"] = $_POST['comment'];
	$data["cols"] = $_POST['cols'];
	$data["per_page"] = $_POST['per_page'];
	$data["date_lastupdated"] = mbmTime();
	
	if(mbmCheckEmptyfield($data)){
		$result_txt = $lang['error']['empty_field'];
	}else{
		if($DB->mbm_update_row($data,"shop_cats",$_GET['id'])==1){
			$result_txt = "updated";
			$b=1;
		}else{
			$result_txt = "Update failed";
		}
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
$q_catinfo = "SELECT * FROM ".PREFIX."shop_cats WHERE id='".$_GET['id']."'";
$r_catinfo = $DB->mbm_query($q_catinfo);
if($DB->mbm_num_rows($r_catinfo)!=1){
	$b=1;
	echo '<div id="query_result">no such cat exists</div>';
}
if($b!=1){
?><form name="addContent" method="post" action="" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="40%" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td bgcolor="#F5F5F5"><?=$lang["shopping"]["select_category"]?>:<br />
  	  <select name="cat_id" id="cat_id">
  	    <option value="0"><?=$lang["shopping"]["set_as_main"]?></option>
      <?=mbmShoppingCatOptions(0)?>
      </select>    </td>
  	<td bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['main']['status']?>:<br>
          <select name="st" id="st">
          <?=mbmShowStOptions($DB->mbm_result($r_catinfo,0,'st'))?>
          </select>      </td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang['main']['level']?>:<br>
          <select name="lev">
            <?= mbmIntegerOptions(0, 5,$DB->mbm_result($r_catinfo,0,'lev')); ?>
          </select></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["shopping"]["product_cols"]?>:<br />
        <input name="cols" type="text" id="cols" value="<?=$DB->mbm_result($r_catinfo,0,'cols')?>" size="45" /></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["menu"]["per_page"]?>
          :<br />
        <input name="per_page" type="text" id="per_page" value="<?=$DB->mbm_result($r_catinfo,0,'per_page')?>" size="45" /></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["menu"]["menu_link"]?>:<br />
          <input type="checkbox" name="linked" id="linked" value="1" />
          <input name="link" type="text" id="link" value="<?=$DB->mbm_result($r_catinfo,0,'link')?>" size="30" />
          <select name="target" id="target">
        <option value="_self"><?=$lang["menu"]["link_target_self"]?></option>
        <option value="_blank" <?
        if($DB->mbm_result($r_catinfo,0,'target')=='_blank'){
			echo 'selected';
		}
		?>><?=$lang["menu"]["link_target_blank"]?></option>
          </select></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["menu"]["name"]?>
          :<br />
        <label>
        <input name="name" type="text" id="name" value="<?=$DB->mbm_result($r_catinfo,0,'name')?>" size="45" />
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><?=$lang["menu"]["menu_comment"]?>:<br />
          <label>
          <textarea name="comment" cols="45" rows="3" id="comment"><?=$DB->mbm_result($r_catinfo,0,'comment')?></textarea>
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5">&nbsp;</td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f5f5f5"><label>
          <input type="submit" name="updateCat" id="updateCat" value="update" />
        </label></td>
        <td bgcolor="#f5f5f5">&nbsp;</td>
      </tr>
</table>  
</form>
<?
}
?>