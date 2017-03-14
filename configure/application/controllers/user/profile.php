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
	 * 用户管理
	 */
	public function user_index(){
		$this->layout->view('user/profile/user_index');
	}
	
	/**
	 * ajax返回用户搜索内容
	 */
	public function user_search_html(){
		$from_key = $this->input->post('from_key');
		$from_val = $this->input->post('from_val');
		$from_field = $this->input->post('from_field');
		$by = $this->input->post('by');
		$offset = $this->uri->segment(4)?$this->uri->segment(4):1;
		$user_id = $this->user_service->get_user_id();
		$where = null;
		if($from_val != ''){
			switch($from_key){
				case 'nc':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'u.nickname', 'opn' => ' like ', 'val' => '%'.$from_val.'%'),
						array('logic' => ' AND ', 'key' => 'u.id', 'opn' => ' <> ', 'val' => $user_id)
					);
					break;
				case 'yx':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'u.email', 'opn' => ' like ', 'val' => '%'.$from_val.'%'),
						array('logic' => ' AND ', 'key' => 'u.id', 'opn' => ' <> ', 'val' => $user_id)
					);
					break;
				case 'jj':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'u.profile', 'opn' => ' like ', 'val' => '%'.$from_val.'%'),
						array('logic' => ' AND ', 'key' => 'u.id', 'opn' => ' <> ', 'val' => $user_id)
					);
					break;
				case 'ip':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'u.regist_ip', 'opn' => ' like ', 'val' => '%'.$from_val.'%'),
						array('logic' => ' AND ', 'key' => 'u.id', 'opn' => ' <> ', 'val' => $user_id)
					);
					break;
				case 'sj':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'u.created_at', 'opn' => ' like ', 'val' => '%'.$from_val.'%'),
						array('logic' => ' AND ', 'key' => 'u.id', 'opn' => ' <> ', 'val' => $user_id)
					);
					break;
				case 'fj':
					if($from_val == '封禁'){
						$where = array(
							array('logic' => ' WHERE ', 'key' => 'u.is_active', 'opn' => ' = ', 'val' => 0),
							array('logic' => ' AND ', 'key' => 'u.id', 'opn' => ' <> ', 'val' => $user_id),
							array('logic' => ' AND ', 'key' => 'd.t_id', 'opn' => ' IS NOT ', 'val' => NULL)
						);
					}else if($from_val == '未激活'){
						$where = array(
							array('logic' => ' WHERE ', 'key' => 'u.is_active', 'opn' => ' = ', 'val' => 0),
							array('logic' => ' AND ', 'key' => 'u.id', 'opn' => ' <> ', 'val' => $user_id),
							array('logic' => ' AND ', 'key' => 'd.t_id', 'opn' => ' IS ', 'val' => NULL)
						);
					}else{
						$where = array(
							array('logic' => ' WHERE ', 'key' => 'u.is_active', 'opn' => ' = ', 'val' => 1),
							array('logic' => ' AND ', 'key' => 'u.id', 'opn' => ' <> ', 'val' => $user_id)
						);
					}
					break;
			}
		}
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('nickname' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('profile' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('email' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('sex' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('gold' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('p_num' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_8':
				$order = array('regist_ip' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_9':
				$order = array('created_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort10':
				$order = array('last_login_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_0':
				$order = array('is_active' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->user_service->count_user_where($where);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'user/profile/user_search_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_USER_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$user_info = $this->user_service->find_user_by_search($where, $order, PAGEING_USER_NUM, ($offset-1)*PAGEING_USER_NUM);
		if($from_val != ''){
			switch($from_key){
				case 'nc':
					for ($i=0; $i < count($user_info); $i++) {
						$user_info[$i]['nickname'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$user_info[$i]['nickname'],1);					
					}
					break;
				case 'yx':
					for ($i=0; $i < count($user_info); $i++) {
						$user_info[$i]['email'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$user_info[$i]['email'],1);					
					}
					break;
				case 'jj':
					for ($i=0; $i < count($user_info); $i++) {
						$user_info[$i]['profile'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$user_info[$i]['profile'],1);					
					}
					break;
				case 'ip':
					for ($i=0; $i < count($user_info); $i++) {
						$user_info[$i]['regist_ip'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$user_info[$i]['regist_ip'],1);					
					}
					break;
				case 'sj':
					for ($i=0; $i < count($user_info); $i++) {
						$user_info[$i]['created_at'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$user_info[$i]['created_at'],1);					
					}
					break;
			}
		}
		$search_data['clean_output']['users'] = $user_info;
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('user/_user_search_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
				)
			);
	}

	/**
	 * ajax返回用户信息
	 */
	public function user_info_html(){
		$this->load->library('area_service');
		$user_id = $this->input->post('user_id');
		$user_info['user'] = $this->user_service->get_user_info($user_id);
		$user_info['user']['address'] = $this->area_service->get_user_area($user_info['user']);
		$this->ajax_json_response(SUCCESS_CODE, array('html' => $this->layout->view('user/_user_info_html', $user_info, true)));
	}
}
