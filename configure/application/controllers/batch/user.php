<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class User extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
        $this->load->db_master(TRUE);
        $this->load->db_slave();
	}
	
	/**
	 * 获取当前牛币最多的前一百名用户
	 * 添加帖到用户牛币排名表
	 */
	public function user_total(){
		$this->load->library('user_service');
		$this->load->library('user_total_rank_service');
		$where = array(
						array('logic' => ' WHERE ', 'key' => 'is_active', 'opn' => ' = ', 'val' => 1)
					);
		$order = array('gold' => 'DESC');
		$user = $this->user_service->find_user_order_gold(RANK_USER);//获取牛币最多的用户
		$this->user_total_rank_service->delete_table();//删除用户排行数据
		foreach($user as $v){
			$data = array('user_id' => $v['id'], 'gold' => $v['gold']);
			$this->user_total_rank_service->add_user_total($data);
		}
		echo '处理完成';
		exit;
	}
}