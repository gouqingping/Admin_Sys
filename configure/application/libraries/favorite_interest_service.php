<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Favorite_interest_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/favorite_interest_model');
	}
	
	/**
	 * 获取关注次数最多的兴趣
	 */
	function get_interest_number($b_time = null, $e_time = null){
		$this->favorite_interest_model->set_db_obj($this->ci->db_slave);
		return $this->favorite_interest_model->get_interest_number($b_time, $e_time);
	}
	
	public function add_interest($data) {
		$this->favorite_interest_model->set_db_obj($this->ci->db_master);
		return $this->favorite_interest_model->add_interest($data);
	}
}
