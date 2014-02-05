<?php
/*
session to database.
*/

class session
{
	//holboltiin var
	var $conn;
	//session_tbl
	var $table = 'mbm3_sessions';
	//session tbl primary key
	var $primaryKey = 's_id';
	//session data
	var $data;
	//tsagiin zurguu
	var $tsagiin_zuruu;
	
	function sessionDb($config)
	{
		$this->__construct($config);
	}
	function __construct($config)
	{
		$this->init($config);
		session_set_save_handler(
							array(&$this, 'cOpen'),
							array(&$this, 'cClose'),
							array(&$this, 'cRead'),
							array(&$this, 'cWrite'),
							array(&$this, 'cDestroy'),
							array(&$this, 'cGc'));
							session_name('AZsuljee');
		session_cache_limiter('private, must-revalidate');
		session_start();
		$this->tsagiin_zuruu = time()+60*60;
	}
	function init($config)
	{
		foreach ((array)$config as $k => $v)
		{
			if (!$v)
			{
				continue;
			}
			$this->$k = $v;
		}
		$this->config = $config;
		return true;
	}

	function cOpen($save_path,$s_id)
	{
		return true;
	}
	function cClose()
	{
		return true;
	}
	function cRead($s_id)
	{
		$now_time = time()+$this->tsagiin_zuruu;

		$sql = "SELECT s_data FROM {$this->table} WHERE {$this->primaryKey}='$s_id' AND s_expire>$now_time";
		$rs = $this->conn->Execute($sql);

		if(!$rs || $rs->EOF)
		{
			return "";
		}
		else
		{
			return $rs->fields['s_data'];
		}
		return "";
	}
	function cWrite($s_id,$s_data)
	{
		$rec = $this->getData($s_id, $s_data);
		$sql = "SELECT {$this->primaryKey} FROM {$this->table} WHERE {$this->primaryKey}='$s_id'";
		$rs = $this->conn->Execute($sql);
		
		if(!$rs || $rs->EOF)
		{
			$rec[$this->primaryKey] = $s_id;
			$this->conn->AutoExecute("{$this->table}",$rec,"INSERT");
			if($this->conn->Affected_Rows())
			{
				return true;
			}
		}
		else
		{
			$this->conn->AutoExecute("{$this->table}",$rec,"UPDATE","{$this->primaryKey}='$s_id'");
			if($this->conn->Affected_Rows())
			{
				return true;
			}
		}
		return false;
	}
	function cDestroy($s_id)
	{
		$sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey}='$s_id'";
		$this->conn->Execute($sql);
		if($this->conn->Affected_Rows())
		{
			return true;
		}
		return false;
	}
	function cGc($life_time)
	{
		$now_time = time()+$this->tsagiin_zuruu+3600;
		$sql = "DELETE FROM {$this->table} WHERE s_expire < $now_time";
		$this->conn->Execute($sql);
		return intval($this->conn->Affected_Rows());
	}
	
	//写入session的数据,可根据需要修改
	function getData($s_id, $s_data)
	{
		global $C_SYS;
		//$this->conn = getConn();
		$C_SYS['login_expire'] = !intval($C_SYS['login_expire']) ? 3600 : $C_SYS['login_expire'];
		$expire = time()+$this->tsagiin_zuruu + $C_SYS['login_expire'] * 3600;

		$rec = array();
		//session的有效期
		$rec['s_expire'] = $expire;
		//session 数据
		$rec['s_data'] = $s_data;
		//其它自定义数据
		$rec['user_id'] = $_SESSION['user_id'];
		$rec['user_ip'] = getenv("REMOTE_ADDR");
		$rec['user_act'] = isset($GLOBALS['ACT']) ? $GLOBALS['ACT'] : '';
		$rec['user_code'] = isset($GLOBALS['CODE']) ? $GLOBALS['CODE'] : '';
		
		return $rec;
	}
}
?>