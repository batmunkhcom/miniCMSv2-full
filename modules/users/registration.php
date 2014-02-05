<?
if($mBm!=1){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}elseif($_SESSION['lev']>0){
	echo '<div id="query_result">You must be logged out before register. 
			<a href="index.php?action=logout&url='.base64_encode('index.php?module=users&cmd=registration').'">click here</a> to log out.</div>';
}else{
	?>
	<script language="javascript">
	function mbmCheckForm(){
		var userForm=document.userRegistration;
		var result_txt = '';
		
		if(userForm.email.value.length<10){
			result_txt = result_txt+' <?=$lang["users"]["invalid_email"]?>';
		}else if(userForm.username.value.length<5){
			result_txt = result_txt+' <?=$lang["users"]["short_username"]?>';
		}else if(userForm.firstname.value==''){
			result_txt = result_txt+' <?=$lang["users"]["enter_firstname"]?>';
		}else if(userForm.lastname.value==''){
			result_txt = result_txt+' <?=$lang["users"]["enter_lastname"]?>';
		}else if(userForm.pass1.value==''){
			result_txt = result_txt+' <?=$lang["users"]["enter_password"]?>';
		}else if(userForm.pass1.value!=userForm.pass2.value){
			result_txt = result_txt+' <?=$lang["users"]["passwords_not_match"]?>';
		}else if(userForm.year.value==0){
			result_txt = result_txt+' <?=$lang["users"]["enter_birth_year"]?>';
		}else if(userForm.occupation.value==''){
			result_txt = result_txt+' <?=$lang["users"]["enter_occupation"]?>';
		}else if(userForm.city.value==''){
			result_txt = result_txt+' <?=$lang["users"]["enter_city"]?>';
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
	</script>
	<h2>Registration
	</h2>
	  <?
		if(isset($_POST['username'])){
			$data['lev']=1;
			if(USER_DIRECT_ACTIVATION=='1'){
				$data['st']=1;
			}else{
				$data['activation_key']=rand(1000000,9999999);
				$data['st']=0;
			}
			
			$data['username']=strtolower($_POST['username']);
			$data['password']=md5($_POST['pass1']);
			$data['email']=$_POST['email'];
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
			$data['interests']='';
			$data['city']=$_POST['city'];
			$data['country']=$_POST['country'];
			$data['website']=$_POST['website'];
			$data['newsletter']=$_POST['newsletter'];
			$data['date_added']=mbmTime();
			$data['enable_blog']=1;
			$data['session_id']=session_id();
			
			if(!eregi("^[a-zA-Z]+[a-zA-Z0-9_]+[a-zA-Z0-9_]$",$_POST['username'])){
				$result_txt = $lang["users"]['invalid_username_format'];
			}elseif($DB2->mbm_check_field('username',$data['username'],'users')==1){
				$result_txt = $lang["users"]["already_exists_username"];
			}elseif(mbmCheckEmail($_POST['email'])==0){
				$result_txt = $lang["users"]["invalid_email"];
			}elseif($DB2->mbm_check_field('email',$data['email'],'users')==1){
				$result_txt = $lang["users"]["already_exists_email"];
			}else{
				if($DB2->mbm_insert_row($data,'users')==1){
					
					$v_link = DOMAIN.DIR.'index.php?action=verification&UID='.$DB2->mbm_get_field($data['session_id'],'session_id','id','users')
										.'&url='.base64_encode('index.php?module=users&cmd=login'
										.'&key='.$data['activation_key']);
					if(USER_DIRECT_ACTIVATION=='0'){
						$email_content  = REGISTRATION_EMAIL.$lang['users']['verification_txt'] ;
					}else{
						$email_content = REGISTRATION_EMAIL;
					}
					$email_content = str_replace("{USERNAME}",$data['username'],$email_content );
					$email_content = str_replace("{PASSWORD}",$_POST['pass1'],$email_content);
					$email_content = str_replace("{DOMAIN}",DOMAIN,$email_content);
					
					if(USER_DIRECT_ACTIVATION=='0'){
						$email_content = str_replace("{VERIFICATION_LINK}",$v_link,$email_content);
					}else{
						$email_content = str_replace("{VERIFICATION_LINK}","",$email_content);
					}
					
					$result_txt = $lang['users']['registration_successfull'];
					$b=1;
					mbmSendEmail(ADMIN_NAME.'|'.ADMIN_EMAIL,$data['username'].'|'.$data['email'],DOMAIN.": User registration info",$email_content);
					//mbmSendEmail($data['firstname'].'|'.$data['email'],ADMIN_NAME.'|'.ADMIN_EMAIL,DOMAIN.": User {".$data['username']."} has been registered",mbmDate("Y-m-d, H:i:s"));
				}else{
					$result_txt = $lang["users"]["error_occurred"];
				}
			}
			echo '<div id="query_result">'.$result_txt.'</div>';
		}
	if($b!=1){
	?>
	<form id="userRegistration" name="userRegistration" method="post" action="" onsubmit="mbmCheckForm();return false;">
	  <table width="100%" border="0" cellspacing="2" cellpadding="3">
	
		<tr>
		  <td width="20%" align="right"><?=$lang["users"]["email"]?>:</td>
		  <td width="30%"><input name="email" type="text" class="input" value="<?=$_POST['email']?>" id="email" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["select_username"]?></td>
		  <td><input name="username" type="text" class="input" id="username" value="<?=$_POST['username']?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["password"]?>:</td>
		  <td><input name="pass1" type="password" class="input" id="pass1" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["verify_password"]?>:</td>
		  <td><input name="pass2" type="password" class="input" id="pass2" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["firstname"]?>:</td>
		  <td><input name="firstname" type="text" class="input" value="<?=$_POST['firstname']?>" id="firstname" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["lastname"]?>:</td>
		  <td><input name="lastname" type="text" class="input" id="lastname" value="<?=$_POST['lastname']?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		
		<tr>
		  <td align="right"><?=$lang["users"]["phone"]?>:</td>
		  <td><input name="phone" type="text" class="input" id="phone" value="<?=$_POST['phone']?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["fax"]?>:</td>
		  <td><input name="fax" type="text" class="input" id="fax" value="<?=$_POST['fax']?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["mobile"]?>:</td>
		  <td><input name="mobile" type="text" class="input" id="mobile" value="<?=$_POST['mobile']?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["yim"]?>:</td>
		  <td><input name="yim" type="text" class="input" id="yim" value="<?=$_POST['yim']?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["msn"]?>:</td>
		  <td><input name="msn" type="text" class="input" id="msn" value="<?=$_POST['msn']?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["birthday"]?>:</td>
		  <td><select name="year" id="year" class="input">
			<option value="0"><?=$lang["users"]["select_birth_year"]?></option>
             <?
			 unset($selected_value);
			 if(isset($_POST['year'])){
				 $selected_value = $_POST['year'];
			 }else{
				 $selected_value = (mbmDate("Y")-18);
			 }
			 echo mbmIntegerOptions((mbmDate("Y")-60), (mbmDate("Y")-13),$selected_value); ?>
		  </select>
		  -
		  <select name="month" id="month" class="input">
           <?
			 unset($selected_value);
			 if(isset($_POST['month'])){
				 $selected_value = $_POST['month'];
			 }else{
				 $selected_value = mbmDate("m");
			 }
			 echo mbmIntegerOptions(1, 12,$selected_value); ?>
				</select>
		  -
		  <select name="day" id="day" class="input">
           <?
			 unset($selected_value);
			 if(isset($_POST['day'])){
				 $selected_value = $_POST['day'];
			 }else{
				 $selected_value = mbmDate("d");
			 }
			 echo mbmIntegerOptions(1, 31,$selected_value); ?>
				</select></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["gender"]?></td>
		  <td><input name="gender" type="radio" id="gender" value="M" checked="checked" />
			<?=$lang["users"]["male"]?> 
			<input type="radio" name="gender" id="gender" value="F" />
			<?=$lang["users"]["female"]?></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["occupation"]?>:</td>
		  <td><input name="occupation" value="<?=$_POST['occupation']?>" type="text" class="input" id="occupation" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["city"]?>:</td>
		  <td><input name="city" value="<?=$_POST['city']?>" type="text" class="input" id="city" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["country"]?>:</td>
		  <td><select name="country" id="country" class="input">
			  <?=mbmCountryList('dropdown')?>
				  </select>      </td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><?=$lang["users"]["website"]?>:</td>
		  <td><input name="website" type="text" class="input" id="website" value="<?
          if(isset($_POST['website'])){
		  	echo $_POST['website'];
		  }else{
		  	echo 'http://';
		  }
		  ?>" size="30" /></td>
		  <td align="right">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td><input type="submit" class="button" name="userRegistration" id="userRegistration" value="<?=$lang["users"]["button_register"]?>" /></td>
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
