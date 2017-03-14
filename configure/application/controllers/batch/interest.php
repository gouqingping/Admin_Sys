<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

include_once (APPPATH . 'controllers/base_controller.php');

class Interest extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
        $this->load->db_master(TRUE);
        $this->load->db_slave();
	}
	
	/**
	 * 获取推荐兴趣
	 * 以前一天发帖量,关注数,评论数,赞助次数整合抽出兴趣进行推荐
	 */
	public function recommend(){
		$this->load->library('post_service');
		$this->load->library('favorite_interest_service');
		$this->load->library('comment_service');
		$this->load->library('user_gold_service');
		$this->load->library('recommend_interest_service');
		$this->recommend_interest_service->delete_table();//删除推荐兴趣表数据
		if(INTEREST_TIME >= 1){
			$b_time = get_time_day('-'.INTEREST_TIME, 'Y-m-d');
			$e_time = get_now_time();
			$this->add_recommend($this->post_service->get_interest_number($b_time, $e_time));//发帖次数最多的
			$this->add_recommend($this->favorite_interest_service->get_interest_number($b_time, $e_time));//关注次数最多的
			$this->add_recommend($this->comment_service->get_interest_number($b_time, $e_time));//评论次数最多的
			$this->add_recommend($this->user_gold_service->get_interest_number($b_time, $e_time));//赞助次数最多的
		}else{
			$this->add_recommend($this->post_service->get_interest_number());//发帖次数最多的
			$this->add_recommend($this->favorite_interest_service->get_interest_number());//关注次数最多的
			$this->add_recommend($this->comment_service->get_interest_number());//评论次数最多的
			$this->add_recommend($this->user_gold_service->get_interest_number());//赞助次数最多的
		}
		echo '处理完成';
		exit;
	}
	
	/**
	 * 添加推荐兴趣
	 */
	private function add_recommend($obj){
		if($obj){
			foreach($obj as $v){
				if(!$this->recommend_interest_service->get_recommend_by_interest_id($v['interest_id'])){
					$data = array(
						'interest_id' => $v['interest_id'],
						'is_active' => 1
					);
					$this->recommend_interest_service->add_recommend($data);
				}
			}
		}
	}
	
	/*
	 * 获取兴趣总牛币数
	 * 通过赞助明细获取所有兴趣收到的总牛币数
	 */
	public function interest_total(){
		$interest_gold = $this->get_interest_gold();
		if($interest_gold){
			$this->load->library('interest_total_rank_service');
			$this->interest_total_rank_service->delete_table();//删除赞助总牛币表数据
			$this->add_interest_gold($interest_gold, 'total');
		}
		echo '处理完成';
		exit;
	}
	
	/*
	 * 获取兴趣前一天被赞助的的牛币数
	 * 通过赞助明细获取所有兴趣收到的总牛币数
	 */
	public function interest_yesterday(){
		$b_time = get_time_day('-2', 'Y-m-d 00:00:00');
		$interest_gold = $this->get_interest_gold($b_time);
		if($interest_gold){
			$this->load->library('interest_yesterday_rank_service');
			$this->interest_yesterday_rank_service->delete_table();//删除前一天的赞助牛币表数据
			$this->add_interest_gold($interest_gold, 'day');
		}
		echo '处理完成';
		exit;
	}
	
	/*
	 * 获取兴趣赞助的牛币数
	 */
	private function get_interest_gold($b_date = null){
		$e_date = get_time_day('-1', 'Y-m-d 23:59:59');
		$this->load->library('user_gold_service');
		return $this->user_gold_service->get_interest_gold($b_date, $e_date);
	}
	
	private function add_interest_gold($obj, $type){
		$data = array();
		foreach($obj as $v){
			$data['interest_id'] = $v['interest_id'];
			$data['gold'] = $v['gold'];
			switch($type){
				case 'total':
					$this->load->library('interest_total_rank_service');
					$this->interest_total_rank_service->add_interest_total($data);
				break;
				case 'day':
					$this->load->library('interest_yesterday_rank_service');
					$this->interest_yesterday_rank_service->add_interest_yesterday($data);
				break;
			}
		}
	}
}