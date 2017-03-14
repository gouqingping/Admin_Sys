<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'db_model.php';

class Ad_banner_model extends Db_model {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 获取banner数量
	 * $where 条件
	 */
	public function count_banner_where($where = null){
		$sql = <<< END
SELECT
	count(id) as _num
FROM 
	t_ad_banner b
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
	 * 获取banner信息
	 * $where 条件
	 * $order 排序
	 * $limit 分页页码
	 * $offset 分页偏移量
	 */
	public function find_banner_where($where = null, $order = null, $limit = null, $offset = null){
		$bind_array = array(TYPE_BANNER_HTML);
		$sql = <<< END
SELECT
	b.id,
	b.img,
	b.url,
	b.type,
	b.t_id,
	b.title,
	b.begin_at,
	b.end_at,
	b.is_active,
	b.created_at,
	b.updated_at,
	b.deleted_at,
	h.html
FROM
	t_ad_banner b
LEFT JOIN
	t_html h
ON
	b.t_id = h.id AND b.type = ? AND b.t_id != 0
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
	 * 添加banner
	 * $data banner信息
	 */
	public function add_banner($data){
		return $this->insert_data('t_ad_banner', $data);
	}
	
	/**
	 * 更变banner信息
	 * $id 编号id
	 * $data banner信息
	 */
	public function update_banner($id, $data){
		$where = array('id' => $id);
		return $this->update_data('t_ad_banner', $data, $where);
	}
}