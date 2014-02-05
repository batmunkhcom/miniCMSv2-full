function mbmSendToFriend(){
	  var elementForm = document.getElementById("send2Friend");

	  if(checkReadyState(xmlhttp))
	  {
		  var response = xmlhttp.responseXML.documentElement;
		  var ct = '';
		  x=response.getElementsByTagName("send2friend");
		 
		 if(x[0].getAttribute("st")==1){
		 	elementForm.style.display="none"; 	
		 }
		 alert(x[0].getAttribute("txt"));
		  
	}else{
			elementForm.outerHTML='<div align="center"><img src="images/web/loading.gif" border="0" /><\/div>';
	}
}