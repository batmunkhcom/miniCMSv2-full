<?
$tddddddddddddd = time();
//include zamiig todorhoilj uguh
ini_set('include_path',ABS_DIR . INCLUDE_DIR);
set_time_limit(0);
define("PREFIX",$config['db_prefix']);
$security_key = md5('mbm');

// session eheleh

session_start();
if(isset($_GET['azSid'])){
	header("Location: ".DOMAIN.DIR);
}
//session asuudal duusah
	
	function mbm_include($dir,$ext)
	{

		$d = dir(ABS_DIR.$dir);
		
		while (false !== ($entry = $d->read())) {
		  
		  switch(strtolower($ext)){
		  	case 'php':
				if(substr($entry,-3)=='php'){
						include_once(ABS_DIR.$dir.'/'.$entry);
				  }
			break;
		  	case 'txt':
				if(substr($entry,-3)=='txt'){
						include_once(ABS_DIR.$dir.'/'.$entry);
				  }
			break;
			case 'css':
			  if(substr($entry,-3)=='css'){
					//echo '<link href="'.DOMAIN.DIR.$dir.'/'.$entry.'" rel="stylesheet" type="text/css" />'."\n";
					$css_files .= '@import url("'.DOMAIN.DIR.$dir.'/'.$entry.'");'."\n";
			  }
			break;
			case 'js':
			  if(substr($entry,-2)=='js'){
			  	echo '<script  src="'.INCLUDE_DOMAIN.str_replace(INCLUDE_DIR,"",$dir).'/'.$entry.'" language="Javascript" type="text/javascript"></script>'."\n";
			  /*
					echo '<script language="javascript" type="text/javascript" >'."\n";
					echo "<!--\n";
					//echo "//".$dir.'/'.$entry." file eheljiinadaa..\n";
					$lines = file(ABS_DIR.$dir.'/'.$entry);
					foreach ($lines as $line_num => $line) {
					   echo $line;
					}
					echo '//-->';
					echo '</script>'."\n";
			  */
			  }
			break;
			case 'php_js':
			  if(substr($entry,-3)=='php'){
			  	echo '<script  src="'.INCLUDE_DOMAIN.str_replace(INCLUDE_DIR,"",$dir).'/'.$entry.'" language="Javascript" type="text/javascript"></script>'."\n";
			  }
			break;
			case 'js_template':
			  if(substr($entry,-2)=='js'){
			  	echo '<script  src="'.DOMAIN.DIR.$dir.'/'.$entry.'" language="Javascript" type="text/javascript"></script>'."\n";
			  /*
					echo '<script language="javascript" type="text/javascript" >'."\n";
					echo "<!--\n";
					//echo "//".$dir.'/'.$entry." file eheljiinadaa..\n";
					$lines = file(ABS_DIR.$dir.'/'.$entry);
					foreach ($lines as $line_num => $line) {
					   echo $line;
					}
					echo '//-->';
					echo '</script>'."\n";
			  */
			  }
			break;
		  }
		}
		$d->close();
		if($ext == 'css'){
			echo "\n".'<style type="text/css">'."\n";
				echo $css_files;
			echo '</style>'."\n";
		}
	}
	
	function mbm_test($d){
		echo '<table cellspacing="2" cellpadding="5" 
				style="border: 1px solid #FF0000;
				margin-bottom:6px;
				float:right;">';
			echo '<tr><td align="center" 
						style="font-weight:bold;background-color:#FF0000;color:#FFFFFF;">';
				echo 'Keys';
			echo '</td><td align="center" 
						style="font-weight:bold;background-color:#FF0000;color:#FFFFFF;">';
				echo 'Values';
			echo '</td></tr>';
		foreach($d as $k=>$v){
			echo '<tr><td align="right" bgcolor="#EEEEEE">';
			echo '<strong>'.$k.'</strong>';
			echo '</td><td bgcolor="#F5F5F5">';
			echo $v;
			echo '</td></tr>';
		}
		echo '</table>';
	}
	function mbm_test2($d){
		echo '<table cellspacing="2" cellpadding="5" 
				style="border: 1px solid #FF0000;
				margin-bottom:6px;
				margin-right:2px;
				float:right;">';
			echo '<tr><td align="center" 
						style="font-weight:bold;background-color:#FF0000;color:#FFFFFF;">';
				echo 'Keys';
			echo '</td><td align="center" 
						style="font-weight:bold;background-color:#FF0000;color:#FFFFFF;">';
				echo 'Values';
			echo '</td></tr>';
		foreach($d as $k=>$v){
				echo '<tr style="color:#FFFFFF"><td bgcolor="#175796" colspan="2">';
				echo '<strong>'.$k.'</strong>';
				echo '</td></tr>';
				foreach($d[$k] as $kk=>$vv){
					echo '<tr><td align="right" bgcolor="#EEEEEE">';
					echo '<strong>'.$kk.'</strong>';
					echo '</td><td bgcolor="#F5F5F5">';
					echo $vv;
					echo '</td></tr>';
				}
		}
		echo '</table>';
	}
	
	function mbm_result($txt=''){
		if(strlen($txt)>3){
			return '<div id="query_result">'.$txt.'</div>';
		}else{
			return '';
		}
	}
	function mbm_get_included_file(){
		$included_files = get_included_files();
		$buf = '';		
		foreach ($included_files as $filename) {
		   $buf .= "$filename<br />";
		}
		return $buf;
	}
	
?>