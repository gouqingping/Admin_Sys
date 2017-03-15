<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Html_model extends Db_model {

	public function __construct() {
		parent::__construct();
	}
	
	public function get_html_by_id($id){
		$bind_array = array($id);
		$sql = <<< END
SELECT
	*
FROM
	t_html
WHERE
	id = ?
END;
	return $this->get_db_obj()->query($sql, $bind_array)->row_array();
	}
	
	/**
	 * 添加静态html
	 * $data 静态html信息
	 */
	public function add_html($data){
		return $this->insert_data('t_html', $data);
	}
	
	/**
	 * 更变静态html信息
	 * $id 编号id
	 * $data 静态html信息
	 */
	public function update_html($id, $data){
		$where = array('id' => $id);
		return $this->update_data('t_html', $data, $where);
	}
}