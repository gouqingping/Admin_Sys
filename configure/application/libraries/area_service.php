<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Area_service extends Base_service {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db/area_model');
	}
	
	//获取子级地区信息
	public function find_area_by_parent_id($parent_id, $is_active = null){
		$this->area_model->set_db_obj($this->ci->db_slave);
		return $this->area_model->find_area_by_parent_id($parent_id, $is_active);
	}
	
	public function get_area_by_id($id, $is_active = null){
		$this->area_model->set_db_obj($this->ci->db_slave);
		return $this->area_model->get_area_by_id($id, $is_active);
	}
	
	//获取用户所在区域
	public function get_user_area($user){
		$area = '';
		if($user['province']) {
			$a = $this->get_area_by_id($user['province']);
			$area .= $a['area_name'];
		}
		if($user['city']) {
			$a = $this->get_area_by_id($user['city']);
			$area .= $a['area_name'];
		}
		if($user['county']) {
			$a = $this->get_area_by_id($user['county']);
			$area .= $a['area_name'];
		}
		return $area;
	}
}