<?php

class Account extends MY_Common
{
   var $sError;
   var $data; 
   function __construct()
   {
      // load controller parent
      parent::__construct();
      $this->sError = '';
   }
   function index()
   {
       if (parent::check_security(2, '')) {
           if ($this->session->userdata('ulevel') == '0') {
               redirect(base_url() . 'admin/doctor/edit/');
           } 
           else if ($this->session->userdata('ulevel') == '1') {
               redirect(base_url() . 'admin/doctor/edit/');
           }
           else if ($this->session->userdata('ulevel') == '2') {
               redirect(base_url() . 'admin/user/edit/');
           }
       }
   }
}
?>
