<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Interest_total_rank_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 删除赞助总牛币表数据
	 */
	public function delete_table(){
		return $this->truncate_table('t_interest_total_rank');
	}
	
	/**
	 * 添加赞助总牛币表数据
	 */
	public function add_interest_total($data){
		return $this->insert_data('t_interest_total_rank', $data);
	}
}