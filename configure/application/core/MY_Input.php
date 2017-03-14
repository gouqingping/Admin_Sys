<?php
if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class My_Input extends CI_Input
{

    private static $urls = null;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取URL地址参数数组
     *
     * @return array|null
     */
    public function urls(){
        if(is_array(self::$urls)) return self::$urls;
        $CI = &get_instance();
        $urls = $CI->uri->ruri_to_assoc();
        if(!is_array($urls)) $urls = array();
        self::$urls = $urls;
        return self::$urls;
    }


    /**
     * 判断请求类型是否为POST
     *
     * @return bool
     */
    public function is_post()
    {
        return strtolower($this->server('REQUEST_METHOD')) === 'post';
    }

    /**
     * 判断请求类型是否为GET
     *
     * @return bool
     */
    public function is_get()
    {
        return strtolower($this->server('REQUEST_METHOD')) === 'get';
    }

}