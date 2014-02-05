function loadZar(limit,target_div,type,order_by,asc,phone,user_id,timer){
	
	$(target_div).html('<img src="images/loading.gif" />');
	
	$.ajax({
			type: "POST", 
			url: "xml.php?action=zar", 
			data: "limit="+limit+"&order_by="+order_by+"&type="+type+"&asc="+asc+"&user_id="+user_id+"&phone="+phone,
			cache: false,
			//dataType: 'text',
			complete: function(data){
				$(target_div).fadeIn();
				$(target_div).html(data.responseText);
			}
		 });
	if(timer>0){
		setTimeout("loadZar("+limit+",'"+target_div+"','"+type+"','"+order_by+"','"+asc+"','"+phone+"',"+user_id+","+timer+")",timer*1000);
	}
}