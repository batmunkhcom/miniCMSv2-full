<?
if($_SESSION['lev'] == 0 || !isset($_SESSION['user_id'])){
	echo mbmError('Login required');
}else{
?>
<h1>Deleted messages</h1>
    <?php 
	$posts = mbmGetMessages(array(
							//'box'=>'Trash',
							'to_uid'=>$_SESSION['user_id'],
							'is_deleted'=>1,
							'is_replied'=>0,
							'is_draft'=>0,
							'order_by'=>'id',
							'asc'=>'DESC',
							'st'=>1
							));
	require_once(ABS_DIR.'modules/message/tpl_msg.php');
	
}
?>