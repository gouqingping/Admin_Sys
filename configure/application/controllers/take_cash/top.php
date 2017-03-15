<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/base_controller.php');

class Top extends Base_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('take_cash_service');
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}
	
	/**
	 * ajax返回订单搜索内容
	 */
	public function take_cash_html(){
		$from_key = $this->input->post('from_key');
		$from_val = $this->input->post('from_val');
		$from_field = $this->input->post('from_field');
		$by = $this->input->post('by');
		$offset = $this->uri->segment(4)?$this->uri->segment(4):1;
		$where = null;
		if($from_val != ''){
			switch($from_key){
				case 'nc':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'u.nickname', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
				case 'jb':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'tc.rank', 'opn' => ' = ', 'val' => $from_val)
					);
					break;
				case 'nb':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'tc.gold', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
				case 'je':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'tc.money', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
				case 'sj':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'tc.created_at', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
			}
		}
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('tc.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('u.nickname' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('tc.rank' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('tc.gold' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('tc.money' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('tc.status' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('tc.is_active' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_8':
				$order = array('tc.created_at' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->take_cash_service->count_take_cash_where($where);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'take_cash/top/take_cash_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_TAKE_CASH_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$take_cash = $this->take_cash_service->find_take_cash_where($where, $order, PAGEING_TAKE_CASH_NUM, ($offset-1)*PAGEING_TAKE_CASH_NUM);
		if($from_val != ''){
			switch($from_key){
				case 'nc':
					for ($i=0; $i < count($take_cash); $i++) {
						$take_cash[$i]['nickname'] = preg_replace('/'.$from_val.'/i','<span class="violet">'.$from_val.'</span>',$take_cash[$i]['nickname'],1);					
					}
					break;
				case 'jb':
					for ($i=0; $i < count($take_cash); $i++) {
						$take_cash[$i]['rank'] = preg_replace('/'.$from_val.'/i','<span class="violet">'.$from_val.'</span>',$take_cash[$i]['rank'],1);					
					}
					break;
				case 'nb':
					for ($i=0; $i < count($take_cash); $i++) {
						$take_cash[$i]['gold'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$take_cash[$i]['gold'],1);					
					}
					break;
				case 'je':
					for ($i=0; $i < count($take_cash); $i++) {
						$take_cash[$i]['money'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$take_cash[$i]['money'],1);					
					}
					break;
				case 'sj':
					for ($i=0; $i < count($take_cash); $i++) {
						$take_cash[$i]['created_at'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$take_cash[$i]['created_at'],1);					
					}
					break;
			}
		}
		$search_data['clean_output']['take_cash'] = $take_cash;
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('take_cash/_take_cash_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
				)
			);
	}

	/**
	 * ajax处理实名认证
	 */
	public function payment_message_html(){
		$id = $this->input->post('key');
		if($take_cash = $this->take_cash_service->get_by_id($id, true)){
			$user = $this->user_service->get_user_by_id($take_cash['user_id']);
			$data['take_cash'] = $take_cash;
			$data['user'] = $user;
			$this->ajax_json_response(SUCCESS_CODE, 
				array(
					'html' => $this->layout->view('take_cash/_payment_message_html', $data, true)
				)
			);
		}
	}

	/**
	 * ajax设置所选择的数据无效
	 */
	public function click_active(){
		$id_s = $this->input->post('id_s');
		foreach($id_s as $id){
			$this->take_cash_service->update_take_cash(array('is_active' => 0), $id);
		}
		$this->ajax_json_response(SUCCESS_CODE);
	}

	/*
	 * ajax确认付款
	 */
	public function payment(){
		$id = $this->input->post('key');
		$handle = $this->input->post('handle');
		$explain = $this->input->post('explain');
		$user_id = $this->user_service->get_user_id();
		if($take_cash = $this->take_cash_service->get_by_id($id, true)){
			switch($handle){
				case 'no':
					$is_update = $this->take_cash_service->update_take_cash(array('STATUS' => CASH_ORDER_STATUS_FAIL), $id);
					$msg['send_by_user_id'] = 0;
					$msg['receive_by_user_id'] = $take_cash['user_id'];
					$msg['content'] = $explain;
					$msg['type'] = 1;
					$this->load->library('message_service');
					$this->message_service->add_message($msg);
					//退款添加用户的gold
		            $this->user_service->update_user(array(
		                '__uc_gold' => 'gold+'.$take_cash['gold']), $take_cash['user_id']);
					//添加退款记录
					$this->load->library('user_gold_service');
					$gold_data = array(
		                'accept_user_id' => $take_cash['user_id'],
		                'gold' => $take_cash['gold'],
		                'type' => GOLD_TYPE_REFUND,
		                't_id' => $take_cash['id']
		            );
					$this->user_gold_service->add_user_gold($gold_data);
					$this->ajax_json_response(SUCCESS_CODE, array('is_update' => TRUE, 'status' => FALSE));
				break;
				case 'yes':
					$is_update = $this->take_cash_service->update_take_cash(array('STATUS' => CASH_ORDER_STATUS_SUCCESS), $id);
					$msg['send_by_user_id'] = 0;
					$msg['receive_by_user_id'] = $take_cash['user_id'];
					$msg['content'] = $explain;
					$msg['type'] = 1;
					$this->load->library('message_service');
					$this->message_service->add_message($msg);
					$this->ajax_json_response(SUCCESS_CODE, array('is_update' => TRUE, 'status' => TRUE));
				break;
			}
		}
		$this->ajax_json_response(SUCCESS_CODE, FALSE);
	}
}