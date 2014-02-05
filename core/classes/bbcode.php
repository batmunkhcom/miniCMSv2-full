<?php
class BBCODE{
	var $tags;
	var $settings;
	function BBCODE(){
		$this->tags = array();
		$this->settings = array('enced'=>true);
		$this->mbmLoadBBCODE();
	}
	function mbmLoadBBCODE(){
	global $lang;
		$this->add_tag(array('Name'=>'b','HtmlBegin'=>'<span style="font-weight: bold;">','HtmlEnd'=>'</span>'));
		$this->add_tag(array('Name'=>'code','HtmlBegin'=>'<div class="code"><strong>Code:</strong><br />','HtmlEnd'=>'</div>'));
		//$this->add_tag(array('Name'=>'php','HtmlBegin'=>'highlight_txt(','HtmlEnd'=>',1)')); # turshih
		$this->add_tag(array('Name'=>'i','HtmlBegin'=>'<span style="font-style: italic;">','HtmlEnd'=>'</span>'));
		$this->add_tag(array('Name'=>'u','HtmlBegin'=>'<span style="text-decoration: underline;">','HtmlEnd'=>'</span>'));
		$this->add_tag(array('Name'=>'link','HasParam'=>true,'HtmlBegin'=>'<a href="%%P%%">','HtmlEnd'=>'</a>'));
		$this->add_tag(array('Name'=>'color','HasParam'=>true,'ParamRegex'=>'[A-Za-z0-9#]+','HtmlBegin'=>'<span style="color: %%P%%;">','HtmlEnd'=>'</span>','ParamRegexReplace'=>array('/^[A-Fa-f0-9]{6}$/'=>'#$0')));
		$this->add_tag(array('Name'=>'email','HasParam'=>true,'HtmlBegin'=>'<a href="mailto:%%P%%">','HtmlEnd'=>'</a>'));
		$this->add_tag(array('Name'=>'size','HasParam'=>true,'HtmlBegin'=>'<span style="font-size: %%P%%pt;">','HtmlEnd'=>'</span>','ParamRegex'=>'[0-9]+'));
		$this->add_tag(array('Name'=>'bg','HasParam'=>true,'HtmlBegin'=>'<span style="background: %%P%%;">','HtmlEnd'=>'</span>','ParamRegex'=>'[A-Za-z0-9#]+'));
		$this->add_tag(array('Name'=>'s','HtmlBegin'=>'<span style="text-decoration: line-through;">','HtmlEnd'=>'</span>'));
		$this->add_tag(array('Name'=>'align','HtmlBegin'=>'<div style="text-align: %%P%%">','HtmlEnd'=>'</div>','HasParam'=>true,'ParamRegex'=>'(center|right|left)'));
		$this->add_alias('url','link');
	}
	function get_data($name,$cfa = ''){
		if(!array_key_exists($name,$this->tags)) return '';
		$data = $this->tags[$name];
		if($cfa) $sbc = $cfa; else $sbc = $name;
		if(!is_array($data)){
			$data = preg_replace('/^ALIAS(.+)$/','$1',$data);
			return $this->get_data($data,$sbc);
		}else{
			$data['Name'] = $sbc;
			return $data;
		}
	}
	function change_setting($name,$value){
		$this->settings[$name] = $value;
	}
	function add_alias($name,$aliasof){
		if(!array_key_exists($aliasof,$this->tags) or array_key_exists($name,$this->tags)) return false;
		$this->tags[$name] = 'ALIAS'.$aliasof;
		return true;
	}
	function onparam($param,$regexarray){
		$param = replace_pcre_array($param,$regexarray);
		if(!$this->settings['enced']){
			$param = htmlentities($param);
		}
		return $param;
	}
	function export_definition(){
		return serialize($this->tags);
	}
	function import_definiton($definition,$mode = 'append'){
		switch($mode){
			case 'append':
			$array = unserialize($definition);
			$this->tags = $array + $this->tags;
			break;
			case 'prepend':
			$array = unserialize($definition);
			$this->tags = $this->tags + $array;
			break;
			case 'overwrite':
			$this->tags = unserialize($definition);
			break;
			default:
			return false;
		}
		return true;
	}
	function add_tag($params){
		if(!is_array($params)) return 'Paramater array not an array.';
		if(!array_key_exists('Name',$params) or empty($params['Name'])) return 'Name parameter is required.';
		if(preg_match('/[^A-Za-z]/',$params['Name'])) return 'Name can only contain letters.';
		if(!array_key_exists('HasParam',$params)) $params['HasParam'] = false;
		if(!array_key_exists('HtmlBegin',$params)) return 'HtmlBegin paremater not specified!';
		if(!array_key_exists('HtmlEnd',$params)){
			 if(preg_match('/^(<[A-Za-z]>)+$/',$params['HtmlBegin'])){
			 	$params['HtmlEnd'] = begtoend($params['HtmlBegin']);
			 }else{
			 	return 'You didn\'t specify the HtmlEnd parameter, and your HtmlBegin parameter is too complex to change to an HtmlEnd parameter.  Please specify HtmlEnd.';
			 }
		}
		if(!array_key_exists('ParamRegexReplace',$params)) $params['ParamRegexReplace'] = array();
		if(!array_key_exists('ParamRegex',$params)) $params['ParamRegex'] = '[^\\]]+';
		if(!array_key_exists('HasEnd',$params)) $params['HasEnd'] = true;
		if(array_key_exists($params['Name'],$this->tags)) return 'The name you specified is already in use.';
		$this->tags[$params['Name']] = $params;
		return '';
	}
	function parse_bbcode($text){
		foreach($this->tags as $tagname => $tagdata){
			if(!is_array($tagdata)) $tagdata = $this->get_data($tagname);
			$startfind = "/\\[{$tagdata['Name']}";
			if($tagdata['HasParam']){
				$startfind.= '=('.$tagdata['ParamRegex'].')';
			}
			$startfind.= '\\]/';
			if($tagdata['HasEnd']){
				$endfind = "[/{$tagdata['Name']}]";
				$starttags = preg_match_all($startfind,$text,$ignore);
				$endtags = substr_count($text,$endfind);
				if($endtags < $starttags){
					$text.= str_repeat($endfind,$starttags - $endtags);
				}
				$text = str_replace($endfind,$tagdata['HtmlEnd'],$text);
			}
			$replace = str_replace(array('%%P%%','%%p%%'),'\'.$this->onparam(\'$1\',$tagdata[\'ParamRegexReplace\']).\'','\''.$tagdata['HtmlBegin'].'\'');
			$text = preg_replace($startfind.'e',$replace,$text);
		}
		return $text;
	}
}
?>