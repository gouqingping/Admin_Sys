<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class Profile extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('user_service');
		//判断是否登录
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}
	
	/**
	 * ajax用户封禁信息
	 */
	public function dark_room_html(){
		$this->load->library('dark_room_service');
		$this->load->library('user_service');
		$user_id = $this->user_service->get_user_id();
		$dark_info = array();
		$dark_info['is_mu'] = false;
		$t_ids = $this->input->post('t_id');
		$type = $this->input->post('type');
		if(count($t_ids)==1){
			$dark_data = $this->dark_room_service->find_dark_history_by_type_by_t_id($type, $t_ids[0]);
			foreach($dark_data as $key => $val){
				//封禁人
				$apply_user = $this->user_service->get_user_by_id($val['apply_user_id']);
				$dark_data[$key]['apply_user'] = '';
				if($apply_user){
					$dark_data[$key]['apply_user'] = $apply_user['nickname'];
				}
				//解封人
				$accept_user = $this->user_service->get_user_by_id($val['accept_user_id']);
				$dark_data[$key]['accept_user'] = '';
				if($accept_user){
					$dark_data[$key]['accept_user'] = $accept_user['nickname'];
				}
			}
			$dark_info['user_dark'] = $dark_data;
			if($this->dark_room_service->get_dark_room_by_type_by_t_id($type, $t_ids[0], 1)){
				$dark_info['state'] = DARK_ROOM_STATE_NO;
			}else{
				$dark_info['state'] = DARK_ROOM_STATE_YES;
			}
		}else{
			$dark_info['is_mu'] = true;
		}
		$user = $this->user_service->get_user_by_id($user_id);
		$dark_info['user'] = $user['nickname'];
		$dark_info['type'] = $type;
		$this->ajax_json_response(SUCCESS_CODE, array('html' => $this->layout->view('dark/_dark_room_html', $dark_info, true)));
	}

	/**
	 * 保存封禁
	 */
	public function dark_save(){
		$user_id = $this->user_service->get_user_id();
		$t_ids = $this->input->post('t_id');
		$type = $this->input->post('type');
		$dark_day = $this->input->post('dark_day');
		$explain = $this->input->post('explain');
		for($i=0; $i<count($t_ids); $i++){
			switch($dark_day){
			case 'relieve':
				$this->save_dark_relieve($type, $t_ids[$i], $user_id, $explain);
				break;
			default:
				$this->save_dark_room($type, $t_ids[$i], $dark_day, $user_id, $explain);
				break;
			}
		}
		$this->ajax_json_response(SUCCESS_CODE);
	}
	
	/**
	 * 保存解除封禁
	 */
	public function save_dark_relieve($type, $t_id, $user_id, $explain){
		$this->load->library('dark_room_service');
		$this->load->library('dark_relieve_service');
		if($room = $this->dark_room_service->get_dark_room_by_type_by_t_id($type, $t_id, 1)){
			$this->dark_relieve_service->add_dark_relieve($type, $room, $user_id, $explain);
		}
	}
		
	/**
	 * 保存封禁
	 */
	public function save_dark_room($type, $t_id, $dark_day, $user_id, $explain){
		$this->load->library('dark_room_service');
		if($room = $this->dark_room_service->get_dark_room_by_type_by_t_id($type, $t_id, 1)){
			$room['dark_begin_time'] = get_now_time('Y-m-d');
			$room['dark_end_time'] =  get_time_day($dark_day, 'Y-m-d');
			$room['dark_day'] = $dark_day;
			$room['user_id'] = $user_id;
			$room['dark_explain'] = $explain;
			$this->dark_room_service->update_dark_room($room['id'], $room);
		}else{
			$room['type'] = $type;
			$room['t_id'] = $t_id;
			$room['dark_begin_time'] = get_now_time('Y-m-d');
			$room['dark_end_time'] =  get_time_day($dark_day, 'Y-m-d');
			$room['dark_day'] = $dark_day;
			$room['user_id'] = $user_id;
			$room['dark_explain'] = $explain;
			$this->dark_room_service->add_dark_room($type, $room);
		}
	}

	/**
	 * ajax计算解封日期
	 */
	public function get_day(){
		$day = $this->input->post('dark_day');
		$this->ajax_json_response(SUCCESS_CODE, array('day' => get_time_day($day, 'Y-m-d')));
	}
}
