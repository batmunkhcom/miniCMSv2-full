function mbmRatingHover(v,value){
	c0 = document.getElementById('RatingValue0');
	c0.innerHTML = v;
	for(i=1;i<6;i++){
		document.getElementById('RatingValue'+i).className='rating';
	}
	for(i=1;i<=value;i++){
		document.getElementById('RatingValue'+i).className='ratingHover';
	}
}
function mbmRateIt(v,rcode){
	for(i=1;i<=v;i++){
		document.getElementById('RatingValue'+i).className='ratingActive';
	}
	mbmLoadXML('GET','xml.php?action=rating&type=rate&code='+rcode+'&value='+v,mbmRatingResult);
}
function mbmClearRating(){
	for(i=1;i<6;i++){
		document.getElementById('RatingValue'+i).className='rating';
	}
}
function mbmRatingResult(){
	 var result_div = document.getElementById("RatingResult");
	  if(checkReadyState(xmlhttp))
	  {
		  var response = xmlhttp.responseXML.documentElement;
		  x=response.getElementsByTagName("rating")
		  result_div.style.display='block';
		  result_div.innerHTML = '';
		  for (i=0;i<x.length;i++){
			result_div.innerHTML = result_div.innerHTML+'<br /><img src="modules/ratings/star'+x[i].getAttribute("value")+'.png" border="0" />';
		  }
		  document.getElementById("ratingValues").style.display='none';
	  }else{
			result_div.innerHTML='<center><img src="images/web/loading.gif" border="0" /><\/center>';
		}
}