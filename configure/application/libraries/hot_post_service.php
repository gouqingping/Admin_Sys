<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Hot_post_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/hot_post_model');
	}
	
	/**
	 * 删除热帖表数据
	 */
	public function delete_table(){
		$this->hot_post_model->set_db_obj($this->ci->db_master);
		return $this->hot_post_model->delete_table();	
	}
	
	/**
	 * 添加计算出的新数据
	 */
	public function add_hot_post($data){
		$this->hot_post_model->set_db_obj($this->ci->db_master);
		return $this->hot_post_model->add_hot_post($data);	
	}
}
