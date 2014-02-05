<?
function mbmGetImagesFromTable(
								$var = array(
									  'field_name'=>'content_more',
									  'table_name'=>'contents',
									  'limit'=>10,
									  'order_by'=>'RAND()',
									  'where_value'=>'id!=0'
									  )	 
								){
	global $DB;
	
	$q = "SELECT ".$var['field_name']." FROM ".$var['table_name']." WHERE ".$var['field_name']." LIKE '%<img%' AND ".$var['where_value']." ORDER BY ".$var['order_by']." LIMIT ".$var['limit']."";
	$r = $DB->mbm_query($q);
	
	$buf = '';
	
	for($i=0;$i<mysql_num_rows($r);$i++){
		$dd = mbmCountImg(stripslashes(mysql_result($r,$i,"content")));
		$buf[] = $dd[0][0][0];
	}
	return $buf;
}

function mbmCountImg($txt = ''){
	
	preg_match_all('/<img[^>]+>/i',$txt, $result);
	
	$img = array();
	foreach( $result as $kk=>$v)
	{
		foreach( $result[$kk] as $k=>$vv)
		{
			preg_match_all('/(alt|title|src)=("[^"]*")/i',$vv, $img[$k]);
		}
	}
	
	return count($img);
}
function mbmGetImagesIntoArray($txt = ''){
	
	preg_match_all('/<img[^>]+>/i',$txt, $result);
	
	$img = array();
	foreach( $result as $kk=>$v)
	{
		foreach( $result[$kk] as $k=>$vv)
		{
			preg_match_all('/(alt|title|src)=("[^"]*")/i',$vv, $img[$k]);
		}
	}
	
	return ($img);
}
?>