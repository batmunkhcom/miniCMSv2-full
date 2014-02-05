<script language="javascript">
mbmSetContentTitle("<?=$lang["forum"]["forum_list"]?>");
mbmSetPageTitle('<?=$lang["forum"]["forum_list"]?>');
show_sub('menu10');
</script>
<?		
if($mBm!=1 && $modules_permissions[$_GET['module']]>$_SESSION['lev']){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}
if(isset($_POST['updatePositions'])){
	$poss = $_POST['pos'];
	
	foreach($poss as $k=>$v){
		$DB->mbm_query("UPDATE ".PREFIX."forums SET pos='".$_POST['pos'][$k]."' WHERE id='".$k."'");
	}
	//print_r($_POST['pos']);
}
if(isset($_GET['action'])){
	switch($_GET['action']){
		case 'st':
			$DB->mbm_query("UPDATE ".PREFIX."forums SET st='".$_GET['st']."' WHERE id='".$_GET['id']."'");
		break;
		case 'lev':
			$DB->mbm_query("UPDATE ".PREFIX."forums SET lev='".$_GET['lev']."' WHERE id='".$_GET['id']."'");
		break;
		case 'announcement':
			$DB->mbm_query("UPDATE ".PREFIX."forums SET announcement='".$_GET['announcement']."' WHERE id='".$_GET['id']."'");
		break;
		case 'sticky':
			$DB->mbm_query("UPDATE ".PREFIX."forums SET sticky='".$_GET['sticky']."' WHERE id='".$_GET['id']."'");
		break;
	}
	echo mbm_result($lang["forum"]["command_processed"]);
}
$q_forums = "SELECT * FROM ".PREFIX."forums WHERE id!=0 ";
if($DB->mbm_check_field('id',$_GET['forum_id'],'forums')==1){
	$q_forums .= "AND forum_id='".$_GET['forum_id']."' ";
}else{
	$q_forums .= "AND forum_id='0' ";
}
$q_forums .= "ORDER BY pos";
$r_forums = $DB->mbm_query($q_forums);
?>
<form id="form1" name="form1" method="post" action="index.php?module=forum&cmd=forums&forum_id=<?=$_GET['forum_id']?>">
  <table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
    <tr class="list_header">
      <td width="30" align="center">#</td>
      <td><?=$lang["forum"]["forum_name"]?></td>
      <td width="100"><?=$lang["forum"]["username"]?></td>
      <td width="30" align="center"><?=$lang["forum"]["announcement_short"]?></td>
      <td width="30" align="center"><?=$lang["forum"]["sticky_short"]?></td>
      <td width="30" align="center"><?=$lang["main"]["status"]?></td>
      <td width="30" align="center"><?=$lang["main"]["level"]?></td>
      <td width="100" align="center"><?=$lang["main"]["hits"]?></td>
      <td width="75" align="center"><?=$lang["main"]["date_added"]?></td>
      <td width="75" align="center"><?=$lang["main"]["date_lastupdated"]?></td>
      <td width="50" align="center"><?=$lang["main"]["pos"]?></td>
      <td width="100" align="center"><?=$lang["main"]["action"]?></td>
    </tr>
    <?
    for($i=0;$i<$DB->mbm_num_rows($r_forums);$i++){
	?>
    <tr>
      <td align="center" bgcolor="#f5f5f5"><strong><?=($i+1)?>.</strong></td>
      <td bgcolor="#f5f5f5"><a href="<?
      if($DB->mbm_check_field('forum_id',$DB->mbm_result($r_forums,$i,"id"),'forums')==1){
	  	echo 'index.php?module=forum&cmd=forums&forum_id='.$DB->mbm_result($r_forums,$i,"id");
	  }else{
	  	echo '#" onclick="alert(\'no sub forum\')';
	  }
	  ?>" ><?=$DB->mbm_result($r_forums,$i,"name")?></a> [<?=$DB->mbm_result($r_forums,$i,"id")?>]</td>
      <td bgcolor="#f5f5f5"><?=$DB2->mbm_get_field($DB->mbm_result($r_forums,$i,"user_id"),'id','username','users')?></td>
      <td align="center" bgcolor="#f5f5f5"><?
		if($DB->mbm_result($r_forums,$i,"announcement")==1){
			$st_con = 'status_1.png'; 
		}else{
			$st_con = 'status_0.png'; 
		}
		echo '<a href="index.php?module=forum&cmd=forums&forum_id='.$_GET['forum_id'].'&action=announcement&id='.$DB->mbm_result($r_forums,$i,"id").'&announcement=';
			echo abs(($DB->mbm_result($r_forums,$i,"announcement")%2)-1);
		echo '"';
		echo '<img src="images/icons/'.$st_con.'" border="0" />';
		echo '</a>';
	?></td>
      <td align="center" bgcolor="#f5f5f5"><?
		if($DB->mbm_result($r_forums,$i,"sticky")==1){
			$st_con = 'status_1.png'; 
		}else{
			$st_con = 'status_0.png'; 
		}
		echo '<a href="index.php?module=forum&cmd=forums&forum_id='.$_GET['forum_id'].'&action=sticky&id='.$DB->mbm_result($r_forums,$i,"id").'&sticky=';
			echo abs(($DB->mbm_result($r_forums,$i,"sticky")%2)-1);
		echo '"';
		echo '<img src="images/icons/'.$st_con.'" border="0" />';
		echo '</a>';
	?></td>
      <td align="center" bgcolor="#f5f5f5"><?
		if($DB->mbm_result($r_forums,$i,"st")==1){
			$st_con = 'status_1.png'; 
		}else{
			$st_con = 'status_0.png'; 
		}
		echo '<a href="index.php?module=forum&cmd=forums&forum_id='.$_GET['forum_id'].'&action=st&id='.$DB->mbm_result($r_forums,$i,"id").'&st=';
			echo abs(($DB->mbm_result($r_forums,$i,"st")%2)-1);
		echo '"';
		echo '<img src="images/icons/'.$st_con.'" border="0" />';
		echo '</a>';
	?></td>
      <td align="center" bgcolor="#f5f5f5"> <select class="input" name="lev" 
    		onchange="window.location='index.php?module=forum&cmd=forums&forum_id=<?=$_GET['forum_id']?>&action=lev&id=<?=$DB->mbm_result($r_forums,$i,"id")?>&lev='+this.value">
    <?= mbmIntegerOptions(0, $_SESSION['lev'],$DB->mbm_result($r_forums,$i,"lev")); ?>
    </select></td>
      <td align="center" bgcolor="#f5f5f5"><?=number_format($DB->mbm_result($r_forums,$i,"hits"))?></td>
      <td align="center" bgcolor="#f5f5f5"><?=date("Y-m-d",$DB->mbm_result($r_forums,$i,"date_added"))?></td>
      <td align="center" bgcolor="#f5f5f5"><?=date("Y-m-d",$DB->mbm_result($r_forums,$i,"date_lastupdated")).'<br />['.$DB->mbm_result($r_forums,$i,"total_updated").']'?></td>
      <td align="center" bgcolor="#f5f5f5"><input name="pos[<?=$DB->mbm_result($r_forums,$i,"id")?>]" type="text" value="<?=($DB->mbm_result($r_forums,$i,"pos")*1)?>" id="pos[<?=$DB->mbm_result($r_forums,$i,"id")?>]" size="3" style="text-align:center;" /></td>
      <td align="center" bgcolor="#f5f5f5"><a href="index.php?module=forum&amp;cmd=forum_edit&amp;id=<?=$DB->mbm_result($r_forums,$i,"id")?>">
        <?=$lang["main"]["edit"]?>
      </a> | <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','index.php?module=forum&amp;cmd=forums&amp;id=<?=$DB->mbm_result($r_forums,$i,"id")?>&amp;action=delete')">
      <?=$lang["main"]["delete"]?>
      </a></td>
    </tr>
    <?
    }
	?>
    <tr>
    	<td bgcolor="#F5F5F5"></td>
   	  <td colspan="11" align="right" bgcolor="#F5F5F5"><input type="submit" name="updatePositions" id="updatePositions" value="<?=$lang["forum"]["button_update_position"]?>" /></td>
    </tr>
  </table>

</form>
