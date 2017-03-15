<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Dark_room_service extends Base_service {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db/dark_room_model');
	}
	
	/**
	 * 获取所有需解封的封禁信息
	 */
	public function find_dark_room(){
		$this->dark_room_model->set_db_obj($this->ci->db_slave);
		return $this->dark_room_model->find_dark_room();
	}
	
	/**
	 * 获取封禁信息
	 * $type 封禁类型 1用户2帖子3兴趣
	 * $t_id 封禁类型 id
	 */
	public function get_dark_room_by_type_by_t_id($type, $t_id, $is_active){
		$this->dark_room_model->set_db_obj($this->ci->db_slave);
		return $this->dark_room_model->get_dark_room_by_type_by_t_id($type, $t_id, $is_active);
	}
	
	/**
	 * 获取封禁历史信息
	 * $type 封禁类型 1用户2帖子3兴趣
	 * $t_id 封禁类型 id
	 */
	public function find_dark_history_by_type_by_t_id($type, $t_id){
		$this->dark_room_model->set_db_obj($this->ci->db_slave);
		return $this->dark_room_model->find_dark_history_by_type_by_t_id($type, $t_id);
	}
	
	/**
	 * 添加封禁信息
	 * $data 封禁信息
	 */
	public function add_dark_room($type, $data){
		$this->dark_room_model->set_db_obj($this->ci->db_master);
		$this->dark_room_model->get_db_obj()->trans_begin();
		try{
			if($type == TYPE_DARK_ROOM_USER){
				$this->load->library('user_service');
				$this->user_service->update_user(array('is_active' => 0), $data['t_id']);
			}elseif($type == TYPE_DARK_ROOM_POST){
				$this->load->library('post_service');
				$this->post_service->update_post(array('is_active' => 0), $data['t_id']);
			}elseif($type == TYPE_DARK_ROOM_COMMENT){
				$this->load->library('comment_service');
				$this->comment_service->update_comment(array('is_active' => 0), $data['t_id']);
			}elseif($type == TYPE_DARK_ROOM_INTEREST){
				$this->load->library('interest_service');
				$this->interest_service->update_interest(array('is_active' => 0), $data['t_id']);
			}
			$dark_room = $this->dark_room_model->add_dark_room($data);
			$this->dark_room_model->get_db_obj()->trans_complete();
			return $dark_room;
		}catch(Exception $e){
			$this->dark_room_model->get_db_obj()->trans_rollback(); 
		}
	}
	
	/**
	 * 更变封禁信息
	 * $id 封禁id
	 * $data 封禁信息
	 */
	public function update_dark_room($id ,$data){
		$this->dark_room_model->set_db_obj($this->ci->db_master);
		return $this->dark_room_model->update_dark_room($id, $data);	
	}
}