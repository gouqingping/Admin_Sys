<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Favorite_interest_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 获取关注次数最多的兴趣
	 */
	function get_interest_number($b_time = null, $e_time = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	interest_id,
	COUNT(interest_id) num 
FROM
	t_favorite_interest
WHERE
	interest_id > 0
END;

		if($b_time !== null && $e_time !== null){
			$sql .= ' AND created_at >= ? AND created_at <= ?';
			$bind_array[] = $b_time;
			$bind_array[] = $e_time;
		}
		$sql .= ' GROUP BY interest_id ORDER BY num DESC LIMIT ?';
		$bind_array[] = INTEREST_FAVORITE_LIMIT;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	public function add_interest($data) {
		return $this->insert_data('t_favorite_interest', $data);
	}
} 
