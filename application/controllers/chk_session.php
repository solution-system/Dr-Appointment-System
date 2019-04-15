<?php

class Chk_session extends CI_Controller 
{
    public function index()
    {
        $is_login = $this->session->userdata("uid");	
        if ($is_login<>"")
            print '1';
        else 
            print '0';
    }
}
?>
