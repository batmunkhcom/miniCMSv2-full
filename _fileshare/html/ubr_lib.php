<?php
//******************************************************************************************************
//	Name: ubr_lib.php
//	Revision: 2.0
//	Date: 8:17 PM Thursday, August 28, 2008
//	Link: http://uber-uploader.sourceforge.net
//	Developer: Peter Schmandra
//	Description: Library used by Uber-Uploader
//
//	BEGIN LICENSE BLOCK
//	The contents of this file are subject to the Mozilla Public License
//	Version 1.1 (the "License"); you may not use this file except in
//	compliance with the License. You may obtain a copy of the License
//	at http://www.mozilla.org/MPL/
//
//	Software distributed under the License is distributed on an "AS IS"
//	basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See
//	the License for the specific language governing rights and
//	limitations under the License.
//
//	Alternatively, the contents of this file may be used under the
//	terms of either the GNU General Public License Version 2 or later
//	(the "GPL"), or the GNU Lesser General Public License Version 2.1
//	or later (the "LGPL"), in which case the provisions of the GPL or
//	the LGPL are applicable instead of those above. If you wish to
//	allow use of your version of this file only under the terms of
//	either the GPL or the LGPL, and not to allow others to use your
//	version of this file under the terms of the MPL, indicate your
//	decision by deleting the provisions above and replace them with the
//	notice and other provisions required by the GPL or the LGPL. If you
//	do not delete the provisions above, a recipient may use your
//	version of this file under the terms of any one of the MPL, the GPL
//	or the LGPL.
//	END LICENSE BLOCK
//***************************************************************************************************************

// Output a message to screen and exit
function kak($msg, $exit_ubr, $line, $path_to_css_file='images/ubr.css'){
	print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
	print "<html>\n";
	print "		<head>\n";
	print "			<title>Файл хуулагч</title>\n";
	print "			<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n";
	print "			<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
	print "			<meta http-equiv=\"cache-control\" content=\"no-cache\">\n";
	print "			<meta http-equiv=\"expires\" content=\"-1\">\n";
	print "			<meta name=\"robots\" content=\"none\">\n";
	print "			<link rel=\"stylesheet\" type=\"text/css\" href=\"$path_to_css_file\">\n";
	print "		</head>\n";
	print "		<body class=\"ubrBody\">\n";
	print "			<div align='center'>\n";
	print "				<br>\n";
	print "				$msg\n";
	print "				<br>\n";
	print "				<!-- kak on line $line -->\n";
	print "			</div>\n";
	print "		</body>\n";
	print "</html>\n";

	if($exit_ubr){ exit; }
}

// Read a file
function readUberFile($file, $debug_ajax=0){
	if(is_file($file)){
		if(is_readable($file)){
			$file_contents = '';

			if(function_exists('file_get_contents')){
				if($file_contents = file_get_contents($file)){ return $file_contents; }
				else{
					if($debug_ajax){ showDebugMessage("Файлын мэдээллийг уншихад алдаа гарлаа:" . $file); }
					return false;
				}
			}
			else{
				if(($fh = fopen($file, "rb")) !== false){
					if($file_contents = fread($fh, @filesize($file))){
						@fclose($fh);
						return $file_contents;
					}
					else{
						if($debug_ajax){ showDebugMessage("Файлыг уншихад алдаа гарлаа:" . $file); }
						return false;
					}
				}
				else{
					if($debug_ajax){ showDebugMessage("Файлыг нээхэд алдаа гарлаа:" . $file); }
					return false;
				}
			}
		}
		else{
			if($debug_ajax){ showDebugMessage("Файлыг уншихад алдаа гарлаа:" . $file); }
			return false;
		}
	}
	else{
		if($debug_ajax){ showDebugMessage("Файл олдсонгүй:" . $file); }
		return false;
	}
}

function showAlertMessage($message, $exit_ubr){
	echo "if(typeof showAlertMessage == 'function'){ showAlertMessage(" . '"' . $message . '"' . "); }";

	if($exit_ubr){ exit(); }
}

#Generate a 32 character string
function generateUploadID(){ return md5(uniqid(mt_rand(), true)); }

# Javascript function wrappers
function showDebugMessage($message){ echo "if(typeof showDebugMessage == 'function'){ showDebugMessage(" . '"' . $message . '"' . "); }"; }
function stopUpload(){ echo "if(typeof stopUpload == 'function'){ stopUpload(); }"; }
function startUpload($upload_id, $debug_upload){ echo "if(typeof startUpload == 'function'){ startUpload(" . '"' . $upload_id . '",' . $debug_upload . "); }"; }
function startProgressBar($upload_id, $total_upload_size, $start_time){ echo "if(typeof startProgressBar == 'function'){ startProgressBar(" . '"' . $upload_id . '","' . $total_upload_size . '","' . $start_time . '"' . "); }"; }
function setProgressStatus($total_bytes_read, $files_uploaded, $current_filename, $bytes_read, $lapsed_time){ echo "if(typeof setProgressStatus == 'function'){ setProgressStatus(" . $total_bytes_read . "," . $files_uploaded . ",'" . $current_filename . "'," . $bytes_read . "," . $lapsed_time . "); }"; }
function stopDataLoop(){ echo "if(typeof stopDataLoop == 'function'){ stopDataLoop(); }"; }
function hideProgressBar(){ echo "if(typeof hideProgressBar == 'function'){ hideProgressBar(); }"; }
function getProgressStatus($get_status_speed){ echo "if(typeof getProgressStatus == 'function'){ setTimeout('getProgressStatus()', $get_status_speed); }"; }

////////////////////////////////////////////////////////////////////////////////
// Output array to screen (debug, debug_var, next_div, debug_colorize_string)
// Contributor: http://www.php.net/manual/en/function.print-r.php
////////////////////////////////////////////////////////////////////////////////
function debug($name, $data){
	ob_start();
	print_r($data);
	$str = ob_get_contents();
	ob_end_clean();
	debug_var($name, $str);
}

function debug_var($name, $data){
	$captured = preg_split("/\r?\n/", $data);

	print "<script>function toggleDiv(num){var span = document.getElementById('d'+num);var a = document.getElementById('a'+num);var cur = span.style.display;if(cur == 'none'){a.innerHTML = '-';span.style.display = 'inline';}else{a.innerHTML = '+';span.style.display = 'none';}}</script>";
	print "<b>$name</b>\n";
	print "<pre>\n";

	foreach($captured as $line){ print debug_colorize_string($line) . "\n"; }

	print "</pre>\n";
}

function next_div($matches){
	static $num = 0;
	++$num;
	return "$matches[1]<a id=a$num href=\"javascript: toggleDiv($num)\">+</a><span id=d$num style=\"display:none\">(";
}
function debug_colorize_string($string){
	$string = preg_replace("/\[(\w*)\]/i", '[<font color="red">$1</font>]', $string);
	$string = preg_replace_callback("/(\s+)\($/", 'next_div', $string);
	$string = preg_replace("/(\s+)\)$/", '$1)</span>', $string);
	$string = str_replace('Array', '<font color="blue">Array</font>', $string);
	$string = str_replace('=>', '<font color="#556F55">=></font>', $string);

	return $string;
}

?>