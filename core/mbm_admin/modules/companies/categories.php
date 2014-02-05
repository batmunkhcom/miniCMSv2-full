<script language="javascript">
mbmSetContentTitle("Company categories");
mbmSetPageTitle('Company categories');
show_sub('menu18');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}

switch($_GET['action']){
	case 'delete':
		if($DB->mbm_query("DELETE FROM ".$DB->prefix."company_categories WHERE id='".addslashes($_GET['id'])."' LIMIT 1") == 1){
			$result_txt = $lang["companies"]["deleted"] ;
		}else{
			$result_txt = $lang["companies"]["delete_error"] ;
		}
	break;
	case 'edit':
			$result_txt = $lang["companies"]["not_available"];
	break;
}

if(isset($_POST['buttonAdd'])){
	$data['name'] = $_POST['name'];
	$data['comment'] = $_POST['comment'];
	$data['date_added'] = mbmTime();
	$data['user_id'] = $_SESSION['user_id'];
	
	if(strlen($data['name'])<3){
		$result_txt = $lang["companies"]["short_name_field"];
	}elseif($DB->mbm_insert_row($data,'company_categories')==1){
		$result_txt = $lang["companies"]["insert_command_processed"];
	}else{
		$result_txt = $lang["companies"]["insert_command_failed"];
	}
}
if($result_txt !=''){
	echo mbmError($result_txt);
}
$q_co_cats = "SELECT * FROM ".$DB->prefix."company_categories ORDER BY name";
$r_co_cats = $DB->mbm_query($q_co_cats);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
       <tr class="list_header">
        <td width="30" align="center">#</td>
        <td><?=$lang["companies"]["service_name"]?></td>
        <td width="100" ><?=$lang["main"]["username"]?></td>
        <td width="75" align="center" ><?=$lang["main"]["date_added"]?></td>
        <td width="100" align="center" ><?=$lang["main"]["hits"]?></td>
        <td width="145" align="center" ><?=$lang["main"]["action"]?></td>
      </tr>
      <?
  for($i=0;$i<$DB->mbm_num_rows($r_co_cats);$i++){
  	?>
	<tr >
        <td  align="center"><strong><?=($i+1)?>.</strong></td>
        <td><?=$DB->mbm_result($r_co_cats,$i,"name")?></td>
        <td  ><?=$DB2->mbm_get_field($DB->mbm_result($r_co_cats,$i,"user_id"),'id','username','users')?></td>
        <td align="center" ><?=date("Y/m/d",$DB->mbm_result($r_co_cats,$i,"date_added"))?></td>
        <td align="center" ><?=number_format($DB->mbm_result($r_co_cats,$i,"hits"))?></td>
        <td align="center">
        	<a href="index.php?module=companies&amp;cmd=categories&amp;action=edit&id=<?=$DB->mbm_result($r_co_cats,$i,"id")?>">
        		<img src="images/<?=$_SESSION['ln']?>/button_edit.png" border="0" alt="<?= $lang['main']['edit']?>" hspace="3" />
                </a>
    		<a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=companies&amp;cmd=categories&amp;action=delete&id=<?=$DB->mbm_result($r_co_cats,$i,"id")?>')">
   				 <img src="images/<?=$_SESSION['ln']?>/button_delete.png" border="0" alt="<?= $lang['main']['delete']?>" />
             </a></td>
      </tr>
	<?
  }
  ?>
    </table></td>
    <td width="30%" valign="top">
<form name="form1" method="post" action="">
  <label>
    <strong><?=$lang["companies"]["category_name"]?></strong><br>
    <input name="name" type="text" id="name" size="30">
    <br>
    <br>
    <strong><?=$lang["companies"]["category_comment"]?></strong> </label>
  <br>
  <textarea name="comment" cols="28" rows="5" id="comment"></textarea>
  <br>
  <br>
  <input type="submit" name="buttonAdd" id="buttonAdd" value="<?=$lang["companies"]["add_category"]?>">
</form></td>
  </tr>
</table>
