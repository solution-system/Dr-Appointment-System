<?php
class Home extends MY_Common
{
    function index()
    {
      if (parent::check_security(2, '/admin/'))
      {
      	// print 'home - home';
         $data['main_content'] = 'admin/index';
         $this->load->view('template/admin/content', $data);
      }
    }
} ?>