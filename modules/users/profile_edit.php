<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}else{
	?>
	<script language="javascript">
	function mbmCheckForm(){
		var userForm=document.userRegistration;
		var result_txt = '';
		
		if(userForm.email.value.length<10){
			result_txt = result_txt+' please enter valid email';
		}else if(userForm.username.value.length<5){
			result_txt = result_txt+' username must consist of at least 5 chars';
		}else if(userForm.firstname.value==''){
			result_txt = result_txt+' please enter your firstname';
		}else if(userForm.lastname.value==''){
			result_txt = result_txt+' please enter your lastname';
		}else if(userForm.pass1.value!=userForm.pass2.value){
			result_txt = result_txt+' passwords do not match.';
		}else if(userForm.year.value==0){
			result_txt = result_txt+' please enter your birth year';
		}else if(userForm.occupation.value==''){
			result_txt = result_txt+' please enter occupation';
		}else if(userForm.city.value==''){
			result_txt = result_txt+' please enter city';
		}
		if(result_txt!=''){
			alert(result_txt);
			return false;
		}else{
			userForm.action="";
			userForm.method="post";
			userForm.submit();
			return true;
		}
	}
	</script><?
		if(isset($_POST['userRegistration'])){
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
	<form id="userRegistration" name="userRegistration" method="post" action="" onsubmit="mbmCheckForm();return false;">
	  <table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
		  <td align="right">Username</td>
		  <td><input name="username" type="text" class="input" id="username" value="<?=$DB2->mbm_result($r_user_profile,0,"username")?>" size="30" disabled="disabled" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
          <td align="right">Password:</td>
		  <td><input name="pass1" type="password" class="input" id="pass1" size="30" /></td>
		  <td align="right">&nbsp;</td>
	    </tr>
		<tr>
          <td align="right">Verify password:</td>
		  <td><input name="pass2" type="password" class="input" id="pass2" size="30" /></td>
		  <td align="right">&nbsp;</td>
	    </tr>
		<tr>
		  <td align="right">Firstame:</td>
		  <td><input name="firstname" type="text" class="input" value="<?=$DB2->mbm_result($r_user_profile,0,"firstname")?>" id="firstname" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">Lastname:</td>
		  <td><input name="lastname" type="text" class="input" id="lastname" value="<?=$DB2->mbm_result($r_user_profile,0,"lastname")?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">Phone:</td>
		  <td><input name="phone" type="text" class="input" id="phone" value="<?=$DB2->mbm_result($r_user_profile,0,"phone")?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">Fax:</td>
		  <td><input name="fax" type="text" class="input" id="fax" value="<?=$DB2->mbm_result($r_user_profile,0,"fax")?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">Mobile:</td>
		  <td><input name="mobile" type="text" class="input" id="mobile" value="<?=$DB2->mbm_result($r_user_profile,0,"mobile")?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">YIM:</td>
		  <td><input name="yim" type="text" class="input" id="yim" value="<?=$DB2->mbm_result($r_user_profile,0,"yim")?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">MSN:</td>
		  <td><input name="msn" type="text" class="input" id="msn" value="<?=$DB2->mbm_result($r_user_profile,0,"msn")?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">birthday:</td>
		  <td><select name="year" id="year" class="input">
			<option value="0">select year</option>
             <?
			 	unset($selected_value);
				$selected_value = substr($DB2->mbm_result($r_user_profile,0,"birthday"), 0, 4);
			 	echo mbmIntegerOptions((mbmDate("Y")-60), (mbmDate("Y")-13),$selected_value); ?>
		  </select>
		  -
		  <select name="month" id="month" class="input">
           <?
			 	unset($selected_value);
				$selected_value = substr($DB2->mbm_result($r_user_profile,0,"birthday"), 5, 2);
			 	echo mbmIntegerOptions(1, 12,$selected_value); ?>
				</select>
		  -
		  <select name="day" id="day" class="input">
           <?
			 	unset($selected_value);
				$selected_value = substr($DB2->mbm_result($r_user_profile,0,"birthday"), 8, 2);
			 	echo mbmIntegerOptions(1, 31,$selected_value); ?>
				</select></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">Gender</td>
		  <?
		  	 if($DB->mbm_result($r_user_profile,0,"gender") == 'M'){
			 	$sel1= 'checked="checked"';
				$sel2= '';
			 }else{
			 	$sel1= '';
				$sel2= 'checked="checked"';
			 }
		  ?>
		  <td><input name="gender" type="radio" id="gender" value="M" <?= $sel1;?>/>
			M 
			<input type="radio" name="gender" id="gender" value="F" <?= $sel2;?> />
			F</td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">Occupation:</td>
		  <td><input name="occupation" value="<?=$DB2->mbm_result($r_user_profile,0,"occupation")?>" type="text" class="input" id="occupation" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">City:</td>
		  <td><input name="city" value="<?=$DB2->mbm_result($r_user_profile,0,"city")?>" type="text" class="input" id="city" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">Country:</td>
		  <td><select name="country" id="country" class="input">
			  <?=mbmCountryList('dropdown')?>
				  </select>      </td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td width="20%" align="right">Email:</td>
		  <td width="30%"><input name="email" type="text" class="input" value="<?=$DB2->mbm_result($r_user_profile,0,"email")?>" id="email" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>		
		<tr>
		  <td align="right">Website:</td>
		  <td><input name="website" type="text" class="input" id="website" value="<?=$DB2->mbm_result($r_user_profile,0,"website")?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td><input type="submit" class="button" name="userRegistration" id="userRegistration" value="update profile" /></td>
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
