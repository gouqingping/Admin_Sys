<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Ad_banner_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/ad_banner_model');
	}
	
	/**
	 * 获取banner数量
	 * $where 条件
	 */
	public function count_banner_where($where){
		$this->ad_banner_model->set_db_obj($this->ci->db_slave);
		return $this->ad_banner_model->count_banner_where($where);
	}

	/**
	 * 获取banner信息
	 * $where 条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_banner_where($where = null, $order = null, $limit = null, $offset = null){
		$this->ad_banner_model->set_db_obj($this->ci->db_slave);
		return $this->ad_banner_model->find_banner_where($where, $order, $limit, $offset);
	}

	/**
	 * 添加banner
	 * $data banner信息
	 */
	public function add_banner($data){
		$this->ad_banner_model->set_db_obj($this->ci->db_master);
		return $this->ad_banner_model->add_banner($data);
	}
	
	/**
	 * 更变banner信息
	 * $id 编号id
	 * $data banner信息
	 */
	public function update_banner($id, $data){
		$this->ad_banner_model->set_db_obj($this->ci->db_master);
		return $this->ad_banner_model->update_banner($id, $data);
	}
}