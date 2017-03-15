<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Recommend_interest_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/recommend_interest_model');
	}
	
	/**
	 * 获取推荐兴趣
	 * $interest_id 兴趣id
	 */
	public function get_recommend_by_interest_id($interest_id){
		$this->recommend_interest_model->set_db_obj($this->ci->db_master);
		return $this->recommend_interest_model->get_recommend_by_interest_id($interest_id);
	}
	
	/**
	 * 删除热帖表数据
	 */
	public function delete_table(){
		$this->recommend_interest_model->set_db_obj($this->ci->db_master);
		return $this->recommend_interest_model->delete_table();
	}
	
	/**
	 * 添加计算出的新数据
	 */
	public function add_recommend($data){
		$this->recommend_interest_model->set_db_obj($this->ci->db_master);
		return $this->recommend_interest_model->add_recommend($data);
	}
}
