//******************************************************************************************************
//	Name: ubr_file_upload.js
//	Revision: 2.1
//	Date: 8:13 PM Thursday, August 28, 2008
//	Link: http://uber-uploader.sourceforge.net
//	Developer Peter Schmandra
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
// * ATTENTION * If you need to debug this file, set the $DEBUG_AJAX = 1 in ubr_ini.php
//               and use the showDebugMessage function. eg. showDebugMessage("Upload ID = $UPLOAD_ID<br>");
//***************************************************************************************************************

var upload_range = 1;
var get_status_url;
var seconds = 0;
var minutes = 0;
var hours = 0;
var total_upload_size = 0;
var total_Kbytes = 0;
var CPB_loop = false;
var CPB_width = 0;
var CPB_bytes = 0;
var CPB_time_width = 500;
var CPB_time_bytes = 15;
var CPB_hold = true;
var CPB_byte_timer;
var CPB_status_timer;
var BPB_width_inc = 0;
var BPB_width_new = 0;
var BPB_width_old = 0;
var BPB_timer;
var UP_timer;

// Check the file format before uploading
function checkFileNameFormat(){
	if(!check_file_name_format){ return false; }

	for(var i = 0; i < upload_range; i++){
		if(document.uu_upload.elements['upfile_' + i].value != ""){
			var string = document.uu_upload.elements['upfile_' + i].value;
			var num_of_last_slash = string.lastIndexOf("\\");

			if(num_of_last_slash < 1){ num_of_last_slash = string.lastIndexOf("/"); }

			var file_name = string.slice(num_of_last_slash + 1, string.length);
			var re = /^[\w][\w\.\-\s]{1,120}$/i;

			if(!re.test(file_name)){
				alert("Уучлаарай. Уг хэлбэрийн файлыг оруулахыг зөвшөөрөхгүй. Та файлын нэрээ өөрчлөөд дахин оролдоно уу\n\n1. Файлын нэрний урт 120 тэмдэгтээс илүүгүй бөгөөд 1-9, a-z, A-Z, _, -, space тэмдэгтүүдийг ашиглаж болно.\n");
				return true;
			}
		}
	}
	return false;
}

// Check for legal file extentions
function checkAllowFileExtensions(){
	if(!check_allow_extensions_on_client){ return false; }

	for(var i = 0; i < upload_range; i++){
		if(document.uu_upload.elements['upfile_' + i].value != ""){
			if(!document.uu_upload.elements['upfile_' + i].value.match(allow_extensions)){
				var string = document.uu_upload.elements['upfile_' + i].value;
				var num_of_last_slash = string.lastIndexOf("\\");

				if(num_of_last_slash < 1){ num_of_last_slash = string.lastIndexOf("/"); }

				var file_name = string.slice(num_of_last_slash + 1, string.length);
				var file_extension = file_name.slice(file_name.indexOf(".")).toLowerCase();

				alert('Уучлаарай "' + file_extension + '" өргөтгөлтэй файл хуулахыг хориглоно.');
				return true;
			}
		}
	}
	return false;
}

// Check for illegal file extentions
function checkDisallowFileExtensions(){
	if(!check_disallow_extensions_on_client){ return false; }

	for(var i = 0; i < upload_range; i++){
		if(document.uu_upload.elements['upfile_' + i].value != ""){
			if(document.uu_upload.elements['upfile_' + i].value.match(disallow_extensions)){
				var string = document.uu_upload.elements['upfile_' + i].value;
				var num_of_last_slash = string.lastIndexOf("\\");

				if(num_of_last_slash < 1){ num_of_last_slash = string.lastIndexOf("/"); }

				var file_name = string.slice(num_of_last_slash + 1, string.length);
				var file_extension = file_name.slice(file_name.indexOf(".")).toLowerCase();

				alert('Уучлаарай "' + file_extension + '" өргөтгөлтэй файл хуулахыг хориглоно.');
				return true;
			}
		}
	}
	return false;
}

// Make sure the user selected at least one file
function checkNullFileCount(){
	if(!check_null_file_count){ return false; }

	var null_file_count = 0;

	for(var i = 0; i < upload_range; i++){
		if(document.uu_upload.elements['upfile_' + i].value == ""){ null_file_count++; }
	}

	if(null_file_count == upload_range){
		alert("Хуулах файлаа сонгоно уу.");
		return true;
	}
	else{ return false; }
}

// Make sure the user is not uploading duplicate files
function checkDuplicateFileCount(){
	if(!check_duplicate_file_count){ return false; }

	var duplicate_flag = false;
	var file_count = 0;
	var duplicate_msg = "Файл давхцсан байна. Шалгана уу.\n\n";
	var file_name_array = new Array();

	for(var i = 0; i < upload_range; i++){
		if(document.uu_upload.elements['upfile_' + i].value != ""){
			var string = document.uu_upload.elements['upfile_' + i].value;
			var num_of_last_slash = string.lastIndexOf("\\");

			if(num_of_last_slash < 1){ num_of_last_slash = string.lastIndexOf("/"); }

			var file_name = string.slice(num_of_last_slash + 1, string.length);

			file_name_array[i] = file_name;
		}
	}

	var num_files = file_name_array.length;

	for(var i = 0; i < num_files; i++){
		for(var j = 0; j < num_files; j++){
			if(file_name_array[i] == file_name_array[j] && file_name_array[i] != null){ file_count++; }
		}
		if(file_count > 1){
			duplicate_msg += ' "' + file_name_array[i] + '" файл ' + (i + 1) + " хэсэгт давхцсан байна.\n";
			duplicate_flag = true;
		}
		file_count = 0;
	}

	if(duplicate_flag){
		alert(duplicate_msg);
		return true;
	}
	else{ return false; }
}


function resetForm(){ location.href = self.location; }
function hideProgressBar(){ document.getElementById('progress_bar').style.display = "none"; }
function showDebugMessage(message){ document.getElementById('ubr_debug').innerHTML += message + '<br>'; }
function clearDebugMessage(){ document.getElementById('ubr_debug').innerHTML = ''; }
function showAlertMessage(message){ document.getElementById('ubr_alert').innerHTML = message; }
function clearAlertMessage(){ document.getElementById('ubr_alert').innerHTML = ''; }
function stopDataLoop(){
	clearInterval(UP_timer);
	clearInterval(BPB_timer);
	CPB_loop = false;
}

// Initialize the file upload page
function iniFilePage(){
	resetProgressBar();
	clearAlertMessage();

	for(var i = 0; i < upload_range; i++){
		document.uu_upload.elements['upfile_' + i].disabled = false;
		document.uu_upload.elements['upfile_' + i].value = "";
	}

	document.getElementById('upload_button').disabled = false;
	document.getElementById('progress_bar').style.display = "none";
	document.uu_upload.reset();
}

// Reset the progress bar
function resetProgressBar(){
	CPB_loop = false;
	clearInterval(BPB_timer);
	clearInterval(UP_timer);
	seconds = 0;
	minutes = 0;
	hours = 0;
	CPB_width = 0;
	CPB_bytes = 0;
	CPB_hold = true;
	total_upload_size = 0;
	total_Kbytes = 0;

	document.getElementById('upload_status').style.width = '0px';

	if(show_percent_complete){ document.getElementById('percent_complete').innerHTML = '0%'; }
	if(show_files_uploaded){ document.getElementById('files_uploaded').innerHTML = 0; }
	if(show_files_uploaded){ document.getElementById('total_uploads').innerHTML = ''; }
	if(show_current_position){ document.getElementById('current_position').innerHTML = 0; }
	if(show_current_position){ document.getElementById('total_kbytes').innerHTML = ''; }
	if(show_elapsed_time){ document.getElementById('elapsed_time').innerHTML = 0; }
	if(show_est_time_left){ document.getElementById('est_time_left').innerHTML = 0; }
	if(show_est_speed){ document.getElementById('est_speed').innerHTML = 0; }
}

// Handle user pressing 'Enter' in the upload slots
function handleKey(event){
	if(document.all){ if(window.event.keyCode == 13){ return false; } }
	else{ if(event && event.which == 13){ return false; } }
}

// Link the upload
function linkUpload(){
	if(checkFileNameFormat()){ return false; }
	if(checkAllowFileExtensions()){ return false; }
	if(checkDisallowFileExtensions()){ return false; }
	if(checkNullFileCount()){ return false; }
	if(checkDuplicateFileCount()){ return false; }

	document.getElementById('upload_button').disabled = true;

	if(show_files_uploaded){
		var total_uploads = 0;

		for(var i = 0; i < upload_range; i++){
			if(document.uu_upload.elements['upfile_' + i].value != ""){ total_uploads++; }
		}

		document.getElementById('total_uploads').innerHTML = total_uploads;
	}

	var jsel = document.createElement('SCRIPT');
	var day = new Date;
	var dom;

	if(document.getElementById('ajax_div')){ dom = document.getElementById('ajax_div'); }
	else{ dom = document.body; }

	jsel.type = 'text/javascript';
	jsel.src = path_to_link_script + '?rnd_id=' + day.getTime();
	dom.appendChild(jsel);

	dom = null;
	jsel = null;
	day = null;
	
	document.getElementById("uu_upload").style.display='none';
}

//Submit the upload form
function startUpload(upload_id, debug_upload){
	document.uu_upload.action = path_to_upload_script + '?upload_id=' +  upload_id;
	document.uu_upload.submit();

	for(var i = 0; i < upload_range; i++){ document.uu_upload.elements['upfile_' + i].disabled = true; }

	if(document.getElementById('upload_div')){ document.getElementById('upload_div').style.display = "none"; }

	if(!debug_upload){ initializeProgressBar(upload_id); }
}

// Initialize progress bar
function initializeProgressBar(upload_id){
	var jsel = document.createElement('SCRIPT');
	var dom;

	if(document.getElementById('ajax_div')){ dom = document.getElementById('ajax_div'); }
	else{ dom = document.body; }

	jsel.type = 'text/javascript';
	jsel.src = path_to_set_progress_script + '?upload_id=' + upload_id;
	dom.appendChild(jsel);

	dom = null;
	jsel = null;
	day = null;
}

// Stop the upload
function stopUpload(){
	try{ window.stop(); }
	catch(e){
		try{ document.execCommand('Stop'); }
		catch(e){}
	}
}

//Start the progress bar
function startProgressBar(upload_id, upload_size, start_time){
	total_upload_size = upload_size;
	total_Kbytes = Math.round(total_upload_size / 1024);
	get_status_url = path_to_get_progress_script + '?upload_id=' + upload_id + '&start_time=' + start_time + '&total_upload_size=' + total_upload_size;
	CPB_loop = true;
	document.getElementById('progress_bar').style.display = "";
	showAlertMessage("Файлыг хуулж байна");

	if(show_current_position){ document.getElementById('total_kbytes').innerHTML = total_Kbytes + " "; }
	if(show_elapsed_time){ UP_timer = setInterval("getElapsedTime()", 1000); }

	getProgressStatus();

	if(cedric_progress_bar == 1){
		if(show_current_position){ smoothCedricBytes(); }
		smoothCedricStatus();
	}
}

// Calculate and display upload information
function setProgressStatus(total_bytes_read, files_uploaded, current_filename, bytes_read, lapsed_time){
	var byte_speed = 0;
	var time_remaining = 0;
	var dom;

	if(lapsed_time > 0){ byte_speed = total_bytes_read / lapsed_time; }
	if(byte_speed > 0){ time_remaining = Math.round((total_upload_size - total_bytes_read) / byte_speed); }

	if(cedric_progress_bar == 1){
		if(byte_speed != 0){
			var temp_CPB_time_width = Math.round(total_upload_size * 1000 / (byte_speed * progress_bar_width));
			var temp_CPB_time_bytes = Math.round(1024000 / byte_speed);

			if(temp_CPB_time_width < 5001){ CPB_time_width = temp_CPB_time_width; }
			if(temp_CPB_time_bytes < 5001){ CPB_time_bytes = temp_CPB_time_bytes; }
		}
		else{
			CPB_time_width = 500;
			CPB_time_bytes = 15;
		}
	}

	// Calculate percent finished
	var percent_float = total_bytes_read / total_upload_size;
	var percent = Math.round(percent_float * 100);
	var progress_bar_status = Math.round(percent_float * progress_bar_width);

	// Calculate time remaining
	var remaining_sec = (time_remaining % 60);
	var remaining_min = (((time_remaining - remaining_sec) % 3600) / 60);
	var remaining_hours = ((((time_remaining - remaining_sec) - (remaining_min * 60)) % 86400) / 3600);

	if(remaining_sec < 10){ remaining_sec = '0' + remaining_sec; }
	if(remaining_min < 10){ remaining_min = '0' + remaining_min; }
	if(remaining_hours < 10){ remaining_hours = '0' + remaining_hours; }

	var time_remaining_f = remaining_hours + ':' + remaining_min + ':' + remaining_sec;
	var Kbyte_speed = Math.round(byte_speed / 1024);
	var Kbytes_read = Math.round(total_bytes_read / 1024);

	if(cedric_progress_bar == 1){
		if(cedric_hold_to_sync){
			if(progress_bar_status < CPB_width){ CPB_hold = true; }
			else{
				CPB_hold = false;
				CPB_width = progress_bar_status;
				CPB_bytes = Kbytes_read;
			}
		}
		else{
			CPB_hold = false;
			CPB_width = progress_bar_status;
			CPB_bytes = Kbytes_read;
		}

		dom = document.getElementById('upload_status');
		dom.style.width = progress_bar_status + 'px';
	}
	else if(bucket_progress_bar == 1){
		BPB_width_old = BPB_width_new;
		BPB_width_new = progress_bar_status;

		if((BPB_width_inc < BPB_width_old) && (BPB_width_new > BPB_width_old)){ BPB_width_inc = BPB_width_old; }

		clearInterval(BPB_timer);
		BPB_timer = setInterval("incrementProgressBar()", 10);
	}
	else{
		dom = document.getElementById('upload_status');
		dom.style.width = progress_bar_status + 'px';
	}

	if(show_current_position){
		dom = document.getElementById('current_position');
		dom.innerHTML = Kbytes_read;
	}
	if(show_current_file){
			dom = document.getElementById('current_file');
			dom.innerHTML = current_filename;
	}
	if(show_percent_complete){
		dom = document.getElementById('percent_complete')
		dom.innerHTML = percent + '%';
	}
	if(show_files_uploaded){
		dom = document.getElementById('files_uploaded');
		dom.innerHTML = files_uploaded;
	}
	if(show_est_time_left){
		dom = document.getElementById('est_time_left');
		dom.innerHTML = time_remaining_f;
	}
	if(show_est_speed){
		dom = document.getElementById('est_speed');
		dom.innerHTML = Kbyte_speed;
	}

	dom = null;
}

function incrementProgressBar(){
	var PB_dom = document.getElementById('upload_status');

	if(BPB_width_inc < BPB_width_new){
		BPB_width_inc++;
		PB_dom.style.width = BPB_width_inc + 'px';
	}
}

// Get the progress of the upload
function getProgressStatus(){
	var jsel = document.createElement('SCRIPT');
	var day = new Date;
	var dom;

	if(document.getElementById('ajax_div')){
		dom = document.getElementById('ajax_div');
		dom.innerHTML = '';
	}
	else{ dom = document.body; }

	jsel.type = 'text/javascript';
	jsel.src = get_status_url + "&rnd_id=" + day.getTime();

	dom.appendChild(jsel);
	dom = null;
	jsel = null;
	day = null;
}

// Calculate the time spent uploading
function getElapsedTime(){
	seconds++;

	if(seconds == 60){
		seconds = 0;
		minutes++;
	}

	if(minutes == 60){
		minutes = 0;
		hours++;
	}

	var hr = "" + ((hours < 10) ? "0" : "") + hours;
	var min = "" + ((minutes < 10) ? "0" : "") + minutes;
	var sec = "" + ((seconds < 10) ? "0" : "") + seconds;
	var dom = document.getElementById('elapsed_time')

	dom.innerHTML = hr + ":" + min + ":" + sec;

	dom = null;
	hr = null;
	min = null;
	sec = null;
}

// Make the progress bar smooth
function smoothCedricStatus(){
	if(CPB_width < progress_bar_width && !CPB_hold){
		CPB_width++;
		var dom = document.getElementById('upload_status');
		dom.style.width = CPB_width + 'px';
		dom = null;
	}

	if(CPB_loop){
		clearTimeout(CPB_status_timer);
		CPB_status_timer = setTimeout("smoothCedricStatus()", CPB_time_width);
	}
}

// Make the bytes uploaded smooth
function smoothCedricBytes(){
	if(CPB_bytes < total_Kbytes && !CPB_hold){
		CPB_bytes++;
		var dom = document.getElementById('current_position');
		dom.innerHTML = CPB_bytes;
		dom = null;
	}

	if(CPB_loop){
		clearTimeout(CPB_byte_timer);
		CPB_byte_timer = setTimeout("smoothCedricBytes()", CPB_time_bytes);
	}
}

// Add one upload slot
function addUploadSlot(num){
	if(upload_range < max_upload_slots){
		if(num == upload_range){
			var up = document.getElementById('upload_slots');
			var dv = document.createElement("div");

			dv.innerHTML = '<input class="ubrUploadSlot" type="file" name="upfile_' + upload_range + '" size="90" onChange="addUploadSlot('+(upload_range + 1)+')" onKeypress="return handleKey(event)">';
			up.appendChild(dv);
			upload_range++;
			up = null;
			dv = null;
		}
	}
}
