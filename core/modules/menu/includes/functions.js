
$(document).ready(function(){
	//global varsxml.php?action=content_comment&type=add&name=\'+escape(encodeURI(document.contentCommentForm.comment_name.value))+\'&content_id='.$content_id.'&comment=\'+escape(encodeURI(document.contentCommentForm.comment_content.value)
	var inputUser = $("#comment_name");
	var inputMessage = $("#comment_content");
	var inputContentId = $("#content_id");
	var loading = $("#contentComments");
	var messageList = $("#contentComments");
	var ehlel = 0;
	//functions
	function updateContentComments(loadURL){
		loadURL = loadURL + '&l='+ehlel;
		$.ajax({
			type: "POST", url: loadURL, data: "",
			complete: function(data){
				//loading.fadeOut();
				messageList.append(data.responseText);
				//messageList.show("fast");
				ehlel = ehlel + 20;
			}
		});
	}
	updateContentComments("xml.php?action=content_comment&l=0&content_id="+$("#content_id").attr("value"));
	//check if all fields are filled
	function checkFaqsForm(){
		if(inputUser.attr("value") && inputMessage.attr("value"))
			return true;
		else
			return false;
	}
	$("#moreContentComments").click(function(){
		updateContentComments("xml.php?action=content_comment&content_id="+$("#content_id").attr("value")+'&l='+ehlel);
	});
	//on submit event
	$("#contentCommentForm").submit(function(){
		if(checkFaqsForm()){
			var nick = inputUser.attr("value");
			var message = inputMessage.attr("value");
			var content_id = inputContentId.attr("value");
			var buttonValue = $("#commentSubmit").attr("value");
			//we deactivate submit button while sending
			
			//$("#commentSubmit").attr({ disabled:true, value:"Sending..." });
			//$("#commentSubmit").blur();
			
			$.ajax({
				type: "POST", url: "xml.php?action=content_comment&type=add", data: "name="+nick+"&content_id="+content_id+"&comment="+message,
				complete: function(data){
					messageList.html(data.responseText);
					$("#contentCommentForm").hide('fast');
					window.location='#lastComment';
				}
			 });
		}
		else alert("Please fill all fields!");
		//we prevent the refresh of the page after submitting the form
		return false;
	});
	
	
	$('#thumbPhotos a').lightBox(); 
	/*	
		$(function() {
			// Use this example, or...
			//$('a[@rel*=lightbox]').lightBox(); // Select all links that contains lightbox in the attribute rel
			// This, or...
			$('#autoCarPhotosLightbox a').lightBox(); // Select all links in object with gallery ID
			// This, or...
			//$('a.lightbox').lightBox(); // Select all links with lightbox class
			// This, or...
			//$('a').lightBox(); // Select all links in the page
			// ... The possibility are many. Use your creative or choose one in the examples above
		});
		*/
});



function mbmContentComments() 
{
	  var result_div = document.getElementById("contentComments");
	  var elementForm = document.getElementById("contentCommentForm");
	  //elementForm.style.visibility="hidden";
	  if(checkReadyState(xmlhttp))
	  {
		  var response = xmlhttp.responseXML.documentElement;
		  var ct = '';
		  x=response.getElementsByTagName("comment");
		  result_div.style.display='block';
		  for (i=0;i<x.length;i++){
			ct = ct + '<div id="commentUsername">'+(i+1)+'. ';
			ct = ct + x[i].getAttribute("username") ;
			if(x[i].getAttribute("date_added")!=null){
				ct = ct + ' <span id="mbmTimeConverterContentComment">[' + x[i].getAttribute("date_added") + ']<\/span>';
			}
			ct = ct + '<\/div>';
			ct = ct + '<div id="commentUserComment">';
			ct = ct + unescape(decodeURI(x[i].firstChild.nodeValue)) + '<\/div>';
		  }
		  //elementForm.style.display="none";
		  result_div.innerHTML = '';
		  result_div.innerHTML = ct;
		  //elementForm.comment_name.value = '';
		  elementForm.comment_content.value = '';
		  
	  }else{
			result_div.innerHTML='<div align="center"><img src="images/web/loading.gif" border="0" /><\/div>';
		}
}