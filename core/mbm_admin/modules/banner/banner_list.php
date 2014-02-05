<script language="javascript">
mbmSetContentTitle("<?= $lang['banners']['banner_list']?>");
mbmSetPageTitle('<?= $lang['banners']['banner_list']?>');
show_sub('menu3');
</script>
<?		
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}  if(isset($_GET['action']) && $_GET['action']!=''){
		switch($_GET['action']){
			case 'st':
				if($DB->mbm_query("UPDATE ".PREFIX."banners SET st='".$_GET['st']."' WHERE id='".$_GET['id']."'")==1){
					$result_txt = $lang["banners"]["status_updated"];
				}
			break;
			case 'delete':
				if($DB->mbm_query("DELETE FROM ".PREFIX."banners WHERE id='".$_GET['id']."'")==1){
					$result_txt = $lang["banners"]["command_processed"];
				}
			break;
		}
		echo '<div id="query_result">'.$result_txt.'</div>';
	}
  	$q_bnnr = "SELECT * FROM ".PREFIX."banners WHERE ";
	if(isset($_GET['type']) && $_GET['type']!='' ){
		$q_bnnr .= "type='".$_GET['type']."'";
	}else{
		$q_bnnr .= "type!=''";
	}
	if($_GET['st'] && $_GET['st']!=''){
		$q_bnnr .= " AND st='".$_GET['st']."'";
		
	}
	if(isset($_GET['order_by']) && $_GET['order_by']!=''){
		$o_b = $_GET['order_by'];
	}else{
		$o_b = 'st';
	}
	if(isset($_GET['filter_by']) && $_GET['filter_by']!=''){
		$q_bnnr .= " AND `type`='".$_GET['filter_by']."'";
	}
	$q_bnnr .= " ORDER BY ".$o_b.",id DESC";
	$r_bnnr = $DB->mbm_query($q_bnnr);
		
echo mbmNextPrev("index.php?module=banner&cmd=banner_list&filter_by=".$_GET['filter_by']."&order_by=".$_GET['order_by']."&st=".$_GET['st'],$DB->mbm_num_rows($r_bnnr),START, PER_PAGE);
?>
<div align="center" style="margin:12px;">
  <select name="select" id="select" onchange="window.location='index.php?module=banner&cmd=banner_list&filter_by='+this.value">
  	<option><?=$lang["banners"]["banner_type"]?></option>
  	<?=mbmBannerTypes(array(2=>'<option>',3=>'</option>'))?>
  </select>
</div>
<table width="100%" border="0" cellspacing="2" cellpadding="3"  class="tblContents">
  <tr class="list_header">
  	<td width="30" align="center">#</td>
    <td width="250"><?=$lang["banners"]["banner_name"]?></td>
    <td width="75" align="center"><?=$lang["banners"]["banner_code"]?></td>
    <td width="75" align="center"><?=$lang["banners"]["banner_dateadded"]?></td>
    <td width="70" align="center"><?=$lang["banners"]["banner_type"]?></td>
    <td width="50" align="center"><?=$lang["banners"]["banner_status"]?></td>
    <td width="150" align="center"><?=$lang["banners"]["banner_hits"]?></td>
	<td width="100" align="center"><?=$lang["banners"]["banner_actions"]?></td>
  </tr>
  <?
	if($DB->mbm_num_rows($r_bnnr) == 0 ){
		echo '<div align="center">'.$lang["banners"]["no_banner"].'</div><br>';
	}
	if((START+PER_PAGE) > $DB->mbm_num_rows($r_bnnr)){
		$end= $DB->mbm_num_rows($r_bnnr);
	}else{
		$end= START+PER_PAGE; 
	}

	for($i=START;$i<$end;$i++){
  ?>
  <tr height="20">
  	<td align="center" bgcolor="#f5f5f5" class="bold"><?=($i+1)?></td>
	<td bgcolor="#f5f5f5" onmouseover="mbmToggleDisplay('banner<?=$DB->mbm_result($r_bnnr,$i,"id")?>')" onmouseout="mbmToggleDisplay('banner<?=$DB->mbm_result($r_bnnr,$i,"id")?>')" style="position:relative;">
		<?='<strong>'.$DB->mbm_result($r_bnnr,$i,"name").'</strong> ['.$DB->mbm_result($r_bnnr,$i,"id").']'?></a><br />
        <?=$DB->mbm_result($r_bnnr,$i,"comment")?>
        <div align="center" id="banner<?=$DB->mbm_result($r_bnnr,$i,"id")?>" style="display:none; position:absolute; z-index:100;"><?=$DB->mbm_result($r_bnnr,$i,"content")?></div>
        </td>
	<td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_bnnr,$i,"code")?></a></td>
  	<td align="center" bgcolor="#f5f5f5"><?=date("Y/m/d",$DB->mbm_result($r_bnnr,$i,"date_added"))?>
  	<td align="center" bgcolor="#f5f5f5"><?=$DB->mbm_result($r_bnnr,$i,"type")?></td>
  	<td align="center" bgcolor="#f5f5f5">
    <a href="index.php?module=banner&cmd=banner_list&id=<?=$DB->mbm_result($r_bnnr,$i,"id")?>&action=st&st=<?=(($DB->mbm_result($r_bnnr,$i,"st")+1)%2)?>&filter_by=<?=$_GET['filter_by']?>">
    	<img src="<?=DOMAIN.DIR?>mbm_admin/images/icons/status_<?=$DB->mbm_result($r_bnnr,$i,"st")?>.png" border="0" />    </a>	</td>
  	<td align="center" bgcolor="#f5f5f5"><?=number_format($DB->mbm_result($r_bnnr,$i,"max_hits")).'&raquo;'.number_format($DB->mbm_result($r_bnnr,$i,"hits")).'<br /><strong>'.$DB->mbm_result($r_bnnr,$i,"clicked").'</strong>'?></td>
    <td align="center" bgcolor="#f5f5f5" width="145"><?
            	echo mbmAdminButtonEdit('index.php?module=banner&cmd=banner_edit&id='.$DB->mbm_result($r_bnnr,$i,"id"));
				
				$deelte_redirect_url = 'index.php?module=banner&amp;cmd=banner_list&action=delete';
				$deelte_redirect_url.= '&filter_by='.$_GET['filter_by'].'&order_by='.$_GET['order_by'].'&id='.$DB->mbm_result($r_bnnr,$i,"id").'&start='.$_GET['start'];
				echo mbmAdminButtonDelete($deelte_redirect_url,$lang['banners']['confirm_delete_banner']);
	?></td>
  </tr>
  <?
  }
  ?>
</table>
