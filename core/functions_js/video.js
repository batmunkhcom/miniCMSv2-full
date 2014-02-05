//video Playlist
$(document).ready(function(){
	
	/*
	$.ajax({
				type: "POST", url: "xml.php?action=playlist&type=send&", data: "video_url="+playlist_button.attr("video_url")+"&image_url="+playlist_button.attr("image_url")+"&duration="+playlist_button.attr("duration"),
				complete: function(data){
					playlist_button.fadeIn();
					playlist_button.html(data.responseText);
				}
			 });
	*/
	$("#videoPlaylistButton a").click(function(){
		$("#videoPlaylists").show("fast");
		$("#videoPlaylists").html('<img src="images/loading.gif">');
		$.ajax({
					type: "POST", url: "xml.php?action=playlist&type=get_playlistOptions&", data: "",
					complete: function(data){
						$("#videoPlaylists").fadeIn();
						$("#videoPlaylists").html(data.responseText);
					}
				 });
	});
});

function mbmPlaylistAction(element){
	
	if(element == 'new'){
		a = window.prompt("Playlist","");
		if(a == ''){
			mbmPlaylistAction('new');
		}
		$("#videoPlaylists").html('<img src="images/loading.gif">');
		$.ajax({
					type: "POST", url: "xml.php?action=playlist&type=createPlaylist&", data: "name="+a,
					complete: function(data){
						$.ajax({
							type: "POST", url: "xml.php?action=playlist&type=get_playlistOptions&", data: "created="+a,
							complete: function(data){
								$("#videoPlaylists").fadeIn();
								$("#videoPlaylists").html(data.responseText);
							}
						 });
					}
				 });
	}
}

function mbmAddToPlaylist(playlist_id){
	video_url = $("#videoPlaylistButton").attr("video_url");
	image_url = $("#videoPlaylistButton").attr("image_url");
	title = document.title;
	comment = mbmGetAttrData("meta","description","content");
	
	$("#videoPlaylists").html('<img src="images/loading.gif">');
	$.ajax({
			type: "POST", url: "xml.php?action=playlist&type=addToPlaylist&", data: "playlist_id="+playlist_id+"&video_url="+video_url+"&image_url="+image_url+"&title="+title+"&comment="+comment,
			complete: function(data){
				$("#videoPlaylistButton").fadeIn();
				$("#videoPlaylistButton").html(data.responseText);
			}
		 });
}