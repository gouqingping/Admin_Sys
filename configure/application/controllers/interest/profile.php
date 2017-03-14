<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class Profile extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('user_service');
		$this->load->library('interest_service');
		//判断是否登录
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}
	
	/**
	 * 兴趣管理
	 */
	public function interest_index(){
		$this->layout->css(array('interest.css'));
		$this->layout->view('interest/profile/interest_index');
	}
	
	/**
	 * ajax返回申请中的兴趣内容
	 */
	public function interest_apply_html(){
		$from_field = $this->input->post('from_field');
		$by = $this->input->post('by');
		$offset = $this->uri->segment(4)?$this->uri->segment(4):1;
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('i.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('i.name' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('i.is_active' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('f_num' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('i.created_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('i.updated_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('u.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_8':
				$order = array('au.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_9':
				$order = array('i.content' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->interest_service->count_interest_apply(null);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'interest/profile/interest_apply_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_INTEREST_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$search_data['clean_output']['interest'] = $this->interest_service->find_interest_apply(null, $order, PAGEING_INTEREST_NUM, ($offset-1)*PAGEING_INTEREST_NUM);
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$search_data['type'] = 'apply';
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('interest/_interest_search_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
				)
			);
	}

	/**
	 * ajax返回兴趣内容
	 */
	public function interest_html(){
		$from_val = $this->input->post('from_val');
		$from_field = $this->input->post('from_field');
		$by = $this->input->post('by');
		$offset = $this->uri->segment(4)?$this->uri->segment(4):1;
		$where = null;
		if($from_val != ''){
			$where = array(array('logic' => ' WHERE ', 'key' => 'name', 'opn' => ' like ', 'val' => '%'.$from_val.'%'));
		}
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('i.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('i.name' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('i.is_active' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('f_num' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('i.created_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('i.updated_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('u.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_8':
				$order = array('au.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_9':
				$order = array('i.content' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->interest_service->count_interest_where($where);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'interest/profile/interest_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_INTEREST_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$interest = $this->interest_service->find_interest_search_where($where, $order, PAGEING_INTEREST_NUM, ($offset-1)*PAGEING_INTEREST_NUM);
		if($from_val != ''){
			for ($i=0; $i < count($interest); $i++) {
				$interest[$i]['name'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$interest[$i]['name'],1);					
			}
		}
		$search_data['clean_output']['interest'] = $interest;
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$search_data['type'] = 'search';
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('interest/_interest_search_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
				)
			);
	}

	/**
	 * ajax返回审核页面
	 */
	public function interest_examine(){
		$examine = array();
		$t_ids = $this->input->post('t_id');
		$val = implode(',',$t_ids);
		$where[] = array('logic' => ' WHERE ', 'key' => 'i.id', 'opn' => ' in ', 'val' => '('.$val.')');
		$aooly = $this->interest_service->find_interest_apply($where);
		$name = '';
		foreach($aooly as $key => $val){
			$name .= '['.$val['name'].']';
		}
		$examine['examine'] = $name;
		$this->ajax_json_response(SUCCESS_CODE, array('html' => $this->layout->view('interest/_interest_examine_html', $examine, true)));
	}
	
	/**
	 * ajax保存审核
	 */
	public function interest_examine_save(){
		
		$user_id = $this->user_service->get_user_id();
		$t_ids = $this->input->post('t_id');
		$examine = $this->input->post('examine');
		$val = implode(',',$t_ids);
		$where[] = array('logic' => ' WHERE ', 'key' => 'i.id', 'opn' => ' in ', 'val' => '('.$val.')');
		$apply = $this->interest_service->find_interest_apply($where);
		if($examine == 'yes'){
			foreach($apply as $val){
				$this->interest_service->add_interest($val, $user_id);
			}
		}else{
			$this->load->library('upload_service');
			$service_url = $this->config->item('interest');
			foreach($apply as $val){
				$img = $this->config->item('interest_thum_img');
				foreach($img as $cm){
					$this->upload_service->delete_file_server($service_url.$cm['Prefix'].$val['icon']);
				}
				$this->interest_service->delete_interest_apply(array('id' => $val['id']));
			}
		}
		$this->ajax_json_response(SUCCESS_CODE);
	}
}