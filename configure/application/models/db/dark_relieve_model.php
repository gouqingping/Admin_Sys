<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Dark_relieve_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 添加解除封禁
	 * $data
	 */
	public function add_dark_relieve($data){
		return $this->insert_data('t_dark_relieve', $data);
	}
}