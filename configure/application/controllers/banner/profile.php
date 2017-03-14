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
	 * 活动或广告第三方网络地址
	 */
	public function banner_index(){
		$this->layout->view('banner/profile/banner_index');
	}
	
	/**
	 * 编辑banner页面
	 */
	public function set(){
		$this->layout->css(array('added.css'));
		$this->layout->javascript(array('jquery.form.js', 'laydate.js'));
		$data['banner'] = null;
		if($md5_id = $this->uri->segment(4)){
			$this->load->library('ad_banner_service');
			$id = decrypt_id($md5_id);
			$where = array(array('logic' => ' WHERE ', 'key' => 'b.id', 'opn' => ' = ', 'val' => $id));
			$banner = $this->ad_banner_service->find_banner_where($where);
			if($banner[0]['t_id']){
				$this->load->library('html_service');
				$html = $this->html_service->get_html_by_id($banner[0]['t_id']);
				$banner[0]['html'] = $html['html'];
			}
			$data['banner'] = $banner;
		}
		$this->layout->view('banner/profile/set_banner_info', $data);
	}
}