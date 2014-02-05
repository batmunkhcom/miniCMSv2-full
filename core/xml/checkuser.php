<?
switch($_GET['action']){
		case 'checkuser':
			if(isset($_GET['username'])){
				$uname = $DB2->mbm_check_field('username',$_GET['username'],'users');
			}elseif(isset($_GET['email'])){
				$uname = $DB2->mbm_check_field('email',$_GET['email'],'users');
			}
			$txt .= "\n\t<check st='".$uname."' />";
		break;
	}
?>