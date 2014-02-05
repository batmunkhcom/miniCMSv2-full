
$(document).ready(function(){
	//global vars
	var inputUser = $("#usernameComments");
	var inputCaptcha = $("#captcha");
	var inputMessage = $("#commentsContent");
	var loading = $("#commentsLoading");
	var messageList = $("#commentsResult");
	var commentCode = $("#commentCode");
	
	//functions
	function updateComments(loadURL){
		//just for the fade effect
		messageList.hide();
		var code = commentCode.attr("value");
		loading.fadeIn();
		//send the post to shoutbox.php
		$.ajax({
			type: "POST", url: loadURL, data: "code="+code,
			complete: function(data){
				loading.fadeOut();
				messageList.html(data.responseText);
				messageList.fadeIn(2000);
			}
		});
	}
	updateComments("xml.php?action=comments");
	//check if all fields are filled
	function checkCommentsForm(){
		if(inputUser.attr("value") && inputMessage.attr("value"))
			return true;
		else
			return false;
	}
	
	//Load for the first time the shoutbox data
	//updateShoutbox();
	
	//on submit event
	$("#formComments").submit(function(){
		if(checkCommentsForm()){
			var nick = inputUser.attr("value");
			var message = inputMessage.attr("value");
			var captcha = inputCaptcha.attr("value");
			var code = commentCode.attr("value");
			var buttonValue = $("#submitComments").attr("value");
			//we deactivate submit button while sending
			
			//$("#submitComments").attr({ disabled:true, value:"Sending..." });
					$("#formComments").hide();
			$("#submitComments").blur();
			$.ajax({
				type: "POST", url: "xml.php?action=comments&type=add&", data: "name="+nick+"&content="+message+"&code="+code+"&captcha="+captcha,
				complete: function(data){
					messageList.html(data.responseText);
					//message.hide();
					//updateComments("xml.php?action=comments");
					//reactivate the send button
					messageList.fadeIn(2000);
					window.location='#lastComment';
				}
			 });
		}
		else alert("Please fill all fields!");
		//we prevent the refresh of the page after submitting the form
		return false;
	});
});


function mbmCommentsResults() 
{
	  var result_div = document.getElementById("commentsResult");
  if(checkReadyState(xmlhttp)){
	  var response = xmlhttp.responseXML.documentElement;
	  x=response.getElementsByTagName("comment");
	  result_div.style.display='block';
	  result_div.innerHTML = '';
	  var ct = '';
	  for (i=0;i<x.length;i++){
		ct = ct + '<div id="comments_name">'+ ''+(i+1)+'. ' ;
		ct = ct + x[i].getAttribute("name");
		ct = ct + ' <span id="comments_mbmTimeConverter">['+x[i].getAttribute("date_added")+']<\/span>';
		ct = ct + '<\/div>';
		ct = ct + '<div id="comments_content">' + x[i].firstChild.nodeValue+'<\/div>';
	  }
	  x2 = response.getElementsByTagName("result");
	  if(x2.length>0){
		  if(x2[0].getAttribute("st")==1){
			  document.getElementById('formComments').style.display='none';
		  }
		  alert(x2[0].getAttribute("value"));
		  
	  }
	  result_div.innerHTML = ct;
  }else{
		result_div.innerHTML='<center><img src="images/web/loading.gif" border="0" /><\/center>';
	}
}