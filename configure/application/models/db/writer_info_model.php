<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Writer_info_model extends Db_model {

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 撰稿人数量
	 * $where 条件
	 */
	public function count_writer_info_where($where = null){
		$sql = <<< END
SELECT
	count(w.id) as _num
FROM 
	t_writer_info w
LEFT JOIN	
	t_user u
ON
	u.id = w.user_id
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
	 * 撰稿人查询
	 * $where 条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 **/
	public function find_writer_info_where($where = null, $order = null, $limit = null, $offset = null){
		$bind_array = array();
		$sql = <<< END
SELECT
	w.id,
	w.user_id,
	u.nickname,
	w.pay_account,
	w.qq,
	w.contact_address,
	w.step,
	w.pay_account_updated_at,
	w.name,
	w.is_active,
	w.identity_card,
	w.identity_card_img,
	w.created_at,
	w.updated_at,
	w.deleted_at
FROM 
	t_writer_info w
LEFT JOIN	
	t_user u
ON
	u.id = w.user_id
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
    is_active,
    pay_account,
    qq,
    contact_address,
    step,
    pay_account_updated_at,
    name,
    identity_card,
    identity_card_img,
    created_at,
    updated_at
FROM
    t_writer_info
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
	public function update_writer($data, $id) {
        $where = array('id' => $id);
        return $this->update_data('t_writer_info', $data, $where);
    }
}