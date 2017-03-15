<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * base service
 *
 * @author yang.tianxiang
 *
 */
class Base_service {

	protected $ci = null;

	public function __construct(){
		if (is_null($this->ci)) {
			$this->ci = &get_instance();
		}
	}

	public function __get($prop){

		if (isset($this->ci->$prop)) {
			$ret = $this->ci->$prop;
		}
		return $ret;
	}
}
