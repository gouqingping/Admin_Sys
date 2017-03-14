<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Gold_order_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/gold_order_model');
	}
	
	/**
	 * 订单数量
	 * $where 条件
	 */
	public function count_gold_order_where($where = null){
		$this->gold_order_model->set_db_obj($this->ci->db_slave);
		return $this->gold_order_model->count_gold_order_where($where);
	}
	
	/**
	 * 订单查询
	 * $where 条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 **/
	public function find_gold_order_where($where = null, $order = null, $limit = null, $offset = null){
		$this->gold_order_model->set_db_obj($this->ci->db_slave);
		return $this->gold_order_model->find_gold_order_where($where, $order, $limit, $offset);
	}
	
	/*
	 * 修改
	 */
	public function update_gold_order($data, $id) {
        $this->gold_order_model->set_db_obj($this->ci->db_master);
        return $this->gold_order_model->update_gold_order($data, $id);
    }
}