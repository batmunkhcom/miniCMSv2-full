// JavaScript Document
function mbmZarDelete(zar_id){
	$.ajax({
		type: "POST", url: "xml.php?action=zar_module&type=delete", data: "&id="+zar_id,
		complete: function(data){
			$("#zarItem"+zar_id).html(data.responseText);
			//$("#zarItem"+zar_id).hide('fast');
			$("#zarItem"+zar_id).fadeOut(3000);
		}
	 });
}