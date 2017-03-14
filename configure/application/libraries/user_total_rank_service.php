<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class User_total_rank_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/user_total_rank_model');
	}
	
	/**
	 * 删除用户总排行表数据
	 */
	public function delete_table(){
		$this->user_total_rank_model->set_db_obj($this->ci->db_master);
		return $this->user_total_rank_model->delete_table();	
	}
	
	/**
	 * 添加用户总排行表数据
	 */
	public function add_user_total($data){
		$this->user_total_rank_model->set_db_obj($this->ci->db_master);
		return $this->user_total_rank_model->add_user_total($data);	
	}
}