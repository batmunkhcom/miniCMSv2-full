<?
function mbmShareThisPage($info=array()){
	$buf .= '<div style="margin-bottom:3px;">';
		$buf .= '<img src="http://s9.addthis.com/button1-share.gif" width="125" height="16" border="0" alt="share it" 
				onclick="window.open(\'';
				$buf .= 'http://www.addthis.com/bookmark.php?v=10&pub=batmunkh&url='
						.rawurlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'])
						.'&title='.$info['title'];
				$buf .= '\',\'ShareIt\',\'scrollbars=1,width=500,height=500\')" style="cursor:pointer;" />';
	$buf .= '</div>';
	
	return $buf;
}

function mbmAddRSSPage($info=array(
									'content_type'=>'video'
								  )
					   ){
	global $lang;
	
	$buf .= '<div style="margin-bottom:3px;">';
		$buf .= '<!-- AddThis Feed Button BEGIN -->
				 <a href="#" onclick="window.open(\'http://www.addthis.com/feed.php?pub=batmunkh&t1=&h1='.rawurlencode(DOMAIN).'rss.php%3Faction%3Dcontent%26type%3D'.$info['content_type'].'\',\'RSS_'.$info['content_type'].'\',\'height=500,width=500,scrollbars=1\'); return false;">
				 <img src="http://s9.addthis.com/button1-rss.gif" width="125" height="16" border="0" alt="'.$lang["main"]["rss_".$info['content_type']].'" /></a>
				 <!-- AddThis Feed Button END -->
				';
	$buf .= '</div>';
	
	return $buf;
}

function mbmSend2Friend(){

	global $lang;

	$buf = '<div style="margin-bottom:3px; position:relative;" >';
		$buf .= '<img src="'.INCLUDE_DOMAIN.'images/icons/icon_send2friend_'.$_SESSION['ln'].'.png" border="0" onclick="mbmToggleDisplay(\'send2Friend\'); document.getElementById(\'videoEmbedCode\').style.display=\'none\';" />';
	
		$buf .= '<div id="send2Friend">';
			$buf .= '<form id="send2FriendForm" name="send2FriendForm" action="" method="POST"
				onsubmit="mbmLoadXML(\'GET\',\'xml.php?action=send2friend&email_to=\'+escape(encodeURI(this.send2Friend_emailto.value))+\'&email_from=\'+escape(encodeURI(this.send2Friend_emailfrom.value))+\'&url='.base64_encode(DOMAIN.DIR.'index.php?'.$_SERVER['QUERY_STRING']).'&type=send&name_from=\'+escape(encodeURI(this.send2Friend_name.value)),mbmSendToFriend);
				return false;">';
			$buf .= '<div id="send2Friend_title">'.$lang["main"]["send2friend_title"].'</div>';
			$buf .= '<div id="send2Friend_name_">'.$lang["main"]["send2friend_name_from"].':<br />
						<input type="text" class="send2Friend_input" name="send2Friend_name" id="send2Friend_name">
					</div>';
			$buf .= '<div id="send2Friend_emailfrom_">'.$lang["main"]["send2friend_email_from"].':<br />
						<input type="text" class="send2Friend_input" name="send2Friend_emailfrom" id="send2Friend_emailfrom">
					</div>';
			$buf .= '<div id="send2Friend_emailto_">'.$lang["main"]["send2friend_email_to"].':<br />
						<input type="text" class="send2Friend_input" name="send2Friend_emailto" id="send2Friend_emailto">
					</div>';
			$buf .= '<div id="send2Friend_submit_">
						<input type="submit" value="'.$lang["main"]["send"].'" class="send2Friend_submit" name="send2Friend_submit" id="send2Friend_submit">
						&nbsp;<input type="button" value="'.$lang["main"]["cancel"].'" class="send2Friend_submit" onclick="mbmToggleDisplay(\'send2Friend\')">
					</div>';
			$buf .= '</form>';
		$buf .= '</div>';
	$buf .= '</div>';
	return $buf;
}
function mbmScheduleAdd($var = array(
									'name_from'=>'',
									'name_to'=>'',
									'email_from'=>'',
									'email_to'=>'',
									'st'=>'',
									'subject'=>'',
									'content'=>'',
									'date_added'=>'',
									'date_sent'=>''
									)){
	global $DB2;
	
	$invitation_content  = str_replace("{FROM}",$var['name_from'],$var['content']);
	
	$data['name_from'] = strtoupper($var['name_from']);
	$data['name_to'] = strtoupper($var['name_to']);
	$data['email_from'] = ADMIN_EMAIL;
	$data['email_to'] = $var['email_to'];
	$data['st'] = $var['st'];
	$data['subject'] = $var['subject'];
	$data['content'] = str_replace("{TO}",$data['name_to'],$invitation_content);
	$data['date_added'] = $var['date_added'];
	$data['date_sent'] = $var['date_sent'];
	
	return $DB2->mbm_insert_row($data,'schedules');
}
?>