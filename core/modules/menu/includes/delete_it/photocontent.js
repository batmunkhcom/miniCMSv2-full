/* ================================================================ 
This copyright notice must be untouched at all times.

The original version of this javascript and the associated (x)html
is available at http://www.stunicholls.com/gallery/multi-page.html
Copyright (c) 2005-2007 Stu Nicholls. All rights reserved.
This javascript and the associated (x)html may be modified in any 
way to fit your requirements.
=================================================================== */

clickGallery = function(menu) {
	var getEls = document.getElementById(menu).getElementsByTagName("LI");
	var getAgn = getEls;

	for (var i=0; i<getEls.length; i++) {
			getEls[i].onclick=function() {
				for (var x=0; x<getAgn.length; x++) {
				getAgn[x].className=getAgn[x].className.replace("galleryon", "");
				}
				this.className+=" galleryon";
			if ((this.className.indexOf('sub'))!=-1) {
				if ((this.className.indexOf('page'))!=-1) {
					this.className=this.className.replace("page", "");
				}
				else {
				this.className+=" page";
				}
			}
		}
	}
}
