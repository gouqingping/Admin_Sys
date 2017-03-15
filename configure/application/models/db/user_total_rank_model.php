<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class User_total_rank_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 删除用户总排行表数据
	 */
	public function delete_table(){
		return $this->truncate_table('t_user_total_rank');
	}
	
	/**
	 * 添加用户总排行表数据
	 */
	public function add_user_total($data){
		return $this->insert_data('t_user_total_rank', $data);
	}
}