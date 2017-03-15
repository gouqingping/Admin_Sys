<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/base_controller.php');

class Account extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('user_service');
	}
	
	//登录
	public function login()
	{
		$this->layout->setLayout('layout_login');
		$this->layout->css('regist.css');
		$data = array();
		if ($this->input->is_post()) {
			if ($this->form_validation->run('login') == FALSE) {
				$this->layout->view('user/account/regist', $data);
			} else {
				$email = $this->input->post('email');
				$password = set_password($this->input->post('password'));
				if ($user = $this->user_service->get_user_by_email_and_pwd($email, $password)) {
					if ($user['is_active']) {
						$this->user_service->set_user_session($user);
						redirect(base_url() . 'panel/top/panel_index');
					} else {
						$data['clean_output']['error'] = error_msg(array($this->lang->line('error_login_info_active')));
						$this->layout->view('user/account/regist', $data);
					}
				} else {
					$data['clean_output']['error'] = error_msg(array($this->lang->line('error_login_info_wrong')));
					$this->layout->view('user/account/regist', $data);
				}
			}
		} else {
	    	$this->layout->view('user/account/regist', $data);
		}
	}

	public function sign_out(){
		$this->session->unset_userdata('user_info');
		redirect(base_url().'user/account/login');
	}
}
