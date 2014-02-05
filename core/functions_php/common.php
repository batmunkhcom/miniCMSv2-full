<?
// page ledeg function v2
function mbmNextPrev($url=NULL,$num_rows=0,$start=0,$per_page=10)
{
	global $lang;
	$total_pages = ceil($num_rows/$per_page);
	$current_page = (($start/$per_page)+1);
	
	
	$tmp_cccccc = 5; // heden shirhegiig haruulah
	
	if(($current_page-$tmp_cccccc)>0){
		$i_start = $current_page - $tmp_cccccc;
	}else{
		$i_start = 1;
	}
	if(($current_page+$tmp_cccccc)<$total_pages){
		$end = $current_page + $tmp_cccccc;
	}else{
		$end = $total_pages;
	}
	if($current_page!=1){
		$buf .= '<span id="page_numbers">';
		$buf .= '<a href="'.$url.'" style="color:#333;">'
				.$lang['main']['paging_prev'].' '
				.'</a>';
		$buf .= '</span>';
	}
	if($current_page>$tmp_cccccc && ($current_page-$tmp_cccccc)>1){
		$buf .= '<span id="page_numbers">';
		$buf .= '<a href="'.$url.'&amp;start=0" style="color:#333;">';
		$buf .= 1;
		$buf .= '</a>';
		$buf .= '</span>';
		if(($current_page-$tmp_cccccc)>2) $buf .= ' ... ';
	}
	for($i=$i_start;$i<=$end;$i++){
		if($i==$current_page){
			$buf .= '<span id="page_numbers" style="border:2px solid #333;color:#333;">';
			$buf .= '<strong>'.$i.'</strong>';
		}else{
			$buf .= '<span id="page_numbers">';
			$buf .= '<a href="'.$url.'&amp;start='.(($i-1)*$per_page).'" style="color:#333;">';
			$buf .= $i;
			$buf .= '</a>';
		}
		$buf .= '</span>';
	}
	$buf = rtrim($buf,', ');
	
	if($num_rows<$per_page){
		return '';
	}
	
	if($total_pages != $current_page && $total_pages>$end){
		$buf .= ' ... ';
		$buf .= '<span id="page_numbers">';
		$buf .= '<a href="'.$url.'&amp;start='.(floor($num_rows/$per_page)*$per_page).'" style="color:#6d6d6d;">';
		$buf .= $total_pages;
		$buf .= '</a>';
		$buf .= '</span>';
	}
	
	if($total_pages>$current_page){
		$buf .= '<span id="page_numbers">';
		$buf .= '<a href="'.$url.'&amp;start='.(($current_page)*$per_page).'" style="color:#6d6d6d;">'
				.' '.$lang['main']['paging_next']
				.'</a>';
		$buf .= '</span>';
	}
	
	return '<div id="Paging">'.$buf.'</div>';
	//return '<div id="Paging"><span id="page_numbers">Үзэж буй хуудас: '.$current_page.' Нийт хуудас: '.$total_pages.'</span> '.$buf.'</div>';
}
// page ledeg function v2end

// page ledeg function v1
/*
function mbmNextPrev($url=NULL,$num_rows=0,$start=0,$per_page=10)
{
	global $lang;
	$total_pages = ceil($num_rows/$per_page);
	$current_page = (($start/$per_page)+1);
	
	if(($current_page-3)>0){
		$i_start = $current_page - 3;
	}else{
		$i_start = 1;
	}
	if(($current_page+3)<$total_pages){
		$end = $current_page + 3;
	}else{
		$end = $total_pages;
	}
	$buf .= '<span id="page_numbers">';
	$buf .= '<a href="'.$url.'" style="color:#333333;">'
			.'&laquo; '
			.'</a>';
	$buf .= '</span>';
	for($i=$i_start;$i<=$end;$i++){
		$buf .= '<span id="page_numbers">';
		if($i==$current_page){
			$buf .= '<strong>'.$i.'</strong>';
		}else{
			$buf .= '<a href="'.$url.'&amp;start='.(($i-1)*$per_page).'">';
			$buf .= $i;
			$buf .= '</a>';
		}
		$buf .= '</span>';
	}
	$buf = rtrim($buf,', ');
	
	if($num_rows<$per_page){
		return '';
	}
	$buf .= '<span id="page_numbers">';
	$buf .= '<a href="'.$url.'&amp;start='.(floor($num_rows/$per_page)*$per_page).'" style="color:#333333;">'
			.' &raquo;'
			.'</a>';
	$buf .= '</span>';
	return '<div id="Paging">Хуудас : '.$buf.'</div>';
}
*/
// next priv v1 end
function mbmCheckLink($link)
{
//	if(!eregi("^[a-z]+[a-z0-9_-]*(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.([a-z]+){2,}$", $email))
//	{
//		return false; // invalid email address
//	}
//	else{
		return true;
//	}
}
function mbmWriteFile($somecontent,$filename,$mode="w"){
	
	if (is_writable($filename)) {
	
	   // $somecontent -ig bichne.
	   if (!$handle = fopen($filename, $mode)) {
			return 3;//file iig neej chadaagui
	   }
	
	   // Write $somecontent to our opened file.
	   if (fwrite($handle, $somecontent) === FALSE) {
		   return 2; // file ruu bichij chadsangui
	   }
	   
	   return 1; // amjilttai
	   
	   fclose($handle);
	
	} else {
	   return 0; // file aa 0777 bolgo.
	}
}
function mbmPercent($a=50,$total_percent=100,$color=0){
	$b = ceil(($a/$total_percent)*100);
	$c = number_format((($a/$total_percent)*100),2,'.',',');
	$colors[0] = array('#356db3','#9ab6d9');
	$colors[1] = array('#00805c','#9ae1cd');
	$colors[2] = array('#ff8000','#ffddba');
	$colors[3] = array('#8f038f','#ffa8ff');
	$colors[4] = array('#a0410d','#ffdcc8');
	$colors[5] = array('#666666','#DDDDDD');
	
	
	$buf = '<table cellspacing="0" cellpadding="0" width="100">';
	$buf .= '<tr><td colspan="2" align="left">'.$a.'</td></tr>';
	$buf .= '<tr style="border: 1px solid '.$colors[$color][0].';">
				<td bgcolor="'.$colors[$color][0].'" height="8" width="'.$b.'"></td>
				<td bgcolor="'
			.$colors[$color][1].'" width="'.(100-$b).'"></td></tr>';
	$buf .= '<tr><td colspan="2" align="left">'.$c.'%</td></tr>';
	$buf .= '</table>';
	return $buf;
}
function mbmError($text=''){
	return '<div id="query_result">'.$text.'</div>';
}

function mbmKPHtoMPS($var = array(
							'km'=>1,
							'second'=>1
							)){ // km/tsag iig meter/sec ruu hurvuuleh

	return number_format(($var['km']*1000)/3600,2);
}

function mbmOptionsFromArrays($var = array(0=>'',1=>''),$selected_value=NULL){
	
	$buf = '';
	
	if(is_array($var)){
		foreach($var as $k=>$v){
			$buf .= '<option value="'.$k.'" ';
			if($selected_value == $k && $selected_value != NULL){
				$buf .= 'selected';
			}
			$buf .= '>'.$v.'</option>';
		}
		return $buf;
	}else{	
		return '';
	}
}

/*
* array sortloh
* id gedeg n key buguud tuugeer sortlono
*/
function mbmSortArray($array, $id="id", $sort_ascending=true) {
	$temp_array = array();
	while(count($array)>0) {
		$lowest_id = 0;
		$index=0;
		foreach ($array as $item) {
			if (isset($item[$id])) {
								if ($array[$lowest_id][$id]) {
				if ($item[$id]<$array[$lowest_id][$id]) {
					$lowest_id = $index;
				}
				}
							}
			$index++;
		}
		$temp_array[] = $array[$lowest_id];
		$array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
	}
			if ($sort_ascending) {
		return $temp_array;
			} else {
				return array_reverse($temp_array);
			}
}
?>