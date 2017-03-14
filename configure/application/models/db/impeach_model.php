<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Impeach_model extends Db_model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 投诉数量
	 * $where 条件
	 */
	public function count_impeach_where($where = null){
		$sql = <<< END
SELECT
	count(id) as _num
FROM 
	t_impeach i
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
	 * 搜索投诉
	 * $where 搜索条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_impeach_search_where($where = null, $order = null, $limit = null, $offset = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	i.id,
	u.id user_id,
	u.nickname,
	i.content_type,
	i.type,
	i.t_id,
	i.created_at,
	i.content,
	i.is_active
FROM
	t_impeach i
LEFT JOIN 
	t_user u
ON
	i.user_id = u.id
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
	 * 更变投诉
	 * $data更变内容
	 */
	public function update_impeach($data, $id){
		$where = array('id' => $id);
		return $this->update_data('t_impeach', $data, $where);
	}
}