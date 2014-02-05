<?php
function begtoend($htmltag){
	return preg_replace('/<([A-Za-z]+)>/','</$1>',$htmltag);
}
function replace_pcre_array($text,$array){
	$pattern = array_keys($array);
	$replace = array_values($array);
	$text = preg_replace($pattern,$replace,$text);
	return $text;
}

function mbmBBCODEtextarea($postname='post',$bbcode_fieldname='message',$cols=35){
	global $lang;
?><script language="JavaScript" type="text/javascript">
<!--
// bbCode control by
// subBlue design
// www.subBlue.com

// Startup variables
var imageTag = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

// Helpline messages
b_help = "<?=$lang["bbcode"]["bbcode_b_help"]?>";
i_help = "<?=$lang["bbcode"]["bbcode_i_help"]?>";
u_help = "<?=$lang["bbcode"]["bbcode_u_help"]?>";
q_help = "<?=$lang["bbcode"]["bbcode_q_help"]?>";
c_help = "<?=$lang["bbcode"]["bbcode_c_help"]?>";
l_help = "<?=$lang["bbcode"]["bbcode_l_help"]?>";
o_help = "<?=$lang["bbcode"]["bbcode_o_help"]?>";
p_help = "<?=$lang["bbcode"]["bbcode_p_help"]?>";
w_help = "<?=$lang["bbcode"]["bbcode_w_help"]?>";
a_help = "<?=$lang["bbcode"]["bbcode_a_help"]?>";
s_help = "<?=$lang["bbcode"]["bbcode_s_help"]?>";
f_help = "<?=$lang["bbcode"]["bbcode_f_help"]?>";

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array();
bbtags[0] = '[b]';
bbtags[1] = '[/b]';
bbtags[2] = '[i]';
bbtags[3] = '[/i]';
bbtags[4] = '[u]';
bbtags[5] = '[/u]';
bbtags[6] = '[quote]';
bbtags[7] = '[/quote]';
bbtags[8] = '[code]';
bbtags[9] = '[/code]';
bbtags[10] = '[list]';
bbtags[11] = '[/list]';
bbtags[12] = '[list=]';
bbtags[13] = '[/list]';
bbtags[14] = '[img]';
bbtags[15] = '[/img]';
bbtags[16] = '[url]';
bbtags[17] = '[/url]';

imageTag = false;

// Shows the help messages in the helpline window
function helpline(help) {
	document.<?=$postname?>.helpbox.value = eval(help + "_help");
}


// Replacement for arrayname.length property
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}


function emoticon(text) {
	var txtarea = document.<?=$postname?>.<?=$bbcode_fieldname?>;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function bbfontstyle(bbopen, bbclose) {
	var txtarea = document.<?=$postname?>.<?=$bbcode_fieldname?>;

	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	storeCaret(txtarea);
}


function bbstyle(bbnumber) {
	var txtarea = document.<?=$postname?>.<?=$bbcode_fieldname?>;

	txtarea.focus();
	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1) { // Close all open tags & default button names
		while (bbcode[0]) {
			butnumber = arraypop(bbcode) - 1;
			txtarea.value += bbtags[butnumber + 1];
			buttext = eval('document.<?=$postname?>.addbbcode' + butnumber + '.value');
			eval('document.<?=$postname?>.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
		}
		imageTag = false; // All tags are closed including image tags :D
		txtarea.focus();
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text; // Get text selection
		if (theSelection) {
			// Add tags around selection
			document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			txtarea.focus();
			theSelection = '';
			return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		return;
	}
	
	// Find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				txtarea.value += bbtags[butnumber + 1];
				buttext = eval('document.<?=$postname?>.addbbcode' + butnumber + '.value');
				eval('document.<?=$postname?>.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
				imageTag = false;
			}
			txtarea.focus();
			return;
	} else { // Open tags
	
		if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
			txtarea.value += bbtags[15];
			lastValue = arraypop(bbcode) - 1;	// Remove the close image tag from the list
			document.<?=$postname?>.addbbcode14.value = "Img";	// Return button back to normal state
			imageTag = false;
		}
		
		// Open tag
		txtarea.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
		arraypush(bbcode,bbnumber+1);
		eval('document.<?=$postname?>.addbbcode'+bbnumber+'.value += "*"');
		txtarea.focus();
		return;
	}
	storeCaret(txtarea);
}

// From http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2) 
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

//-->
</script>
  <table border="0" cellpadding="3" cellspacing="1" width="100%" class="bbcodeTable">
	<!--
    <tr>
	  <td valign="top" class="bbcodeTitle" colspan="2">
	    <?=$lang["bbcode"]["L_MESSAGE_BODY"]?></td>
    </tr>
    //-->
	<tr> 
	  <td valign="top" class="bbcodeRow1"> 
      Smilies disabled.
	  <table width="100" border="0" align="center" cellpadding="5" cellspacing="0" style="display:none;">
    <tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}" class="bbcode_gensmall"><b><?=$lang["bbcode"]["L_EMOTICONS"]?></b></td>
				</tr>
				<!-- BEGIN smilies_row -->
				<tr align="center" valign="middle"> 
				  <!-- BEGIN smilies_col -->
				  <td><a href="javascript:emoticon('{smilies_row.smilies_col.SMILEY_CODE}')"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
				  <!-- END smilies_col -->
				</tr>
				<!-- END smilies_row -->
				<!-- BEGIN switch_smilies_extra -->
				<tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}"><span  class="bbcode_nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=250');return false;" target="_phpbbsmilies"  class="bbcode_nav"><?=$lang["bbcode"]["L_MORE_SMILIES"]?></a></span></td>
				</tr>
				<!-- END switch_smilies_extra -->
			  </table>
      </td>
	  <td valign="top" class="bbcodeRow2"><span class="bbcodeTitles"> <span class="bbcode_genmed"> </span> 
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		   
			<td>
            	<table border="0" cellspacing="2" cellpadding="0">
   	  <tr>
                    	<td><span class="bbcode_genmed"> 
                          <input type="button" class="bbcode_button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline('b')" />
                          </span></td>
                        <td><span class="bbcode_genmed"> 
                          <input type="button" class="bbcode_button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline('i')" />
                          </span></td>
                        <td><span class="bbcode_genmed"> 
                          <input type="button" class="bbcode_button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline('u')" />
                          </span></td>
                        <td><span class="bbcode_genmed"> 
                          <input type="button" class="bbcode_button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbstyle(6)" onMouseOver="helpline('q')" />
                          </span></td>
                        <td><span class="bbcode_genmed"> 
                          <input type="button" class="bbcode_button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbstyle(8)" onMouseOver="helpline('c')" />
                          </span></td>
                        <td><span class="bbcode_genmed"> 
                          <input type="button" class="bbcode_button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbstyle(10)" onMouseOver="helpline('l')" />
                          </span></td>
                        <td><span class="bbcode_genmed"> 
                          <input type="button" class="bbcode_button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onClick="bbstyle(12)" onMouseOver="helpline('o')" />
                          </span></td>
                        <td><span class="bbcode_genmed"> 
                          <input type="button" class="bbcode_button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onMouseOver="helpline('p')" />
                          </span></td>
                        <td><span class="bbcode_genmed"> 
                          <input type="button" class="bbcode_button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
                          </span>
                        </td>
                    </tr>
                </table>
            </td>
		  </tr>
		  <tr> 
			<td colspan="9"> <span class="bbcode_genmed"> &nbsp;<?=$lang["bbcode"]["L_FONT_COLOR"]?>: 
					<select name="addbbcode18" onChange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('s')">
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="{T_FONTCOLOR1}" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_DEFAULT"]?></option>
					  <option style="color:darkred; background-color: {T_TD_COLOR1}" value="darkred" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_DARK_RED"]?></option>
					  <option style="color:red; background-color: {T_TD_COLOR1}" value="red" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_RED"]?></option>
					  <option style="color:orange; background-color: {T_TD_COLOR1}" value="orange" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_ORANGE"]?></option>
					  <option style="color:brown; background-color: {T_TD_COLOR1}" value="brown" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_BROWN"]?></option>
					  <option style="color:yellow; background-color: {T_TD_COLOR1}" value="yellow" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_YELLOW"]?></option>
					  <option style="color:green; background-color: {T_TD_COLOR1}" value="green" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_GREEN"]?></option>
					  <option style="color:olive; background-color: {T_TD_COLOR1}" value="olive" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_OLIVE"]?></option>
					  <option style="color:cyan; background-color: {T_TD_COLOR1}" value="cyan" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_CYAN"]?></option>
					  <option style="color:blue; background-color: {T_TD_COLOR1}" value="blue" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_BLUE"]?></option>
					  <option style="color:darkblue; background-color: {T_TD_COLOR1}" value="darkblue" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_DARK_BLUE"]?></option>
					  <option style="color:indigo; background-color: {T_TD_COLOR1}" value="indigo" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_INDIGO"]?></option>
					  <option style="color:violet; background-color: {T_TD_COLOR1}" value="violet" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_VIOLET"]?></option>
					  <option style="color:white; background-color: {T_TD_COLOR1}" value="white" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_WHITE"]?></option>
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="black" class="bbcode_genmed"><?=$lang["bbcode"]["L_COLOR_BLACK"]?></option>
					</select> &nbsp;<?=$lang["bbcode"]["L_FONT_SIZE"]?>:<select name="addbbcode20" onChange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.selectedIndex=0;" onMouseOver="helpline('f')">
					  <option value="0" class="bbcode_genmed"><?=$lang["bbcode"]["L_FONT_SIZE"]?></option>
					  <option value="7" class="bbcode_genmed"><?=$lang["bbcode"]["L_FONT_TINY"]?></option>
					  <option value="9" class="bbcode_genmed"><?=$lang["bbcode"]["L_FONT_SMALL"]?></option>
					  <option value="12" selected class="bbcode_genmed"><?=$lang["bbcode"]["L_FONT_NORMAL"]?></option>
					  <option value="18" class="bbcode_genmed"><?=$lang["bbcode"]["L_FONT_LARGE"]?></option>
					  <option  value="24" class="bbcode_genmed"><?=$lang["bbcode"]["L_FONT_HUGE"]?></option>
					</select>
					</span> |
				  <span class="bbcode_gensmall"><a href="javascript:bbstyle(-1)" class="bbcode_genmed" onMouseOver="helpline('a')"><?=$lang["bbcode"]["L_BBCODE_CLOSE_TAGS"]?></a></span>
                  </td>
		  </tr>
		  <tr> 
			<td colspan="9"> <span class="bbcode_gensmall"> 
			  <input type="text" name="helpbox" size="45" maxlength="100" class="bbcode_input_help" value="<?=$lang["bbcode"]["L_STYLES_TIP"]?>" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="9"><span class="bbcodeTitles"> 
			  <textarea name="<?=$bbcode_fieldname?>" onfocus="if(this.value=='<?=$lang["bbcode"]["MESSAGE"]?>') this.value=''" rows="15" cols="<?=$cols?>" wrap="virtual" class="bbcode_textarea" tabindex="3" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"><?
			  if(isset($_POST[$bbcode_fieldname])){
			  	echo $_POST[$bbcode_fieldname];
			  }else{
			  	echo $lang["bbcode"]["MESSAGE"];
			  }
			?></textarea>
			  </span></td>
		  </tr>
		</table>
		</span></td>
	</tr>
  </table>
<?
}

?>