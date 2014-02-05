<?
switch($_GET['type']){
	case 'send':
		$email_to = rawurldecode($_GET['email_to']);
		$email_from = rawurldecode($_GET['email_from']);
		$name_from = rawurldecode($_GET['name_from']);
		if(mbmCheckEmail($email_to)==false || mbmCheckEmail($email_from)==false ){
			$txt .= "<send2friend st='0' txt='Invalid email' />";
		}else{
			if($DB2->mbm_check_field('email',$email_to,'emails')==0){
				$data['email'] = $email_to;
				$data['time'] = mbmTime();
				
				$DB2->mbm_insert_row($data,'emails');
			}
			if($DB2->mbm_check_field('email',$email_from,'emails')==0){
				$data1['email'] = $email_from;
				$data1['time'] = mbmTime();
				
				$DB2->mbm_insert_row($data1,'emails');
			}
			
			$subject='Sain bn uu';
			
			$content = 'Sain bnuu {TO}. {FROM} taniig '.base64_decode($_GET['url']).' hayag ruu orj uzehiig sanal bolgoson bna.. ';
			$content .= SITE_SIGNATURE;
			
			if(mbmScheduleAdd(array(
								'name_from'=>$name_from,
								'name_to'=>$email_to,
								'email_from'=>'do_not_reply@yadii.net',
								'email_to'=>$email_to,
								'st'=>0,
								'subject'=>$subject,
								'content'=>$content,
								'date_added'=>mbmTime(),
								'date_sent'=>0
							)
						)==1){
				
				mbmUpdateUserScore($_SESSION['user_id'],2);
				
				$txt .= "<send2friend st='1' txt='sent' />";
			}else{
				$txt .= "<send2friend st='0' txt='some error occurred. please try again' />";
			}
		}
	break;
}
?>