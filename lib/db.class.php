<?
class db{
	static $memcache_server = array();
	static $memcache = false;
	static $db_set = array();
	static $db = false;
	static $config = array();
	function __construct()
	{
	  if(self::$db_set) return;
		$_config = conf();
		self::$config = $_config;
		self::$db_set = $_config['mysql'];
		self::$memcache_server = $_config['memcache'];
	}
	
	/* db */
	function db_conn()
  {
  	self::$db = new mysqli(self::$db_set['host'],self::$db_set['user'],self::$db_set['pass']);

  	if(isset(self::$db_set['db'])) self::$db -> select_db(self::$db_set['db']);
  	if(isset(self::$db_set['lang'])) self::db_query("SET NAMES '".self::$db_set['lang']."'");
  	if(!self::$db)
  	{
  	  echo 'connect mysql error';
  	  exit;
  	}
  }

  function db_get($table,$key,$order='',$show_sql=false)
  {
    if(!self::$db) $this -> db_conn();
    if(is_array($key) && count($key) > 0)
    {
      foreach($key as $k => $v)
      {
        $k = $this -> db_quote($k);
        $v = $this -> db_quote($v);
        if(preg_match('/^sql/',$k)) $where[] = $v;
        else $where[] = '`'.$k.'` = "'.$v.'"';
      }
      $where = ' where '.join(' and ',$where);
  	}
  	else if($key != '')
    {
      $where = ' where '.$key;
    }
    
    if($order != '') $order = ' order by '.$order;
    
    $sql = "select * from `".$table."` ".$where." ".$order;
    if($show_sql) echo $sql;
    $res = $this -> db_query($sql);
    $ret = $res -> fetch_assoc();
    
    $fields = self::get_fields($table);
    foreach($fields as $k => $v)
    {
      if(preg_match('/^json/',$v['Comment']) && $ret[$v['Field']] != '') $ret[$v['Field']] = json_decode($ret[$v['Field']],1);
    }
    return $ret;
  }
  
  function db_count($table,$key='',$show_sql=false)
  {
    if(!self::$db) $this -> db_conn();
    $where = '';
    if(is_array($key) && count($key) > 0)
    {
      foreach($key as $k => $v)
      {
        if(preg_match('/^sql/',$k))
        {
          $where[] = $v;
        }
        else
        {
          $k = self::db_quote($k);
          $v = self::db_quote($v);
          $where[] = '`'.$k.'` = "'.$v.'"';
        }
        
      }
      $where = 'where '.join(' and ',$where);
    }
    else if($key != '')
    {
      $where = ' where '.$key;
    }
    $sql = "select count(*) as c from `".$table."` ".$where;
    
    if($show_sql)echo $sql.'<br>';
    //echo $sql;
    $res = $this -> db_query($sql);
    $data = $res -> fetch_assoc();
    return $data['c'];
  }
	
	function db_gets_list($table,$key='',$order='',$limit='unlimit',$show_sql=false)
  {
    if(!self::$db) $this -> db_conn();
    $where = '';
    if(is_array($key) && count($key) > 0)
    {
      foreach($key as $k => $v)
      {
        if(preg_match('/^sql/',$k))
        {
          $where[] = $v;
        }
        else
        {
          $k = self::db_quote($k);
          $v = self::db_quote($v);
          $where[] = '`'.$k.'` = "'.$v.'"';
        }
      }
      $where = ' where '.join(' and ',$where);
    }
    else if($key != '')
    {
      $where = ' where '.$key;
    }
    
    if($order != '') $order = ' order by '.$order;
    
    if($limit == 'unlimit') $limit = '';
    else $limit = ' limit '.$limit;
    
    $sql = "select uid from `".$table."` ".$where." ".$order.$limit;
    if($show_sql) echo "\n".$sql."\n";
    
    $res = self::db_query($sql);
    if(!$res) return false;
    
    $ret = false;
    while($data = $res -> fetch_assoc()) $ret[$data['uid']] = $data['uid'];
    return $ret;
  }
	
  function db_gets($table,$key='',$order='',$limit='unlimit',$show_sql=false)
  {
    if(!self::$db) $this -> db_conn();
    $where = '';
    if(is_array($key) && count($key) > 0)
    {
      foreach($key as $k => $v)
      {
        if(preg_match('/^sql/',$k))
        {
          $where[] = $v;
        }
        else
        {
          $k = $this -> db_quote($k);
          $v = $this -> db_quote($v);
          $where[] = '`'.$k.'` = "'.$v.'"';
        }
      }
      $where = ' where '.join(' and ',$where);
    }
    else if($key != '')
    {
      $where = ' where '.$key;
    }
    
    if($order != '') $order = ' order by '.$order;
    
    if($limit == 'unlimit') $limit = '';
    else $limit = ' limit '.$limit;
    
    $sql = "select * from `".$table."` ".$where." ".$order.$limit;
    if($show_sql) echo "\n".$sql."\n";
    //echo "\n".$sql."<br>\n";
    
    $res = $this -> db_query($sql);
    if(!$res) return false;
    
    $fields = self::get_fields($table);
    foreach($fields as $k => $v)
    {
      if(preg_match('/^json/',$v['Comment'])) $json_fields[$v['Field']] = $v['Field'];
    }
    
    $ret = false;
    while($data = mysqli_fetch_assoc($res))
    {
      if($json_fields)
      {
        foreach($json_fields as $k => $v) $data[$v] = json_decode($data[$v],1);
      }
      $ret[] = $data;
    }
    return $ret;
  }
  
  function db_ins($table,$data,$show_sql=false)
  {
    if(!self::$db) $this -> db_conn();
    
    $fields = self::get_fields($table);
    if(!$fields) return false;
    if(!is_array($data)) return false;
    
    foreach($fields as $k => $v)
    {
      if($v['Field'] == 'cdate') $data[$v['Field']] = date('Y-m-d H:i:s');//建立時間
      if(!$data[$v['Field']]) continue;
      if(preg_match('/^json/',$v['Comment'])) $data[$v['Field']] = json_encode($data[$v['Field']]);
     
  		$sql_1[] .= "`".$this -> db_quote($v['Field'])."`";
  		$sql_2[] .= "'".$this -> db_quote($data[$v['Field']])."'";
    }
    $sql = "INSERT INTO `".$table."` (".join(',',$sql_1).") VALUES (".join(',',$sql_2).")";
  	
  	$ins_id = 0;
  	$res = $this -> db_query($sql);
  	$ret = self::$db -> insert_id;
  	
  	if($show_sql) echo $ret."\n".$sql."\n";
  	return $ret;
  }
  
  function db_upd($table,$data,$key,$show_sql = false)
  {
    if(!self::$db) $this -> db_conn();
    $fields = self::get_fields($table);
    foreach($fields as $k => $v)
    {
      if(preg_match('/^json/',$v['Comment'])) $json_fields[$v['Field']] = $v['Field'];
    }
    
    if(!$fields) return false;
    
    $where = '';
    if(is_array($key) && count($key) > 0)
    {
      foreach($key as $k => $v)
      {    
        $k = $this -> db_quote($k);
        $v = $this -> db_quote($v);
        $where[] = $k.'="'.$v.'"';
      }
      $where = 'where '.join(' and ',$where);
    }
    else if($key != '')
    {
      $where = ' where '.$key;
    }
    else
    {
      return false;
    }
  
    if(!is_array($data)) return false;
  	
  	$sql = "";
  	foreach($data as $k => $v)
  	{
      if($json_fields[$k]) $v = json_encode($v);
  	  $k = $this -> db_quote($k);
      $v = $this -> db_quote($v);
  		$sql .= "`".$k."` = '".$v."',";
  	}
  	$sql = substr($sql,0,-1);
  	$sql = "update `".$table."` set ".$sql." ".$where;
  	if($show_sql) echo $sql.";\n<br>";
  	$ret = $this -> db_query($sql);
  }
  
  function db_del($table,$key)
  {
    if(!self::$db) $this -> db_conn();
    $where = '';
    if(is_array($key) && count($key) > 0)
    {
      foreach($key as $k => $v)
      {
        $k = $this -> db_quote($k);
        $v = $this -> db_quote($v);
        $where[] = $k.'="'.$v.'"';
      }
      $where = 'where '.join(' and ',$where);
    }
    if($where == '') return false;
  	
    $sql = "delete from `".$table."` ".$where;
    $this -> db_query($sql);
  }
  
  function db_quote($str)
  {
    if(!self::$db) $this -> db_conn();
    if(is_array($str))
    {
      foreach($str as $k => $v)
      {
        $ret[$k] = self::$db -> real_escape_string($v);
      }
      return $ret;
    }
    else
    {
      return self::$db -> real_escape_string($str);
    }
  }
  
  function db_query($sql)
  {
    if(!self::$db) $this -> db_conn();
    $res = self::$db -> query($sql);
    return $res;
  }
  
	function db_fetch($sql,$fields = false)
  {
    if($fields)
	  {
  	  foreach($fields as $k => $v)
      {
        if(preg_match('/^json/',$v['Comment'])) $json_fields[$v['Field']] = $v['Field'];
      }
    }
    
    $res = $this -> db_query($sql);
    if(!$res) return false;
    
    $ret = false;
    while($data = mysqli_fetch_assoc($res))
    {
      if($json_fields)
      {
        foreach($json_fields as $k => $v) $data[$v] = json_decode($data[$v],1);
      }
      $ret[] = $data;
    }
    return $ret;
  }
  
	function get_fields($table)
	{
	  $sql = 'show FULL fields from `'.$table.'`';
	  //echo $sql."\n";
	  $res = self::db_query($sql);
	  while($data = $res -> fetch_assoc()) $ret[] = $data;
	  return $ret;
	}
	/* memcache */
	function mem_connect(){
		if(self::$memcache) return true;
		self::$memcache = new Memcache;
		if(count(self::$memcache_server) > 1)
		{
  		foreach(self::$memcache_server as $k => $v)
  		{
  			self::$memcache -> addServer($v['host'],$v['port']);
  		}
  		return;
	  }
		self::$memcache -> connect(self::$memcache_server[0]['host'], self::$memcache_server[0]['port']);
	}
	
	function mem_set($key,$data,$expire=86400){
	  if(!self::$memcache) self::mem_connect();
	  //if($_GET['max_debug']) echo '<div class=cache_debug key='.$key.'>mem_set:'.$key.'</div>';
		self::$memcache -> set($key,$data,false,$expire);
	}
	
	function mem_get($key){
	  if(!self::$memcache) self::mem_connect();
		$res = self::$memcache -> get($key);
		if($res && $_GET['max_debug']) echo '<div class=cache_debug key='.$key.'>mem_get:'.$key.'</div>';
		return $res;
	}
	
	function mem_del($key){
	  if(!self::$memcache) self::mem_connect();
		self::$memcache -> delete($key);
		if($_GET['max_debug']) echo '<div style="color:red">mem_del:'.$key.'</div>';
	}
	
	function mem_clear(){
	  if(!self::$memcache) self::mem_connect();
		self::$memcache -> flush();
	}
	
	function mem_stats(){
	  if(!self::$memcache) self::mem_connect();
		$data = self::$memcache -> getStats();
		return $data;
  }
	
	function mem_close(){
		self::$memcache -> close();
	}

}