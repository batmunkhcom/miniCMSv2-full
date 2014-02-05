var xmlhttp;

function mbmLoadXML(type,url,dd) 
{
	xmlhttp='';
	// code for Mozilla, etc.
	if (window.XMLHttpRequest) {
	  xmlhttp=new XMLHttpRequest()
	}
	// code for IE
	else if (window.ActiveXObject){
	  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	  if(xmlhttp==null){
		  	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	  }
	}
	//xmlhttp = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP"): new XMLHttpRequest();
	if (xmlhttp!=null){
	  xmlhttp.onreadystatechange=dd;
	  xmlhttp.open(type,url,true);
	  if (window.XMLHttpRequest) {
		  xmlhttp.send('s');
		}
		// code for IE
		else if (window.ActiveXObject){
			xmlhttp.send();
		}
	}
	else{
	  alert("Алдаа.")
	}
}
function loadXMLDoc(url,dd) 
{
	xmlhttp=''
	// code for Mozilla, etc.
	if (window.XMLHttpRequest) {
	  xmlhttp=new XMLHttpRequest()
	}
	// code for IE
	else if (window.ActiveXObject){
	  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	  if(xmlhttp==null){
		  	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	  }
	}
	//xmlhttp = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP"): new XMLHttpRequest();
	if (xmlhttp!=null){
	  xmlhttp.onreadystatechange=dd;
	  xmlhttp.open("GET",url,true);
	  if (window.XMLHttpRequest) {
		  xmlhttp.send('s');
		}
		// code for IE
		else if (window.ActiveXObject){
			xmlhttp.send();
		}
	}
	else{
	  alert("Алдаа.")
	}
}
function checkReadyState(obj)
{
  if(obj.readyState == 4){
    if(obj.status == 200) {
      return true;
    }
    else
    {
      alert("Fetching data failed");
    }
  }else{
	  return false;
  }
}