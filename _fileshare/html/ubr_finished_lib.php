<?php
//******************************************************************************************************
//	Name: ubr_finished_lib.php
//	Revision: 2.5
//	Date: 11:26 AM Saturday, September 20, 2008
//	Link: http://uber-uploader.sourceforge.net
//	Developer: Peter Schmandra
//	Description: Library for uu_finished.php
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

//error_reporting(E_ALL);

/////////////////////////////////////////////////////////////////////////////
// Get/Set/Store uploaded file slot name, file name, file size and file type
/////////////////////////////////////////////////////////////////////////////
class FileInfo{
	var $slot = '';
	var $name = '';
	var $size = 0;
	var $type = '';

	function getFileInfo($key){
		if(strcasecmp($key, 'slot') == 0){ return $this->slot; }
		elseif(strcasecmp($key, 'name') == 0){ return $this->name; }
		elseif(strcasecmp($key, 'size') == 0){ return $this->size; }
		elseif(strcasecmp($key, 'type') == 0){ return $this->type; }
		else{ print "Error: Invalid get member $key value on FileInfo object<br>\n"; }
	}

	function setFileInfo($key, $value){
		if(strcasecmp($key, 'slot') == 0){ $this->slot = $value; }
		elseif(strcasecmp($key, 'name') == 0){ $this->name = $value; }
		elseif(strcasecmp($key, 'size') == 0){ $this->size = $value; }
		elseif(strcasecmp($key, 'type') == 0){ $this->type = $value; }
		else{ print "Error: Invalid set member $key value on FileInfo object<br>\n"; }
	}
}

/////////////////////////////////////////////////////////////////////
// XML Parser
// Contributor: http://www.php.net/manual/en/function.xml-parse.php
/////////////////////////////////////////////////////////////////////
class XML_Parser{
	var $XML_Parser;
	var $error_msg = '';
	var $delete_xml_file = 1;
	var $in_error = 0;
	var $xml_file = '';
	var $raw_xml_data = '';
	var $xml_post_data = '';
	var $xml_data = array();
	var $upload_id = '';

	function setXMLFileDelete($delete_xml_file){ $this->delete_xml_file = $delete_xml_file; }
	function setXMLFile($temp_dir, $upload_id){
		$this->xml_file = $temp_dir . $upload_id . ".redirect";
		$this->upload_id = $upload_id;
	}
	function getError(){ return $this->in_error; }
	function getErrorMsg(){ return $this->error_msg; }
	function getRawXMLData(){ return $this->raw_xml_data; }
	function getXMLData(){ return $this->xml_data; }

	function startHandler($parser, $name, $attribs){
		$_content = array('name' => $name);

		if(!empty($attribs)){ $_content['attrs'] = $attribs; }

		array_push($this->xml_data, $_content);
	}

	function dataHandler($parser, $data){
		if(count(trim($data))){
			$_data_idx = count($this->xml_data) - 1;

			if(!isset($this->xml_data[$_data_idx]['content'])){ $this->xml_data[$_data_idx]['content'] = ''; }

			$this->xml_data[$_data_idx]['content'] .= $data;
		}
	}

	function endHandler($parser, $name){
		if(count($this->xml_data) > 1){
			$_data = array_pop($this->xml_data);
			$_data_idx = count($this->xml_data) - 1;
			$this->xml_data[$_data_idx]['child'][] = $_data;
		}
	}

	function parseFeed(){
		// read the upload_id.redirect file
		if($this->xml_post_data = readUberFile($this->xml_file)){
			// store the raw xml file
			$this->raw_xml_data = $this->xml_post_data;

			// format the xml data into 1 long string
			$this->xml_post_data = preg_replace('/\>(\n|\r|\r\n| |\t)*\</','><', $this->xml_post_data);

			// create the xml parser
			$this->XML_Parser = xml_parser_create('');

			// set xml parser options
			xml_set_object($this->XML_Parser, $this);
			xml_parser_set_option($this->XML_Parser, XML_OPTION_CASE_FOLDING, false);
			xml_set_element_handler($this->XML_Parser, "startHandler", "endHandler");
			xml_set_character_data_handler($this->XML_Parser, "dataHandler");

			// parse upload_id.redirect file
			if(!xml_parse($this->XML_Parser, $this->xml_post_data)){
				$this->in_error = true;
				$this->error_msg = sprintf("<span class='ubrError'>XML ERROR</span>: %s at line %d", xml_error_string(xml_get_error_code($this->XML_Parser)), xml_get_current_line_number($this->XML_Parser));
			}

			xml_parser_free($this->XML_Parser);

			// delete upload_id.redirect file
			if($this->delete_xml_file){
				for($i = 0; $i < 3; $i++){
					if(@unlink($this->xml_file)){ break; }
					else{ sleep(1); }
				}
			}
		}
		else{
			$this->in_error = true;
			$this->error_msg = "<span class='ubrError'>Алдаа</span>:  " . $this->upload_id . ".redirect файлыг нээж чадсангүй";
		}
	}
}

/////////////////////////////////////////
// Parse config data out of the xml data
/////////////////////////////////////////
function getConfigData($_XML_DATA){
	$_config_data = array();
	$num_configs = count($_XML_DATA[0]['child'][0]['child']);

	//config data is assumed to be stored in $_XML_DATA[0]['child'][0]
	for($i = 0; $i < $num_configs; $i++){
		if(isset($_XML_DATA[0]['child'][0]['child'][$i]['name']) && isset($_XML_DATA[0]['child'][0]['child'][$i]['content'])){
			$key = $_XML_DATA[0]['child'][0]['child'][$i]['name'];
			$value = $_XML_DATA[0]['child'][0]['child'][$i]['content'];
			$_config_data[$key] = $value;
		}
	}

	return $_config_data;
}

/////////////////////////////////////////
// Parse post data out of the xml data
/////////////////////////////////////////
function getpostData($_XML_DATA){
	$_post_value = array();
	$_post_data = array();
	$num_posts = count($_XML_DATA[0]['child'][1]['child']);

	for($i = 0; $i < $num_posts; $i++){
		if(isset($_XML_DATA[0]['child'][1]['child'][$i]['name']) && isset($_XML_DATA[0]['child'][1]['child'][$i]['content'])){
			$_post_value[$_XML_DATA[0]['child'][1]['child'][$i]['name']][$i] = $_XML_DATA[0]['child'][1]['child'][$i]['content'];
		}
	}

	foreach($_post_value as $key => $value){
		if(count($_post_value[$key]) > 1){
			$j = 0;

			foreach($_post_value[$key] as $content){
				$_post_data[$key][$j] = $content;
				$j++;
			}
		}
		else{
			foreach($_post_value[$key] as $content){ $_post_data[$key] = $content; }
		}
	}

	return $_post_data;
}

/////////////////////////////////////////
// Parse file data out of the xml data
/////////////////////////////////////////
function getFileData($_XML_DATA){
	$_file_data = array();
	$num_files = count($_XML_DATA[0]['child'][2]['child']);

	//file data is assumed to be stored in $_XML_DATA[0]['child'][2]
	for($i = 0; $i < $num_files; $i++){
		$file_info = new FileInfo;

		if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][0]['name']) && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][0]['content'])){
			$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][0]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][0]['content']);
		}

		if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][1]['name']) && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][1]['content'])){
			$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][1]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][1]['content']);
		}

		if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][2]['name']) && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][2]['content'])){
			$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][2]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][2]['content']);
		}

		if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][3]['name']) && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][3]['content'])){
			$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][3]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][3]['content']);
		}

		if($file_info->slot != ''){ $_file_data[$file_info->slot] = $file_info; }
	}

	return $_file_data;
}

//////////////////////////////////////////////////
//  formatBytes($file_size) mixed file sizes
//  formatBytes($file_size, 0) KB file sizes
//  formatBytes($file_size, 1) MB file sizes etc
//////////////////////////////////////////////////
function formatBytes($bytes, $format=99){
	$byte_size = 1024;
	$byte_type = array(" KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");

	$bytes /= $byte_size;
	$i = 0;

	if($format == 99 || $format > 7){
		while($bytes > $byte_size){
			$bytes /= $byte_size;
			$i++;
		}
	}
	else{
		while($i < $format){
			$bytes /= $byte_size;
			$i++;
		}
	}

	$bytes = sprintf("%1.2f", $bytes);
	$bytes .= $byte_type[$i];

	return $bytes;
}

//////////////////////////////////////////////////////////////////////
// Send an email with the upload results.
//////////////////////////////////////////////////////////////////////
function emailUploadResults($_FILE_DATA, $_CONFIG_DATA, $_POST_DATA){
	$_FILE_DATA_EMAIL = getFileDataEmail($_FILE_DATA, $_CONFIG_DATA, $_POST_DATA);

	$end_char = "\n";
	$headers = '';
	$message = '';

	if($_CONFIG_DATA['html_email_support']){
		$headers = 'Content-type: text/html; charset=utf-8; format=flowed' . "\r\n";
		$end_char = "<br>\n";
	}
	else{ $headers = 'Content-type: text/plain; charset=utf-8; format=flowed' . "\r\n"; }

	// add config data to email
	$headers = "From: " . $_CONFIG_DATA['from_email_address'] . "\r\n";
	$message = "Upload ID: ". $_CONFIG_DATA['upload_id'] . $end_char;
	$message .= "Start Upload: ". date("M j, Y, g:i:s", $_CONFIG_DATA['start_upload']) . $end_char;
	$message .= "End Upload: ". date("M j, Y, g:i:s", $_CONFIG_DATA['end_upload']) . $end_char;
	$message .= "Remote IP: " . $_CONFIG_DATA['remote_addr'] . $end_char;
	$message .= "Browser: " . $_CONFIG_DATA['http_user_agent'] . $end_char . $end_char;

	// add file upload info to email
	$message .= $_FILE_DATA_EMAIL;

	// add any post or config values to the email here. eg.
	// $message .= "The client ID is " . $_POST_DATA['client_id'] . $end_char;
	//$message .= "The secret ID is " . $_CONFIG_DATA['secret_id'] . $end_char;

	mail($_CONFIG_DATA['to_email_address'], $_CONFIG_DATA['email_subject'], $message, $headers);
}

////////////////////////////////////////////////////////
// Create a '<tr><td>' string based on file upload info
////////////////////////////////////////////////////////
function getFileDataTable($_FILE_DATA, $_CONFIG_DATA, $_POST_DATA){
	$file_list = '';
	$col = 0;

	$file_list = "<table class='ubrFinishedData'>\n";
	$file_list .= "   <tr><th>UPLOADED FILE NAME</th><th>Хуулах файлын хэмжээ</th></tr>\n";

	foreach($_FILE_DATA as $slot => $value){
		$file_slot = $_FILE_DATA[$slot]->getFileInfo('slot');
		$file_name = $_FILE_DATA[$slot]->getFileInfo('name');
		$file_size = $_FILE_DATA[$slot]->getFileInfo('size');
		$file_type = $_FILE_DATA[$slot]->getFileInfo('type');
		$formatted_file_size = formatBytes($file_size);

		if($col%=2){ $css_class = "ubrFinishedEven"; }
		else{ $css_class = "ubrFinishedOdd"; }

		if($file_size > 0){
			if($_CONFIG_DATA['link_to_upload'] == 1){
				$file_path = $_CONFIG_DATA['path_to_upload'] . $file_name.'?';
				$file_list .= "<tr><td class='$css_class'><a href=\"$file_path\" target=\"_blank\">$file_name</a></td><td class='$css_class'>$formatted_file_size</td></tr>\n";
			}
			else{ $file_list .= "<tr><td class='$css_class'>$file_name</td><td class='$css_class'>$formatted_file_size</td></tr>\n"; }
		}
		else{ $file_list .= "<tr><td class='$css_class'>$file_name</td><td class='$css_class'><span class='ubrError'>Файлыг хуулж чадсангүй</span></td></tr>\n"; }

		$col++;
	}

	$file_list .= "</table>\n";

	return $file_list;
}

///////////////////////////////////////////////////////
// Create an email string based on file upload data
///////////////////////////////////////////////////////
function getFileDataEmail($_FILE_DATA, $_CONFIG_DATA, $_POST_DATA){
	$email_file_list = '';
	$end_char = "\n";

	if($_CONFIG_DATA['html_email_support']){ $end_char = "<br>\n"; }

	foreach($_FILE_DATA as $slot => $value){
		$file_slot = $_FILE_DATA[$slot]->getFileInfo('slot');
		$file_name = $_FILE_DATA[$slot]->getFileInfo('name');
		$file_size = $_FILE_DATA[$slot]->getFileInfo('size');
		$file_type = $_FILE_DATA[$slot]->getFileInfo('type');
		$formatted_file_size = formatBytes($file_size);

		if($file_size > 0){
			if($_CONFIG_DATA['link_to_upload_in_email']){ $email_file_list .= "Файлын нэр: " . $_CONFIG_DATA['path_to_upload'] . $file_name . "     Файлын хэмжээ: " . $formatted_file_size . $end_char; }
			else{
				if($_CONFIG_DATA['unique_upload_dir']){
					$email_file_list .= 'Файлын нэр: ' . $_CONFIG_DATA['upload_id'] . '/' . $file_name . "     Файлын хэмжээ: " . $formatted_file_size . $end_char;
				}
				else{ $email_file_list .= 'Файлын нэр: ' . $file_name . "     Файлын хэмжээ: " . $formatted_file_size . $end_char; }
			}
		}
		else{ $email_file_list .= 'Файлын нэр: ' . $file_name . "     Файлын хэмжээ: Хуулж чадсангүй!" . $end_char; }
	}

	return $email_file_list;
}

///////////////////////////////////////////////////////////////////////////////////
// Run js script on parent if 'embedded_upload_results' config setting is detected
///////////////////////////////////////////////////////////////////////////////////
function scriptParent(){
	print "<script language='javascript' type='text/javascript'>\n";
	print "		parent.document.getElementById('upload_div').style.display = '';\n";
	print "		parent.iniFilePage();\n";
	print "</script>\n";
}

///////////////////////////////////////
// Create a thumbfile of a jpg or png file
//////////////////////////////////////
function createThumbFile($source_file_path, $source_file_name, $thumb_file_path, $thumb_file_name, $thumb_file_width, $thumb_file_height){
	list($source_file_width, $source_file_height, $type, $attr) = getimagesize($source_file_path . $source_file_name);
	$source_file_extention = getFileExtension($source_file_name);

	if($source_file_extention == 'jpg' || $source_file_extention == 'jpeg'){ $src_img = imagecreatefromjpeg($source_file_path . $source_file_name); }
	elseif($source_file_extention == 'png'){ $src_img = imagecreatefrompng($source_file_path . $source_file_name); }
	else{ return false; }

	$thumb = getScale($source_file_width, $source_file_height, $thumb_file_width, $thumb_file_height);
	$dst_img = ImageCreateTrueColor($thumb['width'], $thumb['height']);
	$thumb_file = $thumb_file_path . $thumb_file_name;

	imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb['width'], $thumb['height'], $source_file_width, $source_file_height);
	imagejpeg($dst_img, $thumb_file);
	imagedestroy($dst_img);
	imagedestroy($src_img);

	return true;
}

////////////////////////////////////////////////////////
// Get image scale
// Contributor: http://icant.co.uk/articles/phpthumbnails/
//////////////////////////////////////////////////////
function getScale($old_x, $old_y, $new_w, $new_h){
	$thumb = array();

	if($old_x > $old_y) {
		$thumb_w = $new_w;
		$thumb_h = ($new_w / $old_x) * $old_y;
	}

	if($old_x < $old_y) {
		$thumb_w = ($new_h / $old_y) * $old_x;
		$thumb_h = $new_h;
	}

	if($old_x == $old_y) {
		$thumb_w = $new_w;
		$thumb_h = $new_h;
	}

	$thumb['width'] = round($thumb_w);
	$thumb['height'] = round($thumb_h);

	return $thumb;
}

//////////////////////////////////////////////////////////////////////
//  Find file extension
//  Contributor: http://php.about.com/od/finishedphp1/qt/file_ext_PHP.htm
//////////////////////////////////////////////////////////////////////
function getFileExtension($file_name){
	$exts = split("[/\\.]", $file_name);
	$n = count($exts) - 1;
	$exts = $exts[$n];
	$exts = strtolower($exts);

	return $exts;
}

?>