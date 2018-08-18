<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Statistics {
    public function log_activity() {
        // We need an instance of CI as we will be using some CI classes
        $CI =& get_instance();
 
        // Start off with the session stuff we know
        $data = array();
        $data['ip_add'] = $CI->input->ip_address();
        $data['user_agent'] = $CI->agent->agent_string();
        $data['user_id'] = $CI->session->userdata('userId');
 
        // Next up, we want to know what page we're on, use the router class
        $data['section'] = $CI->router->class;
        $data['action'] = $CI->router->method;
 
        // We don't need it, but we'll log the URI just in case
        $data['uri'] = uri_string();
 
        // And write it to the database
        $CI->db->insert('statistics', $data);
    }
}