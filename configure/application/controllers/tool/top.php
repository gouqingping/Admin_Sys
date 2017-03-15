<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/base_controller.php');

class Top extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 生成地图json数据
     */
    public function generate_area_json() {
        $i = 0;
        $data = array();
        $bind = array();
        $this->load->library('area_service');
        //取得国家数据
        $country = $this->area_service->find_area_by_parent_id(0);
        $data = array(
            'id' => $country[0]['id'],
            'area_name' => $country[0]['area_name']
        );
        //省
        $provice = $this->area_service->find_area_by_parent_id($country[0]['id']);
        
        foreach($provice as $v) {
            $ciy = array();
            $p = array(
                'id' => $v['id'],
                'area_name' => $v['area_name']
            );
            //市
            $city = $this->area_service->find_area_by_parent_id($v['id']);
            foreach($city as $v1) {
                $cty = array();
                //区
                $county = $this->area_service->find_area_by_parent_id($v1['id']);
                foreach($county as $v2) {
                        $cty[] = array(
                        'id' => $v2['id'],
                        'area_name' => $v2['area_name']
                    );
                }
                if($cty) {
                    $ciy[] = array(
                        'id' => $v1['id'],
                        'area_name' => $v1['area_name'],
                        'childs' => $cty
                        
                    );
                } else {
                    $ciy[] = array(
                        'id' => $v1['id'],
                        'area_name' => $v1['area_name']
                    );
                }
            }
            
            $data['childs'][] = array(
                'id'=>$p['id'],
                'area_name'=>$p['area_name'],
                'childs'=> $ciy
            );
        }

        $data = json_encode($data, JSON_UNESCAPED_SLASHES);
        file_put_contents(APPPATH.'data/json/area/area.json', $data);
        echo '数据生成完成!';
        exit;
    }
    
}