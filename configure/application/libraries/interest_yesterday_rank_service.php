<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Interest_yesterday_rank_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/interest_yesterday_rank_model');
	}
	
	/**
	 * 删除前一天赞助牛币表数据
	 */
	public function delete_table(){
		$this->interest_yesterday_rank_model->set_db_obj($this->ci->db_master);
		return $this->interest_yesterday_rank_model->delete_table();	
	}
	
	/**
	 * 添加前一天赞助牛币表数据
	 */
	public function add_interest_yesterday($data){
		$this->interest_yesterday_rank_model->set_db_obj($this->ci->db_master);
		return $this->interest_yesterday_rank_model->add_interest_yesterday($data);	
	}
}