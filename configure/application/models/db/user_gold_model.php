<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class User_gold_model extends Db_model {

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 获取赞助次数最多的兴趣
	 */
	function get_interest_number($b_time = null, $e_time = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	interest_id,
	COUNT(interest_id) num 
FROM
	t_user_gold
WHERE
	interest_id > 0
END;

		if($b_time !== null && $e_time !== null){
			$sql .= ' AND created_at >= ? AND created_at <= ?';
			$bind_array[] = $b_time;
			$bind_array[] = $e_time;
		}
		$sql .= ' GROUP BY interest_id ORDER BY num DESC LIMIT ?';
		$bind_array[] = INTEREST_GOLD_LIMIT;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	/**
	 * 获取兴趣赞助的牛币数
	 */
	public function get_interest_gold($b_date = null, $e_date){
		$bind_array = array($e_date);
		$sql = <<< END
SELECT
	SUM(spend_gold) gold,
	interest_id 
FROM
	t_user_gold
WHERE
	interest_id <> 0 AND interest_id IS NOT NULL AND created_at <= ?
END;

		if($b_date !== null){
			$sql .= ' AND created_at >= ?';
			$bind_array[] = $b_date;
		}
		$sql .= ' GROUP BY interest_id';
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	public function add_user_gold($data)
	{
		return $this->insert_data('t_user_gold', $data);
	}
}