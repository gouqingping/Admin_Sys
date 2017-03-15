<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class User_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 用户数量
	 * $where 条件
	 */
	public function count_user_where($where = null){
		$bind_array = array(TYPE_DARK_ROOM_USER);
		$sql = <<< END
SELECT
	count(u.id) as _num
FROM 
	t_user u
LEFT JOIN
	t_dark_room d
ON
	u.id = d.t_id AND 
	d.type = ? AND 
	d.is_active = 1
END;
		if($where !== null){
			foreach($where as $key => $val){
				if($val['opn'] != ' in '){
					$val['val'] = $this->get_db_obj()->escape($val['val']);
				}
				$sql .=  $val['logic'].$val['key'].$val['opn'].$val['val'];
			}
		}
		$rs = $this->get_db_obj()->query($sql, $bind_array)->row_array(); 
		return $rs['_num'];
	}
	
	/**
	 * 统计用户数量
	 * $date 日期
	 * $format 格式
	 */
	public function count_user_by_date($date, $format = '%Y-%m-%d'){
		$bind_array = array($format, $date.'%', $format);
		$sql = <<< END
SELECT
	DATE_FORMAT(created_at, ?) c_day,
	COUNT(created_at) d_num
FROM 
	t_user
WHERE 
	created_at LIKE ?
GROUP BY 
	DATE_FORMAT(created_at, ?)
END;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	/**
	 * 搜索用户
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 **/
	public function find_user_by_search($where = null, $order = null, $limit = null, $offset = null){
		$bind_array = array(TYPE_DARK_ROOM_USER);
		$sql = <<< END
SELECT
	u.id,
	u.username,
	u.password,
	u.email,
	u.platform,
	u.sex,
	u.is_active,
	u.type,
	u.gold,
	u.nickname,
	u.regist_ip,
	u.city,
	u.county,
	u.province,
	u.profile,
	u.weburl,
	u.icon,
	u.last_login_at,
	u.created_at,
	u.updated_at,
	u.deleted_at,
	d.id is_activate,
	COUNT(p.id) p_num
FROM 
	t_user u
LEFT JOIN
	t_post p
ON
 	u.id=p.user_id
LEFT JOIN
	t_dark_room d
ON
	u.id = d.t_id AND 
	d.type = ? AND 
	d.is_active = 1
END;
		if($where !== null){
			foreach($where as $key => $val){
				if($val['opn'] != ' in '){
					$val['val'] = $this->get_db_obj()->escape($val['val']);
				}
				$sql .=  $val['logic'].$val['key'].$val['opn'].$val['val'];
			}
		}
		$sql .= ' GROUP BY u.id';
		if($order !== null){
			$i = 1;
			$sql .= ' ORDER BY ';
			foreach($order as $k => $v){
				if($i == count($order)){
					$sql .= "$k $v";
				}else{
					$sql .= "$k $v,";
				}
				$i++;
			}
		}
		
		if($limit !== null){
			$sql .=  ' LIMIT ?';
			$bind_array[] = (int)$limit;
		}
		if($offset !== null){
			$sql .=  ' OFFSET ?';
			$bind_array[] = (int)$offset;
		}
		return $this->get_db_obj()->query($sql, $bind_array)->result_array(); 
	}

	/**
	 * 获取用户信息
	 * $user_id 用户id
	 */
	public function get_user_info($user_id){
		$bind_array = array(TYPE_DARK_ROOM_USER, $user_id);
		$sql = <<< END
SELECT
	u.id,
	u.username,
	u.password,
	u.email,
	u.platform,
	u.sex,
	u.is_active,
	u.type,
	u.gold,
	u.nickname,
	u.regist_ip,
	u.city,
	u.county,
	u.province,
	u.profile,
	u.weburl,
	u.icon,
	u.last_login_at,
	u.created_at,
	u.updated_at,
	u.deleted_at,
	d.id is_activate,
	COUNT(p.id) p_num
FROM 
	t_user u
LEFT JOIN
	t_post p
ON
 	u.id=p.user_id
LEFT JOIN
	t_dark_room d
ON
	u.id = d.t_id AND 
	d.type = ? AND 
	d.is_active = 1
WHERE
	u.id = ?
GROUP BY
 	u.id
END;
		return $this->get_db_obj()->query($sql, $bind_array)->row_array();
	}

	/**
	 * 获取用户信息
	 * $id 用户id
	 */
	function get_user_by_id($id, $is_active = null){
		$bind_array = array($id);
		
		$sql = <<< END
SELECT
	*
FROM
	t_user
WHERE
	id = ?
END;

		if ($is_active !== null) {
			$sql .= ' AND is_active = ?';
			$bind_array[] = $is_active;
		}

		return $this->get_db_obj()->query($sql, $bind_array)->row_array(); 
	}

	/**
	 * 登录
	 * $email 登录名
	 * $password 密码
	 */
	function get_user_by_email_and_pwd($email, $password){
		$bind_array = array($email, $password);
		
		$sql = <<< END
SELECT
	*
FROM
	t_user
WHERE
	type != 1 AND email = ? AND password = ?
END;
		return $this->get_db_obj()->query($sql, $bind_array)->row_array(); 
	}
	
	/**
	 * 获取牛币最多的用户
	 */
	public function find_user_order_gold($limit=1){
		$sql = <<< END
SELECT
	u.id,
	u.gold
FROM 
	t_user u
WHERE
	is_active = 1
ORDER BY
	gold desc 
LIMIT ?
END;
		$bind_array[] = (int)$limit;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array(); 
	}

	public function update_user($data, $user_id){
		$where = array('id' => $user_id);
		return $this->update_data('t_user', $data, $where);
	}
} 
