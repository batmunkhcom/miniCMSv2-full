<?
switch($_GET['type']){
	case 'send':
		if(strlen($_POST['content'])==''){
			$result_txt = "Empty content";
		}elseif(strlen($_POST['name'])==''){
			$result_txt = "Empty name";
				$ajax_st = 0;
		}elseif(mbmCheckEmail($_POST['email'])==false){
			$result_txt = "Invalid email";
				$ajax_st = 0;
		}else{
			
			$data['content'] = ($_POST['content']);
			$data['email'] = ($_POST['email']);
			if($DB2->mbm_check_field('id',$_SESSION['user_id'],'users')==1){
				$data['name'] = $DB2->mbm_get_field($_SESSION['user_id'],'id','username','users');
			}else{
				if($DB2->mbm_check_field('username',$_POST['name'],'users')==1) $data['name'] = $_POST['name'].'-Guest';
				else $data['name'] = ($_POST['name']);
			}						
			$data['ip'] = getenv("REMOTE_ADDR");
			$data['browser'] = $_SERVER['HTTP_USER_AGENT'];
			$data['date_added'] = mbmTime();
			$data['country'] = mbmCountry(getenv("REMOTE_ADDR"));
			
			$r_add_question = $DB->mbm_insert_row($data,"shoutbox");
			if($r_add_question==1){
				$result_txt = 'You have shouted loader :).';
				$ajax_st = 1;
			}else{
				$result_txt = 'Some error occurred';
				$ajax_st = 0;
			}
		}
	break;
}
if(isset($_POST['content'])){
	$txt .= "<div id=\"query_result\">";
	$txt .= $result_txt;
	$txt .= "</div>";
}
$q_shoutbox = "SELECT * FROM ".PREFIX."shoutbox ORDER BY id DESC LIMIT 50";
$r_shoutbox = $DB->mbm_query($q_shoutbox);

for($i=0;$i<$DB->mbm_num_rows($r_shoutbox);$i++){
	$txt .= "<div class=\"shoutContent\">";
	$txt .= "<span><strong><a href=\"mailto:".$DB->mbm_result($r_shoutbox,$i,"email")."\">".$DB->mbm_result($r_shoutbox,$i,"name")."</a></strong> : </span>";
	$txt .= mbmCleanUpHTML($DB->mbm_result($r_shoutbox,$i,"content"));
	$txt .= "</div>";
}
?>