<?

	$q_fileinfo =  "SELECT * FROM ".PREFIX."fileshare WHERE `key`='".$_GET['k']."'";

	$r_fileinfo = $DB->mbm_query($q_fileinfo);

	

	if($DB->mbm_num_rows($r_fileinfo)==1){

		if(isset($_GET['del_key'])){

			if(isset($_GET['action']) && $_GET['action']=='delete'){

				echo mbmDeleteFileFileshare(array(

											'del_key'=>$_GET['del_key'],

											'key'=>$_GET['k']

											));

			}

			sleep(2);

		}else{

			$DB->mbm_query("UPDATE ".PREFIX."fileshare SET hits=hits+".HITS_BY."  WHERE `key`='".$_GET['k']."'");

			?>

<h2>Файл татах</h2>
<?

/* file tataj bgaa bol GET-r code utga orj ireh buguud ug utga bsan tohioldold tsag yavj ehelne. 

bhgui bol tsag yavahgui ba tatah holboosiig darahad dahiad l neg dor 1ees ih file tataj bolohgui 

gesen aldaa garch tsag toolj eheleh bolno

*/

switch($_GET['code']){

	case 1:

		$error_txt = 'Уучлаарай. Та нэг агшинд нэгээс их файл татах боломжгүй. Түр хүлээнэ үү. <br />Хүлээх хугацаа нь хэрэглэгчийн түвшнээс хамаарна.';

	break;

	default:

		$error_txt = 'Үл мэдэх алдаа байна.';

		$b=2;

	break;

}

if(isset($_GET['code']) && $b!=2){

	echo mbmError($error_txt);

	$timer_wait = ' document.fileInfo.countDownTime.value='.$config_fileshare['next_file_dl_limit'][$_SESSION['lev']].';';

}

?>
<script language="javascript">

mbmSetPageTitle('<?=$DB->mbm_result($r_fileinfo,0,"filename_orig")?>');

</script>
<form id="fileInfo" name="fileInfo" method="post" action="">
  <div align="center" id="countDownDiv" style="margin:12px;"> Та
    <input type="text" id="countDownTime" name="countDownTime" value="10" style="border:0px; font-size:14px; background-color:#FFFFFF; text-align:center; font-weight:bold;" size="1" disabled="disabled" />
    секунд хүлээнэ үү </div>
  <table width="60%" border="1" align="center" cellpadding="3" cellspacing="0" style="border-collapse:collapse; margin-bottom:12px; border:1px solid #fe9b1f;">
    <tr>
      <td width="40%" bgcolor="#feb964">Нэр</td>
      <td bgcolor="#fdf4e9"><strong>
        <?=mbmSubStringFilename(array('txt'=>$DB->mbm_result($r_fileinfo,0,"filename_orig"),'maxlength'=>40));?>
        </strong></td>
    </tr>
    <tr>
      <td bgcolor="#feb964">Хэмжээ</td>
      <td bgcolor="#fdf4e9"><strong>
        <?=mbmFileSizeMB($DB->mbm_result($r_fileinfo,0,"filesize"))?>
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
      <td bgcolor="#feb964">Татагдсан</td>
      <td bgcolor="#fdf4e9"><strong>
        <?=$DB->mbm_result($r_fileinfo,0,"downloaded")?>
        </strong></td>
    </tr>
    <tr>
      <td bgcolor="#feb964">Нэмэгдсэн</td>
      <td bgcolor="#fdf4e9"><strong>
        <?=date("Y/m/d",$DB->mbm_result($r_fileinfo,0,"date_added"))?>
        </strong></td>
    </tr>
    <tr>
      <td bgcolor="#feb964">Сүүлд татагдсан</td>
      <td bgcolor="#fdf4e9"><strong>
        <?=date("Y/m/d H:i:s",$DB->mbm_result($r_fileinfo,0,"session_time"))?>
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
  <div align="center" style="margin-bottom:20px; display:none;" id="dlButton">
    <input type="button" class="buttonFile" disabled="disabled" name="button" id="button" value="Файлыг татах" onclick="getFile()" />
  </div>
</form>
<div align="center">
  <?	

			

		}

		?>
</div>
<script language="javascript">

<?=$timer_wait?>

function countDown(){

	el = document.fileInfo.countDownTime;

	if(el.value>0){

		el.value=(el.value-1);

		setTimeout("countDown()",1500);

	}else{

		document.fileInfo.button.disabled=false;

		document.getElementById('countDownDiv').innerHTML='';

		document.getElementById('dlButton').style.display='block';

		if(document.getElementById('query_result')){

			mbmToggleDisplay('query_result');

		}

	}

}

	<?

	if($_SESSION['lev']>0 && !isset($_GET['code'])){

		 "

			document.fileInfo.button.disabled=false;

			document.getElementById('countDownDiv').innerHTML='';

			document.getElementById('dlButton').style.display='block';

			if(document.getElementById('query_result')){

				mbmToggleDisplay('query_result');

			}

			";	

		echo 'countDown();';

	}else{

		echo 'countDown();';

		}

	?>



function getFile(){

	//window.open('dl.php?<?=$_SERVER['QUERY_STRING']?>','dlFile','height=100,width=100');

	window.location='dl.php?<?=$_SERVER['QUERY_STRING']?>';

	document.getElementById('fileInfo').innerHTML = '<center><img src="images/loading.gif" border="0" /></center>';

	setTimeout("document.getElementById('fileInfo').innerHTML='Манай сайтыг ашиглаж буйд баярлалаа.'",10000);

}

</script>
<?

	}else{

		echo mbmError("Файл олдсонгүй.");

	}

?>
