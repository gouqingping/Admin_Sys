<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class Profile extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('user_service');
		$this->load->library('comment_service');
		//判断是否登录
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}

	/**
	 * ajax返回评论信息
	 */
	public function comment_html(){
		$from_val = $this->input->post('from_val');
		$from_field = $this->input->post('from_field');
		$by = $this->input->post('by');
		$offset = $this->uri->segment(4)?$this->uri->segment(4):1;
		$where = null;
		if($from_val != ''){
			$where = array(array('logic' => ' WHERE ', 'key' => 'comment', 'opn' => ' like ', 'val' => '%'.$from_val.'%'));
		}
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('c.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('u.nickname' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('c.created_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('c.updated_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('c.deleted_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('c.platform' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('c.is_active' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_8':
				$order = array('c.gold' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_9':
				$order = array('c.comment' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->comment_service->count_comment_where($where);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'comment/profile/comment_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_COMMENT_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$comment = $this->comment_service->find_comment_search_where($where, $order, PAGEING_COMMENT_NUM, ($offset-1)*PAGEING_COMMENT_NUM);
//		if($from_val != ''){
//			for ($i=0; $i < count($comment); $i++) {
//				$comment[$i]['comment'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$comment[$i]['comment'],1);					
//			}
//		}
		$search_data['comment'] = $comment;
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$search_data['type'] = 'comment';
		$search_data['from_val'] = $from_val;
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('comment/_comment_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
				)
			);
	}
}