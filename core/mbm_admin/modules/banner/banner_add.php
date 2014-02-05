<script language="javascript">
mbmSetContentTitle("<?= $lang['banners']['banner_add']?>");
mbmSetPageTitle('<?= $lang['banners']['banner_add']?>');
show_sub('menu3');
</script>
<?		
if($mBm!=1 && $modules_permissions['banner']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
	if(isset($_POST['addBanner']))
	{	
		$data['name']= $_POST['name'];
		$data['lev']= $_POST['lev'];
		$data['code']= $_POST['code'];
		$data['st']= $_POST['st'];
		$data['type']= $_POST['type'];
		$data['max_hits']= $_POST['max_hits'];
		$data['user_id']= $_SESSION['user_id'];
		$data['content']= $_POST['content_short'];
		$data['date_added']= mbmTime();
		$data['date_lastupdated'] = $data['date_added'];
		$data['ip']= getenv("REMOTE_ADDR");
			
		if(mbmCheckEmptyfield($data)){
			$result_txt = $lang["error"]["empty_field"];
		}else{
			$data['comment']= $_POST['comment'];
			if($_POST['link']!='http://' && strlen($_POST['link'])>10){
				$data['link']= $_POST['link'];
			}elseif($_POST['link']!='http://'){
				$result_txt = $lang["error"]["link_invalid"];
			}
			if($DB->mbm_insert_row($data, 'banners')==0){
				$result_txt = $lang["banners"]["banner_add_failed"];
			}else{
				$result_txt = $lang["banners"]["banner_add_processed"];
				$b=1;
			}
		}
		echo '<div id="query_result">'.$result_txt.'</div>';
	}
if($b!=1)	{
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="50%" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["banners"]["banner_code"]?>:<br />
      <input name="code" type="text" id="code" class="input" size="45" value="<?=$_POST['code']?>" /></td>
    <td bgcolor="#f5f5f5">Banner code. Can't be same as others.</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["banners"]["banner_type"]?>:<br />
      <select name="type" id="type" class="input" >
      	<?
        echo mbmBannerTypes(array(2=>'<option >',3=>'</option>'));
		?>
      </select>
      </td>
    <td bgcolor="#f5f5f5">Banner type: WHere banner is located.</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["banners"]["banner_maxhits"]?>:<br />
      <input name="max_hits" type="text" id="max_hits" value="<?=$_POST['max_hits']?>" class="input" size="45" /></td>
    <td bgcolor="#f5f5f5">How much banner will be displayed. If its load reaches given number banner won't be displayed automatically.</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["banners"]["banner_link"]?>:<br />
        <input name="link" type="text" class="input" id="link" value="<?
        if(isset($_POST['addBanner'])){
			echo $_POST['link'];
		}else{
			echo 'http://';
		}
		?>" size="45" /></td>
    <td bgcolor="#f5f5f5">Link for banner.</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["main"]["level"]?>:<br />
        <select name="lev" id="lev">
          <?= mbmIntegerOptions(0, 5,$_POST['lev']); ?>
              </select></td>
    <td bgcolor="#f5f5f5">Banner level for users.</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["main"]["status"]?>:<br />
        <select name="st" id="st">
          <option value="0">
          <?= $lang['status'][0]?>
          </option>
          <option value="1" <?
          	if($_POST['st']==1){
				echo 'selected ';
			}
		  ?>>
          <?= $lang['status'][1]?>
          </option>
      </select></td>
    <td bgcolor="#f5f5f5">Banner status. If status is active banner will be displayed.</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["main"]["name"]?>:<br />
      <input name="name" type="text" value="<?=$_POST['name']?>" id="name" class="input" size="45" /></td>
    <td bgcolor="#f5f5f5">Banner name for admin.</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><?=$lang["main"]["comment"]?>:<br />
      <textarea name="comment" cols="45" rows="3" class="input" id="comment"><?=$_POST['comment']?></textarea></td>
    <td bgcolor="#f5f5f5">Banner short information.</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#f5f5f5"><?
	mbmShowHTMLEditor("short",'spaw2','spaw','all',array(0=>stripslashes($_POST['content_short']))
							,'en','100%',"200px");
	?></td>
    </tr>
  <tr>
    <td bgcolor="#f5f5f5">&nbsp;</td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#f5f5f5"><input type="submit" name="addBanner" id="addBanner" value="<?=$lang["banners"]["banner_add"]?>" class="button" /></td>
    <td bgcolor="#f5f5f5">&nbsp;</td>
  </tr>
  </table>
</form>
<?
}
?>
