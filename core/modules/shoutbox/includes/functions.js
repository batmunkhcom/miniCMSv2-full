$(document).ready(function(){
	//global vars
	var inputUser = $("#shoutbox_name");
	var inputEmail = $("#shoutbox_email");
	var inputMessage = $("#shoutbox_content");
	var loading = $("#shoutboxLoading");
	var messageList = $("#shoutboxResult");
	
	//functions
	function updateShoutbox(){
		//just for the fade effect
		messageList.hide();
		loading.fadeIn();
		//send the post to shoutbox.php
		$.ajax({
			type: "POST", url: "xml.php?action=shoutbox&", data: "",
			complete: function(data){
				loading.fadeOut();
				messageList.html(data.responseText);
				messageList.fadeIn(2000);
			}
		});
	}
	updateShoutbox();
	//check if all fields are filled
	function checkForm(){
		if(inputUser.attr("value") && inputMessage.attr("value"))
			return true;
		else
			return true;
	}
	
	//Load for the first time the shoutbox data
	//updateShoutbox();
	
	//on submit event
	$("#shoutboxForm").submit(function(){
		if(checkForm()){
			var nick = inputUser.attr("value");
			var message = inputMessage.attr("value");
			var email = inputEmail.attr("value");
			//we deactivate submit button while sending
			$("#shoutbox_submit").attr({ disabled:true, value:"Sending..." });
			$("#shoutbox_submit").blur();
			//send the post to shoutbox.php xml.php?action=faqs&type=send&name=\'+escape(encodeURI(document.FAQsForm.faqs_name.value))+\'&question=\'+escape(encodeURI(document.FAQsForm.faqs_content.value))+\'&email=\'+escape(encodeURI(document.FAQsForm.faqs_email.value)
			$.ajax({
				type: "POST", url: "xml.php?action=shoutbox&type=send", data: "name="+nick+"&content="+message+"&email="+email,
				complete: function(data){
					//messageList(data.responseText);
					//messageList.html(nick+'-'+message+'-'+email);
					updateShoutbox();
					//reactivate the send button
					$("#shoutbox_submit").attr({ disabled:false, value:"Shout it!" });
				}
			 });
		}
		else alert("Please fill all fields!");
		//we prevent the refresh of the page after submitting the form
		return false;
	});
});