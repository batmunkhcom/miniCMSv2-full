<?
//$txt .= '.....'.$_POST['type'].'......'.$_POST['value'].'...'.$_POST['code'];
if(isset($_POST['type'])){
	$data['type'] = $_POST['type'];
	$data['value'] = $_POST['value'];
	$data['user_id'] = $_SESSION['user_id'];
	$data['date_added'] = mbmTime();
	$data['code'] = $_POST['code'];
	
	$DB2->mbm_insert_row($data,"ilike");
}

$txt .= mbmIlike(array(
							   'up'=>1,
							   'down'=>0,
							   'code'=>$_POST['code']
							   ));
?>