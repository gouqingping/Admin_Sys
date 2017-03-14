<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Interest_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 兴趣数量
	 * $where 条件
	 */
	public function count_interest_where($where = null){
		$sql = <<< END
SELECT
	count(id) as _num
FROM 
	t_interest
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
	 * 统计兴趣数量
	 * $date 日期
	 * $format 格式
	 */
	public function count_interest_by_date($date, $format = '%Y-%m-%d'){
		$bind_array = array($format, $date.'%', $format);
		$sql = <<< END
SELECT
	DATE_FORMAT(created_at, ?) c_day,
	COUNT(created_at) d_num
FROM 
	t_interest
WHERE 
	created_at LIKE ?
GROUP BY 
	DATE_FORMAT(created_at, ?)
END;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}
	
	/**
	 * 获取热门兴趣
	 * $date 日期
	 */
	public function find_hot_interest_by_date($date){
	    $bind_array = array($date.'%');
		$sql = <<< END
SELECT
	i.id,
	i.name,
	p.p_sum,
	f.f_sum
FROM
	t_interest i
LEFT JOIN
	(SELECT interest_id,COUNT(interest_id) p_sum FROM t_post WHERE created_at LIKE ? 
		GROUP BY interest_id ORDER BY p_sum DESC LIMIT 10) p
ON
	i.id = p.interest_id
LEFT JOIN
	(SELECT interest_id,COUNT(interest_id) f_sum FROM t_favorite_interest GROUP BY interest_id) f
ON
	p.interest_id = f.interest_id
LIMIT 10
END;
		return $this->get_db_obj()->query($sql, $bind_array)->result_array();
	}

	/**
	 * 申请中的兴趣数量
	 * $where 搜索条件
	 */
	public function count_interest_apply($where = null){
		$sql = <<< END
SELECT
	count(id) as _num
FROM 
	t_interest_apply
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
	 *  获取申请中的兴趣
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_interest_apply($where = null, $order = null, $limit = null, $offset = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	i.id,
	i.name,
	2 is_active,
	0 f_num,
	i.icon,
	i.created_at,
	i.updated_at,
	i.apply_user_id,
	u.nickname apply_name,
	0 accept_user_id,
	0 accept_name,
	i.content
FROM
	t_interest_apply i
LEFT JOIN
	t_user u
ON
	i.apply_user_id = u.id
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
	 * 搜索兴趣
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_interest_search_where($where = null, $order = null, $limit = null, $offset = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	i.id,
	i.name,
	i.is_active,
	i.be_favorited_num f_num,
	i.icon,
	i.created_at,
	i.updated_at,
	u.id apply_user_id,
	u.nickname apply_name,
	au.id accept_user_id,
	au.nickname accept_name,
	i.content
FROM
	t_interest i
LEFT JOIN 
	t_user u
ON
	i.apply_user_id = u.id
LEFT JOIN
	t_user au
ON
	i.accept_user_id = au.id
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
	 * 添加审核通过的兴趣
	 * $data 兴趣对象
	 */
	public function add_interest($data){
		return $this->insert_data('t_interest', $data);
	}
	
	/**
	 * 删除审核未通过的兴趣
	 * $where 条件
	 */
	public function delete_interest_apply($where){
		return $this->delete('t_interest_apply', $where);
	}
	
	/**
	 * 更变兴趣状态
	 */
	public function update_interest($data, $id){
		$where = array('id' => $id);
		return $this->update_data('t_interest', $data, $where);
	}
}