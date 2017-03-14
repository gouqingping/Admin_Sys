<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class User_service extends Base_service {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db/user_model');
	}
	
	/**
	 * 是否登录
	 */
	public function is_login(){
		$user_data = $this->session->userdata('user_info');
		if (isset($user_data['email']) && $user_data['email'] != "") {
			return true;
		}
		return false;
	}
	
	/**
	 * 是否登录并且账号可用
	 */
	public function is_active()
	{
		$user_data = $this->session->userdata('user_info');
		if (isset($user_data['email']) && $user_data['email'] != "" && $user_data['is_active']) {
			return true;
		}
		return false;
	}
	
	/**
	 * 用户数量
	 * $where 条件
	 */
	public function count_user_where($where){
		$this->user_model->set_db_obj($this->ci->db_slave);
		return $this->user_model->count_user_where($where);
	}
	
	/**
	 * 统计用户数量
	 * $date 日期
	 * $format 格式
	 */
	public function count_user_by_date($date, $format){
		$this->user_model->set_db_obj($this->ci->db_slave);
		return $this->user_model->count_user_by_date($date, $format);
	}
	
	/**
	 * 搜索用户
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 **/
	public function find_user_by_search($where, $order, $limit, $offset){
		$this->user_model->set_db_obj($this->ci->db_slave);
		return $this->user_model->find_user_by_search($where, $order, $limit, $offset);
	}
	
	/**
	 * 获取用户信息
	 * $user_id 用户id
	 */
	public function get_user_info($user_id){
		$this->user_model->set_db_obj($this->ci->db_slave);
		return $this->user_model->get_user_info($user_id);
	}
	
	/**
	 * 获取用户信息
	 * $id 用户id
	 */
	public function get_user_by_id($id, $is_active = null)
	{
		$this->user_model->set_db_obj($this->ci->db_slave);
		return $this->user_model->get_user_by_id($id, $is_active);
	}
	
	/**
	 * 登录
	 * $email 登录名
	 * $password 密码
	 */
	public function get_user_by_email_and_pwd($email, $password)
	{
		$this->user_model->set_db_obj($this->ci->db_slave);
		return $this->user_model->get_user_by_email_and_pwd($email, $password);
	}
	
	/**
	 * 登录记录session
	 * $user登录用户对象
	 */
	public function set_user_session($user)
	{
		$session_data = array (
				'user_id' => $user['id'],
				'email' => $user['email'],
				'is_active' => $user['is_active']
			);
		$this->session->set_userdata('user_info', $session_data);
	}	
	
	public function get_user_session()
	{
		return $this->session->userdata('user_info');
	}
	
	public function get_user_id()
	{
		$user_session = $this->user_service->get_user_session();
		return $user_session['user_id'];
	}
	
	public function get_user_email()
	{
		$user_session = $this->user_service->get_user_session();
		return $user_session['email'];
	}
	
	public function get_user_nickname(){
		$user = $this->get_user_info($this->get_user_id());
		return $user['nickname'];
	}
	
	/**
	 * 获取牛币最多的用户
	 */
	public function find_user_order_gold($limit){
		$this->user_model->set_db_obj($this->ci->db_slave);
		return $this->user_model->find_user_order_gold($limit);
	}
	
	public function update_user($data, $user_id)
	{
		$this->user_model->set_db_obj($this->ci->db_master);
		return $this->user_model->update_user($data, $user_id);
	}
}
