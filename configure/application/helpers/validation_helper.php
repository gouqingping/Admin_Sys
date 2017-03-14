<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* XSS
*
* view htmlspecialchars
*
* @param array $data
* @return array
* @link http://stackoverflow.com/questions/10925720/codeigniter-xss-clean-dilemma/10926392#10926392
*/

if (!function_exists('clean_view_parameters'))
{
    function clean_view_parameters($data)
    {
        if (is_array($data)) {
            $clean_output = NULL;

            // Firstly - check if we want to clean out output - do that first before doing anything else
            if (isset($data['clean_output'])) {
                // Apply to all in the list
                // Except for jquery_validation - so copy that and reinsert
                $clean_output = $data['clean_output'];
                unset($data['clean_output']);
            }

            // Apply escape
            $data = array_map('clean_view_parameters', $data);
            // Restore clean output
            
            if (is_array($clean_output)) {
                // clean output
                foreach ($clean_output as $key => $value) {
                    $data[$key] = $value;
                }
            }
            
            return $data;
        } else if (empty($data)) {
            // if null or empty, don't modify
            return $data;
        } else {
            // escape html characters
            return htmlspecialchars($data, ENT_QUOTES, config_item('charset'));
        }
    }
}

if (!function_exists('html_encode'))
{
	function html_encode($str) {
		return htmlspecialchars($str, ENT_QUOTES, config_item('charset'));
	}
}