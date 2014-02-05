<?
	function mBmDicLangDropDown(){
		global $DB;
		$buf = '';
		
			$q = "SELECT * FROM ".PREFIX."dic_langs ORDER BY id";
			$r = $DB->mbm_query($q);
			for($i=0;$i<$DB->mbm_num_rows($r);$i++){
				$buf .= '<option value="'.$DB->mbm_result($r,$i,"id").'" ';
				if($_POST['dic_lang_id']==$DB->mbm_result($r,$i,"id")){
					$buf .= 'selected ';
				}
				$buf .= '>'
				.$DB->mbm_result($r,$i,"name").'</option>';
			}
		return $buf;
	}
?>