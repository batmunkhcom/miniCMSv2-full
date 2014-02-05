<?
	function mbmForumCatOptions($forum_id=0,$selected_id=0){
		global $DB;
		static $buf = '';
		$q = "SELECT * FROM ".PREFIX."forums WHERE forum_id='".$forum_id."' AND lang='".$_SESSION['ln']."' ORDER BY pos";
		$r = $DB->mbm_query($q);
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
			$buf .= '<option value="'.$DB->mbm_result($r,$i,"id").'" ';
				if($selected_id == $DB->mbm_result($r,$i,"id")){
					$buf .= ' selected';
				}
				$buf .= '>';
				$buf .= str_repeat("-",($DB->mbm_result($r,$i,"sub")*5));
				$buf .= $DB->mbm_result($r,$i,"name");
			$buf .= '</option>';
			if($DB->mbm_check_field('forum_id',$DB->mbm_result($r,$i,"id"),'forums')==1){
				mbmForumCatOptions($DB->mbm_result($r,$i,"id"));
			}
		}
		return $buf;
	}
	function mbmForumMaxPos($forum_id=0){
		global $DB;
		
		$q = "SELECT MAX(pos) FROM ".PREFIX."forums WHERE forum_id='".$forum_id."'"; 
		$r = $DB->mbm_query($q);
		
		return $DB->mbm_result($r,0);
	}
	
	/*
	forum_id : update hiij bui forumiin id
	sub : update hiij bui forum iin sub
	*/
	function mbmForumUpdate($forum_id=0,$sub=0){
		global $DB;
		
		if($sub==0){
			$sub = $DB->mbm_get_field($forum_id,'id','sub','forums');
		}
		$q = "SELECT * FROM ".PREFIX."forums WHERE forum_id='".$forum_id."'";
		$r = $DB->mbm_query($q);
		
		$DB->mbm_query("UPDATE ".PREFIX."forums SET sub='".($sub+1)."' WHERE forum_id='".$forum_id."'");
		
		for($i=0;$i<$DB->mbm_num_rows($r);$i++){
			mbmForumUpdate($DB->mbm_result($r,$i,"id"),$DB->mbm_result($r,$i,"sub"));
		}
		return  true;
	}
?>