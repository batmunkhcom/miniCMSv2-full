$(document).ready(function(){
	//global vars
	var resultValue = $("#IlikeValues");
	var iLikeCode= $("#IlikeCode");
	
	//functions
	function updateIlike(loadURL){
		//just for the fade effect
		//resultValue.hide();
		//send the post to shoutbox.php
		$.ajax({
			type: "POST", url: loadURL, data: "code="+iLikeCode.html(),
			complete: function(data){
				resultValue.html(data.responseText);
				//loading.show();
			}
		});
	}
	//check if all fields are filled
	function checkIlike(){
		
	}
	
	//Load for the first time the shoutbox data
	//updateShoutbox();
	
	//on submit event
	$("#IlikeUp").click(function(){
		
	//	var buttonValue = $("#faqs_button").attr("value");
		var code = iLikeCode.html();
		  $.ajax({
				type: "POST", url: "xml.php?action=ilike&", data: "type=1&value=1&code="+code,
				complete: function(data){
					resultValue.html(data.responseText);
				}
			 });
	});
	$("#IlikeDown").click(function(){
		var code = iLikeCode.html();
		  $.ajax({
				type: "POST", url: "xml.php?action=ilike&", data: "type=-1&value=1&code="+code,
				complete: function(data){
					resultValue.html(data.responseText);
				}
			 });
								  
	});
});