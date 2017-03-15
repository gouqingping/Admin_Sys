<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class Profile extends Base_Controller {

	public function __construct(){
		parent::__construct();
		//判断是否登录
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}
	
	/**
	 * 订单查询
	 */
	public function writer_info_index(){
		$this->layout->view('writer/profile/writer_info_index');
	}
}