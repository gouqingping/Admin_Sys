<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class top extends Base_Controller {

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
	 * 内容首页
	 */
	public function capacity_index(){
		$this->layout->css(array('capacity.css'));
		$data = array();
		$this->layout->view('capacity/top/capacity_index', $data);
	}
}