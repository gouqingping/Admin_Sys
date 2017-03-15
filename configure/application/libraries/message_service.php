<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'base_service.php';

class Message_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('db/message_model');
	}
	
	public function add_message($data) {
		$this->message_model->set_db_obj($this->ci->db_master);
		return $this->message_model->add_message($data);
	}
}
