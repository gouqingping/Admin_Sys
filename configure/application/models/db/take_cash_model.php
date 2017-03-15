<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Take_cash_model extends Db_model {

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 打款提现数量
	 * $where 条件
	 */
	public function count_take_cash_where($where = null){
		$sql = <<< END
SELECT
	count(tc.id) as _num
FROM 
	t_take_cash tc
LEFT JOIN	
	t_user u
ON
	u.id = tc.user_id
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
	 * 打款提现查询
	 * $where 条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 **/
	public function find_take_cash_where($where = null, $order = null, $limit = null, $offset = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	tc.id,
	tc.user_id,
	u.nickname,
	tc.gold,
	tc.rank,
	tc.status,
	tc.money,
	tc.is_active,
	tc.created_at,
	tc.updated_at,
	tc.deleted_at
FROM 
	t_take_cash tc
LEFT JOIN
	t_user u
ON
	 u.id = tc.user_id
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
	
	public function get_by_id($id, $is_active = null) {
        $bind_array = array($id);
        $sql = <<< END
SELECT
	id,
	user_id,
	gold,
	rank,
	status,
	money,
	created_at,
	updated_at,
	deleted_at,
	is_active
FROM
    t_take_cash
WHERE
    id = ?
END;
        if($is_active !== null) {
            $sql .= ' AND is_active = ?';
            $bind_array[] = $is_active;
        }
        return $this->get_db_obj()->query($sql, $bind_array)->row_array();
    }
	
	/*
	 * 修改
	 */
	public function update_take_cash($data, $id) {
        $where = array('id' => $id);
        return $this->update_data('t_take_cash', $data, $where);
    }
}