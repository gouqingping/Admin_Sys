<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Writer_info_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/writer_info_model');
	}
	
	/**
	 * 撰稿人数量
	 * $where 条件
	 */
	public function count_writer_info_where($where = null){
		$this->writer_info_model->set_db_obj($this->ci->db_slave);
		return $this->writer_info_model->count_writer_info_where($where);
	}
	
	/**
	 * 撰稿人查询
	 * $where 条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 **/
	public function find_writer_info_where($where = null, $order = null, $limit = null, $offset = null){
		$this->writer_info_model->set_db_obj($this->ci->db_slave);
		return $this->writer_info_model->find_writer_info_where($where, $order, $limit, $offset);
	}
	
	/*
	 * 根据id获取数据
	 **/
    public function get_by_id($user_id, $is_active = null) {
        $this->writer_info_model->set_db_obj($this->ci->db_slave);
        return $this->writer_info_model->get_by_id($user_id, $is_active);
    }
	
	/*
	 * 修改
	 */
	public function update_writer($data, $id) {
        $this->writer_info_model->set_db_obj($this->ci->db_master);
        return $this->writer_info_model->update_writer($data, $id);
    }
}