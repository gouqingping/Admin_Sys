<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * base model
 * @author yang.tianxiang
 *
 */
class Db_model extends CI_Model {

    protected $db_obj;
    
    public function __construct()
    {
        parent::__construct();
        
    }
    

    // getter/setter
    public function get_db_obj()
    {
        if (!isset($this->db_obj)) {
            throw new Exception('DB connect error');
        }
        return $this->db_obj;
    }

    public function set_db_obj($db_obj)
    {
        $this->db_obj   = $db_obj;
    }
    
    public function insert_data($table, $data)
    {
    	$data['created_at'] = get_now_time();
    	
    	$this->get_db_obj()->insert($table, $data);
    	return $this->get_db_obj()->insert_id();
    }
    
    public function update_data($table, $data, $where)
    {
    	$data['updated_at'] = get_now_time();
    	foreach($data as $k => $v) {
    		if (strstr($k, 	'__uc_')) {
    			$this->get_db_obj()->set(str_replace('__uc_','', $k), $v, false);
    		} else {
    			$this->get_db_obj()->set($k, $v);
    		}
    	}
    	$this->get_db_obj()->where($where);
    	return $this->get_db_obj()->update($table);
    }
    
    public function delete_data($table, $where, $data = array())
    {
    	$data['is_active'] = 0;
    	$data['deleted_at'] = get_now_time();
    	
    	return $this->get_db_obj()->update($table, $data, $where);
    }
	
	public function delete($table, $where){
		return $this->get_db_obj()->delete($table, $where);
	}
	
	public function truncate_table($table){
		$sql = "TRUNCATE TABLE ".$table;
		return $this->get_db_obj()->query($sql);
	}
} 
