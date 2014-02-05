//==============================================================================
// jwPlaylist Class 1.0:
// reads XML playlists and returns array of (title,file,url) rows.
// used by mp3player, flvplayer and jpgrotator.
// currently supporting RSS and XSPF formats
//==============================================================================


// system class for event dispatching
import mx.events.EventDispatcher;


class jwPlaylist {


    // location of the xml file to parse
    private var playlistFile:String;
    // flash XML object
    private var playlistXML:XML;
    // playlist array
    private var playlistArray:Array;




	// eventdispatcher functions
	function dispatchEvent() {};
 	function addEventListener() {};
 	function removeEventListener() {};	




    // class constructor, not much going on
    function jwPlaylist() {
		mx.events.EventDispatcher.initialize(this);
    };




    // setup parsing the XML
    public function readPlaylist(plf:String){
        // get new playlist url if provided
        playlistFile = plf;
        // initializing the XML  object
        playlistXML = new XML();
        playlistXML.ignoreWhite = true;
		playlistXML['parent'] = this;
        // function that substracts the needed data from XML
        playlistXML.onLoad = function(success:Boolean) { 
        	if(success) {
				// check playlist format
            	var format = this.firstChild.nodeName.toLowerCase();
				// if RSS, start RSS structure parser
				if( format == 'rss') {
					var done = this.parent.parseRSS();		
				// if playlist, start XSPF structure parser
				} else if (format == 'playlist') {
					var done = this.parent.parseXSPF();
				} else {
	               // return error if format determination failed
    	           this.parent.playlistArray = new Array({title:"wrong playlist format",file:"",link:""});
				}
        	} else {
               // return error if loading failed
           		this.parent.playlistArray = new Array({title:"playlist not found",file:"",link:""});
            }
            // delete XML object and return the array
			this.parent.eventObject = {target:this.parent, type:'read'};  
			this.parent.eventObject.playlist = this.parent.playlistArray;
			this.parent.dispatchEvent(this.parent.eventObject);
            delete this.parent.playlistXML;
        };
        // start loading XML from file
		playlistXML.load(playlistFile);
    };

	
	
	
	//==============================================================================
	// data structure parsers from here
	// add a parser to add your xml scheme
	//==============================================================================


	// parse RSS data structure
	private function parseRSS() {
		playlistArray = new Array();
		var itm = playlistXML.firstChild.firstChild.firstChild;
		while(itm != null) {
			if (itm.nodeName == 'item') {
				var itc = itm.firstChild;
				var tit = '';
				var enc = '';
				var lnk = '';
				while (itc != null) {
					if(itc.nodeName == 'title') {
						tit = itc.firstChild.nodeValue;
					} else if (itc.nodeName == 'enclosure') {
						enc = itc.attributes.url;
					} else if (itc.nodeName == 'link') {
						lnk = itc.firstChild.nodeValue;
					}
					itc = itc.nextSibling;
				}
				if(enc != null) {
					playlistArray.push({title:tit,file:enc,link:lnk});
				}
			}
			itm = itm.nextSibling;
		}
	};
	
	
	
	
	// parse XSPF data structure
	private function parseXSPF() {
		playlistArray = new Array();
		var tl = playlistXML.firstChild.firstChild;
		while(tl != null) {
			if (tl.nodeName == 'trackList') {
				var tck = tl.firstChild;
				while(tck != null) {
					var tc = tck.firstChild;
					var ann = "";
					var loc = "";
					var inf = "";
					var img = "";
					var ide = "";
					while (tc != null) {
						if(tc.nodeName == 'annotation') {
							ann = tc.firstChild.nodeValue;
						} else if (tc.nodeName == 'location') {
							loc = tc.firstChild.nodeValue;
						} else if (tc.nodeName == 'info') {
							inf = tc.firstChild.nodeValue;
						} else if (tc.nodeName == 'image') {
							img = tc.firstChild.nodeValue;
						} else if (tc.nodeName == 'identifier') {
							ide = tc.firstChild.nodeValue;
						}
						tc = tc.nextSibling;
					}
					playlistArray.push({title:ann,file:loc,link:inf,image:img,identifier:ide});
					tck = tck.nextSibling;
				}
			}
			tl = tl.nextSibling;
		}
	};

	
}