<?php 
include_once '../core/MySql.class.php';
class Model {
	
	protected 	$db = null;
	private 	$table = '';
	private 	$sql = '';
	private 	$where = ' WHERE  1 ';
	private 	$orderby = '';
	private 	$groupby = '';
	private 	$limit = '';
	
	public function __construct($table) {
		$this->table = $table;
		$this->db = MySql::getInstance();
	}

	/**
	 * 插入数据(数组key与表列名一致)
	 */
	public function insert($data){
		$id = $this->db->insert($this->table, $data);
		return $id;
	}
	
	/**
	 * 根据ID更新
	 * @param array $data
	 */
	public function updateById($data){
		return $this->db->update($this->table, $data, "id = ".$data['id']);
	}
	
	/**
	 * 修改数据
	 * @param string $condition
	 * @param array $data
	 */
	public function update( $condition="",$data){
		return $this->db->update($this->table, $data,$condition);
	}
	/**
	 * 条件删除
	 * @param string|array $condition
	 */
	public function delete($condition=""){
		if(is_array($condition)){
			$str = ' 1=1 ';
			foreach($condition as $k=>$v){
				$str .= "AND {$k}='{$v}'";
			}
			$condition = $str;
			unset($str);
		}
		return $this->db->delete( $this->table,$condition);
	}
	
	/**
	 * 获取一条记录
	 */
	public function queryById($id){
		$sql = "SELECT * FROM {$this->table} WHERE id = " . $id;
		return $this->db->query_one($sql,$result_type = MYSQL_ASSOC);
	}
	
	/**
	 * 获取多条记录
	 */
	public function query(){
		$sql = "SELECT * FROM {$this->table} {$this->where}{$this->orderby}{$this->groupby}{$this->limit}";
		return $this->db->query_all($sql,$result_type = MYSQL_ASSOC);
	}
	
	/**
	 * sql查询
	 */
	public function queryBySql($sql){
		return $this->db->query_all($sql,$result_type = MYSQL_ASSOC);
	}
	
	/**
	 * 生成分页
	 * @param int $page
	 * @param string $baseUrl
	 * @param array $pageParam
	 * @return string
	 */
	public function getPager($page,$baseUrl,$pageParam = array()){
		$count = $this->db->get_count($this->table);
		return showPage($count, $page, $baseUrl,$pageParam);
	}
	
	/**
	 * 条件查询
	 * @param string $where
	 * @return Model
	 */
	public function where($where = '1 '){
		$this->where= ' WHERE '.$where;
		return $this;
	}
	/**
	 * 排序
	 * @param string $orderby
	 * @return Model
	 */
	public function order($orderby){
		$this->orderby= ' ORDER BY '.$orderby;
		return $this;
	}
	/**
	 * group
	 * @param string $groupby
	 * @return Model
	 */
	public function group($groupby){
		$this->groupby = ' GROUP BY '.$groupby;
		return $this;
	}
	/**
	 * 区间查询
	 * @param int $start
	 * @param int $count
	 * @return Model
	 */
	public function limit($start,$count){
		$this->limit = ' LIMIT '.$start.','.$count;
		return $this;
	}
	/**
	 * 分页
	 * @param int $pageNum
	 * @return Model
	 */
	public function page($pageNum){
		$perNum = 10;
		$this->limit = ' LIMIT '.($pageNum-1)*$perNum.','.$perNum;
		return $this;
	}

}	
?>