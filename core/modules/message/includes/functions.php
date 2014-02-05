<?php
function mbmMessageLinks(){
	$links = array();
	$links[COMPOSE] 	= 'index.php?module=message&cmd=box&c=compose';
	$links[INBOX] 		= 'index.php?module=message&cmd=box&c=inbox';
	//$links[DRAFTBOX] 	= 'index.php?module=message&cmd=box&c=draft';
	$links[SENTBOX] 	= 'index.php?module=message&cmd=box&c=sent';
	$links[TRASHBOX] 	= 'index.php?module=message&cmd=box&c=trash';
	
	$buf = '';
	
	foreach($links as $k=>$v){
		$buf .= '<a href="'.$v.'">'.$k.'</a>';
	}
	
	return $buf;
}

function mbmGetMessages($val = array(
							/*
							'box'=>'Inbox',
							'from_uid'=>0,
							'to_uid'=>0,
							'is_deleted'=>0,
							'is_replied'=>0,
							'is_draft'=>0,
							'subject'=>'',
							'content'=>'',
							'since_date_replied'=>0,
							'since_date_added'=>0,
							'since_date_deleted'=>0,
							'order_by'=>'id',
							'asc'=>'asc',
							'priority'=>0,
							'is_all'=>0,
							'st'=>1
							*/
							)){
	global $DB, $DB2;
	
	$q =  "SELECT * FROM ".$DB->prefix."messages WHERE id!=0 ";
	if(isset($val['box'])){
		$q .= "AND box='".$val['box']."' ";
	}
	if(isset($val['st'])){
		$q .= "AND st='".$val['st']."' ";
	}
	if(isset($val['to_uid'])){
		$q .= "AND to_uid='".$val['to_uid']."' ";
	}
	if(isset($val['from_uid'])){
		$q .= "AND from_uid='".$val['from_uid']."' ";
	}
	if(isset($val['is_deleted'])){
		$q .= "AND is_deleted='".$val['is_deleted']."' ";
	}
	if(isset($val['is_draft'])){
		$q .= "AND is_draft='".$val['is_draft']."' ";
	}
	if(isset($val['is_replied'])){
		$q .= "AND is_replied='".$val['is_replied']."' ";
	}
	if(isset($val['priority'])){
		$q .= "AND priority='".$val['priority']."' ";
	}
	if(isset($val['subject'])){
		$q .= "AND subject LIKE '%".$val['subject']."%' ";
	}
	if(isset($val['content'])){
		$q .= "AND content LIKE '%".$val['content']."%' ";
	}
	if(isset($val['since_date_replied'])){
		$q .= "AND since_date_replied > ".$val['since_date_replied']." ";
	}
	if(isset($val['since_date_added'])){
		$q .= "AND date_added > ".$val['since_date_added']." ";
	}
	if(isset($val['since_date_deleted'])){
		$q .= "AND since_date_deleted > ".$val['since_date_deleted']." ";
	}
	if(isset($val['order_by'])){
	  $q .= " ORDER BY ".$val['order_by']." ";
	  if(isset($val['asc'])){
	  	$q .= $val['asc']." ";
	  }
	}
	
	$r = $DB->mbm_query($q);
	
	$messages = array();
	for($i=0;$i<$DB->mbm_num_rows($r);$i++){
		$messages[$i]['id'] = $DB->mbm_result($r,$i,"id");
		$messages[$i]['from_uid'] = $DB->mbm_result($r,$i,"from_uid");
		$messages[$i]['date_added'] = $DB->mbm_result($r,$i,"date_added");
		$messages[$i]['subject'] = $DB->mbm_result($r,$i,"subject");
		$messages[$i]['content'] = $DB->mbm_result($r,$i,"content");
		$messages[$i]['priority'] = $DB->mbm_result($r,$i,"priority");
		$messages[$i]['to_uid'] = $DB->mbm_result($r,$i,"to_uid");
		$messages[$i]['is_read'] = $DB->mbm_result($r,$i,"is_read");
	}
	
	return $messages;
	
}
?>