<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Message_model extends Db_model {

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 添加消息
	 */
	public function add_message($data) {
		return $this->insert_data('t_message', $data);
	}
} 
