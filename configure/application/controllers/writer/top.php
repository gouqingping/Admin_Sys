<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/base_controller.php');

class Top extends Base_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('writer_info_service');
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}
	
	/**
	 * ajax返回订单搜索内容
	 */
	public function writer_info_html(){
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
				case 'zfbzh':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'w.pay_account', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
				case 'qq':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'w.qq', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
				case 'dz':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'w.contact_address', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
				case 'xm':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'w.name', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;
				case 'sfz':
					$where = array(
						array('logic' => ' WHERE ', 'key' => 'w.identity_card', 'opn' => ' like ', 'val' => '%'.$from_val.'%')
					);
					break;				
			}
		}
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('w.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('u.nickname' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('w.pay_account' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('w.qq' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('w.contact_address' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('w.step' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('w.pay_account_updated_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_8':
				$order = array('w.name' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_9':
				$order = array('w.is_active' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_10':
				$order = array('w.identity_card' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_11':
				$order = array('w.updated_at' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->writer_info_service->count_writer_info_where($where);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'writer/top/writer_info_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_WRITER_INFO_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$writer_info = $this->writer_info_service->find_writer_info_where($where, $order, PAGEING_WRITER_INFO_NUM, ($offset-1)*PAGEING_WRITER_INFO_NUM);
		if($from_val != ''){
			switch($from_key){
				case 'nc':
					for ($i=0; $i < count($writer_info); $i++) {
						$writer_info[$i]['nickname'] = preg_replace('/'.$from_val.'/i','<span class="violet">'.$from_val.'</span>',$writer_info[$i]['nickname'],1);					
					}
					break;
				case 'zfbzh':
					for ($i=0; $i < count($writer_info); $i++) {
						$writer_info[$i]['pay_account'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$writer_info[$i]['pay_account'],1);					
					}
					break;
				case 'qq':
					for ($i=0; $i < count($writer_info); $i++) {
						$writer_info[$i]['qq'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$writer_info[$i]['qq'],1);					
					}
					break;
				case 'dz':
					for ($i=0; $i < count($writer_info); $i++) {
						$writer_info[$i]['contact_address'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$writer_info[$i]['contact_address'],1);					
					}
					break;
				case 'xm':
					for ($i=0; $i < count($writer_info); $i++) {
						$writer_info[$i]['name'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$writer_info[$i]['name'],1);					
					}
					break;
				case 'sfz':
					for ($i=0; $i < count($writer_info); $i++) {
						$writer_info[$i]['identity_card'] = preg_replace('/'.$from_val.'/','<span class="violet">'.$from_val.'</span>',$writer_info[$i]['identity_card'],1);					
					}
					break;
			}
		}
		$search_data['clean_output']['writer_info'] = $writer_info;
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('writer/_writer_info_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
			)
		);
	}

	/**
	 * ajax处理实名认证
	 */
	public function approve_message_html(){
		$writer_id = $this->input->post('key');
		if($writer = $this->writer_info_service->get_by_id($writer_id, true)){
			$user = $this->user_service->get_user_by_id($writer['user_id']);
			$data['writer'] = $writer;
			$data['user'] = $user;
			$this->ajax_json_response(SUCCESS_CODE, 
				array(
					'html' => $this->layout->view('writer/_approve_message_html', $data, true)
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
			$this->writer_info_service->update_writer(array('is_active' => 0), $id);
		}
		$this->ajax_json_response(SUCCESS_CODE);
	}

	/*
	 * ajax身份认证
	 */
	public function authentication(){
		$writer_id = $this->input->post('key');
		$handle = $this->input->post('handle');
		$explain = $this->input->post('explain');
		if($writer = $this->writer_info_service->get_by_id($writer_id, true)){
			switch($handle){
				case 'no':
					$step = $writer['step'];
					$step = to_be_writer_step($step, WRITER_STEP_2)?$step-WRITER_STEP_2:$step;
					$step += WRITER_STEP_4;
					$is_update = $this->writer_info_service->update_writer(array('step' => $step), $writer_id);
					$msg['send_by_user_id'] = 0;
					$msg['receive_by_user_id'] = $writer['user_id'];
					$msg['content'] = $explain;
					$msg['type'] = 1;
					$this->load->library('message_service');
					$this->message_service->add_message($msg);
					$status = is_writer($step)?'已通过':'未通过';
					$this->ajax_json_response(SUCCESS_CODE, array('is_update' => TRUE, 'status' => FALSE, 'title' => $status));
				break;
				case 'yes':
					$step = $writer['step'];
					$step = to_be_writer_step($step, WRITER_STEP_4)?$step-WRITER_STEP_4:$step;
					$step += WRITER_STEP_2;
					$is_update = $this->writer_info_service->update_writer(array('step' => $step), $writer_id);
					$msg['send_by_user_id'] = 0;
					$msg['receive_by_user_id'] = $writer['user_id'];
					$msg['content'] = $explain;
					$msg['type'] = 1;
					$this->load->library('message_service');
					$this->message_service->add_message($msg);
					$status = is_writer($step)?'已通过':'未通过';
					$this->ajax_json_response(SUCCESS_CODE, array('is_update' => TRUE, 'status' => TRUE, 'title' => $status));
				break;
			}
		}else{
			$this->ajax_json_response(SUCCESS_CODE, FALSE);
		}
	}
}