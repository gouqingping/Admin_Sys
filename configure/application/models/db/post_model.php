<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Post_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 计算出热帖
	 * 帖子分数公式：score=P/((T+2)的G次方)
	 * P表示帖子的赞助牛币数量。
	 * T表示距离发帖的时间（单位为小时），加上2是为了防止最新的帖子导致分母过小。
	 * G表示”重力因子”，即将帖子排名往下拉的力量，默认值为1.8，根据需要调整这个值可以控制帖子上升、下降速度。
	 */
	public function find_hot_post(){
		$bind_array = array(get_now_time(),HOT_POST_DEN,HOT_POST_USER,HOT_POST_LIMIT);
		$sql = <<< END
SELECT
	id,
	gold/POWER(TIMESTAMPDIFF(HOUR, created_at, ?)+?,?) score
FROM
	t_post
WHERE
	gold > 0 AND interest_id > 0
ORDER BY score DESC
LIMIT ?
END;

	return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	 /**
	 * 获取发帖次数最多的兴趣
	 */
	function get_interest_number($b_time = null, $e_time = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	interest_id,
	COUNT(interest_id) num 
FROM
	t_post
WHERE
	interest_id > 0
END;

		if($b_time !== null && $e_time !== null){
			$sql .= ' AND created_at >= ? AND created_at <= ?';
			$bind_array[] = $b_time;
			$bind_array[] = $e_time;
		}
		$sql .= ' GROUP BY interest_id ORDER BY num DESC LIMIT ?';
		$bind_array[] = INTEREST_POST_LIMIT;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	/**
	 * 帖子数量
	 * $where 条件
	 */
	public function count_post_where($where = null){
		$sql = <<< END
SELECT
	count(id) as _num
FROM 
	t_post p
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
	 * 搜索帖子
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
 	public function find_post_search_where($where = null, $order = null, $limit = null, $offset = null){
 		$sql = <<< END
SELECT
	p.id,
	u.id user_id,
	u.nickname,
	p.created_at,
	p.updated_at,
	p.deleted_at,
	p.platform,
	p.is_active,
	p.gold,
	i.id interest_id,
	i.name interest_name,
	p.name post_name,
	p.content
FROM
	t_post p
LEFT JOIN
	t_interest i
ON
	p.interest_id = i.id
LEFT JOIN
	t_user u
ON
	p.user_id = u.id
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
	 * 统计帖子数量
	 * $date 日期
	 * $format 格式
	 */
	public function count_post_by_date($date, $format = '%Y-%m-%d'){
		$bind_array = array($format, $date.'%', $format);
		$sql = <<< END
SELECT
	DATE_FORMAT(created_at, ?) c_day,
	COUNT(created_at) d_num
FROM 
	t_post
WHERE 
	created_at LIKE ?
GROUP BY 
	DATE_FORMAT(created_at, ?)
END;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	/**
	 * 获取热门帖子
	 * $date 日期
	 */
	public function find_hot_post_by_date($date){
		$bind_array = array($date.'%');
		$sql = <<< END
SELECT
	p.id,
	p.name p_name,
	p.content,
	COUNT(c.id) c_num,
	i.name i_name,
	i.id i_id
FROM
	t_post p
LEFT JOIN
	t_comment c
ON
	p.id = c.post_id
LEFT JOIN
	t_interest i
ON
	p.interest_id = i.id
WHERE
	p.created_at LIKE ?
GROUP BY
	p.id
ORDER BY
	c_num
DESC
	LIMIT 10
END;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	public function update_post($data, $id){
		$where = array('id' => $id);
		return $this->update_data('t_post', $data, $where);
	}
}