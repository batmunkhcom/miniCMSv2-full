<?
class DB{
	var $link;
	var $db;
	var $prefix;
	var $lang;
	
	function DB($var){
	
		global $lang;
		
		$this->db=$var;
		$this->lang=$lang;
		$this->prefix=$var['db_prefix'];
		$this->link=$this->mbm_connect();
		$this->mbm_select_db();
	}
	function mbm_connect(){
		if(!$link=@mysql_pconnect($this->db["db_host"],$this->db["db_user"],$this->db["db_pass"])){
			//$this->link=0;
			die("could not connect to database server".substr($this->db["db_user"],5));
		}
		return $this->link=$link;
	}
	function mbm_select_db(){
		if(!$result=@mysql_select_db($this->db["db_name"],$this->link)){
			//$result=0;
			die("could not connect to database".$this->db["db_user"]);
		}
		return $result;
	}
	function mbm_query($query){
		if(!$result=@mysql_query($query,$this->link)){
			$result=0;
		}
		
		return $result;
	}
	function mbm_result($result, $row_id, $field_name=NULL){
		global $censored_words,$BBCODE;
		
		if($field_name==NULL){
			$value=@mysql_result($result,$row_id);
		}else{
			$value=@mysql_result($result,$row_id,$field_name);
		}
		$value = stripslashes($value);
		$value = str_replace($censored_words[0],$censored_words[1],$value);
		$value = $BBCODE->parse_bbcode($value);
		
		return $value;
	}
	function mbm_close(){
		if(!$result=@mysql_close($this->link)){
			$result=0;
		}
		return $result;
	}
	function mbm_error(){
		if(!$result = @mysql_error()){
			$result=0;
		}
		return $result;
	}
	function mbm_num_rows($result){
		$total_rows=@mysql_num_rows($result);
		return $total_rows;
	}
	function mbm_total_rows($table='menus'){
		$q = "SELECT COUNT(*) FROM ".$this->prefix.$table."";
		$r = $this->mbm_query($q);
		return $this->mbm_result($r,0);
	}
	function mbm_insert_row($data,$tbl){
		global $lang; // daraa zasah $this->lang -d onooh
		
		$query = "INSERT INTO ".$this->prefix.$tbl." ";
		$keys = "(";
		$values = "(";
		foreach ($data as $key=>$value){
			$keys .= "`".$key."`,";
			$values .= "'".$this->mbm_sql_quote($value)."',";
		}
		$keys = substr($keys,0,-1).") ";
		$values = substr($values,0,-1).")";
		$query .= $keys." VALUES ".$values.";";
		//ug bichleg baazad bgaa esehiig shalgah
		$total_field = count($data);
		$q_check_inserted = "SELECT * FROM `".$this->prefix.$tbl."` WHERE ";
		$n=0;
		foreach($data as $k=>$v){
			if($k!='date_added'){
				$q_check_inserted .= "`".$k."`='".$v."'";
				if($n<($total_field-1)){
					$q_check_inserted .= " AND ";
				}
			}
		}
		
		$r_check_inserted = $this->mbm_query($q_check_inserted);
		// ug bichleg nemegdseniig shalgaad duuslaa
		
		if($this->mbm_num_rows($r_check_inserted)>0){
			$return_result = 2;
		}else{
			if(!$result=$this->mbm_query($query)){
				$return_result = 0;
			}else{
				$return_result = 1;
			}
		}
		return $return_result;
	}
	function mbm_update_row($data,$tbl,$id,$field='id'){
		$query = "UPDATE ".$this->prefix.$tbl." SET ";
		$values = "";
		foreach ($data as $key=>$value){
			$values .= "`".$key."`='".$this->mbm_sql_quote($value)."',";
		}
		$values = substr($values,0,-1);
		$query .= $values." WHERE `".$field."`='".$id."'";
		if(!$result=$this->mbm_query($query)){
			$return_result = 0;
		}else{
			$return_result = 1;
		}
		return $return_result;
	}
	function mbm_delete_row($id,$tbl){
		$query = "LOCK TABLES ".$this->prefix.$tbl." WRITE; ";
		foreach($id as $key=>$value){
			$query .= "DELETE FROM ".$this->prefix.$tbl." WHERE id='".$value."';";
		}
		$query .= "UNLOCK TABLES;";
		if(!$result=$this->mbm_query($query)){
			$result = 0;
		}
		return $result;
	}
	function mbm_fetch_row($result){
		
		/*
		if($rows=mysql_fetch_array($result)){
			return (string)$rows;
		}else{
			return "(string)";
		}
		*/
	}
	function mbm_get_field($field_value,$field_name,$to_get_fieldname,$tbl){
		$q="SELECT ".$to_get_fieldname." FROM ".$this->prefix.$tbl." WHERE ".$field_name."='".$field_value."'";
		$result=$this->mbm_query($q);
		if(!$this->mbm_result($result,0)){
			$field=0;
		}else{
			$field=$this->mbm_result($result,0);
		}
		return $field;
	}
	function mbm_insert_id(){
		return mysql_insert_id();
	}
	function mbm_field_name($result,$i=0){
		return mysql_field_name($result,$i);
	}
	function mbm_num_fields($result){
		return mysql_num_fields($result);
	}
	function mbm_check_field($fieldname='username',$fieldvalue='user',$tbl='users'){
		$q = "SELECT * FROM ".$this->prefix.$tbl." WHERE `".$fieldname."`='".$fieldvalue."' LIMIT 1";
		$r = $this->mbm_query($q);
		if($this->mbm_num_rows($r)==1){
			return 1; // ug field n bna gesen ug.
		}else{
			return 0; // ug field bhgui gesen ug.
		}
	}
	function mbm_show_select_options($tbl_name,$field="name",$value=0){
		$query = "SELECT * FROM ".$this->prefix.$tbl_name." ORDER BY ".$field;
		$r = $this->mbm_query($query);
		for($i=0;$i<$this->mbm_num_rows($r);$i++){
			$buf .= '<option value="'.$this->mbm_result($r,$i,"id").'" ';
			if($value==$this->mbm_result($r,$i,"id")){
				$buf .= 'selected ';
			}
			$buf .= '>'.$this->mbm_result($r,$i,$field).'</option>';
		}
		return $buf;
	}
	function mbm_get_max_field($value,$value_field,$max_field,$table){
		$q = "SELECT MAX(".$max_field.") FROM ".$this->prefix.$table." WHERE `".strtolower($value_field)."`='".$value."'";
		$r = $this->mbm_query($q);
		return $this->mbm_result($r,0);
	}
	
	function mbm_sql_quote( $value )
	{
		if( get_magic_quotes_gpc() )
		{
			  $value = stripslashes( $value );
		}
		//check if this function exists
		if( function_exists( "mysql_real_escape_string" ) )
		{
			  $value = mysql_real_escape_string( $value );
		}
		//for PHP version < 4.3.0 use addslashes
		else
		{
			  $value = addslashes( $value );
		}
		return $value;
	}

}
?>