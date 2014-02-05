<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}else{
echo '<h2>User banner</h2>';
		if(isset($_POST['addButton'])){
			$data['email']=$_POST['email'];
			if(strlen($_POST['pass1'])>3){
				$data['password'] = md5($_POST['pass1']);
			}
			$data['firstname']=$_POST['firstname'];
			$data['lastname']=$_POST['lastname'];
			$data['birthday']=$_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
			$data['gender']=$_POST['gender'];
			$data['phone']=$_POST['phone'];
			$data['fax']=$_POST['fax'];
			$data['mobile']=$_POST['mobile'];
			$data['yim']=$_POST['yim'];
			$data['msn']=$_POST['msn'];
			$data['occupation']=$_POST['occupation'];
			$data['city']=$_POST['city'];
			$data['country']=$_POST['country'];
			$data['website']=$_POST['website'];
			$data['date_lastupdated']=mbmTime();
			
			if(mbmCheckEmail($_POST['email'])==0){
				$result_txt = $lang["users"]["invalid_email"];
			}else{
				if($DB2->mbm_update_row($data,'users', $_SESSION['user_id'], "id")==1){
					$result_txt = 'Updated';
					$b=1;
				}else{
					$result_txt = $lang["users"]["error_occurred"];
				}
			}
			echo '<div id="query_result">'.$result_txt.'</div>';
		}
	if($b!=1){
	$q_user_profile = "SELECT * FROM ".USER_DB_PREFIX."users WHERE id='".$_SESSION['user_id']."'";
	$r_user_profile = $DB2->mbm_query($q_user_profile);
	?>
	<form id="userBanner" name="userBanner" method="post" action="">
	  <table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
		  <td width="20%" align="right">&nbsp;</td>
		  <td width="30%" valign="top"><?
          mbmShowHTMLEditor("short",'spaw2','spaw','mini',array(0=>'',1=>''),'en','200px',"100px");
		  ?></td>
		  <td valign="top">150x80 хэмжээтэй Үндсэн хуульд нийцэх сурталчилгаа оруулахыг зөвшөөрнө. Удирдагчид таны оруулсан сурталчилгааг шалгаж баталгаажуулснаар таны сурталчилгаа идэвхжих болно.</td>
		</tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td><input type="submit" class="button" name="addButton" id="addButton" value="Add banner" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="right">&nbsp;</td>
		</tr>
	  </table>
	</form>
	<?
	}
}
?>
