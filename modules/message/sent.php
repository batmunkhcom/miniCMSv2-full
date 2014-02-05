<?
if($_SESSION['lev'] == 0 || !isset($_SESSION['user_id'])){
	echo mbmError('Login required');
}else{
?>
<h1>Sent messages</h1>
    <?php 
	$posts = mbmGetMessages(array(
							'box'=>'Sent',
							'from_uid'=>$_SESSION['user_id'],
							'is_deleted'=>0,
							'is_replied'=>0,
							'is_draft'=>0,
							'order_by'=>'id',
							'asc'=>'DESC',
							'st'=>1
							));
	require_once(ABS_DIR.'modules/message/tpl_msg.php');
	
}
?>