<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class top extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('user_service');
		$this->load->library('post_service');
		$this->load->library('comment_service');
		$this->load->library('interest_service');
		//判断是否登录
		if (!$this->user_service->is_active()){
			redirect(base_url() . 'user/account/login');
			exit;
		}
	}
	
    /**
	 * 用户登录首页面板
	 */
	public function panel_index(){
		$this->layout->css(array('panel.css'));
		$data = array();
		//用户量
		$data['user'] = array();
		$user_coutn['sum'] = $this->user_service->count_user_where(null);
		$user_coutn['month_sum'] = $this->user_service->count_user_where(array(array('logic' => ' WHERE ', 'key' => 'u.created_at', 'opn' => ' like ', 'val' => get_now_time('Y-m').'%')));
		$user_coutn['day_sum'] = $this->user_service->count_user_where(array(array('logic' => ' WHERE ', 'key' => 'u.created_at', 'opn' => ' like ', 'val' => get_now_time('Y-m-d').'%')));
		$day = $user_coutn['month_sum']/get_now_time('d');
		$user_coutn['per'] = 0.00;
		if($user_coutn['day_sum'] > 0){
			$user_coutn['per'] = number_format(($user_coutn['day_sum'] / $day * 100), 2, '.', '');
		}
		$data['user'] = $user_coutn;
		//帖子量
		$data['post'] = array();
		$post_coutn['sum'] = $this->post_service->count_post_where(null);
		$post_coutn['month_sum'] = $this->post_service->count_post_where(array(array('logic' => ' WHERE ', 'key' => 'p.created_at', 'opn' => ' like ', 'val' => get_now_time('Y-m').'%')));
		$post_coutn['day_sum'] = $this->post_service->count_post_where(array(array('logic' => ' WHERE ', 'key' => 'p.created_at', 'opn' => ' like ', 'val' => get_now_time('Y-m-d').'%')));
		$day = $post_coutn['month_sum']/get_now_time('d');
		$post_coutn['per'] = 0.00;
		if($post_coutn['day_sum'] > 0){
			$post_coutn['per'] = number_format(($post_coutn['day_sum'] / $day * 100), 2, '.', '');
		}
		$data['post'] = $post_coutn;
		//评论量
		$data['comment'] = array();
		$comment_coutn['sum'] = $this->comment_service->count_comment_where(null);
		$comment_coutn['month_sum'] = $this->comment_service->count_comment_where(array(array('logic' => ' WHERE ', 'key' => 'c.created_at', 'opn' => ' like ', 'val' => get_now_time('Y-m').'%')));
		$comment_coutn['day_sum'] = $this->comment_service->count_comment_where(array(array('logic' => ' WHERE ', 'key' => 'c.created_at', 'opn' => ' like ', 'val' => get_now_time('Y-m-d').'%')));
		$day = $comment_coutn['month_sum']/get_now_time('d');
		$comment_coutn['per'] = 0.00;
		if($comment_coutn['day_sum'] > 0){
			$comment_coutn['per'] = number_format(($comment_coutn['day_sum'] / $day * 100), 2, '.', '');
		}
		$data['comment'] = $comment_coutn;		
		//兴趣量
		$data['interest'] = array();
		$interest_coutn['sum'] = $this->interest_service->count_interest_where(null);
		$interest_coutn['month_sum'] = $this->interest_service->count_interest_where(array(array('logic' => ' WHERE ', 'key' => 'created_at', 'opn' => ' like ', 'val' => get_now_time('Y-m').'%')));
		$interest_coutn['day_sum'] = $this->interest_service->count_interest_where(array(array('logic' => ' WHERE ', 'key' => 'created_at', 'opn' => ' like ', 'val' => get_now_time('Y-m-d').'%')));
		$day = $interest_coutn['month_sum']/get_now_time('d');
		$interest_coutn['per'] = 0.00;
		if($interest_coutn['day_sum'] > 0){
			$interest_coutn['per'] = number_format(($interest_coutn['day_sum'] / $day * 100), 2, '.', '');
		}
		$data['interest'] = $interest_coutn;
		
		$post_html['post_html'] = $this->post_service->find_hot_post_by_date(get_now_time('Y-m-d'));
		$data['clean_output']['post_html'] = $this->layout->view('panel/_index_post_html', $post_html, true);
		
		$interest_html['interest_html'] = $this->interest_service->find_hot_interest_by_date(get_now_time('Y-m-d'));
		$data['clean_output']['interest_html'] = $this->layout->view('panel/_index_interest_html', $interest_html, true);
		
		$this->layout->view('panel/top/panel_index', $data);
	}

    /**
	 *ajax 返回首页历史记录
	 */
	public function index_table_html(){
		$date_key = $this->input->post('date_key');
		$date = get_time_month(-$date_key, 'Y-m');
		$user['data'] = $this->user_service->count_user_by_date($date, '%Y-%m-%d');
		$post['data'] = $this->post_service->count_post_by_date($date, '%Y-%m-%d');
		$comment['data'] = $this->comment_service->count_comment_by_date($date, '%Y-%m-%d');
		$interest['data'] = $this->interest_service->count_interest_by_date($date, '%Y-%m-%d');
		
		$user['date'] = $date;
		$post['date'] = $date;
		$comment['date'] = $date;
		$interest['date'] = $date;
		
		if($date_key == 0){
			$day = (int)get_now_time('d');
		}else{
			$day = date("t", mktime(0, 0, 0, get_time_month(-$date_key, 'm'), 1, get_time_month(-$date_key, 'Y')));
		}
		$user['sum'] = $day;
		$post['sum'] = $day;
		$comment['sum'] = $day;
		$interest['sum'] = $day;

		$this->ajax_json_response(SUCCESS_CODE, 
			array(
				'user_table_html' => $this->layout->view('panel/_index_table_html', $user, true),
				'post_table_html' => $this->layout->view('panel/_index_table_html', $post, true),
				'comment_table_html' => $this->layout->view('panel/_index_table_html', $comment, true),
				'interest_table_html' => $this->layout->view('panel/_index_table_html', $interest, true)
			)
		);
	}
}