<?php

//******************************************************************************************************

//	Name: ubr_set_progress.php

//	Revision: 2.6

//	Date: 12:04 PM Saturday, September 20, 2008

//	Link: http://uber-uploader.sourceforge.net

//	Developer: Peter Schmandra

//	Description: Initialize the progress bar

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

// showDebugMessage("He There");

//***************************************************************************************************************



//***************************************************************************************************************

// The following possible query string formats are assumed

//

// 1. ?upload_id=32_character_alpha_numeric_string

// 2. ?about

//***************************************************************************************************************



$THIS_VERSION    = '2.6';        // Version of this file

$UPLOAD_ID = '';                 // Initialize upload id



require 'ubr_ini.php';

require 'ubr_lib.php';



if($PHP_ERROR_REPORTING){ error_reporting(E_ALL); }



if(isset($_GET['upload_id']) && preg_match("/^[a-zA-Z0-9]{32}$/", $_GET['upload_id'])){ $UPLOAD_ID = $_GET['upload_id']; }

elseif(isset($_GET['about'])){ kak("<u><b>UPLOADER SET PROGRESS</b></u><br>UPLOADER VERSION =  <b>" . $UBER_VERSION . "</b><br>UBR_SET_PROGRESS = <b>" . $THIS_VERSION . "<b><br>\n", 1, __LINE__, $PATH_TO_CSS_FILE); }

else{ kak("<span class='ubrError'>ERROR</span>: Буруу утга<br>", 1, __LINE__, $PATH_TO_CSS_FILE); }



$flength_file = $TEMP_DIR . $UPLOAD_ID . '.dir/' . $UPLOAD_ID . '.flength';

$hook_file = $TEMP_DIR . $UPLOAD_ID . '.dir/' . $UPLOAD_ID . '.hook';

$found_flength_file = false;

$found_hook_file = false;



// Keep trying to read the flength file until timeout

for($i = 0; $i < $TIMEOUT_LIMIT; $i++){

	if($total_upload_size = readUberFile($flength_file, $DEBUG_AJAX)){

		$found_flength_file = true;



		if($start_time = filectime($flength_file)){}

		else{ $start_time = time(); }



		break;

	}



	clearstatcache();

	sleep(1);

}



# Failed to find the flength file in the alloted time

if(!$found_flength_file){

	if($DEBUG_AJAX){ showDebugMessage("Failed to find flength file $flength_file"); }

	showAlertMessage("<span class='ubrError'>Алдаа</span>: Файл олдсонгүй<br /><a href='http://uber-uploader.sourceforge.net/?section=flength' target='_new'>flength file</a>", 1);

}

elseif(strstr($total_upload_size, "ERROR")){

	# Found the flength file but it contains an error

	list($error, $error_num, $error_msg) = explode($DATA_DELIMITER, $total_upload_size);



	if($DEBUG_AJAX){ showDebugMessage($error_msg); }



	deleteTempUploadDir($TEMP_DIR, $UPLOAD_ID);

	stopUpload();



	if($error_num == 1){ $formatted_error_msg = "<span class='ubrError'>ERROR</span>: Файлыг нээж чадсангүй " . $UPLOAD_ID . ".link"; }

	elseif($error_num == 2 || $error_num == 3){ $formatted_error_msg = "<span class='ubrError'>Алдаа</span>: " . $error_msg; }



	showAlertMessage($formatted_error_msg, 1);

}

else{

	// Keep trying to read the hook file until timeout

	if($CGI_UPLOAD_HOOK){

		for($i = 0; $i < $TIMEOUT_LIMIT; $i++){

			if($hook_data = readUberFile($hook_file, $DEBUG_AJAX)){

				$found_hook_file = true;

				break;

			}



			clearstatcache();

			sleep(1);

		}

	}



	# Failed to find the hook file in the alloted time

	if($CGI_UPLOAD_HOOK && !$found_hook_file){

		if($DEBUG_AJAX){ showDebugMessage("Failed to find hook file $hook_file"); }

		showAlertMessage("<span class='ubrError'>ERROR</span>: Failed to find hook file", 1);

	}



	if($DEBUG_AJAX){

		showDebugMessage("Found flength file $flength_file");

		if($CGI_UPLOAD_HOOK){ showDebugMessage("Found hook file $hook_file"); }

	}



	startProgressBar($UPLOAD_ID, $total_upload_size, $start_time);

}



//////////////////////////////////////////////////////////FUNCTIONS //////////////////////////////////////////////////////////////////



// Remove the temp directory based on upload id

function deleteTempUploadDir($temp_dir, $upload_id){

	$temp_upload_dir = $temp_dir . $upload_id . '.dir';



	if($handle = @opendir($temp_upload_dir)){

		while(($file_name = readdir($handle)) !== false){

			if($file_name != "." && $file_name != ".."){ @unlink($temp_upload_dir . '/' . $file_name); }

		}

		closedir($handle);

	}



	@rmdir($temp_upload_dir);

}



?>