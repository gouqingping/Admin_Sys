<?php
if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );
/**
 * 
 * loader extension
 * @author yang.tianxiang
 *
 */

class MY_Loader extends CI_Loader {

    public static $db_master;
    public static $db_slave;
    public static $redis_instance;
    
    function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * load redis
     */
    function redis()
    {
        if (null == self::$redis_instance)
        {
            self::$redis_instance = $this->redis_new_instance();

            // Grab the super object
            $CI =& get_instance();
            // Initialize the db variable.  Needed to prevent
            // reference errors with some configurations
            $CI->redis = '';
            // Load the DB class
            $CI->redis = & self::$redis_instance;
        }

        return self::$redis_instance;
    }

    /**
     * 
     * redis instance
     */
    function redis_new_instance()
    {
        $CI =& get_instance();
        $redis = $CI->config->item('redis');

        $hostname = $redis['hostname'];
        $port = $redis['port'];

        $redis_instance = new Redis();

        if (!$redis_instance->connect($hostname, $port)) {
            //conncect redis
            $redis_instance = null;
            $error =& load_class('Exceptions', 'core');
            echo $error->show_error('Redis failed to connect');
            exit;
        }
        
        return $redis_instance;
    }
    
    /**
     * 
     * load db master
     * @param $active_record
     */
    function db_master($active_record = FALSE)
    {
        if (null == self::$db_master)
        {
            self::$db_master = $this->db_new_master($active_record);

            // Grab the super object
            $CI =& get_instance();
            // Initialize the db variable.  Needed to prevent
            // reference errors with some configurations
            $CI->db_master = '';
            // Load the DB class
            $CI->db_master = & self::$db_master;
        }

        return self::$db_master;
    }

    /**
     * 
     * db master instance
     * @param $active_record
     */
    function db_new_master($active_record = FALSE)
    {
        return $this->database('master', TRUE, $active_record);
    }
    
    /**
     * 
     * load db slave
     * @param $active_record
     */
    function db_slave($active_record=FALSE)
    {
        if (null == self::$db_slave)
        {
            self::$db_slave = $this->db_new_slave($active_record);

            // Grab the super object
            $CI =& get_instance();
            // Initialize the db variable.  Needed to prevent
            // reference errors with some configurations
            $CI->db_slave = '';
            // Load the DB class
            $CI->db_slave = & self::$db_slave;
        }

        return self::$db_slave;
    }

    /**
     * 
     * db slave instance
     * @param $active_record
     */
    function db_new_slave($active_record=FALSE)
    {
        $CI =& get_instance();
        $db_slave_name = "slave";   
        $db_slave_list = $CI->config->item('db_slave_list');
        if(!empty($db_slave_list) && is_array($db_slave_list)) {
            $db_slave_key = array_rand($db_slave_list);
            $db_slave_name = $db_slave_list[$db_slave_key];
            if(empty($db_slave_name)) {
                $db_slave_name = "slave";
            }
            log_message("debug", "DB Slave config： " . $db_slave_name . " array_list: " . implode(",", $db_slave_list));
        } else {
            log_message("debug", "DB Slave config error");
        }
        return $this->database($db_slave_name, TRUE, $active_record);
    }
}
