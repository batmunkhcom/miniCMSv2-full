<script language="javascript">
mbmSetContentTitle("<?=$lang["dic"]["dic_languages"]?>");
mbmSetPageTitle('<?=$lang["dic"]["dic_languages"]?>');
show_sub('menu13');
</script>
<?		
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_GET['action'])) {
	switch($_GET['action']){
		case 'st':
			$q_update_st = "UPDATE ".PREFIX."dic_langs SET st='".$_GET['st']."',date_lastupdated='".mbmTime()."' 
							WHERE id='".$_GET['id']."'";
			$r_update_st = $DB->mbm_query($q_update_st);
			if($r_update_st==1){
				$result_txt = $lang['dic']['lang_status_updated'];
			}else{
				$result_txt = $lang['dic']['lang_status_update_failed'];
			}
		break;
		case 'edit':
		break;
		case 'delete':
		break;
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
?>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="30" align="center" >#</td>
    <td><?=$lang['dic']['lang_name']?></td>
    <td width="100"><?=$lang['main']['username']?></td>
    <td width="50" align="center"><?=$lang['main']['status']?></td>
    <td width="75" align="center"><?=$lang['main']['date_added']?></td>
    <td width="75" align="center"><?=$lang['main']['date_lastupdated']?></td>
    <td width="150" align="center"><?=$lang['main']['action']?></td>
  </tr>
  <?
  	$q_dic_langs = "SELECT * FROM ".PREFIX."dic_langs ORDER BY id";
	$r_dic_langs = $DB->mbm_query($q_dic_langs);
	
	for($i=0;$i<$DB->mbm_num_rows($r_dic_langs);$i++){
  ?>
  <tr>
    <td align="center" bgcolor="#f5f5f5"><strong><?=($i+1)?>.</strong></td>
    <td bgcolor="#f5f5f5"><?=$DB->mbm_result($r_dic_langs,$i,"name")?></td>
    <td bgcolor="#f5f5f5"><?=$DB2->mbm_get_field($DB->mbm_result($r_dic_langs,$i,"user_id"),'id','username','users')?></td>
    <td align="center" bgcolor="#f5f5f5">
    <a href="index.php?module=dic&cmd=lang_list&action=st&st=<?=(($DB->mbm_result($r_dic_langs,$i,"st")+1)%2)?>&id=<?=$DB->mbm_result($r_dic_langs,$i,"id")?>">
    <img src="images/icons/status_<?=$DB->mbm_result($r_dic_langs,$i,"st")?>.png" border="0" alt="change status" />    </a></td>
    <td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_dic_langs,$i,"date_added"))?>
    </td>
    <td align="center" bgcolor="#f5f5f5">
    <?=date("Y/m/d",$DB->mbm_result($r_dic_langs,$i,"date_lastupdated"))?>    </td>
    <td width="150" align="center" bgcolor="#f5f5f5"><a href="#"><?=$lang['main']['edit']?></a> | <a href="#"><?=$lang['main']['delete']?></a></td>
  </tr>
  <?
  }
  ?>
</table>
</form>
