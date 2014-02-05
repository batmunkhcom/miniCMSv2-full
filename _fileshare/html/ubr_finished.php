<?php



//******************************************************************************************************

//	Name: ubr_finished.php

//	Revision: 2.1

//	Date: 11:26 AM Saturday, September 20, 2008

//	Link: http://uber-uploader.sourceforge.net

//	Developer: Peter Schmandra

//	Description: Show successful file uploads.

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

// The following possible query string formats are assumed

//

// 1. ?upload_id=32_character_alpha_numeric_string

// 2. ?about

//****************************************************************************************************************



$THIS_VERSION = "2.1";                                // Version of this file

$UPLOAD_ID = '';                                      // Initialize upload id



require 'ubr_ini.php';

require 'ubr_lib.php';

require 'ubr_finished_lib.php';

//require 'ubr_image_lib.php';



if($PHP_ERROR_REPORTING){ error_reporting(E_ALL); }



header('Content-type: text/html; charset=UTF-8');

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

header('Last-Modified: '.date('r'));

header('Cache-Control: no-store, no-cache, must-revalidate');

header('Cache-Control: post-check=0, pre-check=0', FALSE);

header('Pragma: no-cache');



if(isset($_GET['upload_id']) && preg_match("/^[a-zA-Z0-9]{32}$/", $_GET['upload_id'])){ $UPLOAD_ID = $_GET['upload_id']; }

elseif(isset($_GET['about'])){ kak("<u><b>UBER UPLOADER FINISHED PAGE</b></u><br>UBER UPLOADER VERSION =  <b>" . $UBER_VERSION . "</b><br>UBR_FINISHED = <b>" . $THIS_VERSION . "<b><br>\n", 1 , __LINE__, $PATH_TO_CSS_FILE); }

else{ kak("<span class='ubrError'>ERROR</span'>: Invalid parameters passed<br>", 1, __LINE__, $PATH_TO_CSS_FILE); }



//Declare local values

$_XML_DATA = array();                                          // Array of xml data read from the upload_id.redirect file

$_CONFIG_DATA = array();                                       // Array of config data read from the $_XML_DATA array

$_POST_DATA = array();                                         // Array of posted data read from the $_XML_DATA array

$_FILE_DATA = array();                                         // Array of 'FileInfo' objects read from the $_XML_DATA array

$_FILE_DATA_TABLE = '';                                        // String used to store file info results nested between <tr> tags

$_FILE_DATA_EMAIL = '';                                        // String used to store file info results



$xml_parser = new XML_Parser;                                  // XML parser

$xml_parser->setXMLFile($TEMP_DIR, $_REQUEST['upload_id']);    // Set upload_id.redirect file

$xml_parser->setXMLFileDelete($DELETE_REDIRECT_FILE);          // Delete upload_id.redirect file when finished parsing

$xml_parser->parseFeed();                                      // Parse upload_id.redirect file



// Display message if the XML parser encountered an error

if($xml_parser->getError()){ kak($xml_parser->getErrorMsg(), 1, __LINE__, $PATH_TO_CSS_FILE); }



$_XML_DATA = $xml_parser->getXMLData();                        // Get xml data from the xml parser

$_CONFIG_DATA = getConfigData($_XML_DATA);                     // Get config data from the xml data

$_POST_DATA  = getPostData($_XML_DATA);                        // Get post data from the xml data

$_FILE_DATA = getFileData($_XML_DATA);                         // Get file data from the xml data



//print_r($_FILE_DATA);

//print_r($_XML_DATA);

//print_r($_POST_DATA);

//echo ''.$_XML_DATA[0]['child'][0]['child'][18]['content'].'<br />';

/*

echo '<hr >';

echo 'end time : '

						.$_XML_DATA[0]['child'][0]['child'][18]['content'].'<br />';

echo 'start time : '

						.$_XML_DATA[0]['child'][0]['child'][55]['content'].'<br />';

echo 'upload dir url :'

						.$_XML_DATA[0]['child'][0]['child'][37]['content'].'<br />';

echo 'upload id : '

						.$_XML_DATA[0]['child'][0]['child'][62]['content'].'<br />';

echo 'upload dir : '

						.$_XML_DATA[0]['child'][0]['child'][61]['content'].'<br />';

echo 'orig name : '

						.$_XML_DATA[0]['child'][1]['child'][0]['content'].'<br />';

echo 'filesize : '

						.$_XML_DATA[0]['child'][2]['child'][0]['child'][2]['content'].'<br />';

echo 'mimetype: '

						.$_XML_DATA[0]['child'][2]['child'][0]['child'][3]['content'].'<br />';

echo '<hr >';

*/

// Output XML DATA, CONFIG DATA, POST DATA, FILE DATA to screen and exit if DEBUG_ENABLED.



$r_url = DOMAIN.DIR.'index.php?module=fileshare&cmd=finish&'

			.'duration='.base64_encode($_XML_DATA[0]['child'][0]['child'][18]['content']-$_XML_DATA[0]['child'][0]['child'][55]['content']+1)

			.'&filename='.base64_encode($_XML_DATA[0]['child'][1]['child'][0]['content'])

			.'&dl_url='.base64_encode($_XML_DATA[0]['child'][0]['child'][37]['content'].$_XML_DATA[0]['child'][2]['child'][0]['child'][1]['content'])

			.'&abs_url='.base64_encode($_XML_DATA[0]['child'][0]['child'][61]['content'].$_XML_DATA[0]['child'][2]['child'][0]['child'][1]['content'])

			.'&filesize='.base64_encode($_XML_DATA[0]['child'][2]['child'][0]['child'][2]['content'])

			.'&mimetype='.base64_encode($_XML_DATA[0]['child'][2]['child'][0]['child'][3]['content'])

			;

echo '<script language="Javascript">

		window.top.location=\''.$r_url.'\';

		</script>';

exit;

header("Location: ".$r_url);





if($DEBUG_FINISHED){

	if($_CONFIG_DATA['embedded_upload_results'] == 1){ scriptParent(); }



	debug("<br><u>XML DATA</u>", $_XML_DATA);

	debug("<u>CONFIG DATA</u>", $_CONFIG_DATA);

	debug("<u>POST DATA</u>", $_POST_DATA);

	debug("<u>FILE DATA</u><br>", $_FILE_DATA);

	exit;

}





/////////////////////////////////////////////////////////////////////////////////////////////////

//

//           *** ATTENTION: ENTER YOUR CODE HERE !!! ***

//

//	This is a good place to put your post upload code. Like saving the

//	uploaded file information to your DB or doing some image

//	manipulation. etc. Everything you need is in the

//	$XML DATA, $_CONFIG_DATA, $_POST_DATA and $_FILE_DATA arrays.

//

/////////////////////////////////////////////////////////////////////////////////////////////////

//	NOTE: You can now access all XML values below this comment. eg.

//	$_XML_DATA['upload_dir']; or $_XML_DATA['link_to_upload'] etc

/////////////////////////////////////////////////////////////////////////////////////////////////

//	NOTE: You can now access all config values below this comment. eg.

//	$_CONFIG_DATA['upload_dir']; or $_CONFIG_DATA['link_to_upload'] etc

/////////////////////////////////////////////////////////////////////////////////////////////////

//	NOTE: You can now access all post values below this comment. eg.

//	$_POST_DATA['client_id']; or $_POST_DATA['check_box_1_'] etc

/////////////////////////////////////////////////////////////////////////////////////////////////

//	NOTE: You can now access all file (slot, name, size, type) info below this comment. eg.

//	$_FILE_DATA['upfile_0']->name  or  $_FILE_DATA['upfile_0']->getFileInfo('name')

/////////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//	Create thumnail example.

//	createThumbFile(source_file_path, source_file_name, thumb_file_path, thumb_file_name, thumb_file_width, thumb_file_height)

//

//	EXAMPLE

//	$file_extension = getFileExtension($_FILE_DATA['upfile_0']->name);

//

//	if($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png'){ $success = createThumbFile($_CONFIG_DATA['upload_dir'], $_FILE_DATA['upfile_0']->name, $_CONFIG_DATA['upload_dir'], 'thumb_' . $_FILE_DATA['upfile_0']->name, 120, 100); }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//Create file upload table

$_FILE_DATA_TABLE = getFileDataTable($_FILE_DATA, $_CONFIG_DATA, $_POST_DATA);



// Create and send email

if($_CONFIG_DATA['send_email_on_upload']){ emailUploadResults($_FILE_DATA, $_CONFIG_DATA, $_POST_DATA); }



?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

	<head>

		<title>Uber-Uploader - Free File Upload Progress Bar</title>

		<meta http-equiv="content-type" content="text/html; charset=utf-8">

		<meta http-equiv="pragma" content="no-cache">

		<meta http-equiv="cache-control" content="no-cache">

		<meta http-equiv="expires" content="-1">

		<meta name="robots" content="none">

		<link rel="stylesheet" type="text/css" href="<?php print $PATH_TO_CSS_FILE; ?>">

	</head>

	<?php if($_CONFIG_DATA['embedded_upload_results'] == 1){ scriptParent(); } ?>

	<body class="ubrBody">

		<div class="ubrWrapper">

			<div align="center">

				<br>

				<br>

				<?php print $_FILE_DATA_TABLE; ?>

				<br>

				<?php if($_CONFIG_DATA['embedded_upload_results'] != 1){ ?>

				<br><input type="button" value="Go Back" onClick="javascript:location.href='ubr_file_upload.php'">

				<?php } ?>

			</div>

		</div>

	</body>

</html>