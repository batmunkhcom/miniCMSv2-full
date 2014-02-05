function mbmDicWordResults() 
{
	  var result_div = document.getElementById("dicResult");
  if(checkReadyState(xmlhttp))
  {
	  var response = xmlhttp.responseXML.documentElement;
	  x=response.getElementsByTagName("word")
	  result_div.style.display='block';
	  result_div.innerHTML = '';
	  for (i=0;i<x.length;i++){
		result_div.innerHTML = result_div.innerHTML+'<strong>'+x[i].getAttribute("keyword")+'<\/strong>: '+x[i].firstChild.nodeValue+'<br />';
	  }
  }else{
		result_div.innerHTML='<center><img src="images/web/loading.gif" border="0" /><\/center>';
	}
}
function mbmEncycWordResults() 
{
  var result_div = document.getElementById("encycResult");
  if(checkReadyState(xmlhttp))
  {
	  var response = xmlhttp.responseXML.documentElement;
	  x=response.getElementsByTagName("word")
	  result_div.style.display='block';
	  for (i=0;i<x.length;i++){
		result_div.innerHTML = '<strong>'+x[i].getAttribute("keyword")+'<\/strong>: '+x[i].firstChild.nodeValue+'<br />';
	  }
  }else{
		result_div.innerHTML='<center><img src="images/web/loading.gif" border="0" /><\/center>';
	}
}