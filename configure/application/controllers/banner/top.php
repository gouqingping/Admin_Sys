<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/base_controller.php');

class Top extends Base_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('ad_banner_service');
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}
	
	/**
	 * ajax返回banner列表信息
	 */
	public function banner_html(){
		$from_key = $this->input->post('from_key');
		$from_val = $this->input->post('from_val');
		$from_field = $this->input->post('from_field');
		$by = $this->input->post('by');
		$offset = $this->uri->segment(4)?$this->uri->segment(4):1;
		$user_id = $this->user_service->get_user_id();
		$where = null;
		if($from_val != ''){
			//switch($from_key){}
		}
		//排序
		$order = null;
		switch($from_field){
			case 'sort_1':
				$order = array('b.id' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_2':
				$order = array('b.title' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_3':
				$order = array('b.type' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_4':
				$order = array('b.is_active' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_5':
				$order = array('b.created_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_6':
				$order = array('b.begin_at' => $by=='d'?'DESC':'ASC');
				break;
			case 'sort_7':
				$order = array('b.end_at' => $by=='d'?'DESC':'ASC');
				break;
		}
		//分页
		$total = $this->ad_banner_service->count_banner_where($where);
		$this->load->library('ajax_pagination_service');
		$config['base_url'] = base_url().'banner/top/banner_html';
		$config['total_rows'] = $total;
		$config['per_page'] = PAGEING_BANNER_NUM;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 4;
		$config = array_merge($config, get_pagination_config());
		$this->ajax_pagination_service->initialize($config); 
		$paging = $this->ajax_pagination_service->create_links();
		//获取数据
		$banner = $this->ad_banner_service->find_banner_where($where, $order, PAGEING_BANNER_NUM, ($offset-1)*PAGEING_BANNER_NUM);
		if($from_val != ''){
			//switch($from_key){}
		}
		$search_data['clean_output']['banner'] = $banner;
		$search_data['from_field'] = $from_field;
		$search_data['by'] = $by;
		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'html' => $this->layout->view('banner/_banner_html', $search_data, true),
				'paging' => $paging,
				'pagcount' => $total
			)
		);
	}
	
	/**
	 * 编辑banner
	 */
	public function edit_banner(){
		$this->load->library('upload_service');
		$banner_data['title'] = $this->input->post('title');
		$banner_data['type'] = $this->input->post('type');
		$url = $this->input->post('url');
		if(!check_url($url)){//非法网络url地址
			$this->ajax_json_response(SUCCESS_CODE, '非法网络url地址');
			exit;
		}
		$u = explode('/',$url);
		if($banner_data['type'] == TYPE_BANNER_HTML){
			$banner_data['t_id'] = decrypt_id($u[count($u)-1]);
		}
		$banner_data['url'] = $url;
		$banner_data['is_active'] = $this->input->post('is_active');
		$banner_data['begin_at'] = $this->input->post('begin_at');
		$banner_data['end_at'] = $this->input->post('end_at');
		$id = $this->input->post('id');
		$where = array(array('logic' => ' WHERE ', 'key' => 'b.id', 'opn' => ' = ', 'val' => $id));
		$banner = $this->ad_banner_service->find_banner_where($where);
		if($imag = $this->input->post('imag')){
			$img_url = CNGROOT_PATH.'/docroot/upload/images/banner/temp/'.$imag;//上传图片物理路径名称
			$Prefix = $this->config->item('banner');//图片服务器虚拟路径
			$this->load->library('crop_service');
			$name =$this->crop_service->get_img_name();
			$save_name = $Prefix.$name.$imag;//完整图片名称
			$ask = $this->upload_service->upload_file_server($img_url, $save_name);
			if($ask){
				unlink($img_url);
	        	$banner_data['img'] = $name.$imag;
				if($id){
					$this->upload_service->delete_file_server($Prefix.$banner[0]['img']);
				}
			}else{//图片上传失败
				$this->ajax_json_response(SUCCESS_CODE, '图片上传失败');
				exit;
			}
		}
		
		$this->load->library('html_service');
		$text_html = $this->input->post('text_html');
		if($id){
			if($text_html){
				if($banner[0]['t_id']){
					$this->html_service->update_html($banner[0]['t_id'], array('html' => $text_html));
					$CI =& get_instance();
					$url = $CI->config->item('domain_url').'banner/profile/html/'.encrypt_id($banner[0]['t_id']);
					$banner_data['url'] = $url;
				}else{
					$t_id = $this->html_service->add_html(array('html' => $text_html));
					$banner_data['t_id'] = $t_id;
					$CI =& get_instance();
					$url = $CI->config->item('domain_url').'banner/profile/html/'.encrypt_id($t_id);
					$banner_data['url'] = $url;
				}
			}
			$this->ad_banner_service->update_banner($id, $banner_data);
		}else{
			if($banner_data['img']){
				if($text_html){
					$t_id = $this->html_service->add_html(array('html' => $text_html));
					$banner_data['t_id'] = $t_id;
					$CI =& get_instance();
					$url = $CI->config->item('domain_url').'banner/profile/html/'.encrypt_id($t_id);
					$banner_data['url'] = $url;
				}
				$this->ad_banner_service->add_banner($banner_data);
			}
		}
		$this->ajax_json_response(SUCCESS_CODE, '保存成功');
	}
}