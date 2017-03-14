<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Comment_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/comment_model');
	}
	
	/**
	 * 获取评论次数最多的兴趣
	 */
	function get_interest_number($b_time = null, $e_time = null){
		$this->comment_model->set_db_obj($this->ci->db_slave);
		return $this->comment_model->get_interest_number($b_time, $e_time);
	}
	
	/**
	 * 评论数量
	 * $where 条件
	 */
	public function count_comment_where($where = null){
		$this->comment_model->set_db_obj($this->ci->db_slave);
		return $this->comment_model->count_comment_where($where);
	}
	
	/**
	 * 搜索评论
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_comment_search_where($where = null, $order = null, $limit = null, $offset = null){
		$this->comment_model->set_db_obj($this->ci->db_slave);
		return $this->comment_model->find_comment_search_where($where, $order, $limit, $offset);
	}
	
	/**
	 * 统计评论数量
	 * $date 日期
	 * $format 格式
	 */
	public function count_comment_by_date($date, $format){
		$this->comment_model->set_db_obj($this->ci->db_slave);
		return $this->comment_model->count_comment_by_date($date, $format);
	}
	
	public function update_comment($data, $id){
		$this->comment_model->set_db_obj($this->ci->db_master);
		return $this->comment_model->update_comment($data, $id);	
	}
}