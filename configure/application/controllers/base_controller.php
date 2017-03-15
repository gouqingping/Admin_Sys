<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * base controller
 * 
 * @author yang.tianxiang
*/
class Base_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // DB connect
        $this->load->db_master(TRUE);
        $this->load->db_slave();
//      $this->load->redis();
        $this->load->library('user_service');
        
        //判断是否登录
        if(!$this->user_service->is_login()) {
        	//如果没有登录，判断是否保存了密码,自动登录
        	$email = $this->input->cookie('cke');
        	$password = $this->input->cookie('ckp');
        	if ($email && $password) {
	        	if ($user = $this->user_service->get_user_by_email_and_pwd($email, $password)) {
					$this->user_service->set_user_session($user);
					$this->layout->setUser($user);
	        	} else {
	        		show_404();
	        	}
        	}
        }else{
        	$user = $this->user_service->get_user_info($this->user_service->get_user_id());
        	$this->layout->setUser($user);
        }
        
        if (!$this->input->is_ajax_request()) {
        	$class = $this->router->class;
        	$method = $this->router->method;
        	if ($meta = $this->config->item($class.'_'.$method)) {
        		$this->layout->meta($meta);
        	}
        }
       
    }
    
    protected function ajax_json_response($code, $data = array()) {
    	$rs = array(
    		'code' => $code,
    		'data' => $data
    	);
    	echo json_encode($rs);
    	exit;
    }
    
    protected function jquery_autocomplete_ajax_json_response($suggestions,$query=array(), $data=array()) {
    	$rs = array(
    		'query' => $query,
    		'suggestions' => $suggestions,
    		'data' => $data,
    	);
    	echo json_encode($rs);
    	exit;
    }
    
    protected function ajax_string_response($string) {
    	echo $string;
    	exit;
    }
} 