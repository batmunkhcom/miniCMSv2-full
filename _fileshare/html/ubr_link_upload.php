<?php
//******************************************************************************************************
//	Name: ubr_link_upload.php
//	Revision: 2.6
//	Date: 12:05 PM Saturday, September 20, 2008
//	Link: http://uber-uploader.sourceforge.net
//	Developer: Peter Schmandra
//	Description: Create a link file in the temp directory
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

//***************************************************************************************************************
//   ATTENTION
//
// If you need to debug this file, set the $DEBUG_AJAX = 1 in ubr_ini.php and use the showDebugMessage function.  eg.
// showDebugMessage("Hi There");
//***************************************************************************************************************

//***************************************************************************************************************
// The following possible query string formats are assumed
//
// 1. No query string
// 2. ?about
//***************************************************************************************************************

$THIS_VERSION = '2.6';         // Version of this file
$UPLOAD_ID = '';               // Initialize upload id

require 'ubr_ini.php';
require 'ubr_lib.php';

if($PHP_ERROR_REPORTING){ error_reporting(E_ALL); }

if(isset($_GET['about'])){ kak("<u><b>UBER UPLOADER LINK UPLOAD</b></u><br>UBER UPLOADER VERSION =  <b>" . $UBER_VERSION . "</b><br>UBR_LINK_UPLOAD = <b>" . $THIS_VERSION . "<b><br>\n", 1, __LINE__, $PATH_TO_CSS_FILE); }
else{
	/////////////////////////////////////////////////////
	//   ATTENTION
	//   Put your authentication code here. eg.
	//   if(!authUser($_COOKIE['uber_user'] ){ exit; }
	/////////////////////////////////////////////////////
}

// Set config file
if($MULTI_CONFIGS_ENABLED){
	/////////////////////////////////////////////////////////////////////////
	//   ATTENTION
	//   Put your multi config file code here. eg
	//   if($_SESSION['user_name'] == 'TOM'){ $config_file = 'tom_config.php'; }
	//   if($_COOKIE['user_name'] == 'TOM'){ $config_file = 'tom_config.php'; }
	/////////////////////////////////////////////////////////////////////////
}
else{ $config_file = $DEFAULT_CONFIG; }

// Load config file
require $config_file;

// Generate upload id
$UPLOAD_ID = generateUploadID();

// Format link file  path
$PATH_TO_LINK_FILE = $TEMP_DIR . $UPLOAD_ID . ".link";

//Pass ini and other setting using the link file
$_CONFIG['temp_dir'] = $TEMP_DIR;
$_CONFIG['upload_id'] = $UPLOAD_ID;
$_CONFIG['path_to_link_file'] = $PATH_TO_LINK_FILE;
$_CONFIG['path_to_css_file'] = $PATH_TO_CSS_FILE;
$_CONFIG['cgi_upload_hook'] = $CGI_UPLOAD_HOOK;
$_CONFIG['debug_upload'] = $DEBUG_UPLOAD;
$_CONFIG['delete_link_file'] = $DELETE_LINK_FILE;
$_CONFIG['purge_temp_dirs'] = $PURGE_TEMP_DIRS;
$_CONFIG['purge_temp_dirs_limit'] = $PURGE_TEMP_DIRS_LIMIT;

/////////////////////////////////////////////////////////////////////////
//   ATTENTION
//   You can pass values here by creating or over-riding config values. eg.
//   $_CONFIG['max_upload_size'] = $_SESSION['new_max_upload_size'];
//   $_CONFIG['employee_num'] = $_SESSION['employee_num'];
/////////////////////////////////////////////////////////////////////////

// Create directories
if(!create_dir($TEMP_DIR)){
	if($DEBUG_AJAX){ showDebugMessage('Failed to create temp_dir ' . $TEMP_DIR); }
	showAlertMessage("<span class='ubrError'>ERROR</span>: Failed to create temp_dir", 1);
}
if(!create_dir($_CONFIG['upload_dir'])){
	if($DEBUG_AJAX){ showDebugMessage('Failed to create upload_dir ' . $_CONFIG['upload_dir']); }
	showAlertMessage("<span class='ubrError'>ERROR</span>: Failed to create upload_dir", 1);
}
if($_CONFIG['log_uploads']){
	if(!create_dir($_CONFIG['log_dir'])){
		if($DEBUG_AJAX){ showDebugMessage('Failed to create log_dir ' . $_CONFIG['log_dir']); }
		showAlertMessage("<span class='ubrError'>ERROR</span>: Failed to create log_dir", 1);
	}
}

// Purge old link files
if($PURGE_LINK_FILES){ purge_ubr_files($TEMP_DIR, $PURGE_LINK_LIMIT, '.link', $DEBUG_AJAX); }

// Purge old redirect files
if($PURGE_REDIRECT_FILES){ purge_ubr_files($TEMP_DIR, $PURGE_REDIRECT_LIMIT, '.redirect', $DEBUG_AJAX); }

// Show debug message
if($DEBUG_AJAX){ showDebugMessage("Upload ID = $UPLOAD_ID"); }

// Write link file
if(write_link_file($_CONFIG, $DATA_DELIMITER)){
	if($DEBUG_AJAX){ showDebugMessage('Created link file ' . $PATH_TO_LINK_FILE); }
	startUpload($UPLOAD_ID, $DEBUG_UPLOAD);
}
else{
	if($DEBUG_AJAX){ showDebugMessage('Failed to create link file ' . $PATH_TO_LINK_FILE); }
	showAlertMessage("<span class='ubrError'>ERROR</span>: Failed to create link file: $UPLOAD_ID.link", 1);
}

//////////////////////////////////////////////////////////FUNCTIONS //////////////////////////////////////////////////////////////////

// Create a directory
function create_dir($dir){
	if(is_dir($dir)){ return true; }
	else{
		umask(0);

		if(mkdir($dir, 0777)){ return true; }
		else{ return false; }
	}
}

//Purge old redirect and link files
function purge_ubr_files($temp_dir, $purge_time_limit, $file_type, $debug_ajax){
	$now_time = mktime();

	if(is_dir($temp_dir)){
		if($dp = opendir($temp_dir)){
			while(($file_name = readdir($dp)) !== false){
				if($file_name != '.' && $file_name != '..' && strcmp(substr($file_name, strrpos($file_name, '.')), $file_type) == 0){
					if($file_time = @filectime($temp_dir . $file_name)){
						if(($now_time - $file_time) > $purge_time_limit){ @unlink($temp_dir . $file_name); }
					}
				}
			}
			closedir($dp);
		}
		else{
			if($debug_ajax){ showDebugMessage('Failed to open temp_dir ' . $temp_dir); }
			showAlertMessage("<span class='ubrError'>ERROR</span>: Failed to open temp_dir", 1);
		}
	}
	else{
		if($debug_ajax){ showDebugMessage('Failed to find temp_dir ' . $temp_dir); }
		showAlertMessage("<span class='ubrError'>ERROR</span>: Failed to find temp_dir", 1);
	}
}

//Write 'upload_id.link' file
function write_link_file($_config, $data_delimiter){
	if(($fh = fopen($_config['path_to_link_file'], "wb")) !== false){
		foreach($_config as $config_setting=>$config_value){
			$config_setting = trim($config_setting);
			$config_value = trim($config_value);
			$config_string = $config_setting . $data_delimiter. $config_value . "\n";
			fwrite($fh, $config_string);
		}

		fclose($fh);
		umask(0);
		chmod($_config['path_to_link_file'], 0666);

		if(is_readable($_config['path_to_link_file'])){ return true; }
		else{ return false; }
	}
	else{ return false; }
}

?>