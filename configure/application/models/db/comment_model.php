<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Comment_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 获取评论次数最多的兴趣
	 */
	function get_interest_number($b_time = null, $e_time = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	interest_id,
	COUNT(interest_id) num 
FROM
	t_comment
WHERE
	interest_id > 0
END;

		if($b_time !== null && $e_time !== null){
			$sql .= ' AND created_at >= ? AND created_at <= ?';
			$bind_array[] = $b_time;
			$bind_array[] = $e_time;
		}
		$sql .= ' GROUP BY interest_id ORDER BY num DESC LIMIT ?';
		$bind_array[] = INTEREST_COMMENT_LIMIT;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	/**
	 * 评论数量
	 * $where 条件
	 */
	public function count_comment_where($where = null){
		$sql = <<< END
SELECT
	count(id) as _num
FROM 
	t_comment c
END;
		if($where !== null){
			foreach($where as $key => $val){
				if($val['opn'] != ' in '){
					$val['val'] = $this->get_db_obj()->escape($val['val']);
				}
				$sql .=  $val['logic'].$val['key'].$val['opn'].$val['val'];
			}
		}
		$rs = $this->get_db_obj()->query($sql)->row_array(); 
		return $rs['_num'];
	}

	/**
	 * 搜索评论
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_comment_search_where($where = null, $order = null, $limit = null, $offset = null){
		$sql = <<< END
SELECT
	c.id,
	c.user_id,
	nickname,
	c.post_id,
	c.gold,
	c.comment,
	c.comment_id,
	c.platform,
	c.is_active,
	c.created_at,
	c.updated_at,
	c.deleted_at,
	c.to_user_id,
	c.is_read
FROM
	t_comment c
LEFT JOIN
	t_user u
ON
	c.user_id =  u.id
END;
		if($where !== null){
			foreach($where as $key => $val){
				if($val['opn'] != ' in '){
					$val['val'] = $this->get_db_obj()->escape($val['val']);
				}
				$sql .=  $val['logic'].$val['key'].$val['opn'].$val['val'];
			}
		}

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
	 * 统计评论数量
	 * $date 日期
	 * $format 格式
	 */
	function count_comment_by_date($date, $format = '%Y-%m-%d'){
		$bind_array = array($format, $date.'%', $format);
		$sql = <<< END
SELECT
	DATE_FORMAT(created_at, ?) c_day,
	COUNT(created_at) d_num
FROM 
	t_comment
WHERE 
	created_at LIKE ?
GROUP BY 
	DATE_FORMAT(created_at, ?)
END;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	public function update_comment($data, $id){
		$where = array('id' => $id);
		return $this->update_data('t_comment', $data, $where);
	}
} 