<?
	//limit="+limit+"&div_id="+div_id+"&order_by="+order_by++"&type="+type+"&asc="+asc+"&phone="+phone+"&content="+content,
	
	if(!isset($_POST['user_id'])) $user_id = 0;
	if(!isset($_POST['limit'])) $limit = 1;
	if(!isset($_POST['order_by'])) $order_by = 'hits';
	if(!isset($_POST['type'])) $type = 'sms';
	if(!isset($_POST['asc'])) $asc = 'asc';
	if(!isset($_POST['limphoneit'])) $phone = 0;
	if(!isset($_POST['content'])) $content = 0;
	
	$txt .= mbmShowZar(array(
								 'user_id'=>$user_id,
								 'phone'=>$phone,
								 'order_by'=>$order_by,
								 'asc'=>$asc,
								 'content'=>$content,
								 'limit'=>$limit
								 ));
?>