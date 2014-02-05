function write_result (target_div_id,url) {

	// Create new JS element
	var create_code = document.createElement('DIV');
	create_code.src = url;

	// Append JS element (therefore executing the 'AJAX' call)
	document.getElementById(target_div_id).innerHTML='';
	document.getElementById(target_div_id).appendChild (create_code);
	return true;
}
function confirmSubmit(txt,jumpURL){
	alert(txt);
	var agree=confirm(txt);
	//var b=goURL(jumpURL);
	if (agree) return goURL(jumpURL);
	else return '#' ;
}
function goURL(a){
	window.location=a;
}
function mbmChangeCSS(element_id,new_classname){
	document.getElementById(element_id).className=new_classname;
	return true;
}
function mbmChangeElementBgColor(element_id,new_color){
	document.getElementById(element_id).style.backgroundColor=new_color;
	return true;
}
function mbmAddBookmark(bookmarkurl,bookmarktitle,txt)
{
	//var txt_mozilla = 'Тэмдэглэгдлээ. Та дараа BOOKMARKS цэснээс уг видео руу шууд хандах боломжтой.';
	//var txt_ie = 'Тэмдэглэгдлээ. Та дараа FAVORITES цэснээс уг видео руу шууд хандах боломжтой.';
	if (window.sidebar) { // Mozilla Firefox Bookmark
		window.sidebar.addPanel(bookmarktitle, bookmarkurl,"");
		alert(txt);
	} else if( window.external ) { // IE Favorite
		window.external.AddFavorite( bookmarkurl, bookmarktitle);
		alert(txt); 
	}else if(window.opera && window.print) { // Opera Hotlist
		alert(txt);
		return true; 
	}
}
function mbmToggleVisibility(me){
	if (document.getElementById(me).style.visibility=="hidden"){
		document.getElementById(me).style.visibility="visible";
		}
	else {
		document.getElementById(me).style.visibility="hidden";
		}
}
function mbmToggleDisplay(me){
	if(document.getElementById(me).style.display=="none"){
		document.getElementById(me).style.display="block";
		}
	else if(document.getElementById(me).style.display!="none"){
		document.getElementById(me).style.display="none";
		}
}

function mbmSetPageTitle(txt){
	document.title=txt;
	return true;
}
function mbmSetContentTitle(txt){
	document.getElementById("content_title").innerHTML = txt;
	return true;
}
function mbmBodyonLoad(onloadfunction){
	document.body.getAttribute("onLoad").value=onloadfunction;
}
function mbmSetMetaData(meta_name,attr_name,attr_value){
	t = document.getElementsByTagName("meta");
	for(i=0;i<t.length;i++){
		if(t[i].getAttribute('name')==meta_name){
			t[i].setAttribute(attr_name,attr_value);
		}
	}
	return true;
}
function mbmGetAttrData(tag_name,attr_name,to_get_attr){
	t = document.getElementsByTagName(tag_name);
	for(i=0;i<t.length;i++){
		if(t[i].getAttribute('name')==attr_name){
			buf = t[i].getAttribute(to_get_attr);
		}
	}
	return buf;
}
function mbmSession(){
	}