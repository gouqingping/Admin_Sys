<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Dark_relieve_service extends Base_service {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db/dark_relieve_model');
	}
	
	/**
	 * 解除封禁
	 * $type 封禁类型 1用户2帖子3评论4兴趣
	 * $t_id 封禁类型 id
	 * $$user_id解封人
	 * $explain 解封描述
	 */
	public function add_dark_relieve($type, $room, $user_id, $explain){
		$this->load->library('dark_room_service');
		$this->dark_relieve_model->set_db_obj($this->ci->db_master);
		$this->dark_relieve_model->get_db_obj()->trans_begin();
		try{
			if($type == TYPE_DARK_ROOM_USER){
				$this->load->library('user_service');
				$this->user_service->update_user(array('is_active' => 1), $room['t_id']);
			}elseif($type == TYPE_DARK_ROOM_POST){
				$this->load->library('post_service');
				$this->post_service->update_post(array('is_active' => 1), $room['t_id']);
			}elseif($type == TYPE_DARK_ROOM_COMMENT){
				$this->load->library('comment_service');
				$this->comment_service->update_comment(array('is_active' => 1), $room['t_id']);
			}elseif($type == TYPE_DARK_ROOM_INTEREST){
				$this->load->library('interest_service');
				$this->interest_service->update_interest(array('is_active' => 1), $room['t_id']);
			}
			$this->dark_room_service->update_dark_room($room['id'], array('is_active' => 0));
			$relieve = array('relieve_time' => get_now_time('Y-m-d'), 'dark_id' => $room['id'], 'user_id' => $user_id, 'relieve_explain' => $explain);
			$dark_relieve = $this->dark_relieve_model->add_dark_relieve($relieve);
			$this->dark_relieve_model->get_db_obj()->trans_complete();
			return $dark_relieve;
		}catch(Exception $e){
			$this->dark_relieve_model->get_db_obj()->trans_rollback(); 
		}
	}
}