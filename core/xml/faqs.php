<?
switch($_GET['type']){
	case 'send':
		if($_POST['question']==''){
			$result_txt = "<div id=\"query_result\"> Empty question</div>";
		}elseif($_POST['name']==''){
			$result_txt = "<div id=\"query_result\"> Empty name</div>";
		}elseif(mbmCheckEmail($_POST['email'])==false){
			$result_txt = "<div id=\"query_result\"> Invalid email</div>";
		}else{
			
			$data['question'] = addslashes(nl2br($_POST['question']));
			$data['email'] = $_POST['email'];
			if($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==1){
				$data['name'] = $DB2->mbm_get_field($_SESSION['user_id'],'id','username','users');
			}else{
				$data['name'] = $_POST['name'];
			}						
			$data['user_id'] = $_SESSION['user_id'];
			$data['ip'] = getenv("REMOTE_ADDR");
			$data['browser'] = $_SERVER['HTTP_USER_AGENT'];
			$data['date_added'] = mbmTime();
			$data['date_lastupdated'] = $data['date_added'];
			$data['total_updated'] = 0;
			$data['lang'] = $_SESSION['ln'];
			
			$r_add_question = $DB->mbm_insert_row($data,"faqs");
			if($r_add_question==1){
				$result_txt = 'Your question has been sent.';
				mbmScheduleAdd(array(
								'name_from'=>$data['name'],
								'name_to'=>ADMIN_NAME,
								'email_from'=>$data['email'],
								'email_to'=>ADMIN_EMAIL,
								'st'=>0,
								'subject'=>'FAQ -->'.DOMAIN,
								'content'=>$data['name'].': '.$data['email'].' <br /> '.$data['question'],
								'date_added'=>mbmTime(),
								'date_sent'=>0
							)
						);
				/*
				*/
			}else{
				$result_txt = 'Some error occurred';
			}
		}
	break;
}
if(isset($_GET['type'])){
	$txt .= "<div id=\"query_result\">".$result_txt." </div>";
}

$txt .= mbmFAQsLastQuestions(5,0);
?>