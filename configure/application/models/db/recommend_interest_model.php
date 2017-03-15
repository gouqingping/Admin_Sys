<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Recommend_interest_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 获取推荐兴趣
	 * $interest_id 兴趣id
	 */
	public function get_recommend_by_interest_id($interest_id){
		$bind_array = array($interest_id);
		$sql = 'SELECT * FROM t_recommend_interest WHERE interest_id = ?';
		return $this->get_db_obj()->query($sql, $bind_array)->row_array(); 
	}
	/**
	 * 删除推荐兴趣表数据
	 */
	public function delete_table(){
		return $this->truncate_table('t_recommend_interest');
	}
	
	/**
	 * 添加计算出的新数据
	 */
	public function add_recommend($data){
		return $this->insert_data('t_recommend_interest', $data);
	}
}