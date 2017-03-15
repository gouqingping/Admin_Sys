<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Interest_total_rank_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/interest_total_rank_model');
	}
	
	/**
	 * 删除赞助总牛币表数据
	 */
	public function delete_table(){
		$this->interest_total_rank_model->set_db_obj($this->ci->db_master);
		return $this->interest_total_rank_model->delete_table();	
	}
	
	/**
	 * 添加赞助总牛币表数据
	 */
	public function add_interest_total($data){
		$this->interest_total_rank_model->set_db_obj($this->ci->db_master);
		return $this->interest_total_rank_model->add_interest_total($data);	
	}
}
