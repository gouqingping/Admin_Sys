<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Html_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/html_model');
	}
	
	public function get_html_by_id($id){
		$this->html_model->set_db_obj($this->ci->db_slave);
		return $this->html_model->get_html_by_id($id);
	}
	
	/**
	 * 添加静态html
	 * $data 静态html信息
	 */
	public function add_html($data){
		$this->html_model->set_db_obj($this->ci->db_master);
		return $this->html_model->add_html($data);
	}
	
	/**
	 * 更变静态html信息
	 * $id 编号id
	 * $data 静态html信息
	 */
	public function update_html($id, $data){
		$this->html_model->set_db_obj($this->ci->db_master);
		return $this->html_model->update_html($id, $data);
	}
}