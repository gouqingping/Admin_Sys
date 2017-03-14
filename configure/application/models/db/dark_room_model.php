<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Dark_room_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 获取所有需解封的封禁信息
	 */
	public function find_dark_room(){
		$bind_array = array(get_now_time('Y-m-d'));
		$sql = <<< END
SELECT
	*
FROM
	t_dark_room
WHERE
	dark_end_time <= ? AND is_active = 1 AND dark_day > 0
END;
	return $this->get_db_obj()->query($sql, $bind_array)->result_array(); 
	}
	
	/**
	 * 获取封禁信息
	 * $type 封禁类型 1用户2帖子3兴趣
	 * $t_id 封禁类型 id
	 */
	public function get_dark_room_by_type_by_t_id($type, $t_id, $is_active = null){
		$bind_array = array($type, $t_id, $is_active);
		$sql = <<< END
SELECT
    * 
FROM
    t_dark_room
WHERE
    type = ? AND t_id = ?
END;
		if($is_active !== null){
			$sql .= ' AND is_active = ?';
			$bind_array[] = $is_active;
		}
		return $this->get_db_obj()->query($sql, $bind_array)->row_array(); 
	}
	
	/**
	 * 获取封禁历史信息
	 * $type 封禁类型 1用户2帖子3兴趣
	 * $t_id 封禁类型 id
	 */
	public function find_dark_history_by_type_by_t_id($type, $t_id){
		$bind_array = array($type, $t_id);
		$sql = <<< END
SELECT
    d.user_id apply_user_id,
    d.dark_begin_time,
    d.dark_day,
    d.dark_explain,
    dr.user_id accept_user_id,
    dr.relieve_time,
    dr.relieve_explain
FROM
    t_dark_room d
LEFT JOIN
    t_dark_relieve dr
ON
    dr.dark_id = d.id
WHERE
    d.type = ? AND d.t_id = ?
ORDER BY d.deleted_at
END;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array(); 
	}
	
	/**
	 * 添加封禁信息
	 * $data 封禁信息
	 */
	public function add_dark_room($data){
		return $this->insert_data('t_dark_room', $data);
	}
	
	/**
	 * 更变封禁信息
	 * $id 封禁id
	 * $data 封禁信息
	 */
	public function update_dark_room($id, $data){
		$where = array('id' => $id);
		return $this->update_data('t_dark_room', $data, $where);
	}
}