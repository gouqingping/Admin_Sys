<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Impeach_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/impeach_model');
	}
	
	/**
	 * 投诉数量
	 * $where 条件
	 */
	public function count_impeach_where($where = null){
		$this->impeach_model->set_db_obj($this->ci->db_slave);
		return $this->impeach_model->count_impeach_where($where);
	}
	
	/**
	 * 搜索投诉
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_impeach_search_where($where = null, $order = null, $limit = null, $offset = null){
		$this->impeach_model->set_db_obj($this->ci->db_slave);
		return $this->impeach_model->find_impeach_search_where($where, $order, $limit, $offset);
	}
	
	/**
	 * 处理投诉
	 * $user_id 处理人
	 * $ids 投诉id[]
	 * $handle 处理方式
	 * $explain 消息内容
	 */
	public function processing_save($user_id, $impeach, $msg, $handle){
		$this->impeach_model->set_db_obj($this->ci->db_master);
		$this->impeach_model->get_db_obj()->trans_begin();
		try{
			if($handle == 'yes'){
				$this->load->library('dark_room_service');
				if($room = $this->dark_room_service->get_dark_room_by_type_by_t_id($impeach['type'], $impeach['t_id'], 1)){
					$room['dark_begin_time'] = get_now_time('Y-m-d');
					$room['dark_end_time'] =  get_time_day(0, 'Y-m-d');
					$room['dark_day'] = 0;
					$room['user_id'] = $user_id;
					$room['dark_explain'] = $this->lang->line('system_impeach_dark_room');
					$this->dark_room_service->update_dark_room($room['id'], $room);
				}else{
					$room['type'] = $impeach['type'];
					$room['t_id'] = $impeach['t_id'];
					$room['dark_begin_time'] = get_now_time('Y-m-d');
					$room['dark_end_time'] =  get_time_day(0, 'Y-m-d');
					$room['dark_day'] = 0;
					$room['user_id'] = $user_id;
					$room['dark_explain'] = $this->lang->line('system_impeach_dark_room');
					$this->dark_room_service->add_dark_room($impeach['type'], $room);
				}
			}
			$this->update_impeach(array('is_active' => 0), $impeach['id']);
			$this->load->library('message_service');
			$this->message_service->add_message($msg);
			$this->impeach_model->get_db_obj()->trans_complete();
		}catch(Exception $e) {
			$this->impeach_model->get_db_obj()->trans_rollback(); 
		}
	}
	
	/**
	 * 更变投诉
	 * $data更变内容
	 */
	public function update_impeach($data, $id){
		$this->impeach_model->set_db_obj($this->ci->db_master);
		return $this->impeach_model->update_impeach($data, $id);
	}
}