<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_sender extends CI_Controller {
	function __construct()
    {
        parent::__construct();

        $this->load->model('MEmail_queue');
    }
        
    public function send_message(){

    	ignore_user_abort(true);

    	$datas=$this->MEmail_queue->get_data();
    	if(count($datas)>0){

    		$config = array();
	        $config['useragent']= "CodeIgniter";
	        $config['mailpath']= "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail"
	        $config['protocol'] = "smtp";
	        $config['smtp_host'] = "mail.buynsmile.xyz";
	        $config['smtp_port'] = "25";//25
	        $config['smtp_user'] = 'info@buynsmile.xyz'; // change it to yours
	    	$config['smtp_pass'] = '{*pse,ebpKGN'; // change it to yours
	        $config['mailtype'] = 'html';
	        $config['charset']  = 'utf-8';
	        $config['newline']  = "\r\n";
	        $config['wordwrap'] = TRUE;

			$this->email->initialize($config);

			

    		foreach($datas as $data){
    			$this->email->clear();
    			$this->email->from('info@buynsmile.xyz', 'MinMax Tech Ltd');
    			$this->email->to($data->receipient);

				$this->email->subject($data->subject);
				
				$this->email->message($data->message);
				if($this->email->send()){
					$this->MEmail_queue->mark_as_send($data->id);
				}

				
    		}
    	}
    }    
}