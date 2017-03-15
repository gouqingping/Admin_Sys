<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    var $CI;
    var $layout;
    var $javascript;
    var $css;
    var $meta;
	var $user;
    
    function Layout($layout = "layout")
    {
        $this->CI = & get_instance();
        $this->layout = $layout;
        $this->css = array();
        $this->meta = $this->CI->config->item('default_meta');
        $this->javascript = array();
		$this->user = array();
    }

    function setLayout($layout)
    {
        $this->layout = $layout;
    }
	
	function setUser($user){
		$this->user = $user;
    }
    
    /**
    *
    *
    * @param string $view
    * @param array $data
    * @param boolean $return
    * @return type
    */
    function view($view, $data = null, $return = false)
    {
        
        if (!is_array($data)) {
            $data = array();
        }
        

        // XSS
        $data = clean_view_parameters($data);
        
        $loadedData = array();
        $loadedData['content_for_layout'] = $this->CI->load->view($view,$data,true);
		
        if ($return) {
            return $loadedData['content_for_layout'];
        }
		//user
		if (!isset($loadedData["user"]) ) {
			$loadedData["user"] = array();
		}
        $loadedData['user'] = array_merge($loadedData["user"], $this->user);
		
        // CSS
        if (!isset($loadedData["css"]) ) {
            $loadedData["css"] = array();
        }
        $loadedData["css"] = array_merge($loadedData["css"], $this->css);
        
        // Javascript
        if (!isset($loadedData["javascript"]) ) {
            $loadedData["javascript"] = array();
        }
        $loadedData["javascript"] = array_merge($loadedData["javascript"], $this->javascript);
        
        // Metatag
        if (!isset($loadedData["meta"]) ) {
            $loadedData["meta"] = array();
        }
        $loadedData["meta"] = array_merge($loadedData["meta"], $this->meta);
        
        $this->CI->load->view($this->layout, $loadedData, false);
        
    }
    
    /**
    *
    * @param string $css
    */
    function css($css)
    {
        if (is_array($css)) {
            foreach ($css as $v) {
                $this->css[] = $v;
            }
        } else {
            $this->css[] = $css;
        }
    }

    /**
    *
    * @param string javascript_file
    */
    function javascript($javascript_file)
    {
        if (is_array($javascript_file)) {
                foreach ($javascript_file as $v) {
                    $this->javascript[] = $v;
                }
            } else {
                $this->javascript[] = $javascript_file;
            }
    }
    
    /**
    *
    * @param array meta tag 例：array('title' => 'title', 'description' => 'description', 'keyword' => 'keywords')
    */
    function meta($meta)
    {
        foreach ($meta as $k => $v) {
            $this->meta[$k] = $v;
        }
        
    }
}