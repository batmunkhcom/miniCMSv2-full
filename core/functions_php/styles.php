<?
function mbmonMouse($onMouseOver_bgcolor,$onClick_bgcolor,$status_text)
{
	$a="onmouseout=\"this.style.backgroundColor='',window.status=''\" ";
	$a.="onclick=\"this.style.backgroundColor='".$onClick_bgcolor."'\" ";
	$a.="onmouseover=\"this.style.background='',this.style.backgroundColor='".$onMouseOver_bgcolor."',window.status='".$status_text."'\"";
	return $a;
}
function mbmShowSumImage($id=1){
	global $config;
	$idr = $config['domain'].$config['dir'];
	switch($id){
		case 1:
			$buf ='<img src="'.$dir.'templates/'.TEMPLATE.'/images/sum1.gif" hspace="3" style="float:left">';
		break;
		default:
		break;
	}	
	return $buf;
}
function mbmChangeElementBgColor($element_id,$new_color){
	$buf = '<script language="javascript" type="text/javascript">
			mbmChangeElementBgColor(\''.$element_id.'\',\''.$new_color.'\');
			</script>';
	return $buf;
}

function mbmChangeCSS($element_id,$new_classname){
	$buf = '<script language="javascript" type="text/javascript">
			mbmChangeCSS(\''.$element_id.'\',\''.$new_classname.'\');
			</script>';
	return $buf;
}
?>