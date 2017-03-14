<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Interest_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/interest_model');
	}
	
	/**
	 * 兴趣数量
	 * $where 条件
	 */
	public function count_interest_where($where = null){
		$this->interest_model->set_db_obj($this->ci->db_slave);
		return $this->interest_model->count_interest_where($where);
	}
	
	/**
	 * 统计兴趣数量
	 * $date 日期
	 * $format 格式
	 */
	function count_interest_by_date($date, $format){
		$this->interest_model->set_db_obj($this->ci->db_slave);
		return $this->interest_model->count_interest_by_date($date, $format);
	}
	
	/**
	 * 获取热门兴趣
	 * $date 日期
	 */
	public function find_hot_interest_by_date($date){
		$this->interest_model->set_db_obj($this->ci->db_slave);
		return $this->interest_model->find_hot_interest_by_date($date);
	}
	
	/**
	 * 申请中的兴趣数量
	 * $where 搜索条件
	 */
	public function count_interest_apply($where = null){
		$this->interest_model->set_db_obj($this->ci->db_slave);
		return $this->interest_model->count_interest_apply($where);
	}
	
	/**
	 *  获取申请中的兴趣
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_interest_apply($where = null, $order = null, $limit = null, $offset = null){
		$this->interest_model->set_db_obj($this->ci->db_slave);
		return $this->interest_model->find_interest_apply($where, $order, $limit, $offset);
	}
	
	/**
	 * 搜索兴趣
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_interest_search_where($where = null, $order = null, $limit = null, $offset = null){
		$this->interest_model->set_db_obj($this->ci->db_slave);
		return $this->interest_model->find_interest_search_where($where, $order, $limit, $offset);
	}
	
	/**
	 * 添加审核通过的兴趣
	 * $data 兴趣对象
	 * $user_id 审核人
	 */
	public function add_interest($data, $user_id){
		$this->interest_model->set_db_obj($this->ci->db_master);
		$this->interest_model->get_db_obj()->trans_begin();
		try {
			$data_interest = array(
				'name' => $data['name'],
				'is_active'   => 1,
				'content' => $data['content'],
				'be_favorited_num' => 1,
				'icon' => $data['icon'],
				'apply_user_id' => $data['apply_user_id'],
				'accept_user_id' => $user_id,
				'created_at' => $data['created_at']
			);
			$this->delete_interest_apply(array('id' => $data['id']));
			$int_id = $this->interest_model->add_interest($data_interest);
			$this->load->library('favorite_interest_service');
			$i_data['user_id'] = $data['apply_user_id'];
			$i_data['interest_id'] = $int_id;
			$i_data['is_active'] = 1;
			$this->favorite_interest_service->add_interest($i_data);
			$this->interest_model->get_db_obj()->trans_complete();
		} catch (Exception $e) {
			$this->interest_model->get_db_obj()->trans_rollback(); 
		}
	}
	
	/**
	 * 删除审核未通过的兴趣
	 * $where 条件
	 */
	public function delete_interest_apply($where){
		$this->interest_model->set_db_obj($this->ci->db_master);
		return $this->interest_model->delete_interest_apply($where);
	}
	
	/**
	 * 更变兴趣状态
	 */
	public function update_interest($data, $id){
		$this->interest_model->set_db_obj($this->ci->db_master);
		return $this->interest_model->update_interest($data, $id);
	}
}
