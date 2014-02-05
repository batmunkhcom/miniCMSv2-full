function mbmVideoInfoDisplay(id,total){
	
	for(i=1;i<=total;i++){
		if(document.getElementById('videoInfoContent'+i)){
			document.getElementById('videoInfoContent'+i).style.display='none';
		}
	}
	if(document.getElementById('videoInfoContent'+id)){
		document.getElementById('videoInfoContent'+id).style.display='block';
	}
	return true;
}
function mbmVideInfoDisplayClear(){
	mbmVideoInfoDisplay(0,4);
	setTimeout("mbmVideInfoDisplayClear()",10000);
}
function mbmAddToPlayList(){
	var result_div = document.getElementById("addToPlaylist");
	if(checkReadyState(xmlhttp))
	{
	  var response = xmlhttp.responseXML.documentElement;
	  x=response.getElementsByTagName("comment")
	  result_div.style.display='block';
	  result_div.innerHTML = '';
	  for (i=0;i<x.length;i++){
		result_div.innerHTML = result_div.innerHTML+x[i].firstChild.nodeValue+'<br />';
	  }
	}else{
		result_div.innerHTML='<center><img src="images/web/loading.gif" border="0" /><\/center>';
	}
}
function mbmRemoveFromPlayList(){
	var result_div = document.getElementById("removeFromPlaylist");
	if(checkReadyState(xmlhttp))
	{
	  var response = xmlhttp.responseXML.documentElement;
	  x=response.getElementsByTagName("comment")
	  result_div.style.display='block';
	  result_div.innerHTML = '';
	  for (i=0;i<x.length;i++){
		result_div.innerHTML = result_div.innerHTML+x[i].firstChild.nodeValue+'<br />';
	  }
	}else{
		result_div.innerHTML='<center><img src="images/web/loading.gif" border="0" /><\/center>';
	}
}

mbmVideInfoDisplayClear();


