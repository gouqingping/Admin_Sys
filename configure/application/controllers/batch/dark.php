<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class Dark extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
        $this->load->db_master(TRUE);
        $this->load->db_slave();
	}
	
	/**
	 * 批量处理解封
	 * 获取到期未解封的信息
	 * 循环解封每条封禁
	 */
	public function dark_relieve(){
		$this->load->library('dark_room_service');
		$this->load->library('dark_relieve_service');
		$dark = $this->dark_room_service->find_dark_room();
		foreach($dark as $v){
			$this->dark_relieve_service->add_dark_relieve($v['type'], $v, 0, $this->lang->line('system_dark_relieve'));
		}
		echo '处理完成';
		exit;
	}
}