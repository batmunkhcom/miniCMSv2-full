<?
	function mbmSessionClear($obj,$tbl){
		if($obj->mbm_query("UPDATE ".$tbl." SET session_id='' WHERE session_id='".session_id."'")){
			return true;
		}else{
			return false;
		}
	}
	function mbmSessionGetTime($obj,$tbl){
		$r = $obj->mbm_query("SELECT MAX(session_time) FROM ".$tbl);
		return $obj->mbm_result($r,0);
	}
?>