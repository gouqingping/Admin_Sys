<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class Profile extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('user_service');
		$this->load->library('post_service');
		//判断是否登录
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}

	/**
	 * ajax返回投诉内容
	 */
	public function post_html(){
		$from_val = $this->input->post('from_val');
		$from_field = $this->input->post('from_field');
		$by = $this->input->post('by');
		$offset = $this->uri->segment(4)?$this->uri->segment(4):1;
		$where = null;
		if($from_val != ''){
			$where = array(
						array('logic' => ' WHERE ', 'key' => 'p.content', 'opn' => ' like ', 'val' => '%'.$from_val.'%'),
						array('logic' => ' OR ', 'key' => 'p.name', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
		}
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('p.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('u.nickname' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('p.created_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('p.updated_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('p.deleted_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('p.platform' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('p.is_active' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_8':
				$order = array('p.gold' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_9':
				$order = array('interest_name' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_10':
				$order = array('post_name' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_11':
				$order = array('p.content' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->post_service->count_post_where($where);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'post/profile/post_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_POST_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$post = $this->post_service->find_post_search_where($where, $order, PAGEING_POST_NUM, ($offset-1)*PAGEING_POST_NUM);
//		if($from_val != ''){
//			for ($i=0; $i < count($post); $i++) {
//				$post[$i]['content'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$post[$i]['content'],1);					
//			}
//		}
		$search_data['clean_output']['post'] = $post;
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$search_data['type'] = 'post';
		$search_data['from_val'] = $from_val;
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('post/_post_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
				)
			);
	}
}