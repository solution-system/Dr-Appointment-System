<?php
class Terms_and_Services extends MY_Frontend
{
    function __construct() //this could also be called function User(). the way I do it here is a PHP5 constructor
    {
       parent::__construct();
    }

    public function index()
	 {
      $data['title'] = 'Dr. Website - Terms & Services';
	   // $data['banners'] = parent::get_banner('ad_type,-1');
      $data['main_content'] = 'frontend/terms_and_services_view';
      $this->load->view('template/frontend/content', $data);
    }
}
?>