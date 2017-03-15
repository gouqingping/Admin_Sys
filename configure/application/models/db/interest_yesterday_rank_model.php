<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Interest_yesterday_rank_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 删除前一天赞助牛币表数据
	 */
	public function delete_table(){
		return $this->truncate_table('t_interest_yesterday_rank');
	}
	
	/**
	 * 添加前一天赞助牛币表数据
	 */
	public function add_interest_yesterday($data){
		return $this->insert_data('t_interest_yesterday_rank', $data);
	}
}