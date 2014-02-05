<script language="javascript">
mbmSetContentTitle("<?=$lang["companies"]["add_company"]?>");
mbmSetPageTitle('<?=$lang["companies"]["add_company"]?>');
show_sub('menu18');
</script>
<?
if($mBm!=1 || $_SESSION['lev']<$modules_permissions[$_GET['module']] || 
					$DB2->mbm_get_field($_SESSION['user_id'],'id','lev','users')<$modules_permissions[$_GET['module']]){
	die('<div align="center"><font color="red">HACKING ATTEMPT....</font><br /> <a href="http://www.mng.cc">www.mng.cc</a></div>');
}

$categories = mbmCompanyCategories();
$services = mbmCompanyServices();
if(!is_array($services) || !is_array($categories)){
		echo mbmError("ehleed category uilchilgee oruulah shaardlagatai");
}else{
	
	if(isset($_POST['buttonAdd'])){
		$data['category_ids'] = ',';
		if(is_array( $_POST['categories'])){
			foreach( $_POST['categories'] as $k=>$v){
				$data['category_ids'] .= $v.',';
			}
		}else{
			$result_txt .= "yadaj neg category songo";
		}
		if(!is_array( $_POST['services'])){
			$result_txt .= "yadaj neg service songo";
		}
		
		$data['name_mn'] = $_POST['name_mn'];
		$data['name_en'] = $_POST['name_en'];
		$data['st'] = $_POST['st'];
		$data['logo'] = $_POST[''];
		$data['phone'] = $_POST['phone'];
		$data['fax'] = $_POST['fax'];
		$data['email'] = $_POST['email'];
		$data['web'] = $_POST['web'];
		$data['city'] = $_POST['city'];
		$data['district'] = $_POST['district'];
		$data['address'] = $_POST['address'];
		$data['content_short'] = $_POST['content_short'];
		$data['content_more'] = $_POST['content_more'];
		$data['user_id'] = $_SESSION['user_id'];
		$data['date_added'] = mbmTime();
		$data['session_id'] = session_id();
		
					
		$name_array[0] = array('<','&','#','№','@','>','(',')',' ','%','$','^','"',"'");
		$name_array[1] = array('_','_','_','_','_','_','_','_','_','_','_','_','_','_');
		$logo_filename = 'logo-'.mbmTime().basename(str_replace($name_array[0],$name_array[1],$_FILES['logo']['name']));
		
		if(strlen($data['name_mn'])<3){
				$result_txt = 'ERROR :: Short name';
		}elseif(strlen($data['phone'])<4){
				$result_txt = 'ERROR :: invalid phone';
		}elseif(!move_uploaded_file($_FILES['logo']['tmp_name'],ABS_DIR.PHOTO_DIR.$logo_filename)){
			$result_txt .= $_FILES['logo']['name'].' '.$lang['menu']['command_image_file_upload_failed'].'.<br />';
			$b=2;
		}else{
			$data['logo'] = PHOTO_DIR.$logo_filename;
			
			if($b!=2){
				if($DB->mbm_insert_row($data,'companies')==1){
					$result_txt = $lang["companies"]["insert_command_processed"];
					$company_id = $DB->mbm_get_field(session_id(),'session_id','id','companies');
					$DB->mbm_query("UPDATE ".$DB->prefix."companies SET session_id='' WHERE session_id='".session_id()."'");
					foreach( $_POST['services'] as $k=>$v){
						$data_services['user_id'] = $_SESSION['user_id'];
						$data_services['company_id'] = $company_id;
						$data_services['service_id'] = $k;
						$data_services['date_added'] = mbmTime();
						if($DB->mbm_insert_row($data_services,"company_services")==1){
							//$result_txt .= $v.' added<br />';
						}
						unset($data_services);
					}
					$b=1;
				}else{
					$result_txt = $lang["companies"]["insert_command_failed"];
				}
			}
		}
	}
	if($result_txt !=''){
		echo mbmError($result_txt);
	}
	if($b!=1){	
	?>
	<form name="form1" method="post" action="" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="2" cellpadding="3" class="tblContents">
	  <tr class="list_header">
		<td width="50%">&nbsp;</td>
		<td ></td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["categories"]?>:<br />
		  <select name="categories[]" size="8" multiple="multiple" id="categories[]" style="width:300px;">
		<?
			foreach($categories as $k=>$v){
				echo '<option value="'.$k.'">'.$v.'</option>';
			}
		?>
		  </select></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
	    <td bgcolor="#F5F5F5" ><?=$lang["main"]["status"]?>:<br />
	      <select name="st" id="st">
          <?=mbmShowStOptions($_POST['st'])?>
          </select>  </td>
	    <td bgcolor="#F5F5F5">&nbsp;</td>
      </tr>
	  <tr >
	    <td bgcolor="#F5F5F5" >&nbsp;</td>
	    <td bgcolor="#F5F5F5">&nbsp;</td>
      </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >
		<?=$lang["companies"]["name_mn"]?><br>
		<input name="name_mn" type="text" id="name_mn" size="30">
	  </td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["name_en"]?><br />
		  <input name="name_en" type="text" id="name_en" size="30" /></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["services"]?>:<br />
		<?
		foreach($services as $k=>$v){
			echo '<div style="width:150px; float:left; margin-right:5px; padding-bottom:10px; display:block;">';
				echo '<input type="checkbox" value="'.$k.'" name="services['.$k.']" /> - '.$v;
			echo '</div>';
		}
		?>
		</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["select_logo"]?>:<br />
		  <input name="logo" type="file" id="logo" size="30" /></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["phone"]?>:<br />
		  <input name="phone" type="text" id="phone" size="30" value="<?=$_POST['phone']?>" /></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["fax"]?>:<br />
		  <input name="fax" type="text" id="fax" size="30" value="<?=$_POST['fax']?>" /></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["email"]?>:<br />
		  <input name="email" type="text" id="email" size="30" value="<?=$_POST['email']?>" /></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["web"]?>:<br />
		  <input name="web" type="text" id="web" value="http://" size="30" value="<?=$_POST['web']?>" /></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["city"]?>:<br />
		  <input name="city" type="text" id="city" size="30" value="<?=$_POST['city']?>" /></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["district"]?>:<br />
		  <input name="district" type="text" id="district" size="30" value="<?=$_POST['district']?>" /></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><?=$lang["companies"]["address"]?>:<br />
          <textarea name="address" cols="30" rows="5" id="address"><?=$_POST['address']?></textarea></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td colspan="2" bgcolor="#F5F5F5" >
		<?
		mbmShowHTMLEditor("both",'spaw2','spaw','all',array(0=>$_POST['content_more'],1=>$_POST['content_short'])
								,'en','100%',"400px");
		?>
		</td>
		</tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" ><input type="submit" name="buttonAdd" id="buttonAdd" value="<?=$lang["companies"]["add_company"]?>"></td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	  <tr >
		<td bgcolor="#F5F5F5" >&nbsp;</td>
		<td bgcolor="#F5F5F5">&nbsp;</td>
	  </tr>
	</table>
	</form>
</td>
</tr>
</table>
	<?
	}
}
?>