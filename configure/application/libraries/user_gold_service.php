<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class User_gold_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/user_gold_model');
	}
	
	/**
	 * 获取赞助次数最多的兴趣
	 */
	public function get_interest_number($b_time = null, $e_time = null) {
		$this->user_gold_model->set_db_obj($this->ci->db_slave);
		return $this->user_gold_model->get_interest_number($b_time, $e_time);
	}
	
	/**
	 * 获取兴趣赞助的牛币数
	 */
	public function get_interest_gold($b_date = null, $e_date){
		$this->user_gold_model->set_db_obj($this->ci->db_slave);
		return $this->user_gold_model->get_interest_gold($b_date, $e_date);
	}
	
	public function add_user_gold($data)
	{
		$this->user_gold_model->set_db_obj($this->ci->db_master);
		return $this->user_gold_model->add_user_gold($data);
	}
}