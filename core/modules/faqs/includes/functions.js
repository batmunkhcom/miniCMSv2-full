
$(document).ready(function(){
	//global vars
	var inputUser = $("#faqs_name");
	var inputEmail = $("#faqs_email");
	var inputMessage = $("#faqs_content");
	var loading = $("#faqsLoading");
	var messageList = $("#faqsResult");
	
	//functions
	function updateFaqs(loadURL){
		//just for the fade effect
		messageList.hide();
		loading.fadeIn();
		//send the post to shoutbox.php
		$.ajax({
			type: "POST", url: loadURL, data: "",
			complete: function(data){
				loading.fadeOut();
				messageList.html(data.responseText);
				messageList.fadeIn(2000);
			}
		});
	}
	updateFaqs("xml.php?action=faqs");
	//check if all fields are filled
	function checkFaqsForm(){
		if(inputUser.attr("value") && inputMessage.attr("value"))
			return true;
		else
			return false;
	}
	
	//Load for the first time the shoutbox data
	//updateShoutbox();
	
	//on submit event
	$("#FAQsForm").submit(function(){
		if(checkFaqsForm()){
			var nick = inputUser.attr("value");
			var message = inputMessage.attr("value");
			var email = inputEmail.attr("value");
			var buttonValue = $("#faqs_button").attr("value");
			//we deactivate submit button while sending
			
			$("#faqs_button").attr({ disabled:true, value:"Sending..." });
			$("#faqs_button").blur();
			
			$.ajax({
				type: "POST", url: "xml.php?action=faqs&type=send&", data: "name="+nick+"&question="+message+"&email="+email,
				complete: function(data){
					messageList.html(data.responseText);
					//messageList.html(nick+'-'+message+'-'+email);
					$("#faqs_name").attr("value")='';
					$("#faqs_email").attr("value")='';
					$("#faqs_content").attr("value")='';
					//updateFaqs("xml.php?action=faqs");
					//reactivate the send button
					$("#faqs_button").attr({ disabled:false, value:buttonValue });
				}
			 });
		}
		else alert("Please fill all fields!");
		//we prevent the refresh of the page after submitting the form
		return false;
	});
});