<?
function mbmShowByLang($b=array('mn'=>'','en'=>'')){
	foreach($b as $k=>$v){
		if($k==$_SESSION['ln']){
			$result = $v;
		}
	}
	return $result;
}
?>