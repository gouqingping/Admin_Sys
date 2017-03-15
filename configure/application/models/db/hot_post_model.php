<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Hot_post_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 删除热帖表数据
	 */
	public function delete_table(){
		return $this->truncate_table('t_hot_post');
	}
	
	/**
	 * 添加计算出的新数据
	 */
	public function add_hot_post($data){
		return $this->insert_data('t_hot_post', $data);
	}
}