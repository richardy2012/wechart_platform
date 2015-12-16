<?php
include_once '../common/include-file.php';

/*
* MySql 单例
*/
class MySql{
	
    private $host    	= ''; 		//数据库主机
    private $port    	= ''; 		//数据库端口
    private $user     	= ''; 		//数据库用户名
    private $password  	= ''; 		//数据库用户名密码
    private $database 	= ''; 		//数据库名
    private $charset 	= 'utf8'; 	//数据库编码，GBK,UTF8,gb2312
    private $conn;             		//数据库连接标识;
    private $rows;             		//查询获取的多行数组
    private $pconnect 	= false;
    
    private $handle;
    private $is_log 	= false;
    private $time;
    static 	$_instance; 			//存储对象
    
    public static  $config;
    
    /**
     * 构造函数
     */
    private function __construct($config) {
    	$this->host 	= $config['host'];
    	$this->port 	= $config['port'];
    	$this->user 	= $config['user'];
    	$this->password = $config['password'];
    	$this->database = $config['database'];
    	$this->charset 	= $config['charset'];
    	$this->pconnect = $config['pconnect'];
    	
        if (!$this->pconnect) {
            $this->conn = @mysql_connect($this->host.':'.$this->port, $this->user, $this->password) or $this->err();
        } else {
            $this->conn = @mysql_pconnect($this->host.':'.$this->port, $this->user, $this->password) or $this->err();
        }
        mysql_select_db($this->database) or $this->err();
        return $this->conn;
    }
    
    /**
     * 防止被克隆
     */
    private function __clone(){}
    
    public static function getInstance(){
        if(FALSE == (self::$_instance instanceof self)){
            self::$_instance = new self(self::$config);
        }
        return self::$_instance;
    }
	
	// 查询
	public function query($sql) {
		$this->write_log ($sql );
		$query = mysql_query ( $sql, $this->conn );
		if (! $query)
			$this->halt ( 'Query Error: ' . $sql );
		return $query;
	}
	
	// 获取记录录（MYSQL_ASSOC，MYSQL_NUM，MYSQL_BOTH）
	public function query_count($table, $where = 1, $result_type = MYSQL_ASSOC) {
		$sql = "select count(*) as count from {$table} where {$where}";
		$query = $this->query( $sql );
		$rt = mysql_fetch_array ( $query, $result_type );
		return $rt ['count'];
	}
	
	// 获取一条记录（MYSQL_ASSOC，MYSQL_NUM，MYSQL_BOTH）
	public function query_one($sql, $result_type = MYSQL_ASSOC) {
		try{
			$_query = $this->query( $sql );
			$rt = mysql_fetch_array ( $_query, $result_type );
			$this->write_log ($sql );
			return $rt;
		}catch(Exception $e){
			debug($e);
			return null;
		}
	}
	
	// 获取全部记录
	public function query_all($sql, $result_type = MYSQL_ASSOC) {
		$query = $this->query ( $sql );
		$i = 0;
		$rt = array ();
		while ( $row = mysql_fetch_array ( $query, $result_type ) ) {
			$rt [$i] = $row;
			$i ++;
		}
		$this->write_log ($sql );
		return $rt;
	}
	
	// 插入
	public function insert($table, $dataArray) {
		$field = "";
		$value = "";
		if (! is_array ( $dataArray ) || count ( $dataArray ) <= 0) {
			return false;
		}
		while ( list ( $key, $val ) = each ( $dataArray ) ) {
			$field .= "$key,";//添加
			$value .= "'$val',";
		}
		$field = substr ( $field, 0, - 1 );
		$value = substr ( $value, 0, - 1 );
		$sql = "insert into $table($field) values($value)";
		$this->write_log ($sql );
		if (! $this->query ( $sql ))
			return false;
		return $this->insert_id ();
	}
	
	// 更新
	public function update($table, $dataArray, $condition = "") {
		if (! is_array ( $dataArray ) || count ( $dataArray ) <= 0) {
			return false;
		}
		$value = "";
		while ( list ( $key, $val ) = each ( $dataArray ) ){
			$value .= "$key = '$val',";//添加
		}
		$value = substr ( $value, 0, - 1 );//修改bug 错误使用 .=
		$sql = "update $table set $value where 1=1 and $condition";
		$this->write_log ($sql );
		if (! $this->query ( $sql ))
			return false;
		return true;
	}
	
	// 删除
	public function delete($table, $condition = "") {
		if (empty ( $condition )) {
			return false;
		}
		$sql = "delete from $table where $condition";
		$this->write_log ($sql );
		if (! $this->query ( $sql ))
			return false;
		return true;
	}
	
	// 返回结果集
	public function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array ( $query, $result_type );
	}
	
	// 获取记录条数
	public function num_rows($results) {
		if (! is_bool ( $results )) {
			$num = mysql_num_rows ( $results );
			return $num;
		} else {
			return 0;
		}
	}
	
	// 释放结果集
	public function free_result() {
		$void = func_get_args ();
		foreach ( $void as $query ) {
			if (is_resource ( $query ) && get_resource_type ( $query ) === 'mysql result') {
				return mysql_free_result ( $query );
			}
		}
	}
	
	// 获取最后插入的id
	public function insert_id() {
		$id = mysql_insert_id ( $this->conn );
		return $id;
	}
	
	// 关闭数据库连接
	protected function close() {
		return @mysql_close ( $this->conn );
	}
	
	// 错误提示
	private function halt($msg = '') {
		$msg .= "\r\n" . mysql_error ();
		$this->write_log ( $msg );
		die ( $msg );
	}
	
	// 析构函数
	public function __destruct() {
		$this->free_result ();
		$use_time = ($this->microtime_float ()) - ($this->time);
		if ($this->is_log) {
			fclose ( $this->handle );
		}
	}
	
	// 写入日志文件
	public function write_log($msg = '') {
		if ($this->is_log) {
			$text = date ( "Y-m-d H:i:s" ) . " " . $msg . "\r\n";
			fwrite ( $this->handle, $text );
		}
	}
	
	// 获取毫秒数
	public function microtime_float() {
		list ( $usec, $sec ) = explode ( " ", microtime () );
		return (( float ) $usec + ( float ) $sec);
	}
	
	/**
	 * 错误信息输出
	 */
	protected function err($sql = null) {
		//这里输出错误信息
		exit('mysql error');
	}
	
}