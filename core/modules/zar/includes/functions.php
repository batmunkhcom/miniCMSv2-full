<?

function mbmZarCatsDropDownForUser($user_id=0){
	global $DB2;
	static $buf = '';
	
	if($is_public != 1) $is_public = 0;
	
	$q = "SELECT * FROM ".$DB2->prefix."zar_cats WHERE st='1' AND is_public='0' ";
	$q .= " AND id IN (SELECT cat_id FROM ".$DB2->prefix."zar_admins WHERE user_id='".$user_id."') ";
	$q .= "ORDER BY id ASC";
	$r = $DB2->mbm_query($q);
	
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		$buf .= '<option value="'.$DB2->mbm_result($r,$i,"id").'" ';
		$buf .= '>'.$DB2->mbm_result($r,$i,"name").'</option>';
	}
	
	return $buf;
}

function mbmZarPublicCatsDropDownForUser(){
	global $DB2;
	static $buf = '';
		
	$q = "SELECT * FROM ".$DB2->prefix."zar_cats WHERE st='1' AND is_public='1' ";
	$q .= "ORDER BY id ASC";
	$r = $DB2->mbm_query($q);
	
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		$buf .= '<option value="'.$DB2->mbm_result($r,$i,"id").'" ';
		$buf .= '>'.$DB2->mbm_result($r,$i,"name").'</option>';
	}
	return $buf;
}
function mbmZarTypesDropDownForUser(){
	global $DB2;
	static $buf = '';
	
	$q = "SELECT * FROM ".$DB2->prefix."zar_types ORDER BY id ASC";
	$r = $DB2->mbm_query($q);
	
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		$buf .= '<option value="'.$DB2->mbm_result($r,$i,"id").'" ';
		$buf .= '>'.$DB2->mbm_result($r,$i,"name").'</option>';
	}
	return $buf;
}
function mbmZarCheckUserCats($user_id=0){
	global $DB2;
	
	$q = "SELECT COUNT(id) FROM ".$DB2->prefix."zar_admins WHERE user_id='".$user_id."'";
	$q1 = "SELECT COUNT(id) FROM ".$DB2->prefix."zar_cats WHERE is_public='1'";
	$r = $DB2->mbm_query($q);
	$r1 = $DB2->mbm_query($q1);
	if(($DB2->mbm_result($r,0)+$DB2->mbm_result($r1,0)) == 0){
		return 0;
	}else{
		return 1;
	}
}
function mbmZarList($var=array(
							   'user_id'=>0,
							   'cat_ids'=>'',
							   'st'=>1,
							   'zar_type_id'=>0,
							   'phone'=>'',
							   'order_by'=>'date_added',
							   'asc'=>'desc',
							   'limit'=>10,
							   'per_page'=>10
							   )){
	global $DB2,$lang;
	
	if($var['st'] == 2) {
		$st = "id!=0 ";
	}else{
		$st = "st='".$var['st']."' ";
	}
	
	$q = "SELECT * FROM ".$DB2->prefix."zar_contents WHERE ".$st." ";
	if(is_array($var['cat_ids'])){
		$cats = "AND (";
		foreach($var['cat_ids'] as $k=>$v){
			$cats .= "cat_ids LIKE '%,".$k.",%' OR ";
		}
		$q .= rtrim($cats," OR ")." ) ";
	}elseif($var['cat_ids']!=0 && $var['cat_ids']!=''){
		$q .= "AND cat_ids LIKE '%,".$var['cat_ids'].",%'";
	}
	if($var['zar_type_id']!=0){
		$q .= "AND zar_type_id='".$var['zar_type_id']."' ";
	}
	if($var['phone']!=''){
		$q .= "AND phone LIKE '%".$var['phone']."%' ";
	}
	if($var['user_id']!=0 && isset($var['user_id'])){
		$q .= "AND user_id = '".$var['user_id']."' ";
	}
	$q .= "ORDER BY ".$var['order_by']." ".$var['asc']." ";
	if($var['limit']>0) {$q .= "LIMIT ".$var['limit']."";}
	
	$r = $DB2->mbm_query($q);
	
	$buf = '<div id="zaruud">';
	if((START+$var['per_page']) > $DB2->mbm_num_rows($r)){
		$end= $DB2->mbm_num_rows($r);
	}else{
		$end= START+$var['per_page']; 
	}
	for($i=START;$i<$end;$i++){
	//for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		$buf .= '<div class="zarItem" ';
			if($DB2->mbm_result($r,$i,"user_id") == $_SESSION['user_id'] || $_SESSION['lev']==5){
				$buf .= ' onmouseover="$(\'#zarPrivateCommand'.$DB2->mbm_result($r,$i,"id").'\').css(\'display\',\'block\')" onmouseout="$(\'#zarPrivateCommand'.$DB2->mbm_result($r,$i,"id").'\').css(\'display\',\'none\')"';
			}
		$buf .= ' id="zarItem'.$DB2->mbm_result($r,$i,"id").'">';
			$buf .= '<span class="zarDateAdded">'/*.$lang['main']['date_added'].': '*/;
			$buf .= date("Y/m/d",$DB2->mbm_result($r,$i,"date_added")).'</span>'; 
			$buf .= '<span class="zarCategoryName">'.($i+1).'. '
					.'<a href="'.DOMAIN.DIR.'index.php?module=zar&cmd=list&zCat_id='.mbmZarReturnCatId($DB2->mbm_result($r,$i,"cat_ids")).'">'
						.mbmZarReturnCatName($DB2->mbm_result($r,$i,"cat_ids"))
					.'</a> &raquo; '
					.'<a href="'.DOMAIN.DIR.'index.php?module=zar&cmd=list&zType_id='.($DB2->mbm_result($r,$i,"zar_type_id")).'">'
					.$DB2->mbm_get_field($DB2->mbm_result($r,$i,"zar_type_id"),'id','name','zar_types')
					.'</a>  '
					.'</span>'; 
			$buf .= '<br clear="all" />';
			$buf .= '<div class="zarPrivateCommand" id="zarPrivateCommand'.$DB2->mbm_result($r,$i,"id").'" ><img src="'.DOMAIN.DIR.'mbm_admin/images/icons/status_0.png" border="0" style="cursor:pointer" alt="'.$lang['main']['delete'].'" title="'.$lang['main']['delete'].'" onclick="mbmZarDelete('.$DB2->mbm_result($r,$i,"id").')" /></div>';
			$buf .= $DB2->mbm_result($r,$i,"content");
		$buf .= '<br clear="all" /><br />';
		$buf .= $lang["zar"]['zar_code'].': '.$DB2->mbm_result($r,$i,"id").' <br />';
		$buf .= ''.$lang['zar']['phone'].': '.$DB2->mbm_result($r,$i,"phone").'<br />';
		if($DB2->mbm_result($r,$i,"user_id") == $_SESSION['user_id'] && strlen($DB2->mbm_result($r,$i,"phone1"))>3){
			$buf .= ''.$lang['zar']['phone_admin'].': '.$DB2->mbm_result($r,$i,"phone1").'';
		}
		$buf .= '</div>';
	}
	
	$buf .= '</div>';
	
	$qquery_extend = '';
	if($var['cat_ids'] !=0 && !is_array($var['cat_ids'])){
		$qquery_extend .= '&zCat_id='.$var['cat_ids'];
	}
	if($var['zar_type_id'] !=0 ){
		$qquery_extend .= '&zType_id='.$var['zar_type_id'];
	}
	
	$buf .= mbmNextPrev(''.DOMAIN.DIR.'index.php?module=zar&cmd=list&'.$qquery_extend.$query_string,$DB2->mbm_num_rows($r),START,$var['per_page']);
	
	return $buf;
}
function mbmZarReturnCatId($cat_ids=0){
	$cat_ids = substr($cat_ids,1);
	$cat_id = explode(",",$cat_ids);

	if(count($cat_id)==2){
		return $cat_id[0];
	}else{
		return $cat_id[rand(0,(count($cat_id)-1))];
	}
}
function mbmZarReturnCatName($cat_ids=0){
	global $DB2;
	
	$cat_id = mbmZarReturnCatId($cat_ids);	
	return $DB2->mbm_get_field($cat_id,'id','name','zar_cats');
}
function mbmZarTypesShow($var=array(
									'user_id'=>0,
									'order_by'=>'name',
									'asc'=>'asc',
									'div_id'=>'zarTypesList'
									)){
	global $DB2;
	
	$q = "SELECT * FROM ".$DB2->prefix."zar_types WHERE id!=0 ";
	if(isset($var['user_id']) && $var['user_id']>0){
		$q .= "AND user_id='".$var['user_id']."' ";
	}
	$q .= "ORDER BY ".$var['order_by']." ".$var['asc']." ";
	if(isset($var['limit']) && $var['limit']>0){
		$q .= "LIMIT ".$var['limit'];
	}
	
	$r = $DB2->mbm_query($q);
	
	$buf = '<div id="'.$var['div_id'].'">';
	for($i=0;$i<$DB2->mbm_num_rows($r);$i++){
		$buf .= '<a href="'.DOMAIN.DIR.'index.php?module=zar&cmd=list&zType_id='.$DB2->mbm_result($r,$i,"id").'">';
			$buf .= $DB2->mbm_result($r,$i,"name");
		$buf .= '</a>';
	}
	$buf .= '</div>';
	return $buf;
}
function mbmZarGenerateCode(){
	global $DB2;
	
	$code = md5(rand(1,99999999999));
}
?>