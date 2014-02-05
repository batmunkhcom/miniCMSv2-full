<script language="javascript">
mbmSetContentTitle("<?=$lang["web"]["web_links"]?>");
mbmSetPageTitle('<?=$lang["web"]["web_links"]?>');
show_sub('menu9');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_GET['action']) && $DB->mbm_check_field('id',$_GET['id'],'web_cats')==1){
	switch($_GET['action']){
		case 'st':
			if($DB->mbm_query("UPDATE ".PREFIX."web_links SET total_updated=total_updated+1,st='".$_GET['st']."' WHERE id='".$_GET['id']."'")==1){
				$result_txt = 'status updated.';
			}else{
				$result_txt = 'status update failed.';
			}
		break;
		case 'lev':
		break;
		case 'delete':
		break;
	}
	echo '<div id="query_result">'.$result_txt.'</div>';
}
?><table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
  <tr class="list_header">
    <td width="30" align="center">#</td>
    <td>name</td>
    <td width="100" >user</td>
    <td width="50" align="center" >st</td>
    <td width="50" align="center" >lev</td>
    <td width="75" align="center" >added</td>
    <td width="75" align="center" >updated</td>
    <td width="100" align="center" >hits</td>
    <td width="125" align="center" >action</td>
  </tr>
  <?
  	$q_weblinks = "SELECT * FROM ".PREFIX."web_links ORDER BY date_added DESC";
	$r_weblinks = $DB->mbm_query($q_weblinks);
	for($i=0;$i<$DB->mbm_num_rows($r_weblinks);$i++){
	?>
	<tr>
    	<td bgcolor="#f5f5f5" align="center"><strong><?=($i+1)?>.</strong></td>
    	<td bgcolor="#f5f5f5"><?
		echo '<strong><a href="'.$DB->mbm_result($r_weblinks,$i,"url").'" target="_blank">'
			 .$DB->mbm_result($r_weblinks,$i,"name")
			 .'</a></strong><br />'
			 .$DB->mbm_result($r_weblinks,$i,"comment").'<br />'
			 .'['.$DB->mbm_result($r_weblinks,$i,"keywords").']';
		?></td>
    	<td bgcolor="#f5f5f5"><?=$DB2->mbm_get_field($DB->mbm_result($r_weblinks,$i,"user_id"),'id','username','users')?></td>
    	<td align="center" bgcolor="#f5f5f5"><a href="index.php?module=web&cmd=link_list&id=<?=$DB->mbm_result($r_weblinks,$i,"id")?>&action=st&st=<?=(($DB->mbm_result($r_weblinks,$i,"st")+1)%2)?>&cat_id=<?=$_GET['cat_id']?>">
    <img src="images/icons/status_<?=$DB->mbm_result($r_weblinks,$i,"st")?>.png" border="0" />
    </a></td>
    	<td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_weblinks,$i,"lev")?></td>
    	<td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_weblinks,$i,"date_added"))?></td>
    	<td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_weblinks,$i,"date_lastupdated")).'<br />'.$DB->mbm_result($r_weblinks,$i,"total_updated")?></td>
    	<td align="center" bgcolor="#f5f5f5"><?='<strong>'.$DB->mbm_result($r_weblinks,$i,"hits")
								.'</strong><br />'.$DB->mbm_result($r_weblinks,$i,"views")?></td>
        <td align="center" bgcolor="#f5f5f5"><a href="#">edit</a> | <a href="#">delete</a></td>
    </tr>
	<?
	}
  ?>
  </table>