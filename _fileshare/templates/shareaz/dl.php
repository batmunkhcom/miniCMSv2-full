<?
	$q_fileinfo =  "SELECT * FROM ".PREFIX."fileshare WHERE `key`='".$_GET['k']."'";
	$r_fileinfo = $DB->mbm_query($q_fileinfo);
	
	if($DB->mbm_num_rows($r_fileinfo)==1){
	?><table width="60%" border="1" align="center" cellpadding="3" cellspacing="0" style="border-collapse:collapse; margin-bottom:12px; border:1px solid #fe9b1f;">
  <tr>
	<td width="40%" bgcolor="#feb964">Нэр</td>
		<td bgcolor="#fdf4e9"><strong>
	    <?=$DB->mbm_result($r_fileinfo,0,"filename_orig")?>
		</strong></td>
	  </tr>
  <tr>
	<td bgcolor="#feb964">Хэмжээ</td>
		<td bgcolor="#fdf4e9"><strong>
	    <?=number_format(($DB->mbm_result($r_fileinfo,0,"filesize")/1024/1024),3)?>MB
		</strong></td>
	  </tr>
  <tr>
	<td bgcolor="#feb964">Нэмэгдсэн</td>
		<td bgcolor="#fdf4e9"><strong>
	    <?=date("Y/m/d",$DB->mbm_result($r_fileinfo,0,"date_added"))?>
		</strong></td>
	  </tr>
  <!--<tr>
	<td>Нэмсэн</td>
		<td><?=$DB2->mbm_get_field($DB->mbm_result($r_fileinfo,0,"user_id"),'id','username','users')?></td>
	  </tr>
  //-->
  <tr>
	<td bgcolor="#feb964">Хандалт</td>
		<td bgcolor="#fdf4e9"><strong>
	    <?=$DB->mbm_result($r_fileinfo,0,"hits")?>
		</strong></td>
	  </tr>
  <tr>
  <tr>
	<td bgcolor="#feb964">Татагдсан</td>
		<td bgcolor="#fdf4e9"><strong>
	    <?=$DB->mbm_result($r_fileinfo,0,"downloaded")?>
		</strong></td>
	  </tr>
  <tr>
	<td bgcolor="#feb964">Сүүлд татагдсан</td>
		<td bgcolor="#fdf4e9"><strong>
	    <?=date("Y/m/d",$DB->mbm_result($r_fileinfo,0,"session_time"))?>
		</strong></td>
	  </tr>
	  <tr>
		<td bgcolor="#feb964">Нэмэлт мэдээлэл</td>
		<td bgcolor="#fdf4e9"><strong>
	    <?
		if($DB->mbm_result($r_fileinfo,0,"copyright")==1){
			echo mbmError('Анхаар!!!!. Уг файл хуульд харшлах магадлалтай. Админууд удахгүй уг файлыг шалгах болно.');
		}
		?>
		</strong></td>
	  </tr>
	  
	</table>
	
<div align="center" style="margin-bottom:20px;">
	  <input type="submit" name="button" id="button" value="Файлыг татах" onclick="window.location='dl.php?<?=$_SERVER['QUERY_STRING']?>'" />
    </div>
<?	
	$DB->mbm_query("UPDATE ".PREFIX."fileshare SET hits=hits+".HITS_BY."  WHERE `key`='".$_GET['k']."'");
	}else{
		echo mbmError("Файл олдсонгүй.");
	}
	
	echo '<div>'.mbmShowBanner('dl_1').'</div>';
	echo '<div>'.mbmShowBanner('dl_2').'</div>';
	echo '<div>'.mbmShowBanner('dl_3').'</div>';
?>
