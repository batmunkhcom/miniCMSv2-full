<?
function mbmDicForm(){
	global $lang;
	
	$buf = '<form id="dicForm" name="dicForm" method="post" action="" 
				onsubmit="mbmLoadXML(\'GET\',\'xml.php?action=dic&word=\'+escape(encodeURI(this.q.value))+\'&limit=10&lang_id=\'+escape(encodeURI(this.type.value)),mbmDicWordResults);
				return false;">
				<div id="dicTitle">'.$lang["dic"]["Dictionary"].'</div><div id="dicResult" style="display:none;"></div>
                <div style="padding:5px;">
					<select name="type" id="type" class="input">
						<option value="2">'.$lang["dic"]["mongolian_english"].'</option>
						<option value="1">'.$lang["dic"]["english_mongolia"].'</option>
					  </select>
					  <br />
					  <input name="q" onfocus="if(this.value=\''.$lang["dic"]["keyword"].'\') this.value=\'\';" value="keyword" type="text" class="input" id="q" />
					  <input type="submit" 
					   name="getWord" id="getWord" value="'.$lang["dic"]["search"].'" class="button" />
				</div>
              </form>';

	return $buf;
}
function mbmDicEncycForm(){
	global $lang;
	
	$buf = '<form id="dicEncycForm" name="dicEncycForm" method="post" action="" 
				onsubmit="mbmLoadXML(\'GET\',\'xml.php?action=encyc&word=\'+escape(encodeURI(this.q.value))+\'&limit=1\',mbmEncycWordResults);
				return false;">
				<div class="talbarTitleYellow">'.$lang["dic"]["Encyclopedia"].'</div><div id="encycResult" style="display:none;"></div>
                <div style="padding:5px;">
					  <input name="q" value="keyword" type="text" class="input" id="q" size="30"
					  	 onfocus="if(this.value=\''.$lang["dic"]["keyword"].'\') this.value=\'\';" />
					  <input type="submit" name="getEncycWord" id="getWord" value="'.$lang["dic"]["search"].'" class="button" />
				</div>
              </form>';

	return $buf;
}
function mbmDicRandomWord($dic_lang_id=0,$limit=1){
	global $DB;
	
	$q = "SELECT * FROM ".PREFIX."dic_words WHERE id!=0 ";
	if($dic_lang_id!=0){
		$q .= "AND dic_lang_id='".$dic_lang_id."' ";
	}
	$q .= "ORDER BY RAND() LIMIT ".$limit;
}
?>