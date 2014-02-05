function mbmSetAttribute(tagName,tagIndex,AttrName,AttrValue){
	var newAttr = document.createAttribute(AttrName);
	newAttr.value = AttrValue;
	document.getElementsByTagName(tagName)[tagIndex].setAttribute(AttrName,AttrValue);
	return true;
}