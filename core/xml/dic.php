<?
if(strlen($_GET['word'])==''){
	$txt .= "\n\t<word keyword=\"Error:\"> Empty keyword</word>";
}else{
	$q_dic = "SELECT * FROM ".PREFIX."dic_words WHERE word LIKE '%".rawurldecode($_GET['word'])."%' "
			 ."AND dic_lang_id='".$_GET['lang_id']."' "
			 ."LIMIT ".$_GET['limit'];
	$r_dic = $DB->mbm_query($q_dic);
	for($i=0;$i<$DB->mbm_num_rows($r_dic);$i++){
		$txt .= "\n\t<word keyword='".$DB->mbm_result($r_dic,$i,"word")."'>"
				.$DB->mbm_result($r_dic,$i,"comment")."</word>";
		$DB->mbm_query("UPDATE ".PREFIX."dic_words SET hits=hits+".HITS_BY." WHERE id='".$DB->mbm_result($r_dic,$i,"id")."'");
	}
	if($DB->mbm_num_rows($r_dic)==0){
		$txt .= "\n\t<word keyword='Error:'> not found </word>";
	}
}
?>