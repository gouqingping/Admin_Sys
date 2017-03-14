<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Post_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/post_model');
	}
	
	/**
	 * 计算出热帖
	 * 帖子分数公式：score=P/((T+2)的G次方)
	 * P表示帖子的赞助牛币数量。
	 * T表示距离发帖的时间（单位为小时），加上2是为了防止最新的帖子导致分母过小。
	 * G表示”重力因子”，即将帖子排名往下拉的力量，默认值为1.8，根据需要调整这个值可以控制帖子上升、下降速度。
	 */
	public function find_hot_post(){
		$this->post_model->set_db_obj($this->ci->db_slave);
		return $this->post_model->find_hot_post();
	}
	
	/**
	 * 获取发帖次数最多的兴趣
	 */
	function get_interest_number($b_time = null, $e_time = null){
		$this->post_model->set_db_obj($this->ci->db_slave);
		return $this->post_model->get_interest_number($b_time, $e_time);
	}
	
	/**
	 * 帖子数量
	 * $where 条件
	 */
	public function count_post_where($where = null){
		$this->post_model->set_db_obj($this->ci->db_slave);
		return $this->post_model->count_post_where($where);
	}
	
 	/**
	 * 搜索帖子
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
 	public function find_post_search_where($where = null, $order = null, $limit = null, $offset = null){
 		$this->post_model->set_db_obj($this->ci->db_slave);
		return $this->post_model->find_post_search_where($where, $order, $limit, $offset);
 	}
	
	/**
	 * 统计帖子数量
	 * $date 日期
	 * $format 格式
	 */
	public function count_post_by_date($date, $format){
		$this->post_model->set_db_obj($this->ci->db_slave);
		return $this->post_model->count_post_by_date($date, $format);
	}
	
	/**
	 * 获取热门帖子
	 * $date 日期
	 */
	public function find_hot_post_by_date($date){
		$this->post_model->set_db_obj($this->ci->db_slave);
		return $this->post_model->find_hot_post_by_date($date);
	}
	
	public function update_post($data, $id){
		$this->post_model->set_db_obj($this->ci->db_master);
		return $this->post_model->update_post($data, $id);	
	}
}
