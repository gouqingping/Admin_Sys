<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class Profile extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('user_service');
		$this->load->library('impeach_service');
		//判断是否登录
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}

	/**
	 * ajax返回投诉内容
	 */
	public function impeach_html(){
		$from_val = $this->input->post('from_val');
		$from_field = $this->input->post('from_field');
		$by = $this->input->post('by');
		$offset = $this->uri->segment(4)?$this->uri->segment(4):1;
		$where = null;
		$where = array(
						array('logic' => ' WHERE ', 'key' => 'content', 'opn' => ' like ', 'val' => '%'.$from_val.'%'),
						array('logic' => ' AND ', 'key' => 'i.is_active', 'opn' => ' = ', 'val' => 1)
						);
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('i.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('u.nickname' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('i.content_type' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('i.created_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('i.content' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('i.type' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('i.is_active' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->impeach_service->count_impeach_where($where);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'impeach/profile/impeach_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_IMPEACH_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$impeach = $this->impeach_service->find_impeach_search_where($where, $order, PAGEING_IMPEACH_NUM, ($offset-1)*PAGEING_IMPEACH_NUM);
//		if($from_val != ''){
//			for ($i=0; $i < count($impeach); $i++) {
//				//$impeach[$i]['content'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$impeach[$i]['content'],1);					
//			}
//		}
		$search_data['impeach'] = $impeach;
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$search_data['type'] = 'impeach';
		$search_data['from_val'] = $from_val;
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('impeach/_impeach_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
				)
			);
	}

	/**
	 * ajax处理投诉
	 */
	public function impeach_processing_html(){
		$impeach_data =  array();
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('impeach/_impeach_processing_html', $impeach_data, true)
				)
			);
	}
	
	/**
	 * 
	 */
	public function impeach_save(){
		$user_id = $this->user_service->get_user_id();
		$ids = $this->input->post('ids');
		$handle = $this->input->post('handle');
		$explain = $this->lang->line('system_impeach_mas').$this->input->post('explain');
		$val = implode(',',$ids);
		$where[] = array('logic' => ' WHERE ', 'key' => 'i.id', 'opn' => ' in ', 'val' => '('.$val.')');
		$impeach_data = $this->impeach_service->find_impeach_search_where($where);
		foreach($impeach_data as $key => $impeach){
			$msg['send_by_user_id'] = 0;
			$msg['receive_by_user_id'] = $impeach['user_id'];
			$msg['content'] = $explain;
			$msg['type'] = 1;
			$this->impeach_service->processing_save($user_id, $impeach, $msg, $handle);
		}
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => 'ok'
				)
			);
	}
}