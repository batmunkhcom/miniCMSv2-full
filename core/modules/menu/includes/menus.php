<?

function mbmReturnMenuNames($menu_ids=','){

	global $DB;

	

	$menus = explode(",",rtrim($menu_ids,","));

	

	$buf = '';

	$i=0;

	foreach($menus as $k=>$v){

		if($i>0){

			$buf .= $DB->mbm_get_field($v,'id','name','menus').', ';

		}

		$i++;

	}

	return rtrim($buf,", ");

}



//content-d zoriulav

function mbmReturnMenuId($menu_ids=','){

	

	$ids = explode(",",rtrim($menu_ids,','));	

	$arrays = count($ids);

	

	return $ids[rand(1,($arrays-1))];

}



function mbmMenuRec($m_id){

	global $DB, $Mas;

	

	if($m_id !=0){

		$q = "SELECT * FROM ".PREFIX."menus WHERE st=1 AND lang='".$_SESSION['ln']." '

			 AND lev<=".$_SESSION['lev']." AND id='".$m_id."'";

		$r = $DB->mbm_query($q);

		$Mas[$DB->mbm_result($r,0,"id")]= 1;

		mbmMenuRec($DB->mbm_result($r,$i,"menu_id"));

	}

}



function mbmMenuDesc($mid, $m_id){

	global $DB, $Mas;



	for($i=0; $i<9999; $i++){

		$Mas[$i]= 0;

	}

	$mm = $DB->mbm_get_field($m_id,"id","menu_id", "menus");

	$q = "SELECT * FROM ".PREFIX."menus WHERE st=1 AND lang='".$_SESSION['ln']." '

			AND lev<=".$_SESSION['lev']." AND menu_id=0 OR menu_id='".$mm."' OR menu_id='".$m_id."' ORDER BY pos";

	$r = $DB->mbm_query($q);

	for($i=0;$i<$DB->mbm_num_rows($r);$i++){

		$Mas[$DB->mbm_result($r,$i,"id")]= 1;

	}

	mbmMenuRec($m_id);

}



function mbmShowMenu2($htmls,$mid,$m_id,$padding_left=15,$class='menu'){

	global $DB, $Mas, $buffer;

	$q_menu = "SELECT * FROM ".PREFIX."menus WHERE st=1 

				AND lang='".$_SESSION['ln']."'

				AND lev<=".$_SESSION['lev']." AND menu_id='".$mid."' ORDER BY pos";

	$r_menu = $DB->mbm_query($q_menu);

	if($DB->mbm_num_rows($r_menu) != 0){

		for($i=0;$i<$DB->mbm_num_rows($r_menu);$i++){

			if($Mas[$DB->mbm_result($r_menu,$i,"id")] == 1){

				$buf = $htmls[2];

				$buf .= '<span ';

				if($DB->mbm_result($r_menu,$i,"sub")!=0){

					$buf .= 'style="padding-left:'.($padding_left*$DB->mbm_result($r_menu,$i,"sub")).'px"';

				}

				$buf .= ' ><a href="';	

				if($DB->mbm_result($r_menu,$i,"link")=='http://'){

					$url='index.php?module=menu&amp;cmd=content&amp;menu_id='.$DB->mbm_result($r_menu,$i,"id")."&amp;start=0";

				}else{

					if(substr_count($DB->mbm_result($r_menu,$i,"link"),"?")>0){

						$d='&amp;';

					}else{

						$d='?';

					}

					$url = 'index.php?redirect='.base64_encode($DB->mbm_result($r_menu,$i,"link"));//.$d."mid=".$DB->mbm_result($r_menu,$i,"id"));

				}	

				$buf .= $url.'" title="';

				if($DB->mbm_result($r_menu,$i,"comment")==''){

					$buf .= $DB->mbm_result($r_menu,$i,"name");

				}else{

					$buf .= $DB->mbm_result($r_menu,$i,"comment");

				}

				$buf .= '" class="menupriavte'.$DB->mbm_result($r_menu,$i,"id").' ';

				if($_GET['menu_id']==$DB->mbm_result($r_menu,$i,"id")){

					$buf .= 'menu_selected';

				}else{

					$buf .= $class.$DB->mbm_result($r_menu,$i,"sub");

				}

				$buf .= '" target="'.$DB->mbm_result($r_menu,$i,"target").'">';

				$buf .= $DB->mbm_result($r_menu,$i,"name");

				$buf .= '</a>';

				$buf .= mbmShowNewContentNotify(array('menu_id'=>$DB->mbm_result($r_menu,$i,"id")));

				$buf .= '</span>';

				$buf .=$htmls[3];

				$buffer .= $buf;

				mbmShowMenu2($htmls, $DB->mbm_result($r_menu,$i,"id"),$m_id,$padding_left, 'menu');

			}

		}

	}

	return true;

}



function mbmShowMenu($htmls,$menu_id,$m_id,$padding_left=15,$class='menu'){

	

	global $buffer;

	if($htmls[0]){

		$buffer = $htmls[0];

	}

	

	

	mbmMenuDesc($menu_id, $m_id);

	mbmShowMenu2($htmls,$menu_id,$m_id,$padding_left,'menu');

	

	if($htmls[1]){

		$buffer .= $htmls[1];

	}

	return $buffer;

}



function mbmShowMenuById($htmls,$mid,$class='menu',$show_total_contents=0,$show_submenus=0){
	global $DB;
	$buf = '';
	$q_menu = "SELECT * FROM ".PREFIX."menus WHERE st=1 AND lev<=".$_SESSION['lev']." AND lang='".$_SESSION['ln']."' AND menu_id='".$mid."' ORDER BY pos";
	$r_menu = $DB->mbm_query($q_menu);
	if($DB->mbm_num_rows($r_menu) != 0){
		for($i=0;$i<$DB->mbm_num_rows($r_menu);$i++){
			$buf .= $htmls[0];
			$buf .= '<a href="';
			$buf .= mbmMenuLink($DB->mbm_result($r_menu,$i,"id"),$DB->mbm_result($r_menu,$i,"link"));
			$buf .= '" title="';
			if($DB->mbm_result($r_menu,$i,"comment")==''){
				$buf .= addslashes($DB->mbm_result($r_menu,$i,"name"));
			}else{
				$buf .= addslashes($DB->mbm_result($r_menu,$i,"comment"));
			}
			$buf .= '" class="menupriavte'.$DB->mbm_result($r_menu,$i,"id").' '.$class.'" target="'.$DB->mbm_result($r_menu,$i,"target").'">';
			$buf .= $DB->mbm_result($r_menu,$i,"name");
			$buf .= mbmShowNewContentNotify(array('menu_id'=>$DB->mbm_result($r_menu,$i,"id")));
			if($show_total_contents==1){
				$buf .= ' <span class="tCon">('.mbmMenuTotalContents(array('menu_id'=>$DB->mbm_result($r_menu,$i,"id"))).')</span>';
			}
			$buf .= '</a>';
			if($show_submenus == 1){
				$buf .= mbmShowMenuById($htmls,$DB->mbm_result($r_menu,$i,"id"),$class.' subM',$show_total_contents,$show_submenus);
			}
			$buf .=$htmls[1];
		}
	}
	return $buf;
}

function mbmGetUpperMenuId($menu_id=0){

	global $DB;

	

	$upper_menu_id = $DB->mbm_get_field($menu_id,'id','menu_id','menus');

	if($DB->mbm_check_field('id',$menu_id,'menus')==0){

		$return_id = 0;

	}elseif($upper_menu_id == 0){

		$return_id = $menu_id;

	}else{

		$return_id = mbmGetUpperMenuId($upper_menu_id);

	}

	return $return_id;

}

function mbmMenuLink($menu_id=0,$link='http://'){

	if($link=='http://'){

		$url='index.php?module=menu&amp;cmd=content&amp;menu_id='.$menu_id;

	}else{

		if(substr_count($link,"?")>0){

			$d='&amp;';

		}else{

			$d='?';

		}

		$url = 'index.php?redirect='.base64_encode($link).'&amp;menu_id='.$menu_id;//.$d."mid=".$DB->mbm_result($r_menu,$i,"id"));

	}

	if($link=='#'){

		$url = $url.'" onclick="return false;';

	}

	return $url;

}



function mbmMenuBuildPath($menu_code){

	global $DB,$lang;

	static $sss='';

	$sss .= $menu_code.',';

	

	$upper_code = $DB->mbm_get_field($menu_code,"id","menu_id","menus");

	

	if($upper_code!='0'){

		mbmMenuBuildPath($upper_code);

	}elseif(!isset($_GET['menu_id'])){

		return $lang['main']['home'];

	}

	$sss=rtrim($sss,",");

	$menu_codes = explode(",",$sss);

	

	if(is_array($menu_codes)){

		$menu_codes = array_reverse($menu_codes);

		foreach($menu_codes as $k =>$v){

			if($v!=0){

				$result .= '<a href="'.mbmMenuLink($v,$DB->mbm_get_field($v,"id","link","menus")).'" class="menuPath" title="'.$DB->mbm_get_field($v,"id","comment","menus").'">';

				$result .= $DB->mbm_get_field($v,"id","name","menus").'</a> &raquo; ';

			}

		}

	}else{

		$result = $menu_codes;

	}

	return '<a href="index.php" title="'.$lang['main']['home'].'" class="menuPath">'.$lang['main']['home'].'</a> &raquo; '.rtrim($result," &raquo; ");

}



function mbmMenuDropDownV($var = array('menu_id'=>0)){

	global $DB;

		

	$buf = '<div class="suckerdiv">'."\n";

	$buf .= mbmMenuDropDownV_submenus(

									array(

										'menu_id'=>$var['menu_id'],

										'class'=>$var['class']

										)

								  );

	$buf .= '</div>';

	

	return $buf;

}

function mbmMenuDropDownV_submenus($var = array('menu_id'=>0)){

	global $DB;

	static $b = 0;

	

	$q = "SELECT * FROM ".PREFIX."menus WHERE menu_id='".$var['menu_id']."'  

		  AND st=1 

		  AND lev<='".$_SESSION['lev']."' 

		  AND lang='".$_SESSION['ln']."' 

		  ORDER BY pos";

	$r = $DB->mbm_query($q);

	

	$buf = '<ul ';

		if($b==0){

			$buf .= 'id="suckertree1"';

		}

	$buf .= '>'."\n\t";

	for($i=0;$i<$DB->mbm_num_rows($r);$i++){

		$buf .= '<li>'."\n\t\t";

			$q_checksubmenu = "SELECT COUNT(id) FROM ".PREFIX."menus WHERE st=1 AND menu_id='".$DB->mbm_result($r,$i,"id")."' LIMIT 1";

			$r_checksubmenu = $DB->mbm_query($q_checksubmenu);

			if($DB->mbm_result($r_checksubmenu,0)>0){

				$buf .= '<a href="#" onclick="return false;" class="menupriavte'.$DB->mbm_result($r_menu,$i,"id").' '.$var['class'].$DB->mbm_result($r,$i,"sub").'">';

					$buf .= $DB->mbm_result($r,$i,"name");

				$buf .= '</a>';

				

				$buf .= mbmMenuDropDownV_submenus(

													array(

														'menu_id'=>$DB->mbm_result($r,$i,"id"),

														'class'=>$var['class']

														)

												  );

			}else{

				$buf .= '<a href="';

				$buf .= mbmMenuLink($DB->mbm_result($r,$i,"id"),$DB->mbm_result($r,$i,"link"));

				$buf .= '" title="';

				if($DB->mbm_result($r,$i,"comment")==''){

					$buf .= addslashes($DB->mbm_result($r,$i,"name"));

				}else{

					$buf .= addslashes($DB->mbm_result($r,$i,"comment"));

				}

				$buf .= '" target = "'.$DB->mbm_result($r,$i,"target").'';

				$buf .= '" class="menupriavte'.$DB->mbm_result($r_menu,$i,"id").' '.$var['class'].$DB->mbm_result($r,$i,"sub").'">';

					$buf .= $DB->mbm_result($r,$i,"name");

				$buf .= '</a>';

			}

		$buf .= '</li>'."\n";

	}

	$buf .= '</ul>'."\n";

	if($DB->mbm_num_rows($r)==0){

		$buf = '';

	}

	$b ++;

	return $buf;

}



function mbmMenuListById($var = array(

									'menu_id'=>0,

									'lev'=>0,

									'st'=>1

									)){

	global $DB,$DB2;

	$buf = '<div id="menuListById">';

		$buf .= mbmMenuListByIdLi($var);

	$buf .= '</div>';

	return $buf;

	

}

function mbmMenuListByIdLi($var = array(

									'menu_id'=>0,

									'lev'=>0,

									'st'=>1,

									'notify_new_contents'=>0,

									'show_total_contents'=>0,

									'mainCatClass'=>'',

									'subCatClass'=>''

									)){

	global $DB,$DB2;

	static $kkkkk=0;

	

	$q = "SELECT * FROM ".PREFIX."menus WHERE ";

	$q .= "st='".$var['st']."' ";

	$q .= "AND lev<='".$var['lev']."' ";

	if(!isset($var['menu_id'])){

		$var['menu_id'] = 0;

	}

		$q .= "AND menu_id='".$var['menu_id']."' ";

	$q .= "ORDER BY pos ASC";

	

	$r = $DB->mbm_query($q);

	

	for($i=0;$i<$DB->mbm_num_rows($r);$i++){

		$kkkkk++;

		

		$buf .= '<li>';

		$buf .= '<a href="'.mbmMenuLink($DB->mbm_result($r,$i,"id"),$DB->mbm_result($r,$i,"link")).'" title="'.addslashes($DB->mbm_result($r,$i,"comment")).'"';

		if($DB->mbm_check_field('menu_id',$DB->mbm_result($r,$i,"id"),'menus')==1){

			$buf .= 'onclick="return false;" class="'.$var['mainCatClass'].'"';

		}else{

			$buf .= 'class="'.$var['subCatClass'].'"';

		}

		$buf .= '>';

				$buf .= $DB->mbm_result($r,$i,"name");

			$buf .= mbmShowNewContentNotify(array('menu_id'=>$DB->mbm_result($r,$i,"id")));

			if($var['show_total_contents']==1){

				$buf .= ' <span class="tCon">('.mbmMenuTotalContents(array('menu_id'=>$DB->mbm_result($r,$i,"id"))).')</span>';

			}

			$buf .= '</a>';

		$buf .= '</li>';

			$upper_mid = $DB->mbm_check_field('menu_id',$DB->mbm_result($r,$i,"id"),'menus');

			if($upper_mid ==1 && $upper_mid!=$DB->mbm_result($r,$i,"id")){

				$buf .= mbmMenuListByIdLi(array(

									'menu_id'=>$DB->mbm_result($r,$i,"id"),

									'lev'=>$DB->mbm_result($r,$i,"lev"),

									'st'=>$DB->mbm_result($r,$i,"st")

									));

			}

	}

	$buf_1 .= '<ul ';

	if($kkkkk==0) $buf_1 .= ' id="ddsubmenu1" class="ddsubmenustyle"';

	$buf_1 .= '>';

	$buf = $buf_1.$buf.'</ul>';

	return $buf;

}

function mbmNewContentCheckByMenuId($var = array('menu_id'=>0)){

	global $DB;

	if(defined("NEW_CONTENTS_PERIOD")){

		$new_contents = NEW_CONTENTS_PERIOD;

	}else{

		$new_contents = (24*3600);

	}

	$q = "SELECT COUNT(id) FROM ".PREFIX."menu_contents WHERE menu_id LIKE '%,".$var['menu_id'].",%' AND date_added>'".(mbmTime()-$new_contents)."' AND date_added<'".mbmTime()."'";

	$r = $DB->mbm_query($q);

	//return $DB->mbm_result($r,0).'-'.$q;

	return $DB->mbm_result($r,0);

}

function mbmMenuTotalContents($var = array('menu_id'=>0)){

	global $DB;

	$q = "SELECT COUNT(id) FROM ".PREFIX."menu_contents WHERE menu_id LIKE '%,".$var['menu_id'].",%' AND date_added<'".mbmTime()."'";

	$r = $DB->mbm_query($q);

	

	return $DB->mbm_result($r,0);

}

function mbmSubmenusInArray($menu_id=0,$include_itself=0){

	global $DB;

	$q = "SELECT id,name FROM ".PREFIX."menus WHERE menu_id='".$menu_id."' AND st='1' ORDER BY pos";

	$r = $DB->mbm_query($q);

	

	$menu_ids = array();

	

	for($i=0;$i<$DB->mbm_num_rows($r);$i++){

		$menu_ids[$DB->mbm_result($r,$i,"id")] = $DB->mbm_result($r,$i,"name");

	}

	if($include_itself ==1 ){

		$menu_ids[$menu_id] = $DB->mbm_get_field($menu_id,'id','name','menus');

	}

	

	return $menu_ids;

}

function mbmShowNewContentNotify($var = array(

											  'menu_id'=>0

											  )){

	global $DB,$lang;

	$total_new_contents = mbmNewContentCheckByMenuId(array('menu_id'=>$var['menu_id']));

	if($total_new_contents>0){

		$buf .= '<sup class="supNew">'.$lang['main']['new'].' ('.$total_new_contents.')</sup>';

		return $buf;

	}else{

		return '';

	}

}

?>