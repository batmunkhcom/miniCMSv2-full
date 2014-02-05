<?

if(isset($_GET['pp'])){
	$p_page = $_GET['pp'];
}else{
	$p_page = 50;
}

if($_SESSION['lev']==0){
	echo mbmError("Хандах эрх хүрэлцэхгүй байна.");

}else{

	if(isset($_GET['ob']) && isset($_GET['asc'])){

		switch($_GET['ob']){
			case 1:
				$order_by_ob = 'filename_orig';
			break;
			case 2:
				$order_by_ob = 'days_to_save';
			break;
			case 3:
				$order_by_ob = 'date_added';
			break;
			case 4:
				$order_by_ob = 'filesize';
			break;
			case 5:
				$order_by_ob = 'downloaded';
			break;
			default:
				$order_by_ob = 'id';
			break;
		}
				
		switch($_GET['asc']){
			case 'asc':
				$asc_asc = 'desc';
			break;
			case 'desc':
				$asc_asc = 'asc';
			break;
			default:
				$asc_asc = 'desc';
			break;
		}
		
	}else{
		$order_by_ob = 'id';
		$asc_asc = 'desc';
	}
	
	$order_by = '&ob='.$_GET['ob'].'&asc='.$_GET['asc'];
	
	$q_myfiles = "SELECT * FROM ".PREFIX."fileshare WHERE user_id='".$_SESSION['user_id']."' ORDER BY ".$order_by_ob." ".$asc_asc."";
	$r_myfiles = $DB->mbm_query($q_myfiles);
	
	$q_totalfilesize = "SELECT SUM(filesize),SUM(downloaded) FROM ".PREFIX."fileshare WHERE user_id='".$_SESSION['user_id']."'";
	$r_totalfilesize = $DB->mbm_query($q_totalfilesize);
?><h2>Хувийн файл</h2>
Та нийт <strong><?=mbmFileSizeMB($DB->mbm_result($r_totalfilesize,0,0))?></strong> хэмжээтэй <strong><?=$DB->mbm_num_rows($r_myfiles);?></strong> ширхэг файл оруулсан байгаагаас <strong><?=$DB->mbm_result($r_totalfilesize,0,1)?></strong> удаа татагдсан байна.<br />
<br />

<script language="javascript">

function submitForm(list_type){

	fileForm = document.fileList;
	hidden_field = fileForm.typeList;

	switch(list_type){
		case 1:
			hidden_field.value = 'links';
		break;
		case 2:
			hidden_field.value = 'make_private';
		break;
		case 3:
			hidden_field.value = 'make_private_cancel';
		break;
		default:
			hidden_field.value = 0;
		break;
	}
	fileForm.submit();
}

function toggleAll(val){
	var c = document.getElementsByTagName("input");
	  for(var i=0;i<c.length;i++)
	  {
		if(c[i].type=="checkbox")
		{
		  if(val==0) c[i].checked=false;
		  else if(val==1) c[i].checked=true;
		  else if(val==2){
		  	if(c[i].checked==false) c[i].checked = true;
			else c[i].checked = false;
		  }
		}
	  }
}
</script>
<?
if($_POST['typeList']){
	if(count($_POST['action_f'])>0){
		$q_fileList = "SELECT `key`,`filesize`,`filename_orig`,`id` FROM ".PREFIX."fileshare WHERE ";
		foreach($_POST['action_f'] as $k=>$v){
			$q_fileList .= "id='".$k."' OR ";
		}
		$q_fileList = rtrim($q_fileList,"OR ");
		$r_fileList = $DB->mbm_query($q_fileList);

		$result_txt = '';

		for($i=0;$i<$DB->mbm_num_rows($r_fileList);$i++){
			switch($_POST['typeList']){
				case 'links':
					//$result_txt .= DOMAIN.DIR.'index.php?k='.$DB->mbm_result($r_fileList,$i,"key").' ['.mbmFileSizeMB($DB->mbm_result($r_fileList,$i,"filesize")).'] <br />';
					$result_txt .= 'Файлын нэр: <strong>'.$DB->mbm_result($r_fileList,$i,"filename_orig").'</strong>';
					$result_txt .= '<br />Татах холбоос: <strong>';
					$result_txt .= '<a href="'.DOMAIN.DIR.''.$DB->mbm_result($r_fileList,$i,"key").'" target="_blank" >';
					$result_txt .= DOMAIN.DIR.''.$DB->mbm_result($r_fileList,$i,"key");
					$result_txt .= '</a>';
					$result_txt .= '</strong> <br />';
					$result_txt .= 'Файлын хэмжээ: <strong>['.mbmFileSizeMB($DB->mbm_result($r_fileList,$i,"filesize")).']</strong> <br /><br />';
					//$result = '<textarea cols="150" rows="8">'.$result_txt.'</textarea>';
				break;
				case 'make_private':
					$DB->mbm_query("UPDATE ".PREFIX."fileshare SET is_private='1' WHERE id='".$DB->mbm_result($r_fileList,$i,"id")."'");
					$result_txt = '<strong>'.($i+1).'</strong> Файлын тохиргоо шинэчилэгдэв.';
				break;
				case 'make_private_cancel':
					$DB->mbm_query("UPDATE ".PREFIX."fileshare SET is_private='0' WHERE id='".$DB->mbm_result($r_fileList,$i,"id")."'");
					$result_txt = '<strong>'.($i+1).'</strong> Файлын тохиргоо шинэчилэгдэв.';
				break;
				default:
					$result_txt = 'Файл сонгоорой.';
				break;
			}
		}
	}else{
		$result_txt = 'Ядаж нэг файл сонгоорой.';
	}
	echo '<div style="padding:5px; border:1px solid #f7941c; background-color:#fdf4e9; margin-top:6px; margin-bottom:6px;" align="center">'.$result_txt.'</div>';
}
?>

<div id="shareCommands">
      
      Сонгосон файлуудын хувьд хүчинтэй коммандууд:
  <ul>
    <li><a href="#" onclick="submitForm(1)">Холбоосууд харах</a>
    </li>
    <li><img src="<?=INCLUDE_DOMAIN?>images/locked.gif" onclick="submitForm(2)" align="Нууцлах" style="cursor:pointer;" /></li>
    <li><a href="#" onclick="submitForm(3)">Нууцлал болиулах</a></li>
    <li>&nbsp;</li>
    <li><a href="#">Устгах</a></li>
  </ul>
</div>

<?	$order_by .= '&pp='.$p_page;

	echo  mbmNextPrev('index.php?module=fileshare&cmd=myfiles'.$order_by,$DB->mbm_num_rows($r_myfiles),START,$p_page);



	?>

<form id="fileList" name="fileList" method="post" action="" style="margin-top:6px;">

Бүгдийг: 

<a href="#" onclick="toggleAll(1);return false;">Сонго</a> / 

<a href="#" onclick="toggleAll(0);return false;">Болих</a> / 

<a href="#" onclick="toggleAll(2);return false;">Эсрэгээр</a>

  <table width="99%" border="0" cellspacing="1" cellpadding="2" style="border:1px solid #DDDDDD; margin-top:6px;">

    <tr class="bold">

      <td width="10" align="center" bgcolor="#e2e2e2">-</td>

      <td width="50" height="25" align="center" bgcolor="#e2e2e2">#</td>

      <td bgcolor="#e2e2e2"><a href="index.php?module=fileshare&amp;cmd=myfiles&ob=1&asc=<?=$asc_asc.'&pp='.$p_page?>">Файлын нэр</a></td>

      <td width="40" align="center" bgcolor="#e2e2e2"><a href="index.php?module=fileshare&amp;cmd=myfiles&ob=2&asc=<?=$asc_asc.'&pp='.$p_page?>">Хоног</a></td>

      <td width="75" align="center" bgcolor="#e2e2e2"><a href="index.php?module=fileshare&amp;cmd=myfiles&ob=3&asc=<?=$asc_asc.'&pp='.$p_page?>">Огноо</a></td>

      <td width="75" align="center" bgcolor="#e2e2e2"><a href="index.php?module=fileshare&amp;cmd=myfiles&ob=4&asc=<?=$asc_asc.'&pp='.$p_page?>">Хэмжээ</a></td>

      <td width="75" align="center" bgcolor="#e2e2e2"><a href="index.php?module=fileshare&amp;cmd=myfiles&ob=5&asc=<?=$asc_asc.'&pp='.$p_page?>">Хан./Тат.</a></td>

      <td width="100" align="center" bgcolor="#e2e2e2">Үйлдэл</td>

    </tr>

    <?

  if((START+$p_page) > $DB->mbm_num_rows($r_myfiles)){

		$end= $DB->mbm_num_rows($r_myfiles);

	}else{

		$end= START+$p_page; 

	}

	for($i=START;$i<$end;$i++){

  //for($i=0;$i<$DB->mbm_num_rows($r_myfiles);$i++){

  ?>

    <tr>

      <td align="center"><input type="checkbox" id="action_f[<?=$DB->mbm_result($r_myfiles,$i,"id")?>]" name="action_f[<?=$DB->mbm_result($r_myfiles,$i,"id")?>]" /></td>

      <td height="25" align="center"><strong>

        <?=($i+1)?>

        .</strong></td>

      <td ondblclick="alert('<?=$DB->mbm_result($r_myfiles,$i,"filename_orig")?>')" title="<?=$DB->mbm_result($r_myfiles,$i,"filename_orig")?>"><?

		if($DB->mbm_result($r_myfiles,$i,"is_private") == '1'){
			echo '<img width="18" src="'.INCLUDE_DOMAIN.'images/locked.gif" border="0" align="right" alt="secured" />';
		}

		echo mbmSubStringFilename(array('txt'=>$DB->mbm_result($r_myfiles,$i,"filename_orig"),'maxlength'=>25));

		if(!file_exists(ABS_DIR.$DB->mbm_result($r_myfiles,$i,"abs_url"))){

			echo ' <span style="color:red;" title="'.$DB->mbm_result($r_myfiles,$i,"abs_url").'"><strong>!!!!!</strong></span>';

		}
	?></td>

      <td width="50" align="center" bgcolor="<?

      if($DB->mbm_result($r_myfiles,$i,"days_to_save")<10){

		  	echo '#FF0000" color="#FFFFFF';

	  }else{

		  	echo '#f5f5f5';

	  }

	  ?>"><?=$DB->mbm_result($r_myfiles,$i,"days_to_save")?></td>

      <td align="center"><?=date("Y/m/d H:s:i",$DB->mbm_result($r_myfiles,$i,"date_added"))?>

      </td>

      <td align="center" bgcolor="#F5F5F5"><?=mbmFileSizeMB($DB->mbm_result($r_myfiles,$i,"filesize"))?>

      </td>

      <td align="center"><?='<span title="Хандалт">'.$DB->mbm_result($r_myfiles,$i,"hits").'</span><br /><span title="файлыг татсан">'.$DB->mbm_result($r_myfiles,$i,"downloaded").'</span>'?></td>

      <td align="center" bgcolor="#F5F5F5"><a href="<?=DOMAIN.DIR?>index.php?k=<?=$DB->mbm_result($r_myfiles,$i,"key")?>" target="_blank">Татах</a> | <a href="#" onclick="confirmSubmit('<?=$lang['confirm']['delete']?>','<?=DOMAIN.DIR?>index.php?k=<?=$DB->mbm_result($r_myfiles,$i,"key")?>&amp;action=delete&amp;del_key=<?=$DB->mbm_result($r_myfiles,$i,"key_delete")?>');">Устгах</a></td>

    </tr>

    <tr>

      <td colspan="15" align="center">

      <?

 		echo '<div id="dlURL'.$DB->mbm_result($r_myfiles,$i,"id").'" style="display:none;">';

		if($_SESSION['lev']==5){

			echo '[id:'.$DB->mbm_result($r_myfiles,$i,"id").'] <input type="text" size="100" value="'.$DB->mbm_result($r_myfiles,$i,"dl_url").'" />';	

		}

		

		echo '<br />Сүүлд татагдсан: <strong>';

		if($DB->mbm_result($r_myfiles,$i,"session_time") == $DB->mbm_result($r_myfiles,$i,"date_added")){

			echo 'Татагдаагүй';

		}else{

			echo date("Y/m/d H:i:s",$DB->mbm_result($r_myfiles,$i,"session_time"));

		}

		echo '</strong>';

		

		echo '</div>';

	?>

      <hr onclick="mbmToggleDisplay('<?='dlURL'.$DB->mbm_result($r_myfiles,$i,"id").''?>')" /></td>

    </tr>

    <?

	}

	?>

  </table>

  <input name="typeList" type="hidden" id="typeList" value="0" />

</form>

<?
	echo  mbmNextPrev('index.php?module=fileshare&cmd=myfiles'.$order_by,$DB->mbm_num_rows($r_myfiles),START,$p_page);

}

?>