<?
	switch($_GET['type']){
		case 'delete':
			if($DB2->mbm_get_field($_POST['id'],'id','user_id','zar_contents') == $_SESSION['user_id'] || $_SESSION['lev']==5){
				$DB2->mbm_query("DELETE FROM ".$DB2->prefix."zar_contents WHERE id='".$_POST['id']."' LIMIT 1");
				$txt .= $lang["zar"]['zar_delete'];
			}else{
				$txt .= $lang["zar"]['zar_is_not_yours'];
			}
		break;
	}
?>