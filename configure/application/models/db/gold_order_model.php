<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Gold_order_model extends Db_model {

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 订单数量
	 * $where 条件
	 */
	public function count_gold_order_where($where = null){
		$sql = <<< END
SELECT
	count(go.id) as _num
FROM 
	t_gold_order go
LEFT JOIN	
	t_user u
ON
	u.id = go.user_id
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
	 * 订单查询
	 * $where 条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 **/
	public function find_gold_order_where($where = null, $order = null, $limit = null, $offset = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	go.id,
	go.user_id,
	u.nickname,
	go.order_num,
	go.trade_num,
	go.type,
	go.status,
	go.gold,
	go.money,
	go.is_active,
	go.created_at,
	go.updated_at,
	go.deleted_at
	
FROM 
	t_gold_order go
LEFT JOIN	
	t_user u
ON
	u.id = go.user_id
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

	/*
	 * 修改
	 */
	public function update_gold_order($data, $id) {
        $where = array('id' => $id);
        return $this->update_data('t_gold_order', $data, $where);
    }
}