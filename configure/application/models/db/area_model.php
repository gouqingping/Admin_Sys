<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Area_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}
	
	function find_area_by_parent_id($parent_id, $is_active = null)
	{
		$bind_array = array($parent_id);
		
		$sql = <<< END
SELECT
	*
FROM
	m_area
WHERE
	parent_id = ?
END;

	if ($is_active !== null) {
		$sql .= ' AND is_active = ?';
		$bind_array[] = $is_active;
	}

	return $this->get_db_obj()->query($sql, $bind_array)->result_array(); 
	}
	
	function get_area_by_id($id, $is_active = null)
	{
		$bind_array = array($id);
		
		$sql = <<< END
SELECT
	*
FROM
	m_area
WHERE
	id = ?
END;

	if ($is_active !== null) {
		$sql .= ' AND is_active = ?';
		$bind_array[] = $is_active;
	}

	return $this->get_db_obj()->query($sql, $bind_array)->row_array(); 
	}
} 
