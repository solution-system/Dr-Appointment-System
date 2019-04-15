<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Common extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function check_security($ulevel, $url) {
        if ($this->session->userdata('username') == "") {
            // $url = 'admin/login/' . $this->input->cookie('user_type') . $url;
            // print 'url: ' . $url;
            redirect(base_url()); // . $url);
        } else if ($this->session->userdata('ulevel') > $ulevel) 
        {
            redirect(base_url() . 'message/alert/prohibited/');
        }
        else
            return true;
    }    
}

?>