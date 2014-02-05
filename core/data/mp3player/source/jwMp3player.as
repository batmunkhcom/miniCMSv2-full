//==============================================================================
// jwMp3player Class:
// contains all scripting of the mp3player
// linked to the jwMp3player MovieClip symbol
//==============================================================================


// shared class for loading and parsing of playlist
import jwPlaylist;
// system class for event delegation
import mx.utils.Delegate;
// system class for javascript interaction
import flash.external.ExternalInterface;



class jwMp3player extends MovieClip {
	
	// configuration variables
	private var configURL:String =  "http://lib.az.mn/data/mp3player/config.php";
	private var configXML:XML;
	private var configArray:Array = new Array( { 
				autostart:'false',
				shuffle:'false',
				repeat:'none',
				volume:'80',
				showdisplay:'false',
				showplaylist:'true',
				linktarget:'_self',
				backcolor:'0xffffff',
				frontcolor:'0x000000',
				lightcolor:'0xcc0000',
				jpgfile: undefined, 
				callback: undefined, 
				width:250, // these two vars are re-read in the
				height:300 // readConfigXML function to avoid 0's
	} );
	
	// playlist variables
	private var playlistURL:String = "playlist.php";
	private var playlistObj:jwPlaylist;
	private var playlistArray:Array;
	
	// sound variables
	public var soundState:String = "idle"; // can be idle,load,play,pause
	private var soundObj:Sound;
	private var soundPausePos:Number = 0;
	private var soundPlayPos:Number = 0;
	private var soundCurrent:Number = 0;
	private var soundRandom:Array = new Array();
	private var soundScrubInt:Number;
	private var soundVolumeScrubInt:Number;
	private var soundShowEQ:Boolean = false;
	private var soundEQStripes:Number;
	
	// cover loader and listener
	private var coverLoader:MovieClipLoader;
	private var coverListener:Object;
	
	
	// all sub-movieclips of the mp3player movieclip
	private var back:MovieClip;
	private var displayGlow:MovieClip;
	private var displayEQ:MovieClip;
	private var displayTitle:MovieClip;
	private var displayCover:MovieClip;
	private var displayMask:MovieClip;
	private var controlsPlay:MovieClip;
	private var controlsPause:MovieClip;
	private var controlsPrev:MovieClip;
	private var controlsNext:MovieClip;
	private var controlsProgress:MovieClip;
	private var controlsVolume:MovieClip;
	private var playlistGlow:MovieClip;
	private var playlistMask:MovieClip;
	private var playlistScroll:MovieClip;
	private var playlist:MovieClip;

	
	





	//==============================================================================
	// initialization functions:
	// 1. jwMp3player(): simple constructor
	// 2. readConfig(): loads and applies config xml
	// 3. readFile(): loads and applies file / playlist xml
	// 4. buildPlaylist(): return function of a playlist readFile()
	//==============================================================================




	// constructor
	function jwMp3player() {
		// check for config and playlist file
		if(_root.config != undefined) { configURL = _root.config; }
		if(_root.file != undefined) { playlistURL = _root.file; }
		if(_root.autostart != undefined) { configArray[0]['autostart'] = _root.autostart; }
		// set stage variables
		setStageVars();
		// get all config info
		readConfig();
		// set javascript control target
		if (ExternalInterface.available) {
			var scs:Boolean = ExternalInterface.addCallback("jsControl",this,jsPerformer);
		}
	};


	// stage variables and rightclick menu
	private function setStageVars() {			
		var newMenu:ContextMenu = new ContextMenu();
		newMenu.hideBuiltInItems();
		newMenu.customItems.push(new ContextMenuItem("Flash MP3 Player 2.3 by Jeroenwijering...",goTo));
		_root.menu = newMenu;
		function goTo() { getURL("http://www.jeroenwijering.com/?item=Flash_MP3_Player"); };
		Stage.scaleMode = "noScale";
		Stage.align = "TL";
		// width and height are also re-read here to avoid 0-0 sizes!
		configArray[0]['width'] = Stage.width;
		configArray[0]['height'] = Stage.height;
	};
	
	

	// read config xml
    private function readConfig() {
		// setup config xml
        configXML = new XML();
        configXML.ignoreWhite = true;
		configXML['parent'] = this;
        // parse data from xml
        configXML.onLoad = function(success:Boolean) {
        	if(success) {
            	var itm = this.firstChild.firstChild;
				while (itm != null) {
					this.parent.configArray[0][itm.nodeName] = itm.firstChild.nodeValue; 
					itm = itm.nextSibling;
				}
				trace(this.parent.configArray[0]['height']);
				if(this.parent.configArray[0]['height'] < 30) { this.parent.configArray[0]['showdisplay'] = 'false'; }
        	}  else {
				// just use the default values
			}
			// delete XML
            delete this.parent.configXML;
			// start playlist building
			this.parent.setSizesColorsButtons();
			this.parent.readFile();
        };
        // start loading XML from file
		configXML.load(configURL);
    };

	
	
	
	// read playlist or set single file (publicly accessible)
	public function readFile(fl:String) {
		if(fl) { playlistURL = fl; }
		// remove old playlist buttons (for extra playlist functionality)
		for(var i=0; i<playlistArray.length; i++) {
			playlist['button'+i].removeMovieClip();
		}
		playlistArray = new Array();
		// reset old sound object
		soundObj = new Sound();
		soundCurrent = 0;
		soundState = "idle";
		// check for single file
		if(playlistURL.substr(-4,4).toLowerCase() == '.mp3') {
			// set single file playlist
			var tit = playlistURL.substring(playlistURL.lastIndexOf('/')+1,playlistURL.length-4);
			playlistArray.push({title:tit,file:playlistURL,link:''});
			if(configArray[0]['autostart'] == 'true') { playSong(); }
		// if not, parse playlist
		} else {
			playlistObj = new jwPlaylist();
			playlistObj.addEventListener("read", Delegate.create(this, buildPlaylist));
			playlistObj.readPlaylist(playlistURL);
		}
	};

	
	
	
	// small return function that parses playlist object
	private function buildPlaylist(obj:Object) {
		playlistArray = obj.playlist;
		delete playlistObj;
		setPlaylistSizesColorsButtons();
		if(configArray[0]['showdisplay'] == 'true') { checkForCover(); }
		if(configArray[0]['autostart'] == 'true') { playSong(); }
	};








	//==============================================================================
	// javascript controls delegate function
	//==============================================================================




	function jsPerformer(func:String, param:String) {
		if (func == "pause") { playPause(); }
		else if (func == "play") { playSong(Number(param)); }
		else if (func == "scrub") { scrubSong(Number(param)); }
		else if (func == "volume") { setVolume(Number(param)); }
		else if (func == "link") { getLink(Number(param)); }
		else if (func == "load") { readFile(param); }
	};	
	
	
	





	//==============================================================================
	// all sound control functions are set here
	//==============================================================================




	// start playing first file
	public function playSong(i:Number) {
		playlist['button'+soundCurrent].back._alpha = 0;
		soundState = "load";
		soundPausePos = 0;
		if(i != undefined) { soundCurrent = i; }
		else if (configArray[0]['shuffle'] == 'true') { setRandomCurrent(); }
		playlist['button'+soundCurrent].back._alpha = 25;
		controlsPlay._visible = false;
		controlsPause._visible = true;
		// start the sound object
		soundObj = new Sound(this);
		soundObj['parent'] = this;
		// check shuffle config to see what to do when a song is finished
		soundObj.onSoundComplete = function() {
			this.parent.callBack("complete");
			if (this.parent.configArray[0]['repeat'] == 'all') { this.parent.nextSong(); } 
			else if (this.parent.configArray[0]['repeat'] == 'one') { this.parent.playSong(this.parent.soundCurrent); }
			else if (this.parent.configArray[0]['repeat'] == 'list' && 
					((this.parent.soundCurrent != this.parent.playlistArray.length - 1 && this.parent.configArray[0]['shuffle'] == "false") ||
					 this.parent.soundRandom.length != 0)) { this.parent.nextSong(); }
			else { this.parent.soundState = "idle"; }
		};
		// load album cover if any
		if(configArray[0]['showdisplay'] == 'true') { checkForCover(); }
		// load the file and set the volume
		soundObj.loadSound(playlistArray[soundCurrent]['file'],true);
		setVolume(Number(configArray[0]['volume']));
		soundObj.start();
		callBack("start");
	};

	

	
	// send callback if url is set
	private function callBack(action:String) {
		if(configArray[0]['callback'] != undefined) {
		trace(configArray[0]['callback']);
			var send_lv:LoadVars = new LoadVars();
    		send_lv.file = playlistArray[soundCurrent]['file'];
    		send_lv.title = playlistArray[soundCurrent]['title'];
    		send_lv.identifier = playlistArray[soundCurrent]['identifier'];
    		send_lv.playlist = playlistURL;
    		send_lv.action = action;
    		send_lv.sendAndLoad(configArray[0]['callback'],send_lv, "POST");
		}
		
	};



	// set a random current song to play
	private function setRandomCurrent() {
		// if just started, fill random array
		if(soundRandom.length == 0) {
			for(var k=0; k<playlistArray.length; k++) {
				soundRandom.push(k);
			}
		}
		// else get a random one
		var rd = random(soundRandom.length);
		soundCurrent = soundRandom[rd];
		soundRandom.splice(rd,1);
	};
	



	// pause/play current song	
	public function playPause() { 
		if (soundState == 'idle') {
			playSong();
			soundState = 'load';
		} else if(soundPausePos > 0) { 
			soundObj.start(soundPausePos);
			soundPausePos = 0;
			soundState = "play";
		} else {
			soundPausePos = soundObj.position/1000;
			soundObj.stop();
			soundState = "pause";
		}
	};
	
	
	
	
	// start next song
	private function nextSong() {
		if(configArray[0]['shuffle'] == 'true') {
			playSong();
		} else if (soundCurrent == playlistArray.length - 1) {
			playSong(0);
		} else {
			playSong(soundCurrent + 1);
		}
	};
	
	
	
	
	// start previous song
	private function prevSong() {
		if(configArray[0]['shuffle'] == 'true') {
			playSong(soundRandom[soundRandom.length-1]);
		} else if (soundCurrent == 0) {
			playSong(playlistArray.length-1);
		} else {
			playSong(soundCurrent - 1);
		}
	};
	
	
	
	
	// start scrubbing of the playbar
	private function startScrubbing() {
		soundScrubInt = setInterval(this,"scrubSong",40);
	};




	// stop scrubbing of the playbar
	private function stopScrubbing() {
		clearInterval(soundScrubInt);
	};




	// scrub to a certain position
	public function scrubSong(xm) {
		if( xm == undefined) {
			var xm = Math.round(controlsProgress.loa._xmouse/controlsProgress.loa._width*controlsProgress.loa._xscale);
		} else {
			xm = xm/(soundObj.duration/1000)*100;
		}
		if (xm > 0 && xm < 100) {  
			controlsProgress.tme._xscale = xm;
			soundObj.stop();
			soundObj.start(Math.round(soundObj.duration*xm/100000));
			soundState = "play";
			soundPausePos = 0;
		}
	};



	// start scrubbing of the volume bar
	private function startVolumeScrubbing() {
		soundVolumeScrubInt = setInterval(this,"scrubVolume",40);
	};
	
	
	
	
	// stop scrubbing of the volume bar
	private function stopVolumeScrubbing() {
		clearInterval(soundVolumeScrubInt);
	};
	
	
	
	// volume scrubbing interval function
	private function scrubVolume() {
		var xm = controlsVolume._xmouse;
 		var fx = controlsVolume.front._x;
		var fw = controlsVolume.front._width;
		var vl = Math.round((xm-fx)/fw*100);
		setVolume(vl);
	};
	
	
	
	
	// set a certain volume
	public function setVolume(vl:Number) {
		if(vl >=0 && vl <=100) {
			configArray[0]['volume'] = vl;
			soundObj.setVolume(vl);
			controlsVolume.mask._width = vl/5;
		}
	};




	// get a link from the playlist
	public function getLink(i:Number) {
		getURL(playlistArray[i]['link'],configArray[0]['linktarget']);
	}








	//==============================================================================
	// all the interface-related stuff is set here
	//==============================================================================

	
	
	
	// set the display and controlbar colors, dimensions and button presses
	private function setSizesColorsButtons() {
		// extra reference to config array
		var configArray = this.configArray;
		// back image, size and color
		if(configArray[0]['jpgfile'] != undefined) {
			back.loadMovie(configArray[0]['jpgfile']);
			displayGlow._visible = false;
			playlistGlow._visible = false;
		} else {
			back._width = configArray[0]['width'];
			back.col = new Color(back);
			back.col.setRGB(configArray[0]['backcolor']);
			back._height = configArray[0]['height'];
		}
		// display sizes and colors
		if(configArray[0]['showdisplay'] == 'true') {
			displayGlow._width = configArray[0]['width'];
			displayMask._width = configArray[0]['width'] - 16;
			displayTitle.tf.textColor = configArray[0]['lightcolor'];
			displayTitle.tf.autoSize = true;
			setEqualizer();
			displayTitle.setMask(displayMask);
			displayCover.line.col = new Color(displayCover.line);
			displayCover.line.col.setRGB(configArray[0]['lightcolor']);
			addCoverLoader();
		} else {
			displayGlow._visible = displayEQ._visible = displayTitle._visible = displayMask._visible = false;
			controlsPlay._y = controlsPause._y = controlsNext._y = controlsPrev._y = controlsProgress._y = controlsVolume._y = 0;
			playlistGlow._y = 18;
			playlist._y = 19;
		}
		displayCover._visible = false;
		// play and pause buttons
		controlsPlay.icn.col = new Color(controlsPlay.icn);
		controlsPlay.icn.col.setRGB(configArray[0]['frontcolor']);
		controlsPause.icn.col = new Color(controlsPause.icn);
		controlsPause.icn.col.setRGB(configArray[0]['frontcolor']);
		controlsPause._visible = false;
		controlsPlay.onRollOver = controlsPause.onRollOver = function() { this.icn.col.setRGB(configArray[0]['lightcolor']); };
		controlsPlay.onRollOut = controlsPause.onRollOut =  function() { this.icn.col.setRGB(configArray[0]['frontcolor']); };
		controlsPlay.onPress = controlsPause.onPress = function() { this._parent.playPause(); }
		// hide next prev (will  be shown later if needed)
		controlsNext._visible = controlsPrev._visible = false;
		// progress bar
		controlsProgress._x -= 34;
		controlsProgress._width = configArray[0]['width'] - 56;
		controlsProgress.tme.col = new Color(controlsProgress.tme);
		controlsProgress.tme.col.setRGB(configArray[0]['frontcolor']);
		controlsProgress.loa.col = new Color(controlsProgress.loa);
		controlsProgress.loa.col.setRGB(configArray[0]['frontcolor']);
		controlsProgress.loa._xscale = controlsProgress.tme._xscale = 0;
		controlsProgress.loa.onRollOver = function() { this._parent.tme.col.setRGB(configArray[0]['lightcolor']); };
		controlsProgress.loa.onRollOut = function() { this._parent.tme.col.setRGB(configArray[0]['frontcolor']); };
		controlsProgress.loa.onPress = function() { this._parent._parent.startScrubbing(); }
		controlsProgress.loa.onRelease = controlsProgress.loa.onReleaseOutside = function() { this._parent._parent.stopScrubbing(); }
		// volume bar
		controlsVolume._x = configArray[0]['width'] - 38;
		controlsVolume.icn.col = new Color(controlsVolume.icn);
		controlsVolume.icn.col.setRGB(configArray[0]['frontcolor']);
		controlsVolume.front.col = new Color(controlsVolume.front);
		controlsVolume.front.col.setRGB(configArray[0]['frontcolor']);
		controlsVolume.back.col = new Color(controlsVolume.back);
		controlsVolume.back.col.setRGB(configArray[0]['frontcolor']);
		controlsVolume.back.onRollOver = function() { this._parent.front.col.setRGB(configArray[0]['lightcolor']); };
		controlsVolume.back.onRollOut = function() { this._parent.front.col.setRGB(configArray[0]['frontcolor']); };
		controlsVolume.back.onPress = function() { this._parent._parent.startVolumeScrubbing(); }
		controlsVolume.back.onRelease = controlsVolume.back.onReleaseOutside = function() { this._parent._parent.stopVolumeScrubbing(); }
		// hide playlist (will  be shown later if needed)
		playlistGlow._width = configArray[0]['width']; 
		playlistGlow._height = configArray[0]['height'] - playlistGlow._y;
		playlist._visible = playlist.button._visible = playlistGlow._visible = false;
		setInterval(this,"interfaceUpdater",200);
	};




	// set sizes and colors of playlist
	private function setPlaylistSizesColorsButtons() {
		// extra reference to config array
		var configArray = this.configArray;
		// prev/next buttons
		controlsPrev._visible = controlsNext._visible = true;
		controlsPrev.icn.col = new Color(controlsPrev.icn);
		controlsPrev.icn.col.setRGB(configArray[0]['frontcolor']);
		controlsNext.icn.col = new Color(controlsNext.icn);
		controlsNext.icn.col.setRGB(configArray[0]['frontcolor']);
		controlsPrev.onRollOver = controlsNext.onRollOver = function() { this.icn.col.setRGB(configArray[0]['lightcolor']); };
		controlsPrev.onRollOut = controlsNext.onRollOut =  function() { this.icn.col.setRGB(configArray[0]['frontcolor']); };
		controlsPrev.onPress = function() { this._parent.prevSong(); }
		controlsNext.onPress = function() { this._parent.nextSong(); }
		// progress bar
		controlsProgress._width = configArray[0]['width'] - 90;
		controlsProgress._x = 52;
		// iterate playlist sizes, colors and rollovers
		if((configArray[0]['showplaylist'] == 'true')) {
			playlist._visible = playlistGlow._visible = true;
			for(var i=0; i<playlistArray.length; i++) {
				// duplicate buttons and set size/color
				playlist.button.duplicateMovieClip('button'+i,i);
				var tgt = playlist['button'+i];
				tgt._y = i*20;
				tgt.tf._width = configArray[0]['width'] - 12;
				tgt.tf.text = playlistArray[i]['title'];
				tgt.back._width = configArray[0]['width'] - 2;
				tgt.glow._width = configArray[0]['width'] - 2;
				tgt.tf.textColor = configArray[0]['frontcolor'];
				tgt.back._alpha = 0;
				tgt.back.col = new Color(tgt.back);
				tgt.back.col.setRGB(configArray[0]['lightcolor']);
				tgt.back._alpha = 0;
				// set button functions
				tgt.back.onRollOver = function() { this._parent.tf.textColor = configArray[0]['lightcolor']; };
				tgt.back.onRollOut = function() { this._parent.tf.textColor = configArray[0]['frontcolor']; };
				tgt.back.onPress = function() { this._parent._parent._parent.playSong(this._parent.getDepth()); };	
				// set link functions
				if (playlistArray[i]['link'].length > 4) {
					tgt.link._x = configArray[0]['width'] - 22;
					tgt.link.col = new Color(tgt.link);
					tgt.link.col.setRGB(configArray[0]['frontcolor']);
					tgt.link.onRollOver = function() { this.col.setRGB(configArray[0]['lightcolor']); };
					tgt.link.onRollOut = function() { this.col.setRGB(configArray[0]['frontcolor']); };
					tgt.link.onPress = function() { this._parent._parent._parent.getLink(this._parent.getDepth()); };	
				} else {
					tgt.link._visible = false;
				}
			}
			if(playlist._height > playlistGlow._height) { 
				init_scroller();
				playlistGlow.duplicateMovieClip("playlistMask",1);
				playlist.setMask(playlistMask);
			} else {
				playlistScroll._visible = false;
				playlist._y = playlistGlow._y + 1;
			}
		}
	};


	// make room for scrollbar in playlist and setup scroller sizes, colors.
	private function init_scroller() {
		var configArray = this.configArray;
		var frt:MovieClip = playlistScroll.front;
		var playlist = this.playlist;
		// shorten all buttons ten pixels
		for(var i=0; i<playlistArray.length; i++) {
			var tgt = playlist['button'+i];				
			tgt.tf._width = configArray[0]['width'] - 21;
			tgt.back._width = configArray[0]['width'] - 11;
			tgt.glow._width = configArray[0]['width'] - 11;
			tgt.link._x = configArray[0]['width'] - 31;
		}
		// set sizes and colors
		playlistScroll._x = configArray[0]['width'] - 10;
		playlistScroll._y = playlistGlow._y + 3;
		playlistScroll.back._height = playlistGlow._height - 6;
		playlistScroll.back.col = new Color(playlistScroll.back);
		playlistScroll.back.col.setRGB(configArray[0]['frontcolor']);
		playlistScroll.front._height = Math.round(playlistScroll.back._height*playlistGlow._height/playlist._height);
		playlistScroll.front.col = new Color(playlistScroll.front);
		playlistScroll.front.col.setRGB(configArray[0]['frontcolor']);
		// init scroller functions
		var scl = playlist._height/playlistScroll.back._height;
		playlistScroll.back.onRollOver = playlistScroll.front.onRollOver = function() { 
			frt.col.setRGB(configArray[0]['lightcolor']);
		};
		playlistScroll.back.onRollOut = playlistScroll.front.onRollOut = function() { 
			frt.col.setRGB(configArray[0]['frontcolor']);
		};
		playlistScroll.back.onPress = function() {
			if(this._parent._ymouse < frt._y) { 
				if(frt._y < frt._height/4) { 
					frt._y = 0;
					playlist._y = this._parent._y; 
				} else {
					frt._y -= frt._height/4;
					playlist._y += Math.round(scl*frt._height/4);
				}
			} else {
				if(frt._y > this._height - frt._height*1.25) {
					frt._y = this._height - frt._height;
					playlist._y = this._parent._y + this._parent._height - playlist._height + 2;
				} else {
					frt._y += frt._height/4;
					playlist._y -= Math.round(scl*frt._height/4);
				}
			}
		};
		playlistScroll.front.onPress = function() {
			this.startDrag(false,0,0,0,this._parent.back._height-this._height);
			this.onEnterFrame = function() {
				if(this._y == 0) { 
					playlist._y = this._parent._y; 
				} else if ( this._y == this._parent.back._height-this._height) {
					playlist._y = this._parent._y + this._parent._height - playlist._height + 2;
				} else { 
					playlist._y = -scl*(this._y - this._parent.back._y) + this._parent._parent.playlistGlow._y;
				}
			};
		};
		playlistScroll.front.onRelease = playlistScroll.front.onReleaseOutside  = function() {
			this.stopDrag();
			delete this.onEnterFrame;
		};
	};
	



	// set correct display title / scrubbars / equalizer height
	private function interfaceUpdater() {
		// get title info
		var txt = '<font color="#'+configArray[0]['lightcolor'].substring(2,8)+'">';
		txt += '<b>'+playlistArray[soundCurrent]['title']+'</b> ';
		// show loading progress
		var pcl = Math.round(soundObj.getBytesLoaded()/soundObj.getBytesTotal()*100);
		controlsProgress.loa._xscale = pcl;
		// set all items for idle display
		if(soundState == 'idle') {
			soundShowEQ = false;
			soundPausePos = 0;
			controlsProgress.tme._xscale = 0;
			controlsPlay._visible = true;
			controlsPause._visible = false;
		} else if(soundState == 'load' || soundState == 'play') {  
			soundShowEQ = false; 
			controlsPlay._visible = false;
			controlsPause._visible = true;
			// show playing progress
			var pcp = Math.round(soundObj.position/soundObj.duration*pcl);
			controlsProgress.tme._xscale = pcp;
			// show eq if sound plays during loading
			var pp = soundObj.position;
			if(pp > soundPlayPos) { soundShowEQ = true; }
			soundPlayPos = pp;
			// switch display to play is loaded is 100%
			if(pcl > 99) { 
				soundState = "play";
				var posm = int((soundObj.position/1000)/60);
				var poss = int((soundObj.position/1000)%60);
				var durm = int((soundObj.duration/1000)/60);
				var durs = int((soundObj.duration/1000)%60); 
		 		txt += '- '+checkD(posm)+':'+checkD(poss)+'/'+checkD(durm)+':'+checkD(durs)+'   ';
			} else {
				soundState = "load";
				if(isNaN(pcl)){ pcl = 0; }
				txt += '- '+pcl+'% loaded   ';
			}
		} else if (soundState == 'pause') {
			soundShowEQ = false; 
			controlsPlay._visible = true;
			controlsPause._visible = false;
			txt += '- paused   ';
		}
		// assign title text to display
		displayTitle.tf.htmlText  = txt +'</font>';
		// if the displayTitle is too wide, scroll it
		if(displayTitle._width > displayMask._width) {
			displayTitle.tf.htmlText  = txt+txt;
			displayTitle.onEnterFrame = function() {
				this._x--;
				if(this._x < 8 - this._width/2) {
					this._x = 4;
				}
			};
		} else { 
			displayTitle._x = displayMask._x;
			delete displayTitle.onEnterFrame;
		}
	};


	

	// prefixing a 0 to the time
	private function checkD(toCheck:Number) {
		if(toCheck<10) { return "0"+toCheck } else { return toCheck; }
	};




	// playlist scrolling function
	private function scrollPlaylist() {
		// duplicate the glow to use as a mask
		playlistGlow.duplicateMovieClip("playlistMask",1);
		playlist.setMask(playlistMask);
		// set an enterframe function for the scrolling
		playlistGlow.onEnterFrame = function() {
			// scroll playlist if needed
			if(this.hitTest(_root._xmouse,_root._ymouse) == true) {
				// determine relative mouse position
				var mpos = this._ymouse/this._height*this._yscale*0.02 - 1;
				// determine max, min and current playlist _y
				var ply = this._parent.playlist._y;
				var maxy = this._y + 2;
				var miny = this._y - this._parent.playlist._height + this._height - 1;
				if( ply >  maxy - 5 && mpos < 0) {
					this._parent.playlist._y = maxy;
				} else if (ply < miny + 5 && mpos > 0) {
					this._parent.playlist._y = miny;
				} else {
					this._parent.playlist._y -= Math.floor(mpos*15);
				}
			}
		};
	};




	// equalizer setup function
	private function setEqualizer() {
		// determine width of eq
		soundEQStripes = Math.floor((configArray[0]['width'] - 16)/6);
		// make a duplicate of both mask and stripes
		displayEQ.stripes.duplicateMovieClip("stripes2",1);
		displayEQ.mask.duplicateMovieClip("mask2",3);
		// set colors and sizes
		displayEQ.stripes._width = displayEQ.stripes2._width = configArray[0]['width'] - 16;
		displayEQ.stripes.top.col = new Color(displayEQ.stripes.top);
		displayEQ.stripes.top.col.setRGB(configArray[0]['lightcolor']);
		displayEQ.stripes.bottom.col = new Color(displayEQ.stripes.bottom);
		displayEQ.stripes.bottom.col.setRGB(configArray[0]['frontcolor']);
		displayEQ.stripes2.top.col = new Color(displayEQ.stripes2.top);
		displayEQ.stripes2.top.col.setRGB(configArray[0]['lightcolor']);
		displayEQ.stripes2.bottom.col = new Color(displayEQ.stripes2.bottom);
		displayEQ.stripes2.bottom.col.setRGB(configArray[0]['frontcolor']);
		// apply masking
		displayEQ.stripes.setMask(displayEQ.mask);
		displayEQ.stripes2.setMask(displayEQ.mask2);
		// set alpha for a nice fade
		displayEQ.stripes._alpha = displayEQ.stripes2._alpha = 50;
		// start the drawing functions
		setInterval(this,"drawEqualizerFrame",80,displayEQ.mask);
		setInterval(this,"drawEqualizerFrame",80,displayEQ.mask2);
	};




	// equalizer frame drawer
	private function drawEqualizerFrame(tgt:MovieClip) {
		tgt.clear();
	    tgt.beginFill(0x000000, 100);
		tgt.moveTo(0,0);
		if(soundShowEQ == true) { var h = Math.round(configArray[0]['volume']/6); } 
		else { var h = 0; }
		for (var j=0; j< soundEQStripes; j++) {
			var z = random(h)+h/2 + 2;
			if(j == Math.floor(soundEQStripes/2)) { z = 0; }
			tgt.lineTo(j*6,-1);
			tgt.lineTo(j*6,-z);
			tgt.lineTo(j*6+4,-z);
			tgt.lineTo(j*6+4,-1);
			tgt.lineTo(j*6,-1); 
		}
		tgt.lineTo(j*6,0);
		tgt.lineTo(0,0);
		tgt.endFill();
	};
	
	
	
	
	// set Cover MovieClipLoader and resizer
	private function addCoverLoader() {
		coverLoader = new MovieClipLoader();
		coverListener = new Object();
		coverListener['tgt'] = displayCover.image.loader;
		coverLoader.addListener(coverListener);
		coverListener.onLoadInit = function() {
			this.tgt._xscale = this.tgt._yscale = 100;
			if(this.tgt._width < this.tgt._height) {
				var scl = Math.ceil(4000/this.tgt._width);
			} else { 
				var scl = Math.ceil(4000/this.tgt._height);
			}
			this.tgt._xscale = this.tgt._yscale = scl;
			this.tgt._x = 20 - this.tgt._width/2;
			this.tgt._y = 20 - this.tgt._height/2;
		};
	};
	
	
	
	
	// cover art (un)setter
	private function checkForCover() {
		if(playlistArray[soundCurrent]['image']) {
			displayCover._visible = true;
			displayCover.image.setMask(displayCover.mask);
			displayCover.image.loader.clear();
			coverLoader.loadClip(playlistArray[soundCurrent]['image'],displayCover.image.loader);
			displayMask._x = 60;
			displayEQ._x = 60;
			displayMask._width = configArray[0]['width'] - 70;
			displayEQ.stripes._width = displayEQ.stripes2._width = configArray[0]['width'] - 68;
			soundEQStripes = Math.floor((configArray[0]['width'] - 66)/6);
		} else {
			displayCover._visible = false;
			displayMask._x = 10;
			displayEQ._x = 12;
			displayMask._width = configArray[0]['width'] - 20;
			displayEQ.stripes._width = displayEQ.stripes2._width = configArray[0]['width'] - 18;
			soundEQStripes = Math.floor((configArray[0]['width'] - 16)/6);
		}
	};
	
	
}