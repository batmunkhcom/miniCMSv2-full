<script language="javascript">
mbmSetContentTitle("<?=$lang["menu"]["content_images"]?>");
mbmSetPageTitle('<?=$lang["menu"]["content_images"]?>');
show_sub('menu2');
</script>
<?		
if($mBm!=1 && $modules_permissions['menu']>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if($DB->mbm_check_field('id',$_GET['content_id'],'menu_contents')==0){
	die($lang["menu"]["no_such_content_exists"]);
}else{
	echo '<h2>'.$DB->mbm_get_field($_GET['content_id'],'id','title','menu_contents').'</h2>';
	?>
	<table width="100%" border="0" cellspacing="2" cellpadding="3">
	  <tr class="list_header">
		<td align="center">#</td>
		<td align="center"><?=$lang['menu']['filename']?></td>
		<td width="75" align="center"><?=$lang['menu']['filetype']?></td>
		<td width="75" align="center"><?=$lang['menu']['filesize']?></td>
		<td width="100" align="center"><?=$lang['menu']['filehits']?></td>
		<td width="50" align="center"><?=$lang['menu']['file_ratings']?></td>
		<td width="50" align="center"><?=$lang['menu']['file_downloaded']?></td>
		<td width="75" align="center"><?=$lang['country']['ip']?></td>
		<td width="75" align="center"><?=$lang['main']['date_added']?></td>
		<td width="75" align="center"><?=$lang['main']['total_lastupdated']?></td>
		<td width="75" align="center"><?=$lang['main']['date_lastupdated']?></td>
		<td width="100" align="center"><?=$lang['main']['action']?></td>
	  </tr>
	  
	  <?
	  switch($_GET['action']){
		case 'delete':
			$r_delete_process = $DB->mbm_query("DELETE FROM ".PREFIX."menu_photos WHERE id='".$_GET['id']."' LIMIT 1");
			if($r_delete_process==1){
				$result_txt = $lang["menu"]["command_delete_processed"];
			}else{
				$result_txt = $lang["menu"]["command_delete_failed"];
			}
			echo '<div id="query_result">'.$result_txt.'</div>';
		break;
		case 'edit':
		break;
	  }
	  $q_content_photos = "SELECT * FROM ".PREFIX."menu_photos WHERE content_id='".$_GET['content_id']."' ORDER BY id";
	  $r_content_photos = $DB->mbm_query($q_content_photos);
	  for($i=0;$i<$DB->mbm_num_rows($r_content_photos);$i++){
		echo	'<tr '.mbmonMouse("#e2e2e2","#d2d2d2","").'>
				<td align="center" bgcolor="#e2e2e2"><strong>'.($i+1).'.</strong></td>
				<td bgcolor="#e2e2e2">'.basename($DB->mbm_result($r_content_photos,$i,"url")).'</td>
				<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"filetype").'</td>
				<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"filesize").'</td>
				<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"hits").'</td>
				<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"ratings").'</td>
				<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"downloaded").'</td>
				<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"ip").'</td>
				<td align="center" bgcolor="#e2e2e2">'.date("Y/m/d",$DB->mbm_result($r_content_photos,$i,"date_added")).'</td>
				<td align="center" bgcolor="#e2e2e2">'.$DB->mbm_result($r_content_photos,$i,"total_updated").'</td>
				<td align="center" bgcolor="#e2e2e2">'.date("Y/m/d",$DB->mbm_result($r_content_photos,$i,"date_lastupdated")).'</td>
				<td align="center" bgcolor="#e2e2e2">';
			echo '<a href="#" onclick="confirmSubmit(\''.$lang['confirm']['delete'].'\',\'index.php?module=menu&cmd=content_photos&content_id='
					.$_GET['content_id'].'&id='.$DB->mbm_result($r_content_photos,$i,"id").'&action=delete\')">'
					.$lang['main']['delete'].'</a>';
			echo '</td>
			  </tr>';
		echo '<tr><td colspan="13" align="center">';
			echo '<strong>'.$DB->mbm_result($r_content_photos,$i,"title").'</strong><br />';
			echo '<img src="';
			if(substr_count($DB->mbm_result($r_content_photos,$i,"url"),DOMAIN.DIR)==1){
				echo $DB->mbm_result($r_content_photos,$i,"url");
			}else{
				echo DOMAIN.DIR.$DB->mbm_result($r_content_photos,$i,"url");
			}
			echo '" width="';
			if($DB->mbm_result($r_content_photos,$i,"width")<NEWS_PHOTO_WIDTH){
				echo $DB->mbm_result($r_content_photos,$i,"width");
			}else{
				echo NEWS_PHOTO_WIDTH;
			}
			echo '" alt="'.$DB->mbm_result($r_content_photos,$i,"url").'" />';
		echo '</td></tr>';
	  }
	  ?>
	</table>
<?
}
?>