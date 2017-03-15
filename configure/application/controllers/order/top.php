<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/base_controller.php');

class Top extends Base_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('gold_order_service');
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}
	
	/**
	 * ajax返回订单搜索内容
	 */
	public function gold_order_html(){
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
						array('logic' => ' WHERE ', 'key' => 'u.nickname', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
				case 'dzbh':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'go.order_num', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
				case 'czbh':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'go.trade_num', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
			}
		}
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('go.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('u.nickname' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('go.order_num' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('go.trade_num' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('go.type' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('go.status' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('go.gold' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_8':
				$order = array('go.money' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_9':
				$order = array('go.is_active' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_10':
				$order = array('go.created_at' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->gold_order_service->count_gold_order_where($where);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'order/top/gold_order_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_GOLD_ORDER_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$gold_order = $this->gold_order_service->find_gold_order_where($where, $order, PAGEING_GOLD_ORDER_NUM, ($offset-1)*PAGEING_GOLD_ORDER_NUM);
		if($from_val != ''){
			switch($from_key){
				case 'nc':
					for ($i=0; $i < count($gold_order); $i++) {
						$gold_order[$i]['nickname'] = preg_replace('/'.$from_val.'/i','<span class="violet">'.$from_val.'</span>',$gold_order[$i]['nickname'],1);					
					}
					break;
				case 'dzbh':
					for ($i=0; $i < count($gold_order); $i++) {
						$gold_order[$i]['order_num'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$gold_order[$i]['order_num'],1);					
					}
					break;
				case 'czbh':
					for ($i=0; $i < count($gold_order); $i++) {
						$gold_order[$i]['trade_num'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$gold_order[$i]['trade_num'],1);					
					}
					break;
			}
		}
		$search_data['clean_output']['gold_order'] = $gold_order;
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('order/_gold_order_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
				)
			);
	}

	/**
	 * ajax设置所选择的数据无效
	 */
	public function click_active(){
		$id_s = $this->input->post('id_s');
		foreach($id_s as $id){
			$this->gold_order_service->update_gold_order(array('is_active' => 0), $id);
		}
		$this->ajax_json_response(SUCCESS_CODE);
	}
}