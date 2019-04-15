<?php
class Logout extends MY_Common
{
    function __construct() //this could also be called function User(). the way I do it here is a PHP5 constructor
    {
       parent::__construct();
    }
    function index()
    {
      $username = $this->session->userdata('username');
		if ($username<>"")
		{
			$this->session->sess_destroy();
		}
      redirect(base_url());
      // redirect(base_url() . 'admin/login');
   }
}
?>