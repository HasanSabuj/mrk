<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * login helper for checking user is loged in
 *
 *
 */

 function is_logged_in() {
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    if ($CI->session->has_userdata('userId')) { 
    	return true; 
    } else { 
    	return false; 
    }
}