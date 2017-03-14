<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Take_cash_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/take_cash_model');
	}
	
	/**
	 * 打款提现数量
	 * $where 条件
	 */
	public function count_take_cash_where($where = null){
		$this->take_cash_model->set_db_obj($this->ci->db_slave);
		return $this->take_cash_model->count_take_cash_where($where);
	}
	
	/**
	 * 打款提现查询
	 * $where 条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 **/
	public function find_take_cash_where($where = null, $order = null, $limit = null, $offset = null){
		$this->take_cash_model->set_db_obj($this->ci->db_slave);
		return $this->take_cash_model->find_take_cash_where($where , $order , $limit , $offset);
	}
	
	/*
	 * 根据id获取数据
	 **/
    public function get_by_id($user_id, $is_active = null) {
        $this->take_cash_model->set_db_obj($this->ci->db_slave);
        return $this->take_cash_model->get_by_id($user_id, $is_active);
    }
	
	/*
	 * 修改
	 */
	public function update_take_cash($data, $id) {
        $this->take_cash_model->set_db_obj($this->ci->db_master);
        return $this->take_cash_model->update_take_cash($data, $id);
    }
}