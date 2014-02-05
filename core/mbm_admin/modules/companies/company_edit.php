<script language="javascript">
mbmSetContentTitle("<?=$lang["companies"]["edit_company"]?>");
mbmSetPageTitle('<?=$lang["companies"]["edit_company"]?>');
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
	
	if(isset($_POST['buttonEdit'])){
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
		$data['session_id'] = session_id();
		
					
		$name_array[0] = array('<','&','#','№','@','>','(',')',' ','%','$','^','"',"'");
		$name_array[1] = array('_','_','_','_','_','_','_','_','_','_','_','_','_','_');
		$logo_filename = 'logo-'.mbmTime().basename(str_replace($name_array[0],$name_array[1],$_FILES['logo']['name']));
		
		if(strlen($data['name_mn'])<3){
				$result_txt = 'ERROR :: Short name';
		}elseif(strlen($data['phone'])<4){
				$result_txt = 'ERROR :: invalid phone';
		}else{
			$data['logo'] = $_POST['logo'];
			
			if($b!=2){
				if($DB->mbm_update_row($data,'companies',$_GET['id'])==1){
					$result_txt = $lang["companies"]["update_command_processed"];
					$company_id = $DB->mbm_get_field(session_id(),'session_id','id','companies');
					$DB->mbm_query("UPDATE ".$DB->prefix."companies SET session_id='' WHERE session_id='".session_id()."'");
					
					$DB->mbm_query("DELETE FROM ".$DB->prefix."company_services WHERE company_id='".addslashes($_GET['id'])."'");
					
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
					$result_txt = $lang["companies"]["update_command_failed"];
				}
			}
		}
	}
	if($result_txt !=''){
		echo mbmError($result_txt);
	}
	$q_co = "SELECT * FROM ".$DB->prefix."companies WHERE id='".addslashes($_GET['id'])."'";
	$r_co = $DB->mbm_query($q_co);
	if($DB->mbm_num_rows($r_co) == 1){
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
			  <?=mbmShowStOptions($DB->mbm_result($r_co,0,"st"))?>
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
			<input name="name_mn" type="text" id="name_mn" value="<?=$DB->mbm_result($r_co,0,"name_mn")?>" size="30">
		  </td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" ><?=$lang["companies"]["name_en"]?><br />
			  <input name="name_en" type="text" id="name_en" value="<?=$DB->mbm_result($r_co,0,"name_en")?>" size="30" /></td>
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
					echo '<input type="checkbox" value="'.$k.'" name="services['.$k.']" ';
					$q_check_service = "SELECT COUNT(id) FROM ".$DB->prefix."company_services WHERE company_id = '".$DB->mbm_result($r_co,0,"id")."' AND service_id = '".$k."'";
					$r_check_service = $DB->mbm_query($q_check_service);
					if($DB->mbm_result($r_check_service,0)>0){
						echo 'checked="checked" ';
					}
					
					echo '/> - '.$v;
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
			  <input name="logo" type="text" id="logo" size="30" value="<?=$DB->mbm_result($r_co,0,"logo")?>" /></td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" ><?=$lang["companies"]["phone"]?>:<br />
			  <input name="phone" type="text" id="phone" size="30" value="<?=$DB->mbm_result($r_co,0,"phone")?>" /></td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" ><?=$lang["companies"]["fax"]?>:<br />
			  <input name="fax" type="text" id="fax" size="30" value="<?=$DB->mbm_result($r_co,0,"fax")?>" /></td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" ><?=$lang["companies"]["email"]?>:<br />
			  <input name="email" type="text" id="email" size="30" value="<?=$DB->mbm_result($r_co,0,"email")?>" /></td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" ><?=$lang["companies"]["web"]?>:<br />
			  <input name="web" type="text" id="web" size="30" value="<?=$DB->mbm_result($r_co,0,"web")?>" /></td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" ><?=$lang["companies"]["city"]?>:<br />
			  <input name="city" type="text" id="city" size="30" value="<?=$DB->mbm_result($r_co,0,"city")?>" /></td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" ><?=$lang["companies"]["district"]?>:<br />
			  <input name="district" type="text" id="district" size="30" value="<?=$DB->mbm_result($r_co,0,"district")?>" /></td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" ><?=$lang["companies"]["address"]?>:<br />
			  <textarea name="address" cols="30" rows="5" id="address"><?=$DB->mbm_result($r_co,0,"address")?></textarea></td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td colspan="2" bgcolor="#F5F5F5" >
			<?
			mbmShowHTMLEditor("both",'spaw2','spaw','all',array(0=>$DB->mbm_result($r_co,0,"content_more"),1=>$DB->mbm_result($r_co,0,"content_short"))
									,'en','100%',"400px");
			?>
			</td>
			</tr>
		  <tr >
			<td bgcolor="#F5F5F5" >&nbsp;</td>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
		  <tr >
			<td bgcolor="#F5F5F5" ><input type="submit" name="buttonEdit" id="buttonEdit" value="<?=$lang["companies"]["edit_company"]?>"></td>
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
	}else{
		echo mbmError("no such company found");
	}
}
?>