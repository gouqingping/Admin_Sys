<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class Hot_post extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
        $this->load->db_master(TRUE);
        $this->load->db_slave();
	}
	
	/**
	 * 获取热帖
	 * 添加帖到热帖表
	 */
	public function add_hot_post(){
		$this->load->library('post_service');
		$this->load->library('hot_post_service');
		$hot = $this->post_service->find_hot_post();//获取计算出的热帖
		if($hot){
			$this->hot_post_service->delete_table();//删除热帖表数据
			$data =  array();
			foreach($hot as $v){
				$data = array(
					'post_id' => $v['id'],
					'is_active' => 1
				);
				$this->hot_post_service->add_hot_post($data);//添加计算出的新数据
			}
		}
		echo '处理完成';
		exit;
	}
}