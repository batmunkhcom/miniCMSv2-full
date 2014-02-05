$(document).ready(function(){

	$(".autoCarPhotosImage img").click(function(){
						//$('#autoCarBigPhoto').fadeOut(300);
						$('#autoCarBigPhoto').fadeIn(2000);
						$('#autoCarBigPhoto').html('<img src="images/loading.gif" border="0" />');
						$('#autoCarBigPhoto').html(
												   '<img src="'+
												    $(this).attr("bigPhotoUrl")
												   +'" border="0" />'
												   );
						});
	$('#autoCarPhotosLightbox a').lightBox();
});