<?php
class Home extends MY_Frontend {

    function __construct() { //this could also be called function User(). the way I do it here is a PHP5 constructor
        parent::__construct();
    }

    public function index() {
        if ($this->input->post('username') <> "")
        {
            redirect("/admin");
        }
        else
        {
            $data['title'] = 'Clinic Management System - Home';
            // $data['banners'] = parent::get_banner('ad_type,1');
            // $this->load->model('user_model');
            // $data['tot_st'] = $this->user_model->getNum_USStates();
            // print 'home page ';
            $data['main_content'] = 'frontend/home_view';
            $this->load->view('template/frontend/content', $data);
        }
    }
}?>